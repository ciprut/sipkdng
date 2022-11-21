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
  $jb = array(
    "__Pilih Jenis Kegiatan",
    "pemungutan__Pemungutan / Pemotongan Pajak",
    "penyetoran__Penyetoran Pajak"
  );
  $row = array(
    array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"10","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1"),

    array("width"=>"2","type"=>"text","id"=>"kdSub","label"=>"Kode Sub Kegiatan","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaSub","label"=>"Nama Sub Kegiatan","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini")

  );
//  array("width"=>"4","type"=>"select","id"=>"txtJB","label"=>"Jenis Kegiatan","placeholder"=>"","default"=>"pemungutan","option"=>$jb)
  $form->addRow($row);

  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addHidden(array("id"=>"keybend","value"=>''));
  $form->addHidden(array("id"=>"idSub","value"=>''));
  $form->addClear(10);
  //$form->addButton(array("id"=>"btnLihatPU","icon"=>"search","title"=>"Lihat Data","color"=>"primary"));

  $form->addSingleTabs(array('pemungutan__Pemungutan Pajak','penyetoran__Penyetoran Pajak'),'pajakTabs');
?>
</form>
<div id="listPajak"></div>
<script>
  $("#frmBKUBPLookup").attr("autocomplete","off");
  $("#kdUnit").val("");
  $("#kdSatker,#namaUnit").click(function(){
    $("#kdSub,#namaSub,#kdSatker,#namaUnit,#nipBend,#namaBend,#keybend,#kdUnit,#idSub").val("");
    post_to_modal("../utama/satkerList","a=","Data Satuan Kerja");
  })
  $("#kdSub,#namaSub").click(function(){
   // $("#kdSub,#namaSub,#idSub,#nipBend,#namaBend,#keybend").val("");
    $("#kdSub,#namaSub,#idSub").val("");
    if($("#kdUnit").val() != ""){
      post_to_modal("../utama/treeViewKeg","kdUnit="+$("#kdUnit").val()+"&kdSatker="+$("#kdSatker").val(),"Data Program / Kegiatan / Sub Kegiatan");
    }else{
      alert("Pilih Unit Kerja");
    }
  })
  
  $("#nipBend,#namaBend").click(function(){
    $("#nipBend,#namaBend,#tglMulai,#tglSelesai").val('');
    if($("#kdUnit").val() != ''){// && $("#idSub").val() != ''
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Pilih Bidang, Unit dan Sub Kegiatan");
    }
  })
  $("#idSub").keyup(function(){
    $("#pemungutan").click();
    //$("#txtJB").change();
  });

  $("#txtJB").change(function(){
    if($(this).val() == ''){
      $("#listPajak").html("");
    }
    if($(this).val() == 'pemungutan'){
      post_to_content("listPajak","listPajak","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&sub="+$("#idSub").val(),"1");
      $(this).val("");
    }
  });
  $("#pemungutan").click(function(){
    $("#content-pajakTabs").html("...loading...");
    if($("#idSub").val() != ''){
      post_to_content("content-pajakTabs","listPajak","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&sub="+$("#idSub").val(),"1");
    }else{
      $("#content-pajakTabs").html("...lengapi form...");
    }
  });
  $("#penyetoran").click(function(){
    $("#content-pajakTabs").html("...menu belum ada...");
      //post_to_content("content-pajakTabs","listPajak","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&sub="+$("#idSub").val(),"1");
  });
</script>
<?php $this->endSection(); ?>