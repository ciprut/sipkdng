<?php
  $this->extend('templates/layout');
  $this->section('content');

  $form = new Form_render;
  ?>
  <form id='frmValidasiKasda'>
  <?php

  $jenis = array(
    "__Pilih Jenis SP2D",
    "bkud__Penerimaan",
    "bkuk__Pengeluaran",
    "bkut__Transfer"
  );
  $row = array(
    array("width"=>"1","type"=>"text","id"=>"nobbantu","label"=>"Kode","readonly"=>"readonly","placeholder"=>"","value"=>""),
    array("width"=>"7","type"=>"text","id"=>"txtRek","label"=>"Rekening BUD","readonly"=>"readonly","value"=>""),
    array("width"=>"1","type"=>"text","id"=>"txtTglMulai","label"=>"Dari","placeholder"=>"","value"=>date_format(date_create(session()->cur_thang.'-01-01'),'Y-m-d')),
    array("width"=>"1","type"=>"text","id"=>"txtTglSsampai","label"=>"Sampai","placeholder"=>"","value"=>date('Y-m-d')),
    array("width"=>"2","type"=>"select","id"=>"jnsBUD","label"=>"Jenis Validasi","default"=>"","option"=>$jenis,"readonly"=>"0")
  );
  $form->addRow($row);
?>
</form>
<div id="listValidasi"></div>
<script>
  $("#txtTglMulai").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  $("#txtTglSsampai").datepicker({changeMonth: true,changeYear: true,maxDate:'+0m +7d',dateFormat: 'yy-mm-dd'});

  $("#nobbantu,#txtRek").click(function(){
    post_to_modal("../utama/rekList","List Rekening");
    $("#listValidasi").html('');
    //$("#jnsBUD").val('').prop('disabled',true);
  })

  $("#listUnit").change(function(){
    $("#listSP2D").html('');
    $("#jnsSP2D").val('').prop('disabled',true);
    if($(this).val() != ''){
     // $("#jnsSP2D").val('').prop('disabled',false);
    }   
  })
  $("#jnsBUD").change(function(){
    if($("#txtTglMulai").val() == '' && $("#txtTglSsampai").val() == ''){
      $("#listValidasi").html('');
    }
    $("#listValidasi").html('');
    if($(this).val() != ''){
      post_to_content("listValidasi","listValidasi",$("#frmValidasiKasda").serialize());
      $(this).val('');
    }
  })
</script>
<?php $this->endSection(); ?>