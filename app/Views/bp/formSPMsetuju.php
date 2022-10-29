<?php
  $form = new Form_render;
?>
<form id='frmSPM'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$spm->NOSPM));
    $form->addHidden(array("id"=>"idxsko","value"=>""));

    $reg = $spm->NOREG;
    $kep = $spm->KEPERLUAN;
    $form->addGroup(array("type"=>"text","id"=>"txtNoSPM","label"=>"Nomer SPM","placeholder"=>"","readonly"=>"1","value"=>$spm->NOSPM));
    $tgl = substr($spm->TGLSPM, 0,10);
    $row = array(
      array("width"=>"5","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","placeholder"=>"","readonly"=>"1","value"=>$tgl),
      array("width"=>"7","type"=>"text","id"=>"txtJenisBukti","label"=>"Jenis Bukti","readonly"=>"readonly","value"=>"UP")
    );
    $form->addRow($row);
    $bln = array();
    foreach($bulan as $b){
      array_push($bln,$b->KD_BULAN."__".pjg($b->KD_BULAN,2)." ".$b->KET_BULAN);
    }
    $row = array(
      array("width"=>"8","type"=>"select","id"=>"txtBulan","label"=>"Untuk Bulan","readonly"=>"1","placeholder"=>"","default"=>$spm->KD_BULAN,"option"=>$bln),
      array("width"=>"4","type"=>"text","id"=>"txtNoReg","label"=>"No Reg SPM","readonly"=>"readonly","value"=>$reg)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtDasar","label"=>"Dasar Pengeluaran","readonly"=>"1","placeholder"=>"","value"=>$spm->KETOTOR));
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"1","placeholder"=>"","value"=>$kep));

    $penolakan = array('1__Diterima','0__Ditolak');
    $row = array(
      array("width"=>"5","type"=>"text","id"=>"txtTanggalValid","label"=>"Tanggal","placeholder"=>"","readonly"=>"0","value"=>$spm->TGLVALID),
      array("width"=>"7","type"=>"select","id"=>"txtPenolakan","label"=>"Status","default"=>$spm->PENOLAKAN,"option"=>$penolakan)
    );
    $form->addRow($row);
    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggalValid").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#frmSPM").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_tab("1","setujuSPM",$("#frmSPM").serialize());
  });
  /*
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });
  $("#txtDasar").click(function(){
    if($("#txtTanggal").val() == ""){
      alert('Masukkan Tanggal SPM sebelum memilih SPP');
    }else{
      post_to_modal("sppList","tanggal="+$("#txtTanggal").val(),"Data Surat Permintaan Pembayaran - SPP");
    }
  });
  $("#btnSimpan").click(function(){
    post_to_TAB("1","setujuSPM",$("#frmSPM").serialize());
  });
  */
</script>
