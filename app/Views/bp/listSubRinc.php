<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnAmbilRincianTBP","icon"=>"check","title"=>"Ambil Rincian Obyek","color"=>"primary"));

  $tabel = array("tblRinciSubKeg",array("KODE","URAIAN",""));
  $form->addTable($tabel);
  $idx = time();$total = 0;
  foreach($sro as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDPER ?></a></td>
      <td align='left'><?php echo $h->NMPER ?></a></td>
      <td align='center'>
        <?php
        $elm = trim($h->MTGKEY);
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data",
          "placeholder"=>$h->KDPER."__".$h->NMPER
          )
        );
        //$form->addIconGroup($btt);
        $form->addCheckbox(array("id"=>"tambah","elm"=>$elm));
        ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  ro = new Array();
  $('#tblRinciSubKeg').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "fixedColumns": true
  });

  $('#tblRinciSubKeg').on("click",".ambil",function(){
    elm = $(this).data("elm");
    post_to_tab("1","tambahRO","mtgkey="+elm);
  });

  $('#tblRinciSubKeg').on("click",".tambah",function(){
    if($(this).prop("checked") == true){
      ro.push($(this).data('elm'));
    }else{
      ro.pop($(this).data('elm'));
    }
  })

  $("#btnAmbilRincianTBP").click(function(){
    if(ro.length > 0){
      post_to_tab("1","tambahRO","mtgkey="+ro);
    }else{
      alert('Anda belum memilih Sub Rincian Obyek..!');
    }
  })

</script>
