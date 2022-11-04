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
  $row = array(
    array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

    array("width"=>"2","type"=>"text","id"=>"kdSub","label"=>"Kode Sub Kegiatan","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaSub","label"=>"Nama Sub Kegiatan","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"4","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
  );
  $form->addRow($row);

  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addHidden(array("id"=>"keybend","value"=>''));
  $form->addHidden(array("id"=>"idSub","value"=>''));
  $form->addClear(10);
  //$form->addButton(array("id"=>"btnLihatPU","icon"=>"search","title"=>"Lihat Data","color"=>"primary"));

?>
</form>
<div id="listTBP"></div>
<script>
  $("#frmBKUBPLookup").attr("autocomplete","off");
  $("#kdUnit").val("");
  $("#kdSatker,#namaUnit").click(function(){
    $("#kdSub,#namaSub,#kdSatker,#namaUnit,#nipBend,#namaBend,#keybend,#kdUnit,#idSub").val("");
    post_to_modal("../utama/satkerList","a=","Data Satuan Kerja");
  })
  $("#kdSub,#namaSub").click(function(){
    $("#kdSub,#namaSub,#idSub,#nipBend,#namaBend,#keybend").val("");
    if($("#kdUnit").val() != ""){
      post_to_modal("../utama/treeViewKeg","kdUnit="+$("#kdUnit").val()+"&kdSatker="+$("#kdSatker").val(),"Data Program / Kegiatan / Sub Kegiatan");
    }else{
      alert("Pilih Unit Kerja");
    }
  })
  
  $("#nipBend,#namaBend").click(function(){
    $("#listBKUBP,#nipBend,#namaBend,#tglMulai,#tglSelesai").html('');
    if($("#kdUnit").val() != '' && $("#idSub").val() != ''){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Pilih Bidang, Unit dan Sub Kegiatan");
    }
  })
  $("#keybend").keyup(function(){
    post_to_content("listTBP","listTBP","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&sub="+$("#idSub").val(),"1");
  });
</script>
<?php $this->endSection(); ?>