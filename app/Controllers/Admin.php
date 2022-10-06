<?php namespace App\Controllers;

use App\Models\Menu_Model;
use App\Models\Model_Login;

class Admin extends BaseController
{
	public function __construct(){
		$this->model=new Menu_Model;
		$this->sidebar=new Model_Login;
		$this->session = session();
	}
	public function index()
	{
		return redirect()->to(site_url('menu'));
	}

	///--- Grup Menu ---
	public function menu(){
		$data["title"] = "Administrator - Menu";
		$data["sidebar"] = $this->sidebar->menu();
		$data["grup"] = $this->model->getGrupList();
		$data['opd'] = $this->sidebar->listSatkerUser("1");
		return view('admin-menu/menu',$data);
	}

	public function menuDetil($param){
		$data["submenu"] = $this->model->getSubMenu($param);
		return view('admin-menu/menu_item',$data);
	}

	public function formgrup($param=NULL)
	{
		if(is_null($param)){
			$data["grup"] = $this->model->getUrutGrup();
			return view('admin-menu/menu_grup_form',$data);
		}else{
			$data["grup"] = $this->model->getGrup($param);
			return view('admin-menu/menu_grup_form',$data);
		}
	}
	public function simpanGrup(){
		$data = array(
			"id"=>$this->request->getPost('id'),
			"urut"=>$this->request->getPost('txtUrut'),
			"nama"=>$this->request->getPost('txtGrup'),
			"icon"=>$this->request->getPost('txtIcon')
		);
		$data = $this->model->simpanGrup($data);
		return redirect()->to(site_url('/admin/menu'));
	}

	public function hapusGrup($param){
		$this->model->hapusGrupMenu($param);
		return redirect()->to(site_url('/admin/menu'));
	}

	///--- Menu Items ---
	public function frmMenu($param=NULL)
	{
		$data["grup"] = $this->model->getGrupList();
		if(is_null($param)){
			$data["submenu"] = $this->model->getUrutMenu();
			return view('admin-menu/menu_item_form',$data);
		}else{
			$data["submenu"] = $this->model->getMenu($param);
			return view('admin-menu/menu_item_form',$data);
		}
	}
	public function simpanMenu(){
		$data = array(
			"id"=>$this->request->getPost('id'),
			"txtUrut"=>$this->request->getPost('txtUrut'),
			"txtItem"=>$this->request->getPost('txtItem'),
			"selGrup"=>$this->request->getPost('selGrup'),
			"txtLink"=>$this->request->getPost('txtLink'),
			"txtIcon"=>$this->request->getPost('txtIcon')
		);
		$this->model->simpanMenu($data);
		return redirect()->to(site_url('/admin/menuDetil/'.$this->session->grup));
	}
	public function hapusMenu($param){
		$this->model->hapusMenu($param);
		return redirect()->to(site_url('/admin/menuDetil/'.$this->session->grup));
	}

	///--- Pengguna ---
	public function pengguna(){
		$data["title"] = "Administrator - Operator";
		$data["sidebar"] = $this->sidebar->menu();
		$data['opd'] = $this->sidebar->listSatkerUser();
		$data["user"] = $this->model->getUserList();
		return view('admin-menu/pengguna',$data);
	}
	public function listSatker(){
		if(!is_null($this->request->getPost('id'))){
			session()->set('app_uid',$this->request->getPost('id'));
		}
		$data['satker'] = $this->model->listSatker();
		$data['opd'] = $this->model->listOPD();
		return view('admin-menu/listSatker',$data);
	}
	public function listNewUser(){
		$data['opd'] = $this->model->listOPD();
		return view('admin-menu/listNewUser',$data);
	}
	public function satkerAdd(){
		$post = [
			'satker' => $this->request->getPost('satker'),
			'st' => $this->request->getPost('st')
		];
		$this->model->satkerAdd($post);
		return redirect() ->to(site_url('admin/listSatker'));
	}
	public function formPengguna($param=NULL)
	{
		$data["level"] = $this->model->getLevelList();
		$data["opd"] = $this->model->listOPD();
		if(is_null($param)){
			$data["user"] = "";
			$data["params"] = $this->request->getPost('params');
//			echo "params : ".$this->request->getPost('params');die();
			return view('admin-menu/pengguna_form',$data);
		}else{
			$data["user"] = $this->model->getUser($param);
			return view('admin-menu/pengguna_form',$data);
		}
	}
	public function simpanPengguna(){
		$post = array(
			"id"=>$this->request->getPost('id'),
			"nama"=>$this->request->getPost('txtNama'),
			"username"=>$this->request->getPost('txtUsername'),
			"password"=>$this->request->getPost('txtPassword'),
			"level"=>$this->request->getPost('selLevel'),
			"opd"=>$this->request->getPost('selOPD')
		);
		$this->model->simpanUser($post);
		return redirect()->to(site_url('/admin/pengguna'));
	}
	public function hapusPengguna($param){
		$this->model->hapusUser($param);
		return redirect()->to(site_url('/admin/pengguna'));
	}

