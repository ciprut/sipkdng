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
    public function listGolongan(){
			$builder = $this->db->table('GOLONGAN');
			$builder->select('*');

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
    public function getPegawai($nip){
			$builder = $this->db->table('PEGAWAI a');
			$builder->select('a.*')->where("a.UNITKEY",session()->kdUnit)->where("a.NIP",$nip);
      $builder->join('GOLONGAN b','b.KDGOL = a.KDGOL','left');
      $builder->orderBy('a.KDGOL','ASC');

      $rs = $builder->get()->getRow();
			return $rs;
		}
    public function simpanPegawai($post){
      if(session()->nip == ""){
        $builder = $this->db->table('PEGAWAI');
        $builder->set($post);
        $builder->insert($post);
      }else{
        $builder = $this->db->table('PEGAWAI');
        $builder->where('NIP',session()->nip)->update($post);
      }
			return;
		}
    public function hapusPegawai($nip){
      $builder = $this->db->table('PEGAWAI')->where("NIP",$nip)->delete();
			return;
		}

    public function listBendahara(){
			$builder = $this->db->table('BEND a');
			$builder->select('rtrim(a.KEYBEND) as KEYBEND,a.JNS_BEND, a.NIP, a.KDBANK, a.UNITKEY, a.JAB_BEND, a.REKBEND, a.SALDOBEND,a.SALDOBENDT, a.NPWPBEND, a.TGLSTOPBEND,');
      $builder->select("rtrim(b.KDUNIT) as KDUNIT, rtrim(b.NMUNIT) as NMUNIT, c.NAMA,(rtrim(a.NIP)+' - '+ rtrim(c.NAMA)) as NIPNAMA, c.JABATAN,d.URAI_BEND");
      $builder->join('DAFTUNIT b','b.UNITKEY = a.UNITKEY','left');
      $builder->join('PEGAWAI c','c.NIP = a.NIP','left');
      $builder->join('JBEND d','d.JNS_BEND = a.JNS_BEND','left');
      $builder->where("a.UNITKEY",session()->kdUnit);
      $builder->orderBy('a.JNS_BEND','ASC');
//      echo $builder->getCompiledSelect();die();
      $rs = $builder->get()->getResult();
			return $rs;
		}

	}
?>