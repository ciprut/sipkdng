<?
  $form = new Form_render;

  $my = array();
  foreach($satker as $h){
    $my[$h->opd] = $h->opd;
  }
  $tabel = array("tblPenggunaSatker",array("No","Keterangan","Username","Action"));
  $form->addTable($tabel);
  foreach($opd as $h){
    echo "<tr>";
      echo "<td>".$h->id_unit."</td>";
      echo "<td>".kdSatker($h->kode_skpd)."</td>";
      echo "<td>".$h->nama_skpd."</td>";
      echo "<td align='center'>";
      $elm = $h->id_unit;
      if($my[$h->id_unit] == $h->id_unit){
        $btt = array(
          array("id"=>"btnHapusSatker","icon"=>"trash","elm"=>$elm,"color"=>"primary","title"=>"Hapus")
        );
        $form->addIconGroup($btt);
      }else{
        $btt = array(
          array("id"=>"btnTambahSatker","icon"=>"plus","elm"=>$elm,"color"=>"danger","title"=>"Tambah")
        );
        $form->addIconGroup($btt);
      }
      echo "</td>";
    echo "</tr>";
  }
  $form->closeTable($tabel);
?>

<script>
  $('#tblPenggunaSatker').removeAttr('width').DataTable({
    "pageLength":50,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 150, "targets": 1 },
      { "width": 100, "targets": 3 }
    ],
    "fixedColumns": true
  });

  $("#tblPenggunaSatker").on("click",".btnHapusSatker",function(){
    post_to_content("tab-1","satkerAdd","st=remove&satker="+$(this).data("elm"));
  });
  $("#tblPenggunaSatker").on("click",".btnTambahSatker",function(){
    $("span", $(this)).removeClass('glyphicon-plus').addClass('glyphicon-refresh');
    post_to_content("tab-1","satkerAdd","st=add&satker="+$(this).data("elm"));
  });
</script>
