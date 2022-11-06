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
  $st = array(
    "__Pilih",
    "pengajuan__Pengajuan",
    "verifikasi__Verifikasi"
  );
/*
  array("width"=>"12","type"=>"select","id"=>"kdBidang","label"=>"Bidang Satuan kerja","default"=>"","option"=>$options),
  array("width"=>"9","type"=>"select","id"=>"listUnit","label"=>"Unit/Sub Unit Satuan kerja","default"=>"","option"=>array("__Pilih Bidang")),
  */
$row = array(
  array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
  array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

  array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
  array("width"=>"5","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1"),

  array("width"=>"3","type"=>"select","id"=>"jnsSPP","label"=>"Jenis SPP","default"=>"","option"=>$jenis,"readonly"=>"0"),
  array("width"=>"2","type"=>"select","id"=>"st","label"=>"Status","default"=>"","option"=>$st,"readonly"=>"0")
  );
  $form->addRow($row);
  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addHidden(array("id"=>"keybend","value"=>''));
  
?>
<div id="listSPP"></div>
<script>
  $("#kdSatker,#namaUnit").click(function(){
    $("#listSPP").html('');
    $("#jnsSPP,#nipBend,#namaBend,#kdSatker,#namaUnit,#kdUnit,#keybend").val('');
    post_to_modal("../utama/satkerList","a=","Data Satuan Kerja");
  })

  $("#nipBend,#namaBend").click(function(){
    $("#listSPP").html('');
    $("#jnsSPP,#nipBend,#namaBend,#keybend,#st").val('');
    if($("#kdUnit").val() != ''){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Pilih Bidang, Unit");
    }
  })

  $("#jnsSPP").change(function(){
    $("#listSPP").html('');
    if($(this).val() != '' && $("#keybend").val() != ''){
      elm = $(this).data("elm");
    }else{
      alert("Pilih Unit Kerja dan Bendahara");
      $(this).val("");
    }
  })
  $("#st").change(function(){
    $("#listSPP").html('');
    if($(this).val() == ""){

    }else{
      if($("#jnsSPP").val() != ''){
        elm = $(this).data("elm");
        post_to_content("listSPP","listSPP","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&jn="+$("#jnsSPP").val()+"&st="+$("#st").val());
      }else{
        alert("Pilih Jenis SPP");
        $(this).val("");
      }
    }
  })
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>
<?php $this->endSection(); ?>