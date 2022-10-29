<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Bp extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
			$this->utama = new \App\Models\Model_Utama;
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
				$builder->where('convert(char(10), S.TGLSKO, 101) <= ','Convert(datetime, '.$tgl.')');
			}
      $builder->join('DAFTUNIT U','S.UNITKEY = U.UNITKEY')->orderBy('S.TGLSKO','ASC');
			//echo nl2br($builder->getCompiledSelect());die();

			return $builder->get()->getResult();
		}
		public function getBendahara(){
			$builder = $this->db->table('BEND');
			$rs = $builder->select('*')->where('KEYBEND',session()->keybend)->where('UNITKEY',session()->kdUnit);
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
			$builder->select('DP3.NMP3,K.TGLKON,S.STATUS,AB.NOSPM');
      $builder->join('SPPDETR D','S.NOSPP = D.NOSPP and S.UNITKEY = D.UNITKEY', 'LEFT OUTER');
			$builder->join('SKO SK','S.IDXSKO = SK.IDXSKO and S.UNITKEY = SK.UNITKEY', 'LEFT OUTER');
			$builder->join('DAFTPHK3 DP3','S.KDP3 = DP3.KDP3', 'LEFT OUTER');
			$builder->join('BEND B','S.KEYBEND=B.KEYBEND', 'LEFT OUTER');
			$builder->join('JBEND J','B.JNS_BEND = J.JNS_BEND', 'LEFT OUTER');
			$builder->join('KONTRAK K','S.NOKONTRAK = K.NOKON', 'LEFT OUTER');
			$builder->join('ANTARBYR AB','AB.NOSPP = S.NOSPP','LEFT');
			
			$builder->join('(SELECT X.NOSPP,SUM(X.NILAI) AS NILAI FROM (
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETB WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETD WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETR WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPP, SUM(NILAI) as NILAI FROM SPPDETRTL WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP
			) as X GROUP BY X.NOSPP) AS RR', 'RR.NOSPP = S.NOSPP','LEFT');
			
			$builder->orderBy('S.NOSPP');
			return $builder;
		}

		public function listSPP($tgl= null){
			$builder = $this->BaseQuerySpp();
			if(session()->jnsSpp == "up"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend)->where('S.UNITKEY',session()->kdUnit);
			}
			if(session()->jnsSpp == "gu"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23]);
			}
			if($tgl != NULL){
				//$whereDate = 'Convert(char(10), S.TGLVALID, 101) <= Convert(datetime, \''.$tgl.'\')';
				//$builder->where($whereDate)->where('S.UNITKEY',session()->kdUnit);
			}
			//echo nl2br($builder->getCompiledSelect());die();
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
			if($post['PENOLAKAN'] == "0"){
				$notIn = "NOSPP NOT IN (SELECT NOSPP FROM ANTARBYR WHERE UNITKEY = '".session()->kdUnit."')";
				$builder = $this->db->table('SPP')->where($notIn);
				$update = array("PENOLAKAN"=>"0","TGLVALID"=>NULL);
				$builder->where('UNITKEY',session()->kdUnit)->where('NOSPP',session()->nospp)->update($update);
				$this->utama->setFlashData('SPP tidak dapat dibatalkan. Data SPP sudah jadi SPM!',"Validasi SPP telah dibatalkan","danger");
			}else{
				$builder = $this->db->table('SPP');
				$builder->where('UNITKEY',session()->kdUnit)->where('NOSPP',session()->nospp)->update($post);
				$this->utama->setFlashData('Gagal validasi SPP!','SPP telah divalidasi tanggal '.$post['TGLVALID']);
			}
			return;
		}
		public function hapusSPP(){
			$row = $builder->db->table('SPPDETB')->select('NOSPP')->where('PENOLAKAN','0')->where("NOSPP",session()->nospp)->get()->getRow();
			if($row->NOSPP != ''){
				$notIn = "NOSPP NOT IN (SELECT NOSPP FROM ANTARBYR WHERE UNITKEY = '".session()->kdUnit."')";
				$builder = $this->db->table('SPPDETB')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->where($notIn)->delete();
				$builder = $this->db->table('SPPDETR')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->where($notIn)->delete();
				$builder = $this->db->table('SPP')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->where($notIn)->delete();
				session()->setFlashData("info", "Validasi SPP Berhasil");
			}else{
				session()->setFlashData("info", "Tidak dapat menghapus data, SPP telah di validasi");
			}
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

		/* ---------------------- SPM ------------------- */
		public function getSPM($jnsSpm){
			$builder = $this->db->table('ANTARBYR a');
			$builder->select('a.*,convert(char(10), a.TGLSPM, 101) AS TGLSPM, b.KDUNIT, b.NMUNIT')->where('a.NOSPM',session()->nospm)->where('a.UNITKEY',session()->kdUnit);
			if($jnsSpm == "up"){
				$builder->select('C.NILAI');
				$builder->join('SPMDETB C','C.NOSPM = a.NOSPM','left');
			}
      $builder->join('DAFTUNIT b','b.UNITKEY = a.UNITKEY AND b.KDLEVEL = "3"','left');
			return $builder->get()->getRow();
		}
		public function sppList($tgl= null){
			$builder = $this->BaseQuerySpp();
			if(session()->jnsSpm == "up"){
				$notIn = "S.NOSPP NOT IN (SELECT NOSPP FROM ANTARBYR WHERE UNITKEY = '" .session()->kdUnit . "' AND KDSTATUS='21')";
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->where($notIn);
			}
			if(session()->jnsSpm == "gu"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23]);
			}
			if($tgl != NULL){
				$whereDate = 'Convert(char(10), S.TGLVALID, 101) <= Convert(datetime, \''.$tgl.'\')';
				$builder->where($whereDate)->where('S.UNITKEY',session()->kdUnit);
			}
			//echo nl2br($builder->getCompiledSelect());die();
			return $builder->get()->getResult();
		}
		public function QuerySPMUP(){
			$builder = $this->db->table('ANTARBYR A');
			$builder->select('A.IDXKODE,A.IDXSKO,rtrim(A.IDXTTD) as IDXTTD,rtrim(A.KDSTATUS) as KDSTATUS');
			$builder->select('isnull((A.KEPERLUAN),\'\')as KEPERLUAN,isnull((A.NOKONTRAK),\'\')NOKONTRAK');
			$builder->select('A.KDP3, isnull((DP3.NMP3),\'\')NMP3');
			$builder->select('A.KETOTOR,rtrim(A.KEYBEND) as KEYBEND,A.NOREG,A.NOSPM,A.NOSPP');
			$builder->select('A.PENOLAKAN,convert(char(10), A.TGLSPM, 101) AS TGLSPM,convert(char(10), a.TGLVALID, 101) AS TGLVALID,A.TGSPP,A.UNITKEY');
			$builder->select('SK.TGLSKO,SK.NOSKO, \'\'  as KDKEGUNIT');
			$builder->select('A.KDDANA,A.KDKABKOT,SP2D.NOSP2D');
      $builder->join('SPMDETR D','A.NOSPM = D.NOSPM and A.UNITKEY = D.UNITKEY', 'LEFT OUTER');
      $builder->join('SKO SK','A.IDXSKO = SK.IDXSKO and A.UNITKEY = SK.UNITKEY', 'LEFT OUTER');
      $builder->join('DAFTPHK3 DP3','A.KDP3 = DP3.KDP3', 'LEFT OUTER');
      $builder->join('BEND B','A.KEYBEND=B.KEYBEND', 'LEFT OUTER');
      $builder->join('JBEND J','B.JNS_BEND = J.JNS_BEND', 'LEFT OUTER');
      $builder->join('SP2D SP2D','A.NOSPM = SP2D.NOSP2D', 'LEFT');
      $builder->where('A.UNITKEY',session()->kdUnit)->where('A.IDXKODE',session()->Idxkode);

			$builder->orderBy('A.NOSPM');
			return $builder;
		}
		public function listSPM(){
			$builder = $this->QuerySPMUP();
			if(session()->jnsSpm == "up"){
				$builder->where('A.KEYBEND',session()->keybend);
			}
			if(session()->jnsSpm == "gu"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23]);
			}
			return $builder->get()->getResult();
		}
		public function insertANTARBYR($post){
			$builder = $this->db->table('SPP A');
			$builder->select("A.UNITKEY,'".$post['NOSPM']."' as NOSPM,A.KDSTATUS,A.KEYBEND,A.IDXSKO,A.NOSPP");
			$builder->select("A.IDXKODE,A.NOREG,A.KETOTOR,A.KEPERLUAN,A.PENOLAKAN,'".$post['TGLSPM']."' as TGLSPM,A.TGSPP");
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOSPP',$post['KETOTOR'])->where('A.KEYBEND',session()->keybend);
//			echo nl2br($builder->getCompiledSelect());die();
			$rs = $builder->get()->getRow();
			$hasil = array(
				'UNITKEY'=>$rs->UNITKEY,
				'NOSPM'=>$rs->NOSPM,
				'KDSTATUS'=>$rs->KDSTATUS,
				'KEYBEND'=>$rs->KEYBEND,
				'IDXSKO'=>$rs->IDXSKO,
				'NOSPP'=>$rs->NOSPP,
				'IDXKODE'=>$rs->IDXKODE,
				'NOREG'=>$rs->NOREG,
				'KETOTOR'=>$rs->KETOTOR,
				'KEPERLUAN'=>$rs->KEPERLUAN,
				'PENOLAKAN'=>$rs->PENOLAKAN,
				'TGLSPM'=>$rs->TGLSPM,
				'TGSPP'=>$rs->TGSPP
			);
			return $hasil;
		}
		public function insertSPMUP($post){
			$builder = $this->db->table('SPPDETB B')->select("B.MTGKEY, B.UNITKEY,'".$post['NOSPM']."' as NOSPM,B.NOJETRA,B.NILAI");
			$notIn = "B.NOSPP NOT IN (SELECT NOSPM FROM ANTARBYR WHERE UNITKEY = '".session()->kdUnit."' AND NOSPP = '".$post['NOSPM']."')";
			$builder->where('B.UNITKEY',session()->kdUnit)->where('NOSPP',$post['KETOTOR'])->where($notIn);
			$rs = $builder->get()->getRow();
			$hasil = array(
				'MTGKEY'=>$rs->MTGKEY,
				'UNITKEY'=>$rs->UNITKEY,
				'NOJETRA'=>$rs->NOJETRA,
				'NOSPM'=>$rs->NOSPM,
				'NILAI'=>$rs->NILAI
			);
			return $hasil;
		}
		public function simpanSPM($post){
			if(session()->nospm == ""){
				$antarbyr = $this->insertANTARBYR($post);
				$insert = $this->insertSPMUP($post);

				$builder = $this->db->table('ANTARBYR');
				$parent = $builder->set($antarbyr)->getCompiledInsert();

				$builder = $this->db->table('SPMDETB');
				$builder->set($insert);
				$child = $builder->set($insert)->getCompiledInsert();

				$this->db->transStart();
				$this->db->query($parent);
				$this->db->query($child);
				$this->db->transComplete();
				$this->utama->setFlashData('Tidak dapat menyimpan data SPM.',"SPM telah berhasil disimpan","info");
			}else{
				$builder = $this->db->table('SPPDETB');
				//$builder->where('UNITKEY',session()->kdUnit)->where('NOREG',session()->noreg)->update($post);
			}
			return;
		}
		public function hapusSPM($post){
			$builder = $this->db->table('ANTARBYR');
			if(session()->jnsSpm == "up"){
				$spmdetb = "DELETE SPMDETB WHERE UNITKEY='".session()->kdUnit."' AND NOSPM = '".session()->nospm."' AND NOT IN 
				(SELECT NOSPM FROM SP2D WHERE NOSPM = '".session()->nospm."' AND UNITKEY='".session()->kdUnit."')";
			}else{
				$builder = $this->db->table('SPPDETB');
				//$builder->where('UNITKEY',session()->kdUnit)->where('NOREG',session()->noreg)->update($post);
			}
			$antarbyr = "DELETE ANTARBYR WHERE UNITKEY='".session()->kdUnit."' AND NOSPM = '".session()->nospm."'";
			$this->db->transStart();
			$this->db->query($spmdetb);
			$this->db->query($antarbyr);
			$this->db->transComplete();
			return;
		}
		public function rincianSPM(){
			if(session()->jnsSpm == "up"){
				$builder = $this->db->table('SPMDETB A');
				$builder->select('A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPM,A.UNITKEY');
				$builder->select('rtrim(C.KDPER) as KDPER, rtrim(C.NMPER) as NMPER, C.TYPE');
				$builder->join('MATANGB C','A.MTGKEY = C.MTGKEY','left outer');
				$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOSPM',session()->nospm)->where('A.NOJETRA',session()->kdStatus);
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
		public function setujuSPM($post){
			if($post['PENOLAKAN'] == "0"){
				$notIn = "NOSPM NOT IN (SELECT NOSPM FROM SP2D WHERE UNITKEY = '".session()->kdUnit."')";
//$subQuery = $db->table('users_jobs')->select('job_id')->where('user_id', 3);
				//$subQuery = $this->db->table('SP2D')->select('NOSPM')->where('UNITKEY', session()->kdUnit)->get()->getResultArray();
				$builder = $this->db->table('ANTARBYR')->where($notIn);
				$update = array("PENOLAKAN"=>"0","TGLVALID"=>NULL);
				$builder->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nospm)->update($update);
				$this->utama->setFlashData('SPM tidak dapat dibatalkan. Data SPM sudah jadi SP2D!',"Validasi SPM telah dibatalkan","danger");
			}else{
				$builder = $this->db->table('ANTARBYR');
				$builder->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nospm)->update($post);
				$this->utama->setFlashData('Gagal validasi SPM!','SPM telah divalidasi tanggal '.$post['TGLVALID']);
			}
			return;
		}

		/*----------------- SP2D -----------------*/
		public function simpanSP2D($post){
			$builder->db->table('SP2D')->where('SP2D',session()->sp2d)->where('UNITKEY',session()->kdUnit)->delete();
			if(session()->nospm == ""){
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
	}
?>