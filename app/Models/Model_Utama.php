<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Utama extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
		}

		public function listBidang(){
			$builder = $this->db->table('DAFTUNIT');
			$builder->select('*')->where('KDLEVEL','2')->orderBy('KDUNIT','ASC');
			return $builder->get()->getResult();
		}

    public function listUnit(){
			$builder = $this->db->table('DAFTUNIT');
			$builder->select('*')->where("KDLEVEL >","2")->like('KDUNIT',session()->kdBidang.'%','after')->orderBy('KDUNIT','ASC');

      $rs = $builder->get()->getResult();
			return $rs;
		}

		public function listBendahara($jns= null){
			$builder = $this->db->table('BEND a');
			$builder->select('rtrim(a.KEYBEND) as KEYBEND,a.JNS_BEND, a.NIP, a.KDBANK, a.UNITKEY, a.JAB_BEND, a.REKBEND, a.SALDOBEND,a.SALDOBENDT, a.NPWPBEND, a.TGLSTOPBEND,');
      $builder->select("rtrim(b.KDUNIT) as KDUNIT, rtrim(b.NMUNIT) as NMUNIT, c.NAMA,(rtrim(a.NIP)+' - '+ rtrim(c.NAMA)) as NIPNAMA, c.JABATAN,d.URAI_BEND");
      $builder->join('DAFTUNIT b','b.UNITKEY = a.UNITKEY','left');
      $builder->join('PEGAWAI c','c.NIP = a.NIP','left');
      $builder->join('JBEND d','d.JNS_BEND = a.JNS_BEND','left');
      $builder->where("a.UNITKEY",session()->kdUnit);
			if($jns != null){
				$builder->where("a.JNS_BEND",$jns);
			}
      $builder->orderBy('a.JNS_BEND','ASC');
//      echo $builder->getCompiledSelect();die();
      $rs = $builder->get()->getResult();
			return $rs;
		}

		public function getTahap(){
			$builder = $this->db->table('WEBUSER');
			$rs = $builder->select('*')->get()->getRow();
			return $rs->KDTAHAP;
		}
		public function getNextkey($tabel){
			$builder = $this->db->table('NEXTKEY');
			$builder->select('NEXTKEY')->where('TABLEID',$tabel);
			$rs = $builder->get()->getRow();
			return $rs->NEXTKEY;
		}

		public function getNoRegSPP(){
			$builder = $this->db->table('SPP');
			$builder->select('top 1 NOREG')->where('UNITKEY',session()->kdUnit)->orderBy('NOREG','DESC');
			$rs = $builder->get()->getRow();
			return $rs->NOREG;
		}
		public function getNoSPP(){
			$builder = $this->db->table('SPP');
			$builder->select('top 1 ISNULL(NOSPP,0) as NOSPP')->where('UNITKEY',session()->kdUnit)->where('KEYBEND',session()->keybend)->orderBy('NOSPP','DESC');
			$rs = $builder->get()->getRow();
			return ($rs->NOSPP+0)+1;
		}

	}
?>