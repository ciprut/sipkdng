<?
  header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
?>
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <title><?= $title; ?></title>

      <!-- CSS -->

      <?          
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/bootstrap.min.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/font-awesome/4.5.0/css/font-awesome.min.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/fonts.googleapis.com.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/ace.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/ace-skins.min.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/ace-rtl.min.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/jquery.dataTables.css?t=".time())."'>";
//        echo "<link rel='stylesheet' href='".base_url("assets/css/ace-extra.min.css?t=".time())."'>";

        echo "<link rel='stylesheet' href='".base_url("public/assets/css/style.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/web-plugin.css?t=".time())."'>";
        //echo "<link rel='stylesheet' href='".base_url("public/assets/css/test.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/override.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/jquery-ui.min.css?t=".time())."'>";
        
      ?>

      <!-- Favicon and touch icons
-->
      <script src="<?= base_url("public/assets/js/jquery-2.1.4.min.js"); ?>"></script>
      <script src="<?= base_url("public/assets/js/ace-extra.min.js"); ?>"></script>
      <script src="<?= base_url("public/assets/js/script.js"); ?>"></script>

      <script src="<?= base_url("public/assets/js/datatables.js"); ?>" type="text/javascript"></script> 

      <script src="<?= base_url("public/assets/js/jquery.myplugin.js"); ?>"></script>
      <script src="<?= base_url("public/assets/js/jquery-ui.min.js"); ?>"></script>

    </head>
    <body class="no-skin">
    <div style='padding:10px;background-color:#FFF;'>
      <? 
        echo $this->renderSection('content'); 
      ?>
      <div class='clear'></div>
    </div>

    