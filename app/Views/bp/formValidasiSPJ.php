<?php
  $form = new Form_render;
?>
<form id='frmSPJValidasi'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$spj->NOSPJ));
    $form->addHidden(array("id"=>"idxsko","value"=>""));
    $reg = pjg($noreg,5);

    $form->addHidden(array("id"=>"fmtUP","value"=>pjg($noreg, 5)."/SPJ/".getKdSKPD($unit->KDUNIT)."/UP/".session()->cur_thang));
    $form->addHidden(array("id"=>"fmtTU","value"=>pjg($noreg, 5)."/SPJ/".getKdSKPD($unit->KDUNIT)."/TU/".session()->cur_thang));

    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal SPJ","readonly"=>"0","value"=>"")
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"text","id"=>"txtNoVal","label"=>"Nomer Validasi SPJ","placeholder"=>"","readonly"=>"0","value"=>$spj->NOSPJ."/SAH"));

    $form->addGroup(array("type"=>"text","id"=>"txtNoSPJ","label"=>"Nomer Validasi","placeholder"=>"","readonly"=>"1","value"=>$spj->NOSPJ));
    $tglSPJ = substr($spj->TGLSPJ, 0,10);
    $tglBuku = substr($spj->TGLBUKU, 0,10);
    $row = array(
      array("width"=>"6","type"=>"text","id"=>"txtTanggalSPJ","label"=>"Tanggal SPJ","readonly"=>"1","value"=>$tglSPJ),
      array("width"=>"6","type"=>"text","id"=>"txtTanggalBuku","label"=>"Tanggal Buku","readonly"=>"1","value"=>$tglBuku)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"1","placeholder"=>"","value"=>$spj->KETERANGAN));
    $form->addClear(10);
    $form->addButton(array("id"=>"btnValidasi","icon"=>"save","title"=>"Simpan Validasi","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});

  $("#frmSPJValidasi").attr("autocomplete","off");
  $("#btnValidasi").click(function(){
    if(cekForm('txtTanggal,txtNoVal')){
      post_to_content("listSPJ","validasiSPJ",$("#frmSPJValidasi").serialize());
      hide_form();
    }
  });
</script>
