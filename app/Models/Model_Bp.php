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
			$builder = $this->db->table('SPP S')->select("'0' as SUPERUSER");
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
				}else{
				}
			}
			if(session()->jnsSpp == "gu"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23])->distinct();
			}
			if(session()->jnsSpp == "ls"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode);//->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where("(isnull(D.KDKEGUNIT,'')=isnull('".session()->idSub."','') or isnull('".session()->idSub."','')='' or D.KDKEGUNIT is null) AND '".session()->idSub."' is not null");
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[24,25])->distinct();
			}
			if($tgl != NULL){
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
				if(session()->jnsSpp == "up"){
					$builder = $this->db->table('SPPDETB');
					$builder->set($detb);
					$builder->insert($detb);
					}
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
			$row = $this->db->table('SPJSPP')->select('NOSPP,NOSPJ')->where('UNITKEY',session()->kdUnit)->where("NOSPP",session()->nospp)->get()->getRow();
			if($row->NOSPP != ''){
				session()->setFlashData("info", "Tidak dapat menghapus data, SPP masih digunakan di tabel SPPSPJ <i>No. ".$row->NOSPJ."</i>");
				return;
			}
			$row = $this->db->table('SPPDETB')->select('NOSPP')->where('PENOLAKAN','0')->where("NOSPP",session()->nospp)->get()->getRow();
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
		public function hapusRinciSPP(){
			$builder = $this->db->table('SPP A')->select('A.NOSPP,convert(char(10), A.TGLVALID, 101) AS TGLVALID,B.NOSPM');
			$builder->join('ANTARBYR B','A.UNITKEY = B.UNITKEY AND A.KEYBEND = B.KEYBEND AND A.NOSPP = B.NOSPP','LEFT OUTER');
			$builder->where('A.UNITKEY',session()->kdUnit)->where("A.NOSPP",session()->nospp);
			$rs = $builder->get()->getRow();
			$err = "";
			if($rs->TGLVALID != ''){
				$err .= "SPP telah divalidasi tanggal ".$rs->TGLVALID;
			}
			if($rs->NOSPM != ""){
				$err .= " SPP Sudah dijadikan SPM No. ".$rs->NOSPM;
			}
			if($err != ""){
				session()->setFlashData("info", "Tidak dapat menghapus data, <i>".$err."</i>");
				return;
			}
			/*
			$row = $this->db->table('SPPDETB')->select('NOSPP')->where('PENOLAKAN','0')->where("NOSPP",session()->nospp)->get()->getRow();
			if($row->NOSPP != ''){
				$notIn = "NOSPP NOT IN (SELECT NOSPP FROM ANTARBYR WHERE UNITKEY = '".session()->kdUnit."')";
				$builder = $this->db->table('SPPDETB')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->where($notIn)->delete();
				$builder = $this->db->table('SPPDETR')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->where($notIn)->delete();
				$builder = $this->db->table('SPP')->where("NOSPP",session()->nospp)->where('UNITKEY',session()->kdUnit)->where($notIn)->delete();
				session()->setFlashData("info", "Validasi SPP Berhasil");
			}else{
				session()->setFlashData("info", "Tidak dapat menghapus data, SPP telah di validasi");
			}
			*/
			return;
		}
		public function hapusRinciSPPLS(){
			$builder = $this->db->table('SPP A')->select('A.NOSPP,convert(char(10), A.TGLVALID, 101) AS TGLVALID,B.NOSPM');
			$builder->join('ANTARBYR B','A.UNITKEY = B.UNITKEY AND A.KEYBEND = B.KEYBEND AND A.NOSPP = B.NOSPP','LEFT OUTER');
			$builder->where('A.UNITKEY',session()->kdUnit)->where("A.NOSPP",session()->nospp);
			$rs = $builder->get()->getRow();
			$err = "";
			if($rs->TGLVALID != ''){
				$err .= "SPP telah divalidasi tanggal ".$rs->TGLVALID;
			}
			if($rs->NOSPM != ""){
				$err .= " SPP Sudah dijadikan SPM No. ".$rs->NOSPM;
			}
			if($err != ""){
				session()->setFlashData("info", "Tidak dapat menghapus data, <i>".$err."</i>");
				return;
			}
			$builder = $this->db->table('SPPDETR')->where('UNITKEY',session()->kdUnit)->where("NOSPP",session()->nospp);
			$builder->where('MTGKEY',session()->mtgkey)->delete();
			$this->utama->setFlashData('Gagal menghapus rincian SPP!','Rincian SPP telah dihapus');
			
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
				$builder = $this->db->table('SPJSPP A');
				$builder->select("A.NOSPJ,A.NOSPP,A.UNITKEY, J.IDXKODE, J.KETERANGAN+' - '+K.NMUNIT KETERANGAN, J.KEYBEND, J.TGLSPJ, J.TGLBUKU, J.KDSTATUS,");
				$builder->select("NILAI = isnull((select sum(isnull(NILAI,0)) from SPJDETR C where C.NOSPJ=A.NOSPJ),0) +isnull((select sum(isnull(NILAI,0)) 
				from SPJDETRTL C where C.NOSPJ=A.NOSPJ),0)");
				$builder->join('PSPJ J','A.NOSPJ=J.NOSPJ','LEFT OUTER')->join(' DAFTUNIT K','J.UNITKEY=K.UNITKEY','INNER');
				$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOSPP',session()->nospp)->orderBy('A.NOSPJ');
			}
			if(session()->jnsSpp == "ls"){
				$builder = $this->db->table('SPPDETR A');
				$builder->select("A.KDKEGUNIT,A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPP,A.UNITKEY ,B.IDXKODE,");
				$builder->select("rtrim(C.KDPER) as KDPER, rtrim(C.NMPER) as NMPER, C.TYPE ,D.KDPERS");
				$builder->join('SPP B','A.NOSPP = B.NOSPP and A.UNITKEY = B.UNITKEY','LEFT OUTER');
				$builder->join('MATANGR C','A.MTGKEY = C.MTGKEY','LEFT OUTER');
				$builder->join('JTRNLKAS D','A.NOJETRA = D.NOJETRA','LEFT OUTER');
				$builder->where('B.UNITKEY',session()->kdUnit)->where('B.NOSPP',session()->nospp)->where('A.NOJETRA','21');
				$builder->where('A.KDKEGUNIT',session()->idSub)->orderBy('C.KDPER');
			}
			//echo session()->kdUnit." ".session()->Idxkode;//die();
			return $builder->get()->getResult();
		}
		public function RekLSList(){
			$builder = $this->db->table('DASKR A')->distinct()->join('MATANGR B','A.mtgkey = B.mtgkey','LEFT OUTER');
			$builder->select('B.KDPER, B.NMPER,B.MTGKEY,B.TYPE');
			$builder->where("A.UNITKEY in (select UNITKEY from DAFTUNIT where KDUNIT= '".session()->kdSatker.".')")->where('KDKEGUNIT',session()->idSub);
			$builder->where("A.IDXDASK in (select IDXDASK from SKDASK where UNITKEY in (select UNITKEY from DAFTUNIT where KDUNIT= '".session()->kdSatker.".')");
			$builder->where("(IDXKODE='2' or IDXKODE='6')")->where("KDTAHAP= '".session()->tahap."' and TGLVALID is not NULL)");
			$builder->where("A.MTGKEY not in (select MTGKEY from SPPDETR S where S.UNITKEY= '".session()->kdUnit."' and S.NOSPP= '".session()->nospp."' and S.KDKEGUNIT= '".session()->idSub."' and S.NOJETRA= '21' )");
//			echo nl2br($builder->getCompiledSelect());die();
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function rinciSDLS(){
			$builder = $this->db->table('Sppdetrdana B')->select('B.NOSPP,B.KDDANA,B.MTGKEY,B.UNITKEY,C.NMDANA,B.NILAI,b.KDKEGUNIT');
			$builder->join('JDANA C','B.KDDANA=C.KDDANA','INNER')->where('B.KDKEGUNIT',session()->idSub);
			$builder->where('B.UNITKEY',session()->kdUnit)->where('B.NOSPP',session()->nospp)->where('B.MTGKEY',session()->mtgkey);
			$builder->orderBy('B.KDDANA');
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function listSDLS(){
			$builder = $this->db->table('SBDANAR A')->select('rtrim(A.KDDANA) as KDDANA,A.KDKEGUNIT,A.KDTAHAP,A.MTGKEY,A.NILAI,A.UNITKEY, B.NMDANA');
			$builder->join('JDANA B','A.KDDANA = B.KDDANA','LEFT OUTER')->where('A.KDKEGUNIT',session()->idSub);
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.MTGKEY',session()->mtgkey)->where('A.KDTAHAP',session()->tahap);
			$builder->where("A.KDDANA not in (select KDDANA from Sppdetrdana where MTGKEY= '".session()->mtgkey."' and NOSPP= '".session()->nospp."' and KDKEGUNIT= '".session()->idSub."')");
			$builder->orderBy('A.KDDANA');
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function inputSDLS($post){
			$this->db->table('Sppdetrdana')->set($post)->insert($post);
			$this->utama->setFlashData('Gagal menambah data','Data Sumber Dana berhasil ditambahkan..!');
			return;
		}
		public function updateRinciLS($sd,$nil){
			$update = array('NILAI'=>(int)$nil);
			$q = "SET NOCOUNT ON; exec WSP_VAL_DPARDANA @unitkey='".session()->kdUnit."',@kdtahap='".session()->tahap."',@mtgkey='".session()->mtgkey."',@kdkegunit='".session()->idSub."',@kddana='".$sd."',@dok='SPP',@nomorx='".session()->nospp."'";
			$rs = $this->db->query($q)->getRow();

			if($rs->SISA > (int)$nil){
				$builder = $this->db->table('Sppdetrdana')->where('KDKEGUNIT',session()->idSub)->where('MTGKEY',session()->mtgkey);
				$builder->where('KDDANA',$sd)->where('NOSPP',session()->nospp)->where('UNITKEY',session()->kdUnit)->update($update);
				//$this->utama->setFlashData('Gagal menambah data','Data ditambahkan..!');

				$q = "Update SPPDETR SET NILAI=isnull(
				(select sum(nilai) from Sppdetrdana where UNITKEY= '".session()->kdUnit."' and NOSPP='".session()->nospp."' and MTGKEY= '".session()->mtgkey."' and KDKEGUNIT= '".session()->idSub."' )
				,0) where UNITKEY= '".session()->kdUnit."' and NOSPP='".session()->nospp."' and MTGKEY= '".session()->mtgkey."' and KDKEGUNIT= '".session()->idSub."'";
				$this->db->query($q);
			}
			return;
		}
		public function hapusRinciLS($sd){
			$builder = $this->db->table('Sppdetrdana')->where('KDKEGUNIT',session()->idSub)->where('MTGKEY',session()->mtgkey);
			$builder->where('KDDANA',$sd)->where('NOSPP',session()->nospp)->where('UNITKEY',session()->kdUnit)->delete();
			$this->utama->setFlashData('Gagal menambah data','Data berhasil dihapus..!');

			$q = "Update SPPDETR SET NILAI=isnull(
			(select sum(nilai) from Sppdetrdana where UNITKEY= '".session()->kdUnit."' and NOSPP='".session()->nospp."' and MTGKEY= '".session()->mtgkey."' and KDKEGUNIT= '".session()->idSub."' )
			,0) where UNITKEY= '".session()->kdUnit."' and NOSPP='".session()->nospp."' and MTGKEY= '".session()->mtgkey."' and KDKEGUNIT= '".session()->idSub."'";
			$this->db->query($q);
			return;
		}
		public function tambahROLS($post){
			$mk = explode(",",$post);
			for($n=0;$n<sizeof($mk);$n++){
				$builder = $this->db->table('SPPDETR');
				$data = array(
					"MTGKEY"=>$mk[$n],
					"NILAI"=>"0",
					"NOJETRA"=>"21",
					"KDKEGUNIT"=>session()->idSub,
					"NOSPP"=>session()->nospp,
					"UNITKEY"=>session()->kdUnit
				);
				$builder->set($data);
				$builder->insert($data);
			}
			return;
		}
		public function SPJList() {
			$opsi = $this->utama->getWebset('bppgu');
			if($opsi == 'Y'){
				$builder = $this->db->table('PSPJ A');
				$builder->select('A.NOSPJ,convert(char(10),A.TGLSPJ, 103) as TGLSPJ,rtrim(left(A.KETERANGAN,100)) As KETERANGAN');
				$builder->where('A.UNITKEY',session()->kdUnit)->where('A.TGLSAH IS NOT',null)->where("(A.KDSTATUS='42' and '22' ='22')")->where('IDXKODE','2');
				$builder->where("(A.KEYBEND= '".trim(session()->keybend)."' or (A.KEYBEND is null or A.KEYBEND=''))");
				$builder->where("A.NOSPJ not in (select NOSPJ from SPJSPP where UNITKEY= '".session()->kdUnit."')")->orderBy('A.NOSPJ');
			}else{
				$builder = $this->db->table('PSPJ A');
				$builder->select('A.NOSPJ,convert(char(10),A.TGLSPJ, 103) as TGLSPJ,rtrim(left(A.KETERANGAN,100)) As KETERANGAN');
				$builder->where("(A.UNITKEY= '".trim(session()->kdUnit)."' OR A.UNITKEY IN(SELECT UNITKEYUK FROM DAFTUNITUK WHERE UNITKEYSKPD= '".trim(session()->kdUnit)."' ))");
				$builder->where('A.TGLSAH IS NOT',null)->where("(A.KDSTATUS='42' and '22' ='22')")->where('IDXKODE','2');
				$builder->where("A.NOSPJ not in (select NOSPJ from SPJSPP where UNITKEY= '".session()->kdUnit."')")->orderBy('A.NOSPJ');
			}
			//echo nl2br($builder->getCompiledSelect());die();
			return $builder->get()->getResult();
		}
		public function tambahSPJSPP($post){
			$this->db->table('SPJSPP')->set($post)->insert($post);
			$q = "EXEC WSP_TRANSFER_SPJSPP @unitkey='".session()->kdUnit."',@nospj='".$post['NOSPJ']."',@nospp='".session()->nospp."'";
			$this->db->query($q);
		}
		public function rincianSPJSPP(){
			$q = "
			select distinct 
			UNITKEY,MTGKEY as KDKEGUNIT,KDPER,NMPER,NILAI,TYPE,'".session()->nospp."' as NOSPP, '' as NUPRGRM 
			from ( 
				select distinct '".session()->kdUnit."' UNITKEY,K.KDKEGUNIT as MTGKEY, rtrim(isnull(UR.KDUNIT,(
					select rtrim(numdigit) 
					from 
					struunit where kdlevel='2')))+rtrim(MP.NUPRGRM)+rtrim(MK.NUKEG) as KDPER, MK.NMKEGUNIT as NMPER,'D' as TYPE, 
					NILAI=(
						select 
						sum(NILAI) from SPPDETR where UNITKEY= '".session()->kdUnit."' and NOSPP= '".session()->nospp."'and KDKEGUNIT=K.KDKEGUNIT) 
						from KEGUNIT K left outer join MKEGIATAN MK on MK.KDKEGUNIT=K.KDKEGUNIT 
						left outer join MPGRM MP on MK.IDPRGRM = MP.IDPRGRM 
						left outer join DAFTUNIT UR on MP.UNITKEY = UR.UNITKEY 
						left outer join DAFTUNIT UN on K.UNITKEY = UN.UNITKEY 
						where (K.UNITKEY = '".session()->kdUnit."' OR K.UNITKEY IN(SELECT UNITKEYUK FROM DAFTUNITUK WHERE UNITKEYSKPD= '".session()->kdUnit."' )) and 
						K.KDKEGUNIT in (select KDKEGUNIT from SPPDETR where UNITKEY= '".session()->kdUnit."' and NOSPP= '".session()->nospp."' )
			)A 
			where UNITKEY ='".session()->kdUnit."' 
			order by KDPER
			";
			$rs = $this->db->query($q)->getResult();
			return $rs;
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
				$notIn = "S.NOSPP NOT IN (SELECT NOSPP FROM ANTARBYR WHERE UNITKEY = '" .session()->kdUnit . "' AND KDSTATUS='22')";
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend)->where($notIn);
				$builder->whereIn('S.KDSTATUS',[22,23])->distinct();
			}
			if($tgl != NULL){
				$whereDate = 'Convert(char(10), S.TGLVALID, 101) <= Convert(datetime, \''.$tgl.'\')';
				$builder->where($whereDate)->where('S.UNITKEY',session()->kdUnit);
			}
			if(session()->jnsSpm == "ls"){
				$builder = $this->db->table('SPP A')->orderBy('rtrim(A.NOSPP)')->distinct();
				$builder->select("rtrim(A.NOSPP) as NOSPP ,convert(char(10), A.TGSPP, 101) as TGSPP ,convert(char(10), A.TGLVALID, 101) as TGLVALID ,rtrim(A.KEPERLUAN) as URAIAN");
				$builder->select('A.IDXSKO,SK.NOSKO');
				$builder->join('SPPDETR s','s.UNITKEY = A.UNITKEY AND s.NOSPP = A.NOSPP','INNER');
				$builder->join('MKEGIATAN m','m.KDKEGUNIT = s.KDKEGUNIT','INNER');
				$builder->join('SKO SK','A.IDXSKO = SK.IDXSKO','LEFT OUTER');
				$notIn = "A.NOSPP NOT IN (SELECT isnull(NOSPP,'') FROM ANTARBYR WHERE UNITKEY = '" .session()->kdUnit . "')";
				$builder->where('A.UNITKEY',session()->kdUnit)->where("isnull(A.PENOLAKAN,1)=1")->where('A.IDXKODE',session()->Idxkode);
				$builder->where('A.KDSTATUS','24')->where('s.KDKEGUNIT',session()->idSub)->where($notIn);
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
      $builder->join('SP2D SP2D','A.NOSPM = SP2D.NOSPM', 'LEFT OUTER');
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
				$builder = $this->db->table('ANTARBYR A')->distinct();
				$builder->select("'0' as ALLOWSUPERUSER,A.IDXKODE,A.IDXSKO,rtrim(A.IDXTTD) as IDXTTD,rtrim(A.KDSTATUS) as KDSTATUS, isnull((A.KEPERLUAN),'')KEPERLUAN,");
				$builder->select("isnull((A.NOKONTRAK),'')NOKONTRAK, A.KDP3, isnull((DP3.NMP3),'')NMP3, A.KETOTOR,rtrim(A.KEYBEND) as KEYBEND,A.NOREG,A.NOSPM,A.NOSPP,");
				$builder->select("A.PENOLAKAN,convert(char(10), A.TGLSPM, 101) AS TGLSPM,convert(char(10), a.TGLVALID, 101) AS TGLVALID,");
				$builder->select("A.TGSPP,A.UNITKEY, SK.TGLSKO,SK.NOSKO, '' as KDKEGUNIT, A.KDDANA,A.KDKABKOT,C.NOSP2D");
				$builder->join('SPMDETR D','A.NOSPM = D.NOSPM and A.UNITKEY = D.UNITKEY','LEFT OUTER');
				$builder->join('SKO SK','A.IDXSKO = SK.IDXSKO and A.UNITKEY = SK.UNITKEY','LEFT OUTER');
				$builder->join('DAFTPHK3 DP3','A.KDP3 = DP3.KDP3','LEFT OUTER');
				$builder->join('BEND B','A.KEYBEND=B.KEYBEND','LEFT OUTER');
				$builder->join('SP2D C','A.NOSPM=C.NOSPM','LEFT OUTER');
				$builder->join('JBEND J','B.JNS_BEND = J.JNS_BEND','LEFT OUTER');
				$builder->where('A.UNITKEY',session()->kdUnit)->where('A.IDXKODE','2')->where("( '2' not in ('2') or ( '2' ='2' and A.KDSTATUS in ('22','23')))");
				$builder->where('A.KEYBEND',session()->keybend)->orderBy('A.NOSPM');
				//echo nl2br($builder->getCompiledSelect());die();
			}
			if(session()->jnsSpm == "ls"){
				$builder = $this->db->table('ANTARBYR A')->distinct();
				$builder->select("'0' as ALLOWSUPERUSER,A.IDXKODE,A.IDXSKO,rtrim(A.IDXTTD) as IDXTTD,rtrim(A.KDSTATUS) as KDSTATUS, isnull((A.KEPERLUAN),'')KEPERLUAN,");
				$builder->select("isnull((A.NOKONTRAK),'')NOKONTRAK, A.KDP3, isnull((DP3.NMP3),'')NMP3, A.KETOTOR,rtrim(A.KEYBEND) as KEYBEND,A.NOREG,A.NOSPM,A.NOSPP,");
				$builder->select("A.PENOLAKAN,convert(char(10), A.TGLSPM, 101) AS TGLSPM,convert(char(10), a.TGLVALID, 101) AS TGLVALID,");
				$builder->select("A.TGSPP,A.UNITKEY, SK.TGLSKO,SK.NOSKO, isnull(D.KDKEGUNIT, '".session()->idSub."' ) as KDKEGUNIT,rtrim(MK.NUKEG) as NUKEG,");
				$builder->select("rtrim(MK.NMKEGUNIT) as NMKEGUNIT,A.KDDANA,A.KDKABKOT,C.NOSP2D");
				$builder->join('SPMDETR D','A.NOSPM = D.NOSPM and A.UNITKEY = D.UNITKEY','LEFT OUTER');
				$builder->join('SKO SK','A.IDXSKO = SK.IDXSKO and A.UNITKEY = SK.UNITKEY','LEFT OUTER');
				$builder->join('DAFTPHK3 DP3','A.KDP3 = DP3.KDP3','LEFT OUTER');
				$builder->join('MKEGIATAN MK','D.KDKEGUNIT = MK.KDKEGUNIT','LEFT OUTER');
				$builder->join('SP2D C','A.NOSPM=C.NOSPM','LEFT OUTER');
				$builder->where('A.UNITKEY',session()->kdUnit)->where('A.IDXKODE','2')->whereIn("A.KDSTATUS",['24','25'])->where('D.KDKEGUNIT',session()->idSub);
				$builder->where('A.KEYBEND',session()->keybend)->orderBy('A.NOSPM');
				//echo nl2br($builder->getCompiledSelect());die();
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
				$this->utama->setFlashData("SPM telah berhasil disimpan",'Tidak dapat menyimpan data SPM.',"info");
			}else{
				$builder = $this->db->table('SPPDETB');
				//$builder->where('UNITKEY',session()->kdUnit)->where('NOREG',session()->noreg)->update($post);
			}
			return;
		}
		public function simpanSPMGU($post){
			$this->db->table('ANTARBYR')->set($post)->insert($post);
			$q = "EXEC WSP_TRANSFER_SPPSPM @nospp='".$post['NOSPP']."',@nospm='".$post['NOSPM']."',@unitkey='".session()->kdUnit."'";
			$this->db->query($q);
			$this->utama->setFlashData('Tidak dapat menyimpan data SPM.',"SPM telah berhasil disimpan","info");
			return;
		}
		public function simpanSPMLS($post){
			$this->db->table('ANTARBYR')->set($post)->insert($post);
			$q = "EXEC WSP_TRANSFER_SPPSPM @nospp='".$post['NOSPP']."',@nospm='".$post['NOSPM']."',@unitkey='".session()->kdUnit."'";
			$this->db->query($q);
			$this->utama->setFlashData('Tidak dapat menyimpan data SPM.',"SPM telah berhasil disimpan","info");
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
				//echo nl2br($builder->getCompiledSelect());die();
				return $builder->get()->getResult();
			}
			if(session()->jnsSpm == "gu"){
				$q = "
				select distinct 
				UNITKEY,MTGKEY as KDKEGUNIT,KDPER,NMPER,NILAI,TYPE, '".session()->nospm."' as NOSPM 
				from ( 
					select '".session()->kdUnit."' UNITKEY,K.KDKEGUNIT as MTGKEY, rtrim(isnull(UR.KDUNIT,(select rtrim(numdigit) 
					from struunit where kdlevel='2')))+rtrim(MP.NUPRGRM)+rtrim(MK.NUKEG) as KDPER, MK.NMKEGUNIT as NMPER,'D' as TYPE, 
					NILAI=(select sum(NILAI) from SPMDETR where UNITKEY= '".session()->kdUnit."' and NOSPM= '".session()->nospm."' and KDKEGUNIT=K.KDKEGUNIT) 
					from KEGUNIT K left outer join MKEGIATAN MK on MK.KDKEGUNIT=K.KDKEGUNIT left outer join MPGRM MP on MK.IDPRGRM = MP.IDPRGRM 
					left outer join DAFTUNIT UR on MP.UNITKEY = UR.UNITKEY left outer join DAFTUNIT UN on K.UNITKEY = UN.UNITKEY 
					where (K.UNITKEY = '".session()->kdUnit."' OR K.UNITKEY IN (SELECT UNITKEYUK FROM DAFTUNITUK WHERE UNITKEYSKPD= '".session()->kdUnit."' )) and 
					K.KDKEGUNIT in (select KDKEGUNIT from SPMDETR 
				where 
				UNITKEY= '".session()->kdUnit."' and NOSPM= '".session()->nospm."' ) 
				)A 
				where UNITKEY = '".session()->kdUnit."'
				order by KDPER
				";
				$rs = $this->db->query($q)->getResult();
				return $rs;
			}
			if(session()->jnsSpm == "ls"){
				$builder = $this->db->table('SPMDETR A')->orderBy('D.KDPER');
				$builder->select('A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPM,A.UNITKEY,A.KDKEGUNIT ,B.IDXKODE ,C.KDPERS, D.TYPE ,rtrim(D.KDPER) as KDPER, rtrim(D.NMPER) as NMPER');
				$builder->join('ANTARBYR B','A.NOSPM = B.NOSPM and A.UNITKEY = B.UNITKEY','LEFT OUTER');
				$builder->join('JTRNLKAS C','A.NOJETRA = C.NOJETRA','LEFT OUTER');
				$builder->join('MATANGR D','A.MTGKEY = D.MTGKEY','LEFT OUTER');
				$builder->where('B.UNITKEY',session()->kdUnit)->where('B.NOSPM',session()->nospm)->where('A.NOJETRA','21')->where('A.KDKEGUNIT',session()->idSub);
				$rs = $builder->get()->getResult();
				return $rs;
			}
		}
		public function listLsPotongan(){
			$q = "select * from (
				select A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPM,A.UNITKEY ,rtrim(D.KDPER) as KDPER, rtrim(D.NMPER) as NMPER 
				from SPMDETB A 
				left outer join MATANGB D on A.MTGKEY = D.MTGKEY 
				where 
				A.UNITKEY = '".session()->kdUnit."' and A.NOSPM = '".session()->nospm."' and A.NOJETRA in ('23') 
				
				union 
				
				select A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPM,A.UNITKEY ,rtrim(D.KDPER) as KDPER, rtrim(D.NMPER) as NMPER 
				from SPMDETR A 
				left outer join MATANGR D on A.MTGKEY = D.MTGKEY 
				where 
				A.UNITKEY = '".session()->kdUnit."' and A.NOSPM = '".session()->nospm."' and A.NOJETRA in ('23') 
			)A 
			order by KDPER";
			$rs = $this->db->query($q)->getResult();
			return $rs;
		}
		public function hapusPotonganLS($pjk){
			$builder = $this->db->table('SPMDETB')->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nospm)->where('MTGKEY',$pjk)->where('NOJETRA','23')->delete();
			$builder = $this->db->table('SPMDETR')->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nospm)->where('MTGKEY',$pjk)->where('NOJETRA','23')->delete();
			return;
		}
		public function tambahPotonganLS($post){
			$mk = explode(",",$post);
			for($n=0;$n<sizeof($mk);$n++){
				$builder = $this->db->table('SPMDETB');
				$data = array(
					"MTGKEY"=>$mk[$n],
					"NILAI"=>"0",
					"NOJETRA"=>"23",
					"NOSPM"=>session()->nospm,
					"UNITKEY"=>session()->kdUnit
				);
				$builder->set($data);
				$builder->insert($data);
			}
			return;
		}
		public function potonganLSList(){
			$notIn1 = "A.MTGKEY not in (select MTGKEY from SPMDETR S where S.UNITKEY= '".session()->kdUnit."' and S.NOSPM= '".session()->nospm."' and S.NOJETRA= '23')";
			$notIn2 = "A.MTGKEY not in (select MTGKEY from SPMDETB S where S.UNITKEY= '".session()->kdUnit."' and S.NOSPM= '".session()->nospm."' and S.NOJETRA= '23')";
			$builder = $this->db->table('MATANGB A')->select('A.MTGKEY,A.KDPER,A.NMPER,A.TYPE')->where($notIn1)->where($notIn2)->where("left(A.KDPER,3) = '7.1' and A.TYPE='D'");
			$rs = $builder->get()->getResult();	
			return $rs;
		}
		public function updatePotongan($pot,$nilai){
			$update = array('NILAI'=>$nilai);
			$builder = $this->db->table('SPMDETB')->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nospm)->where('MTGKEY',$pot)->where('NOJETRA','23')->update($update);
			$builder = $this->db->table('SPMDETR')->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nospm)->where('MTGKEY',$pot)->where('NOJETRA','23')->update($update);
			return;
		}
		public function pajakLSList(){
			$notIn = "JP.PJKKEY not in (select PJKKEY from SPMPJK where UNITKEY= '".session()->kdUnit."' and NOSPM= '".session()->nospm."')";
			$builder = $this->db->table('JPAJAK JP')->select('JP.PJKKEY, JP.KDPAJAK, JP.NMPAJAK, JP.RUMUSPJK')->where($notIn);
			$rs = $builder->get()->getResult();	
			return $rs;
		}
		public function hapusPajakLS($pjk){
			$builder = $this->db->table('SPMPJK')->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nospm)->where('PJKKEY',$pjk)->delete();
			return;
		}
		public function tambahPajakLS($post){
			$mk = explode(",",$post);
			for($n=0;$n<sizeof($mk);$n++){
				$builder = $this->db->table('SPMPJK');
				$data = array(
					"PJKKEY"=>$mk[$n],
					"NILAI"=>"0",
					"KETERANGAN"=>"",
					"NOSPM"=>session()->nospm,
					"UNITKEY"=>session()->kdUnit
				);
				$builder->set($data);
				$builder->insert($data);
			}
			return;
		}
		public function listLsPajak(){
			$builder = $this->db->table('SPMPJK A')->orderBy('C.KDPAJAK');
			$builder->select('A.KETERANGAN,A.NILAI,A.NOSPM,A.PJKKEY,A.UNITKEY ,B.IDXKODE,B.IDXSKO,rtrim(B.IDXTTD) as IDXTTD,B.KDP3,');
			$builder->select('rtrim(B.KDSTATUS) as KDSTATUS,B.KEPERLUAN,B.KETOTOR,rtrim(B.KEYBEND) as KEYBEND, B.NOKONTRAK,B.NOREG,');
			$builder->select('B.PENOLAKAN,B.TGLSPM,B.TGLVALID ,C.KDPAJAK,C.NMPAJAK,C.RUMUSPJK');
			$builder->join('ANTARBYR B','A.NOSPM = B.NOSPM and A.UNITKEY=B.UNITKEY','LEFT OUTER');
			$builder->join('JPAJAK C','A.PJKKEY = C.PJKKEY','LEFT OUTER');
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOSPM',session()->nospm);
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function updatePajakLS($pjk,$nilai){
			$update = array('NILAI'=>$nilai);
			$builder = $this->db->table('SPMPJK')->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nospm)->where('PJKKEY',$pjk)->update($update);
			return;
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
				@tgl1='".session()->cur_thang."-01-01 00:00:00',
				@tgl2='".session()->cur_thang."-12-31 00:00:00',
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
				}else if(session()->jb == "Pajak"){
					$insert = array(
						"KEYBEND"=>session()->keybend,
						'NOBKPAJAK'=>$post['NOBUKTI'],
						'TGLBKUSKPD'=>$post['TGLBKUSKPD'],
						'URAIAN'=>$post['URAIAN'],
						'UNITKEY'=>session()->kdUnit,
						'NOBKUSKPD'=> $post['NOBKUSKPD']
					);
					$builder = $this->db->table('BKUPAJAK');
				}else if(session()->jb == "Panjar"){
					$insert = array(
						"KEYBEND"=>session()->keybend,
						'NOPANJAR'=>$post['NOBUKTI'],
						'TGLBKUSKPD'=>$post['TGLBKUSKPD'],
						'URAIAN'=>$post['URAIAN'],
						'UNITKEY'=>session()->kdUnit,
						'NOBKUSKPD'=> $post['NOBKUSKPD']
					);
					$builder = $this->db->table('BKUPANJAR');
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
				$builder->where('A.NOBPK',session()->nobpk);
				$rs = $builder->get()->getRow();
			}else{
				$rs = $builder->get()->getResult();
			}
			return $rs;
		}
		public function hapusTBP(){
			try{
				$builder = $this->db->table('BPK')->where('UNITKEY',session()->kdUnit)->where('NOBPK',session()->nobpk)->delete();
			} catch(\Exception $e){
				if($e->getMessage() != ''){
					session()->setFlashData("info", "Tidak dapat menghapus data. <i>".$e->getMessage()."</i>");
				}
			}
			return;
		}
		public function hapusRinciTBP(){
			$notIn = "SELECT MTGKEY FROM BPKDETRDANA WHERE UNITKEY = '".session()->kdUnit."' AND MTGKEY ='".session()->mtgkey."' AND KDKEGUNIT ='".session()->idSub."'
			AND NOBPK = '".session()->nobpk."' AND NOJETRA = '21'";
			try{
				$builder = $this->db->table('BPKDETR')->where('UNITKEY',session()->kdUnit)->where('MTGKEY',session()->mtgkey);
				$builder->where('KDKEGUNIT',session()->idSub)->where('NOBPK',session()->nobpk)->where('NOJETRA','21')->where("MTGKEY NOT IN (".$notIn.")")->delete();
				if($this->db->affectedRows() < 1){
					session()->setFlashData("info", "Tidak dapat menghapus data. <i>Hapus sumber dana!</i>");
				}else{
					session()->setFlashData("success", "Data telah dihapus.");
				}
			}catch(\Exception $e){
				if($e->getMessage() != ''){
					session()->setFlashData("info", "Tidak dapat menghapus data. <i>".$e->getMessage()."</i>");
				}
			}
		}
		public function hapusRinciTBPSD(){
			$builder = $this->db->table('Bpkdetrdana')->select('MTGKEY')->where('UNITKEY',session()->kdUnit)->where('MTGKEY'->session()->mtgkey);
			$builder->where('KDKEGUNIT',session()->idSub);
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
			$q = "SELECT * FROM BPK WHERE unitkey = '".session()->kdUnit."' AND NOBPK = '".session()->nobpk."'";
			$cek = $this->db->query($q)->getRow();

			$q = "SET NOCOUNT ON; EXEC WSP_VAL_DPARDANA 
			@unitkey='".session()->kdUnit."',
			@kdtahap='".session()->tahap."',
			@mtgkey='".session()->mtgkey."',
			@kdkegunit='".session()->idSub."',
			@kddana='".$post['KDDANA']."',
			@dok='BPK',@nomorx='".session()->nobpk."'";
			$rs = $this->db->query($q)->getRow();

			$sisaDPA = (int)$rs->SISA;

			if($cek->STBANK == "1"){
				$metode = "Bank";
				$ss = $this->db->query("SET NOCOUNT ON; exec WSP_VALIDATIONBPK_BANK @unitkey='".session()->kdUnit."',@keybend='".session()->keybend."'")->getRow();
			}else if($cek->STPANJAR == "1"){
				$ss = $this->db->query("SET NOCOUNT ON; exec WSP_VALIDATIONBPK_PANJAR @unitkey='".session()->kdUnit."',@keybend='".session()->keybend."',@kdkegunit='".session()->idSub."'")->getRow();
				$metode = "Panjar";
				$sisaDana = (int)$ss->sisa;
			}else if($cek->STTUNAI == "1"){
				$metode = "Tunai";
				$ss = $this->db->query("SET NOCOUNT ON; exec WSP_VALIDATIONBPK_BANK @unitkey='".session()->kdUnit."',@keybend='".session()->keybend."'")->getRow();;
			}

			if((int)$rs->SISA < (int)$post['NILAI'] || (int)$ss->sisa < (int)$post['NILAI']){
				session()->setFlashData("info", "<b>Data gagal disimpan..!</b> Pengajuan Rp.".number_format($post['NILAI'],2).". Sisa Pagu DPA <b>Rp.".number_format($sisaDPA,2)."</b>; Sisa ".$metode." <b>Rp.".number_format($sisaDana,2))."</b>";
			}else{
				$update = array("NILAI"=>$post['NILAI']);
				$builder = $this->db->table('Bpkdetrdana')->where("KDDANA",$post['KDDANA'])->where("NOBPK",session()->nobpk);
				$builder->where("UNITKEY",session()->kdUnit)->where("KDKEGUNIT",session()->idSub)->where("MTGKEY",session()->mtgkey);
				$builder->update($update);
				if($this->db->affectedRows() > 0){
					session()->setFlashData("info", "Data gagal disimpan");
				}else{
					session()->setFlashData("info", "Data berhasil disimpan");
				}

				$q = "Update BPKDETR SET NILAI=isnull((select sum(nilai) from Bpkdetrdana
				where UNITKEY= '".session()->kdUnit."' and NOBPK= '".session()->nobpk."' and MTGKEY= '".session()->mtgkey."' and KDKEGUNIT= '".session()->idSub."' ),0)
				where UNITKEY= '".session()->kdUnit."' and NOBPK= '".session()->nobpk."' and MTGKEY= '".session()->mtgkey."' and KDKEGUNIT= '".session()->idSub."'
				";
				$this->db->query($q);
			}					
			return;
		}
		public function rincianBKUBP(){
			//CARI UNITKEY DARI SP2D D
			$q = "
			SELECT UNITKEY,NOBUKU as NOBUKTI,'NOBUKU' as BUKTI,'BKUBANK' as TABEL FROM BKUBANK WHERE NOBUKU = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOBKPAJAK as NOBUKTI,'NOBKPAJAK' as BUKTI,'BKUPAJAK' as TABEL FROM BKUPAJAK WHERE NOBKPAJAK = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOBPK as NOBUKTI,'NOBPK' as BUKTI,'BPKDET' as TABEL FROM BKUBPK WHERE NOBPK = '".session()->nobukti."'
			UNION ALL
			SELECT UNITKEY,NOPANJAR as NOBUKTI,'NOPANJAR' as BUKTI,'PANJARDET' as TABEL FROM BKUPANJAR WHERE NOPANJAR = '".session()->nobukti."'
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
			if($bd->BUKTI == 'NOPANJAR'){
				$builder = $this->db->table('PANJARDET S')->select("NUKEG as KDPER,'' as KDKEGUNIT,NMKEGUNIT as NMPER,NILAI, 'Panjar' as JENIS, '2' as IDXKODE");
				$builder->join('MKEGIATAN M','S.KDKEGUNIT = M.KDKEGUNIT','LEFT OUTER');
				$builder->where('S.UNITKEY',$bd->UNITKEY)->where('NOPANJAR',session()->nobukti);
				$rs = $builder->get()->getResult();
				return $rs;
			}
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
			if($bd->BUKTI == 'NOBKPAJAK'){
				$builder = $this->db->table('BKPAJAKDET S')->select("KDPAJAK as KDPER,'' as KDKEGUNIT,NMPAJAK as NMPER,NILAI, 'Pajak' as JENIS, '0' as IDXKODE");
				$builder->join('JPAJAK M','S.PJKKEY = M.PJKKEY','LEFT OUTER');
				$builder->where('S.UNITKEY',$bd->UNITKEY)->where('NOBKPAJAK',session()->nobukti);
				$q = $builder->getCompiledSelect();
			}
//			echo nl2br($bd->BUKTI." ".$q);die();
      return $this->db->query($q)->getResult();
		}
		public function detilKegiatanGU(){
			$builder = $this->db->table('SPMDETR A')->orderBy('D.KDPER');
			$builder->select('A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPM,A.UNITKEY,A.KDKEGUNIT ,B.IDXKODE ,C.KDPERS,');
			$builder->select('D.TYPE ,rtrim(D.KDPER) as KDPER, rtrim(D.NMPER) as NMPER');
			$builder->join('ANTARBYR B','A.NOSPM = B.NOSPM and A.UNITKEY = B.UNITKEY','LEFT OUTER');
			$builder->join('JTRNLKAS C','A.NOJETRA = C.NOJETRA','LEFT OUTER');
			$builder->join('MATANGR D','A.MTGKEY = D.MTGKEY','LEFT OUTER');
			$builder->where('B.UNITKEY',session()->kdUnit)->where('B.NOSPM',session()->nospm)->where('A.NOJETRA','21')->where('A.KDKEGUNIT',session()->idSub);
			$rs = $builder->get()->getResult();
			return $rs;
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
		public function getSPJ(){
			$builder = $this->db->table('PSPJ')->select('NOSPJ,convert(char(10),TGLSPJ, 103) as TGLSPJ,convert(char(10),TGLBUKU, 103) as TGLBUKU,KETERANGAN');
			$builder->where("UNITKEY",session()->kdUnit)->where("NOSPJ",session()->noSPJ);
			$rs = $builder->get()->getRow();
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
		public function validasiSPJ($post){
			$builder = $this->db->table("PSPJ")->where('NOSPJ',session()->noSPJ)->update($post);
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
			
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function getPajak(){
			$builder = $this->db->table('BKPAJAK A')->select('A.*,B.NOBPK,convert(char(10), C.TGLBPK, 103) AS TGLBPK')->where('A.UNITKEY',session()->kdUnit)->where('A.NOBKPAJAK',session()->nobkpajak);
			$builder->join('BPKPAJAK B','A.NOBKPAJAK=B.NOBKPAJAK',"LEFT OUTER")->join('BPK C','B.NOBPK = C.NOBPK');
			$rs = $builder->get()->getRow();
			return $rs;
		}
		public function pajakTBPList($tgl){
			$builder = $this->db->table('BPK B')->join('BPKDETR D','B.UNITKEY=D.UNITKEY and B.NOBPK=D.NOBPK','LEFT OUTER');
			$builder->select('rtrim(B.NOBPK) AS NOBPK, convert(char(10), B.TGLBPK, 103) AS TGLBPK, rtrim(B.URAIBPK)AS URAIBPK, rtrim(B.NOBPK) AS PK_1');
			$builder->where('B.UNITKEY',session()->kdUnit)->where('B.KEYBEND',session()->keybend)->where('D.KDKEGUNIT',session()->idSub);
			$builder->where("B.NOBPK not in (select NOBPK from BPKPAJAK where UNITKEY = '".session()->kdUnit."')")->distinct();
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function simpanPajak($bkpajak,$bpkpajak){
			$this->db->table("BKPAJAK")->set($bkpajak)->insert($bkpajak);
			$this->db->table("BPKPAJAK")->set($bpkpajak)->insert($bpkpajak);
		}
		public function updatePajak($id,$update){
			$this->db->table("BKPAJAK")->where('NOBKPAJAK',$id)->update($update);
		}
		public function detilPajak(){
			$builder = $this->db->table('BKPAJAKDET A')->join('BKPAJAK B','A.NOBKPAJAK = B.NOBKPAJAK and A.UNITKEY = B.UNITKEY','LEFT OUTER');
			$builder->join('JPAJAK C','A.PJKKEY = C.PJKKEY','LEFT OUTER')->select('A.NILAI,A.NOBKPAJAK,A.PJKKEY,A.UNITKEY,B.TGLVALID');
			$builder->select("rtrim(B.KEYBEND) as KEYBEND ,C.KDPAJAK,C.NMPAJAK,C.RUMUSPJK,isnull(A.NTPN,'') AS NTPN,B.KDSTATUS");
			$builder->where('A.UNITKEY',session()->kdUnit)->where('A.NOBKPAJAK',session()->nobkpajak);
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function listRekPajak(){
			$builder = $this->db->table('JPAJAK JP')->select('JP.PJKKEY, JP.KDPAJAK, JP.NMPAJAK, JP.RUMUSPJK');
			$builder->where("JP.PJKKEY not in (select PJKKEY from BKPAJAKDET where UNITKEY= '".session()->kdUnit."' and NOBKPAJAK= '".session()->nobkpajak."')");
			$builder->orderBy('JP.KDPAJAK');
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function simpanDetilPajak($post){
			$this->db->table('BKPAJAKDET')->set($post)->insert($post);
			return;
		}
		public function hapusDetilPajak($no){
			$this->db->table('BKPAJAKDET')->where('UNITKEY',session()->kdUnit)->where('NOBKPAJAK',session()->nobkpajak)->where('PJKKEY',$no)->delete();
			return;
		}
		public function updateRinciPajak($no,$post){
			$this->db->table('BKPAJAKDET')->where('UNITKEY',session()->kdUnit)->where('NOBKPAJAK',session()->nobkpajak)->where('PJKKEY',$no)->update($post);
			return;
		}

		/* -------------------------------- PANJAR KEGIATAN ------------------ */
		public function listPanjar(){
			$builder = $this->db->table('PANJAR A')->where("A.UNITKEY",session()->kdUnit)->where("A.IDXKODE","2")->where("A.KEYBEND",session()->keybend);
			$builder->select("'0' as ALLOWSUPERUSER,A.IDXKODE,rtrim(A.KDSTATUS) as KDSTATUS,rtrim(A.KEYBEND) as KEYBEND,");
			$builder->select("A.NIP,A.NOPANJAR, A.REFF,A.TGLPANJAR,A.TGLVALID,A.UNITKEY,A.URAIAN,");
			$builder->select("A.STTUNAI, A.STBANK, B.JAB_BEND, B.JNS_BEND, B.KDBANK,B.NPWPBEND,");
			$builder->select("B.REKBEND, B.SALDOBEND, B.TGLSTOPBEND, C.KDUNIT, C.NMUNIT,C.TYPE,");
			$builder->select("D.JABATAN, D.KDGOL,D.NAMA,D.PDDK , E.LBLSTATUS,E.URAIAN as URAISTATUS , F.URAIAN as URAIKODE");
			$builder->join("BEND B","A.KEYBEND=B.KEYBEND","LEFT OUTER");
			$builder->join("DAFTUNIT C","A.UNITKEY=C.UNITKEY","LEFT OUTER");
			$builder->join("PEGAWAI D","A.NIP=D.NIP","LEFT OUTER");
			$builder->join("STATTRS E","A.KDSTATUS=E.KDSTATUS","LEFT OUTER");
			$builder->join("ZKODE F","A.IDXKODE=F.IDXKODE","LEFT OUTER")->orderBy("A.NOPANJAR");
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function simpanPanjar($post){
			$this->db->table('PANJAR')->set($post)->insert($post);
			return;
		}
		public function updatePanjar($nopanjar,$post){
			$this->db->table('PANJAR')->WHERE('NOPANJAR',$nopanjar)->where('UNITKEY',session()->kdUnit)->where('KEYBEND',session()->keybend)->update($post);
			return;
		}
		public function hapusPanjar($nopanjar){
			$builder = $this->db->table('PANJARDET')->where('UNITKEY',session()->kdUnit)->where('NOPANJAR',$nopanjar);
			$rs = $builder->select('COUNT(*) as JML')->get()->getRow();
			if($rs->JML){
				session()->setFlashData("info", "Panjar gagal dihapus karena masih ada ".$rs->JML." (".terbilang($rs->JML).") data dalam rincian panjar.");
				return;
			}else{
				$this->db->table('PANJAR')->WHERE('NOPANJAR',$nopanjar)->where('UNITKEY',session()->kdUnit)->where('KEYBEND',session()->keybend)->delete();
				return;
			}
		}
		public function rinciPanjar(){
			$builder = $this->db->table('PANJARDET A')->where("A.UNITKEY",session()->kdUnit)->where("A.NOPANJAR",session()->nopanjar);
			$builder->select("A.KDKEGUNIT,A.NILAI,A.NOJETRA,A.NOPANJAR,A.UNITKEY , rtrim(B.KEYBEND) as KEYBEND , ");
			$builder->select("C.KDPERS,C.NMJETRA , D.IDPRGRM,D.NUKEG,D.NMKEGUNIT ");
			$builder->join("PANJAR B","A.NOPANJAR = B.NOPANJAR and A.UNITKEY = B.UNITKEY","LEFT OUTER");
			$builder->join("JTRNLKAS C","A.NOJETRA = C.NOJETRA","LEFT OUTER");
			$builder->join("MKEGIATAN D","A.KDKEGUNIT = D.KDKEGUNIT","LEFT OUTER")->orderBy("D.NUKEG");
			//echo nl2br($builder->getCompiledSelect());die();
			$rs = $builder->get()->getResult();
			return $rs;
		}
		public function simpanRinciPanjar($kdkegunit){
			$k = explode(",",$kdkegunit);
			for($i=0;$i<sizeof($k);$i++){
				$post = array(
					'NILAI'=>'0','NOJETRA'=>'32','UNITKEY'=>session()->kdUnit,'NOPANJAR'=>session()->nopanjar,'KDKEGUNIT'=>$k[$i]
				);
				$this->db->table('PANJARDET')->set($post)->insert($post);
			}
			return;
		}
		public function listKegRinciPanjar(){
			$q = "
			select * from ( 
				select '1' AS LEVELKEG,P.UNITKEY,isnull(UR.UNITKEY,'')+'-H' as MTGKEY, 
				rtrim(isnull(UR.KDUNIT,(select rtrim(numdigit) from struunit where kdlevel='2'))) as NUKEG, 
				isnull(UR.NMUNIT,'NON URUSAN') as NMKEGUNIT,'H' as TYPE,'' AS KDKEGUNIT
				from PGRMUNIT 
				P left outer join MPGRM MP on P.IDPRGRM = MP.IDPRGRM 
				left outer join DAFTUNIT UR on MP.UNITKEY = UR.UNITKEY 
				left outer join DAFTUNIT UN on P.UNITKEY = UN.UNITKEY 
				inner join KEGUNIT K on P.UNITKEY=K.UNITKEY and P.IDPRGRM=K.IDPRGRM 
				where P.UNITKEY = '".session()->kdUnit."' and P.KDTAHAP= '".session()->tahap."' 
				union 
				select '2' AS LEVELKEG,P.UNITKEY,P.IDPRGRM+'-H' as MTGKEY, rtrim(isnull(UR.KDUNIT,(select rtrim(numdigit) 
				from struunit 
				where kdlevel='2')))+rtrim(MP.NUPRGRM) as NUKEG, MP.NMPRGRM as NMKEGUNIT,'H' as TYPE,'' AS KDKEGUNIT
				from PGRMUNIT P 
				left outer join MPGRM MP on P.IDPRGRM = MP.IDPRGRM 
				left outer join DAFTUNIT UR on MP.UNITKEY = UR.UNITKEY 
				left outer join DAFTUNIT UN on P.UNITKEY = UN.UNITKEY 
				inner join KEGUNIT K on P.UNITKEY=K.UNITKEY and P.IDPRGRM=K.IDPRGRM 
				where P.UNITKEY = '".session()->kdUnit."' and P.KDTAHAP= '".session()->tahap."' 
				union 
				select '3' AS LEVELKEG,K.UNITKEY,K.KDKEGUNIT+'-D' as MTGKEY, rtrim(isnull(UR.KDUNIT,(select rtrim(numdigit) 
				from struunit
				where kdlevel='2')))+rtrim(MP.NUPRGRM)+rtrim(MK.NUKEG) as NUKEG, MK.NMKEGUNIT as NMKEGUNIT,'D' as TYPE,K.KDKEGUNIT AS KDKEGUNIT
				from KEGUNIT K
				left outer join MKEGIATAN MK on MK.KDKEGUNIT=K.KDKEGUNIT 
				left outer join MPGRM MP on MK.IDPRGRM = MP.IDPRGRM 
				left outer join DAFTUNIT UR on MP.UNITKEY = UR.UNITKEY 
				left outer join DAFTUNIT UN on K.UNITKEY = UN.UNITKEY 
				where K.UNITKEY = '".session()->kdUnit."' and K.KDTAHAP= '".session()->tahap."') A 
				where UNITKEY =  '".session()->kdUnit."' and MTGKEY not in (
					select KDKEGUNIT+'-D' from PANJARDET S where S.UNITKEY=  '".session()->kdUnit."' and S.NOPANJAR=  '".session()->nopanjar."' 
				) order by NUKEG
			";
			$rs = $this->db->query($q)->getResult();
			return $rs;
		}
		public function updateRinciPanjar($kd,$post){
			$builder = $this->db->table('PANJARDET')->WHERE('NOPANJAR',session()->nopanjar)->where('UNITKEY',session()->kdUnit)->where('NOJETRA','32');
			$builder->where('KDKEGUNIT',$kd)->update($post);

			$this->db->query("exec WSP_VALIDATIONPANJARBANK_31 @unitkey='".session()->kdUnit."',@keybend='".session()->keybend."'");
			return;
		}
	
	}
?>