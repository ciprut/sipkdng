<?php
  $form = new Form_render;

  $tabel = array("tblBulan",array("Kode","Periode","Keterangan",""));
  $form->addTable($tabel);
  foreach($bulan as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->KD_BULAN ?></td>
      <td align='left'><?php echo $h->KDPERIODE ?></td>
      <td align='left'><?php echo $h->KET_BULAN ?></td>
      <td align='center'></td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblBulan').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 80, "targets": 0 },
      { "width": 80, "targets": 1 },
      { "width": 80, "targets": 3 }
    ],
    "fixedColumns": true
  });
</script>
