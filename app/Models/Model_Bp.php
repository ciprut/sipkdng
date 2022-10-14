<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Bp extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
		}

		public function listSKUP(){
			$builder = $this->db->table('NSKUP a');
			$builder->select('a.*, b.KDUNIT, b.NMUNIT')->where('a.KDTAHAP',session()->tahap);
      $builder->join('DAFTUNIT b','b.UNITKEY = a.UNITKEY AND b.KDLEVEL = "3"');

			return $builder->get()->getResult();
		}
    public function getSKUP(){
			$builder = $this->db->table('NSKUP a');
			$builder->select('a.*, b.KDUNIT, b.NMUNIT')->where('a.KDTAHAP',session()->tahap)->where('a.UNITKEY',session()->unit);
      $builder->join('DAFTUNIT b','b.UNITKEY = a.UNITKEY AND b.KDLEVEL = "3"');

			return $builder->get()->getRow();
		}
    public function simpanNSUP($post){
      if(session()->edit == ""){
        /* Create$builder = $this->db->table('PEGAWAI');
        $builder->set($post);
        $builder->insert($post);*/
      }else{
        $builder = $this->db->table('NSKUP');
        $builder->where('UNITKEY',session()->edit)->where('KDTAHAP',session()->tahap)->update($post);
      }
			return;
		}

		public function listSPP(){
			$builder = $this->db->table('SPP S');
			$builder->select('S.UNITKEY, rtrim(S.KDSTATUS) as KDSTATUS, S.NOSPP, S.TGSPP, S.IDXSKO, S.KETOTOR
			, S.NOREG, S.NOKONTRAK, S.KEPERLUAN, rtrim(S.KEYBEND) as KEYBEND, S.KDP3, S.KD_BULAN,B.JNS_BEND,
			S.PENOLAKAN, S.TGLVALID, S.IDXKODE,rtrim(S.IDXTTD) as IDXTTD,SK.TGLSKO,SK.NOSKO, ''  as KDKEGUNIT,
			DP3.NMP3,K.TGLKON,S.STATUS')->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->idxKode);
      $builder->join('SPPDETR D','.NOSPP = D.NOSPP and S.UNITKEY = D.UNITKEY');
			$builder->join('SKO SK','S.IDXSKO = SK.IDXSKO and S.UNITKEY = SK.UNITKEY');
			$builder->join('DAFTPHK3 DP3','S.KDP3 = DP3.KDP3');
			$builder->join('BEND B','S.KEYBEND=B.KEYBEND');
			$builder->join('JBEND J','B.JNS_BEND = J.JNS_BEND');
			$builder->join('KONTRAK K','S.NOKONTRAK = K.NOKON');

			return $builder->get()->getResult();
		}

	}
?>