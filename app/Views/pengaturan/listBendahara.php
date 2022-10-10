<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambah","icon"=>"plus","title"=>"Tambah Bendahara","color"=>"primary"));

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

  $('#tblBendahara').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_content("listBendahara","hapusBendahara","keybend="+elm)
    });
  });

  $("#btnTambah").click(function(){
    post_to_modal("pegawaiList","a=a","Daftar Pegawai");
  });
</script>
