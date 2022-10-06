<?
  $form = new Form_render;
?>
<form id='frmOperator' method="POST" action="simpanPengguna">
  <?
    $form->addHidden(array("id"=>"id","value"=>$user->id));

    if($user->id != ""){
      $currentLevel = $user->level;
      $lokasi = $user->lokasi;
      $nama = $user->nama;
      $username = $user->username;
      $opdx = $user->opd;
      $pwd = "";
    }else{
      //$elm = $h->id_unit."__".$h->nama_skpd."__".$h->skpd;      
      $p = explode("__",$params);
      $currentLevel = "2";
      $lokasi = "";
      $nama = $p[2];
      $username = $p[0];
      $opdx = $p[0];
      $pwd = 'batu';
    }
    $form->addGroup(array("type"=>"text","id"=>"txtNama","label"=>"Nama Pengguna","placeholder"=>"Nama Pengguna","value"=>$nama));
    $form->addGroup(array("type"=>"text","id"=>"txtUsername","label"=>"Username","placeholder"=>"Username","value"=>$username));
    $form->addGroup(array("type"=>"text","id"=>"txtPassword","label"=>"Password","placeholder"=>"Password","value"=>$pwd));

    $option = array();
    foreach($level as $h){
      array_push($option,$h->ID_Level."__".$h->Level);
    }
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"selLevel","label"=>"Level ","default"=>$currentLevel,"option"=>$option)
    );
    $form->addRow($row);

    $option = array();
    foreach($opd as $h){
      array_push($option,$h->id_unit."__".$h->nama_skpd);
    }
    $row = array(
      array("width"=>"12","type"=>"select","id"=>"selOPD","label"=>"Satuan Kerja","default"=>$opdx,"option"=>$option)
    );
    $form->addRow($row);
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
