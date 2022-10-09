<?php
  $form = new Form_render;

  $tabel = array("tblTriwulan",array("Kode","Keterangan","Nilai",""));
  $form->addTable($tabel);
  foreach($setweb as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDSET ?></td>
      <td align='left'><?php echo $h->VALDESC ?></td>
      <td align='center'><?php echo $h->VALSET ?></td>
      <td align='center'>
        <?php
        $elm = $h->KDPERIODE;
        $act = array(
          array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus","placeholder"=>""),
          array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah","placeholder"=>"")
        );
        $form->addDropdown($act);
        ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblTriwulan').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 60, "targets": 0 },
      { "width": 250, "targets": 2 },
      { "width": 80, "targets": 3 }
    ],
    "fixedColumns": true
  });
</script>
