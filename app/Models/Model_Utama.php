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
		public function treeViewKeg($unitkey,$kd){
			$sp = "SET NOCOUNT ON; EXEC WSP_TREEVIEWKEG '".$unitkey."','','".session()->tahap."','','".$kd."','',''";
			$rs = $this->db->query($sp)->getResult();
			return $rs;
		}


		public function listRekBUD(){
			$builder = $this->db->table('BKBKAS A');
			$builder->join('DAFTBANK B','A.KDBANK = B.KDBANK','LEFT OUTER')->join('MATANGNRC C','A.MTGKEY = C.MTGKEY','LEFT OUTER');
			$builder->select('A.*,B.NMBANK,C.NMPER')->orderBy('NOBBANTU','ASC');
			return $builder->get()->getResult();
		}

		public function buktiList(){
			$builder = $this->db->table('JBKAS A');
			$builder->select('A.*')->orderBy('A.KDBUKTI','ASC');
			return $builder->get()->getResult();
		}
		public function bendList($jb='%'){
			$builder = $this->db->table('BEND A')->where('A.UNITKEY',session()->kdUnit)->like('A.JAB_BEND',$jb);
			$builder->select('A.*,P.NAMA')->orderBy('A.JNS_BEND','ASC')->join('PEGAWAI P','A.NIP = P.NIP','LEFT OUTER');
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
//      echo nl2br($builder->getCompiledSelect());die();
      $rs = $builder->get()->getResult();
			return $rs;
		}

		public function getKdKeg($field){
			$builder = $this->db->table('MKEGIATAN');
			$rs = $builder->select('*')->where('KDSET',$field)->get()->getRow();
			return $rs->VALSET;
		}
		public function getUraian($kdStatus){
			$builder = $this->db->table('STATTRS');
			$rs = $builder->select('*')->where('KDSTATUS',$kdStatus)->get()->getRow();
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
		public function getNoReg($table,$field,$unitkey=''){
			if($unitkey == ""){
				$unitkey = session()->kdUnit;
			}else if($unitkey == "all"){
				$unitkey = '';
			}
			$builder = $this->db->table($table);
			$builder->select('top (1) ISNULL(LEFT('.$field.',5),0) as NOREG')->like('UNITKEY',$unitkey)->orderBy($field,'DESC');
			$rs = $builder->get()->getRow();
			$nr = ((int)$rs->NOREG)+1;
			return pjg($nr,5);
		}
		public function getNoRegTBP(){
			$builder = $this->db->table('BPK');
			$builder->select('top (1) ISNULL(LEFT(NOBPK,5),0) as NOREG')->where('UNITKEY',session()->kdUnit)->orderBy('NOBPK','DESC');
			$rs = $builder->get()->getRow();
			$nr = ((int)$rs->NOREG)+1;
			return pjg($nr,5);
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
		public function getNoRegBKU($table){
			$q = "SELECT NOBUKAS FROM (
				SELECT NOBUKAS FROM BKUK WHERE NOBBANTU = '".session()->nobbantu."' 
				UNION ALL 
				SELECT NOBUKAS FROM BKUD WHERE NOBBANTU = '".session()->nobbantu."'
			)A order by NOBUKAS";
			$builder = $this->db->query($q);
			$rs = $builder->getRow();
			session()->set('nobukas',($rs->NOBUKAS)+1);

			return;
		}
		public function getNobbantu($no){
			$builder = $this->db->table('BKBKAS');
			$builder->select('*')->where('NOBBANTU',$no)->get()->getRow();
			$rs = $builder->get()->getRow();
			return $rs;
		}
		public function getBendahara(){
			$builder = $this->db->table('BEND');
			$builder->select('*')->where('KEYBEND',session()->keybend)->get()->getRow();
			$rs = $builder->get()->getRow();
			return $rs;
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
		public function getIdxttd($kddok){
			$builder = $this->db->table('JABTTD J');
			$rs = $builder->select('rtrim(J.IDXTTD) as IDXTTD, J.UNITKEY, J.KDDOK, J.NIP,J.JABATAN, J.NOSKPTTD, J.TGLSKPTTD, J.NOSKSTOPTTD, J.TGLSKSTOPTTD,');
			$builder->select('rtrim(U.KDUNIT) as KDUNIT, rtrim(U.NMUNIT) as NMUNIT,D.NMDOK,P.NAMA,(rtrim(J.NIP)+\' - \'+ rtrim(P.NAMA)) as NIPNAMA,P.JABATAN');
			$builder->join('DAFTDOK D','J.KDDOK=D.KDDOK','LEFT OUTER');
			$builder->join('DAFTUNIT U','J.UNITKEY=U.UNITKEY','LEFT OUTER');
			$builder->join('PEGAWAI P','J.NIP=P.NIP','LEFT OUTER');
			$builder->where('J.KDDOK',$kddok);
			$rs = $builder->get()->getRow();
			return $rs;
		}

		public function getBKUSKPD($nobku=null){
			$builder = $this->db->table('BKUSP2D A');
			$rs = $builder->select('A.NOBKUSKPD,A.URAIAN,B.NOSP2D,convert(char(10), A.TGLBKUSKPD, 101) AS TGLBKUSKPD,B.NOSP2D,convert(char(10), B.TGLSP2D, 101) AS TGLSP2D,B.KEPERLUAN');
			$builder->join('SP2D B','A.NOSP2D=B.NOSP2D','LEFT OUTER');
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOBKUSKPD',session()->nobkuskpd)->where('A.KEYBEND',session()->keybend);
			$rs = $builder->get()->getRow();
			return $rs;
		}

		public function getNoBKUSKPD(){
			$q = "
			SELECT top 1 A.NOBKUSKPD from (
				select A.NOBKUSKPD from BKUSP2D A where A.UNITKEY= '".session()->kdUnit."' and (A.KEYBEND =  '".session()->keybend."')
				union
				select A.NOBKUSKPD from BKUBPK A where A.UNITKEY= '".session()->kdUnit."' and (A.KEYBEND =  '".session()->keybend."')
				union
				select A.NOBKUSKPD from BKUPANJAR A where A.UNITKEY= '".session()->kdUnit."' and (A.KEYBEND =  '".session()->keybend."')
				union
				select A.NOBKUSKPD from BKUPAJAK A where A.UNITKEY= '".session()->kdUnit."' and (A.KEYBEND =  '".session()->keybend."')
				union
				select A.NOBKUSKPD from BKUBANK A where A.UNITKEY='".session()->kdUnit."' and (A.KEYBEND =  '".session()->keybend."')
				union
				select A.NOBKUSKPD from BKUTBP A where A.UNITKEY= '".session()->kdUnit."' and (A.KEYBEND =  '".session()->keybend."')
				union
				select A.NOBKUSKPD from BKUSTS A where A.UNITKEY= '".session()->kdUnit."' and (A.KEYBEND =  '".session()->keybend."')
			) A
			order by A.NOBKUSKPD desc				
			";
			$rs = $this->db->query($q)->getRow();
			$x = explode("-",$rs->NOBKUSKPD);
			$nobkuskpd = (int)$x[0];
			return ($nobkuskpd)+1;
		}
		public function listBKUBP($jb){
			$sp = "SET NOCOUNT ON; EXEC WSP_LOOKUP_BKU_BEND
				@Jenis='".$jb."',
				@Unitkey='".session()->kdUnit."',
				@Bend='02',
				@Keybend='".session()->keybend."',
				@NOMOR='',
				@TGL='',
				@TGL2=''
				";
				session()->set("jb",$jb);
				$rs = $this->db->query($sp)->getResultArray();
			return $rs;
		}

	}
?>