<?
  $form = new Form_render;
?>
<form id='frmLevelMenu' method="POST" action="simpanLevel">
  <?
    $form->addHidden(array("id"=>"id","value"=>$level->ID_Level));
    $row = array(
      array("width"=>"2","type"=>"text","id"=>"txtID","label"=>"ID Level","placeholder"=>"","value"=>$level->ID_Level),
      array("width"=>"10","type"=>"text","id"=>"txtLevel","label"=>"Keterangan","value"=>$level->Level)
    );
    $form->addRow($row);

    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#btnSimpan").click(function(){
    $("#frmLevelMenu")[0].submit();
  });
</script>
