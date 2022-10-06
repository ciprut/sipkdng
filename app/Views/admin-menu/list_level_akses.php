<?
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahAkses","icon"=>"plus","title"=>"Tambah Akses","color"=>"success"));
  $tabel = array("tblPenggunaMenu",array("No","Nama Menu","Action"));
  $form->addTable($tabel);
  $nom = 1;
  $grup = '';
  foreach($akses as $h){
    if($grup != $h->Nm_Grup){
      echo '<tr class="header1"><td></td><td>'.$h->Nm_Grup.'</td><td></td></tr>';
      $grup = $h->Nm_Grup;
      $nom = 1;
    }
    echo "<tr>";
      echo "<td>".$nom."</td>";
      echo "<td>".$h->Nm_Menu."</td>";
      echo "<td align='center'>";
        $elm = $h->Menu;
        $btt = array(
          array("id"=>"btnHapusMenu","icon"=>"trash","elm"=>$elm,"color"=>"danger","title"=>"Hapus")
        );
        $form->addIconGroup($btt);
      echo "</td>";
    echo "</tr>";
    $nom++;
  }
  $form->closeTable($tabel);

?>

<script>
  $('#tblPenggunaMenu').removeAttr('width').DataTable({
    'order':false,
    'paging': false,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "fixedColumns": true
  });

  $("#btnTambahAkses").click(function(){
    post_to_tab("2","listAksesLevel","a=a","List Hak Akses");
    //window.location.href = "listAksesLevel";
  });

  $(".btnHapusMenu").click(function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      //window.location.href = "hapusAksesLevel/"+elm;
      post_to_tab("1","hapusAksesLevel","id="+elm);
    });
  });
</script>
