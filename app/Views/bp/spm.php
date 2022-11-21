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
  $jenis = array(
    "__Pilih Jenis SPM",
    "up__SPM UP - Uang Persediaan",
    "gu__SPM GU/TU - Ganti/Tambah UP",
    "ls__SPM LS - Belanja LS",
    "pb__SPM LS - Pembiayaan",
    "gj__SPM LS - Gaji, Tunjangan dan TPP",
    "lsmt__SPM LS / Multi Kegiatan"
  );
  $st = array(
    "__Pilih",
    "pengajuan__Pengajuan",
    "verifikasi__Verifikasi"
  );

  $row = array(
    array("width"=>"3","type"=>"select","id"=>"jnsSPM","label"=>"Jenis SPM","default"=>"","option"=>$jenis,"readonly"=>"0"),
  );
  $form->addRow($row);
  ?>
  <div id='divHeaderSpm'></div>
  <div id="listSPP"></div>
<script>
  $("#jnsSPM").change(function(){
    $("#listSPM").html('');
    if($(this).val() == ""){
      $("#divHeaderSpm").html('');
    }else{
      elm = $(this).data("elm");
      post_to_content("divHeaderSpm","jenisSPM","pengajuan=spm&jn="+$("#jnsSPM").val());
    }
  })
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>
<?php $this->endSection(); ?>