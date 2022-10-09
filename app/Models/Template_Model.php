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

	}
?>