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
  $row = array(
    array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
  
    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"7","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1"),

    array("width"=>"3","type"=>"select","id"=>"jnsSP2D","label"=>"Jenis SP2D","default"=>"","option"=>$jenis,"readonly"=>"0")
  );
  $form->addRow($row);
  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addHidden(array("id"=>"keybend","value"=>''));
  
?>
<div id="listSP2D"></div>
<script>
  $("#kdSatker,#namaUnit").click(function(){
    $("#listSP2D").html('');
    $("#jnsSP2D,#nipBend,#namaBend,#kdSatker,#namaUnit,#kdUnit,#keybend").val('');
    post_to_modal("../utama/satkerList","a=","Data Satuan Kerja");
  })

  $("#nipBend,#namaBend").click(function(){
    $("#listSP2D").html('');
    $("#jnsSP2D,#nipBend,#namaBend,#keybend").val('');
    if($("#kdUnit").val() != ''){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Pilih Bidang, Unit");
    }
  })
  $("#jnsSP2D").change(function(){
    $("#listSP2D").html('');
    if($(this).val() != '' && $("#keybend").val() != ''){
      post_to_content("listSP2D","listSP2D","jns="+$("#jnsSP2D").val());
    }else{
      alert('Mohon lengkapi form..!');
    }
  })
</script>
<?php $this->endSection(); ?>