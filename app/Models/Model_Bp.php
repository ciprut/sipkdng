<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Bp extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
			$utama = new \App\Models\Model_Utama;
		}

		public function listSKUP(){
			$builder = $this->db->table('NSKUP a');
			$builder->select('a.*, b.KDUNIT, b.NMUNIT')->where('a.KDTAHAP',session()->tahap);
      $builder->join('DAFTUNIT b','b.UNITKEY = a.UNITKEY AND b.KDLEVEL = "3"');

			return $builder->get()->getResult();
		}
		public function spdList($tgl=NULL){
			$builder = $this->db->table('SKO S');
			$builder->select('rtrim(S.NOSKO) AS NOSKO, convert(char(10), S.TGLSKO, 103) AS TGLSKO, rtrim(S.IDXSKO) AS IDXSKO,S.KETERANGAN');
			$builder->where('S.UNITKEY',session()->kdUnit)->WHERE('S.IDXKODE','6')->WHERE('S.TGLVALID !=',null);
			if($tgl != NULL){
				$builder->where('convert(char(10), S.TGLSKO, 101) <= ',$tgl);
			}
      $builder->join('DAFTUNIT U','S.UNITKEY = U.UNITKEY')->orderBy('S.TGLSKO','ASC');
			//echo nl2br($builder->getCompiledSelect());die();

			return $builder->get()->getResult();
		}
		public function getBendahara(){
			$builder = $this->db->table('BEND');
			$rs = $builder->select('*')->where('KEYBEND',session()->keybend)->where('UNITKEY',session()->kdUnit);
			//echo $field."<br>".nl2br($builder->getCompiledSelect());die();
			return $rs->get()->getRow();
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
		public function BaseQuerySpp(){
			$builder = $this->db->table('SPP S');
			$builder->select('S.UNITKEY, rtrim(S.KDSTATUS) as KDSTATUS, S.NOSPP, convert(char(10), S.TGSPP, 101) AS TGSPP, S.IDXSKO, S.KETOTOR, RR.NILAI');
			$builder->select('S.NOREG, S.NOKONTRAK, S.KEPERLUAN, rtrim(S.KEYBEND) as KEYBEND, S.KDP3, S.KD_BULAN,B.JNS_BEND,');
			$builder->select('S.PENOLAKAN, convert(char(10), S.TGLVALID, 101) AS TGLVALID, S.IDXKODE,rtrim(S.IDXTTD) as IDXTTD,SK.TGLSKO,SK.NOSKO, \'\'  as KDKEGUNIT,');
			$builder->select('DP3.NMP3,K.TGLKON,S.STATUS');
      $builder->join('SPPDETR D','S.NOSPP = D.NOSPP and S.UNITKEY = D.UNITKEY', 'LEFT OUTER');
			$builder->join('SKO SK','S.IDXSKO = SK.IDXSKO and S.UNITKEY = SK.UNITKEY', 'LEFT OUTER');
			$builder->join('DAFTPHK3 DP3','S.KDP3 = DP3.KDP3', 'LEFT OUTER');
			$builder->join('BEND B','S.KEYBEND=B.KEYBEND', 'LEFT OUTER');
			$builder->join('JBEND J','B.JNS_BEND = J.JNS_BEND', 'LEFT OUTER');
			$builder->join('KONTRAK K','S.NOKONTRAK = K.NOKON', 'LEFT OUTER');
			
			$builder->join('(SELECT X.NOSPP,SUM(X.NILAI) AS NILAI FROM (
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETB WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETD WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETR WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETRTL WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP
			) as X GROUP BY X.NOSPP) AS RR', 'RR.NOSPP = S.NOSPP','LEFT');
			
			$builder->orderBy('S.NOSPP');
			return $builder;
		}

		public function listSPP(){
			$builder = $this->BaseQuerySpp();
			if(session()->jnsSpp == "up"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
			}
			if(session()->jnsSpp == "gu"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23]);
			}
			return $builder->get()->getResult();
		}
		public function getSPP(){
			$builder = $this->db->table('SPP a');
			$builder->select('a.*,convert(char(10), a.TGSPP, 101) AS TGLSPP, b.KDUNIT, b.NMUNIT')->where('a.NOSPP',session()->nospp)->where('a.UNITKEY',session()->kdUnit);
      $builder->join('DAFTUNIT b','b.UNITKEY = a.UNITKEY AND b.KDLEVEL = "3"');
			return $builder->get()->getRow();
		}
		public function getSisaSKUP(){
			$builder = $this->db->table('NSKUP a');
			$builder->select('a.NILAI,ISNULL(SUM(b.NILAI), 0)  as NILAISPP')->where('a.KDTAHAP',session()->tahap)->where('a.UNITKEY',session()->kdUnit);
      $builder->join('SPPDETB b','b.UNITKEY = a.UNITKEY','left')->groupBy('a.NILAI');
			$rs = $builder->get()->getRow();
			return ($rs->NILAI - $rs->NILAISPP);
		}
		public function simpanSPP($post){
			if(session()->nospp == ""){
				$sisaUP = $this->getSisaSKUP();

				$builder = $this->db->table('SPP');
				$builder->set($post);
				$builder->insert($post);

				$detb = array(
					"MTGKEY"=>'REK_UP',
					'UNITKEY'=>session()->kdUnit,
					'NOJETRA'=>session()->kdStatus,
					'NOSPP'=>$post['NOSPP'],
					'NILAI'=> $sisaUP
				);
				$builder = $this->db->table('SPPDETB');
				$builder->set($detb);
				$builder->insert($detb);
			}else{
				$builder = $this->db->table('SPP');
				$builder->where('UNITKEY',session()->kdUnit)->where('NOREG',session()->noreg)->update($post);
			}
			return;
		}
		public function setujuSPP($post){
			$builder = $this->db->table('SPP');
			$builder->where('UNITKEY',session()->kdUnit)->where('NOSPP',session()->nospp)->update($post);
			return;
		}
		public function hapusSPP(){
      $builder = $this->db->table('SPPDETB')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->delete();
      $builder = $this->db->table('SPPDETR')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->delete();
      $builder = $this->db->table('SPP')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->delete();
			return;
		}

		public function rincianSPP(){
			if(session()->jnsSpp == "up"){
				$builder = $this->db->table('SPPDETB A');
				$builder->select('A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPP,A.UNITKEY');
				$builder->select('rtrim(C.KDPER) as KDPER, rtrim(C.NMPER) as NMPER, C.TYPE');
				$builder->join('MATANGB C','A.MTGKEY = C.MTGKEY','left outer');
				$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOSPP',session()->nospp)->where('A.NOJETRA',session()->kdStatus);
			}
			if(session()->jnsSpp == "gu"){
				$builder = $this->db->table('SPPDETB A');
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23]);
			}
			//echo session()->kdUnit." ".session()->Idxkode;//die();
			//echo nl2br($builder->getCompiledSelect());die();
			return $builder->get()->getResult();
		}
		public function BaseQuerySpm(){
			$builder = $this->db->table('SPMPJK S');
			$builder->select('S.UNITKEY, rtrim(S.KDSTATUS) as KDSTATUS, S.NOSPP, convert(char(10), S.TGSPP, 101) AS TGSPP, S.IDXSKO, S.KETOTOR, RR.NILAI');
			$builder->select('S.NOREG, S.NOKONTRAK, S.KEPERLUAN, rtrim(S.KEYBEND) as KEYBEND, S.KDP3, S.KD_BULAN,B.JNS_BEND,');
			$builder->select('S.PENOLAKAN, convert(char(10), S.TGLVALID, 101) AS TGLVALID, S.IDXKODE,rtrim(S.IDXTTD) as IDXTTD,SK.TGLSKO,SK.NOSKO, \'\'  as KDKEGUNIT,');
			$builder->select('DP3.NMP3,K.TGLKON,S.STATUS');
      $builder->join('SPPDETR D','S.NOSPP = D.NOSPP and S.UNITKEY = D.UNITKEY', 'LEFT OUTER');
			$builder->join('SKO SK','S.IDXSKO = SK.IDXSKO and S.UNITKEY = SK.UNITKEY', 'LEFT OUTER');
			$builder->join('DAFTPHK3 DP3','S.KDP3 = DP3.KDP3', 'LEFT OUTER');
			$builder->join('BEND B','S.KEYBEND=B.KEYBEND', 'LEFT OUTER');
			$builder->join('JBEND J','B.JNS_BEND = J.JNS_BEND', 'LEFT OUTER');
			$builder->join('KONTRAK K','S.NOKONTRAK = K.NOKON', 'LEFT OUTER');
			
			$builder->join('(SELECT X.NOSPP,SUM(X.NILAI) AS NILAI FROM (
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETB WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETD WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETR WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETRTL WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP
			) as X GROUP BY X.NOSPP) AS RR', 'RR.NOSPP = S.NOSPP','LEFT');
			
			$builder->orderBy('S.NOSPP');
			return $builder;
		}
		public function listSPM(){
			$builder = $this->BaseQuerySpm();
			if(session()->jnsSpm == "up"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
			}
			if(session()->jnsSpm == "gu"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23]);
			}
			return $builder->get()->getResult();
		}

	}
?>