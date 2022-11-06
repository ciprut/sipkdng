<?php
  $form = new Form_render;
  $form->addClear("10");

  $tabel = array("tblListSPJSubKeg",array("KODE","URAIAN","JUMLAH",""));
  $form->addTable($tabel);
  $total = 0;
  foreach($sub as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->KDPER ?></td>
      <td align='left'><?php echo $h->NMPER ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center'>
        <?php
        $total += $h->NILAI;
        $form->addIconGroup(
          array(
            array("id"=>'btnDetil',"icon"=>"ok","elm"=>$h->KDKEGUNIT,"placeholder"=>$h->NMPER,"color"=>'success',"title"=>"Detil")
          )
        );
      ?>
      </td>
    </tr>
  <?php
  }
  ?>
  <tr class='bold'><td></td><td align='right'>TOTAL NILAI</td><td align='right'><?php echo number_format($total,2) ?></td><td></td></tr>
  <?php
  $form->closeTable($tabel);
?>
<div id='jdl' class='web-judul' style='margin-top:10px;display:none'></div>
<div id='rincSubKeg'></div>
<script>
  $('#tblListSPJSubKeg').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 120, "targets": 2 },
      { "width": 50, "targets": 3 }
    ],
    "fixedColumns": true,
    "bLengthChange" : false,
    "autoWidth" : false
  });
  $('#tblListSPJSubKeg').on("click",".btnDetil",function(){
    elm = $(this).data("elm");
    $("#jdl").html($(this).data("placeholder")).hide().fadeIn();
    post_to_content("rincSubKeg","detilSPJRekening","idSub="+elm);
  });

</script>
