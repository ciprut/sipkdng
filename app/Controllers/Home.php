<?php namespace App\Controllers;

//use App\Models\Model_Login;
use App\Models\Model_Utama;

class Home extends BaseController
{
	public function __construct(){
		//$this->model=new Model_Login;
		$this->session = session();
		$this->utama=new Model_Utama;
	}
	public function index()
	{
		$data["title"] = "Main - Dashboard";
		return view('login',$data);
	}

	public function verify(){
		session()->set('tahun',$this->request->getPost('tahun'));
		session()->set('modul',$this->request->getPost('modul'));
		$this->utama->getPemda('cur_skpkd');

		return redirect()->to(site_url('/login/verify'));
}
	public function login(){
		return view('login');
	}

	public function dashboard(){
		$data["title"] = "Main - Dashboard";
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		return view('templates/dashboard',$data);
	}
}
