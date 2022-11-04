<?php
  $form = new Form_render;
?>
<form id='frmPU'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>session()->nobuku));
    $form->addHidden(array("id"=>"idxsko","value"=>""));
    $jb = array(
      "33__Pengambilan kas Ke BSB",
      "34__Setoran Dari BSB Ke Kas Bendahara"
    );
    if(session()->nobuku == ""){
      $row = array(
        array("width"=>"4","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","readonly"=>"0","value"=>""),
        array("width"=>"8","type"=>"select","id"=>"txtJB","label"=>"Jenis Bukti","placeholder"=>"","default"=>'33',"readonly"=>"0","option"=>$jb)
      );
    }else{
      $row = array(
        array("width"=>"4","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","readonly"=>"0","value"=>ngSQLSRVTGL($pu->TGLBUKU)),
        array("width"=>"8","type"=>"select","id"=>"txtJB","label"=>"Jenis Bukti","placeholder"=>"","default"=>$pu->KDSTATUS,"readonly"=>"1","option"=>$jb)
      );
    }
    $form->addRow($row);
    $ro = ($pu->NOBUKU != "") ? "1":"0";
    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtNo","label"=>"Nomor","readonly"=>$ro,"value"=>$pu->NOBUKU)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Uraian","readonly"=>"0","placeholder"=>"","value"=>$pu->URAISTATUS));

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#frmPU").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listPU","simpanPU",$("#frmPU").serialize(),true);
    hide_form();
  });
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });
</script>
