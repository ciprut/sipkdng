<?php namespace App\Controllers;

use App\Libraries\Client;
use App\Models\Model_Pengaturan;
use App\Models\Model_Login;

class Pengaturan extends BaseController
{
	public function __construct(){
		$this->client = new Client;
		$this->sidebar = new Model_Login;
		$this->data = new Model_Pengaturan;

    $this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	public function pegawai(){
		$data["title"] = "Pengaturan - Pegawai";
//		$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    $data["satker"] = $this->data->listBidang();
    return view('pengaturan/pegawai',$data);
	}
  public function listUnit(){
    if($this->request->getPost('bidang') != ''){
			session()->set('kdBidang',$this->request->getPost('bidang'));
		}
    $data["unit"] = $this->data->listUnit();
		return view('pengaturan/listUnit',$data);
	}
  public function listPegawai(){
    if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
    $data["pegawai"] = $this->data->listPegawai();
		return view('pengaturan/listPegawai',$data);
	}

  public function bendahara(){
		$data["title"] = "Pengaturan - Bendahara";
//		$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    $data["satker"] = $this->data->listBidang();
    return view('pengaturan/bendahara',$data);
	}
  public function listBendahara(){
    if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
    $data["bendahara"] = $this->data->listBendahara();
		return view('pengaturan/listBendahara',$data);
	}

}
