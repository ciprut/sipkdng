<?php
	
	class array_object{
		function arrayKeObject($array){
			$object = new stdClass();
			if (is_array($array)){
				foreach ($array as $kolom=>$isi){
					$kolom = strtolower(trim($kolom));
					$object->$kolom = $isi;
				}
			}
			return $object;
		}

		function objectKeArray($object){
			$array = array();
			if (is_object($object)) {
				$array = get_object_vars($object);
			}
			return $array;
		}
	}

  function getLink($html){
	  $linkArray = array();
	  if(preg_match_all('/<a\s+.*?href=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)<\/a>/i', $html, $matches, PREG_SET_ORDER)){
	    foreach ($matches as $match) {
	    	array_push($linkArray, array($match[1], $match[2]));
	    }
	  }
	  return $linkArray;
  }

	error_reporting(E_ALL ^ E_NOTICE);

	$vbln = array("-","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$vcolors = array(
	"#f44336","#9c27b0","#e91e63","#673ab7","#3f51b5","#2196f3","#f06292","#90a4ae","#FFD54F","#ff7043","#9e9e9e",
	"#FFC107","#009688","#FF9800","#4CAF50","#304ffe","#6200ea","#c51162","#2E7D32","#d50000","#e040fb","#ce93d8",
	"#f44336","#9c27b0","#e91e63","#673ab7","#3f51b5","#2196f3","#8BC34A","#03a9f4","#CDDC39","#00bcd4","#FFEB3B",
	"#f44336","#9c27b0","#e91e63","#673ab7","#3f51b5","#2196f3","#8BC34A","#03a9f4","#CDDC39","#00bcd4","#FFEB3B");
	date_default_timezone_set('Asia/Jakarta');
	
	function cekLine($ln){
		echo "(".$ln.") This line OK";
		exit();
	}

	function myTrim($text,$max=10){
		$pjg = strlen(trim($text));
		if($pjg > $max){
			$result = substr($text, 0,$max)."...";
		}else{
			$result = $text;
		}
		return $result;
	}

	function titleCase($txt){
		$ret = strtolower($txt);
		return ucwords($ret);
	}

	function toArray($data){
		$dat = explode("&",$data);
		$n = array();
		for ($i=0; $i < sizeof($dat); $i++) { 
			$res = explode("=",$dat[$i]);
			$n[$res[0]] = $res[1];
		}
		return $n;
	}
	function jsAlert($txt){
		$ket = "<script>";
		$ket .= "alert('".$txt."');";
		$ket .= "</script>";
		echo $ket;
	}

	function makeSession($sessName,$sessRes){
		$CI =& get_instance();
		if(!is_null($CI->request->getPost($sessRes))){
			session()->set($sessName,$CI->request->getPost($sessRes));
		}
	}
	function clean($txt){
		$ket = preg_replace("/\s+/", "",$txt);
		$ket = str_replace('\t','',$txt);
		$ket = str_replace("\/","/",$ket);

		$ket = str_replace('\r',"",$ket);
		$ket = str_replace('\n',"",$ket);
		return $ket;
	}

	function clean_code($string){
		$clean_code = preg_replace('/[^a-zA-Z0-9]/', '', $string);
		return $clean_code;
	}

	function timeAgo($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	function angka($x){
		$hasil = is_infinite($x);

		if(is_nan($hasil)){
			$hasil = 0;
		}
		return $hasil;
	}

	function pretty_print($json_data){
		//Initialize variable for adding space
		$space = 0;
		$flag = false;

		//Using <pre> tag to format alignment and font
		echo "<pre>";

		//loop for iterating the full json data
		$ket = preg_replace("/\s+/", "",$json_data);
		$ket = str_replace('\t','',$json_data);
		$ket = str_replace("\/","/",$ket);
		$ket = str_replace('\r',"",$ket);
		$ket = str_replace('\n',"",$ket);
		$json_data = $ket;
		for($counter=0; $counter<strlen($json_data); $counter++){
			//Checking ending second and third brackets
			if ( $json_data[$counter] == '}' || $json_data[$counter] == ']' ){
				$space--;
				echo "\n";
				echo str_repeat(' ', ($space*2));
			}
 
			//Checking for double quote(“) and comma (,)
			if ( $json_data[$counter] == '"' && ($json_data[$counter-1] == ',' || $json_data[$counter-2] == ',') ){
				echo "\n";
				echo str_repeat(' ', ($space*2));
			}
			if ( $json_data[$counter] == '"' && !$flag ){
				if ( $json_data[$counter-1] == ':' || $json_data[$counter-2] == ':' )
					echo '<span style="color:blue;font-weight:bold">';
				else
					echo '<span style="color:red;">';
			}
			echo $json_data[$counter];
			//Checking conditions for adding closing span tag
			if ( $json_data[$counter] == '"' && $flag )
				echo '</span>';
			if ( $json_data[$counter] == '"' )
				$flag = !$flag;
				//Checking starting second and third brackets
			if ( $json_data[$counter] == '{' || $json_data[$counter] == '[' ){
				$space++;
				echo "\n";
				echo str_repeat(' ', ($space*2));
			}
		}
		echo "</pre>";
	}
	
	function UploadImage($lokasi,$nama_field,$nama_file,$ukuran = 110){
	  //direktori gambar

	  //Simpan gambar dalam ukuran sebenarnya
	  $vfile_upload = $lokasi.$nama_file.".jpg";
		if(is_file($vfile_upload)){
			//unlink($vfile_upload);
			//return;
		}
	  move_uploaded_file($_FILES[$nama_field]["tmp_name"], $vfile_upload);
		//unlink($_FILES["file"]["tmp_name"]);
		$hasil = "";
		
	  //identitas file asli
	  if($im_src = imagecreatefromjpeg($vfile_upload)){
			$hasil .= "Copy temp file(imagecreatefromjpeg) OK..<br>";
		}else{
			$hasil .= "Copy File gagal"."..<br>";
		}
		
	  $src_width = imageSX($im_src);
	  $src_height = imageSY($im_src);
		$l = $src_width;
		$t = $src_height;

		//jika gambarnya lebar
		if($l > $t){
			$p = ($ukuran/$l); //20/100=0.5
			$dst_width = $ukuran;
			$dst_height = ($t *$p);
		}
		//jika gambarnya tinggi
		if($t > $l){
			$p = ($ukuran/$t);
			$dst_height = $ukuran;
			$dst_width = ($l *$p);
		}
		//jika gambarnya tinggi
		if($l == $t){
			$p = ($ukuran/$t);
			$dst_height = $ukuran;
			$dst_width = $ukuran;
		}

	  //proses perubahan ukuran
	  $im = imagecreatetruecolor($dst_width,$dst_height);
	  if(imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height)){
			$hasil .= "Proses Resize OK..<br>";
		}else{
			$hasil .= "Proses Resize Gagal ke ".$dst_width." - ".$dst_height."..<br>";
		}

	  //Simpan gambar
		unlink($vfile_upload);
		$nf = $lokasi.$nama_file.".jpg";
	  if(imagejpeg($im,$nf)){
			$hasil .= "Proses Create New File OK.. <br>";
			echo $hasil;
			return;
		}else{
			$hasil .= "Proses Create New File mengupload";
			echo $hasil;
			return;
		}
  	
	  //Hapus gambar di memori komputer
	  imagedestroy($im_src);
	  imagedestroy($im);
	}	

	function numberColor($n,$digit){
		$t = number_format($n,$digit);
		$tt = explode(".",$t);
		$tota = number_format($n).".<b style='color:#d50000;font-weight:normal'>".$tt[1]."</b>";
		return $tota;
	}
	
	function getKdSKPD($num){
		$ret = substr($num,0,(strlen($num)-1));
		return $ret;
	}
	
	function load_to_content($id,$url){
		echo '<script>
			load_to_content("'.$id.'","'.$url.'");
		</script>';
	}
	
	function add_array($arr,$key,$value = 0){
		if(!isset($arr[$key])){
			$arr[$key] = 0;
		}
		if($value > 0){
			$arr[$key] += $value;			
		}
	}
	
	function escape($str){
		$r = htmlspecialchars($str);
		$r = quotemeta($r);
		return $r;
	}

	function getFlashData(){
		if(session()->getFlashData("info")){
			flashData("info");
		}	
		if(session()->getFlashData("success")){
			flashData("success");
		}	
		if(session()->getFlashData("danger")){
			flashData("danger");
		}	
	}
	function getUnitkey(){
		if($this->request->getPost('unitkey') != ''){
			session()->set('kdUnit',$this->request->getPost('unitkey'));
		}
	}
	function show_error($q = ""){
		if($q != ""){
			echo "<b>".$q."</b><br>".mysql_error()."<br>";
		}else{
			echo "<br>".mysql_error()."<br>";
		}
	}
	function separator(){
		echo "<div class='separator'></div>";
	}
	function cls(){
		echo "<div class='clear'></div>";
	}
	function flashData($type){
		echo '
		<div class="clear" style="height:30px"></div>
		<div class="alert alert-'.$type.' alert-dismissible show" role="alert">'.session()->getFlashData($type).'
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:10px">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>';
	}
	
	function arr2q($n){
		$r = str_replace("(","('",$n);
		$r = str_replace(")","')",$r);
		$r = str_replace(".","','",$r);
		return $r;
	}
	
	function kd_skpd($n){
		//1.01-2.19-0.00-01.0000
		$x = explode(".",$n);
		return $x[0].".".pjg($x[1],2)."-".$x[2].".".pjg($x[3],2)."-".$x[4].".".pjg($x[5],2)."-".pjg($x[6],2).".".pjg($x[7],4);
	}
	function kdSatker($n){
		//1.01-2.19-0.00-01.0000
		$x = explode(".",$n);
		return $x[0].".".pjg($x[1],2)."-".$x[2].".".pjg($x[3],2)."-".$x[4].".".pjg($x[5],2)."-".pjg($x[6],2).".".pjg($x[7],4);
	}

	function kdKeg($n){
		$x = explode(".",$n);
		return $x[0].".".pjg($x[1],2).".".pjg($x[2],2).".".$x[3].".".pjg($x[4],2);
	}
	
	function kdRek($n){
		//5.1.1.01.01.0001
		$x = explode(".",$n);
		return $x[0].".".$x[1].".".$x[2].".".pjg($x[3],2).".".pjg($x[4],2).".".pjg($x[5],4);
	}
	function kdProg($n){
		$x = explode(".",$n);
		return $x[0].".".pjg($x[1],2).".".pjg($x[2],2);
	}
	function kdSubKeg($n){
		$x = explode(".",$n);
		return $x[0].".".pjg($x[1],2).".".pjg($x[2],2).".".$x[3].".".pjg($x[4],2).".".pjg($x[5],2);
	}
	function kdAkunSSH($n){
		//1.01-2.19-0.00-01.0000
		$x = explode(".",$n);
		return $x[0].".".pjg($x[1],2).".".pjg($x[2],2).".".pjg($x[3],2).".".pjg($x[4],2).".".pjg($x[5],2).".".pjg($x[6],3);
	}
	function kdSSH($n){
		//1.01-2.19-0.00-01.0000
		$x = explode(".",$n);
		return $x[0].".".pjg($x[1],2).".".pjg($x[2],2).".".pjg($x[3],2).".".pjg($x[4],2).".".pjg($x[5],2).".".pjg($x[6],3).".".pjg($x[7],4);
	}
		
	function explodeMID($userid){
		$u = explode(".",$userid);
		$hasil = array();
		$grup = substr($u[0],0,1);
		array_push($hasil,$grup);
		 
		$userid = intval(substr($u[0],1));
		array_push($hasil,$userid); 

		$ref = $u[1];
		array_push($hasil,$ref); 
		return $hasil;
	}

	function alert($n){
		echo "<div class='web-alert'>".$n."</div>";
	}

	function menuAlert($judul,$n){
		echo "<div style='padding:30px;margin:auto;width:60%;background:#FFF'>";
		echo "<div class='web-alert'>".$judul."</div>";
		echo "<div style='background:#FFF;border:1px solid #b71c1c;padding:20px;font-size:14px'>".$n."</div>";
		echo "</div>";
	}
	
	function confirm($n){
		echo "<div class='web-confirm'>".$n."</div>";
	}
	// Upload file untuk download file
	function UploadFile($vdir,$fupload_name,$nn){
  	//direktori file
  	$vfile_upload = $vdir . $fupload_name;
$m = "Uploaded ".$vfile_upload." - ";
	  //Simpan file
  	if(move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload)){
$m .= "Uploaded ".$vfile_upload." - OK - ";
			$ok = 0;
			if(mysql_query("INSERT INTO ta_impor (nama_file,tahun,jenis,perubahan,no) values 
			('".$fupload_name."','".$_SESSION["tahun"]."','".$_POST["datajenis"]."','".$_POST["per"]."','".$nn."'")){//,'".$_POST["nom"]."'
				$ok = 1;
				$qImport = "INSERT INTO ta_impor (nama_file,tahun,jenis,perubahan,no) values 
			('".$fupload_name."','".$_SESSION["tahun"]."','".$_POST["datajenis"]."','".$_POST["per"]."','".$nn."'";

$m .= "SAVED ".$vfile_upload." - OK - ";
			}
		}
	}

	function terbilang($x){
    $x=abs($x);
    $angka=array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp="";
    if($x<12){
        $temp=" ".$angka[$x];
    }elseif($x<20){
        $temp=terbilang($x-10)." Belas";
    }elseif($x<100){
        $temp=terbilang($x/10)." Puluh".terbilang($x%10);
    }elseif($x<200){
        $temp=" Seratus".terbilang($x-100);
    }elseif($x<1000){
        $temp=terbilang($x/100)." Ratus".terbilang($x%100);
    }elseif($x<2000){
        $temp=" Seribu".terbilang($x-1000);
    }elseif($x<1000000){
        $temp=terbilang($x/1000)." Ribu".terbilang($x%1000);
    }elseif($x<1000000000){
        $temp=terbilang($x/1000000)." Juta".terbilang($x%1000000);
    }elseif($x<1000000000000){
        $temp=terbilang($x/1000000000)." Milyar".terbilang(fmod($x,1000000000));
    }elseif($x<1000000000000000){
        $temp=terbilang($x/1000000000000)." Trilyun".terbilang(fmod($x,1000000000000));
    }    
        return$temp;
	}

	function persen($a,$b){
		$minus = 0;
		if($a < 0){
			$a = $a * -1;
			$minus = 1;
		}

		if($a < 1 || $b < 1){
			$n = "0";
		}else{
			$n = ($a/$b)*100;
		}

		if($a == $b ){
			$n = 100;
		}
		if($a == 0 ){
			$n = 0;
		}

		if($a < 0 && $b > 0){
			$a = $a * -1;
			$minus = 1;
			$n = ($a/$b)*100;
			if($a == $b){
				$n = 100;
			}
		}
		if($a > 0 && $b == 0){
			$n = 100;
		}

		$hasil = 0;
		if($minus == 0){
			$hasil = $n;
		}else{
			$hasil = ($n*-1);
		}

		return ($hasil);
	}
	
	function bagi($a,$b){
		if($a < 1 || $b < 1){
			$n = 0;
		}else{
			$n = ($a/$b);
		}
		return $n;
	}
	
	function selisih($a,$b){
		if($a < 1 || $b < 1){
			$n = 0;
		}else{
			$n = ($a/$b);
		}
		return ($a-$b);
	}
	
	function script($txt){
		echo '<script>'.$txt.'</script>';
	}
	
	function callback($txt){
		$h = "<div class='callback' style='display:block'>$txt</div>";
		echo $h;
	}

	function keterangan($txt){
		$h = "<div style='display:block;padding:5px;background:#CCC;border-bottom:1px solid #666;text-align:left'>$txt</div>";
		echo $h;
	}

	function errmsg($txt){
		$h = "<center><div style='margin:auto;width:65%;padding:20px;color:#F00;font-weight:bold;margin-top:50px;border:1px solid #F00;background:#FFF'>$txt</div></center>";
		echo $h;
	}
	
  function str_num($num){
    return number_format($num);
  }
	
	function toOption($array,$default=''){
		$opt = array();
		if($default != ''){
			array_push($opt,"__".$default);
		}
		foreach($array  as $h){
			array_push($opt,$h->idx."__".$h->keterangan);
		}
		return $opt;
	}
	
	function cek_sel($def,$cek){
		if($def == $cek){
			$sel = "SELECTED";
		}else{
			$sel = "";
		}
		return $sel;
	}

	function cek_sels($def,$cek){
		if($def == $cek){
			$sel = "SELECTED";
		}else{
			$sel = "";
		}
		echo $sel;
	}
	function mmddyyyy($tgl){
		//2021-04-06 00:00:00
		$t1 = explode(" ",$tgl);
		$t2 = explode("-",$t1[0]);
//		return $t2[1]."/".$t2[2]."/".$t2[0];
		return $t2[0]."-".$t2[1]."-".$t2[2];
	}
	
	function flash(){
		if(session()->getFlashdata('message') == true){
			echo "
			<div class='alert alert-success show rounded' role='alert' style='position:fixed;top:50px;right:10px;width:300px'>
				".session()->getFlashdata("message")."
			</div>";
			echo '
			<script>
				window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove(); 
					});
				}, 1500);
			</script>';
		}else if(session()->getFlashdata('error') == true){
			echo "
			<div class='alert alert-danger show rounded' role='alert' style='position:fixed;top:50px;right:10px;width:300px'>
				".session()->getFlashdata("error")."
			</div>";
			echo '
			<script>
				window.setTimeout(function() {
					$(".alert").fadeTo(1000, 0).slideUp(500, function(){
						$(this).remove(); 
					});
				}, 1500);
			</script>';
		}
	}
	function ngTanggal($tanggal,$format) {
		$bulan = array("-","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$bln = array("-","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des");
		$thi = date("Ymdhis");
		$hasil = $tgl = $bl = $thn = "";
		if($tanggal != ''){
			$thi = str_replace("/","",$tanggal);
			$tgl = substr($thi,0,2);
			$bl = intval(substr($thi,2,2));
			$thn = substr($thi,4,4);
	}
		switch($format){
			case "ddmmmyyyy":
				$hasil = intval($tgl)." ".$bln[$bl]." ".$thn;
				break;
			case "ddmmmmyyyy":
				$hasil = intval($tgl)." ".$bulan[$bl]." ".$thn;
				break;
			case "ddmmyyyy":
				$hasil = intval($tgl)."-".pjg($bl,2)."-".$thn;
				break;
			case "mmmyyyy":
				$hasil = $bulan[$bl]." ".$thn;
				break;
			case "mysql":
				$hasil = $thn."-".pjg($bl,2)."-".intval($tgl);
				break;
			case "js":
				$hasil = $thn."-".pjg($bl,2)."-".intval($tgl);
				break;
			case "dd":
				$hasil = intval($tgl);
				break;
			case "yyyy":
				$hasil = $thn;
				break;
			case "mm":
			$hasil = $bl;
			break;
	
			case "sqlserver":
				$hasil = intval($tgl)."/".$bl."/".$thn;
				break;
			default :
				$hasil = "no var";//$thi;
		}
		if(strlen($tanggal) < 8){
			$hasil = "";
		}
		return $hasil;
	}
	function ngSQLSRVTGL($tanggal){
		$t = explode(" ",$tanggal);//2022-01-18
		$d = explode("-",$t[0]);
		$tgl = $d[2];
		$bl = intval($d[1]);
		$thn = $d[0];
		$bln = array("-","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des");
		$hasil = intval($tgl)." ".$bln[$bl]." ".$thn;
		if($tanggal == ""){
			$hasil = "-";
		}

		return $hasil;
	}
	function ngSQLTanggal($tanggal,$format) {
		$bulan = array("-","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$bln = array("-","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des");
		$thi = date("Y/m/d/his");
		$hasil = $tgl = $bl = $thn = "";
		if($tanggal != ''){
			$thi = $tanggal;
			$d = explode("/",$thi);
			$tgl = $d[1];
			$bl = intval($d[0]);
			$thn = $d[2];
		}
		switch($format){
			case "ddmmmyyyy":
				$hasil = intval($tgl)." ".$bln[$bl]." ".$thn;
				break;
			case "ddmmmmyyyy":
				$hasil = intval($tgl)." ".$bulan[$bl]." ".$thn;
				break;
			case "ddmmyyyy":
				$hasil = intval($tgl)."-".pjg($bl,2)."-".$thn;
				break;
			case "mmmyyyy":
				$hasil = $bulan[$bl]." ".$thn;
				break;
			case "mysql":
				$hasil = $thn."-".pjg($bl,2)."-".intval($tgl);
				break;
			case "js":
				$hasil = $thn."-".pjg($bl,2)."-".intval($tgl);
				break;
			case "dd":
				$hasil = intval($tgl);
				break;
			case "yyyy":
				$hasil = $thn;
				break;
			case "mm":
				$hasil = $bl;
				break;
			case "sqlserver":
				$hasil = intval($tgl)."/".$bl."/".$thn;
				break;
			default :
				$hasil = $thi;
		}
		if(strlen($tanggal) < 8){
			$hasil = "-";
		}
		return $hasil;
	}
	function dmyy($txt){
		$nilai = substr($txt,6,2)."-".substr($txt,4,2)."-".substr($txt,0,4);
		return $nilai;
	}
	
	function thi(){
		$thi = date("Ymdhis");
		return $thi;
	}
	
	function Ymd(){
		$thi = date("Ymd");
		return $thi;
	}
	
	function tglTgl($txt){
		$tgl = substr($txt,6,2);
		return intval($tgl);
  }
	
	function pjg($tx,$l){
    $p = strlen($tx);
    $t = $l - $p;
    if($t > 0){
      $txt = str_repeat("0",$t).$tx;
    }else{
      $txt = $tx; 
    }
    return $txt;
  }
	
	function no_inject($txt){
		$r = stripslashes($txt);
		$r = htmlentities($r);
		return $r;
	}
	
	function judul($txt){
		echo "<div style='display:block;padding:10px;font-weight:bold;font-size:16px;text-align:center'>";
		echo strtoupper($txt);
		echo "</div>";	
	}
	
	function say($txt,$jdl=""){
		echo "<div>";
			if($jdl != ""){
				echo "<div style='border:1px solid #333;background:#0288d1;color:#000;font-weight:bold;margin-bottom:1px;padding:10px'>".$jdl."</div>";
			}else{
				echo "<div style='border:1px solid #333;background:#0288d1;color:#000;font-weight:bold;margin-bottom:1px;padding:10px'>Query</div>";
			}
			echo "<div style='border:1px solid #333;background:#FFF;color:#000;margin-bottom:12px;padding:10px'>";
				echo nl2br($txt);
			echo "</div>";
		echo "</div>";
	}
	function sayExit($txt){
		echo nl2br($txt)."<hr>";
		die();
	}
	
	function nol($txt){
		$n = floatval($txt);
		if($n < 0){
			$n = 0;
		}
		return $n;
	}

	function minus($txt){
		$n = floatval($txt);
		if($n < 0){
			$n = "(".($n*-1).")";
		}
		return $n;
	}

	function minusFormat($txt){
		$n = floatval($txt);
		if($n < 0){
			$n = "(".number_format(($n*-1),2).")";
		}else{
			$n = number_format($n,2);
		}
		return $n;
	}

	function minusFormat4($txt){
		$n = floatval($txt);
		if($n < 0){
			$n = "(".number_format(($n*-1),4).")";
		}else{
			$n = number_format($n,4);
		}
		return $n;
	}
	
	function gd($txt){
		$h = nl2br(htmlentities(strip_tags($_GET[$txt])));
		return $h;
	}
	
	function xls_data($txt){
		$h = mysql_real_escape_string(htmlentities(strip_tags($txt)));
		$h = str_replace(":","_");
		return $h;
	}

	function pd($txt){
		//$h = mysql_escape_string(htmlentities(strip_tags($_POST[$txt])));
		$t = str_replace("<br />","",$_POST["$txt"]);
		$t = str_replace("<","",$t);
		$t = str_replace(">","",$t);
		$h = addslashes(nl2br(htmlentities($t)));
		return $h;
	}

	function txt($txt){
		$h = str_replace("'","&#39;",$txt);
		return $h;
	}
	
	function toInt($txt){
		return str_replace(",","",$txt);
	}
	
	function error($txt){
		echo "<div style='display:block;margin-left:10%;margin-right:10%;padding:10px;font-weight:bold;font-size:16px;text-align:center;background:#F00;
		border:1px solid #F00;margin-bottom:0px;color:#FFF'>ERROR</div>";

		echo "<div style='display:block;margin-left:10%;margin-right:10%;padding:30px;font-weight:bold;font-size:14px;text-align:center;background:#F5A9BC;border:1px solid #F00;margin-bottom:30px'>";
		echo strtoupper($txt);
		echo "</div>";	
	}
	
	function jdl($txt){
		echo "<div style='display:block;margin-left:10%;margin-right:10%;padding:30px;font-weight:bold;font-size:18px;
		text-align:center;background:#F5A9BC;border:1px solid #F00;margin-bottom:30px'>";
		echo strtoupper($txt);
		echo "</div>";	
	}
	
	function sukses($txt){
		echo "<div style='display:block;margin-left:10%;margin-right:10%;padding:10px;font-weight:bold;font-size:16px;text-align:center;background:#0F0;
		border:1px solid #0F0;margin-bottom:0px;color:#FFF'>PROSES SELESAI</div>";

		echo "<div style='display:block;margin-left:10%;margin-right:10%;padding:30px;font-weight:bold;font-size:14px;text-align:center;background:#9FF781;border:1px solid #0F0;margin-bottom:30px'>";
		echo strtoupper($txt);
		echo "</div>";	
	}

	
	function tanggalhariini(){
		$hari = array("-","Senin","Selasa","Rabu","Kamis","Jum\'at","Sabtu","Minggu");
		$bln = array("-","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$hasil = $hari[date("N")].", ".date("d")." ".$bln[date("n")]." ".date("Y");
		return $hasil;
	}
	
	$hColor = array("#7cb5ec", "#90ed7d", "#f7a35c", "#8085e9", "#f15c80", "#e4d354", "#2b908f", "#f45b5b", "#91e8e1");
	$tColor = array("#333333", "#ffffff", "#333333", "#333333", "#333333", "#333333", "#333333", "#333333", "#333333", "#333333");
	
	function createBarChart($col,$val,$text){
		$bc  = "<div class='ig-barchart' style='background:#FFF'>&nbsp;";
			$bc .= "<div class='ig-barchart-inside' style='z-index:0;width:".$val."%;background:".$col."'>&nbsp;</div>";
			$tc = "#333333";
			if($col == "#434348"){
				$tc = "#ffffff";
			}
			$bc .= "<div class='ig-barchart-text' style='color:".$tc."'>".$text."</div>";
		$bc .= "</div>";
		
		echo $bc;
	}
	
	function leapYear($thn,$bln){
		$yes = array("","31","29","31","30","31","30","31","31","30","31","30","31");
		$no = array("","31","28","31","30","31","30","31","31","30","31","30","31");		
		$ret = 28;
		if($bln != 2){
			$ret = $no[$bln];
		}else{
			if($thn % 400 == 0){ //LeapYear
				$ret = 29;
			}else{
				if($thn % 100 == 0){ //Not Leap Year
					//$ret = 28;
				}else{
					if($thn % 4 == 0){ //LeapYear
						$ret = 29;
					}
				}
			}
		}
		return $ret;
	}

	function paginate($item_per_page, $current_page, $total_records, $total_pages, $page_url){
		$pagination = '';
		if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
			$pagination .= '<ul class="pagination">';
       
			$right_links    = $current_page + 3;
			$previous       = $current_page - 3; //previous link
			$next           = $current_page + 1; //next link
			$first_link     = true; //boolean var to decide our first link
       
			if($current_page > 1){
				$previous_link = ($previous==0)?1:$previous;
				$pagination .= '<li class="first"><a href="#" class='.$page_url.' data-page="1" title="First">&laquo;</a></li>'; //first link
				$pagination .= '<li><a href="#" class='.$page_url.' data-page='.$previous_link.' title="Previous">&lsaquo;</a></li>'; //previous link
				for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
					if($i > 0){
						$hal = $i;//$i."-".($i*$item_per_page);
						$pagination .= '<li><a href="#" class='.$page_url.' data-page='.$i.'>'.$hal.'</a></li>';
					}
				}  
				$first_link = false; //set first link to false
			}
       
			if($first_link){ //if current active page is first link
				$hal = $current_page;//((($current_page-1)*$item_per_page)+1)."-".($current_page*$item_per_page);
				$pagination .= '<li class="first active">'.$hal.'</li>';
			}elseif($current_page == $total_pages){ //if it's the last active link
				$hal = $current_page;//((($current_page-1)*$item_per_page)+1)."-".($current_page*$item_per_page);
				$pagination .= '<li class="last active">'.$hal.'</li>';
			}else{ //regular current link
				$hal = $current_page;//((($current_page-1)*$item_per_page)+1)."-".($current_page*$item_per_page);
				$pagination .= '<li class="active">'.$hal.'</li>';
			}
               
			for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
				if($i<=$total_pages){
					$hal = $i;//((($i-1)*$item_per_page)+1)."-".($i*$item_per_page);
					$pagination .= '<li><a href="#" class='.$page_url.' data-page='.$i.'>'.$hal.'</a></li>';
				}
			}
			if($current_page < $total_pages){
				$next_link = ($i > $total_pages)? $total_pages : $i;
				$pagination .= '<li><a href="#" class='.$page_url.' data-page='.$next_link.' >&rsaquo;</a></li>'; //next link
				$pagination .= '<li class="last"><a href="#" class='.$page_url.' data-page='.$total_pages.' title="Last">&raquo;</a></li>'; //last link
				//$pagination .= '<li class="last material '.$page_url.'" data-page='.$total_pages.' title="Last">skip_next</li>'; //last link
			}
       
			$pagination .= '</ul>';
		}
		return $pagination; //return pagination links
	}
?>
