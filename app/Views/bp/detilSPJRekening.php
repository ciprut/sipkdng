<?php
  $form = new Form_render;
  $form->addClear("10");

  $tabel = array("tblListSubRo",array("KODE","URAIAN","SUMBER DANA","JUMLAH",""));
  $form->addTable($tabel);
  $total = 0;
  foreach($ro as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->KDPER ?></td>
      <td align='left'><?php echo $h->NMPER ?></td>
      <td align='left'><?php echo $h->NMDANA ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center' width='50px'>
        <?php
        $total += $h->NILAI;
        
      ?>
      </td>
    </tr>
  <?php
  }
  ?>
  <tr class='bold'><td></td><td></td><td align='right'>TOTAL NILAI</td><td align='right'><?php echo number_format($total,2) ?></td><td></td></tr>
  <?php
  $form->closeTable($tabel);
?>
<script>
  $('#tblListSubRo').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 220, "targets": 2 },
      { "width": 120, "targets": 3 },
      { "width": 50, "targets": 4 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });



</script>
