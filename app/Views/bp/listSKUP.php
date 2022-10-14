<?php
  $form = new Form_render;
  //$form->addClear("10");
  //$form->addButton(array("id"=>"btnTambahB","icon"=>"plus","title"=>"Tambah Bendahara","color"=>"primary"));

  $tabel = array("tblNSKUP",array("KD UNIT","NAMA UNIT","NILAI",""));
  $form->addTable($tabel);
  foreach($up as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDUNIT ?></td>
      <td align='left'><?php echo $h->NMUNIT ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center'>
        <?php
        $elm = $h->UNITKEY;
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
  $('#tblNSKUP').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 120, "targets": 2 },
      { "width": 50, "targets": 3 }
    ],
    "fixedColumns": true
  });

  $('#tblNSKUP').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_tab("0","listSKUP","hapus="+elm)
    });
  });
  $('#tblNSKUP').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formSKUP","unit="+elm,"SK Uang Persediaan "+elm);
  });

  $("#btnTambahB").click(function(){
    post_form("formBendahara","keybend=","Form Bendahara");
//    post_to_modal("pegawaiList","a=a","Daftar Pegawai");
  });
</script>
