<?php namespace App\Controllers;

use App\Libraries\Client;
use App\Models\Model_Data;
use App\Models\Model_Login;

class Data extends BaseController
{
	public function __construct(){
		$this->client = new Client;
		$this->sidebar = new Model_Login;
		$this->data = new Model_Data;

    $this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	public function tahap(){
		$data["title"] = "Data - Tahap";
//		$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");
		return view('data/tahap',$data);
	}
  public function listTahap(){
    $data["tahap"] = $this->data->listTahap();
		return view('data/listTahap',$data);
	}

	public function bulan(){
		$data["title"] = "Data - Bulan";
//		$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");
		return view('data/bulan',$data);
	}
  public function listBulan(){
    $data["bulan"] = $this->data->listBulan();
		return view('data/listBulan',$data);
	}

}
