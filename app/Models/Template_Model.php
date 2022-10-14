<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Daring_Model extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
		}

		public function getSetting(){
			$builder = $this->db->table('def_setting_sipd');
			$builder->select('*');
			return $builder->get()->getRow();
		}
		public function simpanNSUP($post){
      if(session()->edit == ""){
        $builder = $this->db->table('PEGAWAI');
        $builder->set($post);
        $builder->insert($post);
      }else{
        $builder = $this->db->table('NSKUP');
        $builder->where('UNITKEY',session()->edit)->update($post);
      }
			return;
		}

	}
?>