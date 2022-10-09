<?php
  $form = new Form_render;

  $tabel = array("tblPegawai",array("NIP","NAMA","GOL/PANGKAT","JABATAN",""));
  $form->addTable($tabel);
  foreach($pegawai as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->NIP ?></td>
      <td align='left'><?php echo $h->NAMA ?></td>
      <td align='left'><?php echo $h->NMGOL."/".$h->PANGKAT ?></td>
      <td align='left'><?php echo $h->JABATAN ?></td>
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
  $('#tblPegawai').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 150, "targets": 0 },
      { "width": 180, "targets": 2 },
      { "width": 80, "targets": 4 }
    ],
    "fixedColumns": true
  });
</script>
