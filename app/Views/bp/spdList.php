<?php
  $form = new Form_render;
  $tabel = array("tblspdList",array("TGL SPD","NO SPD","KETERANGAN",""));
  $form->addTable($tabel);
  foreach($spd as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->TGLSKO ?></td>
      <td align='left'><?php echo $h->NOSKO ?></td>
      <td align='left'><?php echo $h->KETERANGAN ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOSKO;
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
      { "width": 270, "targets": 1 },
      { "width": 50, "targets": 3 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblspdList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    $("#txtDasar").val(elm);
    $("#idxsko").val($(this).data('placeholder'));
    closeModal();
  });

</script>
