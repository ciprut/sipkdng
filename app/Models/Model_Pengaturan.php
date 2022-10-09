<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Pengaturan extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
		}

		///-- Setting Data SIPD
		public function listBidang(){
			$builder = $this->db->table('DAFTUNIT');
			$builder->select('*')->where('KDLEVEL','2')->orderBy('KDUNIT','ASC');
			return $builder->get()->getResult();
		}

    public function listUnit(){
			$builder = $this->db->table('DAFTUNIT');
			$builder->select('*')->where("KDLEVEL >","2")->like('KDUNIT',session()->kdBidang.'%','after')->orderBy('KDUNIT','ASC');

//      $sql = $builder->getCompiledSelect();
//      echo $sql;die();
      $rs = $builder->get()->getResult();
			return $rs;
		}
    public function listPegawai(){
			$builder = $this->db->table('PEGAWAI a');
			$builder->select('a.NIP,a.KDGOL,a.NAMA,b.NMGOL,b.PANGKAT,a.JABATAN')->where("a.UNITKEY",session()->kdUnit);
      $builder->join('GOLONGAN b','b.KDGOL = a.KDGOL','left');
      $builder->orderBy('a.KDGOL','ASC');

      $rs = $builder->get()->getResult();
			return $rs;
		}

	}
?>