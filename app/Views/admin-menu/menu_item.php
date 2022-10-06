<?
//  include_once "app/assets/php/form_render.php";
//  include_once "app/core/crud.php";
//  include_once "app/class_def.php";
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahItem","icon"=>"plus","title"=>"Tambah Item","color"=>"success"));

  $tabel = array("tblMenuItem",array("No","Keterangan","ID Menu","Icon","Link","Status","Action"));
  $form->addTable($tabel);
  foreach($submenu as $h){
    echo "<tr>";
      echo "<td>".$h["No_Urut"]."</td>";
      echo "<td>".$h["Menu"]."</td>";
      echo "<td>".$h["ID_Menu"]."</td>";
      echo "<td>".$h["Icon"]."</td>";
      echo "<td>".$h["Link"]."</td>";
      echo "<td>".$h["Status"]."</td>";
      echo "<td align='center'>";
      $elm = $h["ID_Menu"];
      $btt = array(
        array("id"=>"btnHapusItem","icon"=>"trash","elm"=>$elm,"color"=>"danger","title"=>"Hapus"),
        array("id"=>"btnEditItem","icon"=>"edit","elm"=>$elm,"color"=>"warning","title"=>"Edit")
      );
      $form->addIconGroup($btt);
      echo "</td>";
    echo "</tr>";
  }
  $form->closeTable($tabel);

?>

<script>
  $('#tblMenuItem').removeAttr('width').DataTable({
    "paging":false,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 50, "targets": 2 },
      { "width": 150, "targets": 3 },
      { "width": 150, "targets": 4 },
      { "width": 100, "targets": 5 },
      { "width": 80, "targets": 6 }
    ],
    "fixedColumns": true
  });

  $("#btnTambahItem").click(function(){
    post_form("frmMenu","a=a","Menu User");
  });

  $(".btnEditItem").click(function(){
    post_form("frmMenu/"+$(this).data("elm"),"a=a","Menu User");
//    post_form("adddetil","a=edit&id="+$(this).data("elm"),"Grup Menu");
  });

  $(".btnHapusItem").click(function(){
    elm = $(this).data("elm");
    modal = {
        color:"danger",
        icon:"minus-circle"
      };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_tab("1","hapusMenu/"+elm,"a=a");
    });
  });
</script>
