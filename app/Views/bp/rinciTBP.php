<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahRincianTBP","icon"=>"plus","title"=>"Tambah Rincian","color"=>"primary"));

  getFlashData();

  $tabel = array("tblRinciTBP",array("KODE","NAMA JETRA","NILAI",""));
  $form->addTable($tabel);
  $idx = time();$total = 0;
  foreach($rinci as $h){ ?>
    <?php $idx = $h->MTGKEY ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDPER ?></a></td>
      <td align='left'><?php echo $h->NMPER ?></a></td>
      <td align='right'>
        <span class='awal awal<?php echo $idx ?>'><?php echo number_format($h->NILAI,2) ?></span>
        <input type='text' class='inputAwal inputAwal<?php echo $idx ?>' 
        data-id='<?php echo $idx ?>' 
        value='<?php echo number_format($h->NILAI,2) ?>' 
        style='display:none;padding:0px;text-align:right;width:100%'>
      </td>
      <td align='center'>
        <?php
        $total += $h->NILAI;
        if($h->TGLVALID == NULL){
          $form->addIconGroup(
            array(
              array("id"=>'btnNilai',"icon"=>"pencil","elm"=>$h->MTGKEY,"placeholder"=>myTrim($h->NMPER),"color"=>'success',"title"=>"Nilai")
            )
          );
        }
        ?>
      </td>
    </tr>
  <?php
  } ?>
  <tr class='bold'><td></td><td align="right">TOTAL TBP</td><td align="right"><?php echo number_format($total,2) ?></td><td></td></tr>
  <?php
  $form->closeTable($tabel);
?>
<script>
  $('#tblRinciTBP').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":50,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 150, "targets": 2 },
      { "width": 50, "targets": 3 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });

  $("#btnTambahRincianTBP").click(function(){
    post_to_tab("2",'listSubRinc','idSub='+$("#idSub").val(),'Sub Rincian Obyek');
  });
  $('#tblRinciTBP').on("click",".btnNilai",function(){
    elm = $(this).data("elm");
    post_to_tab("2","listSDTBP","kdper="+elm,$(this).data("placeholder"));
  });

</script>
