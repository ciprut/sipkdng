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
				"up"=>array("Idxkode"=>"6","jnsSpm"=>"up","kdStatus"=>"21","keperluan"=>"uraispmup","jnsBend"=>"02","format"=>"frmtspm"),
				"gu"=>array("Idxkode"=>"2","jnsSpm"=>"gu","kdStatus"=>"22","keperluan"=>"uraispmgu","jnsBend"=>"02","format"=>"frmtspm"),
				"tu"=>array("Idxkode"=>"6","jnsSpm"=>"tu","kdStatus"=>"23","keperluan"=>"uraispmtu","jnsBend"=>"02","format"=>"frmtspm"),
				"ls"=>array("Idxkode"=>"2","jnsSpm"=>"gu","kdStatus"=>"25","keperluan"=>"spmnonspj","jnsBend"=>"02","format"=>"frmtspm")
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
    $data['format'] = $this->utama->getWebset(session()->format);
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
    $data['format'] = $this->utama->getWebset(session()->format);
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
	public function rincianSPM(){
    if($this->request->getPost('nospm') != ''){
			session()->set('nospm',$this->request->getPost('nospm'));
		}

		$data["rinci"] = $this->model->rincianSPM();
		return view('bp/rincianSPM',$data);
	}

	public function formSPM(){
		session()->set('nospm','');
		if($this->request->getPost('nospm') != ''){
			session()->set('nospm',$this->request->getPost('nospm'));
		}
		$data['bendahara'] = $this->model->getBendahara();
		$data['noreg'] = $this->utama->getNoRegSPM(session()->jnsSpm);
		$data['unit'] = $this->utama->getUnit();
		$data['format'] = $this->utama->getWebset(session()->format);
		$data['keperluan'] = $this->utama->getWebset(session()->keperluan);
		$data['bulan'] = $this->utama->listBulan();
		$data['spm'] = $this->model->getSPM(session()->jnsSpm);
		return view('bp/formSPM'.session()->jnsSpm,$data);
	}
	public function sppList(){
		$data["spp"] = $this->model->sppList($this->request->getPost('tanggal'));
		return view('bp/sppList',$data);
	}
	public function simpanSPM(){
    if($this->request->getPost('id') == ''){
      $data = array(
        "UNITKEY"=>session()->kdUnit,
				"NOSPM"=>$this->request->getPost('txtNoSPM'),
        "KDSTATUS"=>session()->kdStatus,
        "KD_BULAN"=>$this->request->getPost('txtBulan'),
        "KEYBEND"=>session()->keybend,
        "IDXKODE"=>session()->Idxkode,
        "NOREG"=>pjg((session()->noreg)+1,3),

				"KETOTOR"=>$this->request->getPost('txtDasar'),
        "KEPERLUAN"=>$this->request->getPost('txtUntuk'),
        "PENOLAKAN"=>"0",
        "TGLSPM"=>$this->request->getPost('txtTanggal')
      );
      $this->model->simpanSPM($data);
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
      $this->model->simpanSPM($data);
    }
		return redirect()->to(site_url('/bp/listSPM'));
	}
	public function formSPMSetuju(){
    session()->set('nospm','');
    if($this->request->getPost('nospm') != ''){
			session()->set('nospm',$this->request->getPost('nospm'));
		}
    $data['bendahara'] = $this->model->getBendahara();
    $data['noreg'] = $this->utama->getNoRegSPP();
    $data['unit'] = $this->utama->getUnit();
    $data['format'] = $this->utama->getWebset(session()->format);
    $data['keperluan'] = $this->utama->getWebset(session()->keperluan);
    $data['bulan'] = $this->utama->listBulan();
    $data['spm'] = $this->model->getSPM(session()->jnsSpm);
		return view('bp/formSPMSetuju',$data);
	}
	public function hapusSPM(){
    session()->set('nospm','');
    if($this->request->getPost('nospm') != ''){
			session()->set('nospm',$this->request->getPost('nospm'));
		}
		$this->model->hapusSPM();
		return redirect()->to(site_url('/bp/listSPM'));
	}
	public function setujuSPM(){
		$data = array(
			"PENOLAKAN"=>$this->request->getPost('txtPenolakan'),
			"TGLVALID"=>$this->request->getPost('txtTanggalValid')
		);
		$this->model->setujuSPM($data);

		return redirect()->to(site_url('/bp/listSPM'));
	}

	/* --------------- BKUBP ------------------- */
	public function bkubp(){
		$data["title"] = "BKU Bendahara Pengeluaran";
		session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		$data["satker"] = $this->utama->listBidang();
		return view('bp/bkubp',$data);
	}
	public function listBKUBP(){
		if($this->request->getPost('keybend') != ''){
			session()->set('keybend',$this->request->getPost('keybend'));
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
		$data["bkubp"] = $this->model->listBKUBP();
		return view('bp/listBKUBP',$data);
	}
	public function formBKUBP(){
		session()->set('nobkuskpd','');
		if($this->request->getPost('nobkuskpd') != ''){
			session()->set('nobkuskpd',$this->request->getPost('nobkuskpd'));
		}
		$data['bku'] = $this->utama->getBKUSKPD();
		$data['noreg'] = $this->utama->getNoBKUSKPD();
		return view('bp/formBKUBP',$data);
	}
	public function simpanBKUBP(){
    if($this->request->getPost('id') == ''){
      $data = array(
        "NOBUKTI"=>$this->request->getPost('txtNoBukti'),
				"TGLBKUSKPD"=>$this->request->getPost('txtTanggal'),
        "URAIAN"=>$this->request->getPost('txtUntuk'),
        "NOBKUSKPD"=>$this->request->getPost('txtNoBKU')."-B02"
      );
      $this->model->simpanBKUBP($data);
    }else{
      $data = array(
        "NOBUKTI"=>$this->request->getPost('txtNoBukti'),
				"TGLBKUSKPD"=>$this->request->getPost('txtTanggal'),
        "URAIAN"=>$this->request->getPost('txtUntuk'),
        "NOBKUSKPD"=>$this->request->getPost('txtNoBKU')."-B02"
      );
      $this->model->simpanSPM($data);
    }
		return redirect()->to(site_url('/bp/listBKUBP'));
	}
	public function hapusBKUBP(){
		$kode = explode("__",$this->request->getPost('nobkuskpd'));
		session()->set('nobkuskpd',$kode[0]);
		$this->model->hapusBKUBP($kode[1]);
		return redirect()->to(site_url('/bp/listBKUBP'));
	}

	/* --------------- PERGESERAN UANG ------------------- */
	public function pergeseranuang(){
		$data["title"] = "BP - Pergeseran Uang";
		session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		$data["satker"] = $this->utama->listBidang();
		return view('bp/pergeseranuang',$data);
	}
	public function listPergeseranUang(){
		if($this->request->getPost('keybend') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
			session()->set('keybend',$this->request->getPost('keybend'));
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
		$data["bkubp"] = $this->model->listPergeseranUang();
		return view('bp/listPergeseranUang',$data);
	}
	public function formPergeseranUang(){
		session()->set('nobuku','');
		if($this->request->getPost('nobuku') != ''){
			session()->set('nobuku',$this->request->getPost('nobuku'));
			$data['pu'] = $this->model->listPergeseranUang(session()->nobuku);
		}else{
			$data['pu'] = [];
		}
		return view('bp/formPergeseranUang',$data);
	}
	public function simpanPU(){
    if($this->request->getPost('id') == ''){
      $data = array(
				"IDXTTD"=>"",
        "KDSTATUS"=>$this->request->getPost('txtJB'),
				"KEYBEND1"=>session()->keybend,
				"KEYBEND2"=>"",
				"TGLBUKU"=>$this->request->getPost('txtTanggal'),
        "URAIAN"=>$this->request->getPost('txtUntuk'),
				"UNITKEY"=>session()->kdUnit,
        "NOBUKU"=>$this->request->getPost('txtNo')
      );
      $this->model->simpanPU($data);
    }else{
      $data = array(
        "NOSP2D"=>$this->request->getPost('txtNoSP2D'),
				"TGLBKUSKPD"=>$this->request->getPost('txtTanggal'),
        "URAIAN"=>$this->request->getPost('txtUntuk'),
        "NOBKUSKPD"=>$this->request->getPost('txtNoBKU')."-B02"
      );
      $this->model->simpanSPM($data);
    }
		return redirect()->to(site_url('/bp/listPergeseranUang'));
	}
	public function hapusPU(){
		if($this->request->getPost('nobuku') != ''){
			session()->set('nobuku',$this->request->getPost('nobuku'));
		}
		$this->model->hapusPU();
		return redirect()->to(site_url('/bp/listPergeseranUang'));
	}
	public function rincianPU(){
		if($this->request->getPost('nobuku') != ''){
			session()->set('nobuku',$this->request->getPost('nobuku'));
		}
		$data["rinci"] = $this->model->rincianPU();
		return view('bp/rincianPU',$data);
	}
	public function updateRinciPU(){
		$post = array("NILAI"=>$this->request->getPost('nilai'));
		$this->model->updateRinciPU($post);
		return redirect()->to(site_url('/bp/rincianPU'));
	}

	/* --------------- TANDA BUKTI PENGELUARAN ------------------- */
	public function TBP(){
		$data["title"] = "TBP - Tanda Bukti Pengeluaran";
		session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		$data["satker"] = $this->utama->listBidang();
		return view('bp/tbp',$data);
	}

	public function listTBP(){
		if($this->request->getPost('keybend') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
			session()->set('keybend',$this->request->getPost('keybend'));
			session()->set('idSub',$this->request->getPost('sub'));
		}
		$data["tbp"] = $this->model->listTBP();
		return view('bp/listTBP',$data);
	}
	public function rinciTBP(){
		if($this->request->getPost('nobpk') != ''){
			session()->set('nobpk',$this->request->getPost('nobpk'));
		}
		$data["rinci"] = $this->model->rinciTBP();
		return view('bp/rinciTBP',$data);
	}
	public function formTBP(){
		session()->set('nobpk','');
		if($this->request->getPost('nobpk') != ''){
			session()->set('nobpk',$this->request->getPost('nobpk'));
			$data['tbp'] = $this->model->getTBP(session()->nobuku);
		}else{
			$data['noreg'] = $this->utama->getNoRegTBP();
			$data['unit'] = $this->utama->getUnit();
			$data['bend'] = $this->utama->getBendahara();
			$data['tbp'] = [];
		}
		return view('bp/formTBP',$data);
	}
	public function simpanTBP(){
		$stpanjar = $sttunai = $stbank = '0';
		if($this->request->getPost('txtSbr') == 'tunai'){
			$sttunai = '1';
		}else if($this->request->getPost('txtSbr') == 'panjar'){
			$stpanjar = '1';
		}else{
			$stbank = '1';
		}
    if($this->request->getPost('id') == ''){
      $data = array(
				"UNITKEY"=>session()->kdUnit,
				"TGLBPK"=>$this->request->getPost('txtTanggal'),
        "STPANJAR"=>$stpanjar,
        "STTUNAI"=>$sttunai,
        "STBANK"=>$stbank,
        "KDSTATUS"=>'21',
				"IDXKODE"=>"2",
				"KEYBEND"=>session()->keybend,
				"PENERIMA"=>$this->request->getPost('txtPenerima'),
        "URAIBPK"=>$this->request->getPost('txtUntuk'),
        "NOBPK"=>$this->request->getPost('txtNo')
      );
      $this->model->simpanTBP($data);
    }else{
      $data = array(
        "NOSP2D"=>$this->request->getPost('txtNoSP2D'),
				"TGLBKUSKPD"=>$this->request->getPost('txtTanggal'),
        "URAIAN"=>$this->request->getPost('txtUntuk'),
        "NOBKUSKPD"=>$this->request->getPost('txtNoBKU')."-B02"
      );
      $this->model->simpanTBP($data);
    }
		return redirect()->to(site_url('/bp/listTBP'));
	}
	public function listSubRinc(){
		if($this->request->getPost('idSub') != ''){
			session()->set('idSub',$this->request->getPost('idSub'));
		}
		$data["sro"] = $this->model->listSubRinc();
		return view('bp/listSubRinc',$data);
	}
	public function tambahRO(){
		$post = array(
			"MTGKEY"=>$this->request->getPost('mtgkey'),
			"NILAI"=>"0",
			"NOJETRA"=>"21",
			"KDKEGUNIT"=>session()->idSub,
			"NOBPK"=>session()->nobpk,
			"UNITKEY"=>session()->kdUnit
		);
		$this->model->tambahRO($post);
		return redirect()->to(site_url('/bp/rinciTBP'));
	}
	public function listSDTBP(){
		if($this->request->getPost('kdper') != ''){
			session()->set('mtgkey',$this->request->getPost('kdper'));
		}
		$data["sd"] = $this->model->listSDTBP();
		return view('bp/listSDTBP',$data);
	}
	public function listSDSub(){
		$data["sd"] = $this->model->listSDSub();
		return view('bp/listSDSub',$data);
	}
	public function inputSDTBP(){
		if($this->request->getPost('kdDana') != ''){
			session()->set('kdDana',$this->request->getPost('kdDana'));
		}
		$this->model->inputSDTBP();
		return redirect()->to(site_url('/bp/listSDTBP'));
	}
	public function updateRinciTBP(){
		$post = array(
			"NILAI"=>$this->request->getPost('nilai'),
			"KDDANA"=>$this->request->getPost('kdDana')
		);
		$this->model->updateRinciTBP($post);
		return redirect()->to(site_url('/bp/listSDTBP'));
	}

	/* --------------- PERTANGGUNGJAWABAN ------------------- */
	public function pertanggungjawaban(){
		$data["title"] = "Pertanggungjawaban UP/GU/TU";
		session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		$data["satker"] = $this->utama->listBidang();
		return view('bp/pertanggungjawaban',$data);
	}

}
