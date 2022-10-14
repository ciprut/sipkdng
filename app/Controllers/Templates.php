<?php namespace App\Controllers;

use App\Models\Tools_Model;
//use App\Models\Model_Login;

class Tools extends BaseController
{
	public function __construct(){
		$this->model = new Tools_Model;
		//$this->sidebar = new Model_Login;
		$this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	public function konversi(){
		$data["title"] = "Tools - Konversi Data SIPD";
		$data["sidebar"] = $this->sidebar->menu();
		$data['opd'] = $this->sidebar->listSatkerUser();
		return view('tools/konversi',$data);
	}
	public function formPegawai(){
    session()->set('nip','');
    if($this->request->getPost('nip') != ''){
			session()->set('nip',$this->request->getPost('nip'));
		}
    $data["pegawai"] = $this->data->getPegawai(session()->nip);
    $data["golongan"] = $this->data->listGolongan();
		return view('pengaturan/formPegawai',$data);
	}


}
