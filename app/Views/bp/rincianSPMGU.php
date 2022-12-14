<?php
  $form = new Form_render;
  $form->addTitle("Detil SPM No ".session()->nospm);
  $form->addClear("10");
  if(session()->jnsSpm != "up"){
    //$form->addButton(array("id"=>"btnTambahSPM","icon"=>"plus","title"=>"Tambah Rincian","color"=>"primary"));
  }

  $tabel = array("tblSPMGiat",array("KODE","URAIAN","JUMLAH"));
  $form->addTable($tabel);
  foreach($rinci as $h){ ?>
    <tr class=''>
      <td align='left'><a class='detilKegiatanGU' data-elm='<?php echo$h->KDKEGUNIT ?>'><?php echo$h->KDPER ?></a></td>
      <td align='left'><?php echo $h->NMPER ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<div id='detilKegiatanGU'></div>
<script>
  $('#tblSPMGiat').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 150, "targets": 2 }
    ],
    "fixedColumns": true
  });

  $('#tblSPMGiat').on("click",".detilKegiatanGU",function(){
    elm = $(this).data("elm");
    post_to_content("detilKegiatanGU","detilKegiatanGU","idSub="+elm)
  });

</script>
