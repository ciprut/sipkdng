<?php
  $form = new Form_render;
  $form->AddTitle('Pemungutan Pajak');
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahPajak","icon"=>"plus","title"=>"Tambah Pajak","color"=>"primary"));
  $tabel = array("tblListPajak",array("NO BUKTI PAJAK","TANGGAL PAJAK","TGL BUKU SPJ","NO BPK/TBP","URAIAN",""));
  $form->addTable($tabel);
  foreach($pajak as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><a class='detil' data-elm="<?php echo $h->NOBKPAJAK ?>"  data-placeholder="<?php echo $h->TGLVALID ?>"><?php echo $h->NOBKPAJAK ?></a></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLBKPAJAK) ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLVALID) ?></td>
      <td align='left'><?php echo $h->NOBPK ?></td>
      <td align='left'><?php echo $h->URAIAN ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOBKPAJAK;
        $act = array(
          array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah Pajak","placeholder"=>""),
          array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus Pajak","placeholder"=>"")
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
<div id='detilPajak'></div>
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
  $("#btnTambahPajak").click(function(){
    post_form("formPajak","nobkpajak=","PAJAK");
  });

  $('#tblListPajak').on("click",".detil",function(){
    elm = $(this).data("elm");
    post_to_content("detilPajak",'detilPajak','nobkpajak='+elm);
  });

</script>
