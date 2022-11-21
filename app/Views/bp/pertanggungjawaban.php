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
    "__Pilih Jenis Pertanggungjawaban/SPJ UP/GU/TU",
    "tbp__TBP - Tanda Bukti Pengeluaran/Tagihan",
    "koreksi__Koreksi Belanja",
    "jkn__J K N"
  );

  $row = array(
    array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
    array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

    array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
    array("width"=>"6","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1"),

    array("width"=>"4","type"=>"select","id"=>"jns","label"=>"Jenis SPJ","default"=>"","option"=>$jenis,"readonly"=>"0")
  );
  $form->addRow($row);
  $form->addHidden(array("id"=>"keybend","value"=>''));
  $form->addHidden(array("id"=>"jabBend","value"=>''));

  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addClear(10);
//  $form->addButton(array("id"=>"btnCariBKUK","icon"=>"search","title"=>"Lihat Data BKU","color"=>"primary"));

?>
</form>
<div id="listSPJ"></div>
<script>
  $("#frmBKUBPLookup").attr("autocomplete","off");
  $("#tglMulai").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#tglSelesai").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});

  $("#kdUnit").val("");
  $("#kdSatker,#namaUnit").click(function(){
    $("#listSPJ").html('');
    $("#nipBend,#namaBend,#jns,#keybend,#jabBend").val('');
    post_to_modal("../utama/satkerListBend","a=","Data Satuan Kerja");
  })

  $("#keybend").keyup(function(){
    post_to_content("listBKUBP","listBKUBP","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val());
  });
  
  $("#nipBend,#namaBend").click(function(){
    $("#listSPJ").html('');
    $("#jns,#nipBend,#namaBend,#keybend,#jabBend").val("");
    if($("#kdUnit").val() != '' ){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val()),"Data Bendahara";
    }else{
      alert("Masukkan Bidang, Unit");
    }
  })
  $("#jns").change(function(){
    $("#listSPJ").html('');
    if($("#keybend").val() != '' && $(this).val() != ''){
      post_to_content("listSPJ","listSPJ","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val());
      $(this).val("");
    }else{
      $(this).val("");
      alert("Pilih Bendahara");
    }
  })
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>
<?php $this->endSection(); ?>