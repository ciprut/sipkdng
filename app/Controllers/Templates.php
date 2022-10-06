<?php namespace App\Controllers;

use App\Libraries\Client;
use App\Models\Tools_Model;
use App\Models\Model_Login;

class Tools extends BaseController
{
	public function __construct(){
		$this->client = new Client;
		$this->model = new Tools_Model;
		$this->sidebar = new Model_Login;
		$this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	///-- komponen --
	public function konversi(){
		$data["title"] = "Tools - Konversi Data SIPD";
		$data["sidebar"] = $this->sidebar->menu();
		$data['opd'] = $this->sidebar->listSatkerUser();
		return view('tools/konversi',$data);
	}


}
