<?php
  $form = new Form_render;
  $tabel = array("tblrekList",array("NO","NAMA BANK","KETERANGAN REKENING","NO REKENING",""));
  $form->addTable($tabel);
  foreach($rek as $h){ ?>
    <tr class=''>
      <td align='center'><?php echo $h->NOBBANTU ?></td>
      <td align='left'><?php echo $h->NMBANK ?></td>
      <td align='left'><?php echo $h->NMBKAS ?></td>
      <td align='center'><?php echo $h->NOREKB ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOBBANTU;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data Pegawai",
          "placeholder"=>$h->NMBKAS."__".$h->NOREKB
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
  $('#tblrekList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 350, "targets": 2 },
      { "width": 130, "targets": 3 },
      { "width": 50, "targets": 4 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": false
  });

  $('#tblrekList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#nobbantu").val(elm);
    $("#txtRek").val(dats[0]);
    closeModal();
  });

</script>
