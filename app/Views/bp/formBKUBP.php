<?php
  $form = new Form_render;
?>
<form id='frmBKUBP'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>session()->nobkuskpd));
    $form->addHidden(array("id"=>"idxsko","value"=>""));
    if(session()->nobkuskpd == ""){
      $row = array(
        array("width"=>"4","type"=>"text","id"=>"txtNoBKU","label"=>"No. BKU","placeholder"=>"","value"=>pjg($noreg,5),"readonly"=>"1"),
        array("width"=>"8","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","readonly"=>"0","value"=>"")
      );
    }else{
      $row = array(
        array("width"=>"4","type"=>"text","id"=>"txtNoBKU","label"=>"No. BKUx","placeholder"=>"","value"=>pjg($bku->NOBKUSKPD,5),"readonly"=>"1"),
        array("width"=>"8","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","readonly"=>"0","value"=>$bku->TGLBKUSKPD)
      );
    }
    $form->addRow($row);
    $jb = array(
      "SP2D__SP2D",
      "BPK__BPK",
      "Panjar__Panjar",
      "Pajak__Pajak",
      "Bank__Bank",
      "Pelimpahan Uang__Pelimpahan Uang",
      "Pengembalian__Pengembalian"
    );
    $row = array(
      array("width"=>"7","type"=>"select","id"=>"txtJB","label"=>"Jenis Bukti","placeholder"=>"","default"=>"SP2D","option"=>$jb),
      array("width"=>"5","type"=>"text","id"=>"txtTanggalBukti","label"=>"Tgl Bukti","readonly"=>"readonly","value"=>$bku->TGLSP2D)
    );
    $form->addRow($row);
    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtNoBukti","label"=>"Nomer Bukti","readonly"=>"readonly","value"=>$bku->NOSP2D)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Uraian","readonly"=>"1","placeholder"=>"","value"=>$bku->URAIAN));

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#frmBKUBP").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    $("#listBKUBP").html("<center>...loading...</center>");
    post_to_content("listBKUBP","simpanBKUBP",$("#frmBKUBP").serialize());
    hide_form();
  });
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });
  $("#txtTanggalBukti,#txtNoBukti,#txtUntuk").on('click',function(){
    if($("#id").val() == ""){
      post_to_modal("../utama/listBKUBP/"+$("#txtJB").val(),"a=a","Data "+$("#txtJB").val());
    }
  });
</script>
