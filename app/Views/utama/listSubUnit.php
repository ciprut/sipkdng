<?php
  $form = new Form_render;
  $form->addClear("10");

  $tabel = array("tblListSubUnit",array("KODE","NAMA UNIT KERJA",""));
  $form->addTable($tabel);
  $idx = 1;
  foreach($unit as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDUNIT ?></td>
      <td align='left'><?php echo $h->NMUNIT ?></td>
      <td align='center'>
        <?php
        $elm = $h->UNITKEY;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data Unit Kerja",
          "placeholder"=>$h->KDUNIT."__".$h->NMUNIT
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
  $('#tblListSubUnit').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":3,
    "columnDefs": [
      { "width": 150, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "fixedColumns": true,
    "bLengthChange" : false,
    "autoWidth" : false
  });
  $('#tblListSubUnit').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#kdUnit").val(elm);
    $("#kdSatker").val(dats[0]);
    $("#namaUnit").val(dats[1]);
    closeModal();
  });

</script>
