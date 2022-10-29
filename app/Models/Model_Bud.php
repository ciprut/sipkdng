<?
	namespace App\Models;
	use CodeIgniter\Model;

	class Model_Bud extends Model{
		public function __construct() {          
			$this->db = \Config\Database::connect();
    	$this->session = session();
			$this->utama = new \App\Models\Model_Utama;
		}

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
			$builder = $this->db->table('SP2D')->where('UNITKEY',session()->kdUnit);
			$builder->select('NOSP2D,KETOTOR,KEPERLUAN,PENOLAKAN,convert(char(10), TGLVALID, 101) AS TGLVALID,convert(char(10), TGLSP2D, 101) AS TGLSP2D,TGLSPM,NOSPM,NOREG');
			return $builder->get()->getResult();
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
		public function spmList($tgl= null){
			if(session()->jnsSp2d == "up"){
				$builder = $this->db->table('SPMDETB A');
				$builder->select('A.MTGKEY,A.NILAI,A.NOJETRA,A.NOSPM,A.UNITKEY,B.TGLVALID,B.KETOTOR,B.TGLSPM,B.KEYBEND,');
				$builder->select('rtrim(D.KDPER) as KDPER, rtrim(D.NMPER) as NMPER,C.NIP,E.NAMA');
	
				$builder->join('ANTARBYR B','A.NOSPM = B.NOSPM', 'LEFT OUTER');
				$builder->join('BEND C','B.KEYBEND = C.KEYBEND', 'LEFT OUTER');
				$builder->join('PEGAWAI E','C.NIP = E.NIP', 'LEFT OUTER');
				$builder->join('MATANGB D','A.MTGKEY = D.MTGKEY', 'LEFT OUTER')->orderBy('D.KDPER');
			}
			if(session()->jnsSpm == "gu"){
				$builder->where('S.UNITKEY',session()->kdUnit)->where('S.IDXKODE',session()->Idxkode)->where('RIGHT(J.JNS_BEND,1)','2');
				$builder->where('(isnull(D.KDKEGUNIT,\'\')=isnull(\'\',\'\') or isnull(\'\',\'\')=\'\' or D.KDKEGUNIT is null)');
				$builder->where('S.KEYBEND',session()->keybend);
				$builder->whereIn('S.KDSTATUS',[22,23]);
			}
			if($tgl != NULL){
				$whereDate = 'Convert(char(10), B.TGLVALID, 101) <= Convert(datetime, \''.$tgl.'\')';
				$builder->where($whereDate)->where('A.UNITKEY',session()->kdUnit)->where('B.TGLSPM !=',NULL);
			}
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

		public function listValidasi($post){
			if(session()->jns == 'bkuk'){
				$q = "
				@allowsuperuser=0,
				@nobbantu='".$post['NOBBANTU']."',
				@tgl1='".$post['NOBBANTU']." 00:00:00',
				@tgl2='".$post['NOBBANTU']." 00:00:00',
				@field=N'1',@value='',
				@hal=1,
				@flgtgl=0,
				@jur=0
				";
				$this->db->query("EXEC WSPI_BKUK ".$q);
			}
			return;
		}

	}
?>