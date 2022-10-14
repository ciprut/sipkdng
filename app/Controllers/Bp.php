<?php namespace App\Controllers;

use App\Models\Model_Bp;
use App\Models\Model_Utama;
//use App\Models\Model_Login;

class Bp extends BaseController
{
	public function __construct(){
		$this->model = new Model_Bp;
		$this->utama = new Model_Utama;
		//$this->sidebar = new Model_Login;
		$this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	public function skup(){
		$data["title"] = "SK Uang Persediaan";
    session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    return view('bp/skup',$data);
	}
	public function listSKUP(){
    if(!is_null($this->request->getPost('hapus'))){
			$this->model->hapusSKUP($this->request->getPost('hapus'));
		}
    if(!is_null($this->request->getPost('form'))){
      session()->set('edit',$this->request->getPost('form'));
      $data = array(
        "NILAI"=>$this->request->getPost('txtNilai')
      );
      $this->model->simpanNSUP($data);
		}
		$data['up'] = $this->model->listSKUP();
		return view('bp/listSKUP',$data);
	}
  public function formSKUP(){
    session()->set('unit','');
    if($this->request->getPost('unit') != ''){
			session()->set('unit',$this->request->getPost('unit'));
		}
    $data['up'] = $this->model->getSKUP();
		return view('bp/formSKUP',$data);
	}

  public function spp(){
		$data["title"] = "SK Uang Persediaan";
    session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    $data["satker"] = $this->utama->listBidang();
    return view('bp/spp',$data);
	}
	public function listBendahara(){
    if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
		$params = array(
			"up"=>array("Idxkode"=>"6","jnsSpp"=>"up","kdStatus"=>"21","webset"=>"uraisppup","jnsBend"=>"02","control"=>"frmtspp"),
			"gu"=>array("Idxkode"=>"6","jnsSpp"=>"gu","kdStatus"=>"22","webset"=>"uraisppgu","jnsBend"=>"02"),
			"tu"=>array("Idxkode"=>"6","jnsSpp"=>"tu","kdStatus"=>"23","webset"=>"uraispptu","jnsBend"=>"02"),
			"gu"=>array("Idxkode"=>"2","jnsSpp"=>"gu","kdStatus"=>"25","webset"=>"sppnonspj","jnsBend"=>"02")
		);
    $data["bendahara"] = $this->utama->listBendahara($this->request->getPost('jns'));
		return view('bp/listBendahara',$data);
	}
}