	/// --- Level Menu ---
	public function level(){
		$data["title"] = "Administrator - Level";
		$data["sidebar"] = $this->sidebar->menu();
		$data['opd'] = $this->sidebar->listSatkerUser();
		$data["level"] = $this->model->getLevelList();
		return view('admin-menu/level',$data);
	}
	public function levelForm()
	{
		$param = $this->request->getPost('id');
		$action = $this->request->getPost('action');

		if($action == 'baru'){
			$data["level"] = "";
			return view('admin-menu/level_form',$data);
		}else{
			$data["level"] = $this->model->getLevel($param);
			return view('admin-menu/level_form',$data);
		}
	}
	public function simpanLevel(){
		$post = array(
			"id"=>$this->request->getPost('id'),
			"level"=>$this->request->getPost('txtLevel')
		);
		$this->model->simpanLevel($post);
		return redirect()->to(site_url('/admin/level'));
	}
	public function hapusLevel($param){
		$this->model->hapusLevel($param);
		return redirect()->to(site_url('/admin/level'));
	}
	public function levelAkses(){
		if(!is_null($this->request->getPost('id'))){
			$id = $this->request->getPost('id');
		}else{
			$id = $this->session->grup;
		}
		$data["akses"] = $this->model->aksesLevelList($id);
		return view('admin-menu/list_level_akses',$data);
	}
	public function levelUser(){
		if(!is_null($this->request->getPost('id'))){
			session()->set('lv',$this->request->getPost('id'));
		}
		$data["user"] = $this->model->aksesLevelUser();
		return view('admin-menu/list_level_user',$data);
	}
	public function listUserLevel(){
		$data["user"] = $this->model->listUserOPD();
		return view('admin-menu/listUserOPD',$data);
	}
	public function updateUserLevel(){
		$this->model->updateUserLevel($this->request->getPost('id'),session()->lv);
		return redirect()->to(site_url('admin/levelUser'));
	}
	public function btnHapusUserLevel(){
		$this->model->updateUserLevel($this->request->getPost('id'),'2');
		return redirect()->to(site_url('admin/levelUser'));
	}

	public function listAksesLevel(){
		$data["aksesgrup"] = $this->model->aksesLevelListGrup();
		return view('admin-menu/list_menu_item',$data);
	}
	public function tambahAksesLevel(){
		$mnu = $this->request->getPost("menu");
		$this->model->tambahAksesLevel($mnu);
		$data["akses"] = $this->model->aksesLevelList($this->session->grup);
		return view('admin-menu/list_level_akses',$data);
	}
	public function hapusAksesLevel(){
		$mnu = $this->request->getPost("id");
		$this->model->hapusAksesLevel($mnu);
		$data["akses"] = $this->model->aksesLevelList($this->session->grup);
		return view('admin-menu/list_level_akses',$data);
	}
	public function phpinfo(){
		return view('simda/phpinfo');
	}

	///--- Grup Menu ---
	public function toolkit(){
		$data["title"] = "Administrator - Toolkit";
		$data["sidebar"] = $this->sidebar->menu();
		$data['opd'] = $this->sidebar->listSatkerUser();
		return view('admin-menu/toolkit',$data);
	}

	///--- Kelompok Data ---
	public function data(){
		$data["title"] = "Administrator - Kelompok Data";
		$data["sidebar"] = $this->sidebar->menu();
		$data['opd'] = $this->sidebar->listSatkerUser();
		$data["kelompok"] = $this->model->getKelompokData();
		return view('admin-menu/kelompok',$data);
	}
	public function formKel($param=NULL)
	{
		if(is_null($param)){
			$data["kelompok"] = $this->model->getUrutGrup();
			return view('admin-menu/formKelompok',$data);
		}else{
			$data["kelompok"] = $this->model->getKelompok($param);
			return view('admin-menu/formKelompok',$data);
		}
	}
	public function simpanKelompok(){
		$data = array(
			"id"=>$this->request->getPost('id'),
			"nama"=>$this->request->getPost('txtGrup')
		);
		$data = $this->model->simpanKelompok($data);
		return redirect()->to(site_url('/admin/data'));
	}
}
