<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahPajak","icon"=>"plus","title"=>"Tambah Pajak","color"=>"primary"));

  $tabel = array("tblListPajak",array("NO","TANGGAL PAJAK","TGL BUKU SPJ","NO BPK","URAIAN",""));
  $form->addTable($tabel);
  foreach($pajak as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->NOBKPAJAK ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLBKPAJAK) ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLVALID) ?></td>
      <td align='left'><?php echo $h->NOBPK ?></td>
      <td align='left'><?php echo $h->URAIAN ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOSPJ;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data","placeholder"=>$h->NOSPJ)
        );
        $form->addIconGroup($btt);

        $act = array(
          array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah SPP","placeholder"=>""),
          array("id"=>"rinci","elm"=>$elm,"color"=>"primary","title"=>"Rincian SPP","placeholder"=>""),
          array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus SPP","placeholder"=>"")
        );
        if(session()->jnsSpp != "up"){
          $form->addDropdown($act);
        }
      ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblListPajak').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 250, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 120, "targets": 2 },
      { "width": 250, "targets": 3 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true,
    "bLengthChange" : false,
    "autoWidth" : false
  });

  $('#tblListPajak').on("click",".ambil",function(){
    elm = $(this).data("elm");
    post_to_tab("1","rincSPJBPK","noSPJ="+elm);
  });

</script>
