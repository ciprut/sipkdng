<?php namespace App\Controllers;

use App\Models\Model_Bud;
use App\Models\Model_Utama;
//use App\Models\Model_Login;

class Bud extends BaseController
{
	public function __construct(){
		$this->utama = new Model_Utama;
		$this->model = new Model_Bud;
		//$this->sidebar = new Model_Login;
		$this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	public function sp2d(){
		$data["title"] = "PEMBUATAN SP2D";
    session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    $data["satker"] = $this->utama->listBidang();
    return view('bud/sp2d',$data);
	}
  public function listSP2D(){
    if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
			session()->set('jns',$this->request->getPost('jns'));
		}
		$jns = $this->request->getPost('jns');
		$params = array(
			"up"=>array("Idxkode"=>"6","jnsSp2d"=>"up","kdStatus"=>"21","keperluan"=>"uraisp2dup","jnsBend"=>"02","format"=>"frmtsp2d"),
			"gu"=>array("Idxkode"=>"2","jnsSp2d"=>"gu","kdStatus"=>"22","keperluan"=>"uraisp2dgu","jnsBend"=>"02","format"=>"frmtsp2d"),
			"tu"=>array("Idxkode"=>"2","jnsSp2d"=>"tu","kdStatus"=>"23","keperluan"=>"uraisp2dtu","jnsBend"=>"02","format"=>"frmtsp2d"),
			"ls"=>array("Idxkode"=>"2","jnsSp2d"=>"ls","kdStatus"=>"24,25","keperluan"=>"uraisp2dls","jnsBend"=>"02","format"=>"frmtsp2d")
		);
		session()->set('jnsSp2d',$params[$jns]['jnsSp2d']);
		session()->set('Idxkode',$params[$jns]['Idxkode']);
		session()->set('kdStatus',$params[$jns]['kdStatus']);
		session()->set('keperluan',$params[$jns]['keperluan']);
		session()->set('jnsBend',$params[$jns]['jnsBend']);
		session()->set('format',$params[$jns]['format']);
		//}
		if($session->jnsSp2d == "ls"){
			$data["sp2d"] = $this->model->listSP2DLS();
		}else{
			$data["sp2d"] = $this->model->listSP2D();
		}
    return view('bud/listSP2D',$data);
	}
	public function spmList(){
		$data["spm"] = $this->model->spmList($this->request->getPost('tanggal'));
//		$data['bendahara'] = $this->model->bendaharaSPM();
//		$data['ttd'] = $this->model->ttdSP2D();
		return view('bud/spmList',$data);
	}
	public function rekList(){
		$data["rek"] = $this->utama->listRekBUD();
		return view('bud/rekList',$data);
	}
  public function rincianSP2D(){
    if($this->request->getPost('nosp2d') != ''){
			session()->set('nosp2d',$this->request->getPost('nosp2d'));
		}

		$data["rinci"] = $this->model->rincianSP2D();
		return view('bud/rincianSP2D',$data);
	}
  public function formSP2D(){
		session()->set('nosp2d','');
		if($this->request->getPost('nosp2d') != ''){
			session()->set('nosp2d',$this->request->getPost('nosp2d'));
		}
		$data['noreg'] = $this->utama->getNoRegSP2D();
		$data['unit'] = $this->utama->getUnit();
		$data['format'] = $this->utama->getWebset(session()->format);
		$data['keperluan'] = $this->utama->getWebset(session()->keperluan);
		$data['rekening'] = $this->utama->listRekBUD();
		$data['sp2d'] = $this->model->getSP2D(session()->nosp2d);
		return view('bud/formSP2D',$data);
	}
	public function formSP2DSetuju(){
		if($this->request->getPost('nosp2d') != ''){
			session()->set('nosp2d',$this->request->getPost('nosp2d'));
		}
		$data['sp2d'] = $this->model->getSP2D(session()->nosp2d);
		return view('bud/formSP2DSetuju',$data);
	}
	public function setujuSP2D(){
		$data = array(
			"PENOLAKAN"=>$this->request->getPost('txtPenolakan'),
			"TGLVALID"=>$this->request->getPost('txtTanggalValid')
		);
		$this->model->setujuSP2D($data);

		return redirect()->to(site_url('/bud/listSP2D'));
	}
	public function simpanSP2D(){
    if($this->request->getPost('id') == ''){
      $data = array(
				"NOSP2D"=>$this->request->getPost('txtNoSP2D'),
				"NOSPM"=>$this->request->getPost('txtSPM'),
				"IDXTTD"=>$this->request->getPost('idxttd'),
				"NOBBANTU"=>trim($this->request->getPost('nobbantu')),
				"NOREG"=>$this->request->getPost('txtNoReg'),
				"KEPERLUAN"=>$this->request->getPost('txtUntuk'),
        "TGLSP2D"=>$this->request->getPost('txtTanggal')
      );
      $this->model->simpanSP2D($data);
    }else{
			session()->set('nosp2d',$this->request->getPost('id'));
      $data = array(
				"NOSP2D"=>$this->request->getPost('txtNoSP2D'),
				"NOSPM"=>$this->request->getPost('txtSPM'),
				"IDXTTD"=>$this->request->getPost('idxttd'),
				"NOBBANTU"=>trim($this->request->getPost('nobbantu')),
				"NOREG"=>$this->request->getPost('txtNoReg'),
				"KEPERLUAN"=>$this->request->getPost('txtUntuk'),
        "TGLSP2D"=>$this->request->getPost('txtTanggal')
      );
      $this->model->simpanSP2D($data);
    }
		return redirect()->to(site_url('/bud/listSP2D'));
	}

