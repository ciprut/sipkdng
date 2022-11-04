<?php
  $form = new Form_render;
  $tabel = array("tblBuktiList",array("KODE","NAMA BUKTI KAS",""));
  $form->addTable($tabel);
  foreach($rek as $h){ ?>
    <tr class=''>
      <td align='center'><?php echo $h->KDBUKTI ?></td>
      <td align='left'><?php echo $h->NMBUKTI ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->KDBUKTI;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data Bukti",
          "placeholder"=>$h->KDBUKTI."__".$h->NMBUKTI
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
  $('#tblBuktiList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": false
  });

  $('#tblBuktiList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#txtJenisBukti").val(elm);
    $("#txtKetBukti").val(dats[1]);
    closeModal();
  });

</script>
