<?php
  $form = new Form_render;
  $form->addTitle("Rincian Dokumen No ".session()->nobukti);
  $form->addClear("10");

  $tabel = array("tblSP2DRinci",array("KODE","URAIAN","JUMLAH"));
  $form->addTable($tabel);
  foreach($rinci as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo$h->MTGKEY ?></td>
      <td align='left'><?php echo $h->NMPER ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblSP2DRinci').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 150, "targets": 2 }
    ],
    "fixedColumns": true
  });
  
  $("#btnTambahSP2D").click(function(){
    post_form("formSP2D","nospp=","S P P");
  });

</script>
