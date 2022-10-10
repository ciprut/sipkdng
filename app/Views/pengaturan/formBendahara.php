<?
  $form = new Form_render;

  $bk = array("__Pilih Bank");
  foreach($bank as $s){
    array_push($bk,$s->KDBANK."__".$s->KDBANK." - ".strtoupper($s->NMBANK));
  }

  $jb = array("__Pilih Bendahara");
  foreach($jbend as $s){
    array_push($jb,$s->JNS_BEND."__".$s->JNS_BEND." - ".strtoupper($s->URAI_BEND));
  }
?>
<form id='frmBendahara'>
  <?
    $form->addHidden(array("id"=>"id","value"=>session()->keybend));
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"txtJBend","label"=>"Jenis Bendahara","default"=>$pegawai->KDGOL,"option"=>$jb)
    );
    $form->addRow($row);

    $row = array(
      array("width"=>"3","type"=>"text","id"=>"txtBKU","label"=>"Jns BKU","placeholder"=>"","value"=>""),
      array("width"=>"9","type"=>"text","id"=>"txtNIP","label"=>"Nomor Induk Pegawai","readonly"=>"readonly","value"=>session()->nip)
    );
    $form->addRow($row);

    $row = array(
      array("width"=>"12","type"=>"select","id"=>"txtBank","label"=>"Bank Bendahara","default"=>$pegawai->KDGOL,"option"=>$bk)
    );
    $form->addRow($row);

    $form->addGroup(array("type"=>"text","id"=>"txtRek","label"=>"No Rekening Bank","value"=>$pegawai->NAMA));
    $form->addGroup(array("type"=>"text","id"=>"txtNPWP","label"=>"NPWP","value"=>$pegawai->ALAMAT));
    $row = array(
      array("width"=>"6","type"=>"text","id"=>"txtSBank","label"=>"Saldo Bank","placeholder"=>"","value"=>"0"),
      array("width"=>"6","type"=>"text","id"=>"txtSTunai","label"=>"Saldo Tunai","value"=>"0")
    );
    $form->addRow($row);

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#frmBendahara").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listBendahara","simpanBendahara",$("#frmBendahara").serialize());
    hide_form();
  });
</script>
