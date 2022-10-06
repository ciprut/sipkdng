<?
  $form = new Form_render;
?>
<form id='frmMenuItem' method="POST" action='simpanMenu'>
  <?
  
    $form->addHidden(array("id"=>"id","value"=>$submenu->ID_Menu));
    
    $row = array(
      array("width"=>"3","type"=>"text","id"=>"txtUrut","label"=>"No Urut","placeholder"=>"","value"=>$submenu->No_Urut),
      array("width"=>"9","type"=>"text","id"=>"txtItem","label"=>"Menu Item","value"=>$submenu->Menu)
    );
    $form->addRow($row);
    
    $option = array();
    foreach($grup as $o){
      array_push($option,$o->ID_Grup."__".$o->Nm_Grup);
    }
    $row = array(
    array("width"=>"12","type"=>"select","id"=>"selGrup","label"=>"Grup Menu","default"=>$submenu->ID_Grup,"option"=>$option)
    );
    $form->addRow($row);

    $form->addGroup(array("type"=>"text","id"=>"txtLink","label"=>"Alamat Link","placeholder"=>"Alamat Link","value"=>$submenu->Link));
    $form->addGroup(array("type"=>"text","id"=>"txtIcon","label"=>"Icon","placeholder"=>"Icon","value"=>$submenu->Icon));

    echo "<div style='height:200px;overflow-y:scroll'>";
      echo $this->include('application/fa_list');
    echo "</div>";
    $form->addClear(10);
    
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#btnSimpan").click(function(){
    post_to_tab("1","simpanMenu",$("#frmMenuItem").serialize());
  });
</script>
