<?php
  $form = new Form_render;

  $tabel = array("tblTahap",array("Kode","Keterangan","Nilai",""));
  $form->addTable($tabel);
  foreach($pemda as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->TABLEID ?></td>
      <td align='left'><?php echo $h->NEXTKEYDESC ?></td>
      <td align='center'><?php echo $h->NEXTKEY ?></td>
      <td align='center'></td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblTahap').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 80, "targets": 0 },
      { "width": 80, "targets": 2 }
    ],
    "fixedColumns": true
  });
</script>
