<? 
	session_start();
?>
<div style='padding:20px'>
	<h1>Selamat Datang!</h1><br>
	<?	
		
		$usr = array("","Administrator","","","Operator");
		echo "".$usr[$_SESSION["level"]];
		echo "<ul>";
			echo "<li>Login dengan user admin password 1234</li>";
			echo "<li>Masuk menu Import Data Si-PeDe -> Setting. Atur setting.</li>";
			echo "<li>Masuk menu Administrator -> Login SIPD.</li>";
		echo "</ul><br><br>";

		$cookie = $token = $cookies = "";
		$url = 'https://batu.sipd.kemendagri.go.id/daerah?legfG9ESfy3bl3MOait6MzQVlzwfcEP62iqGiJzXStzs6dsLWRj06Fp8KiRfe@17cdUrnX1pq6HmzNDwFfbo0Sya/xEDoPKcGSgMgQzayqtszFOJMeGtMNE9AKi6gt8o';
	?>

</div>