<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RosterModel;
use App\Models\SupervisoryAuthorityModel;
use CodeIgniter\HTTP\ResponseInterface;

class SupervisoryAuthority extends BaseController
{
    private $rosterModel;
    private $supervisoryAuthorityModel;
 
    public function __construct()
    {

        $this->supervisoryAuthorityModel = new SupervisoryAuthorityModel();
        $this->rosterModel = new RosterModel();
    }
    public function index()
    {
        $supervisoryAuthorities = $this->supervisoryAuthorityModel->findAll();

        return view('supervisoryAuthority/index', [
            'supervisoryAuthorities' => $supervisoryAuthorities,
            'item' => 1
        ]);
    }

    public function new()
    {
        helper('form');
     
        return view('supervisoryAuthority/create');
    }

    public function create()
    {
        $data = array_map('trim', $this->request->getPost());
        
        if (!$this->supervisoryAuthorityModel->insert($data)) {
            session()->setFlashdata('fail', 'Ошибка!');
            return redirect()->route('supervisory.authority.new')->withInput()->with('errors', $this->supervisoryAuthorityModel->errors());
        }
        
        return redirect()->route('supervisory.authority')->with('success', 'Запись добавлена');
    }

    public function edit($id)
    {
        helper('form');
        $supervisoryAuthorities = $this->supervisoryAuthorityModel->find($id);
        
        return view('supervisoryAuthority/edit', [
            'supervisoryAuthorities' => $supervisoryAuthorities
        ]);
    }

    public function update($id)
    {
        $data = array_map('trim', $this->request->getPost());
        
        if (!$this->supervisoryAuthorityModel->update($id, $data)) {
            session()->setFlashdata('fail', 'Ошибка!');
            return redirect()->route('supervisory.authority.new')->withInput()->with('errors', $this->supervisoryAuthorityModel->errors());
        }
        
        return redirect()->route('supervisory.authority')->with('success', 'Запись добавлена');
    }

    public function delete($id)
    {

        if ($this->rosterModel->select('id')->where('supervisory_authority_id', $id)->find()) {

            session()->setFlashdata('fail', 'Ошибка: Oрганизация задействована в плановых проверках');
            return redirect()->route('supervisory.authority');
        }

        $this->supervisoryAuthorityModel->delete($id);
        return redirect()->route('supervisory.authority')->with('success', 'Запись удалена');
    }
}
