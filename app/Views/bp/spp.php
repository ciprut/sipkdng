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

  $row = array(
    array("width"=>"3","type"=>"select","id"=>"jnsSPP","label"=>"Jenis SPP","default"=>"","option"=>$jenis,"readonly"=>"0"),
  );
  $form->addRow($row);
  ?>
  <div id='divHeaderSpp'></div>
  <div id="listSPP"></div>
<script>
  $("#jnsSPP").change(function(){
    $("#listSPP").html('');
    if($(this).val() == ""){
      $("#divHeaderSpp").html('');
    }else{
      elm = $(this).data("elm");
      post_to_content("divHeaderSpp","jenisSPPSPM","pengajuan=spp&jn="+$("#jnsSPP").val());
    }
  })
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>
<?php $this->endSection(); ?>