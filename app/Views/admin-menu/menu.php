<?
  $this->extend('templates/layout');
 
  $this->section('content');
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahGrup","icon"=>"plus","title"=>"Tambah Grup","color"=>"success"));

  $tabel = array("tblMenuGrup",array("No","Keterangan","Icon","Sub","Action"));
  $form->addTable($tabel);
  foreach($grup as $h){
    echo "<tr>";
      echo "<td>".$h->No_Urut."</td>";
      echo "<td><a class='nmGrup' href='#' data-elm='".$h->ID_Grup."'>".$h->Nm_Grup."</a></td>";
      echo "<td>".$h->Icon."</td>";
      echo "<td align='center'>".$h->subs."</td>";
      echo "<td align='center'>";
      $elm = $h->ID_Grup;
			if($h->subs == 0){
        $btt = array(
          array("id"=>"btnHapusGrup","icon"=>"trash","elm"=>$elm,"color"=>"danger","title"=>"Hapus"),
          array("id"=>"btnEditGrup","icon"=>"edit","elm"=>$elm,"color"=>"warning","title"=>"Edit")
        );
			}else{
        $btt = array(
          array("id"=>"btnHapusGrupxxxx","icon"=>"trash","elm"=>$elm,"color"=>"disable","title"=>"Hapus"),
          array("id"=>"btnEditGrup","icon"=>"edit","elm"=>$elm,"color"=>"warning","title"=>"Edit")
        );
			}
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
      { "width": 80, "targets": 3 },
      { "width": 80, "targets": 4 }
    ],
    "fixedColumns": true
  });

  $('#tblMenuGrup').on("click",".nmGrup",function(){
    post_to_tab("1","menudetil/"+$(this).data("elm"),"grup="+$(this).data("elm"),"Detil Grup");
  });

  $('#tblMenuGrup').on("click",".btnEditGrup",function(){
    post_form("formgrup/"+$(this).data("elm"),"a=a","Grup Menu");
  });

  $("#btnTambahGrup").click(function(){
    //window.location.href = "http://localhost:8090/ci4/public/menu/formgrup/";
    post_form("formgrup","a=baru","Grup Menu");
  });

  $('#tblMenuGrup').on("click",".btnHapusGrup",function(){
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