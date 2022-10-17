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
    "__Pilih Jenis SPM",
    "up__SPM UP - Uang Persediaan",
    "gu__SPM GU/TU - Ganti/Tambah UP",
    "ls__SPM LS - Belanja LS",
    "pb__SPM LS - Pembiayaan",
    "gj__SPM LS - Gaji, Tunjangan dan TPP",
    "lsmt__SPM LS / Multi Kegiatan"
  );

  $row = array(
    array("width"=>"12","type"=>"select","id"=>"kdBidang","label"=>"Bidang Satuan kerja","default"=>"","option"=>$options),
    array("width"=>"9","type"=>"select","id"=>"listUnit","label"=>"Unit/Sub Unit Satuan kerja","default"=>"","option"=>array("__Pilih Bidang")),
    array("width"=>"3","type"=>"select","id"=>"jnsSPM","label"=>"Jenis SPM","default"=>"","option"=>$jenis,"readonly"=>"1")
  );
  $form->addRow($row);
  
?>
<div id="listBendahara"></div>
<script>
  $("#kdBidang").change(function(){
    post_to_content("listUnit","../utama/listUnit","bidang="+$(this).val())
    $("#listBendahara").html('');
    $("#jnsSPM").val('').prop('disabled',true);
  })

  $("#listUnit").change(function(){
    $("#listBendahara").html('');
    $("#jnsSPM").val('').prop('disabled',true);
    if($(this).val() != ''){
      $("#jnsSPM").val('').prop('disabled',false);
    }
  })
  $("#jnsSPM").change(function(){
    $("#listBendahara").html('');
    if($(this).val() != ''){
      post_to_content("listBendahara","listBendahara","unitkey="+$("#listUnit").val()+"&jns="+$("#jnsSPM").val());
    }
  })
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>
<?php $this->endSection(); ?>