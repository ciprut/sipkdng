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

		///-- Setting Data SIPD
		public function listFungsi(){
			$q = "SELECT a.* FROM FUNGSI a ORDER BY a.KDFUNG";
      $rs = $this->mssql->getResult($q);

      return $rs;
		}
		public function saveSetting($post){
			$builder = $this->db->table('def_setting_sipd');
			$builder->set('tahun',$post["tahun"]);
			$builder->set('id_daerah',$post['idDaerah']);
			$builder->set('nama_daerah',$post['nama'])->update();
		}

	}
?>