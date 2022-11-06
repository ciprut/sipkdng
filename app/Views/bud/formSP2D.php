<?php
  $form = new Form_render;
?>
<form id='frmSP2D'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$sp2d->NOSP2D));
    $form->addHidden(array("id"=>"idxttd","value"=>$sp2d->IDXTTD));
    $form->addHidden(array("id"=>"nobbantu","value"=>$sp2d->NOBBANTU));

    if($sp2d->NOSP2D != ''){
      $reg = pjg($sp2d->NOREG,5);
      $kep = $sp2d->KEPERLUAN;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSP2D","label"=>"Nomer SP2D","placeholder"=>"","readonly"=>"1","value"=>$sp2d->NOSP2D));
    }else{
      $reg = pjg((session()->noreg),5);
      $kep = $keperluan;
      $nosp2d = pjg((session()->noreg), 5)."/SP2D-".strtoupper(session()->jnsSp2d)."/".getKdSKPD($unit->KDUNIT)."/B".session()->jnsBend."/".session()->tahun;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSP2D","label"=>"Nomer SP2D","placeholder"=>$webset,"value"=>$nosp2d,"readonly"=>"1"));
    }
    $tgl = substr($sp2d->TGLSPM, 0,10);
    $row = array(
      array("width"=>"5","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","placeholder"=>"","value"=>$tgl),
      array("width"=>"3","type"=>"text","id"=>"txtJenisBukti","label"=>"Jenis Bukti","readonly"=>"readonly","value"=>"UP"),
      array("width"=>"4","type"=>"text","id"=>"txtNoReg","label"=>"No Reg SP2D","readonly"=>"readonly","value"=>$reg)
    );
    $form->addRow($row);

    $form->addGroup(array("type"=>"textarea","id"=>"txtRek","label"=>"Rekening BUD","readonly"=>"1","placeholder"=>"","value"=>$sp2d->NMBANK."\nNo Rek : ".$sp2d->NOREKB));
    $form->addGroup(array("type"=>"text","id"=>"txtSPM","label"=>"No SPM","placeholder"=>"","readonly"=>"1","value"=>$sp2d->NOSPM));
    $form->addGroup(array("type"=>"text","id"=>"txtSPD","label"=>"Dasar Pembayaran","placeholder"=>"","readonly"=>"1","value"=>$sp2d->KETOTOR));
    $form->addGroup(array("type"=>"text","id"=>"txtUntuk","label"=>"Untuk","placeholder"=>"","readonly"=>"1","value"=>$kep));

    $form->addGroup(array("type"=>"text","id"=>"txtNmBendahara","label"=>"Nama Bendahara","placeholder"=>"","readonly"=>"1","value"=>$sp2d->BENDAHARA));
    $form->addGroup(array("type"=>"text","id"=>"txtTtd","label"=>"Nama Penanda Tangan","placeholder"=>"","readonly"=>"1","value"=>$sp2d->TTDNAMA));

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#frmSP2D").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listSP2D","simpanSP2D",$("#frmSP2D").serialize());
    hide_form();
  });
  $("#txtTanggal").on('blur',function(){
    $("#txtSPD,#txtSPM,#txtRek,#txtNmBendahara,#txtTtd").val("");
  });
  $("#txtSPM").click(function(){
    if($("#txtTanggal").val() == ""){
      alert('Masukkan Tanggal SP2D sebelum memilih SPM');
    }else{
      post_to_modal("spmList","tanggal="+$("#txtTanggal").val(),"Data Surat Perintah Membayar - SPM");
    }
  });
  $("#txtRek").click(function(){
    if($("#txtTanggal").val() == ""){
      alert('Masukkan Tanggal SP2D sebelum memilih Rekening BUD');
    }else{
      post_to_modal("rekList","tanggal=","Data Rekening Bendahara Umum Daerah");
    }
  });
  $("#txtTtd").click(function(){
    post_to_modal("../utama/listTTD/04.301","x=","Data Pegawai");
  });

</script>
