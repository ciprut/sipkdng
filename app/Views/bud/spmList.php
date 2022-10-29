<?php
  $form = new Form_render;
  $tabel = array("tblspmList",array("TGL SPM","TGL VALIDASI","NO SPM","NO SPD",""));
  $form->addTable($tabel);
  foreach($spm as $h){ ?>
    <tr class=''>
      <td align='center' width='120px'><?php echo $h->TGLSPM ?></td>
      <td align='center' width='120px'><?php echo $h->TGLVALID ?></td>
      <td align='left'><?php echo $h->NOSPM ?></td>
      <td align='left'><?php echo $h->KETOTOR ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOSPM;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data SPM",
          "placeholder"=>$h->KETOTOR."__".$h->NAMA."__".$h->NOSPM
          )
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
  $('#tblspmList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 100, "targets": 0 },
      { "width": 100, "targets": 1 },
      { "width": 270, "targets": 2 },
      { "width": 50, "targets": 4 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": false
  });

  $('#tblspmList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#txtSPM").val(elm);
    $("#txtSPD").val(dats[0]);
    $("#txtNmBendahara").val(dats[1]);
    closeModal();
  });

</script>
