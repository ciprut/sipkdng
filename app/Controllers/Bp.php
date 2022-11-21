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

	/* ------------------------ */
	public function jenisSPPSPM(){
		session()->set('pengajuan',$this->request->getPost('pengajuan'));
		session()->set('jnsSpp',$this->request->getPost('jn'));
		session()->set('title',$this->request->getPost('title'));

		$jns = session()->jnsSpp;
		if(session()->pengajuan == 'spp'){
			$params = array(
				"up"=>array("Idxkode"=>"6","jnsSpp"=>"up","kdStatus"=>"21","keperluan"=>"uraisppup","jnsBend"=>"02","format"=>"frmtspp"),
				"gu"=>array("Idxkode"=>"2","jnsSpp"=>"gu","kdStatus"=>"22","keperluan"=>"uraisppgu","jnsBend"=>"02","format"=>"frmtspp"),
				"tu"=>array("Idxkode"=>"6","jnsSpp"=>"tu","kdStatus"=>"23","keperluan"=>"uraispptu","jnsBend"=>"02","format"=>"frmtspp"),
				"ls"=>array("Idxkode"=>"2","jnsSpp"=>"ls","kdStatus"=>"24","keperluan"=>"uraisppls","jnsBend"=>"02","format"=>"frmtspp")
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
				"ls"=>array("Idxkode"=>"2","jnsSpm"=>"ls","kdStatus"=>"24","keperluan"=>"uraispmls","jnsBend"=>"02","format"=>"frmtspm")
			);
			session()->set('jnsSpm',$params[$jns]['jnsSpm']);
			session()->set('Idxkode',$params[$jns]['Idxkode']);
			session()->set('kdStatus',$params[$jns]['kdStatus']);
			session()->set('keperluan',$params[$jns]['keperluan']);
			session()->set('jnsBend',$params[$jns]['jnsBend']);
			session()->set('format',$params[$jns]['format']);
		}

		return view('bp/headerSpp');
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
		session()->set('jnsBend','02');
		$data["bendahara"] = $this->utama->listBendahara(session()->jnsBend);
		return view('bp/listBendahara',$data);
	}
	public function listSPP(){
    if($this->request->getPost('keybend') != ''){
			session()->set('keybend',$this->request->getPost('keybend'));
			session()->set('jnsSpp',$this->request->getPost('jn'));
			session()->set('st',$this->request->getPost('st'));
			session()->set('idSub',$this->request->getPost('idSub'));
			session()->set('kdSatker',$this->request->getPost('kdSatker'));
		}
		/*
		$jns = session()->jnsSpp;
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
		*/
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

		$jns = session()->jnsSpp;
		
    $data['bendahara'] = $this->model->getBendahara();
    $data['noreg'] = $this->utama->getNoReg("SPP","NOREG");
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
        "NOREG"=>pjg((session()->noreg),5),

				"KETOTOR"=>$this->request->getPost('txtDasar'),
        "KEPERLUAN"=>$this->request->getPost('txtUntuk'),
        "PENOLAKAN"=>$this->request->getPost('txtPenolakan'),
        "TGSPP"=>$this->request->getPost('txtTanggal')
      );
			if(session()->jnsSpp == 'ls'){
				if($this->request->getPost('kp3') != ''){
					$data['KDP3'] = $this->request->getPost('kp3');
				}
				if($this->request->getPost('txtNoKontrak') != ''){
					$data['NOKONTRAK'] = $this->request->getPost('txtNoKontrak');
				}
			}
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
	public function RekLSList(){
		$data['rek'] = $this->model->RekLSList();
		return view('bp/RekLSList',$data);
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
	public function hapusRinciSPP(){
    session()->set('nospj','');
    if($this->request->getPost('nospj') != ''){
			session()->set('nospj',$this->request->getPost('nospj'));
		}
		$this->model->hapusRinciSPP();
		return redirect()->to(site_url('/bp/rincianSPP'));
	}
	public function hapusRinciSPPLS(){
    session()->set('nospj','');
    if($this->request->getPost('mtgkey') != ''){
			session()->set('mtgkey',$this->request->getPost('mtgkey'));
		}
		$this->model->hapusRinciSPPLS();
		return redirect()->to(site_url('/bp/rincianSPP'));
	}
	public function rincianSPP(){
    if($this->request->getPost('nospp') != ''){
			session()->set('nospp',$this->request->getPost('nospp'));
		}
		$data["rinci"] = $this->model->rincianSPP();
		return view('bp/rincianSPP',$data);
	}
	public function rinciSDLS(){
    if($this->request->getPost('mtgkey') != ''){
			session()->set('mtgkey',$this->request->getPost('mtgkey'));
		}
		$data["sd"] = $this->model->rinciSDLS();
		return view('bp/rinciSDLS',$data);
	}
	public function inputSDLS(){
		$post = array(
			'NILAI'=>'0',
			'KDDANA'=>$this->request->getPost('kdDana'),
			'NOSPP'=>session()->nospp,
			'UNITKEY'=>session()->kdUnit,
			'KDKEGUNIT'=>session()->idSub,
			'MTGKEY'=>session()->mtgkey
		);
		$this->model->inputSDLS($post);
		return redirect()->to(site_url('/bp/rinciSDLS'));
	}
	public function updateRinciLS(){		
		$this->model->updateRinciLS($this->request->getPost('kdDana'),$this->request->getPost('nilai'));
		return redirect()->to(site_url('/bp/rinciSDLS'));
	}
	public function hapusRinciLS(){		
		$this->model->hapusRinciLS($this->request->getPost('kdDana'));
		return redirect()->to(site_url('/bp/rinciSDLS'));
	}
	public function listSDLS(){
		$data["sd"] = $this->model->listSDLS();
		return view('bp/listSDLS',$data);
	}
	public function tambahSPJSPP(){
		$post = array(
			"NOSPP"=>session()->nospp,
			"UNITKEY"=>session()->kdUnit,
			"NOSPJ"=>$this->request->getPost('nospj')
		);
		$this->model->tambahSPJSPP($post);
		return redirect()->to(site_url('/bp/rincianSPP'));
	}
	public function rincianSPJSPP(){
		if($this->request->getPost('nospj') != ''){
			session()->set('nospj',$this->request->getPost('nospj'));
		}

		$data["rinci"] = $this->model->rincianSPJSPP();
		return view('bp/rincianSPJSPP',$data);

	}
	public function tambahROLS(){
		$this->model->tambahROLS($this->request->getPost('mtgkey'));
		return redirect()->to(site_url('/bp/rincianSPP'));
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
	public function jenisSPM(){
		session()->set('pengajuan',$this->request->getPost('pengajuan'));
		session()->set('jnsSpm',$this->request->getPost('jn'));
		session()->set('title',$this->request->getPost('title'));

		$jns = session()->jnsSpm;
		if(session()->pengajuan == 'spp'){
			$params = array(
				"up"=>array("Idxkode"=>"6","jnsSpp"=>"up","kdStatus"=>"21","keperluan"=>"uraisppup","jnsBend"=>"02","format"=>"frmtspp"),
				"gu"=>array("Idxkode"=>"2","jnsSpp"=>"gu","kdStatus"=>"22","keperluan"=>"uraisppgu","jnsBend"=>"02","format"=>"frmtspp"),
				"tu"=>array("Idxkode"=>"6","jnsSpp"=>"tu","kdStatus"=>"23","keperluan"=>"uraispptu","jnsBend"=>"02","format"=>"frmtspp"),
				"ls"=>array("Idxkode"=>"2","jnsSpp"=>"ls","kdStatus"=>"24","keperluan"=>"uraisppls","jnsBend"=>"02","format"=>"frmtspp")
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
				"ls"=>array("Idxkode"=>"2","jnsSpm"=>"ls","kdStatus"=>"24","keperluan"=>"uraispmls","jnsBend"=>"02","format"=>"frmtspm")
			);
			session()->set('jnsSpm',$params[$jns]['jnsSpm']);
			session()->set('Idxkode',$params[$jns]['Idxkode']);
			session()->set('kdStatus',$params[$jns]['kdStatus']);
			session()->set('keperluan',$params[$jns]['keperluan']);
			session()->set('jnsBend',$params[$jns]['jnsBend']);
			session()->set('format',$params[$jns]['format']);
		}

		return view('bp/headerSpm');
	}
	public function listSPM(){
		if($this->request->getPost('keybend') != ''){
			session()->set('keybend',$this->request->getPost('keybend'));
			session()->set('jnsSpm',$this->request->getPost('jn'));
			session()->set('st',$this->request->getPost('st'));
			session()->set('idSub',$this->request->getPost('idSub'));
			session()->set('kdSatker',$this->request->getPost('kdSatker'));
		}
/*
		if($this->request->getPost('keybend') != ''){
			session()->set('keybend',$this->request->getPost('keybend'));
			session()->set('jnsSpm',$this->request->getPost('jns'));
		}
		$jns = $this->request->getPost('jns');

		$params = array(
			"up"=>array("Idxkode"=>"6","jnsSpm"=>"up","kdStatus"=>"21","keperluan"=>"uraispmup","jnsBend"=>"02","format"=>"frmtspm"),
			"gu"=>array("Idxkode"=>"2","jnsSpm"=>"gu","kdStatus"=>"22","keperluan"=>"uraispmgu","jnsBend"=>"02","format"=>"frmtspm"),
			"tu"=>array("Idxkode"=>"2","jnsSpm"=>"tu","kdStatus"=>"23","keperluan"=>"uraispmtu","jnsBend"=>"02","format"=>"frmtspm"),
			"ls"=>array("Idxkode"=>"2","jnsSpm"=>"gu","kdStatus"=>"25","keperluan"=>"spmnonspj","jnsBend"=>"02","format"=>"frmtspm")
		);
		session()->set('jnsSpm',$params[$jns]['jnsSpm']);
		session()->set('Idxkode',$params[$jns]['Idxkode']);
		session()->set('kdStatus',$params[$jns]['kdStatus']);
		session()->set('keperluan',$params[$jns]['keperluan']);
		session()->set('jnsBend',$params[$jns]['jnsBend']);
		session()->set('format',$params[$jns]['format']);
*/
		$data["spm"] = $this->model->listSPM(session()->jnsBend);
		return view('bp/listSPM',$data);
	}
	public function rincianSPM(){
    if($this->request->getPost('nospm') != ''){
			session()->set('nospm',$this->request->getPost('nospm'));
		}

		$data["rinci"] = $this->model->rincianSPM();
		if(session()->jnsSpm == "up"){
			return view('bp/rincianSPMUP',$data);
		}
		if(session()->jnsSpm == "gu"){
			return view('bp/rincianSPMGU',$data);
		}if(session()->jnsSpm == "ls"){
			return view('bp/rincianSPMLS',$data);
		}
	}
	public function detilKegiatanGU(){
		if($this->request->getPost('idSub') != ''){
			session()->set('idSub',$this->request->getPost('idSub'));
		}
		$data['detil'] = $this->model->detilKegiatanGU();
		return view('bp/detilKegiatanGU',$data);
	}
	public function listLsPotongan(){
		$data['spm'] = $this->model->getSPM(session()->jnsSpm);
		$data['potongan'] = $this->model->listLsPotongan();
		return view('bp/listLsPotongan',$data);
	}
	public function hapusPotonganLS(){
		$this->model->hapusPotonganLS($this->request->getPost('id'));
		return redirect()->to(site_url('/bp/listLsPotongan'));
	}
	public function tambahPotonganLS(){
		$this->model->tambahPotonganLS($this->request->getPost('mtgkey'));
		return redirect()->to(site_url('/bp/listLsPotongan'));
	}
	public function potonganLSList(){
		$data["rek"] = $this->model->potonganLSList();
		return view('bp/potonganLSList',$data);
	}
	public function updatePotongan(){
		$this->model->updatePotongan($this->request->getPost('pot'),$this->request->getPost('nilai'));
		return redirect()->to(site_url('/bp/listLsPotongan'));
	}
	public function pajakLSList(){
		$data["rek"] = $this->model->pajakLSList();
		return view('bp/pajakLSList',$data);
	}
	public function hapusPajakLS(){
		$this->model->hapusPajakLS($this->request->getPost('id'));
		return redirect()->to(site_url('/bp/listLsPajak'));
	}
	public function tambahPajakLS(){
		$this->model->tambahPajakLS($this->request->getPost('mtgkey'));
		return redirect()->to(site_url('/bp/listLsPajak'));
	}
	public function listLsPajak(){
		$data['spm'] = $this->model->getSPM(session()->jnsSpm);
		$data['pajak'] = $this->model->listLsPajak();
		return view('bp/listLsPajak',$data);
	}
	public function updatePajakLS(){
		$this->model->updatePajakLS($this->request->getPost('pjk'),$this->request->getPost('nilai'));
		return redirect()->to(site_url('/bp/listLsPajak'));
	}
	public function formSPM(){
		session()->set('nospm','');
		if($this->request->getPost('nospm') != ''){
			session()->set('nospm',$this->request->getPost('nospm'));
		}
		$data['bendahara'] = $this->model->getBendahara();
		$data['noreg'] = $this->utama->getNoReg('ANTARBYR','NOREG');
		$data['unit'] = $this->utama->getUnit();
		$data['format'] = $this->utama->getWebset(session()->format);
		$data['keperluan'] = $this->utama->getWebset(session()->keperluan);
		$data['bulan'] = $this->utama->listBulan();
		$data['spm'] = $this->model->getSPM(session()->jnsSpm);
		return view('bp/formSPM'.session()->jnsSpm,$data);
	}
	public function sppList(){
		$data["spp"] = $this->model->sppList($this->request->getPost('tanggal'));
		if(session()->jnsSpm == "ls"){
			return view('bp/sppListLS',$data);
		}else{
			return view('bp/sppList',$data);
		}
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
	public function simpanSPMGU(){
		session()->set("nospp",trim($this->request->getPost('txtNoSPP')));
		$spp = $this->model->getSPP();

		$data = array(
			"KDKABKOT"=>'',
			"KDDANA"=>'',
			"IDXKODE"=>session()->Idxkode,
			"IDXSKO"=>$spp->IDXSKO,
			"IDXTTD"=>$spp->IDXTTD,
			"KDP3"=>$spp->KDP3,
			"KDSTATUS"=>session()->kdStatus,
			"KETOTOR"=>$spp->KETOTOR,
			"KEYBEND"=>session()->keybend,
			"NOKONTRAK"=>$spp->NOKONTRAK,
			"NOREG"=>pjg((session()->noreg),5),
			"NOSPP"=>$spp->NOSPP,
			"PENOLAKAN"=>"0",
			"KEPERLUAN"=>$this->request->getPost('txtUntuk'),
			"TGLSPM"=>$this->request->getPost('txtTanggal'),
			"TGSPP"=>$spp->TGSPP,
			"UNITKEY"=>session()->kdUnit,
			"NOSPM"=>$this->request->getPost('txtNoSPM')
		);
		$this->model->simpanSPMGU($data);

		return redirect()->to(site_url('/bp/listSPM'));
	}
	public function simpanSPMLS(){
		session()->set("nospp",trim($this->request->getPost('txtDasar')));
		$spp = $this->model->getSPP();

		$data = array(
			"KDKABKOT"=>'',
			"KDDANA"=>'',
			"IDXKODE"=>session()->Idxkode,
			"IDXSKO"=>$spp->IDXSKO,
			"IDXTTD"=>$spp->IDXTTD,
			"KDP3"=>$spp->KDP3,
			"KDSTATUS"=>session()->kdStatus,
			"KETOTOR"=>$spp->KETOTOR,
			"KEYBEND"=>session()->keybend,
			"NOKONTRAK"=>$spp->NOKONTRAK,
			"NOREG"=>pjg((session()->noreg),5),
			"NOSPP"=>$spp->NOSPP,
			"PENOLAKAN"=>"0",
			"KEPERLUAN"=>$this->request->getPost('txtUntuk'),
			"TGLSPM"=>$this->request->getPost('txtTanggal'),
			"TGSPP"=>$spp->TGSPP,
			"UNITKEY"=>session()->kdUnit,
			"NOSPM"=>$this->request->getPost('txtNoSPM')
		);
		$this->model->simpanSPMGU($data);

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
	public function rincianBKUBP(){
    if($this->request->getPost('nobukti') != ''){
			session()->set('nobukti',$this->request->getPost('nobukti'));
		}

		$data["rinci"] = $this->model->rincianBKUBP();
		return view('bp/rincianBKUBP',$data);
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
	public function hapusRinciTBP(){
		session()->set('mtgkey','');
		if($this->request->getPost('mtgkey') != ''){
			session()->set('mtgkey',$this->request->getPost('mtgkey'));
		}
		$this->model->hapusRinciTBP($data);
		return redirect()->to(site_url('/bp/rinciTBP'));
	}
	public function hapusRinciTBPSD(){
		session()->set('kdper','');
		if($this->request->getPost('kdper') != ''){
			session()->set('kdper',$this->request->getPost('kdper'));
		}
		$this->model->hapusRinciTBP($data);
		return redirect()->to(site_url('/bp/rinciTBP'));
	}
	public function hapusTBP(){
		session()->set('nobpk','');
		if($this->request->getPost('nobpk') != ''){
			session()->set('nobpk',$this->request->getPost('nobpk'));
		}
		$this->model->hapusTBP();
		return redirect()->to(site_url('/bp/listTBP'));
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
				"PENERIMA"=>$this->request->getPost('txtPenerima'),
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
		$this->model->tambahRO($this->request->getPost('mtgkey'));
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
		$data["title"] = "Pertanggungjawaban - [SPJ] UP/GU/TU";
		session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		$data["satker"] = $this->utama->listBidang();
		return view('bp/pertanggungjawaban',$data);
	}

	public function listSPJ(){
		if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
			session()->set('keybend',$this->request->getPost('keybend'));
		}
		$data["spj"] = $this->model->listSPJ();
		return view('bp/listSPJ',$data);
	}
	public function rincSPJBPK(){
		if($this->request->getPost('noSPJ') != ''){
			session()->set('noSPJ',$this->request->getPost('noSPJ'));
		}
		$data["bpk"] = $this->model->rincSPJBPK();
		return view('bp/rincSPJBPK',$data);
	}
	public function rinciSPJSubKeg(){
		if($this->request->getPost('noSPJ') != ''){
			session()->set('noSPJ',$this->request->getPost('noSPJ'));
		}
		$data["sub"] = $this->model->rinciSPJSubKeg();
		return view('bp/rinciSPJSubKeg',$data);
	}
	public function detilSPJRekening(){
		if($this->request->getPost('idSub') != ''){
			session()->set('idSub',$this->request->getPost('idSub'));
		}
		$data["ro"] = $this->model->detilSPJRekening();
		return view('bp/detilSPJRekening',$data);
	}
	public function formSPJ(){
		session()->set('noSPJ','');
		if($this->request->getPost('noSPJ') != ''){
			session()->set('noSPJ',$this->request->getPost('noSPJ'));
			$data['spj'] = $this->model->getSPJ(session()->noSPJ);
		}else{
			$data['noreg'] = $this->utama->getNoReg('PSPJ','NOSPJ');
			$data['unit'] = $this->utama->getUnit();
			$data['bend'] = $this->utama->getBendahara();
			$data['spj'] = [];
		}
		return view('bp/formSPJ',$data);
	}
	public function simpanSPJ(){
		$post = array(
			"IDXKODE"=>"2",
			"IDXTTD"=>"",
			"KDSTATUS"=>"42",
			"KETERANGAN"=>$this->request->getPost('txtUntuk'),
			"KEYBEND"=>session()->keybend,
			"TGLBUKU"=>$this->request->getPost('txtTanggalBuku'),
			"TGLSPJ"=>$this->request->getPost('txtTanggalSPJ'),
			"NOSPJ"=>$this->request->getPost('txtNoSPJ'),
			"UNITKEY"=>session()->kdUnit
		);
		$this->model->simpanSPJ($post);
		return redirect()->to(site_url('/bp/listSPJ'));
	}
	public function validasiSPJ(){
		$post = array(
			"NOSAH"=>$this->request->getPost('txtNoVal'),
			"TGLSAH"=>$this->request->getPost('txtTanggal')
		);
		$this->model->validasiSPJ($post);
		return redirect()->to(site_url('/bp/listSPJ'));
	}
	public function BPKList(){
		$data['bpk'] = $this->model->BPKList();
		return view('bp/BPKList',$data);
	}
	public  function SPJList(){
		$data['spj'] = $this->model->SPJList();
		return view('bp/SPJList',$data);
	}
	public function insertBPKSPJ(){
		$post = array(
			'NOSPJ'=>session()->noSPJ,
			"NOBPK"=>$this->request->getPost('noBPK'),
			"UNITKEY"=>session()->kdUnit
		);
		$this->model->insertBPKSPJ($post);
		return redirect()->to(site_url('/bp/rincSPJBPK'));
	}
	public function formValidasiSPJ(){
		session()->set('noSPJ','');
		if($this->request->getPost('noSPJ') != ''){
			session()->set('noSPJ',$this->request->getPost('noSPJ'));
			$data['spj'] = $this->model->getSPJ();
		}else{
			$data['noreg'] = $this->utama->getNoReg('PSPJ','NOSPJ');
			$data['unit'] = $this->utama->getUnit();
			$data['bend'] = $this->utama->getBendahara();
			$data['spj'] = [];
		}
		return view('bp/formValidasiSPJ',$data);
	}

	/* --------------- PAJAK ------------------- */
	public function pajak(){
		$data["title"] = "Pemungutan / Penyetoran Pajak";
		session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		$data["satker"] = $this->utama->listBidang();
		return view('bp/pajak',$data);
	}
	public function listPajak(){
		if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
			session()->set('keybend',$this->request->getPost('keybend'));
			session()->set('idSub',$this->request->getPost('sub'));
		}
		$data['pajak'] = $this->model->listPajak();
		return view('bp/listPajak',$data);
	}
	public function formPajak(){
		session()->set('nobkpajak','');
    if($this->request->getPost('nobkpajak') != ''){
			session()->set('nobkpajak',$this->request->getPost('nobkpajak'));
		}

		$data['bendahara'] = $this->model->getBendahara();
    $data['unit'] = $this->utama->getUnit();
    $data['pajak'] = $this->model->getPajak();
    $data['noreg'] = $this->utama->getNoreg("BKPAJAK","NOBKPAJAK");
		return view('bp/formPajak',$data);
	}
	public function pajakTBPList(){
		$data['tbp'] = $this->model->pajakTBPList($this->request->getPost('tanggal'));
		return view('bp/pajakTBPList',$data);
	}
	public function simpanPajak(){
		if($this->request->getPost('id') == ""){
			$bkpajak = array(
				"NTPN"=>"",
				"IDXTTD"=>"",
				"KDSTATUS"=>"35",
				"KEYBEND"=>session()->keybend,
				"TGLBKPAJAK"=>$this->request->getPost('txtTanggal'),
				"TGLVALID"=>$this->request->getPost('txtTglBuku'),
				"URAIAN"=>$this->request->getPost('txtUntuk'),
				"UNITKEY"=>session()->kdUnit,
				"NOBKPAJAK"=>$this->request->getPost('txtNoPajak')
			);
			$bpkpajak = array(
				"UNITKEY"=>session()->kdUnit,
				"NOBPK"=>$this->request->getPost('txtNoTBP'),
				"KDSTATUS"=>"35",
				"NOBKPAJAK"=>$this->request->getPost('txtNoPajak'),
				"KDKEGUNIT"=>session()->idSub
			);
			$this->model->simpanPajak($bkpajak,$bpkpajak);
		}else{
			$bkpajak = array(
				"TGLBKPAJAK"=>$this->request->getPost('txtTanggal'),
				"TGLVALID"=>$this->request->getPost('txtTglBuku'),
				"URAIAN"=>$this->request->getPost('txtUntuk')
			);
			$this->model->updatePajak($this->request->getPost('id'),$bkpajak);
		}
		return redirect()->to(site_url('/bp/listPajak'));
	}
	public function detilPajak(){
		if($this->request->getPost('nobkpajak') != ''){
			session()->set('nobkpajak',$this->request->getPost('nobkpajak'));
		}
		$data['dp'] = $this->model->detilPajak();
		return view('bp/detilPajak',$data);
	}
	public function listRekPajak(){
		$data['rp'] = $this->model->listRekPajak();
		return view('bp/listRekPajak',$data);
	}
	public function simpanDetilPajak($no){
		$post = array(
			'NILAI'=>'0',
			'UNITKEY'=>session()->kdUnit,
			'NOBKPAJAK'=>session()->nobkpajak,
			'PJKKEY'=>$no
		);
		$this->model->simpanDetilPajak($post);
		return redirect()->to(site_url('/bp/detilPajak'));
	}
	public function updateRinciPajak(){
		$post = array(
			'NILAI'=>$this->request->getPost('nilai')
		);
		$this->model->updateRinciPajak($this->request->getPost('no'),$post);
		return redirect()->to(site_url('/bp/detilPajak'));
	}
	public function hapusDetilPajak($no){
		$this->model->hapusDetilPajak($no);
		return redirect()->to(site_url('/bp/detilPajak'));
	}

	/* --------------- PANJAR ------------------- */
	public function panjar(){
		$data["title"] = "Panjar Kegiatan";
		session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

		$data["satker"] = $this->utama->listBidang();
		return view('bp/panjar',$data);
	}
	public function formPanjar(){
		session()->set('nopanjar','');
		$data['panjar'] = [];
    if($this->request->getPost('nopanjar') != ''){
			session()->set('nopanjar',$this->request->getPost('nopanjar'));
			$data['panjar'] = $this->model->getPanjar();
		}
		$data['unit'] = $this->utama->getUnit();
    $data['noreg'] = $this->utama->getNoreg("PANJAR","NOPANJAR");
		return view('bp/formPanjar',$data);
	}
	public function simpanPanjar(){
		$stt = "0";$stb = "1";
		if($this->request->getPost('txtSB') == "tunai"){
			$stt = "1";$stb = "0";
		}
		$post = array(
			'IDXKODE'=>'2',
			'STTUNAI'=>$stt,
			'STBANK'=>$stb,
			'KDSTATUS'=>'31',
			'KEYBEND'=>session()->keybend,
			'REFF'=>$this->request->getPost('txtReff'),
			'TGLPANJAR'=>$this->request->getPost('txtTanggal'),
			'URAIAN'=>$this->request->getPost('txtUraian'),
			'UNITKEY'=>session()->kdUnit,
			'NOPANJAR'=>$this->request->getPost('txtNoPanjar')
		);
		$this->model->simpanPanjar($post);
		return redirect()->to(site_url('/bp/listPanjar'));
	}
	public function listPanjar(){
		if($this->request->getPost('keybend') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
			session()->set('keybend',$this->request->getPost('keybend'));
		}
		$data["panjar"] = $this->model->listPanjar();
		return view('bp/listPanjar',$data);
	}
	public function rinciPanjar(){
		if($this->request->getPost('nopanjar') != ''){
			session()->set('nopanjar',$this->request->getPost('nopanjar'));
		}
		$data["rinci"] = $this->model->rinciPanjar();
		return view('bp/rinciPanjar',$data);
	}
	public function updatePanjar($nopanjar,$post){
		$update = array(
			'URAIAN'=>$this->request->getPost('txtUrai')
		);
		$this->model->updatePanjar($this->request->getPost('nopanjar'),$update);
		return redirect()->to(site_url('/bp/listPanjar'));
	}
	public function hapusPanjar(){
		$this->model->hapusPanjar($this->request->getPost('nopanjar'));
		return redirect()->to(site_url('/bp/listPanjar'));
	}
	public function simpanRinciPanjar(){
		$data["rinci"] = $this->model->simpanRinciPanjar($this->request->getPost('kdkegunit'));
		return redirect()->to(site_url('/bp/rinciPanjar'));
	}
	public function listKegRinciPanjar(){
		$data["tree"] = $this->model->listKegRinciPanjar();
		return view('utama/treeViewKegCheckbox',$data);
	}
	public function updateRinciPanjar(){
		$update = array(
			'NILAI'=>$this->request->getPost('nilai')
		);
		$this->model->updateRinciPanjar($this->request->getPost('kdKeg'),$update);
		return redirect()->to(site_url('/bp/rinciPanjar'));
	}
}
