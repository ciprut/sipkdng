<?php
  $form = new Form_render;
  $form->addTitle('SPJ NOMOR '.session()->nospj);
  getFlashData();

  $tabel = array("tblRinciSPJSPP",array("KODE","URAIAN","JUMLAH"));
  $form->addTable($tabel);
  $idx = time();$total = 0;
  foreach($rinci as $h){ ?>
    <?php $idx = $h->KDKEGUNIT ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDPER ?></td>
      <td align='left'><?php echo $h->NMPER ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <?php $total += $h->NILAI; ?>
    </tr>
  <?php
  } ?>
  <tr class='bold'><td></td><td align="right">TOTAL</td><td align="right"><?php echo number_format($total,2) ?></td></tr>
  <?php
  $form->closeTable($tabel);
?>
<script>
  $('#tblRinciSPJSPP').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":50,
    "columnDefs": [
      { "width": 80, "targets": 0 },
      { "width": 150, "targets": 2 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });
</script>
