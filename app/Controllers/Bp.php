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

	/* --------------- SPP ------------------- */
  public function spp(){
		$data["title"] = "SPP - Surat Permintaan Pembayaran";
    session()->set('tahap',$this->utama->getTahap());
    session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");
		session()->set('pengajuan','spp');

    $data["satker"] = $this->utama->listBidang();
    return view('bp/spp',$data);
	}
	public function listBendahara(){
    if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
		$jns = $this->request->getPost('jns');

		if(session()->pengajuan == 'spp'){
			$params = array(
				"up"=>array("Idxkode"=>"6","jnsSpp"=>"up","kdStatus"=>"21","keperluan"=>"uraisppup","jnsBend"=>"02","format"=>"frmtspp"),
				"gu"=>array("Idxkode"=>"2","jnsSpp"=>"gu","kdStatus"=>"22","keperluan"=>"uraisppgu","jnsBend"=>"02","format"=>"frmtspp"),
				"tu"=>array("Idxkode"=>"6","jnsSpp"=>"tu","kdStatus"=>"23","keperluan"=>"uraispptu","jnsBend"=>"02","format"=>"frmtspp"),
				"ls"=>array("Idxkode"=>"2","jnsSpp"=>"gu","kdStatus"=>"25","keperluan"=>"sppnonspj","jnsBend"=>"02","format"=>"frmtspp")
			);
			session()->set('jnsSpp',$params[$jns]['jnsSpp']);
			session()->set('Idxkode',$params[$jns]['Idxkode']);
			session()->set('kdStatus',$params[$jns]['kdStatus']);
			session()->set('keperluan',$params[$jns]['keperluan']);
			session()->set('jnsBend',$params[$jns]['jnsBend']);
			session()->set('format',$params[$jns]['format']);
		}else if(session()->pengajuan == 'spm'){
			$params = array(
				"up"=>array("Idxkode"=>"6","jnsSpm"=>"up","kdStatus"=>"21","keperluan"=>"uraisppup","jnsBend"=>"02","format"=>"frmtspp"),
				"gu"=>array("Idxkode"=>"2","jnsSpm"=>"gu","kdStatus"=>"22","keperluan"=>"uraisppgu","jnsBend"=>"02","format"=>"frmtspp"),
				"tu"=>array("Idxkode"=>"6","jnsSpm"=>"tu","kdStatus"=>"23","keperluan"=>"uraispptu","jnsBend"=>"02","format"=>"frmtspp"),
				"ls"=>array("Idxkode"=>"2","jnsSpm"=>"gu","kdStatus"=>"25","keperluan"=>"sppnonspj","jnsBend"=>"02","format"=>"frmtspp")
			);
			session()->set('jnsSpm',$params[$jns]['jnsSpm']);
			session()->set('Idxkode',$params[$jns]['Idxkode']);
			session()->set('kdStatus',$params[$jns]['kdStatus']);
			session()->set('keperluan',$params[$jns]['keperluan']);
			session()->set('jnsBend',$params[$jns]['jnsBend']);
			session()->set('format',$params[$jns]['format']);
		}
		$data["bendahara"] = $this->utama->listBendahara(session()->jnsBend);
		return view('bp/listBendahara',$data);
	}
	public function listSPP(){
    if($this->request->getPost('keybend') != ''){
			session()->set('keybend',$this->request->getPost('keybend'));
		}

		$data["spp"] = $this->model->listSPP(session()->jnsBend);
		return view('bp/listSPP',$data);
	}
	public function spdList(){
		$data["spd"] = $this->model->spdList($this->request->getPost('tanggal'));
		return view('bp/spdList',$data);
	}
	public function formSPP(){
    session()->set('nospp','');
    if($this->request->getPost('nospp') != ''){
			session()->set('nospp',$this->request->getPost('nospp'));
		}
    $data['bendahara'] = $this->model->getBendahara();
    $data['noreg'] = $this->utama->getNoRegSPP();
    $data['unit'] = $this->utama->getUnit();
    $data['format'] = $this->utama->getWebset(session()->control);
    $data['keperluan'] = $this->utama->getWebset(session()->keperluan);
    $data['bulan'] = $this->utama->listBulan();
    $data['spp'] = $this->model->getSPP();
		return view('bp/formSPP'.session()->jnsSpp,$data);
	}
	public function formSPPSetuju(){
    session()->set('nospp','');
    if($this->request->getPost('nospp') != ''){
			session()->set('nospp',$this->request->getPost('nospp'));
		}
    $data['bendahara'] = $this->model->getBendahara();
    $data['noreg'] = $this->utama->getNoRegSPP();
    $data['unit'] = $this->utama->getUnit();
    $data['format'] = $this->utama->getWebset(session()->control);
    $data['keperluan'] = $this->utama->getWebset(session()->keperluan);
    $data['bulan'] = $this->utama->listBulan();
    $data['spp'] = $this->model->getSPP();
		return view('bp/formSPPSetuju',$data);
	}
	public function simpanSPP(){
    if($this->request->getPost('id') == ''){
      $data = array(
        "UNITKEY"=>session()->kdUnit,
				"NOSPP"=>$this->request->getPost('txtNoSPP'),
        "KDSTATUS"=>session()->kdStatus,
        "KD_BULAN"=>$this->request->getPost('txtBulan'),
        "KEYBEND"=>session()->keybend,
        "IDXSKO"=>$this->request->getPost('idxsko'),
        "IDXKODE"=>session()->Idxkode,
        "NOREG"=>pjg((session()->noreg)+1,3),

				"KETOTOR"=>$this->request->getPost('txtDasar'),
        "KEPERLUAN"=>$this->request->getPost('txtUntuk'),
        "PENOLAKAN"=>$this->request->getPost('txtPenolakan'),
        "TGSPP"=>$this->request->getPost('txtTanggal')
      );
      $this->model->simpanSPP($data);
    }else{
      $data = array(
        "JNS_BEND"=>$this->request->getPost('txtJBend'),
        "KDBANK"=>$this->request->getPost('txtBank'),
        "UNITKEY"=>session()->kdUnit,
        "JAB_BEND"=>$this->request->getPost('txtBKU'),
        "REKBEND"=>$this->request->getPost('txtRek'),
        "SALDOBEND"=>$this->request->getPost('txtSBank'),
        "NPWPBEND"=>$this->request->getPost('txtNPWP'),
        "SALDOBENDT"=>$this->request->getPost('txtSTunai'),
        "NOREK"=>$this->request->getPost('txtRek')
      );
      $this->model->simpanSPP($data);
    }
		return redirect()->to(site_url('/bp/listSPP'));
	}
	public function setujuSPP(){
		$data = array(
			"PENOLAKAN"=>$this->request->getPost('txtPenolakan'),
			"TGLVALID"=>$this->request->getPost('txtTanggalValid')
		);
		$this->model->setujuSPP($data);

		return redirect()->to(site_url('/bp/listSPP'));
	}
	public function hapusSPP(){
    session()->set('nospp','');
    if($this->request->getPost('nospp') != ''){
			session()->set('nospp',$this->request->getPost('nospp'));
		}
		$this->model->hapusSPP();
		return redirect()->to(site_url('/bp/listSPP'));
	}
	public function rincianSPP(){
    if($this->request->getPost('nospp') != ''){
			session()->set('nospp',$this->request->getPost('nospp'));
		}

		$data["rinci"] = $this->model->rincianSPP();
		return view('bp/rincianSPP',$data);
	}

		/* --------------- SPM ------------------- */
		public function spm(){
			$data["title"] = "SPM - Surat Perintah Membayar";
			session()->set('tahap',$this->utama->getTahap());
			session()->set('tahap',$this->utama->getTahap());
			//$data["sidebar"] = $this->sidebar->menu();
			$data["menu"] = file_get_contents("./public/".session()->modul.".json");
			session()->set('pengajuan','spm');
	
			$data["satker"] = $this->utama->listBidang();
			return view('bp/spm',$data);
		}
		public function listSPM(){
			if($this->request->getPost('keybend') != ''){
				session()->set('keybend',$this->request->getPost('keybend'));
			}
	
			$data["spp"] = $this->model->listSPM(session()->jnsBend);
			return view('bp/listSPM',$data);
		}
	
}
