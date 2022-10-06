<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Menu_Model extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session=session();
		}

		///--- Grup Menu ---
		public function getGrupList(){
			$builder = $this->db->table('def_menu_grup')->orderBy('No_Urut','RANDOM')->get();
			$q = "SELECT a.*,b.subs FROM def_menu_grup a 
			LEFT JOIN (SELECT ID_Grup,COUNT(ID_Menu) as subs FROM def_menu GROUP BY ID_Grup) as b ON (b.ID_Grup = a.ID_Grup)
			ORDER BY a.No_Urut";
			return $this->db->query($q)->getResult();
		}

		public function getGrup($n){
			$builder = $this->db->table('def_menu_grup')->where('ID_Grup',$n)->get();
			return $builder->getRow();
		}
		public function getUrutGrup(){
			$builder = $this->db->table('def_menu_grup')->select('MAX(No_Urut)+1 as No_Urut')->get();
			return $builder->getRow();
		}
		public function simpanGrup($post){
			if($post["id"] == ""){
	      $q = "INSERT INTO def_menu_grup (ID_Grup,No_Urut,Nm_Grup,Icon) VALUES (?,?,?,?)";
				$query = $this->db->query($q,[$post["id"],$post["urut"],$post["nama"],$post["icon"]]);
			}else{
	      $q = "UPDATE def_menu_grup SET No_Urut = ?,Nm_Grup = ?,Icon = ? WHERE ID_Grup = ?";
				$query = $this->db->query($q,[$post["urut"],$post["nama"],$post["icon"],$post["id"]]);
			}
			return $query->getResultArray();
		}
		public function hapusGrupMenu($id){
				$builder = $this->db->table('def_menu_grup')->where('ID_Grup',$id)->delete();
		}

		///--- Menu Item ---
		public function getSubMenu($n){
			$this->session->set('grup',$n);
			$builder = $this->db->table('def_menu')->where('ID_Grup',$this->session->grup)->get();
      return $builder->getResultArray();
		}

		public function getUrutMenu(){
			$builder = $this->db->table('def_menu')->select('MAX(No_Urut)+1 as No_Urut')->where('ID_Grup',$this->session->grup)->get();
			return $builder->getRow();
		}
		public function simpanMenu($post){
			if($post["id"] == ""){
	      $q = "INSERT INTO def_menu (No_Urut,Menu,Icon,Link,ID_Grup) VALUES (?,?,?,?,?)";
				$query = $this->db->query($q,[$post["txtUrut"],$post["txtItem"],$post["txtIcon"],$post["txtLink"],$post["selGrup"]]);
			}else{
	      $q = "UPDATE def_menu SET No_Urut=?,Menu=?,Icon=?,Link=?,ID_Grup=? WHERE ID_Menu=?";
				$query = $this->db->query($q,[$post["txtUrut"],$post["txtItem"],$post["txtIcon"],$post["txtLink"],$post["selGrup"],$post["id"]]);
			}
		}
		public function getMenu($n){
			$builder = $this->db->table('def_menu')->where('ID_Menu',$n)->get();
      return $builder->getRow();
		}

		public function hapusMenu($n){
			$q1 = "DELETE FROM def_level_menu WHERE Menu = ?";
			$q2 = "DELETE FROM def_menu WHERE ID_Menu = ?";
			$this->db->transStart();
			$this->db->query($q1,[$n]);
			$this->db->query($q2,[$n]);
			$this->db->transComplete();
		}
		public function listUserOPD(){
			$q = "SELECT a.*,b.nama_skpd,c.kd_urusan,c.kd_bidang,c.kd_unit,c.kd_sub FROM def_operator a
			LEFT JOIN sipd_opd b ON (b.id_unit = a.opd)
			LEFT JOIN mapping_opd c ON (c.id_unit = a.opd)
			WHERE level != '".session()->lv."' AND level != '1'  AND level != '4'";
			return $this->db->query($q)->getResult();
		}
		public function updateUserLevel($id,$lv){
			$q = "UPDATE def_operator SET level = '".$lv."' WHERE id = '".$id."'";
			$this->db->query($q);
			//return $this->db->query($q)->getResult();
		}

		///User - Operator
		public function getUserList(){
			$builder = $this->db->table('def_operator a');
			$builder->select('a.*,b.Level as KetLevel,c.nama_skpd')->join('def_level b','b.ID_Level = a.Level','left');
			$builder->join('sipd_opd c','c.id_unit = a.opd','left');
			return $builder->get()->getResult();
		}
		public function getUser($id){
			$builder = $this->db->table('def_operator')->where('id',$id);
      return $builder->get()->getRow();
		}
		public function simpanUser($post){
			if($post["id"] == ""){
				$builder = $this->db->table('def_operator');
				$data = [
					'nama' => $post["nama"],
					'username' => $post['username'],
					'password' => md5($post['password']),
					'level' => $post['level'],
					'opd' => $post['opd']
				];
	      $builder->insert($data);
			}else{
				$builder = $this->db->table('def_operator');
				$builder->set('nama',$post["nama"]);
				$builder->set('username',$post["username"]);
				if($post["password"] != ''){
					$builder->set('password',$post["password"]);
				}
				$builder->set('opd',$post["opd"]);
				$builder->set('level',$post["level"])->where('id',$post['id'])->update();
			}
		}
		public function hapusUser($n){
			$builder = $this->db->table('def_operator');
			$builder->where('ID',$n)->delete();
		}
		public function listSatker(){
			$builder = $this->db->table('def_operator_satker')->where('id',session()->app_uid);
			return $builder->get()->getResult();
		}
		public function satkerAdd($post){
			if($post['st'] == 'add'){
				$data = [
					'id' => session()->app_uid,
					'opd' => $post['satker'],
				];
				$this->db->table('def_operator_satker')->insert($data);
			}else{
				$this->db->table('def_operator_satker')->where('id',session()->app_uid)->where('opd',$post['satker'])->delete();
			}
		}
		public function listOPD(){
			$q = "SELECT a.*,ifnull(b.jumlah,'0') as jumlah FROM sipd_opd a
			LEFT JOIN (
				SELECT opd,COUNT(opd) as jumlah FROM def_operator GROUP BY opd
			) b ON (b.opd = a.id_unit)";
			return $this->db->query($q)->getResult();
		}

		///-- Level Operator
		public function getLevelList(){
			$builder = $this->db->table('def_level');
			$builder->select('*');
			return $builder->get()->getResult();
		}
		public function getLevel($n){
			$builder = $this->db->table('def_level');
			$builder->select('*')->where('ID_Level',$n);	
			return $builder->get()->getRow();
		}
		public function aksesLevelUser(){
			$q = "SELECT a.*,b.nama_skpd,c.kd_urusan,c.kd_bidang,c.kd_unit,c.kd_sub FROM def_operator a
			LEFT JOIN sipd_opd b ON (b.id_unit = a.opd)
			LEFT JOIN mapping_opd c ON (c.id_unit = a.opd)
			WHERE level = '".session()->lv."'";
			return $this->db->query($q)->getResult();
		}
		public function simpanLevel($post){
			if($post["id"] == ""){
				$builder = $this->db->table('def_level');
				$data = [
					'Level' => $post['level']
				];
	      $builder->insert($data);
			}else{
				$builder = $this->db->table('def_level');
				$builder->set('Level',$post["level"])->where('ID_Level',$post['id'])->update();
			}
		}
		public function hapusLevel($n){
			$builder = $this->db->table('def_level_menu');
			$builder->where('ID',$n)->delete();

			$builder = $this->db->table('def_level');
			$builder->where('ID_Level',$n)->delete();
		}
		public function aksesLevelList($n){
			$this->session->set('grup',$n);
			$builder = $this->db->table('def_level_menu a');
			$builder->select('a.*,b.Menu as Nm_Menu,b.ID_Grup,c.Nm_Grup')->join('def_menu b','b.ID_Menu = a.Menu','left');
			$builder->join('def_menu_grup c','c.ID_Grup = b.ID_Grup','left')->where('ID',$n)->orderBy('b.ID_Grup','ASC');
			return $builder->get()->getResult();
		}
		public function aksesLevelListGrup(){
			$builder = $this->db->table('def_level_menu')->select('Menu')->where('ID',$this->session->grup);
			$data = $builder->get()->getResult();
			$notIn = array('99999');
			foreach ($data as $h) {
				array_push($notIn,$h->Menu);
			}

			$builder = $this->db->table('def_menu a');
			$builder->select('a.*,b.Nm_Grup')->join('def_menu_grup b','b.ID_Grup = a.ID_Grup','left')->whereNotIn('a.ID_Menu',$notIn);
			$builder->orderBy('a.ID_Grup','ASC');
			return $builder->get()->getResult();
		}
		public function tambahAksesLevel($mnuList){
			$builder = $this->db->table('def_level_menu');
			$mnu = explode("__",$mnuList);
			for($i=0;$i<sizeof($mnu);$i++){
				$data = [
					'ID' => $this->session->grup,
					'Menu' => $mnu[$i]
				];
	      $builder->insert($data);
	    }
	    return $this->db->affectedRows();
		}
		public function hapusAksesLevel($mnu){
			$builder = $this->db->table('def_level_menu');
			$builder->where('ID',$this->session->grup)->where('Menu',$mnu)->delete();
	    return $this->db->affectedRows();
		}

		///-- Setting Data SIPD
		public function getSetting(){
			$builder = $this->db->table('def_level');
			$builder->select('*');
			return $builder->get()->getResult();
		}

		public function phpinfo(){
			return view('simda/phpinfo');		
		}

			///--- Kelompok Data ---
		public function getKelompokData(){
			$builder = $this->db->table('ta_kelompok')->get();
			return $builder->getResult();
		}
		public function getKelompok($id){
			$builder = $this->db->table('ta_kelompok')->where('no_id',$id)->get();
			return $builder->getRow();
		}
		public function simpanKelompok($post){
			if($post["id"] == ""){
	      $q = "INSERT INTO ta_kelompok (keterangan) VALUES (?)";
				$query = $this->db->query($q,[$post["nama"]]);
			}else{
	      $q = "UPDATE ta_kelompok SET keterangan = ? WHERE no_id = ?";
				$query = $this->db->query($q,[$post["nama"],$post["id"]]);
			}
			return $query->getResultArray();
		}
	}
?>