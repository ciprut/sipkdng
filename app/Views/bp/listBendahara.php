<?php
  $form = new Form_render;
  $tabel = array("tblBendahara",array("NIP","NAMA","JENIS BEND","KODE BKU","REKENING",""));
  $form->addTable($tabel);
  foreach($bendahara as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo str_replace(' ','',$h->NIP) ?></td>
      <td align='left'><?php echo $h->NAMA ?></td>
      <td align='left'><?php echo $h->JNS_BEND.". ".$h->URAI_BEND ?></td>
      <td align='center'><?php echo $h->JAB_BEND ?></td>
      <td align='center'><?php echo $h->REKBEND ?></td>
      <td align='center'>
        <?php
        $elm = $h->KEYBEND;

        $btt = array(
          array("id"=>"data".session()->pengajuan,"icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Pilih Bendahara s".$h->KEYBEND,"placeholder"=>$h->NAMA." - ".$h->JAB_BEND)
        );
        $form->addIconGroup($btt);
        ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
  echo "Webset ".session()->webset." Jenis SPP : ".session()->jns;
?>
<script>
  $('#tblBendahara').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 260, "targets": 2 },
      { "width": 100, "targets": 3 },
      { "width": 100, "targets": 4 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true
  });

  $('#tblBendahara').on("click",".dataspp",function(){
    elm = $(this).data("elm");
    post_to_tab("1","listSPP","keybend="+elm,"SPP a.n "+$(this).data('placeholder'));
  });
  $('#tblBendahara').on("click",".dataspm",function(){
    elm = $(this).data("elm");
    post_to_tab("1","listSPM","keybend="+elm,"SPM a.n "+$(this).data('placeholder'));
  });

</script>
