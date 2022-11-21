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

  $row = array(
    array("width"=>"3","type"=>"select","id"=>"jnsSPP","label"=>"Jenis SPP","default"=>"","option"=>$jenis,"readonly"=>"0"),
  );
  $form->addRow($row);
  ?>
  <div id='divJnsSpp'></div>
  <div style='border:1px solid #999;padding:8px;margin-top:5px'>
  <div id='divForm' style='display:none'>
  <?php
  $row = array(
    array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"10","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
  );
  $form->addRow($row);
  ?>
  </div>
  <div id='divFormLS' style='display:none'>
  <?php
  $form->addTitle("Sub Kegiatan");
  $row = array(
    array("width"=>"2","type"=>"text","id"=>"kdSub","label"=>"Kode Sub Kegiatan","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaSub","label"=>"Nama Sub Kegiatan","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini")
  );
  $form->addRow($row);
  ?>
  </div>
  <div id='divFormStatus' style='display:none'>
  <?php
  $row = array(
    array("width"=>"2","type"=>"select","id"=>"st","label"=>"Status","default"=>"","option"=>$st,"readonly"=>"0")
  );
  //$form->addRow($row);

  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addHidden(array("id"=>"keybend","value"=>''));
  $form->addHidden(array("id"=>"idSub","value"=>''));

  $form->addClear(10);
  $form->addButton(array("id"=>"btnPengajuan","icon"=>"new-window","title"=>"Pengajuan SPP","color"=>"primary"));
  $form->addButton(array("id"=>"btnVerifikasi","icon"=>"saved","title"=>"Verifikasi SPP","color"=>"primary"));
  
?>
</div></div>
<div id="listSPP"></div>
<script>
  $("#kdSatker,#namaUnit").click(function(){
    $("#listSPP").html('');
    $("#nipBend,#namaBend,#kdSatker,#namaUnit,#kdUnit,#keybend,#kdSub,#namaSub,#idSub").val('');
    post_to_modal("../utama/satkerListBend","a=","Data Satuan Kerja");
  })

  $("#nipBend,#namaBend").click(function(){
    $("#listSPP").html('');
    $("#nipBend,#namaBend,#keybend,#st,#kdSub,#namaSub,#idSub").val('');
    if($("#kdUnit").val() != ''){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Pilih Bidang, Unit");
    }
  });

  $("#jnsSPPx").change(function(){
    $("#listSPP").html('');
    $("#st").val("");
    if($(this).val() != '' && $("#keybend").val() != ''){
      elm = $(this).data("elm");
    }else{
      alert("Pilih Unit Kerja dan Bendahara");
      $(this).val("");
    }
  });

  $("#btnPengajuan").click(function(){
    $("#listSPP").html('');
    if($("#jnsSPP").val() != ''){
      elm = $(this).data("elm");
      post_to_content("listSPP","listSPP","idSub="+$("#idSub").val()+"&kdSatker="+$("#kdSatker").val()+"&unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&jn="+$("#jnsSPP").val()+"&st="+$("#st").val());
    }else{
      alert("Pilih Jenis SPP");
      $(this).val("");
    }
  });

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
  });
  $("#kdSub,#namaSub").click(function(){
    $("#kdSub,#namaSub,#idSub").val("");
    if($("#kdUnit").val() != ""){
      post_to_modal("../utama/treeViewKeg","kdUnit="+$("#kdUnit").val()+"&kdSatker="+$("#kdSatker").val(),"Data Program / Kegiatan / Sub Kegiatan");
    }else{
      alert("Pilih Unit Kerja");
    }
  })

  $("#jnsSPP").change(function(){
    $("#listSPP").html('');
    $("#divForm, #divFormStatus, #divFormLS").hide();
    $("#nipBend,#namaBend,#kdSatker,#namaUnit,#kdUnit,#keybend,#kdSub,#namaSub,#idSub,#st").val('');
    if($(this).val() == ""){
      $("#divForm, #divFormStatus").fadeOut();
      $("#divJnsSpp").html('');
    }else{
      elm = $(this).data("elm");
      title = 'Pengajuan Surat Permintaan Pembayaran (SPP) - ';
      post_to_content("divJnsSpp","jenisSPPSPM","title="+title+"&pengajuan=spp&jn="+$("#jnsSPP").val());
      $("#divForm, #divFormStatus").fadeIn();
      if($(this).val() == "ls"){
        $("#divFormLS").fadeIn();
      }
    }
  })
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>
<?php $this->endSection(); ?>