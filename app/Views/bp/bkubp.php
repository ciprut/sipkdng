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
    array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

    array("width"=>"2","type"=>"text","id"=>"tglMulai","label"=>"Mulai","default"=>"","readonly"=>"0"),
    array("width"=>"2","type"=>"text","id"=>"tglSelesai","label"=>"Sampai","default"=>"","readonly"=>"0"),

    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"6","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
  );
  $form->addRow($row);
  $form->addHidden(array("id"=>"keybend","value"=>''));
  $form->addHidden(array("id"=>"jabBend","value"=>''));

  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addClear(10);
//  $form->addButton(array("id"=>"btnCariBKUK","icon"=>"search","title"=>"Lihat Data BKU","color"=>"primary"));

?>
</form>
<div id="listBKUBP"></div>
<script>
  $("#frmBKUBPLookup").attr("autocomplete","off");
  $("#tglMulai").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#tglSelesai").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});

  $("#kdUnit").val("");
  $("#kdSatker,#namaUnit").click(function(){
    $("#listBKUBP").html('');
    $("#nipBend,#namaBend,#tglMulai,#tglSelesai,#keybend,#jabBend").val('');
    post_to_modal("../utama/satkerListBend","a=","Data Satuan Kerja");
  })

  $("#keybend").keyup(function(){
    post_to_content("listBKUBP","listBKUBP","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val());
  });
  
  $("#nipBend,#namaBend").click(function(){
    $("#listBKUBP,#nipBend,#namaBend,#tglMulai,#tglSelesai").html('');
    if($("#listUnit").val() != '' ){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Masukkan Bidang, Unit");
    }
  })
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>
<?php $this->endSection(); ?>