<?
  $form = new Form_render;
?>
<form id='frmSKUP'>
  <?
    $form->addHidden(array("id"=>"form","value"=>session()->unit));
    $form->addGroup(array("type"=>"text","id"=>"txtUnit","label"=>"Unit Kerja","readonly"=>"1","placeholder"=>"","value"=>$up->KDUNIT));
    $form->addGroup(array("type"=>"textarea","id"=>"txtNmUnit","label"=>"Nama Unit Kerja","readonly"=>"1","placeholder"=>"","value"=>$up->NMUNIT));
    $form->addGroup(array("type"=>"text","id"=>"txtNilai","label"=>"Nilai Uang Persediaan","value"=>$up->NILAI));
    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#frmSKUP").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_tab("0","listSKUP",$("#frmSKUP").serialize());
  });

  $("#txtNIP").click(function(){
    //post_to_modal("pegawaiList","a=a","Daftar Pegawai");
  });
</script>
