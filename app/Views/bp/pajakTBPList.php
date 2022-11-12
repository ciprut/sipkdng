<?php
  $form = new Form_render;
  $tabel = array("tblspdList",array("TANGGAL","NO BPK","URAIAN",""));
  $form->addTable($tabel);
  foreach($tbp as $h){ ?>
    <tr class=''>
      <td align='center' width='120px'><?php echo ngSQLSRVTGL($h->TGLBPK,103) ?></td>
      <td align='left'><?php echo $h->NOBPK ?></td>
      <td align='left'><?php echo $h->URAIBPK ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOBPK;
        $ph = $h->NOBPK."__". ngSQLSERVERTGL($h->TGLBPK,103);
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data","placeholder"=>$ph)
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
      { "width": 120, "targets": 0 },
      { "width": 250, "targets": 1 },
      { "width": 50, "targets": 3 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblspdList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#txtNoTBP").val(elm);
    $("#txtTglTBP").val(dats[1]);
    closeModal();
  });

</script>
