<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Data extends Model{

		public function __construct() {          
    	$this->session = session();
			$this->db = \Config\Database::connect();
		}

		public function listData($data){
			switch ($data) {
				case "TAHAP":
					$q = "SELECT a.* FROM TAHAP a ORDER BY cast(a.KDTAHAP as integer)";
					break;
				case "BULAN":
					$q = "SELECT a.* FROM BULAN a ORDER BY cast(a.KD_BULAN as integer)";
					break;
				case "PERIODE":
					$q = "SELECT a.* FROM PERIODE a ORDER BY cast(a.KDPERIODE as integer)";
					break;
				case "WEBSET":
					$q = "SELECT a.* FROM WEBSET a ORDER BY a.VALDESC";
					break;
				case "NEXTKEY":
					$q = "SELECT a.* FROM NEXTKEY a ORDER BY a.TABLEID";
					break;
				default:
					echo "error";
					die();
			}
			$rs = $this->db->query($q)->getResult();
      return $rs;
		}
	}
?>