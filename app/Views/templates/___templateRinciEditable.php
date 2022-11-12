<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahRincianSDTBP","icon"=>"plus","title"=>"Tambah Sumber Dana","color"=>"primary"));

  getFlashData();

  $tabel = array("tblRinciSDTBP",array("KODE","NAMA JETRA","NILAI",""));
  $form->addTable($tabel);
  $idx = time();$total = 0;
  foreach($sd as $h){ ?>
    <?php $idx = $h->KDDANA ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDDANA ?></a></td>
      <td align='left'><?php echo $h->NMDANA ?></a></td>
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
              array("id"=>'btnEdit',"icon"=>"edit","elm"=>$idx,"placeholder"=>"","color"=>'primary',"title"=>"Edit"),
              array("id"=>'btnCancel',"icon"=>"remove","elm"=>$idx,"placeholder"=>"","color"=>'danger',"title"=>"Cancel"),
              array("id"=>'btnHapus btnHapus'.$idx,"icon"=>"trash","elm"=>$idx,"placeholder"=>"","color"=>'danger',"title"=>""),
              array("id"=>'btnSimpan',"icon"=>"ok","elm"=>$idx,"placeholder"=>"","color"=>'success',"title"=>"Simpan")
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
  $('#tblRinciSDTBP').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":50,
    "columnDefs": [
      { "width": 80, "targets": 0 },
      { "width": 150, "targets": 2 },
      { "width": 90, "targets": 3 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });

  $("#btnTambahRincianSDTBP").click(function(){
    post_to_modal('listSDSub','a=','Sub Rincian Obyek');
  });
  $('#tblRinciSDTBP').on("click",".nilai",function(){
    elm = $(this).data("elm");
    post_to_tab("2","listSDBPK","kdper="+elm,$(this).data("placeholder"));
  });

  $(".btnCancel").hide();
  $(".btnSimpan").hide();

  $('#tblRinciSDTBP').on("click",".btnEdit",function(){
    $(".btnCancel[data-elm='"+$(this).data('elm')+"']").show();
    $(".btnSimpan[data-elm='"+$(this).data('elm')+"']").show();
    $(this).hide();

    $(".awal").show();
    $(".inputAwal, .btnHapus"+$(this).data('elm')).hide();
    $(".awal"+$(this).data('elm')).hide();
    $(".inputAwal"+$(this).data('elm')).show().focus().val();
  });

  $('#tblRinciSDTBP').on("click",".btnCancel",function(){
    $(".btnEdit[data-elm='"+$(this).data('elm')+"']").show();
    $(".btnSimpan[data-elm='"+$(this).data('elm')+"']").hide();
    $(this).hide();
    $(".awal, .btnHapus").show();
    $(".inputAwal").hide();
  });

   $('#tblRinciSDTBP').on("click",".btnSimpan",function(){
    $(".btnEdit[data-elm='"+$(this).data('elm')+"']").show();
    $(".btnCancel[data-elm='"+$(this).data('elm')+"']").hide();
    $(".Total"+$(this).data('elm')).html('<marquee>...menyimpan data...</marquee>');

    nilai = $(".inputAwal"+$(this).data('elm')).val();
    nilai = nilai.trim();
    nilai = nilai.split(",").join('');

    spm = $(".spm"+$(this).data('elm')).data('value');
    sisa = $(".inputAwal"+$(this).data('elm')).data('sisa');

    $(this).hide();
    $(this).hide();
    $(".awal, .btnHapus").show();
    $(".inputAwal").hide();
    post_to_tab("2","updateRinciTBP","nilai="+nilai+"&kdDana="+$(this).data('elm'));
  });
  post_to_content("tab-1","rinciTBP","a=a");

</script>
