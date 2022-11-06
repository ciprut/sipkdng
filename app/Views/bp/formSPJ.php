<?php
  $form = new Form_render;
?>
<form id='frmSPJ'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$spj->NOSPJ));
    $form->addHidden(array("id"=>"idxsko","value"=>""));
    $reg = pjg($noreg,5);

    $form->addHidden(array("id"=>"fmtUP","value"=>pjg($noreg, 5)."/SPJ/".getKdSKPD($unit->KDUNIT)."/UP/".session()->cur_thang));
    $form->addHidden(array("id"=>"fmtTU","value"=>pjg($noreg, 5)."/SPJ/".getKdSKPD($unit->KDUNIT)."/TU/".session()->cur_thang));

    $jb = array('UP__Pertanggungjawaban - SPJ UP',"TU__Pertanggungjawaban - SPJ TU");
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"txtJB","label"=>"Jenis Bukti","placeholder"=>"","default"=>"UP","option"=>$jb)
    );
    $form->addRow($row);
    if($spj->NOSPJ != ''){
      $reg = pjg($spj->NOREG,5);
      $kep = $spj->KETERANGAN;
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPJ","label"=>"Nomer SPJ","placeholder"=>"","readonly"=>"1","value"=>$spj->NOSPJ));
    }else{
      $reg = pjg($noreg,5);
      $kep = "SPJ UP/GU/TU";
      $form->addGroup(array("type"=>"text","id"=>"txtNoSPJ","label"=>"Nomer SPJ","placeholder"=>$webset,"value"=>"","readonly"=>"1"));
    }
    $tglSPJ = substr($spj->TGLSPJ, 0,10);
    $tglBuku = substr($spj->TGLBUKU, 0,10);
    $row = array(
      array("width"=>"6","type"=>"text","id"=>"txtTanggalSPJ","label"=>"Tanggal SPJ","placeholder"=>"","value"=>$tglSPJ),
      array("width"=>"6","type"=>"text","id"=>"txtTanggalBuku","label"=>"Tanggal Buku","readonly"=>"0","value"=>$tglBuku)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"0","placeholder"=>"","value"=>$kep));
    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggalSPJ,#txtTanggalBuku").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  nomer = $("#fmtUP").val();
  $("#txtNoSPJ").val(nomer);

  $("#frmSPJ").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listSPJ","simpanSPJ",$("#frmSPJ").serialize());
    hide_form();
  });
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });

  $("#txtJB").change(function(){
    nomer = $("#fmt"+$(this).val()).val();
    $("#txtNoSPJ").val(nomer);
  });
</script>
