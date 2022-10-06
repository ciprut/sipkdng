<?
  $form = new Form_render;
?>
<form id='frmGrupMenu' method="POST" action='simpanKelompok'>
  <?
    $form->addHidden(array("id"=>"id","value"=>$kelompok->no_id));
    $row = array(
      array("width"=>"3","type"=>"text","id"=>"txtUrut","label"=>"No Urut","placeholder"=>"","value"=>$kelompok->no_id),
      array("width"=>"9","type"=>"text","id"=>"txtGrup","label"=>"Grup Menu","value"=>$kelompok->keterangan)
    );
    $form->addRow($row);
    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#btnSimpan").click(function(){
    $("#frmGrupMenu")[0].submit();
  });
</script>
