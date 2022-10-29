<?php
  $form = new Form_render;
  $tabel = array("tblPegawaiList",array("NIP","NAMA PEGAWAI","JABATAN","GOL",""));
  $form->addTable($tabel);
  foreach($pegawai as $h){ ?>
    <tr class=''>
      <td align='center'><?php echo str_replace(" ","",$h->NIP) ?></td>
      <td align='left'><?php echo $h->NAMA." ".$h->IDXTTD ?></td>
      <td align='left'><?php echo $h->JABATAN ?></td>
      <td align='center'><?php echo $h->PANGKAT ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->IDXTTD;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data Pegawai",
          "placeholder"=>$h->NAMA."__".$h->JABATAN
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
  $('#tblPegawaiList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 150, "targets": 0 },
      { "width": 270, "targets": 2 },
      { "width": 130, "targets": 3 },
      { "width": 50, "targets": 4 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": false
  });

  $('#tblPegawaiList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#idxttd").val(elm);
    $("#txtTtd").val(dats[0]);
    closeModal();
  });

</script>
