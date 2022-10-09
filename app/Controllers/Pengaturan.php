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
  public function formPegawai(){
    session()->set('nip','');
    if($this->request->getPost('nip') != ''){
			session()->set('nip',$this->request->getPost('nip'));
		}
    $data["pegawai"] = $this->data->getPegawai(session()->nip);
    $data["golongan"] = $this->data->listGolongan();
		return view('pengaturan/formPegawai',$data);
	}
  public function simpanPegawai(){
    if($this->request->getPost('id') == ''){
      $data = array(
        "KDGOL"=>$this->request->getPost('txtGol'),
        "NIP"=>$this->request->getPost('txtNIP'),
        "NAMA"=>$this->request->getPost('txtNama'),
        "ALAMAT"=>$this->request->getPost('txtAlamat'),
        "UNITKEY"=>session()->kdUnit,
        "JABATAN"=>$this->request->getPost('txtJabatan')
      );
      $this->data->simpanPegawai($data);
    }else{
      $data = array(
        "KDGOL"=>$this->request->getPost('txtGol'),
        "NAMA"=>$this->request->getPost('txtNama'),
        "ALAMAT"=>$this->request->getPost('txtAlamat'),
        "JABATAN"=>$this->request->getPost('txtJabatan')
      );
      $this->data->simpanPegawai($data);
    }
		return redirect()->to(site_url('/pengaturan/listPegawai'));
	}
  public function hapusPegawai(){
    $nip = $this->request->getPost('nip');
    $this->data->hapusPegawai($nip);
		return redirect()->to(site_url('/pengaturan/listPegawai'));
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
