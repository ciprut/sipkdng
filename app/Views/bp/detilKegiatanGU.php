<?php
  $form = new Form_render;
  $form->addTitle("Detil SPM No ".session()->nospm);
  $form->addClear("10");
  if(session()->jnsSpm != "up"){
    //$form->addButton(array("id"=>"btnTambahSPM","icon"=>"plus","title"=>"Tambah Rincian","color"=>"primary"));
  }

  $tabel = array("tblSPMGiatRInci",array("KODE","URAIAN","JUMLAH"));
  $form->addTable($tabel);
  $total = 0;
  foreach($detil as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo$h->KDPER ?></td>
      <td align='left'><?php echo $h->NMPER ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <?php $total += $h->NILAI ?>
    </tr>
  <?php
  }
  ?>
    <tr class='bold'>
      <td align='left'></td>
      <td align='right'>TOTAL</td>
      <td align='right'><?php echo number_format($total,2) ?></td>
    </tr>
  <?php
  $form->closeTable($tabel);
?>
<div id='detilKegiatanGU'></div>
<script>
  $('#tblSPMGiatRInci').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 150, "targets": 2 }
    ],
    "fixedColumns": true
  });

</script>
