<?php
  $form = new Form_render;
  $tabel = array("tblBPKList",array("NO","URAIAN","BENDAHARA",""));
  $form->addTable($tabel);
  //var_dump($bpk);die();
  foreach($bpk as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->NOBPK ?></td>
      <td align='left'><?php echo $h->URAIBPK ?></td>
      <td align='left'><?php echo $h->NAMA ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOBPK;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data","placeholder"=>$h->NOBPK)
        );
        $form->addIconGroup($btt);
      ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  
  $('#tblBPKList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 290, "targets": 0 },
      { "width": 150, "targets": 2 },
      { "width": 50, "targets": 3 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblBPKList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    post_to_tab("1","insertBPKSPJ","noBPK="+elm);
    closeModal();
  });

</script>
