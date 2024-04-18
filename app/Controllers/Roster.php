<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RosterModel;
use App\Models\SmallBusinessEntityModel;
use App\Models\SupervisoryAuthorityModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Roster extends BaseController
{
    private $rosterModel;
    private $supervisoryAuthorityModel;
    private $smallBusinessEntityModel;
 
    public function __construct()
    {
        $this->rosterModel = new RosterModel();
        $this->supervisoryAuthorityModel = new SupervisoryAuthorityModel();
        $this->smallBusinessEntityModel = new SmallBusinessEntityModel();
    }

    public function index()
    {
        $rosters = $this->rosterModel
        ->select('rosters.id, small_business_entities.title AS SBE_title, rosters.planned_verification_period_from, rosters.planned_verification_period_before, rosters.planned_duration_check, supervisory_authorities.title AS SA_title')
        ->join('supervisory_authorities', 'rosters.supervisory_authority_id = supervisory_authorities.id', 'left')
        ->join('small_business_entities', 'rosters.small_business_entity_id = small_business_entities.id', 'left')
        ->find();
        $supervisoryAuthorities = $this->supervisoryAuthorityModel->findAll();
        $smallBusinessEnties = $this->smallBusinessEntityModel->findAll();

        return view('roster/index', [
            'rosters' => $rosters,
            'item' => 1,
            'supervisoryAuthorities' => $supervisoryAuthorities,
            'smallBusinessEnties' => $smallBusinessEnties,
        ]);
    }

    public function new()
    {
        helper('form');
        $supervisoryAuthorities = $this->supervisoryAuthorityModel->findAll();
        $smallBusinessEnties = $this->smallBusinessEntityModel->findAll();
        return view('roster/create', [

            'supervisoryAuthorities' => $supervisoryAuthorities,
            'smallBusinessEnties' => $smallBusinessEnties,
        ]);
    }

    public function create()
    {
        $data = array_map('trim', $this->request->getPost());

        $plannedVerificationPeriodFrom = strtotime($data['planned_verification_period_from']);
        $plannedVerificationPeriodBefore = strtotime($data['planned_verification_period_before']);
        $data['planned_verification_period_from'] = !empty($data['planned_verification_period_from']) ? date('Y-m-d H:i:s', $plannedVerificationPeriodFrom) : ''; 
        $data['planned_verification_period_before'] = !empty($data['planned_verification_period_before']) ? date('Y-m-d H:i:s', $plannedVerificationPeriodBefore) : '';

        if ($data['planned_verification_period_before'] <= $data['planned_verification_period_from']) {
            
            session()->setFlashdata('fail', 'Ошибка!');
            return redirect()->route('roster.new')->withInput()->with('errors', ['planned_verification_period_before' => 'Поле период проверки по не может быть больше или равен полю период проверки с']);
        }

        if (!$this->rosterModel->insert($data)) {
            session()->setFlashdata('fail', 'Ошибка!');
            return redirect()->route('roster.new')->withInput()->with('errors', $this->rosterModel->errors());
        }
        
        return redirect()->route('roster')->with('success', 'Запись добавлена');
    }

    public function edit($id)
    {
        helper('form');
        $roster = $this->rosterModel->find($id);
        $supervisoryAuthorities = $this->supervisoryAuthorityModel->findAll();
        $smallBusinessEnties = $this->smallBusinessEntityModel->findAll();
        
        return view('roster/edit', [
            'roster' => $roster,
            'supervisoryAuthorities' => $supervisoryAuthorities,
            'smallBusinessEnties' => $smallBusinessEnties,
        ]);
    }

    public function update($id)
    {

        $data = array_map('trim', $this->request->getPost());

        $plannedVerificationPeriodFrom = strtotime($data['planned_verification_period_from']);
        $plannedVerificationPeriodBefore = strtotime($data['planned_verification_period_before']);
        $data['planned_verification_period_from'] = !empty($data['planned_verification_period_from']) ? date('Y-m-d H:i:s', $plannedVerificationPeriodFrom) : ''; 
        $data['planned_verification_period_before'] = !empty($data['planned_verification_period_before']) ? date('Y-m-d H:i:s', $plannedVerificationPeriodBefore)  : '';

        $roster = $this->rosterModel->select('small_business_entity_id, planned_verification_period_from, planned_verification_period_before, planned_duration_check, supervisory_authority_id')->where('id', $id)->first();
        
        if ($roster == $data) {

            session()->setFlashdata('fail', 'Ошибка: Вы не внисли изменениня в записи');
            return redirect()->route('roster.edit', [$id]);
        }

        if (!$this->rosterModel->update($id, $data)) {
            session()->setFlashdata('fail', 'Ошибка!');
            return redirect()->route('roster.edit', [$id])->withInput()->with('errors', $this->rosterModel->errors());
        }
        
        return redirect()->route('roster')->with('success', 'Запись добавлена');
    }

    public function delete($id)
    {
        
        $this->rosterModel->delete($id);
        
        return redirect()->route('roster')->with('success', 'Запись удалена');
    }

    public function newExcel()
    {

        return view('roster/createExcel');
    }

    public function createExcel()
    {
        
        if (!$this->request->getFile('excel_file')->isValid()) {

            session()->setFlashdata('fail', 'Ошибка: Возникли проблемы при загрузке файла');
            return redirect()->route('roster.new.excel');
        }

        $file = $this->request->getFile('excel_file');

        if ($file->getExtension() !== 'xlsx') {

            session()->setFlashdata('fail', 'Ошибка: Неправильный тип файла расширение файла должно быть "xlsx"');
            return redirect()->route('roster.new.excel');
        }

        // Создать объект для чтения Excel файла и открыть файл
        $reader = new Xlsx();
        $spreadsheet = $reader->load($file->getTempName());

        // Получить данные из первого листа
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $fails = [];
         
        // Создаем массив соотношения столбцов в базе и файле excel
        $headers = [
            
            'A' => 'small_business_entity_id',
            'B'=> 'supervisory_authority_id',
            'C' => 'planned_verification_period_from',
            'D' => 'planned_verification_period_before',
            'E' => 'planned_duration_check',
        ];

        // Получить данные без заголовков
        $dataWithoutHeaders = $sheet->rangeToArray('A2:'.$highestColumn.$highestRow, null, true, true, true);

        // Удалить пустые строки из данных
        $filteredData = array_filter($dataWithoutHeaders, function($row) {
            return !empty(array_filter($row));
        });

        // Создать ассоциативный массив
        $associativeData = [];
        foreach ($filteredData as $cell => $row) {
            $associativeRow = [];
            foreach ($row as $index => $value) {
                
                // Проверки на корректность заполнения данных
                if (empty($value) && ($index == 'A' || $index == 'B' || $index == 'C' || $index == 'D' || $index == 'E')) {

                    array_key_exists('Ошибка: Незаполненная ячейка', $fails) ? $fails['Ошибка: Незаполненная ячейка'] .= ", $index$cell" : $fails['Ошибка: Незаполненная ячейка'] = " $index$cell";
                } elseif ($index == 'A') {
                    
                    $value = trim($value);
                    $value = $this->smallBusinessEntityModel->select('id')->where('title', $value)->first();
                    $value = $value['id'] ?? '';
                    
                    if (empty($value)) {

                        array_key_exists('Ошибка: "СМП" не найден в базе данных, ячейка', $fails) ? $fails['Ошибка: "СМП" не найден в базе данных, ячейка'] .=  ", $index$cell" : $fails['Ошибка: "СМП" не найден в базе данных, ячейка'] =  " $index$cell";
                    } 
                } elseif ($index == 'B') {

                    $value = trim($value);
                    $value = $this->supervisoryAuthorityModel->select('id')->where('title', $value)->first();
                    $value = $value['id'] ?? '';
                    
                    if (empty($value)) {

                        array_key_exists('Ошибка: "Контролирующий орган" не найден в базе данных, ячейка', $fails) ? $fails['Ошибка: "Контролирующий орган" не найден в базе данных, ячейка'] .=  ", $index$cell" : $fails['Ошибка: "Контролирующий орган" не найден в базе данных, ячейка'] =  " $index$cell";
                    }
                } elseif ($index == 'C') {
                    
                    $value = trim($value);
                    $timestamp = strtotime($value);
                    $value = $timestamp ? date('Y-m-d H:i:s', $timestamp) : ''; 

                    if (empty($value)) {

                        array_key_exists('Ошибка: Некорректно записана дата ячейка', $fails) ? $fails['Ошибка: Некорректно записана дата ячейка'] .= ", $index$cell" : $fails['Ошибка: Некорректно записана дата ячейка'] = " $index$cell";
                    }
                } elseif ($index == 'D') {
                    
                    $value = trim($value);
                    $timestamp = strtotime($value);
                    $value = $timestamp ? date('Y-m-d H:i:s', $timestamp) : ''; 

                    if (empty($value)) {
                        
                        array_key_exists('Ошибка: Некорректно записана дата ячейка', $fails) ? $fails['Ошибка: Некорректно записана дата ячейка'] .= ", $index$cell" : $fails['Ошибка: Некорректно записана дата ячейка'] = " $index$cell" ;
                    } elseif ( $value <= $associativeRow['planned_verification_period_from']) {
            
                        array_key_exists('Ошибка: Поле "Период проверки по" не может быть больше или равен полю "Период проверки с" ячейка', $fails) ? $fails['Ошибка: Поле "Период проверки по" не может быть больше или равен полю "Период проверки с" ячейка'] .= ", $index$cell" : $fails['Ошибка: Поле "Период проверки по" не может быть больше или равен полю "Период проверки с" ячейка'] = " $index$cell" ;
                    }
                } elseif ($index == 'E') {

                    $value = trim($value);
                    if (!is_numeric($value)) {

                        array_key_exists('Ошибка: Столбец должен содержать только числовые значения ячейка', $fails) ? $fails['Ошибка: Столбец должен содержать только числовые значения ячейка'] .= ", $index$cell" : $fails['Ошибка: Столбец должен содержать только числовые значения ячейка'] = " $index$cell";
                    }
                }

                if (array_key_exists($index, $headers)) {

                    $associativeRow[$headers[$index]] = $value;
                } else {
                    
                    if (!empty($value)) {
                        
                        array_key_exists('Ошибка: Столбец не нужно заполнять, ячейка', $fails) ? $fails['Ошибка: Столбец не нужно заполнять, ячейка'] .= ", $index$cell" : $fails['Ошибка: Столбец не нужно заполнять, ячейка'] = " $index$cell" ;
                    }
                }
            }
            $associativeData[] = $associativeRow;
        }

        if (count($fails)) {

            session()->setFlashdata('fails', array_unique($fails));
            return redirect()->route('roster.new.excel');
        }
        
        //dd($associativeData);
        if (!$this->rosterModel->insertBatch($associativeData)) {
            session()->setFlashdata('fails', $this->rosterModel->errors());
            return redirect()->route('roster.new.excel');
        }

        return redirect()->route('roster')->with('success', 'Запись добавлена');
    }
}
