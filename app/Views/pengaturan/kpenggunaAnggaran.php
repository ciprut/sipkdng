<?php
  $this->extend('templates/layout');
  $this->section('content');

  $form = new Form_render;
  $options = array(
    "__Pilih Bidang Satuan Kerja",
  );
  foreach($satker as $s){
    $unitkey = str_replace("_","",$s->UNITKEY);
    array_push($options,$s->KDUNIT."__".$s->KDUNIT." ".$s->NMUNIT);
  }
  $row = array(
    array("width"=>"12","type"=>"select","id"=>"kdBidang","label"=>"Bidang Satuan kerja","default"=>"","option"=>$options),
    array("width"=>"12","type"=>"select","id"=>"listUnit","label"=>"Unit/Sub Unit Satuan kerja","default"=>"","option"=>array("__Pilih Bidang"))
  );
  $form->addRow($row);
?>
<div id="listKPA"></div>
<script>
  $("#kdBidang").change(function(){
    post_to_content("listUnit","listUnit","bidang="+$(this).val())
    $("#listKPA").html('');
  })

  $("#listUnit").change(function(){
    $("#listPA").html('');
    if($(this).val() != ''){
      post_to_content("listKPA","listKPA","unitkey="+$(this).val())
    }
  })
</script>
<?php $this->endSection(); ?>