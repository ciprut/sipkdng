<?php
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahSDLS","icon"=>"new-window","title"=>"Tambah","color"=>"primary"));

  $tabel = array("tblListSDLS",array("NO","KETERANGAN","SISA",""));
  $form->addTable($tabel);
  foreach($sd as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->KDDANA ?></td>
      <td align='left'><?php echo $h->NMDANA ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->KDDANA;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data","placeholder"=>$h->KDDANA)
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
  $('#tblListSDLS').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 120, "targets": 2 },
      { "width": 50, "targets": 3 }
    ],
    "fixedColumns": true,
    "bLengthChange" : false,
    "autoWidth" : false
  });

  $('#tblListSDLS').on("click",".ambil",function(){
    elm = $(this).data("elm");
    post_to_tab("3","inputSDLS","kdDana="+elm);
    closeModal();
  });

</script>
