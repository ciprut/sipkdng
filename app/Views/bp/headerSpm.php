<?php
  $form = new Form_render;
  $st = array(
    "__Pilih",
    "pengajuan__Pengajuan",
    "verifikasi__Verifikasi"
  );
  if(session()->jnsSpm == "up"){
    $form->addTitle('Surat Permintaan Pembayaran (SPM) Uang Persediaan - UP');
    $row = array(
      array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
      array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

      array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
      array("width"=>"10","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
    );
    $form->addRow($row);
  }
  if(session()->jnsSpm == "gu"){
    $form->addTitle('Surat Permintaan Pembayaran (SPM) Ganti Uang Persediaan - GU');
    $row = array(
      array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
      array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

      array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
      array("width"=>"10","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
    );
    $form->addRow($row);
  }
  if(session()->jnsSpm == "ls"){
    $form->addTitle('Surat Permintaan Pembayaran (SPM) Pembayaran Langsung - LS');
    $row = array(
      array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
      array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

      array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
      array("width"=>"10","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
    );
    $form->addRow($row);

    $form->addTitle("Sub Kegiatan");
    $row = array(
      array("width"=>"2","type"=>"text","id"=>"kdSub","label"=>"Kode Sub Kegiatan","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
      array("width"=>"10","type"=>"text","id"=>"namaSub","label"=>"Nama Sub Kegiatan","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini")
    );
    $form->addRow($row);
  }
  $form->addHidden(array("id"=>"kdUnit","value"=>''));
  $form->addHidden(array("id"=>"keybend","value"=>''));
  $form->addHidden(array("id"=>"idSub","value"=>''));

  $form->addClear(10);
  $form->addButton(array("id"=>"btnPengajuan","icon"=>"new-window","title"=>"Pengajuan SPM","color"=>"primary"));
  $form->addButton(array("id"=>"btnVerifikasi","icon"=>"saved","title"=>"Verifikasi SPM","color"=>"primary"));
  
?>
<script>
  $("#kdSatker,#namaUnit").click(function(){
    $("#listSPM").html('');
    $("#nipBend,#namaBend,#kdSatker,#namaUnit,#kdUnit,#keybend,#kdSub,#namaSub,#idSub").val('');
    post_to_modal("../utama/satkerListBend","a=","Data Satuan Kerja");
  })

  $("#nipBend,#namaBend").click(function(){
    $("#listSPM").html('');
    $("#nipBend,#namaBend,#keybend,#st,#kdSub,#namaSub,#idSub").val('');
    if($("#kdUnit").val() != ''){
      post_to_modal("../utama/bendList/B","unitkey="+$("#kdUnit").val(),"Data Bendahara");
    }else{
      alert("Pilih Bidang, Unit");
    }
  });

  $("#btnPengajuan").click(function(){
    $("#listSPM").html('');
    if($("#jnsSPM").val() != ''){
      elm = $(this).data("elm");
//      post_to_content("listSPM","listSPM","idSub="+$("#idSub").val()+"&kdSatker="+$("#kdSatker").val()+"&unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&jn="+$("#jnsSPM").val()+"&st="+$("#st").val());
      post_to_tab("1","listSPM","idSub="+$("#idSub").val()+"&kdSatker="+$("#kdSatker").val()+"&unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&jn="+$("#jnsSPM").val()+"&st="+$("#st").val(),"Rincian SPM");
    }else{
      alert("Pilih Jenis SPM");
      $(this).val("");
    }
  });

  $("#st").change(function(){
    $("#listSPM").html('');
    if($(this).val() == ""){

    }else{
      if($("#jnsSPM").val() != ''){
        elm = $(this).data("elm");
        post_to_content("listSPM","listSPM","unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&jn="+$("#jnsSPM").val()+"&st="+$("#st").val());
      }else{
        alert("Pilih Jenis SPM");
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
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>