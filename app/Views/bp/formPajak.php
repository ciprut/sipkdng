<?php
  $form = new Form_render;
?>
<form id='frmPajak'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$pajak->NOBKPAJAK));
    $form->addHidden(array("id"=>"idxsko","value"=>""));
    $ro = ($pajak->NOBKPAJAK == '') ? "1" : "0";

    if($pajak->NOBKPAJAK != ''){
      $reg = pjg(session()->noreg,5);
      $kep = $pajak->URAIAN;
      $form->addGroup(array("type"=>"text","id"=>"txtNoPajak","label"=>"Nomer SPP","placeholder"=>"","readonly"=>"1","value"=>$pajak->NOBKPAJAK));
    }else{
      $reg = pjg((session()->noreg),5);
      $kep = $keperluan;
      $nospp = pjg((session()->noreg), 5)."/PAJAK/".getKdSKPD($unit->KDUNIT)."/".$bendahara->JAB_BEND."/".session()->cur_thang;
      $form->addGroup(array("type"=>"text","id"=>"txtNoPajak","label"=>"Nomer SPP","placeholder"=>$webset,"value"=>$nospp,"readonly"=>"1"));
    }
    $tgl = substr($pajak->TGLBKPAJAK, 0,10);
    $tglBuku = substr($pajak->TGLBKPAJAK, 0,10);
    $row = array(
      array("width"=>"6","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","placeholder"=>"","value"=>$tgl),
      array("width"=>"6","type"=>"text","id"=>"txtTglBuku","label"=>"Tanggal Buku","readonly"=>"0","value"=>$tglBuku)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"text","id"=>"txtNoTBP","label"=>"Nomor TBP","readonly"=>"1","placeholder"=>"","value"=>$pajak->NOBPK));
    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtTglTBP","label"=>"Tanggal TBP","readonly"=>"readonly","value"=>ngSQLSERVERTGL($pajak->TGLBPK,103))
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"0","placeholder"=>"","value"=>$kep));

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal,#txtTglBuku").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy',altField: "#txtTglBuku"});
  $("#frmPajak").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listPajak","simpanPajak",$("#frmPajak").serialize());
    hide_form();
  });
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });
  $("#txtNoTBP,#txtTglTBP").click(function(){
    post_to_modal("pajakTBPList","tanggal="+$("#txtTanggal").val(),"Tanda Bukti Pengeluaran");
  });
</script>
