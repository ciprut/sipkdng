<?
  $form = new Form_render;
  //echo "<div style='height:400px;overflow-y:scroll'>";
  $tabel = array("tblDetilPaket",array("No","Nama Paket","Pagu","Pemilihan","Sumber Dana"));
  $form->addTable($tabel);
  $nom = 1;
  foreach($paket as $h){
    echo "<tr>
    <td align='center'>".pjg($nom,3)."</td>
    <td>".$h->paket."</td>
    <td align='right'>".number_format($h->pagu)."</td>
    <td align='center'>".$h->pemilihan."</td>
    <td align='center'>".$h->sumber."</td>
    ";
    echo "</tr>";
    $nom++;
  }
  $form->closeTable($tabel);   
      echo "<div style='padding:10px;border:1px solid #b71c1c;color:#333333;font-size:10px;line-height:20px'><b>DISCLAIMER :</b>
      <br>Data RUP sepenuhnya diambil dari situs <a href='https://sirup.lkpp.go.id'>sirup.lkpp.go.id</a> secara berkala. Jika ada perubahan data, maka harus diupdate/diimport ulang.</div>";
  //echo "</div>";
?>

<script>

  $('#tblDetilPaket').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 100, "targets": 2 },
      { "width": 130, "targets": 3 },
      { "width": 100, "targets": 4 }
    ],
    "fixedColumns": true
  });

</script>

