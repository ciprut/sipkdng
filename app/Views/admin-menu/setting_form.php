<?
  $form = new Form_render;
?>
<form id='frmOperator' method="POST" action="simpanSetting">
  <?
    $form->addHidden(array("id"=>"id","value"=>$user->id));

    if($user->id != ""){
      $currentLevel = $user->level;
      $lokasi = $user->lokasi;
      $nama = $user->nama;
      $username = $user->username;
      $opdx = $user->opd;
      $pwd = "";
    }
    $form->addGroup(array("type"=>"text","id"=>"txtNama","label"=>"Nama Pengguna","placeholder"=>"Nama Pengguna","value"=>$nama));
    $form->addGroup(array("type"=>"text","id"=>"txtUsername","label"=>"Username (tidak akan disimpan)","placeholder"=>"Username","value"=>$username));
    $form->addGroup(array("type"=>"text","id"=>"txtPassword","label"=>"Password (kosongkan jika tidak ingin mengubah)","placeholder"=>"Password","value"=>$pwd));

    $form->addClear(10);
    $form->addButton(array("id"=>"btnSimpan","icon"=>"save","title"=>"Simpan","color"=>"primary"));
  ?>
</form>
<script>
  $("#btnSimpan").click(function(){
    //post_to_tab("0","simpanPengguna/"+$("#frmOperator").serialize());
    $("#frmOperator")[0].submit();
  });
</script>
