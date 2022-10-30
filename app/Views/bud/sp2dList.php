<?php
  $form = new Form_render;
  $tabel = array("tblsp2dList",array("NO SP2D","TGL VALIDASI","KETERANGAN",""));
  $form->addTable($tabel);
  foreach($sp2d as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->NOSP2D ?></td>
      <td align='center'><?php echo $h->TGLVALID ?></td>
      <td align='left'><?php echo $h->KEPERLUAN ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->IDXTTD;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data Pegawai",
          "placeholder"=>$h->NOSP2D."__".$h->TGLSP2D."__".$h->KEPERLUAN."__".$h->NAMA
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
  $('#tblsp2dList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 250, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 50, "targets": 3 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": false
  });

  $('#tblsp2dList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#idxttd").val(elm);
    $("#txtNoSP2D").val(dats[0]);
    $("#txtTglSP2D").val(dats[1]);
    $("#txtUntuk").val(dats[2]);
    $("#txtTtd").val(dats[3]);
    closeModal();
  });

</script>
