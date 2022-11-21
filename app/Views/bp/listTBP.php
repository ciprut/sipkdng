<?php
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahTBP","icon"=>"plus","title"=>"Tambah Data TBP","color"=>"primary"));

  getFlashData();

  $tabel = array("tblTBP",array("NO","TGL BUKU","TGL BKU","PENERIMA","URAIAN","*"));
  $form->addTable($tabel);
  foreach($tbp as $h){ ?>
    <tr class=''>
      <td align='left'><a class="rinci" data-elm="<?php echo $h->NOBPK; ?>" data-placeholder="<?php echo $h->NOBPK; ?>"><?php echo $h->NOBPK ?></a></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLBPK) ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLVALID) ?></td>
      <td align='center'><?php echo $h->PENERIMA ?></td>
      <td align='left'><?php echo $h->URAIBPK ?></td>
      <td align='center'>
        <?php
        $elm = $h->NOBPK;

        if($h->TGLVALID == NULL){
          $act = array(
            array("id"=>"ubah","elm"=>$elm,"color"=>"danger","title"=>"Edit Data","placeholder"=>""),
            array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus Data","placeholder"=>"")
          );
        }else{
          $act = array(
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Pembatalan Validasi","placeholder"=>"")
          );
        }
        if($h->TGLVALID == NULL){
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
  $('#tblTBP').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 250, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 120, "targets": 2 },
      { "width": 130, "targets": 3 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });

  $("#btnTambahTBP").click(function(){
    if($("#keybend").val() != '' ){
      post_form("formTBP","nobpk=","Tanda Bukti Pengeluaran - TBP");
    }else{
      alert("Pilih Bendahara Pengeluaran");
    }
  });

  $('#tblTBP').on("click",".hapus",function(){
    elm = "nobpk="+$(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_content("listTBP","hapusTBP",elm);
    });
  });
  
  $('#tblTBP').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formTBP","nobpk="+$(this).data("elm"),"Tanda Bukti Pengeluaran - TBP");
  });
  $('#tblTBP').on("click",".rinci",function(){
    elm = $(this).data("elm");
    post_to_tab("1","rinciTBP","nobpk="+elm,"TBP No. <b>"+$(this).data("placeholder")+"</b>");
  });

</script>
