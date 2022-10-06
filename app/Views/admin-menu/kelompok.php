<?
  $this->extend('templates/layout');
 
  $this->section('content');
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahKelompok","icon"=>"plus","title"=>"Tambah Kelompok Data","color"=>"success"));

  $tabel = array("tblMenuGrup",array("No","Keterangan","Action"));
  $form->addTable($tabel);
  foreach($kelompok as $h){
    echo "<tr>";
      echo "<td>".$h->no_id."</td>";
      echo "<td>".$h->keterangan."</td>";
      echo "<td align='center'>";
      $elm = $h->no_id;
        $btt = array(
          array("id"=>"btnHapusData","icon"=>"trash","elm"=>$elm,"color"=>"danger","title"=>"Hapus"),
          array("id"=>"btnEditData","icon"=>"edit","elm"=>$elm,"color"=>"warning","title"=>"Edit")
        );
        $form->addIconGroup($btt);
      echo "</td>";
    echo "</tr>";
  }
  $form->closeTable($tabel);

?>

<script>
  $('#tblMenuGrup').removeAttr('width').DataTable({
    "columnDefs": [
      { "width": 60, "targets": 0 },
      { "width": 80, "targets": 2 }
    ],
    "fixedColumns": true
  });

  $(".btnEditData").click(function(){
    post_form("formKel/"+$(this).data("elm"),"a=a","Edit Kelompok Data");
  });

  $("#btnTambahKelompok").click(function(){
    //window.location.href = "http://localhost:8090/ci4/public/menu/formgrup/";
    post_form("formKel","a=baru","Kelompok Data");
  });

  $(".btnHapusGrup").click(function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      location.replace("hapusGrup/"+elm);
    });
  });
</script>
<?$this->endSection();?>