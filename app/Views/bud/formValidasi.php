<?php
  $form = new Form_render;
?>
<form id='frmValidasi'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$val->NOBUKAS));
    $form->addHidden(array("id"=>"idxttd","value"=>$idxttd->IDXTTD));
  //var_dump($bantu);
    if($val->NOBUKAS != ''){
      $reg = pjg($val->NOBUKAS,5);
      $kep = $val->KEPERLUAN;
      //$form->addGroup(array("type"=>"text","id"=>"txtNoVal","label"=>"Nomer Validasi BKU","placeholder"=>"","readonly"=>"1","value"=>$reg));
    }else{
      $reg = pjg(($noreg),5);
      $kep = $keperluan;
      //$form->addGroup(array("type"=>"text","id"=>"txtNoVal","label"=>"Nomer Validasi BKU","placeholder"=>$webset,"value"=>$reg,"readonly"=>"1"));
    }
    $tgl = substr($val->TGLKAS, 0,10);
    $row = array(
      array("width"=>"5","type"=>"text","id"=>"txtNoVal","label"=>"Nomer Validasi BKU","placeholder"=>"","value"=>$reg,"readonly"=>"1"),
      array("width"=>"5","type"=>"text","id"=>"txtTanggalVal","label"=>"Tanggal","placeholder"=>"","value"=>$tgl),
      array("width"=>"2","type"=>"text","id"=>"txtBantu","label"=>"Kode","readonly"=>"readonly","value"=>$bantu->NOBBANTU),
    );
    $form->addRow($row);

    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtNoReg","label"=>"Uraian","readonly"=>"readonly","value"=>$bantu->NMBKAS)
    );
    $form->addRow($row);

    //tabel JBKAS
    $row = array(
      array("width"=>"2","type"=>"text","id"=>"txtJenisBukti","label"=>"Bukti","readonly"=>"readonly","value"=>$val->KDBUKTI),
      array("width"=>"10","type"=>"text","id"=>"txtKetBukti","label"=>"Keterangan","readonly"=>"readonly","value"=>$val->NMBUKTI)
    );
    $form->addRow($row);

    //tabel sp2d
    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtNoSP2D","label"=>"No SP2D","readonly"=>"readonly","value"=>$val->NOSP2D),
      array("width"=>"4","type"=>"text","id"=>"txtTglSP2D","label"=>"Tanggal","readonly"=>"readonly","value"=>$val->TGLSP2D),
      array("width"=>"8","type"=>"text","id"=>"txtUntuk","label"=>"Untuk","readonly"=>"readonly","value"=>$val->KEPERLUAN)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"text","id"=>"txtNoBuktiVal","label"=>"Nomer Bukti","placeholder"=>"","readonly"=>"0","value"=>$val->NOBUKTI));
    $form->addGroup(array("type"=>"text","id"=>"txtTtd","label"=>"Nama Penanda Tangan Dok: 04.501","placeholder"=>"","readonly"=>"1","value"=>$idxttd->NIPNAMA));

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#frmValidasi").attr("autocomplete","off");

  $("#txtTanggalVal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm-dd-yy'});
  $("#btnSimpan").click(function(){
    post_to_content("listValidasi","simpanValidasi",$("#frmValidasi").serialize());
    hide_form();
  });
  $("#txtJenisBukti, #txtKetBukti").click(function(){
    if($("#txtTanggalVal").val() == ""){
      alert('Masukkan Tanggal Validasi sebelum memilih Bukti');
    }else{
      post_to_modal("../utama/buktiList","x=","Bukti Validasi SP2D");
    }
  });

  $("#txtNoSP2D, #txtTglSP2D").click(function(){
    if($("#txtTanggalVal").val() == ""){
      alert('Masukkan Tanggal Validasi sebelum memilih SP2D');
    }else{
      post_to_modal("sp2dList","tanggal="+$("#txtTanggalVal").val(),"Data SP2D Yang belum di BKU");
    }
  });

  /*
  $("#txtTtd").click(function(){
    post_to_modal("../utama/listTTD/04.301","x=","Data Pegawai");
  });
*/
</script>
