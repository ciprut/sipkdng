<?php
namespace App\Controllers;

use App\Models\Model_Login;

class login extends BaseController{

    public function __construct(){
        $this->session=session();
        $this->model = new Model_Login();
    }

    public function index(){
        return view('login');
    }

    public function verify(){
			$data = array(
            'username'  => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'tahun' => $this->request->getPost('tahun'),
            'modul' => $this->request->getPost('modul'),
      );
			session()->set('tahun',$this->request->getPost('tahun'));
			session()->set('modul',$this->request->getPost('modul'));

			if(empty($data["username"])){
	    	session()->setFlashdata('message', 'Masukkan Username');
	    	return redirect()->to(site_url('/login'));
	    }else
			if(empty($data["password"])){
	    	session()->setFlashdata('message', 'Masukkan Password');
	    	return redirect()->to(site_url('/login'));
	    }
      $login = $this->model->login($data);
			if(empty($login)){
	    	session()->setFlashdata('message', 'Username atau Password Salah');
	    	return redirect()->to(site_url('/login'));
	    }else{
				session()->set('operator_name',$login->nama);
				session()->set('operator_id',$login->id);
				session()->set('level',$login->level);
				session()->set('operator_id_opd',$login->opd);
				session()->set('operator_opd',$login->kode_skpd);
				session()->set('operator_sub_unit',$login->nama_skpd);
				session()->set('operator_skpd',$login->skpd);
				
				return redirect()->to(site_url('/home/dashboard'));
				
			}
    }
}