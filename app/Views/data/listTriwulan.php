<?php
  $form = new Form_render;

  $tabel = array("tblTriwulan",array("Kode","Keterangan","Awal","Akhir",""));
  $form->addTable($tabel);
  foreach($triwulan as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h['KDPERIODE'] ?></td>
      <td align='left'><?php echo $h['NMPERIODE'] ?></td>
      <td align='center'><?php echo $h['AWAL'] ?></td>
      <td align='center'><?php echo $h['AKHIR'] ?></td>
      <td align='center'>
        <?php
        $elm = $h['KDPERIODE'];
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
      { "width": 180, "targets": 2 },
      { "width": 180, "targets": 3 },
      { "width": 80, "targets": 4 }
    ],
    "fixedColumns": true
  });
</script>
