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
}
