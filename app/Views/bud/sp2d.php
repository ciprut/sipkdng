<?php
  $this->extend('templates/layout');
  $this->section('content');

  $form = new Form_render;
  $form = new Form_render;
  $options = array(
    "__Pilih Bidang Satuan Kerja",
  );
  foreach($satker as $s){
    $unitkey = str_replace("_","",$s->UNITKEY);
    array_push($options,$s->KDUNIT."__".$s->KDUNIT." ".$s->NMUNIT);
  }
  $jenis = array(
    "__Pilih Jenis SP2D",
    "up__SP2D UP - Uang Persediaan",
    "gu__SP2D GU/TU - Ganti/Tambah UP",
    "ls__SP2D LS - Belanja LS",
    "pb__SP2D LS - Pembiayaan",
    "gj__SP2D LS - Gaji, Tunjangan dan TPP",
    "lsmt__SP2D LS / Multi Kegiatan"
  );

  $row = array(
    array("width"=>"12","type"=>"select","id"=>"kdBidang","label"=>"Bidang Satuan kerja","default"=>"","option"=>$options),
    array("width"=>"9","type"=>"select","id"=>"listUnit","label"=>"Unit/Sub Unit Satuan kerja","default"=>"","option"=>array("__Pilih Bidang")),
    array("width"=>"3","type"=>"select","id"=>"jnsSP2D","label"=>"Jenis SP2D","default"=>"","option"=>$jenis,"readonly"=>"1")
);
//  array("width"=>"3","type"=>"select","id"=>"jnsSPP","label"=>"Jenis SPP","default"=>"","option"=>$jenis,"readonly"=>"1")
  $form->addRow($row);
  
?>
<div id="listSP2D"></div>
<script>
  $("#kdBidang").change(function(){
    post_to_content("listUnit","../utama/listUnit","bidang="+$(this).val())
    $("#listSP2D").html('');
    $("#jnsSP2D").val('').prop('disabled',true);
  })

  $("#listUnit").change(function(){
    $("#listSP2D").html('');
    $("#jnsSP2D").val('').prop('disabled',true);
    if($(this).val() != ''){
      $("#jnsSP2D").val('').prop('disabled',false);
    }   
  })
  $("#jnsSP2D").change(function(){
    $("#listSP2D").html('');
    if($(this).val() != ''){
      post_to_content("listSP2D","listSP2D","unitkey="+$("#listUnit").val()+"&jns="+$("#jnsSP2D").val());
    }
  })
</script>
<?php $this->endSection(); ?>