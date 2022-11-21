<?php
  $form = new Form_render;
  $options = array(
    "__Pilih Bidang Satuan Kerja",
  );
  foreach($bidang as $s){
    $unitkey = str_replace("_","",$s->UNITKEY);
    array_push($options,$s->KDUNIT."__".$s->KDUNIT." ".$s->NMUNIT);
  }
  $row = array(
    array("width"=>"12","type"=>"select","id"=>"kdBidang","label"=>"Bidang Satuan kerja","default"=>"","option"=>$options)
  );
  $form->addRow($row);
  
?>
<div id="listSubUnit" style="height:400px"></div>
<script>
  $("#kdBidang").change(function(){
    post_to_content("listSubUnit","../utama/listSubUnitBend","bidang="+$(this).val())
  })

  $("#listUnit").change(function(){
    $("#listBendahara").html('');
    $("#jnsSPM").val('').prop('disabled',true);
    if($(this).val() != ''){
      $("#jnsSPM").val('').prop('disabled',false);
    }
  })
</script>