<?
  session_start();
  $h = $data["login"];
    if($h["Nama"] != ""){
      $_SESSION["operator_name"] = $h["Nama"];
      $_SESSION["operator_id"] = $h["ID"];
      $_SESSION["operator_lokasi"] = $h["Lokasi"];
      $_SESSION["level"] = $h["Level"];
      $_SESSION["operator_akses"] = $h["Akses"];
    }else{
      $_SESSION["operator_name"] = "";
      $_SESSION["level"] = "4";
      $_SESSION["operator_id"] = "";
      $_SESSION["operator_lokasi"] = "";
      $_SESSION["operator_akses"] = "1,2,3,4";
    }
  header("Location: ".APP_URL);
?>
