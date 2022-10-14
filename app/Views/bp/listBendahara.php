<?php
  $form = new Form_render;
  $tabel = array("tblBendahara",array("NIP","NAMA","JENIS BEND","KODE BKU","REKENING",""));
  $form->addTable($tabel);
  foreach($bendahara as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo str_replace(' ','',$h->NIP) ?></td>
      <td align='left'><?php echo $h->NAMA ?></td>
      <td align='left'><?php echo $h->URAI_BEND ?></td>
      <td align='center'><?php echo $h->JAB_BEND ?></td>
      <td align='center'><?php echo $h->REKBEND ?></td>
      <td align='center'>
        <?php
        $elm = $h->KEYBEND;
        $act = array(
          array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Pilih Bendahara","placeholder"=>"")
        );
//        $form->addDropdown($act);
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Pilih Bendahara","placeholder"=>$h->NAMA." - ".$h->JAB_BEND)
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
  $('#tblBendahara').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 260, "targets": 2 },
      { "width": 100, "targets": 3 },
      { "width": 100, "targets": 4 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true
  });

  $('#tblBendahara').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formBendahara","keybend="+elm,"Form Edit Pegawai");
  });

</script>
