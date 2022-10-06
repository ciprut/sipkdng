<?
  $form = new Form_render;

  $tabel = array("tblUserSatker",array("No","Kode Satker","Keterangan","*","Jml","Action"));
  $form->addTable($tabel);
  foreach($opd as $h){
    echo "<tr>";
      echo "<td>".$h->id_unit."</td>";
      echo "<td>".kdSatker($h->kode_skpd)."</td>";
      echo "<td>".$h->nama_skpd."</td>";
      echo "<td>".$h->skpd."</td>";
      echo "<td align='center'>".$h->jumlah."</td>";
      echo "<td align='center'>";
      $elm = $h->id_unit."__".$h->nama_skpd."__".$h->skpd;
        $btt = array(
          array("id"=>"btnTambahUser","icon"=>"plus","elm"=>$elm,"color"=>"danger","title"=>"Tambah")
        );
        $form->addIconGroup($btt);
      echo "</td>";
    echo "</tr>";
  }
  $form->closeTable($tabel);
?>

<script>
  $('#tblUserSatker').removeAttr('width').DataTable({
    "pageLength":50,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 150, "targets": 1 },
      { "width": 150, "targets": 3 },
      { "width": 50, "targets": 4 },
      { "width": 100, "targets": 5 }
    ],
    "fixedColumns": true
  });

  $("#tblPenggunaSatker").on("click",".btnHapusSatker",function(){
    post_to_content("tab-1","satkerAdd","st=remove&satker="+$(this).data("elm"));
  });
  $("#tblUserSatker").on("click",".btnTambahUser",function(){
    post_form("formPengguna","a=baru&params="+$(this).data("elm"),"Operator");
  });
</script>
