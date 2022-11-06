<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahSPJBPK","icon"=>"plus","title"=>"Tambah Tagihan","color"=>"primary"));

  $tabel = array("tblRinciSPJBPK",array("NO BPK","TANGGAL","URAIAN","NILAI"));
  $form->addTable($tabel);
  $total = 0;
  foreach($bpk as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->NOBPK ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLBPK) ?></td>
      <td align='left'><?php echo $h->URAIBPK ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
        <?php
        $total += $h->NILAI;
      ?>
    </tr>
  <?php
  }
  ?>
  <tr class='bold'><td></td><td></td><td align='right'>TOTAL NILAI BPK</td><td align='right'><?php echo number_format($total,2) ?></td></tr>
  <?php
  $form->closeTable($tabel);
?>

<script>
  $('#tblRinciSPJBPK').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 250, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 120, "targets": 3 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });
  $("#btnTambahSPJBPK").click(function(){
    post_to_modal('BPKList','a=a','Rincian SPJ');
  });

  $('#tblRinciSPJBPK').on("click",".detil",function(){
    elm = $(this).data("elm");
    post_to_content("rincBPK","rinciSPJSubKeg","noBPK="+elm);
  });

</script>
