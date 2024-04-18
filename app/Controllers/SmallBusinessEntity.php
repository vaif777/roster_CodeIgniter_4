<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RosterModel;
use App\Models\SmallBusinessEntityModel;
use CodeIgniter\HTTP\ResponseInterface;

class SmallBusinessEntity extends BaseController
{
    private $rosterModel;
    private $smallBusinessEntityModel;
 
    public function __construct()
    {

        $this->smallBusinessEntityModel = new SmallBusinessEntityModel();
        $this->rosterModel = new RosterModel();
    }
    public function index()
    {
        $smallBusinessEnties = $this->smallBusinessEntityModel->findAll();

        return view('smallBusinessEntity/index', [
            'smallBusinessEnties' => $smallBusinessEnties,
            'item' => 1
        ]);
    }

    public function new()
    {
        helper('form');
     
        return view('smallBusinessEntity/create');
    }

    public function create()
    {
        $data = array_map('trim', $this->request->getPost());

        if (!$this->smallBusinessEntityModel->insert($data)) {
            session()->setFlashdata('fail', 'Ошибка!');
            return redirect()->route('small.business.entity.new')->withInput()->with('errors', $this->smallBusinessEntityModel->errors());
        }
        
        return redirect()->route('small.business.entity')->with('success', 'Запись добавлена');
    }

    public function edit($id)
    {
        helper('form');
        $smallBusinessEntity = $this->smallBusinessEntityModel->find($id);
        
        return view('smallBusinessEntity/edit', [
            'smallBusinessEntity' => $smallBusinessEntity
        ]);
    }

    public function update($id)
    {
        
        $data = array_map('trim', $this->request->getPost());
        
        if (!$this->smallBusinessEntityModel->update($id, $data)) {
            session()->setFlashdata('fail', 'Ошибка!');
            return redirect()->route('small.business.entity.new')->withInput()->with('errors', $this->smallBusinessEntityModel->errors());
        }
        
        return redirect()->route('small.business.entity')->with('success', 'Запись добавлена');
    }

    public function delete($id)
    {

        if ($this->rosterModel->select('id')->where('small_business_entity_id', $id)->find()) {

            session()->setFlashdata('fail', 'Ошибка: Oрганизация задействована в плановых проверках');
            return redirect()->route('small.business.entity');
        }

        $this->smallBusinessEntityModel->delete($id);
        return redirect()->route('small.business.entity')->with('success', 'Запись удалена');
    }
}
