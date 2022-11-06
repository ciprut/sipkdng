<?php
  $form = new Form_render;
?>
<form id='frmSPPSetuju'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$spp->NOSPP));
    $form->addHidden(array("id"=>"idxsko","value"=>""));

    if($spp->NOSPP != ''){
      $reg = pjg($spp->NOREG,3);
      $kep = $spp->KEPERLUAN;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPP","label"=>"Nomer SPP","placeholder"=>"","readonly"=>"1","value"=>$spp->NOSPP));
    }else{
      $reg = pjg((session()->noreg)+1,3);
      $kep = $keperluan;
      $nospp = pjg((session()->noreg)+1, 5)."/SPP-".strtoupper(session()->jnsSpp)."/".$unit->KDUNIT."/".$bendahara->JAB_BEND."/".session()->tahun;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPP","label"=>"Nomer SPP","placeholder"=>$webset,"value"=>$nospp,"readonly"=>"1"));
    }
    $tgl = substr($spp->TGLSPP, 0,10);
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
      array("width"=>"8","type"=>"select","id"=>"txtBulan","label"=>"Untuk Bulan","placeholder"=>"","readonly"=>"1","default"=>$spp->KD_BULAN,"option"=>$bln),
      array("width"=>"4","type"=>"text","id"=>"txtNoReg","label"=>"No Reg SPP","readonly"=>"readonly","value"=>$reg)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtDasar","label"=>"Dasar Pengeluaran","readonly"=>"1","placeholder"=>"","value"=>$spp->KETOTOR));
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"1","placeholder"=>"","value"=>$kep));

    $penolakan = array('1__Diterima','0__Ditolak');
    $row = array(
      array("width"=>"7","type"=>"select","id"=>"txtPenolakan","label"=>"Keterangan Penolakan","default"=>$spp->PENOLAKAN,"option"=>$penolakan),
      array("width"=>"5","type"=>"text","id"=>"txtTanggalValid","label"=>"Tanggal","placeholder"=>"","value"=>$tgl)
    );
    $form->addRow($row);

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggalValid").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#btnSimpan").click(function(){
    post_to_content("listSPP","setujuSPP",$("#frmSPPSetuju").serialize());
    hide_form();
  });
  $("#txtPenolakan").change(function(){
    if($(this).val() == "0"){
      $("#txtTanggalValid").val("").prop( "disabled", true ).datepicker( "option", "disabled", true );
    }else{
      $("#txtTanggalValid").val("").prop( "disabled", false ).datepicker( "option", "disabled", false );
    }
  });

</script>
