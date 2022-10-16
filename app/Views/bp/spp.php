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
    "__Pilih Jenis SPP",
    "up__SPP UP - Uang Persediaan",
    "gu__SPP GU/TU - Ganti/Tambah UP",
    "ls__SPP LS - Belanja LS",
    "pb__SPP LS - Pembiayaan",
    "gj__SPP LS - Gaji, Tunjangan dan TPP",
    "lsmt__SPP LS / Multi Kegiatan"
  );

  $row = array(
    array("width"=>"12","type"=>"select","id"=>"kdBidang","label"=>"Bidang Satuan kerja","default"=>"","option"=>$options),
    array("width"=>"9","type"=>"select","id"=>"listUnit","label"=>"Unit/Sub Unit Satuan kerja","default"=>"","option"=>array("__Pilih Bidang")),
    array("width"=>"3","type"=>"select","id"=>"jnsSPP","label"=>"Jenis SPP","default"=>"","option"=>$jenis,"readonly"=>"1")
  );
  $form->addRow($row);
  
?>
<div id="listBendahara"></div>
<script>
  $("#kdBidang").change(function(){
    post_to_content("listUnit","../utama/listUnit","bidang="+$(this).val())
    $("#listBendahara").html('');
    $("#jnsSPP").val('').prop('disabled',true);
  })

  $("#listUnit").change(function(){
    $("#listBendahara").html('');
    $("#jnsSPP").val('').prop('disabled',true);
    if($(this).val() != ''){
      $("#jnsSPP").val('').prop('disabled',false);
    }
  })
  $("#jnsSPP").change(function(){
    $("#listBendahara").html('');
    if($(this).val() != ''){
      post_to_content("listBendahara","listBendahara","unitkey="+$("#listUnit").val()+"&jns="+$("#jnsSPP").val());
    }
  })
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>
<?php $this->endSection(); ?>