	/*========================= VALIDASI KASDA ============================*/
	public function validasiKasda(){
		$data["title"] = "Validasi Kasda";
    session()->set('tahap',$this->utama->getTahap());
		//$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    return view('bud/valKasda',$data);
	}
	public function listValidasi(){
		if($this->request->getPost('jnsBUD') != ''){
			session()->set('jns',$this->request->getPost('jnsBUD'));
		}
		$data = array(
			"NOBBANTU"=>$this->request->getPost('nobbantu'),
			"TGL1"=>$this->request->getPost('txtTglMulai'),
			"TGL2"=>$this->request->getPost('txtTglSsampai')
		);
		$data['valid'] = $this->model->listValidasi($data);

		return view('bud/listValidasi',$data);
	}
	public function formValidasi(){
		session()->set('nobbantu','');
		if($this->request->getPost('nobbantu') != ''){
			session()->set('nobbantu',trim($this->request->getPost('nobbantu')));
		}
		$data['bantu'] = $this->utama->getNobbantu($this->request->getPost('nobbantu'));
		$data['noreg'] = $this->utama->getNoReg('BKUK','NOBUKAS','all');
		$data['idxttd'] = $this->utama->getIdxttd('04.501');
		return view('bud/formValidasi',$data);
	}
	public function sp2dList(){
		$data["sp2d"] = $this->model->sp2dList($this->request->getPost('tanggal'));
		return view('bud/sp2dList',$data);
	}
	public function simpanValidasi(){
		session()->set('nobukas','');
    if($this->request->getPost('id') == ''){
      $data = array(
				"KDBUKTI"=>trim($this->request->getPost('txtJenisBukti')),
				"IDXTTD"=>trim($this->request->getPost('idxttd')),
				"NOBUKTIKAS"=>trim($this->request->getPost('txtNoBuktiVal')),
				"NOSP2D"=>trim($this->request->getPost('txtNoSP2D')),
				"TGLKAS"=>trim($this->request->getPost('txtTanggalVal')),
				"NOBUKAS"=>trim($this->request->getPost('txtNoVal'))
      );
      $this->model->simpanValidasi($data);
    }else{
			session()->set('nobukas',$this->request->getPost('id'));
      $data = array(
				"KDBUKTI"=>trim($this->request->getPost('txtJenisBukti')),
				"IDXTTD"=>trim($this->request->getPost('idxttd')),
				"NOBUKTIKAS"=>trim($this->request->getPost('txtNoBuktiVal')),
				"NOSP2D"=>trim($this->request->getPost('txtNoSP2D')),
				"TGLKAS"=>trim($this->request->getPost('txtTanggalVal')),
				"NOBUKAS"=>trim($this->request->getPost('txtNoVal'))
      );
      $this->model->simpanValidasi($data);
    }
		return redirect()->to(site_url('/bud/listValidasi'));
	}
	public function rincianValSP2D(){
    if($this->request->getPost('nosp2d') != ''){
			session()->set('nosp2d',$this->request->getPost('nosp2d'));
		}

		$data["rinci"] = $this->model->rincianValSP2D();
		return view('bud/rincianValSP2D',$data);
	}

}
