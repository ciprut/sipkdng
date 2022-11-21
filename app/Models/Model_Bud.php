<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Bud extends Model{
		public function __construct() {  
			$this->db = \Config\Database::connect();
    	$this->session = session();
			$this->utama = new \App\Models\Model_Utama;
		}

		/* ========================== PEMBUATAN SP2D ===================== */
		public function getSP2D(){
			$builder = $this->db->table('SP2D A')->where("A.UNITKEY",session()->kdUnit)->where('A.NOSP2D',session()->nosp2d);
			$builder->select('A.*,AB.KEYBEND,P.NAMA as BENDAHARA,B.NIP,T.NAMA as TTDNAMA,X.NIP as TTD,BB.KDBANK,BB.MTGKEY,BB.NOREKB');
			$builder->select('DB.NMBANK, NRC.NMPER,convert(char(10), A.TGLSP2D, 101) AS TANGGAL');
			$builder->join('ANTARBYR AB','A.NOSPM = AB.NOSPM', 'LEFT OUTER')->join('BEND B','AB.KEYBEND = B.KEYBEND','LEFT OUTER');
			$builder->join('PEGAWAI P','B.NIP = P.NIP', 'LEFT OUTER');
			$builder->join('JABTTD X','A.IDXTTD = X.IDXTTD', 'LEFT OUTER');
			$builder->join('PEGAWAI T','X.NIP = T.NIP','LEFT OUTER');
			$builder->join('BKBKAS BB','A.NOBBANTU = BB.NOBBANTU','LEFT OUTER');
			$builder->join('DAFTBANK DB','BB.KDBANK = DB.KDBANK','LEFT OUTER');
			$builder->join('MATANGNRC NRC','BB.MTGKEY = NRC.MTGKEY','LEFT OUTER');
			return $builder->get()->getRow();
		}
		public function listSP2D(){
			//$builder->select('NOSP2D,KETOTOR,KEPERLUAN,PENOLAKAN,convert(char(10), TGLVALID, 101) AS TGLVALID,convert(char(10), TGLSP2D, 101) AS TGLSP2D,TGLSPM,NOSPM,NOREG');
			if(session()->jns == 'up'){
				$builder = $this->db->table('SP2D')->where('UNITKEY',session()->kdUnit)->where('IDXKODE',session()->Idxkode);
			}else if(session()->jns == 'gu'){
				$builder = $this->db->table('SP2D A')->distinct()->orderBy('A.NOSP2D');
				$builder->select("'0' as ALLOWSUPERUSER,A.IDXKODE,A.IDXSKO,rtrim(A.IDXTTD) as IDXTTD,rtrim(A.KDSTATUS) as KDSTATUS,");
				$builder->select("isnull((A.KEPERLUAN),'')KEPERLUAN,isnull((A.NOKONTRAK),'')NOKONTRAK, A.KDP3, isnull((DP3.NMP3),'')NMP3, A.KETOTOR,");
				$builder->select('rtrim(A.KEYBEND) as KEYBEND,A.NOREG,A.NOSP2D, A.NOSPM,A.PENOLAKAN,A.TGLSP2D,A.TGLSPM,A.TGLVALID,A.UNITKEY,');
				$builder->select("SK.NOSKO,SK.TGLSKO, '0' as KDKEGUNIT, A.NOBBANTU,C.NMBKAS,K.TGLKON");
				$builder->join('SP2DDETR D','A.NOSP2D = D.NOSP2D and A.UNITKEY = D.UNITKEY','LEFT OUTER');
				$builder->join('SKO SK','A.IDXSKO = SK.IDXSKO and A.UNITKEY = SK.UNITKEY','LEFT OUTER');
				$builder->join('DAFTPHK3 DP3','A.KDP3 = DP3.KDP3','LEFT OUTER');
				$builder->join('BKBKAS C','A.NOBBANTU = C.NOBBANTU','LEFT OUTER');
				$builder->join('BEND B','A.KEYBEND=B.KEYBEND','LEFT OUTER');
				$builder->join('JBEND J','J.JNS_BEND=B.JNS_BEND','LEFT OUTER');
				$builder->join('KONTRAK K','A.NOKONTRAK = K.NOKON AND a.UNITKEY = k.UNITKEY','LEFT OUTER');
				$builder->where("A.UNITKEY",session()->kdUnit)->where('A.IDXKODE',session()->Idxkode);
				$builder->where("('".session()->Idxkode."' not in ('2') or ( '".session()->Idxkode."' ='2' and A.KDSTATUS in ('21','22','23')))");				
			}
			$rs = $builder->get()->getResult();
			return $rs;
		}
    public function rincianSP2D(){
      $builderD = $this->db->table('SP2DDETD A')->select('\'\' AS KDKEGUNIT,A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSP2D,A.UNITKEY,\'\' AS KDDANA');
      $builderD->select('rtrim(C.KDPER) as KDPER, rtrim(C.NMPER) as NMPER, C.TYPE')->join('MATANGB C','A.MTGKEY = C.MTGKEY','left outer');
      $builderD->where('A.UNITKEY',session()->kdUnit)->where('A.NOSP2D',session()->nosp2d);
      $query1 = $builderD->getCompiledSelect();

      $builderR = $this->db->table('SP2DDETR A')->select('A.KDKEGUNIT,A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSP2D,A.UNITKEY,A.KDDANA');
      $builderR->select('rtrim(C.KDPER) as KDPER, rtrim(C.NMPER) as NMPER, C.TYPE')->join('MATANGB C','A.MTGKEY = C.MTGKEY','left outer');
      $builderR->where('A.UNITKEY',session()->kdUnit)->where('A.NOSP2D',session()->nosp2d);
      $query2 = $builderR->getCompiledSelect();

      $builderB = $this->db->table('SP2DDETB A')->select('\'\' AS KDKEGUNIT,A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSP2D,A.UNITKEY,A.KDDANA');
      $builderB->select('rtrim(C.KDPER) as KDPER, rtrim(C.NMPER) as NMPER, C.TYPE')->join('MATANGB C','A.MTGKEY = C.MTGKEY','left outer');
      $builderB->where('A.UNITKEY',session()->kdUnit)->where('A.NOSP2D',session()->nosp2d);
      $query3 = $builderB->getCompiledSelect();

      return $this->db->query($query1.' UNION ALL '.$query2.' UNION ALL '.$query3)->getResult();
		}
		public function BaseQuerySp2d(){
			$builder = $this->db->table('ANTARBYR S');
			$builder->select('A.IDXKODE,A.IDXSKO,rtrim(A.IDXTTD) as IDXTTD,rtrim(A.KDSTATUS) as KDSTATUS,');
			$builder->select('isnull((A.KEPERLUAN),\'\') as KEPERLUAN,isnull((A.NOKONTRAK),\'\') as NOKONTRAK,');
			$builder->select('A.KDP3, isnull((DP3.NMP3),\'\')NMP3,');
			$builder->select('A.KETOTOR,rtrim(A.KEYBEND) as KEYBEND,A.NOREG,A.NOSP2D,');
			$builder->select('A.NOSPM,A.PENOLAKAN,A.TGLSP2D,A.TGLSPM,A.TGLVALID,A.UNITKEY,');
			$builder->select('SK.NOSKO,SK.TGLSKO,\'\' as KDKEGUNIT,');
			$builder->select('A.NOBBANTU,C.NMBKAS,K.TGLKON');

      $builder->join('SPPDETR D','A.NOSP2D = D.NOSP2D and A.UNITKEY = D.UNITKEY', 'LEFT OUTER');
			$builder->join('SKO SK','A.IDXSKO = SK.IDXSKO and A.UNITKEY = SK.UNITKEY', 'LEFT OUTER');
			$builder->join('BKBKAS C','A.NOBBANTU = C.NOBBANTU', 'LEFT OUTER');
			$builder->join('BEND B','S.KEYBEND=B.KEYBEND', 'LEFT OUTER');
			$builder->join('JBEND J','B.JNS_BEND = J.JNS_BEND', 'LEFT OUTER');
			$builder->join('KONTRAK K','S.NOKONTRAK = K.NOKON', 'LEFT OUTER');
			
			$builder->join('(SELECT X.NOSPM,SUM(X.NILAI) AS NILAI FROM (
			SELECT UNITKEY, NOSPM, SUM(NILAI) as NILAI FROM SPMDETB WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPM, SUM(NILAI) as NILAI FROM SPMDETD WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPM, SUM(NILAI) as NILAI FROM SPMDETR WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPM, SUM(NILAI) as NILAI FROM SPMDETRTL WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPM
			) as X GROUP BY X.NOSPM) AS RR', 'RR.NOSPM = S.NOSPM','LEFT');
			
			$builder->orderBy('S.NOSPM');
			return $builder;
		}
		public function BaseQuerySpm(){
			$builder = $this->db->table('SPMDETB A');
			$builder->select('A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPM,A.UNITKEY,');
			$builder->select('rtrim(D.KDPER) as KDPER, rtrim(D.NMPER) as NMPER');

      $builder->join('MATANGB D','A.MTGKEY = D.MTGKEY', 'LEFT OUTER');
			$builder->join('SKO SK','A.IDXSKO = SK.IDXSKO and A.UNITKEY = SK.UNITKEY', 'LEFT OUTER');
			$builder->join('BKBKAS C','A.NOBBANTU = C.NOBBANTU', 'LEFT OUTER');
			$builder->join('BEND B','S.KEYBEND=B.KEYBEND', 'LEFT OUTER');
			$builder->join('JBEND J','B.JNS_BEND = J.JNS_BEND', 'LEFT OUTER');
			$builder->join('KONTRAK K','S.NOKONTRAK = K.NOKON', 'LEFT OUTER');
			
			$builder->join('(SELECT X.NOSPM,SUM(X.NILAI) AS NILAI FROM (
			SELECT UNITKEY, NOSPM, SUM(NILAI) as NILAI FROM SPMDETB WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPM, SUM(NILAI) as NILAI FROM SPMDETD WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPM, SUM(NILAI) as NILAI FROM SPMDETR WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPP UNION ALL 
			SELECT UNITKEY, NOSPM, SUM(NILAI) as NILAI FROM SPMDETRTL WHERE UNITKEY = \''.session()->kdUnit.'\' GROUP BY UNITKEY, NOSPM
			) as X GROUP BY X.NOSPM) AS RR', 'RR.NOSPM = S.NOSPM','LEFT');
			
			$builder->orderBy('S.NOSPM');
			return $builder;
		}
		public function spmList____________($tgl= null){
			if(session()->jnsSp2d == "up"){
				$builder = $this->db->table('SPMDETB A'); //21 - 6
				$builder->select('A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPM,A.UNITKEY,B.TGLVALID,B.KETOTOR,B.TGLSPM,B.KEYBEND,');
				$builder->select('rtrim(D.KDPER) as KDPER, rtrim(D.NMPER) as NMPER,C.NIP,E.NAMA');
	
				$builder->join('ANTARBYR B','A.NOSPM = B.NOSPM', 'LEFT OUTER');
				$builder->join('BEND C','B.KEYBEND = C.KEYBEND', 'LEFT OUTER');
				$builder->join('PEGAWAI E','C.NIP = E.NIP', 'LEFT OUTER');
				$builder->join('MATANGB D','A.MTGKEY = D.MTGKEY', 'LEFT OUTER')->orderBy('D.KDPER');
			}
			if(session()->jnsSp2d == "gu"){ // 22 - 2
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23]);
			}
			if($tgl != NULL){
				$whereDate = 'Convert(char(10), B.TGLVALID, 101) <= Convert(datetime, \''.$tgl.'\')';
				$builder->where($whereDate)->where('A.UNITKEY',session()->kdUnit)->where('B.TGLSPM !=',NULL);
			}
			//echo nl2br($builder->getCompiledSelect());die();
			return $builder->get()->getResult();
		}
		public function spmList($tgl= null){
			if(session()->jnsSp2d == "up"){
				$builder = $this->db->table('ANTARBYR A'); //21 - 6
				$builder->select('rtrim(A.NOSPM) as NOSPM ,convert(char(10), A.TGLSPM, 103) as TGLSPM ,rtrim(A.KEPERLUAN) as URAIAN,convert(char(10), A.TGLVALID, 103) as TGLVALID');
	
				$builder->like('A.NOSPM','')->like("isnull(A.KEPERLUAN,'')","")->where('A.UNITKEY',session()->kdUnit);
				$builder->like('convert(char(10), A.TGLSPM, 103)','')->where("isnull(A.PENOLAKAN,1)","1");
				$builder->where('A.IDXKODE',session()->Idxkode)->where('A.KDSTATUS','21');
				$builder->where("A.NOSPM NOT IN (select NOSPM from SP2D WHERE UNITKEY = '".session()->kdUnit."')");
				$builder->where('TGLVALID !=',null)->orderBy('rtrim(A.NOSPM)');
			}
			if(session()->jnsSp2d == "gu"){ // 22 - 2
				$builder = $this->db->table('ANTARBYR A'); //21 - 6
				$builder->select('rtrim(A.NOSPM) as NOSPM ,convert(char(10), A.TGLSPM, 103) as TGLSPM ,rtrim(A.KEPERLUAN) as URAIAN,');
				$builder->select("convert(char(10), A.TGLVALID, 103) as TGLVALID,A.KETOTOR,(rtrim(B.NIP)+' - '+ rtrim(P.NAMA)) as NIPNAMA");
				$builder->join('BEND B','A.KEYBEND = B.KEYBEND', 'LEFT OUTER');
				$builder->join('PEGAWAI P','B.NIP = P.NIP', 'LEFT OUTER');

				$builder->where('A.UNITKEY',session()->kdUnit)->where('isnull(A.PENOLAKAN,1)','1')->where('A.IDXKODE',session()->Idxkode);
				$builder->where('A.KDSTATUS','22');
				$builder->where("A.NOSPM NOT IN (select NOSPM from SP2D WHERE UNITKEY = '".session()->kdUnit."')");
				$builder->where('TGLVALID !=',null)->orderBy('rtrim(A.NOSPM)');
			}
			if($tgl != NULL){
				$whereDate = 'Convert(char(10), TGLVALID, 101) <= Convert(datetime, \''.$tgl.'\')';
				$builder->where($whereDate);
			}
			//echo nl2br($builder->getCompiledSelect());die();
			return $builder->get()->getResult();
		}
		public function simpanSP2D($post){
			//cari data2 SPM
			$spm = $this->db->table('ANTARBYR')->where('NOSPM',$post['NOSPM'])->where('UNITKEY',session()->kdUnit)->select('*')->get()->getRow();

			$this->db->table('SP2D')->where('NOSP2D',$post['NOSP2D'])->where('UNITKEY',session()->kdUnit)->delete();
			if(session()->nosp2d == ""){
				$insert = array(
					'UNITKEY'=>session()->kdUnit,
					'NOSP2D'=>$post['NOSP2D'],
					'KDSTATUS'=>trim($spm->KDSTATUS),
					'NOSPM'=>$spm->NOSPM,
					'KEYBEND'=>$spm->KEYBEND,
					'IDXSKO'=>$spm->IDXSKO,
					'IDXTTD'=>$post['IDXTTD'],
					'IDXKODE'=>$spm->IDXKODE,
					'NOREG'=>$post['NOREG'],
					'KETOTOR'=>$spm->KETOTOR,
					'NOKONTRAK'=>$spm->NOKONTRAK,
					'KEPERLUAN'=>$spm->KEPERLUAN,
					'TGLSP2D'=>$post['TGLSP2D'],
					'TGLSPM'=>$spm->TGLSPM,
					'NOBBANTU'=>trim($post['NOBBANTU'])
				);
				$builder = $this->db->table('SP2D');
				$builder->set($insert);
				$builder->insert($insert);
				$this->db->query("EXEC WSP_TRANSFER_SPMSP2D @nospm = '".$spm->NOSPM."',@nosp2d = '".$post['NOSP2D']."', @unitkey = '".session()->kdUnit."'");
				$this->utama->setFlashData('Gagal Menyimpan Data SP2D!','SP2D Berhasil Disimpan');
			}else{
				$update = array(
					'NOSPM'=>$spm->NOSPM,
					'KEYBEND'=>$spm->KEYBEND,
					'IDXSKO'=>$spm->IDXSKO,
					'IDXTTD'=>$post['IDXTTD'],
					'IDXKODE'=>$spm->IDXKODE,
					'NOREG'=>$post['NOREG'],
					'KETOTOR'=>$spm->KETOTOR,
					'NOKONTRAK'=>$spm->NOKONTRAK,
					'KEPERLUAN'=>$spm->KEPERLUAN,
					'TGLSP2D'=>$post['TGLSP2D'],
					'TGLSPM'=>$spm->TGLSPM,
					'NOBBANTU'=>trim($post['NOBBANTU'])
				);
				$builder = $this->db->table('SP2D');
				$builder->where('UNITKEY',session()->kdUnit)->where('NOSP2D',session()->nosp2d)->update($update);

				$this->db->query("EXEC WSP_TRANSFER_SPMSP2D @nospm = '".$spm->NOSPM."',@nosp2d = '".session()->nosp2d."', @unitkey = '".session()->kdUnit."'");
				$this->utama->setFlashData('Gagal Mengubah Data SP2D!','SP2D Berhasil Diubah');
			}
			return;
		}
		public function setujuSP2D($post){
			if($post['PENOLAKAN'] == "0"){
				$notIn = "NOSP2D NOT IN (SELECT NOSP2D FROM BKUK WHERE UNITKEY = '".session()->kdUnit."')";
				$builder = $this->db->table('SP2D')->where($notIn);
				$update = array("PENOLAKAN"=>"0","TGLVALID"=>NULL);
				$builder->where('UNITKEY',session()->kdUnit)->where('NOSPM',session()->nosp2d)->update($update);
				$this->utama->setFlashData('SP2D tidak dapat dibatalkan. Data SP2D sudah masuk daftar penguji!',"Validasi SP2D telah dibatalkan","danger");
			}else{
				$builder = $this->db->table('SP2D');
				$builder->where('UNITKEY',session()->kdUnit)->where('NOSP2D',session()->nosp2d)->update($post);
				$this->utama->setFlashData('Gagal validasi SP2D!','SP2D telah divalidasi tanggal '.$post['TGLVALID']);
			}
			return;
		}

		/* ======================= VALIDASI BUD ======================= */
		public function listValidasi($post){
			if(session()->jns == 'bkuk'){
				$sp = "SET NOCOUNT ON; EXEC WSPI_BKUK 
				@allowsuperuser='0',
				@nobbantu='".trim($post['NOBBANTU'])."',
				@TGL1='".$post['TGL1']." 00:00:00',
				@TGL2='".$post['TGL2']." 00:00:00',
				@field='1',
				@value='',
				@hal=1,
				@flgtgl=0,
				@jur=0
				";
				$rs = $this->db->query($sp)->getResult();
			}
			return $rs;
		}
		public function sp2dList($tgl=null){
			$builder = $this->db->table('SP2D A');
			$builder->select('rtrim(A.NOSP2D) as NOSP2D,convert(char(10), A.TGLSP2D, 101) as TGLSP2D,convert(char(10), A.TGLVALID, 103) as TGLVALID,rtrim(A.KEPERLUAN) as KEPERLUAN');
			$builder->select('A.IDXTTD,B.NIP,C.NAMA');
			$builder->join('JABTTD B','A.IDXTTD = B.IDXTTD','LEFT OUTER');
			$builder->join('PEGAWAI C','B.NIP = C.NIP');
			$builder->where('A.NOBBANTU',session()->nobbantu)->where('A.TGLVALID is not',null)->where('A.NOSP2D not in (select NOSP2D from BKUK)');
			if($tgl != NULL){
				$whereDate = 'Convert(char(10), A.TGLVALID, 101) <= Convert(datetime, \''.$tgl.'\')';
				$builder->where($whereDate);
			}
			//echo $builder->getCompiledSelect();die();
			return $builder->get()->getResult();
		}
		public function simpanValidasi($post){
			//cari data2 SP2D
			$notIn = "A.NOSP2D NOT IN (SELECT NOSP2D FROM BKUK UNION ALL SELECT NOSP2D FROM BKUD)";
			$builder = $this->db->table('SP2D A')->where('A.NOSP2D',$post['NOSP2D'])->select('A.*,B.JAB_BEND');
			$builder->join('BEND B','A.KEYBEND = B.KEYBEND', 'LEFT OUTER');
			$sp2d = $builder->get()->getRow();

			$this->db->table('BKUK')->where('NOSP2D',$post['NOSP2D'])->delete();
			if(session()->nobukas == ""){
				$insert = array(
					'IDXTTD'=>$post['IDXTTD'],
					'KDBUKTI'=>$post['KDBUKTI'],
					'NOBBANTU'=>session()->nobbantu,
					'NOBUKTIKAS'=>$post['NOBUKTIKAS'],
					'NOSP2D'=>$sp2d->NOSP2D,
					'TGLKAS'=>$post['TGLKAS'],
					'UNITKEY'=>$sp2d->UNITKEY,
					'URAIAN'=>$sp2d->KEPERLUAN,
					'NOBUKAS'=>trim($post['NOBUKAS']."-B01")
				);
				$builder = $this->db->table('BKUK');
				$builder->set($insert);
				$builder->insert($insert);
				$this->utama->setFlashData('Gagal Menyimpan Data Validasi!','Validasi BUD Berhasil Disimpan');
			}else{/*
				$update = array(
					'NOSPM'=>$spm->NOSPM,
					'KEYBEND'=>$spm->KEYBEND,
					'IDXSKO'=>$spm->IDXSKO,
					'IDXTTD'=>$post['IDXTTD'],
					'IDXKODE'=>$spm->IDXKODE,
					'NOREG'=>$post['NOREG'],
					'KETOTOR'=>$spm->KETOTOR,
					'NOKONTRAK'=>$spm->NOKONTRAK,
					'KEPERLUAN'=>$spm->KEPERLUAN,
					'TGLSP2D'=>$post['TGLSP2D'],
					'TGLSPM'=>$spm->TGLSPM,
					'NOBBANTU'=>trim($post['NOBBANTU'])
				);
				$builder = $this->db->table('SP2D');
				$builder->where('UNITKEY',session()->kdUnit)->where('NOSP2D',session()->nosp2d)->update($update);

				$this->db->query("EXEC WSP_TRANSFER_SPMSP2D @nospm = '".$spm->NOSPM."',@nosp2d = '".session()->nosp2d."', @unitkey = '".session()->kdUnit."'");
				$this->utama->setFlashData('Gagal Mengubah Data SP2D!','SP2D Berhasil Diubah');*/
				echo "NOT THIS SHIT!";die();
			}
			return;
		}
		public function rincianValSP2D(){
			//CARI UNITKEY DARI SP2D D
			$bd = $this->db->table('SP2D')->select("*")->where('NOSP2D',session()->nosp2d)->where('TGLVALID !=',null)->get()->getRow();

      $builderD = $this->db->table('SP2DDETD S')->select('KDPER,\'\' as KDKEGUNIT,NMPER,NILAI, \'SP2D\' as JENIS, \'6\' as IDXKODE');
      $builderD->join('MATANGD M','S.MTGKEY=M.MTGKEY','left outer');
      $builderD->where('S.UNITKEY',$bd->UNITKEY)->where('S.NOSP2D',session()->nosp2d)->where('S.NOJETRA','21');
      $query1 = $builderD->getCompiledSelect();

      $builderR = $this->db->table('SP2DDETR S')->select('KDPER,KDKEGUNIT,NMPER,NILAI, \'SP2D\' as JENIS, \'6\'  as IDXKODE');
      $builderR->join('MATANGR M','S.MTGKEY = M.MTGKEY','left outer');
      $builderR->where('S.UNITKEY',$bd->UNITKEY)->where('S.NOSP2D',session()->nosp2d)->where('S.NOJETRA','21');
      $query2 = $builderR->getCompiledSelect();

      $builderB = $this->db->table('SP2DDETB S')->select('KDPER,\'\' as KDKEGUNIT,NMPER,NILAI, \'SP2D\' as JENIS, \'6\' as IDXKODE');
      $builderB->join('MATANGB M','S.MTGKEY = M.MTGKEY','left outer');
      $builderB->where('S.UNITKEY',$bd->UNITKEY)->where('S.NOSP2D',session()->nosp2d)->where('S.NOJETRA','21');
      $query3 = $builderB->getCompiledSelect();

			$builderL = $this->db->table('SP2DDETRTL S')->select('KDPER,\'\' as KDKEGUNIT,NMPER,NILAI, \'SP2D\' as JENIS, \'6\' as IDXKODE');
      $builderL->join('MATANGR M','S.MTGKEY = M.MTGKEY','left outer');
      $builderL->where('S.UNITKEY',$bd->UNITKEY)->where('S.NOSP2D',session()->nosp2d)->where('S.NOJETRA','21');
      $query4 = $builderL->getCompiledSelect();

			$q = $query1.' UNION ALL '.$query2.' UNION ALL '.$query3.' UNION ALL '.$query4;
			//echo nl2br($q);
      return $this->db->query($q)->getResult();
		}

	}
?>