<?php
  $form = new Form_render;
  $st = array(
    "__Pilih",
    "pengajuan__Pengajuan",
    "verifikasi__Verifikasi"
  );
  if(session()->jnsSpp == "up"){
    $form->addTitle('Surat Permintaan Pembayaran (SPP) Uang Persediaan - UP');
    $row = array(
      array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
      array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

      array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
      array("width"=>"10","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
    );
    $form->addRow($row);
  }
  if(session()->jnsSpp == "gu"){
    $form->addTitle('Surat Permintaan Pembayaran (SPP) Ganti Uang Persediaan - GU');
    $row = array(
      array("width"=>"2","type"=>"text","id"=>"kdSatker","label"=>"Kode Unit","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),
      array("width"=>"10","type"=>"text","id"=>"namaUnit","label"=>"Nama Unit Kerja","default"=>"","readonly"=>"1","placeholder"=>"Klik Disini"),

      array("width"=>"2","type"=>"text","id"=>"nipBend","label"=>"NIP","default"=>"","readonly"=>"1"),
      array("width"=>"10","type"=>"text","id"=>"namaBend","label"=>"Nama Bendahara","default"=>"","readonly"=>"1")
    );
    $form->addRow($row);
  }
  if(session()->jnsSpp == "ls"){
    $form->addTitle('Surat Permintaan Pembayaran (SPP) Pembayaran Langsung - LS');
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
  $form->addButton(array("id"=>"btnPengajuan","icon"=>"new-window","title"=>"Pengajuan SPP","color"=>"primary"));
  $form->addButton(array("id"=>"btnVerifikasi","icon"=>"saved","title"=>"Verifikasi SPP","color"=>"primary"));
  
?>
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

  $("#btnPengajuan").click(function(){
    $("#listSPP").html('');
    if($("#jnsSPP").val() != ''){
      elm = $(this).data("elm");
//      post_to_content("listSPP","listSPP","idSub="+$("#idSub").val()+"&kdSatker="+$("#kdSatker").val()+"&unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&jn="+$("#jnsSPP").val()+"&st="+$("#st").val());
      post_to_tab("1","listSPP","idSub="+$("#idSub").val()+"&kdSatker="+$("#kdSatker").val()+"&unitkey="+$("#kdUnit").val()+"&keybend="+$("#keybend").val()+"&jn="+$("#jnsSPP").val()+"&st="+$("#st").val(),"Rincian SPP");
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
  //post_to_tab("0","listSKUP","","Data Uang Persediaan");
</script>