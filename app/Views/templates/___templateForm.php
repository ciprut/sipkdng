<?php
  $form = new Form_render;
?>
<form id='frmSPP'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$data->NOSPP));
    $form->addHidden(array("id"=>"idxsko","value"=>""));
    $ro = ($data->NOSPP == '') ? "1" : "0";

    if($data->NOSPP != ''){
      $reg = pjg($data->NOREG,3);
      $kep = $data->KEPERLUAN;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPP","label"=>"Nomer SPP","placeholder"=>"","readonly"=>"1","value"=>$data->NOSPP));
    }else{
      $reg = pjg((session()->noreg),5);
      $kep = $keperluan;
      $nospp = pjg((session()->noreg), 5)."/SPP-".strtoupper(session()->jnsSpp)."/".$unit->KDUNIT."/".$bendahara->JAB_BEND."/".session()->cur_thang;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPP","label"=>"Nomer SPP","placeholder"=>$webset,"value"=>$nospp,"readonly"=>"1"));
    }
    $tgl = substr($data->TGLSPP, 0,10);
    $row = array(
      array("width"=>"5","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","placeholder"=>"","value"=>$tgl),
      array("width"=>"7","type"=>"text","id"=>"txtJenisBukti","label"=>"Jenis Bukti","readonly"=>"readonly","value"=>"UP")
    );
    $form->addRow($row);
    $bln = array();
    foreach($bulan as $b){
      array_push($bln,$b->KD_BULAN."__".pjg($b->KD_BULAN,2)." ".$b->KET_BULAN);
    }
    $row = array(
      array("width"=>"8","type"=>"select","id"=>"txtBulan","label"=>"Untuk Bulan","placeholder"=>"","default"=>$data->KD_BULAN,"option"=>$bln),
      array("width"=>"4","type"=>"text","id"=>"txtNoReg","label"=>"No Reg SPP","readonly"=>"readonly","value"=>$reg)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtDasar","label"=>"Dasar Pengeluaran","readonly"=>"1","placeholder"=>"","value"=>$data->KETOTOR));
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"1","placeholder"=>"","value"=>$kep));

    $penolakan = array('1__Diterima','0__Ditolak');
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"txtPenolakan","label"=>"Keterangan Penolakan","default"=>$data->PENOLAKAN,"option"=>$penolakan)
    );
    $form->addRow($row);
    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#frmSPP").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listSPP","simpanSPP",$("#frmSPP").serialize());
    hide_form();
  });
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });
  $("#txtDasar").click(function(){
    if($("#txtTanggal").val() == ""){
      alert('Masukkan Tanggal SPP sebelum memilih SPD');
    }else{
      post_to_modal("spdList","tanggal="+$("#txtTanggal").val(),"Data Surat Penyediaan Dana");
    }
  });
</script>
