        <!-- Footer -->
        <footer class="footer-container" style='position:fixed;bottom:0px;left:0px;right:0px;background:#333'>
	        <div class="container">
	        	<div class="row">
                    <div class="col" style="text-align:center">
                    	SIPeDe - &copy; 2020 Budgeting Crew 115.
                    </div>
                </div>
	        </div>
        </footer>

        <div id="form-container">
          <div class="form-title" id="form-title">This is form title</div>

          <button type="button" class="btn btn-danger btn-sm" aria-label="Left Align" id="form-close">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
          </button>
          <div id="form-content"></div>
          <div class="form-footer" id="form-footer">&nbsp;</div>
        </div>

      </div>
	        <!-- End content -->

    </div>
        <!-- End wrapper -->

        <!-- Javascript -->
      <div id='divProses'></div>
      <div id='divProsesAjax'></div>
<?php
        echo $this->include('templates/process');
?>
  <div id='mtx' style='background: rgba(0, 0, 0, 0.1);position:fixed;left: -3000px;top: 0px;z-index: 16000;'>
    <center>
    <div style='width:300px;height:50px;margin:auto;margin-top:350px;color:#FFF;border-radius: 3px;background: rgba(0, 0, 0, 0.75);border:1px solid #FFF'>
      <br><b id='quotes'>Loading... Mohon tunggu...</b>
    </div>
  </center>
  </div>
</body>
  <script type="text/javascript">
      //if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="<?php echo base_url("public/assets/js/bootstrap.min.js"); ?>"></script>

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
      <script src="public/assets/js/excanvas.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url("public/assets/js/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/jquery.dataTables.bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/dataTables.buttons.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/buttons.flash.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/buttons.html5.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/buttons.print.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/buttons.colVis.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/dataTables.select.min.js"); ?>"></script>
    
    <script src="<?php echo base_url("public/assets/js/jquery-ui.custom.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/jquery.ui.touch-punch.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/jquery.easypiechart.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/jquery.sparkline.index.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/jquery.flot.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/jquery.flot.pie.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/jquery.flot.resize.min.js"); ?>"></script>

    <!-- ace scripts -->
    <script src="<?php echo base_url("public/assets/js/ace-elements.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/assets/js/ace.min.js"); ?>"></script>
</html>
<script>
  $(".web-tab").web_tab({"jenis":"form","judul":"SIPD Lokal Data"});

  $("#form-close").click(function(){
    hide_form();
  });

  $(".has-tooltip").tooltip();

  $("#mtx").css("height",window.innerHeight+"px");
  $("#mtx").css("width",window.innerWidth+"px");

  function showProcess(){
    $("#modal-judul-process").html("Process");
    $("#modal-process").text("_");
    $("#processModal").modal('show');
    //$('.modal-backdrop').removeClass("modal-backdrop");
//    $("#processModal").css({"left":"0px"}).show();
//    $("body,html").css({"overflow":"hidden"});
  }

  $("#closeModalProcess").click(function(){
     $("#processModal").css({"left":"-10000px"}).hide();
     $("body,html").css({"overflow":"auto"});
  });

  function gantiJudul(text){
    $("#modal-judul-process").html(text);
  }
  $('#movableDialog').draggable({
     //handle: ".modal-header";
  });

  $("#myScrollBtn").click(function(){
    $("#modalContent").get(0).scrollIntoView({behavior: 'smooth'});
  });
  
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  }) 

  $(".alert").on('click',function(){
    $(".alert").alert('close');
  });

  $(".menuGantiOPD").click(function(){
    urlx = encodeURI(window.location);
//    alert(urlx);
    url = urlx.split('75');
    al = url[1].replaceAll("/","XXX");
    window.location.href ='../home/gantiOPD/'+$(this).data('elm')+"__"+al;
  })

</script>