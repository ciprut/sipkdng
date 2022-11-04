<?php
  $form = new Form_render;
?>
<form id='frmTBP'>
  <?php
    $form->addHidden(array("id"=>"id","value"=>$tbp->nobpk));
    $form->addHidden(array("id"=>"idxsko","value"=>""));

    //00001/TBP-UP/1.01.0.00.0.00.01/B02/2022
    $form->addHidden(array("id"=>"f1","value"=>$noreg."/TBP-"));
    $form->addHidden(array("id"=>"f2","value"=>"/".getKdSKPD($unit->KDUNIT)."/".$bend->JAB_BEND."/".session()->tahun));
    $ro = ($tbp->NOBPK != "") ? "1":"0";
    $jb = array(
      "UP__Uang Persediaan - UP",
      "TU__Tambah Uang Persediaan - TU"
    );

    if($tbp->nobpk != ""){
      $row = array(
        array("width"=>"5","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","readonly"=>"0","value"=>""),
        array("width"=>"7","type"=>"select","id"=>"txtJB","label"=>"Jenis Bukti","placeholder"=>"","default"=>'33',"readonly"=>"1","option"=>$jb),
        array("width"=>"12","type"=>"text","id"=>"txtNo","label"=>"Nomor Tanda Bukti Pengeluaran","readonly"=>$ro,"value"=>$tbp->NOBPK)
      );
      }else{
      $row = array(
        array("width"=>"5","type"=>"text","id"=>"txtTanggal","label"=>"Tanggal","readonly"=>"0","value"=>ngSQLSRVTGL($tbp->TGLBPK)),
        array("width"=>"7","type"=>"select","id"=>"txtJB","label"=>"Jenis Bukti","placeholder"=>"","default"=>$tbp->KDSTATUS,"readonly"=>"0","option"=>$jb),
        array("width"=>"12","type"=>"text","id"=>"txtNo","label"=>"Nomor Tanda Bukti Pengeluaran","readonly"=>"1","value"=>$noreg."/TBP-UP"."/".getKdSKPD($unit->KDUNIT)."/".$bend->JAB_BEND."/".session()->tahun)
      );
      }
    $form->addRow($row);

    $row = array(
      array("width"=>"4","type"=>"text","id"=>"txtTglB","label"=>"Tanggal","readonly"=>"1","value"=>$tbp->TGLBA),
      array("width"=>"8","type"=>"text","id"=>"txtNoB","label"=>"Nomor Berita Acara","readonly"=>"1","value"=>$tbp->NOBA)
    );
    $form->addRow($row);

    echo "<div id='divSP2D'>";
    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtNoSP2D","label"=>"Nomor SP2D Pengajuan TU","readonly"=>"1","value"=>$tbp->NOSP2D)
    );
    $form->addRow($row);
    echo "</div>";

    $row = array(
      array("width"=>"12","type"=>"text","id"=>"txtPenerima","label"=>"Penerima","readonly"=>$ro,"value"=>$tbp->PENERIMA)
    );
    $form->addRow($row);
    $form->addGroup(array("type"=>"textarea","id"=>"txtUntuk","label"=>"Uraian","readonly"=>"0","placeholder"=>"","value"=>$tbp->URAIBPK));

    $sbr = array(
      "tunai__Kas Tunai",
      "bank__Kas di Bank",
      "panjar__Pengajuan Panjar Kegiatan"
    );
    $s = "bank";
    if($h->STPANJAR == '1'){ $s = 'panjar'; }
    if($h->STTUNAI == '1'){ $s = 'tunai'; }
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"txtSbr","label"=>"Sumber","placeholder"=>"","default"=>$s,"readonly"=>"0","option"=>$sbr)
    );

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#txtTanggal").datepicker({changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'});
  $("#divSP2D").hide();
  $("#frmTBP").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listTBP","simpanTBP",$("#frmTBP").serialize(),true);
    hide_form();
  });

  $("#txtJB").change(function(){
    $("#divSP2D").hide();
    if($(this).val() == 'TU'){
      $("#divSP2D").fadeIn();
    }
    $("#txtNo").val($("#f1").val()+$(this).val()+$("#f2").val());
  });
  $("#txtTanggal").on('blur',function(){
    $("#txtDasar").val("");
  });
</script>
