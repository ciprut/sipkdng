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
				$builder->where('convert(char(10), S.TGLSKO, 101) <= ',$tgl);
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
				if(session()->st == "pengajuan"){
//					$builder->where('S.TGLVALID',NULL);
				}else{
//					$builder->where('S.TGLVALID',NULL);
				}
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
				echo $builder->getCompiledSelect();die();
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
			//echo nl2br($builder->getCompiledSelect());die();
			return $builder->get()->getResult();
		}
		public function setujuSPM($post){
			if($post['PENOLAKAN'] == "0"){
				$notIn = "NOSPM NOT IN (SELECT NOSPM FROM SP2D WHERE UNITKEY = '".session()->kdUnit."')";
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

		/*------------------ BKU Bendahara Pengeluaran ------------*/
		public function listBKUBP(){
			$q = "SET NOCOUNT ON; EXEC WSPI_BKUPENGELUARAN
				@allowsuperuser=0,
				@kode='B02',
				@unitkey='".session()->kdUnit."',
				@keybend='".session()->keybend."',
				@tgl1='2022-01-01 00:00:00',
				@tgl2='2022-12-31 00:00:00',
				@field='1',
				@value='',
				@hal=1,
				@flgtgl=0,
				@jmlhal=0
			";
			$rs = $this->db->query($q);
			return $rs->getResult();
		}
		public function simpanBKUBP($post){
			if(session()->nobkuskpd == ""){
				if(session()->jb == "SP2D"){
					$insert = array(
						"KEYBEND"=>session()->keybend,
						'NOSP2D'=>$post['NOBUKTI'],
						'TGLBKUSKPD'=>$post['TGLBKUSKPD'],
						'URAIAN'=>$post['URAIAN'],
						'UNITKEY'=>session()->kdUnit,
						'NOBKUSKPD'=> $post['NOBKUSKPD']
					);
					$builder = $this->db->table('BKUSP2D');
				}else if(session()->jb == "Bank"){
					$insert = array(
						"KEYBEND"=>session()->keybend,
						'NOBUKU'=>$post['NOBUKTI'],
						'TGLBKUSKPD'=>$post['TGLBKUSKPD'],
						'URAIAN'=>$post['URAIAN'],
						'UNITKEY'=>session()->kdUnit,
						'NOBKUSKPD'=> $post['NOBKUSKPD']
					);
					$builder = $this->db->table('BKUBANK');
				}else if(session()->jb == "BPK"){
					$insert = array(
						"KEYBEND"=>session()->keybend,
						'NOBPK'=>$post['NOBUKTI'],
						'TGLBKUSKPD'=>$post['TGLBKUSKPD'],
						'URAIAN'=>$post['URAIAN'],
						'UNITKEY'=>session()->kdUnit,
						'NOBKUSKPD'=> $post['NOBKUSKPD']
					);
					$builder = $this->db->table('BKUBPK');
				}
				$builder->set($insert);
				$builder->insert($insert);
			}else{
			}
			return;
		}
		public function hapusBKUBP($tabel){
			if($tabel == '21'){
				$builder = $this->db->table('BKUSP2D');
			}else if($tabel == '33'){
				$builder = $this->db->table('BKUBANK');
			}

			$builder->where('UNITKEY',session()->kdUnit)->where('NOBKUSKPD',session()->nobkuskpd)->where('KEYBEND',session()->keybend);
			$builder->where('TGLVALID',NULL)->delete();
			return;
		}

		/*------------------ PERGESERAN UANG ------------*/
		public function listPergeseranUang($nobuku=''){
			$builder = $this->db->table('BKBANK A');
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.KEYBEND1',session()->keybend);
			$builder->select("0 as superuser,rtrim(A.IDXTTD) as IDXTTD,rtrim(A.KDSTATUS) as KDSTATUS,");
			$builder->select("rtrim(A.KEYBEND1) as KEYBEND1,rtrim(A.KEYBEND2) as KEYBEND2,A.NOBUKU,A.TGLBUKU,");
			$builder->select("A.TGLVALID,A.UNITKEY,A.URAIAN,rtrim(C.KDUNIT) as KDUNIT, rtrim(C.NMUNIT) as NMUNIT,");
			$builder->select("D.KDDOK, E.LBLSTATUS, E.URAIAN as URAISTATUS");
			$builder->join('DAFTUNIT C','A.UNITKEY=C.UNITKEY', 'LEFT OUTER');
			$builder->join('JABTTD D','A.IDXTTD=D.IDXTTD', 'LEFT OUTER');
			$builder->join('STATTRS E','A.KDSTATUS=E.KDSTATUS', 'LEFT OUTER');
			$builder->orderBy('A.NOBUKU');
			if($nobuku != ''){
				$builder->where('A.NOBUKU',$nobuku);
				$rs = $builder->get()->getRow();
			}else{
				$rs = $builder->get()->getResult();
			}
			return $rs;
		}
		public function simpanPU($post){
			if(session()->nobuku == ""){
				$builder = $this->db->table('BKBANK');
				$builder->set($post);
				$builder->insert($insert);

				$det = array(
					"NILAI"=>0,
					"UNITKEY"=>session()->kdUnit,
					"NOBUKU"=>$post["NOBUKU"],
					"NOJETRA"=>"31"
				);
				$builder = $this->db->table('BKBANKDET');
				$builder->set($det);
				$builder->insert($insert);
			}else{
			}
			return;
		}
		public function hapusPU(){
			$builder = $this->db->table('BKBANKDET');
			$builder->where('UNITKEY',session()->kdUnit)->where('NOBUKU',session()->nobuku)->where('NOJETRA','31')->delete();

			$builder = $this->db->table('BKBANK');
			$builder->where('UNITKEY',session()->kdUnit)->where('NOBUKU',session()->nobuku)->where('KEYBEND1',session()->keybend);
			$builder->where('TGLVALID',NULL)->delete();
			return;
		}
		public function rincianPU(){
			$builder = $this->db->table('BKBANKDET A');
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOBUKU',session()->nobuku);
			$builder->select('A.NILAI,A.NOBUKU,A.NOJETRA,A.UNITKEY, rtrim(B.KEYBEND1) as KEYBEND1, rtrim(B.KEYBEND2) as KEYBEND2, C.KDPERS,C.NMJETRA');
			$builder->join('BKBANK B','A.NOBUKU = B.NOBUKU and A.UNITKEY = B.UNITKEY','LEFT OUTER');
			$builder->join('JTRNLKAS C','A.NOJETRA = C.NOJETRA','LEFT OUTER');
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function updateRinciPU($post){
			$builder = $this->db->table('BKBANKDET');
			$builder->where('UNITKEY',session()->kdUnit)->where('NOBUKU',session()->nobuku)->update($post);
			return;
		}

		/*------------------ Tanda Bukti Penerimaan ------------------*/
		public function listTBP(){//,@unitkey='2559_',@idxkode=2,@kdkegunit='8765_',@keybend='189018_',@field='1',@value=''
			$q = "SET NOCOUNT ON; EXEC WSPI_BPK
				@allowsuperuser=0,
				@idxkode='2',
				@unitkey='".session()->kdUnit."',
				@keybend='".session()->keybend."',
				@kdkegunit='".session()->idSub."',
				@field='1',
				@value=''
			";
			//echo $q;die();
			$rs = $this->db->query($q);
			return $rs->getResult();
		}
		public function rinciTBP($nobpk=''){
			$builder = $this->db->table('BPKDETR BL');
			$builder->where('BL.UNITKEY',session()->kdUnit)->where('BL.NOBPK',session()->nobpk);
			$builder->select("BL.*,rtrim(B.KDSTATUS) as KDSTATUS,B.TGLBPK ,B.URAIBPK, rtrim(B.KEYBEND) as KEYBEND,B.PENERIMA,B.TGLVALID,");
			$builder->select("B.IDXKODE,J.NMJETRA, J.KDPERS, rtrim(M.KDPER) as KDPER, rtrim(M.NMPER) as NMPER");
			$builder->join('BPK B',' BL.NOBPK = B.NOBPK and BL.UNITKEY=B.UNITKEY', 'LEFT OUTER');
			$builder->join('MATANGR M','BL.MTGKEY = M.MTGKEY', 'LEFT OUTER');
			$builder->join('JTRNLKAS J','BL.NOJETRA = J.NOJETRA', 'LEFT OUTER');
			$builder->orderBy('M.KDPER');
			if($nobpk != ''){
				$builder->where('A.NOBPK',$nobpk);
				$rs = $builder->get()->getRow();
			}else{
				$rs = $builder->get()->getResult();
			}
			return $rs;
		}
		public function getTBP(){
			$builder = $this->db->table('BPK A');
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOBPK',session()->nobpk);
			$builder->select('A.*');
			$rs = $builder->get()->getRow();
			return $rs;
		}
		public function simpanTBP($post){
			if(session()->nobpk == ""){
				$builder = $this->db->table('BPK');
				$builder->set($post);
				$builder->insert($insert);
			}else{
			}
			return;
		}
		public function listSubRinc(){
			$notIn = "A.MTGKEY not in (select rtrim(MTGKEY) from BPKDETR S where S.UNITKEY= '".session()->kdUnit."'
			and S.NOBPK= '".session()->nobpk."' and S.KDKEGUNIT= '".session()->idSub."')";

			$builder = $this->db->table('DASKR A');
			$builder->select('B.KDPER, B.NMPER,B.MTGKEY,B.TYPE');
			$builder->join('MATANGR B','A.mtgkey = B.mtgkey','LEFT OUTER');
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.KDKEGUNIT',session()->idSub);
			$builder->where($notIn);
			$builder->orderBy('B.KDPER')->distinct();
			$rs = $builder->get()->getResult();

			return $rs;
		}
		public function tambahRO($post){
			$mk = explode(",",$post);
			for($n=0;$n<sizeof($mk);$n++){
				$builder = $this->db->table('BPKDETR');
				$data = array(
					"MTGKEY"=>$mk[$n],
					"NILAI"=>"0",
					"NOJETRA"=>"21",
					"KDKEGUNIT"=>session()->idSub,
					"NOBPK"=>session()->nobpk,
					"UNITKEY"=>session()->kdUnit
				);
				$builder->set($data);
				$builder->insert($data);
			}
			return;
		}
		public function listSDTBP(){
			$builder = $this->db->table('Bpkdetrdana B');
			$builder->select('B.NOBPK,B.KDDANA,B.MTGKEY,B.UNITKEY,C.NMDANA,B.NILAI,b.KDKEGUNIT');
			$builder->join('JDANA C','B.KDDANA=C.KDDANA','LEFT OUTER');
			$builder->where('B.UNITKEY',session()->kdUnit)->where('B.KDKEGUNIT',session()->idSub)->where('B.NOBPK',session()->nobpk);
			$builder->where('B.MTGKEY',session()->mtgkey);
			$builder->orderBy('B.KDDANA');
			$rs = $builder->get()->getResult();

			return $rs;
		}
		public function listSDSub(){
			$builder = $this->db->table('SBDANAR A');
			$builder->select('rtrim(A.KDDANA) as KDDANA,A.KDKEGUNIT,A.KDTAHAP,A.MTGKEY,A.NILAI,A.UNITKEY, B.NMDANA');
			$builder->join('JDANA B','A.KDDANA=B.KDDANA','LEFT OUTER');
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.KDKEGUNIT',session()->idSub)->where('A.KDTAHAP',session()->tahap);
			$builder->where('A.MTGKEY',session()->mtgkey);
			$notIn = "A.KDDANA not in (select KDDANA from Bpkdetrdana where MTGKEY='".session()->mtgkey."' and NOBPK= '".session()->nobpk."' and A.KDKEGUNIT= '".session()->idSub."')";
			$builder->where($notIn);
			$builder->orderBy('A.KDDANA');
			$rs = $builder->get()->getResult();

			return $rs;
		}
		public function inputSDTBP(){
			$post = array(
				"NILAI"=>'0',
				"KDDANA"=>session()->kdDana,
				"NOBPK"=>session()->nobpk,
				"UNITKEY"=>session()->kdUnit,
				"KDKEGUNIT"=>session()->idSub,
				"MTGKEY"=>session()->mtgkey
			);
			$this->db->table('Bpkdetrdana')->set($post)->insert($post);

			$q = "EXEC WSP_VAL_DPARDANA 
			@unitkey='".session()->kdUnit."',
			@kdtahap='".session()->tahap."',
			@mtgkey='".session()->mtgkey."',
			@kdkegunit='".session()->idSub."',
			@kddana='".session()->kdDana."',
			@dok='BPK',@nomorx='".session()->nobpk."'";
			$this->db->query($q);
			return;
		}
		public function updateRinciTBP($post){
			$q = "SET NOCOUNT ON; EXEC WSP_VAL_DPARDANA 
			@unitkey='".session()->kdUnit."',
			@kdtahap='".session()->tahap."',
			@mtgkey='".session()->mtgkey."',
			@kdkegunit='".session()->idSub."',
			@kddana='".$post['KDDANA']."',
			@dok='BPK',@nomorx='".session()->nobpk."'";
			$rs = $this->db->query($q)->getRow();

			$this->db->query("exec WSP_VALIDATIONBPK_BANK @unitkey='".session()->kdUnit."',@keybend='".session()->keybend."'");

			if((int)$rs->SISA < (int)$post['NILAI']){
				session()->setFlashData("info", "Sisa dana sebesar Rp.".number_format((int)$rs->SISA,2)." tidak mencukupi..!");
			}else{
				$update = array("NILAI"=>$post['NILAI']);
				$builder = $this->db->table('Bpkdetrdana')->where("KDDANA",$post['KDDANA'])->where("NOBPK",session()->nobpk);
				$builder->where("UNITKEY",session()->kdUnit)->where("KDKEGUNIT",session()->idSub)->where("MTGKEY",session()->mtgkey);
				$builder->update($update);

				$q = "Update BPKDETR SET NILAI=isnull((select sum(nilai) from Bpkdetrdana
				where UNITKEY= '".session()->kdUnit."' and NOBPK= '".session()->nobpk."' and MTGKEY= '".session()->mtgkey."' and KDKEGUNIT= '".session()->idSub."' ),0)
				where UNITKEY= '".session()->kdUnit."' and NOBPK= '".session()->nobpk."' and MTGKEY= '".session()->mtgkey."' and KDKEGUNIT= '".session()->idSub."'
				";
				$this->db->query($q);
				session()->setFlashData("info", "Data telah disimpan");
			}					
			return;
		}
		public function rincianBKUBP(){
			//CARI UNITKEY DARI SP2D D
			$q = "
			SELECT UNITKEY,NOBUKU as NOBUKTI,'NOBUKU' as BUKTI,'BKUBANK' as TABEL FROM BKUBANK WHERE NOBUKU = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOBKPAJAK as NOBUKTI,'NOBUKU' as BUKTI,'BKUBANK' as TABEL FROM BKUPAJAK WHERE NOBKPAJAK = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOBPK as NOBUKTI,'NOBPK' as BUKTI,'BPKDET' as TABEL FROM BKUBPK WHERE NOBPK = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOPANJAR as NOBUKTI,'NOBUKU' as BUKTI,'BKUBANK' as TABEL FROM BKUPANJAR WHERE NOPANJAR = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOSP2D as NOBUKTI,'NOSP2D' as BUKTI,'SP2DDET' as TABEL FROM BKUSP2D WHERE NOSP2D = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOSTS as NOBUKTI,'NOBUKU' as BUKTI,'BKUBANK' as TABEL FROM BKUSTS WHERE NOSTS = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOSTS as NOBUKTI,'NOBUKU' as BUKTI,'BKUBANK' as TABEL FROM BKUSTSPENDAPATAN WHERE NOSTS = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOTBP as NOBUKTI,'NOBUKU' as BUKTI,'BKUBANK' as TABEL FROM BKUTBP WHERE NOTBP = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOTBP as NOBUKTI,'NOBUKU' as BUKTI,'BKUBANK' as TABEL FROM BKUTBPPENDAPATAN WHERE NOTBP = '".session()->nobukti."'
			";
			$bd = $this->db->query($q)->getRow();
			$tabel = $bd->TABEL; $field = "S.".$bd->BUKTI;

      $builderD = $this->db->table($tabel.'D S')->select('KDPER,\'\' as KDKEGUNIT,NMPER,NILAI, \'SP2D\' as JENIS, \'6\' as IDXKODE');
      $builderD->join('MATANGD M','S.MTGKEY=M.MTGKEY','left outer');
      $builderD->where('S.UNITKEY',$bd->UNITKEY)->where($field,session()->nobukti)->where('S.NOJETRA','21');
      $query1 = $builderD->getCompiledSelect();

      $builderR = $this->db->table($tabel.'R S')->select('KDPER,KDKEGUNIT,NMPER,NILAI, \'SP2D\' as JENIS, \'6\'  as IDXKODE');
      $builderR->join('MATANGR M','S.MTGKEY = M.MTGKEY','left outer');
      $builderR->where('S.UNITKEY',$bd->UNITKEY)->where($field,session()->nobukti)->where('S.NOJETRA','21');
      $query2 = $builderR->getCompiledSelect();

      $builderB = $this->db->table($tabel.'B S')->select('KDPER,\'\' as KDKEGUNIT,NMPER,NILAI, \'SP2D\' as JENIS, \'6\' as IDXKODE');
      $builderB->join('MATANGB M','S.MTGKEY = M.MTGKEY','left outer');
      $builderB->where('S.UNITKEY',$bd->UNITKEY)->where($field,session()->nobukti)->where('S.NOJETRA','21');
      $query3 = $builderB->getCompiledSelect();

			$builderL = $this->db->table($tabel.'RTL S')->select('KDPER,\'\' as KDKEGUNIT,NMPER,NILAI, \'SP2D\' as JENIS, \'6\' as IDXKODE');
      $builderL->join('MATANGR M','S.MTGKEY = M.MTGKEY','left outer');
      $builderL->where('S.UNITKEY',$bd->UNITKEY)->where($field,session()->nobukti)->where('S.NOJETRA','21');
      $query4 = $builderL->getCompiledSelect();

			$q = $query1.' UNION ALL '.$query2.' UNION ALL '.$query3.' UNION ALL '.$query4;
			//echo nl2br($q);
      return $this->db->query($q)->getResult();
		}

		/* ==================== SPJ ======================*/
		public function listSPJ(){
			$q = "SELECT distinct 0 as ALLOWSUPERUSER,A.IDXKODE,rtrim(A.IDXTTD) as IDXTTD,rtrim(A.KDSTATUS) as KDSTATUS,A.KETERANGAN,rtrim(A.KEYBEND) as KEYBEND,
			A.NOSAH,A.NOSPJ,A.TGLBUKU,A.TGLSAH,A.TGLSPJ,A.TGLVALID,A.UNITKEY, B.NIP,rtrim(C.KDUNIT) as KDUNIT, rtrim(C.NMUNIT) as NMUNIT,
			D.KDDOK,E.LBLSTATUS, E.URAIAN as URAISTATUS,F.URAIAN as URAIKODE
			from PSPJ A
			left outer join BEND B on A.KEYBEND = B.KEYBEND
			left outer join DAFTUNIT C on A.UNITKEY = C.UNITKEY
			left outer join JABTTD D on A.IDXTTD = D.IDXTTD
			left outer join STATTRS E on A.KDSTATUS=E.KDSTATUS
			left outer join ZKODE F on A.IDXKODE = F.IDXKODE
			where 
			(
				A.UNITKEY= '".session()->kdUnit."' or 
				A.UNITKEY in (
					select unitkeyuk from daftunituk where unitkeyskpd= '".session()->kdUnit."' 
				)
			) and 
			A.IDXKODE= '2' and A.KEYBEND= '".session()->keybend."' and A.KDSTATUS not in ('20') order by A.NOSPJ";
			$rs = $this->db->query($q)->getResult();
			return $rs;
		}
		public function rincSPJBPK(){
			$nilai = "NILAI = isnull(
				(select sum(isnull(NILAI,0)) from BPKDETR C where C.UNITKEY=A.UNITKEY and C.NOBPK=A.NOBPK),0)+isnull(
					(select sum(isnull(NILAI,0)) from BPKDETRTL C where C.UNITKEY=A.UNITKEY and C.NOBPK=A.NOBPK),0)";
			$builder = $this->db->table("BPKSPJ A")->select("A.NOBPK,A.NOSPJ,A.UNITKEY,B.TGLBPK,B.URAIBPK,".$nilai);
			$builder->where("A.UNITKEY",session()->kdUnit)->where("A.NOSPJ",session()->noSPJ)->whereNotIn("B.KDSTATUS",["20"])->orderBy('A.NOBPK');
			$builder->join("BPK B","A.UNITKEY=B.UNITKEY and A.NOBPK=B.NOBPK","LEFT OUTER");
			$rs = $builder->get()->getResult();
			return $rs;
		}

		public function rinciSPJSubKeg(){
			$q = "SELECT DISTINCT 
			UNITKEY,MTGKEY as KDKEGUNIT,KDPER,NMPER,NILAI,TYPE,'".session()->noSPJ."' as NOSPJ 
			FROM (
				SELECT UNITKEY,MTGKEY,KDPER,NMPER,[TYPE],NILAI,KDKEGUNIT FROM
				(
					SELECT K.UNITKEY,K.KDKEGUNIT,K.KDKEGUNIT as MTGKEY, rtrim(isnull(UR.KDUNIT,(select rtrim(numdigit) from struunit where kdlevel='2')))+rtrim(MP.NUPRGRM)+rtrim(MK.NUKEG) as KDPER, 
					MK.NMKEGUNIT as NMPER,'D' as TYPE, NILAI=(
						select sum(NILAI) from SPJDETR where (UNITKEY=  '".session()->kdUnit."' OR 
						UNITKEY IN (SELECT UNITKEYUK FROM DAFTUNITUK WHERE UNITKEYSKPD= '".session()->kdUnit."')) and 
						NOSPJ= '".session()->noSPJ."' and KDKEGUNIT=K.KDKEGUNIT
					)
					from KEGUNIT K
					left outer join MKEGIATAN MK on MK.KDKEGUNIT=K.KDKEGUNIT
					left outer join MPGRM MP on MK.IDPRGRM = MP.IDPRGRM
					left outer join DAFTUNIT UR on MP.UNITKEY = UR.UNITKEY
					left outer join DAFTUNIT UN on K.UNITKEY = UN.UNITKEY
			
					UNION ALL
			
					SELECT UNITKEY,'00' KDKEGUNIT,'00' MTGKEY,'00' KDPER,'SPJ BTL' NMPER,'D' [TYPE],SUM(NILAI) NILAI 
					FROM SPJDETRTL 
					WHERE UNITKEY= '".session()->kdUnit."' and NOSPJ = '".session()->noSPJ."'
					GROUP BY UNITKEY
				)K
				where K.UNITKEY = '".session()->kdUnit."' and K.KDKEGUNIT	in (
					select KDKEGUNIT from SPJDETR 
					where (UNITKEY= '".session()->kdUnit."' OR UNITKEY IN (
						SELECT UNITKEYUK FROM DAFTUNITUK WHERE UNITKEYSKPD= '".session()->kdUnit."')) and NOSPJ= '".session()->noSPJ."'
						UNION ALL
						select '00' KDKEGUNIT from SPJDETRTL where UNITKEY= '".session()->kdUnit."'  and NOSPJ= '".session()->noSPJ."'
					)
			)A
			where UNITKEY = '".session()->kdUnit."' 
			order by KDPER
			";
			$rs = $this->db->query($q)->getResult();
			return $rs;
		}
		public function detilSPJRekening(){
			$builder = $this->db->table("SPJDETR A");
			$builder->select('A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPJ,A.UNITKEY,rtrim(A.KDDANA) as KDDANA,A.KDKEGUNIT,');
			$builder->select('B.IDXKODE,rtrim(C.KDPER) as KDPER, rtrim(C.NMPER) as NMPER,E.NMDANA,D.KDPERS,\'\' as NUKEG,\'\' as NMKEGUNIT');
			$builder->join('PSPJ B','A.NOSPJ = B.NOSPJ and A.UNITKEY = B.UNITKEY', 'LEFT OUTER');
			$builder->join('MATANGR C','A.MTGKEY = C.MTGKEY', 'LEFT OUTER');
			$builder->join('JTRNLKAS D','A.NOJETRA = D.NOJETRA', 'LEFT OUTER');
			$builder->join('JDANA E','A.KDDANA = E.KDDANA', 'LEFT OUTER');
			$builder->where('B.UNITKEY',session()->kdUnit)->where('B.NOSPJ',session()->noSPJ)->where('A.KDKEGUNIT',session()->idSub)->where('A.NOJETRA','41');
			$builder->orderBy('C.KDPER');
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function simpanSPJ($post){
			$builder = $this->db->table("PSPJ")->set($post)->insert($post);
			return;
		}
		public function BPKList(){
			$builder = $this->db->table('WEBSET')->select('VALSET')->where('KDSET','spjbku')->get()->getRow();
			$builder = $this->db->table('BPK B')->select('B.NOBPK,convert(char(10),B.TGLBPK, 103) as TGLBPK,rtrim(left(B.URAIBPK,80)) as URAIBPK,BD.JNS_BEND+\'-\'+P.NAMA as NAMA');
			$builder->join('BEND BD','B.KEYBEND=BD.KEYBEND','LEFT OUTER')->join('PEGAWAI P','P.NIP=BD.NIP','LEFT OUTER');
			$builder->where('B.UNITKEY',session()->kdUnit)->where('B.IDXKODE','2');
			$builder->where("(('42' = '42' AND B.KDSTATUS in ('21','22')and(B.KEYBEND= '".session()->keybend."' or isnull('".session()->keybend."','')='' ))");
			$builder->orWhere("('42' ='43' and B.KDSTATUS='23' and B.KEYBEND= '".session()->keybend."'))");
			$builder->where("B.NOBPK not in (select NOBPK from BPKSPJ where UNITKEY= '".session()->kdUnit."')");// and IDXKODE='2'
			if($builder->KDSET == 'Y'){
				$builder->distinct();
				//echo nl2br($builder->getCompiledSelect());die();
				$rs = $builder->get()->getResult();
			}else{
				$builder->where("B.NOBPK in (select NOBPK from BKUBPK where UNITKEY= '".session()->kdUnit."')");
				$builder->distinct();
				
				$rs = $builder->get()->getResult();
			}
			return $rs;
		}
		public function insertBPKSPJ($post){
			$builder = $this->db->table("BPKSPJ")->set($post)->insert($post);
			$rs=$this->db->table('PSPJ')->select('convert(char(10),TGLSPJ, 101) as TGLSPJ')->where('NOSPJ',session()->noSPJ)->get()->getRow();
			$update = array('TGLVALID'=>$rs->TGLSPJ);
			$builder = $this->db->table("BPK")->where('UNITKEY',session()->kdUnit)->where('NOBPK',$post['NOBPK'])->update($update);
			$q =  "WSP_TRANSFER_BPKSPJ @unitkey='".session()->kdUnit."',@nobpk='".$post['NOBPK']."',@nospj='".session()->noSPJ."'";
			$this->db->query($q);
			return;
		}


		/* ============ PAJAK =================*/
		public function listPajak(){
			$builder = $this->db->table("BKPAJAK A");
			$builder->select('\'0\' as ALLOWSUPERUSER,rtrim(A.IDXTTD) as IDXTTD,rtrim(A.KDSTATUS) as KDSTATUS,rtrim(A.KEYBEND) as KEYBEND,');
			$builder->select('A.NOBKPAJAK,A.TGLBKPAJAK,A.TGLVALID,A.UNITKEY,A.URAIAN,C.NOBPK,A.NTPN');
			$builder->join('BPKPAJAK B','b.UNITKEY=a.UNITKEY and b.NOBKPAJAK=a.NOBKPAJAK', 'LEFT OUTER');
			$builder->join('BPK C','B.UNITKEY=C.UNITKEY and B.NOBPK=C.NOBPK', 'LEFT OUTER');
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.KEYBEND',session()->keybend)->where('A.KDSTATUS','35');
			$builder->where('(isnull(B.KDKEGUNIT,\'\')=isnull(\''.session()->idSub.'\',\'\') or isnull(\''.session()->idSub.'\',\'\')=\'\')');
			$builder->orderBy('A.NOBKPAJAK');
			//echo nl2br($builder->getCompiledSelect());die();
			$rs = $builder->get()->getResult();
			return $rs;
		}
	}
?>