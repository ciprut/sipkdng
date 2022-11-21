<?php
  $form = new Form_render;
  $tabel = array("tblspdList",array("TGL SPP","TGL VALIDASI","NO SPP LS","NO SPD",""));
  $form->addTable($tabel);
  foreach($spp as $h){ ?>
    <tr class=''>
      <td align='center' width='120px'><?php echo ngSQLSERVERTGL($h->TGSPP,101) ?></td>
      <td align='center' width='120px'><?php echo ngSQLSERVERTGL($h->TGLVALID,101) ?></td>
      <td align='left'><?php echo $h->NOSPP ?></td>
      <td align='left'><?php echo $h->NOSKO ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOSPP;
        $ph = $h->TGSPP."__".$h->NOSPP."__".$h->NOSKO."__".$h->TGLSKO."__".$h->URAIAN;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data Pegawai","placeholder"=>$ph)
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
    dats = $(this).data("placeholder").split("__");
    $("#txtTanggalSPP").val(dats[0]);
    $("#txtNoSPP").val(dats[1]);
    $("#txtNoSPD").val(dats[2]);
    $("#txtTanggalSPD").val(dats[3]);
    $("#txtUntuk").val(dats[4]);
    closeModal();
  });

</script>
