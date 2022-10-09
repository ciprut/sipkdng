<?
  $form = new Form_render;

  $gols = array(
    "__Pilih Golongan",
  );
  foreach($golongan as $s){
    array_push($gols,$s->KDGOL."__".$s->NMGOL." - ".strtoupper($s->PANGKAT));
  }
?>
<form id='frmPegawai'>
  <?
    $form->addHidden(array("id"=>"id","value"=>$pegawai->NIP));
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"txtGol","label"=>"Golongan","default"=>$pegawai->KDGOL,"option"=>$gols)
    );
    $form->addRow($row);
    if($pegawai->NIP == ''){
      $form->addGroup(array("type"=>"text","id"=>"txtNIP","label"=>"Nomor Induk Pegawai","placeholder"=>"16 Digit tanpa SPASI","value"=>$pegawai->NIP));
    }else{
      $form->addGroup(array("type"=>"text","id"=>"txtNIP","label"=>"Nomor Induk Pegawai","readonly"=>"1","placeholder"=>"16 Digit tanpa SPASI","value"=>$pegawai->NIP));
    }
    $form->addGroup(array("type"=>"text","id"=>"txtNama","label"=>"Nama Lengkap","value"=>$pegawai->NAMA));
    $form->addGroup(array("type"=>"textarea","id"=>"txtAlamat","label"=>"Alamat Kantor","value"=>$pegawai->ALAMAT));
    $form->addGroup(array("type"=>"text","id"=>"txtJabatan","label"=>"Jabatan","value"=>$pegawai->JABATAN));

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#frmPegawai").attr("autocomplete","off");
  $("#btnSimpan").click(function(){
    post_to_content("listPegawai","simpanPegawai",$("#frmPegawai").serialize());
  });
</script>
