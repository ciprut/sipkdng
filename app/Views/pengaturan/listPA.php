<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambah","icon"=>"plus","title"=>"Tambah Pengguna Anggaran","color"=>"primary"));

  $tabel = array("tblPA",array("NIP","NAMA","GOL/PANGKAT","JABATAN",""));
  $form->addTable($tabel);
  foreach($pa as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->NIP ?></td>
      <td align='left'><?php echo $h->NAMA ?></td>
      <td align='left'><?php echo $h->NMGOL." / ".$h->PANGKAT ?></td>
      <td align='left'><?php echo $h->JABATAN ?></td>
      <td align='center'>
        <?php
        $elm = $h->NIP;
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
  $('#tblPA').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 150, "targets": 0 },
      { "width": 180, "targets": 2 },
      { "width": 80, "targets": 4 }
    ],
    "fixedColumns": true
  });

  $("#btnTambah").click(function(){
    post_form("formPA","nip=","Form Pengguna Anggaran");
  });

  $('#tblPA').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_content("listPA","hapusPA","nip="+elm)
    });
  });
  $('#tblPA').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formPA","nip="+elm,"Form Edit Pegawai");
  });

  hide_form();
</script>
