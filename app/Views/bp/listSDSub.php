<?php
  $form = new Form_render;
  $tabel = array("tblSDSubKeg",array("NO","KETERANGAN","SISA",""));
  $form->addTable($tabel);
  foreach($sd as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->KDDANA ?></td>
      <td align='left'><?php echo $h->NMDANA ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->KDDANA;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data","placeholder"=>$h->KDDANA)
        );
        $form->addIconGroup($btt);
      ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblSDSubKeg').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 120, "targets": 2 },
      { "width": 50, "targets": 3 }
    ],
    "fixedColumns": true,
    "bLengthChange" : false,
    "autoWidth" : false
  });

  $('#tblSDSubKeg').on("click",".ambil",function(){
    elm = $(this).data("elm");
    post_to_tab("2","inputSDTBP","kdDana="+elm);
    closeModal();
  });

</script>
