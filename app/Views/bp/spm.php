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
    array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
  
    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"7","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1"),

    array("width"=>"3","type"=>"select","id"=>"jnsSPM","label"=>"Jenis SPM","default"=>"","option"=>$jenis,"readonly"=>"0")
  );
  $form->addRow($row);
  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addHidden(array("id"=>"keybend","value"=>''));
  
?>
<div id="listSPM"></div>
<script>
  $("#kdSatker,#namaUnit").click(function(){
    $("#listSPM").html('');
    $("#jnsSPM,#nipBend,#namaBend,#kdSatker,#namaUnit,#kdUnit,#keybend").val('');
    post_to_modal("../utama/satkerList","a=","Data Satuan Kerja");
  })

  $("#nipBend,#namaBend").click(function(){
    $("#listSPM").html('');
    $("#jnsSPM,#nipBend,#namaBend,#keybend").val('');
    if($("#kdUnit").val() != ''){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Pilih Bidang, Unit");
    }
  })

  $("#jnsSPM").change(function(){
    $("#listBendahara").html('');
    if($(this).val() != ''){
      post_to_content("listSPM","listSPM","unitkey="+$("#kdUnit").val()+"&jns="+$("#jnsSPM").val()+"&keybend="+$("#keybend").val());
    }else{
      $("#listSPM").html('');
    }
  })
</script>
<?php $this->endSection(); ?>