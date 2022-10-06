<?php namespace App\Controllers;

use App\Libraries\Client;
use App\Models\Model_Login;

class Home extends BaseController
{
	public function __construct(){
		$this->model=new Model_Login;
	}
	public function index()
	{
		$session = session();
		if($session->get('cookie') && $session->get('token')){
			return view('login');
		}else{
			return view('login');
//			return redirect()->to(site_url('login'));
		}
	}

	public function login(){
		return view('login');
	}

	public function dashboard(){
		$session=session();
		$data["title"] = "Main - Dashboard";
		$data["sidebar"] = $this->model->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		return view('templates/dashboard',$data);
	}
	public function dataMetode(){
		if(!is_null($this->request->getPost('metode'))){
			session()->set('rup_metode',$this->request->getPost('metode'));
		}
		$data['paket'] = $this->model->rupListPaket();
		return view('templates/rupListPaket',$data);
	}
	public function fa_test(){
		$session=session();
		$data["title"] = "Main - Dashboard";
		$data["sidebar"] = $this->model->menu();
		$data['opd'] = $this->model->listSatkerUser();
		return view('home/fa_test',$data);
	}
	public function glyp_test(){
		$session=session();
		$data["title"] = "Main - Dashboard";
		$data["sidebar"] = $this->model->menu();
		$data['opd'] = $this->model->listSatkerUser();
		return view('home/glyp_test',$data);
	}
	public function formSetting(){
		$data["user"] = $this->model->getUser();
		return view('admin-menu/setting_form',$data);
	}

	public function gantiOPD($idx){
    $a = explode("__",$idx);

    $id = $a[0];
		$this->model->gantiOPD($id);
		$tujuan = str_replace("XXX","/",$a[1]);
		return redirect()->to(site_url($tujuan));
	}
}
