<?php
  $form = new Form_render;
  $form->addTitle("Detil SPM No ".session()->nospm);
  $form->addClear("10");
  $form->addButton(array("id"=>"btnPotongan","icon"=>"remove-sign","title"=>"Potongan","color"=>"primary"));
  $form->addButton(array("id"=>"btnPajak","icon"=>"usd","title"=>"Pajak","color"=>"primary"));

/*
<a class='detilKegiatanLS' data-elm='<?php echo$h->KDKEGUNIT ?>'>
*/
  $tabel = array("tblSPMGiat",array("KODE","URAIAN","JUMLAH"));
  $form->addTable($tabel);
  foreach($rinci as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo$h->KDPER ?></td>
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

  $("#btnPotongan").click(function(){
    post_to_tab("3","listLsPotongan","a=a","Potongan SPM");
  });

  $("#btnPajak").click(function(){
    post_to_tab("3","listLsPajak","a=a","Potongan Pajak");
  });

  $('#tblSPMGiat').on("click",".detilKegiatanLS",function(){
    elm = $(this).data("elm");
    post_to_content("detilKegiatanGU","detilKegiatanGU","idSub="+elm)
  });

</script>
