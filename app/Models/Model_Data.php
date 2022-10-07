<?
	namespace App\Models;
	use CodeIgniter\Model;
  use Mssql;

	class Model_Data extends Model{
    private $mssql;

		public function __construct() {          
    	$this->session = session();
      $this->mssql = new Mssql();
		}

		public function listTahap(){
			$q = "SELECT a.* FROM TAHAP a ORDER BY cast(a.KDTAHAP as integer)";
      $rs = $this->mssql->getResult($q);
      return $rs;
		}
		public function listBulan(){
			$q = "SELECT a.* FROM BULAN a ORDER BY cast(a.KD_BULAN as integer)";
      $rs = $this->mssql->getResult($q);
      return $rs;
		}
	}
?>