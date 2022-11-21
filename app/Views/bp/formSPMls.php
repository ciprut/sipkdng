<?php
  $form = new Form_render;
?>
<form id='frmSPM'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$spm->NOSPM));
    $form->addHidden(array("id"=>"idxsko","value"=>""));

    if($spp->NOSPM != ''){
      $reg = pjg($spm->NOREG,3);
      $kep = $spm->KEPERLUAN;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPM","label"=>"Nomer SPM","placeholder"=>"","readonly"=>"1","value"=>$spm->NOSPM));
    }else{
      $reg = pjg((session()->noreg),3);
      $kep = $keperluan;
      $nospm = pjg((session()->noreg), 5)."/SPM-".strtoupper(session()->jnsSpm)."/".getKdSKPD($unit->KDUNIT)."/".$bendahara->JAB_BEND."/".session()->tahun;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPM","label"=>"Nomer SPM","placeholder"=>$webset,"value"=>$nospm,"readonly"=>"1"));
    }
    $tgl = substr($spm->TGLSPM, 0,10);
    $row = array(
      array("width"=>"5","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","placeholder"=>"","value"=>$tgl),
      array("width"=>"7","type"=>"text","id"=>"txtJenisBukti","label"=>"Jenis Bukti","readonly"=>"readonly","value"=>"LS")
    );
    $form->addRow($row);
    $bln = array();
    foreach($bulan as $b){
      array_push($bln,$b->KD_BULAN."__".pjg($b->KD_BULAN,2)." ".$b->KET_BULAN);
    }
    $row = array(
      array("width"=>"8","type"=>"select","id"=>"txtBulan","label"=>"Untuk Bulan","placeholder"=>"","default"=>$spm->KD_BULAN,"option"=>$bln),
      array("width"=>"4","type"=>"text","id"=>"txtNoReg","label"=>"No Reg SPM","readonly"=>"readonly","value"=>$reg)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"text","id"=>"txtDasar","label"=>"Dasar Pengeluaran","readonly"=>"1","placeholder"=>"","value"=>$spm->KETOTOR));
    $form->addGroup(array("type"=>"text","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"1","placeholder"=>"","value"=>$kep));

    $row = array(
      array("width"=>"4","type"=>"text","id"=>"txtTglBA","label"=>"Tanggal","readonly"=>"1","value"=>""),
      array("width"=>"8","type"=>"text","id"=>"txtNoBA","label"=>"No Berita Acara","readonly"=>"1","value"=>"")
    );
    $form->addRow($row);

    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtNoKontrak","label"=>"No Kontrak","readonly"=>"1","value"=>"")
    );
    $form->addRow($row);

    $row = array(
      array("width"=>"4","type"=>"text","id"=>"txtRekPHK","label"=>"Rekening","readonly"=>"1","value"=>""),
      array("width"=>"8","type"=>"text","id"=>"txtNamaPHK","label"=>"Nama Pihak Ketiga","readonly"=>"1","value"=>"")
    );
    $form->addRow($row);

    $penolakan = array('1__Diterima','0__Ditolak');
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"txtPenolakan","label"=>"Keterangan Penolakan","default"=>$spm->PENOLAKAN,"option"=>$penolakan)
    );
    $form->addRow($row);
    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#frmSPM").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    //post_to_content("listSPM","simpanSPM",$("#frmSPM").serialize());
    post_to_tab("1","simpanSPMLS",$("#frmSPM").serialize());
    hide_form();
  });
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
</script>
