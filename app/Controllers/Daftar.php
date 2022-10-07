<?php namespace App\Controllers;

use App\Libraries\Client;
use App\Models\Model_Daftar;
use App\Models\Model_Login;

class Daftar extends BaseController
{
	public function __construct(){
		$this->client = new Client;
		$this->sidebar = new Model_Login;
		$this->daftar = new Model_Daftar;

    $this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	public function fungsi(){
		$data["header"] = "Fungsi";
		$data["title"] = "Daftar - Fungsi";
//		$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");
		return view('daftar/fungsi',$data);
	}
  public function listFungsi(){
    $data["fungsi"] = $this->daftar->listFungsi();
		return view('daftar/listFungsi',$data);
	}


}
