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
  public function pegawaiList(){
    $data["pegawai"] = $this->data->listPegawai();
		return view('pengaturan/pegawaiList',$data);
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
  public function formBendahara(){
    session()->set('nip','');
    session()->set('keybend','');
    if($this->request->getPost('nip') != ''){
			session()->set('nip',$this->request->getPost('nip'));
		}
    if($this->request->getPost('keybend') != ''){
			session()->set('keybend',$this->request->getPost('keybend'));
		}
    //$data["pegawai"] = $this->data->getPegawai(session()->nip);
    $data["bendahara"] = $this->data->getBendahara(session()->keybend);
    $data["jbend"] = $this->data->listJenisBendahara();
    $data["bank"] = $this->data->listBank();
		return view('pengaturan/formBendahara',$data);
	}
  public function simpanBendahara(){
    if($this->request->getPost('id') == ''){
      $data = array(
        "KEYBEND"=>"CAST((CAST(SUBSTRING(CAST(rtrim(KEYBEND) AS varchar),1,(LEN(rtrim(KEYBEND))-1)) AS INT)+1 ) AS VARCHAR) + CAST('_' AS VARCHAR)",
        "JNS_BEND"=>$this->request->getPost('txtJBend'),
        "NIP"=>$this->request->getPost('txtNIP'),
        "KDBANK"=>$this->request->getPost('txtBank'),
        "UNITKEY"=>session()->kdUnit,
        "JAB_BEND"=>$this->request->getPost('txtBKU'),
        "REKBEND"=>$this->request->getPost('txtRek'),
        "SALDOBEND"=>$this->request->getPost('txtSBank'),
        "NPWPBEND"=>$this->request->getPost('txtNPWP'),
        "SALDOBENDT"=>$this->request->getPost('txtSTunai'),
        "NOREK"=>$this->request->getPost('txtRek')
      );
      $this->data->simpanBendahara($data);
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
      $this->data->simpanBendahara($data);
    }
		return redirect()->to(site_url('/pengaturan/listBendahara'));
	}
  public function hapusBendahara(){
    $kb = $this->request->getPost('keybend');
    $this->data->hapusBendahara($kb);
		return redirect()->to(site_url('/pengaturan/listBendahara'));
	}

  public function pa(){
		$data["title"] = "Pengaturan - Pengguna Anggaran";
//		$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    $data["satker"] = $this->data->listBidang();
    return view('pengaturan/penggunaAnggaran',$data);
	}
  public function listPA(){
    if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
    $data["pa"] = $this->data->listPA();
		return view('pengaturan/listPA',$data);
	}
  public function formPA(){
    session()->set('nip','');
    if($this->request->getPost('nip') != ''){
			session()->set('nip',$this->request->getPost('nip'));
		}
    $data["pegawai"] = $this->data->getPegawai(session()->nip);
		return view('pengaturan/formPA',$data);
	}
  public function simpanPA(){
    if($this->request->getPost('id') == ''){
      $data = array(
        "UNITKEY"=>session()->kdUnit,
        "NIP"=>$this->request->getPost('txtNIP')
      );
      $this->data->simpanPA($data);
    }else{
      $data = array(
        "NIP"=>$this->request->getPost('txtNIP')
      );
      $this->data->simpanPA($data);
    }
		return redirect()->to(site_url('/pengaturan/listPA'));
	}
  public function hapusPA(){
    $nip = $this->request->getPost('nip');
    $this->data->hapusPA($nip);
		return redirect()->to(site_url('/pengaturan/listPA'));
	}

  public function kpa(){
		$data["title"] = "Pengaturan - Kuasa Pengguna Anggaran";
//		$data["sidebar"] = $this->sidebar->menu();
		$data["menu"] = file_get_contents("./public/".session()->modul.".json");

    $data["satker"] = $this->data->listBidang();
    return view('pengaturan/kpenggunaAnggaran',$data);
	}
  public function listKPA(){
    if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
    $data["pa"] = $this->data->listKPA();
		return view('pengaturan/listKPA',$data);
	}
  public function formKPA(){
    session()->set('nip','');
    if($this->request->getPost('nip') != ''){
			session()->set('nip',$this->request->getPost('nip'));
		}
    $data["pegawai"] = $this->data->getKPA(session()->nip);
		return view('pengaturan/formKPA',$data);
	}
  public function simpanKPA(){
    if($this->request->getPost('id') == ''){
      $data = array(
        "UNITKEY"=>session()->kdUnit,
        "JABATAN"=>$this->request->getPost('txtJabatan'),
        "NIP"=>$this->request->getPost('txtNIP')
      );
      $this->data->simpanKPA($data);
    }else{
      $data = array(
        "JABATAN"=>$this->request->getPost('txtJabatan')
      );
      $this->data->simpanKPA($data);
    }
		return redirect()->to(site_url('/pengaturan/listKPA'));
	}
  public function hapusKPA(){
    $nip = $this->request->getPost('nip');
    $this->data->hapusPA($nip);
		return redirect()->to(site_url('/pengaturan/listKPA'));
	}

}
