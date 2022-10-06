<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Daring_Model extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
		}

		///-- Setting Data SIPD
		public function getSetting(){
			$builder = $this->db->table('def_setting_sipd');
			$builder->select('*');
			return $builder->get()->getRow();
		}
		public function saveSetting($post){
			$builder = $this->db->table('def_setting_sipd');
			$builder->set('tahun',$post["tahun"]);
			$builder->set('id_daerah',$post['idDaerah']);
			$builder->set('nama_daerah',$post['nama'])->update();
		}

	}
?>