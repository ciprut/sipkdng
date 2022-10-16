<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Pengaturan extends Model{
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
		public function listJenisBendahara(){
			$builder = $this->db->table('JBEND a');
			$builder->select('a.JNS_BEND,a.MTGKEY,a.URAI_BEND')->orderBy('a.JNS_BEND','ASC');

      $rs = $builder->get()->getResult();
			return $rs;
		}
		public function listBank(){
			$builder = $this->db->table('DAFTBANK a');
			$builder->select('a.KDBANK,a.NMBANK');
      $builder->orderBy('a.KDBANK','ASC');

      $rs = $builder->get()->getResult();
			return $rs;
		}
		public function getBendahara($nip){
			$builder = $this->db->table('BEND a');
			$builder->select('a.*, b.NAMA')->where("a.UNITKEY",session()->kdUnit)->where("a.KEYBEND",$nip);
			$builder->join("PEGAWAI b","b.NIP = a.NIP","left");
      $rs = $builder->get()->getRow();
			return $rs;
		}
		public function simpanBendahara($post){
      if(session()->keybend == ""){
				$q = "INSERT INTO BEND (KEYBEND,JNS_BEND,NIP,KDBANK,UNITKEY,JAB_BEND,REKBEND,SALDOBEND,NPWPBEND,SALDOBENDT,NOREK) 
				VALUES 
				(
					(SELECT CAST((CAST(SUBSTRING(CAST(rtrim(MAX(KEYBEND)) AS varchar),1,(LEN(rtrim(MAX(KEYBEND)))-1)) AS INT)+1 ) AS VARCHAR) + CAST('_' AS VARCHAR)
					FROM BEND
					), 
				'".$post['JNS_BEND']."', 
				'".$post['NIP']."', 
				'".$post['KDBANK']."',
				'".session()->kdUnit."',
				'".$post['JAB_BEND']."',
				'".$post['REKBEND']."',
				'".$post['SALDOBEND']."',
				'".$post['NPWPBEND']."',
				'".$post['SALDOBENDT']."',
				'".$post['NOREK']."'
				)";
				$this->db->query($q);
      }else{
				$builder = $this->db->table('BEND');
        $builder->where('KEYBEND',session()->keybend)->update($post);
      }
			return;
		}
		public function hapusBendahara($kb){
      $builder = $this->db->table('BEND')->where("KEYBEND",$kb)->delete();
			return;
		}
/*SELECT KEYBEND,
CAST(
	(CAST(SUBSTRING(CAST(rtrim(KEYBEND) AS varchar),1,(LEN(rtrim(KEYBEND))-1)) AS INT)+1 ) AS VARCHAR
) + CAST('_' AS VARCHAR)
AS BARU 
FROM BEND WHERE NIP = '197405172000032004'
*/

		public function listPA(){
			$builder = $this->db->table('ATASBEND a');
			$builder->select('a.NIP,b.NAMA, c.NMGOL,c.PANGKAT, b.JABATAN')->where("a.UNITKEY",session()->kdUnit);
			$builder->join("PEGAWAI b","b.NIP = a.NIP","left");
			$builder->join('GOLONGAN c','c.KDGOL = b.KDGOL','left');

			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function getPA($nip){
			$builder = $this->db->table('ATASBEND a');
			$builder->select('a.*, b.NAMA, b.KDGOL, c.NMGOL,c.PANGKAT, b.JABATAN')->where("a.UNITKEY",session()->kdUnit)->where("a.NIP",$nip);
			$builder->join("PEGAWAI b","b.NIP = a.NIP","left");
			$builder->join('GOLONGAN c','c.KDGOL = b.KDGOL','left');
			$rs = $builder->get()->getRow();
			return $rs;
		}
		public function simpanPA($post){
			if(session()->nip == ""){
				$builder = $this->db->table('ATASBEND');
				$builder->set($post);
				$builder->insert($post);
			}else{
				$builder = $this->db->table('ATASBEND');
				$builder->where('UNITKEY',session()->kdUnit)->update($post);
			}
			return;
		}
		public function hapusPA($nip){
      $builder = $this->db->table('KPA')->where("NIP",$nip)->where('UNITKEY',session()->kdUnit)->delete();
			return;
		}

		public function listKPA(){
			$builder = $this->db->table('KPA a');
			$builder->select('a.NIP,b.NAMA, c.NMGOL,c.PANGKAT, a.JABATAN')->where("a.UNITKEY",session()->kdUnit);
			$builder->join("PEGAWAI b","b.NIP = a.NIP","left");
			$builder->join('GOLONGAN c','c.KDGOL = b.KDGOL','left');

			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function getKPA($nip){
			$builder = $this->db->table('KPA a');
			$builder->select('a.*, b.NAMA, b.KDGOL, c.NMGOL,c.PANGKAT')->where("a.UNITKEY",session()->kdUnit)->where("a.NIP",$nip);
			$builder->join("PEGAWAI b","b.NIP = a.NIP","left");
			$builder->join('GOLONGAN c','c.KDGOL = b.KDGOL','left');
			$rs = $builder->get()->getRow();
			return $rs;
		}
		public function simpanKPA($post){
			if(session()->nip == ""){
				$builder = $this->db->table('KPA');
				$builder->set($post);
				$builder->insert($post);
			}else{
				$builder = $this->db->table('KPA');
				$builder->where('UNITKEY',session()->kdUnit)->where('NIP',session()->nip)->update($post);

//				$q = "UPDATE KPA SET JABATAN = '".$post['JABATAN']."' WHERE UNITKEY = '".session()->kdUnit."' AND NIP = '".session()->nip."'";
//				echo $q;die();
//				$this->db->query($q);
			}
			return;
		}
		public function hapusKPA($nip){
      $builder = $this->db->table('KPA')->where("NIP",$nip)->where('UNITKEY',session()->kdUnit)->delete();
			return;
		}
	}
?>