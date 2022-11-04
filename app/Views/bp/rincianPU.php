<?php
  $form = new Form_render;
  $form->addClear("10");

  getFlashData();

  $tabel = array("tblRinciPU",array("NAMA JETRA","NILAI",""));
  $form->addTable($tabel);
  $idx = 1;
  foreach($rinci as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->NMJETRA ?></a></td>
      <td align='right'>
        <span class='awal awal<?php echo $idx ?>'><?php echo number_format($h->NILAI,2) ?></span>
        <input type='text' class='inputAwal inputAwal<?php echo $idx ?>' 
        data-id='<?php echo $idx ?>' 
        value='<?php echo number_format($h->NILAI,2) ?>' 
        style='display:none;padding:0px;text-align:right;width:100%'>
      </td>
      <td align='center'>
        <?php
        $form->addIconGroup(
          array(
            array("id"=>'btnEdit',"icon"=>"edit","elm"=>$sk,"placeholder"=>"","color"=>'primary',"title"=>"Edit"),
            array("id"=>'btnCancel',"icon"=>"remove","elm"=>$sk,"placeholder"=>"","color"=>'danger',"title"=>"Cancel"),
            array("id"=>'btnSimpanx btnSimpanx'.$sk,"icon"=>"remove","elm"=>$sk,"placeholder"=>"","color"=>'disabled',"title"=>""),
            array("id"=>'btnSimpan',"icon"=>"ok","elm"=>$sk,"placeholder"=>"","color"=>'success',"title"=>"Simpan")
          )
        );
        ?>
      </td>
      <?php $sk++ ?>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblRinciPU').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 150, "targets": 1 },
      { "width": 90, "targets": 2 }
    ],
    "fixedColumns": true
  });
  $('#tblRinciPU').on("click",".setuju",function(){
    elm = $(this).data("elm");
    post_form("formSPMSetuju","nospm="+elm,"Persetujuan S P M");
  });

  $(".btnCancel").hide();
  $(".btnSimpan").hide();

  $('#tblRinciPU').on("click",".btnEdit",function(){
    $(".btnCancel[data-elm='"+$(this).data('elm')+"']").show();
    $(".btnSimpan[data-elm='"+$(this).data('elm')+"']").show();
    $(this).hide();

    $(".awal").show();
    $(".inputAwal, .btnSimpanx"+$(this).data('elm')).hide();
    $(".awal"+$(this).data('elm')).hide();
    $(".inputAwal"+$(this).data('elm')).show().focus().val();
  });

  $('#tblRinciPU').on("click",".btnCancel",function(){
    $(".btnEdit[data-elm='"+$(this).data('elm')+"']").show();
    $(".btnSimpan[data-elm='"+$(this).data('elm')+"']").hide();
    $(this).hide();
    $(".awal, .btnSimpanx").show();
    $(".inputAwal").hide();
  });

  $('#tblRinciPU').on("click",".cek",function(){
    post_to_tab("3","listCatatanSPM","sdspm="+$(this).data("sd"),"Data Pengajuan SPM");
  });

   $('#tblRinciPU').on("click",".btnSimpan",function(){
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
    $(".awal, .btnSimpanx").show();
    $(".inputAwal").hide();
    post_to_content("tab-1","updateRinciPU","nilai="+nilai);
  });

</script>
