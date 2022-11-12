<?php
  $form = new Form_render;
?>
<form id='frmSPMGU'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$spm->NOSPM));
    $form->addHidden(array("id"=>"idxsko","value"=>""));
    $form->addHidden(array("id"=>"noGU","value"=>""));
    $form->addHidden(array("id"=>"noTU","value"=>""));

    if($spp->NOSPM != ''){
      $reg = pjg($spm->NOREG,5);
      $kep = $spm->KEPERLUAN;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPM","label"=>"Nomer SPM","placeholder"=>"","readonly"=>"1","value"=>$spm->NOSPM));
    }else{
      $reg = pjg((session()->noreg),5);
      $kep = $keperluan;
      $nospm = pjg((session()->noreg), 5)."/SPM-".strtoupper(session()->jnsSpm)."/".getKdSKPD($unit->KDUNIT)."/".$bendahara->JAB_BEND."/".session()->tahun;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPM","label"=>"Nomer SPM","placeholder"=>$webset,"value"=>$nospm,"readonly"=>"1"));
    }
    $tgl = substr($spm->TGLSPM, 0,10);
    $row = array(
      array("width"=>"4","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","placeholder"=>"","value"=>$tgl),
      array("width"=>"8","type"=>"select","id"=>"txtJnsSPM","label"=>"Jenis SPM","placeholder"=>"","default"=>$spm->Jenis,"option"=>array("GU__Pengajuan SPM GU","TU__Pengajuan SPM TU"))
    );
    $form->addRow($row);
    $bln = array();
    foreach($bulan as $b){
      array_push($bln,$b->KD_BULAN."__".pjg($b->KD_BULAN,2)." ".$b->KET_BULAN);
    }
    $row = array(
      array("width"=>"4","type"=>"text","id"=>"txtNoReg","label"=>"No Reg SPM","readonly"=>"readonly","value"=>$reg),
      array("width"=>"8","type"=>"text","id"=>"txtTanggalSPP","label"=>"Tanggal SPP","readonly"=>"readonly","value"=>"")
    );
    $form->addRow($row);

    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtNoSPP","label"=>"Nomor SPP","placeholder"=>"","value"=>$tgl,"readonly"=>"readonly"),
      array("width"=>"4","type"=>"text","id"=>"txtTanggalSPD","label"=>"Tanggal SPD","readonly"=>"readonly","value"=>""),
      array("width"=>"8","type"=>"text","id"=>"txtNoSPD","label"=>"Nomor SPD","placeholder"=>"","value"=>$tgl,"readonly"=>"readonly")
    );
    $form->addRow($row);

    $form->addGroup(array("type"=>"textarea","id"=>"txtDasar","label"=>"Dasar Pengeluaran","readonly"=>"1","placeholder"=>"","value"=>$spm->KETOTOR));
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"1","placeholder"=>"","value"=>$kep));

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
  $("#frmSPMGU").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listSPM","simpanSPMGU",$("#frmSPMGU").serialize());
    hide_form();
  });
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });
  $("#txtTanggalSPP,#txtNoSPP").click(function(){
    if($("#txtTanggal").val() == ""){
      alert('Masukkan Tanggal SPM sebelum memilih SPP');
    }else{
      post_to_modal("sppList","tanggal="+$("#txtTanggal").val(),"Data Surat Permintaan Pembayaran - SPP");
    }
  });
  $("#txtJnsSPM").change(function(){
    txt = $("#txtJnsSPM option:selected").text();
    $("#txtUntuk").val(txt);
  });

</script>
