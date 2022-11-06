<?php
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahBKUBP","icon"=>"plus","title"=>"Tambah BKU","color"=>"primary"));

  getFlashData();

  $tabel = array("tblBKUBP",array("NO","TANGGAL","JENIS BUKTI","NO BUKTI","AFEKTASI","POTONGAN","PAJAK","DIBAYAR","*"));
  $form->addTable($tabel);
  foreach($bkubp as $h){ ?>
    <tr class=''>
      <td align='left'><a class="rinci" data-elm="<?php echo $h->NOBUKTI; ?>" data-placeholder="<?php echo $h->NOBUKTI; ?>"><?php echo $h->NOBKUSKPD." [".trim($h->KDSTATUS)."]" ?></a></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLBKUSKPD) ?></td>
      <td align='center'><?php echo $h->JENIS ?></td>
      <td align='left'><?php echo $h->NOBUKTI ?></td>
      <td align='right'><?php echo number_format($h->AFEKTASI,2) ?></td>
      <td align='right'><?php echo number_format($h->POTONGAN,2) ?></td>
      <td align='right'><?php echo number_format($h->PAJAK,2) ?></td>
      <td align='right'><?php echo number_format($h->DIBAYAR,2) ?></td>
      <td align='center'>
        <?php
        $elm = $h->NOBKUSKPD."__".trim($h->KDSTATUS);

        if($h->TGLVALID == NULL){
          $act = array(
            array("id"=>"ubah","elm"=>$elm,"color"=>"danger","title"=>"Edit BKU BP","placeholder"=>""),
            array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus BKU","placeholder"=>"")
          );
        }else{
          $act = array(
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Pembatalan Validasi BUD","placeholder"=>"")
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
<div id='detilBKUBP'>asd</div>
<script>
  $('#tblBKUBP').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 100, "targets": 1 },
      { "width": 100, "targets": 2 },
      { "width": 250, "targets": 3 },
      { "width": 100, "targets": 4 },
      { "width": 100, "targets": 5 },
      { "width": 100, "targets": 6 },
      { "width": 100, "targets": 7 },
      { "width": 50, "targets": 8 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });

  $('#tblBKUBP').on("click",".hapus",function(){
    elm = "unitkey="+$("#listUnit").val()+"&keybend="+$("#keybend").val()+"&nobkuskpd="+$(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_content("listBKUBP","hapusBKUBP",elm);
    });
  });
  $('#tblBKUBP').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formBKUBP","unitkey="+$("#listUnit").val()+"&keybend="+$("#keybend").val()+"&nobkuskpd="+$(this).data("elm"),"BKU Bendahara Pengeluaran");
  });
  $('#tblBKUBP').on("click",".rinci",function(){
    elm = $(this).data("elm");
    post_to_content("detilBKUBP","rincianBKUBP","nobukti="+elm,$(this).data("placeholder"))
    //post_to_tab("2","rincianSPM","nospp="+elm,$(this).data("placeholder"))
  });
  $('#tblValidasi').on("click",".setuju",function(){
    elm = $(this).data("elm");
    post_form("formSP2DSetuju","nosp2d="+elm,"Persetujuan S P 2 D");
  });
  
  $("#btnTambahBKUBP").click(function(){
    post_form("formBKUBP","nobkuskpd=","BKU Bendahara Pengeluaran");
  });

</script>
