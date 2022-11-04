<?php
  $form = new Form_render;
  $tabel = array("tblbendList",array("NIP","NAMA","JAB BEND","NO REKENING",""));
  $form->addTable($tabel);
  foreach($bend as $h){ ?>
    <tr class=''>
      <td align='center'><?php echo $h->NIP ?></td>
      <td align='left'><?php echo $h->NAMA ?></td>
      <td align='left'><?php echo $h->JAB_BEND ?></td>
      <td align='center'><?php echo $h->REKBEND ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->KEYBEND;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data Bendahara",
          "placeholder"=>$h->NIP."__".$h->NAMA."__".$h->JAB_BEND
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
  $('#tblbendList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 75, "targets": 2 },
      { "width": 130, "targets": 3 },
      { "width": 50, "targets": 4 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": false
  });

  $('#tblbendList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#keybend").val(elm).keyup();
    $("#jabBend").val(dats[2]);
    $("#nipBend").val(dats[0]);
    $("#namaBend").val(dats[1]);
    closeModal();
  });

</script>
