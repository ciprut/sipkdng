<?
  $this->extend('templates/layout');
  $this->section('content');
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahPengguna","icon"=>"plus","title"=>"Tambah Operator","color"=>"success"));
  
  $tabel = array("tblPengguna",array("No","Keterangan","Satuan Kerja","Username","Password","Level","Action"));
  $form->addTable($tabel);
  foreach($user as $h){
    echo "<tr>";
      echo "<td>".$h->id."</td>";
      echo "<td>".$h->nama."</td>";
      echo "<td>".$h->nama_skpd."</td>";
      echo "<td>".$h->username."</td>";
      echo "<td>".$h->password."</td>";
      echo "<td>".$h->KetLevel."</td>";
      echo "<td align='center'>";
      $elm = $h->id;
        $btt = array(
          array("id"=>"btnHapusPengguna","icon"=>"trash","elm"=>$elm,"color"=>"danger","title"=>"Hapus"),
          array("id"=>"btnSatkerPengguna","icon"=>"list","elm"=>$elm,"color"=>"danger","title"=>"Satuan Kerja"),
          array("id"=>"btnEditPengguna","icon"=>"edit","elm"=>$elm,"color"=>"warning","title"=>"Edit")
        );
        $form->addIconGroup($btt);
      echo "</td>";
    echo "</tr>";
  }
  $form->closeTable($tabel);

?>

<script>
  $('#tblPengguna').removeAttr('width').DataTable({
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 150, "targets": 1 },
      { "width": 100, "targets": 3 },
      { "width": 150, "targets": 4 },
      { "width": 120, "targets": 5 },
      { "width": 120, "targets": 6 }
    ],
    "fixedColumns": true
  });

  $("#tblPengguna").on("click",".btnEditPengguna",function(){
    post_form("formPengguna/"+$(this).data("elm"),"a=a","Operator");
  });
  $("#tblPengguna").on("click",".btnSatkerPengguna",function(){
    post_to_tab("1","listSatker","id="+$(this).data("elm"),"Operator");
  });

  $("#btnTambahPengguna").click(function(){
//    post_form("formPengguna","a=baru","Operator");
    post_to_tab("1","listNewUser","a=baru","Operator Baru");
  });

  $("#tblPengguna").on("click",".btnHapusPengguna",function(){
    elm = $(this).data("elm");
    modal = {
        color:"danger",
        icon:"minus-circle"
      };
      showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
        window.location.href= "hapusPengguna/"+elm;
      });
  });
</script>
<?$this->endSection();?>
