<?php
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

      <title><?php echo $title; ?></title>

      <!-- CSS -->

      <?php         
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
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/jquery-ui.min.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/chart.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/select.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/override.css?t=".time())."'>";
        echo "<link rel='stylesheet' href='".base_url("public/assets/css/animate.min.css?t=".time())."'>";
      ?>

      <!-- Favicon and touch icons
-->
      <script src="<?php echo base_url("public/assets/js/jquery-2.1.4.min.js"); ?>"></script>
      <script src="<?php echo base_url("public/assets/js/ace-extra.min.js"); ?>"></script>
      <script src="<?php echo base_url("public/assets/js/script.js"); ?>"></script>

      <script src="<?php echo base_url("public/assets/js/datatables.js"); ?>" type="text/javascript"></script> 

      <script src="<?php echo base_url("public/assets/js/jquery.myplugin.js"); ?>"></script>
      <script src="<?php echo base_url("public/assets/js/jquery-ui.min.js"); ?>"></script>
      <script src="<?php echo base_url("public/assets/js/chart.js"); ?>"></script>
      <script src="<?php echo base_url("public/assets/js/select.js"); ?>"></script>
      <style>
        #modal-judul-process {
          cursor: move;
        }
        #myScrollBtn {
          display: block; /* Hidden by default */
          position: fixed; /* Fixed/sticky position */
          bottom: 50px; /* Place the button at the bottom of the page */
          right: 30px; /* Place the button 30px from the right */
          z-index: 9999; /* Make sure it does not overlap */
          border: none; /* Remove borders */
          outline: none; /* Remove outline */
          background-color: #333; /* Set a background color */
          color: white; /* Text color */
          cursor: pointer; /* Add a mouse pointer on hover */
          border-radius: 2px; /* Rounded corners */
          font-size: 11px; /* Increase font size */
          width: 35px;
          height:35px;
          line-height: 35px;
        }

        #myScrollBtn:hover {
          background-color: #555; /* Add a dark-grey background on hover */
        }
        .dropdown-menu {
           overflow-y:auto; 
           max-height:50vh;
           width:400px;
        }
      </style>
    </head>
    <body class="no-skin">
    <button id="myScrollBtn" title="Go to top">Top</button> 

    <?php
      echo "<div id='modalContent'></div>";
      echo "<div style='display:none'>";
      echo "</div>";
      echo $this->include('templates/modals');
      echo $this->include('templates/header');
    ?>

<div class="main-container ace-save-state" id="main-container">
  <script type="text/javascript">
    try{ace.settings.loadState('main-container')}catch(e){}
  </script>

  <!-- Sidebar  <div id="sidebar" class="sidebar responsive ace-save-state"> -->
  <div id="sidebar" class="sidebar responsive ace-save-state display" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
    <script type="text/javascript">
      try{ace.settings.loadState('sidebar')}catch(e){}
    </script>
   
    <?php
      echo $this->include('templates/sidebar');
    ?>
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
      <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
  </div><!-- Sidebar -->

			<!-- Content -->
  <div class="main-content">
    <div class="main-content-inner">
      <!-- breadcumb -->
      <?php
        $uri = current_url(true);
        $ttl = explode(" - ",$title);
      ?>
      <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
          
          <li>
              <a href="<?php echo "../".$uri->getSegment(2);?>"><?php echo ucfirst($uri->getSegment(2));?></a>
          </li>
          <li class="active"><?php echo ucfirst($uri->getSegment(3));?></li>
        </ul><!-- /.breadcrumb -->
      </div>

      <div class="page-content">
        <div class="page-header">
          <?php
          if($web != ''){
            echo "<h1>".$web."</h1>";
          }else{
            ?>

          <h1>
          <?php /* echo $ttl[0]; ?>
            <small>
              <i class="ace-icon fa fa-angle-double-right"></i>
              <?php echo $ttl[1]; ?>
            </small>
          </h1>
          <?php */?>
          <?php }?>
        </div><!-- /.page-header -->

        <div class="web-tab">
          <ul class="web-tab-header">
            <li><a href="#tab-0"> <?php echo $title; ?> </a></li>
            <li><a href="#tab-1">#</a></li>
            <li><a href="#tab-2">#</a></li>
            <li><a href="#tab-3">#</a></li>
            <li><a href="#tab-4">#</a></li>
          </ul>
          <div id="tab-0">
            <?php
              echo $this->renderSection('content'); 
            ?>
            <div class='clear'></div>
          </div>
          <div id="tab-1"></div>
          <div id="tab-2"></div>
          <div id="tab-3"></div>
          <div id="tab-4"></div>
        </div> <!-- /.web-tab -->

      </div><!-- /.page-content -->
    </div> <!-- /.main-content-inner -->

    <?php
      echo $this->include('templates/footer'); 
    ?>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
      <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
  </div><!-- /.main-content -->

</div> <!-- /.main-container -->
    