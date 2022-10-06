<?
  $this->extend('templates/layout');
 
  $this->section('content');
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahLevel","icon"=>"plus","title"=>"Tambah Level","color"=>"primary"));
  
  $tabel = array("tblMenuGrup",array("No","Keterangan","ID Level","*","Action"));
  $form->addTable($tabel);
  $nom = 1;
  foreach($level as $h){
    echo "<tr>";
      echo "<td>".$nom."</td>";
      echo "<td><a class='btnEditAkses' href='#' data-elm='".$h->ID_Level."'>".$h->Level."</a></td>";
      echo "<td align='center'>".$h->ID_Level."</td>";

      echo "<td align='center'>";
      $elm = $h->ID_Level;
        $btt = array(
          array("id"=>"btnEditAkses","icon"=>"chevron-right","elm"=>$elm,"color"=>"warning","title"=>"Menu")
        );
        $form->addIconGroup($btt);
      echo "</td>";

      echo "<td align='center'>";
        $btt = array(
          array("id"=>"btnHapusLevel","icon"=>"trash","elm"=>$elm,"color"=>"danger","title"=>"Hapus"),
          array("id"=>"btnUserLevel","icon"=>"pawn","elm"=>$elm,"color"=>"primary","title"=>"User"),
          array("id"=>"btnEditLevel","icon"=>"edit","elm"=>$elm,"color"=>"warning","title"=>"Edit")
        );
        $form->addIconGroup($btt);
      echo "</td>";
    echo "</tr>";
    $nom++;
  }
  $form->closeTable($tabel);
//            array("class"=>"btnEditAkses","elm"=>$elm,"title"=>"Edit Hak Akses","icon"=>"edit")

?>

<script>
  $('#tblMenuGrup').removeAttr('width').DataTable({
    "ordering":false,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 80, "targets": 2 },
      { "width": 50, "targets": 3 },
      { "width": 100, "targets": 4 }
    ],
    "fixedColumns": true
  });

  $(".btnEditLevel").click(function(){
    post_form("levelForm","action=edit&id="+$(this).data("elm"),"Level Menu");
  });

  $("#btnTambahLevel").click(function(){
    post_form("levelForm","action=baru&id=","Level Menu");
  });
  $(".btnUserLevel").click(function(){
    post_to_tab("1","levelUser","id="+$(this).data("elm"),"List User");
  });

  $(".btnEditAkses").click(function(){
    post_to_tab("1","levelAkses","id="+$(this).data("elm"),"Hak Akses Level");
//    window.location.href = "level/akses/"+$(this).data("elm");
  });

  $(".btnHapusLevel").click(function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      location.replace("hapusLevel/"+elm);
    });
  });
</script>
<?$this->endSection();?>