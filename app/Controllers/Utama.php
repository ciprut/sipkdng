<?php namespace App\Controllers;

use App\Models\Model_Utama;

class Utama extends BaseController
{
	public function __construct(){
		$this->utama = new Model_Utama;
		$this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

  public function listUnit(){
    if($this->request->getPost('bidang') != ''){
			session()->set('kdBidang',$this->request->getPost('bidang'));
		}
    $data["unit"] = $this->utama->listUnit();
		return view('utama/listUnit',$data);
	}
  public function listPegawai($tabel){
    $data["pegawai"] = $this->utama->listPegawai($tabel);
		return view('utama/listPegawai',$data);
	}
	public function listTTD($kddok){
    $data["pegawai"] = $this->utama->listTTD($kddok);
		return view('utama/listPegawai',$data);
	}
	public function rekList(){
		$data["rek"] = $this->utama->listRekBUD();
		return view('utama/rekList',$data);
	}
	public function buktiList(){
		$data["rek"] = $this->utama->buktiList();
		return view('utama/buktiList',$data);
	}
	
	public function bendList($jb=null){
		if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
    $data["bend"] = $this->utama->bendList();
		return view('utama/bendList',$data);
	}
	public function listBKUBP($jb){
    $data["lBKU"] = $this->utama->listBKUBP($jb);
		return view('utama/listBKUBP',$data);
	}
	public function satkerList(){
		$data["bidang"] = $this->utama->listBidang();
		return view('utama/satkerList',$data);
	}
	public function satkerListBend(){
		$data["bidang"] = $this->utama->listBidang();
		return view('utama/satkerListBend',$data);
	}
  public function listSubUnit(){
    if($this->request->getPost('bidang') != ''){
			session()->set('kdBidang',$this->request->getPost('bidang'));
		}
    $data["unit"] = $this->utama->listUnit();
		return view('utama/listSubUnit',$data);
	}
	public function listSubUnitBend(){
    if($this->request->getPost('bidang') != ''){
			session()->set('kdBidang',$this->request->getPost('bidang'));
		}
    $data["unit"] = $this->utama->listUnit();
		return view('utama/listSubUnitBend',$data);
	}

	public function treeViewKeg($cek = null){
		$unitkey = $this->request->getPost('kdUnit');
		$kd = $this->request->getPost('kdSatker');
		//$data['prog'] = $this->utama->programUnit($unitkey);
		$data["tree"] = $this->utama->treeViewKeg($unitkey,$kd);
		if($cek == 'checkboxes'){
			return view('utama/treeViewKegCheckbox',$data);
		}else{
			return view('utama/treeViewKeg',$data);
		}
	}

}
