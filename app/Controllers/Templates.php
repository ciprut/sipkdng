<?php namespace App\Controllers;

use App\Models\Model_Bp;
use App\Models\Model_Utama;
//use App\Models\Model_Login;

class Tools extends BaseController
{
	public function __construct(){
		$this->utama = new Tools_Utama;
		$this->model = new Tools_Model;
		//$this->sidebar = new Model_Login;
		$this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	public function konversi(){
		$data["title"] = "SK Uang Persediaan";
    session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    return view('bp/skup',$data);
	}



}
