<?php
  $form = new Form_render;
  $form->addTitle("Detil SPP No ".session()->nospp);
  $form->addClear("10");
  if(session()->jnsSpp != "up"){
    $form->addButton(array("id"=>"btnTambahRinc","icon"=>"plus","title"=>"Tambah Rincian - SPJ","color"=>"primary"));
  }

  $tabel = array("tblSPPRinci",array("NO SPJ","TANGGAL","URAIAN","NILAI",""));
  $form->addTable($tabel);
  foreach($rinci as $h){ ?>
    <tr class=''>
      <?php if(session()->jnsSpp != "up"){ ?>
        <td align='left'><a class='rincSPJ' data-elm="<?php echo$h->NOSPJ ?>"><?php echo$h->NOSPJ ?></a></td>
      <?php } else { ?>
        <td align='left'>*</td>
      <?php } ?>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLSPJ) ?></td>
      <td align='left'><?php echo $h->KDPER." ".$h->KETERANGAN ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center'></td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<div id='rincSPJ'></div>
<script>
  $('#tblSPPRinci').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 250, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 150, "targets": 3 },
      { "width": 50, "targets": 4 }
    ],
    "fixedColumns": true
  });
  
  $("#btnTambahRinc").click(function(){
    post_to_modal("SPJList","a=","S P J");
  });

  $('#tblSPPRinci').on("click",".rincSPJ",function(){
    elm = $(this).data("elm");
    post_to_tab("2","rincianSPJSPP","nospj="+elm);
//    post_to_content("tabsSPP-2","rincianSPJSPP","nospj="+elm);
//    $("#header-tabsSPP-2").click();
  });

</script>
