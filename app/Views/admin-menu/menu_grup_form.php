<?
  $form = new Form_render;
?>
<form id='frmGrupMenu' method="POST" action='simpanGrup'>
  <?
    $form->addHidden(array("id"=>"id","value"=>$grup->ID_Grup));
    $row = array(
      array("width"=>"3","type"=>"text","id"=>"txtUrut","label"=>"No Urut","placeholder"=>"","value"=>$grup->No_Urut),
      array("width"=>"9","type"=>"text","id"=>"txtGrup","label"=>"Grup Menu","value"=>$grup->Nm_Grup)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"text","id"=>"txtIcon","label"=>"Icon","placeholder"=>"Icon","value"=>$grup->Icon));
    echo "<div style='height:200px;overflow-y:scroll'>";
      echo $this->include('application/fa_list');
    echo "</div>";
    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#btnSimpan").click(function(){
    $("#frmGrupMenu")[0].submit();
  });
</script>
