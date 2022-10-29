<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Utama extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
		}
			//echo nl2br($builder->getCompiledSelect());

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
		public function getUnit(){
			$builder = $this->db->table('DAFTUNIT');
			$builder->select('*')->where("UNITKEY",session()->kdUnit);
      $rs = $builder->get()->getRow();
			return $rs;
		}
		public function listPegawai($tabel){
			$builder = $this->db->table($tabel.' A')->join('PEGAWAI P','A.NIP = P.NIP', 'LEFT OUTER')->join('GOLONGAN G','P.KDGOL = G.KDGOL', 'LEFT OUTER');
			$builder->select('A.*,P.NAMA, P.JABATAN, G.PANGKAT')->where("A.UNITKEY",session()->kdUnit);
      $rs = $builder->get()->getResult();
			return $rs;
		}
		public function listTTD($kddok){
			$builder = $this->db->table('JABTTD A')->join('PEGAWAI P','A.NIP = P.NIP', 'LEFT OUTER')->join('GOLONGAN G','P.KDGOL = G.KDGOL', 'LEFT OUTER');
			$builder->select('A.*,P.NAMA, P.JABATAN, G.PANGKAT')->where("A.UNITKEY",session()->cur_skpkd)->where('KDDOK',$kddok);
      $rs = $builder->get()->getResult();
			return $rs;
		}

		public function listBulan(){
			$builder = $this->db->table('BULAN');
			$builder->select('*')->orderBy('KDPERIODE','ASC');
      $rs = $builder->get()->getResult();
			return $rs;
		}

		public function listRekBUD(){
			$builder = $this->db->table('BKBKAS A');
			$builder->join('DAFTBANK B','A.KDBANK = B.KDBANK','LEFT OUTER')->join('MATANGNRC C','A.MTGKEY = C.MTGKEY','LEFT OUTER');
			$builder->select('A.*,B.NMBANK,C.NMPER')->orderBy('NOBBANTU','ASC');
			return $builder->get()->getResult();
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

		public function getWebset($field){
			$builder = $this->db->table('WEBSET');
			$rs = $builder->select('*')->where('KDSET',$field)->get()->getRow();
			return $rs->VALSET;
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
		public function updateNextkey($tableID){
			$builder = $this->db->table('NEXTKEY');
			$builder->where('TABLEID',$tableID)->update('NEXTKEY',"(rtrim(cast((cast(rtrim(replace(NEXTKEY,'_','')) as int)+1) as char(20))) + '_')");
			return;
		}

		public function getNoRegSPP(){
			$builder = $this->db->table('SPP');
			$builder->select('top (1) ISNULL(NOREG,0) as NOREG')->where('UNITKEY',session()->kdUnit)->orderBy('NOREG','DESC');
			$rs = $builder->get()->getRow();
			session()->set('noreg',$rs->NOREG);

			return;
		}
		public function getNoRegSPM($jnsSpm){
			if($jnsSpm == "up"){
				$builder = $this->db->table('ANTARBYR');
			}
			$builder->select('top (1) ISNULL(NOREG,0) as NOREG')->where('UNITKEY',session()->kdUnit)->orderBy('NOREG','DESC');
			$rs = $builder->get()->getRow();
			session()->set('noreg',$rs->NOREG);

			return;
		}
		public function getNoRegSP2D(){
			$builder = $this->db->table('SP2D');
			$builder->select('top (1) ISNULL(NOREG,0) as NOREG')->where('UNITKEY',session()->kdUnit)->orderBy('NOREG','DESC');
			$rs = $builder->get()->getRow();
			session()->set('noreg',($rs->NOREG)+1);

			return;
		}
		public function getNoSPP(){
			$builder = $this->db->table('SPP');
			$builder->select('top (1) ISNULL(NOSPP,0) as NOSPP')->where('UNITKEY',session()->kdUnit)->where('KEYBEND',session()->keybend)->orderBy('NOSPP','DESC');
			$rs = $builder->get()->getRow();
			return ($rs->NOSPP+0)+1;
		}
		public function setFlashData($error,$ok,$type='info'){
			if($this->db->affectedRows() > 0){
				session()->setFlashData("success", $ok);
			}	else {	
				session()->setFlashData("danger", $error);
			}		
		}
		public function getPemda($where){
			$builder = $this->db->table('PEMDA')->select('CONFIGVAL')->where('CONFIGID',$where)->get()->getRow();
			session()->set($where,$builder->CONFIGVAL);
			return;
		}


	}
?>