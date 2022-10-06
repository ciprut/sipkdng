<?php namespace App\Models;

use CodeIgniter\Model;
//use modelUntukSIPKD;

class Model_Login extends Model{
  //private $simda;

	public function __construct()
	{
    $this->db = \Config\Database::connect();
    $this->session=session();
    //$this->simda = new modelUntukSIPKD();
  }
	
	public function login($post){
    $q = "SELECT a.* FROM def_operator a 
    WHERE username = ? AND password = ?";
    $data = $this->db->query($q,[$post["username"],MD5($post["password"])])->getRow();

    return $data;
  }

  public function logout($post)
  {
    session()->remove('username');
		return redirect()->to('/login');
  }

  public function menu(){
    $q = "SELECT a.*,
    b.Menu as Nama_Menu,b.ID_Grup,b.Icon,b.Link,b.No_Urut,
    c.Nm_Grup,c.ID_Grup,c.No_Urut as Urut_Grup,c.Icon as IconGrup
    FROM def_level_menu a 
          LEFT JOIN def_menu b ON (b.ID_Menu = a.Menu)
                    LEFT JOIN def_menu_grup c ON (c.ID_Grup = b.ID_Grup)
          WHERE a.ID = ?
          ORDER BY c.ID_Grup,b.No_Urut";
    $rs = $this->db->query($q,[$this->session->level])->getResult();

    return $rs;
  }

  public function listSatkerUser($id=null){
    if($id != null){
      $q = "SELECT COUNT(menu) as akses FROM def_level_menu WHERE id = '".session()->level."' AND menu = '".$id."'";
      $j = $this->db->query($q)->getRow();

      if($j->akses > 0){
      }else{
        echo 'Menu ditutup sementara. Silahkan kembali.';die();
      }
    }else{
    }
  }

  public function getUser()
  {
    $q = "SELECT a.*,b.kode_skpd,b.nama_skpd,b.skpd FROM def_operator a LEFT JOIN sipd_opd b ON (b.id_unit = a.opd)
    WHERE id = ?";
    $data = $this->db->query($q,[session()->operator_id])->getRow();
    return $data;
  }

}