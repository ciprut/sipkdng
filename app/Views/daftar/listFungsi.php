<?php
  $form = new Form_render;

  $tabel = array("tblFungsi",array("Kode","Keterangan",""));
  $form->addTable($tabel);
  foreach($fungsi as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h['KDFUNG'] ?></td>
      <td align='left'><?php echo $h['NMFUNG'] ?></td>
      <td align='center'></td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblFungsi').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":20,
    "columnDefs": [
      { "width": 80, "targets": 0 },
      { "width": 80, "targets": 2 }
    ],
    "fixedColumns": true
  });
</script>
