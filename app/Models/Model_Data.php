<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Data extends Model{

		public function __construct() {          
    	$this->session = session();
			$this->db = \Config\Database::connect();
		}

		public function listTahap(){
			$q = "SELECT a.* FROM TAHAP a ORDER BY cast(a.KDTAHAP as integer)";
			$rs = $this->db->query($q)->getResult();
      return $rs;
		}
		public function listBulan(){
			$q = "SELECT a.* FROM BULAN a ORDER BY cast(a.KD_BULAN as integer)";
      $rs = $this->db->query($q)->getResult();
      return $rs;
		}
		public function listTriwulan(){
			$q = "SELECT a.* FROM PERIODE a ORDER BY cast(a.KDPERIODE as integer)";
      $rs = $this->db->query($q)->getResult();
      return $rs;
		}
    public function listSetweb(){
			$q = "SELECT a.* FROM WEBSET a ORDER BY a.VALDESC";
      $rs = $this->db->query($q)->getResult();
      return $rs;
		}
	}
?>