<?
	namespace App\Models;
	use CodeIgniter\Model;
  use Mssql;

	class Model_Daftar extends Model{
    private $mssql;

		public function __construct() {          
    	$this->session = session();
      $this->mssql = new Mssql();
		}

		public function listFungsi(){
			$q = "SELECT a.* FROM FUNGSI a ORDER BY a.KDFUNG";
      $rs = $this->mssql->getResult($q);

      return $rs;
		}
	}
?>