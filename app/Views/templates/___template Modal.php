<?php
  $form = new Form_render;
  $tabel = array("tblspdList",array("TGL SPP","TGL VALIDASI","NO SPP","NO SPD",""));
  $form->addTable($tabel);
  foreach($spp as $h){ ?>
    <tr class=''>
      <td align='center' width='120px'><?php echo $h->TGSPP ?></td>
      <td align='center' width='120px'><?php echo $h->TGLVALID ?></td>
      <td align='left'><?php echo $h->NOSPP ?></td>
      <td align='left'><?php echo $h->NOSKO ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOSPP;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data Pegawai","placeholder"=>$h->IDXSKO)
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
  $('#tblspdList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 20, "targets": 0 },
      { "width": 20, "targets": 1 },
      { "width": 270, "targets": 2 },
      { "width": 50, "targets": 4 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblspdList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    $("#txtDasar").val(elm);
    closeModal();
  });

</script>
