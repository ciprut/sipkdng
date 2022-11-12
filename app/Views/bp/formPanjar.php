<?php
  $form = new Form_render;
?>
<form id='frmPanjar'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$panjar->NOPANJAR));
    $form->addHidden(array("id"=>"npengajuan","value"=>pjg((session()->noreg), 5)."/Pengajuan-Panjar/".getKdSKPD($unit->KDUNIT)."/".session()->cur_thang));
    $form->addHidden(array("id"=>"npengembalian","value"=>pjg((session()->noreg), 5)."/Pengembalian-Panjar/".getKdSKPD($unit->KDUNIT)."/".session()->cur_thang));

    $ro = ($panjar->NOPANJAR == '') ? "1" : "0";
    $jb = array("__Pilih","pengajuan__Pengajuan Panjar","pengembalian__Pengembalian Panjar");
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"txtJB","label"=>"Jenis Panjar","placeholder"=>"","default"=>"SP2D","option"=>$jb)
    );
    $form->addRow($row);
    if($panjar->NOPANJAR != ''){
      $reg = pjg(session()->noreg,5);
      $kep = $panjar->URAIAN;
      $form->addGroup(array("type"=>"text","id"=>"txtNoPanjar","label"=>"Nomer Panjar","placeholder"=>"","readonly"=>"1","value"=>$panjar->NOPANJAR));
    }else{
      $reg = pjg((session()->noreg),5);
      $kep = "Panjar Kegiatan : ";
      $nomer = pjg((session()->noreg), 5)."/PANJAR/".getKdSKPD($unit->KDUNIT)."/".session()->cur_thang;
      $form->addGroup(array("type"=>"text","id"=>"txtNoPanjar","label"=>"Nomer Panjar","placeholder"=>$webset,"value"=>$nomer,"readonly"=>"0"));
    }
    $form->addGroup(array("type"=>"textarea","id"=>"txtUraian","label"=>"Untuk","readonly"=>"0","placeholder"=>"","value"=>$kep));

    $tgl = substr($panjar->TGLPANJAR, 0,10);
    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtReff","label"=>"Nomor Referensi","placeholder"=>"","value"=>$panjar->REFF),
      array("width"=>"6","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","placeholder"=>"","value"=>$tgl),
      array("width"=>"6","type"=>"select","id"=>"txtSB","label"=>"Sumber Panjar","placeholder"=>"","default"=>"bank","option"=>array("bank__Bank","tunai__Tunai"))
    );
    $form->addRow($row);

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#frmPanjar").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    if(cekForm('txtTanggal,txtJB,txtNoPanjar')){
      post_to_content("listPanjar","simpanPanjar",$("#frmPanjar").serialize());
      hide_form();
    }
  });
  $("#txtJB").change(function(){
    $("#txtNoPanjar").val($("#n"+$(this).val()).val());
  })
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });
  $("#txtNoTBP,#txtTglTBP").click(function(){
    post_to_modal("pajakTBPList","tanggal="+$("#txtTanggal").val(),"Tanda Bukti Pengeluaran");
  });
</script>
