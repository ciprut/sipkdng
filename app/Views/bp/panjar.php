<?php
  $this->extend('templates/layout');
  $this->section('content');

  $form = new Form_render;
  ?>
  <form id='frmBKUBPLookup'>
  <?php
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
    array("width"=>"6","type"=>"select","id"=>"listUnit","label"=>"Unit/Sub Unit Satuan kerja","default"=>"","option"=>array("__Pilih Bidang")),
    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"4","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
  );
  $row = array(
    array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"10","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
  );
  $form->addRow($row);
  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addHidden(array("id"=>"keybend","value"=>''));
  $form->addHidden(array("id"=>"jabBend","value"=>''));
  $form->addClear(10);
  //$form->addButton(array("id"=>"btnLihatPU","icon"=>"search","title"=>"Lihat Data","color"=>"primary"));

?>
</form>
<div id="listPanjar"></div>
<script>
  $("#frmBKUBPLookup").attr("autocomplete","off");

  $("#kdSatker,#namaUnit").click(function(){
    $("#kdSatker,#namaUnit,#nipBend,#namaBend,#keybend,#kdUnit").val("");
    $("#listPanjar").html("");
    post_to_modal("../utama/satkerListBend","a=","Data Satuan Kerja");
  })
  
  $("#nipBend,#namaBend").click(function(){
    $("#nipBend,#namaBend").val('');
    $("#listPanjar").html("");
    if($("#kdUnit").val() != '' && $("#idSub").val() != ''){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Pilih Bidang, Unit dan Sub Kegiatan");
    }
  })
  $("#keybend").keyup(function(){
    post_to_content("listPanjar","listPanjar","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val(),"1");
  });
</script>
<?php $this->endSection(); ?>