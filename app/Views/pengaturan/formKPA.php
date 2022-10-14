<?
  $form = new Form_render;
?>
<form id='frmKPA'>
  <?
    $form->addHidden(array("id"=>"id","value"=>session()->nip));
    $form->addGroup(array("type"=>"text","id"=>"txtNIP","label"=>"Nomor Induk Pegawai","readonly"=>"1","placeholder"=>"16 Digit tanpa SPASI","value"=>$pegawai->NIP));
    $form->addGroup(array("type"=>"text","id"=>"txtNama","label"=>"Nama Lengkap","readonly"=>"1","value"=>$pegawai->NAMA));
    $form->addGroup(array("type"=>"text","id"=>"txtJabatan","label"=>"Jabatan","value"=>$pegawai->JABATAN));
    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#frmKPA").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listKPA","simpanKPA",$("#frmKPA").serialize());
  });

  $("#txtNIP").click(function(){
    post_to_modal("pegawaiList","a=a","Daftar Pegawai");
  });
</script>
