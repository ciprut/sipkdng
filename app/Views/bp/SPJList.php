<div style='height:400px'>
<?php
  $form = new Form_render;
  $tabel = array("tblspjList",array("KODE","URAIAN",""));
  $form->addTable($tabel);
  foreach($spj as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->NOSPJ ?></td>
      <td align='left'><?php echo $h->KETERANGAN ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOSPJ;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data Pegawai","placeholder"=>"")
        );
        $form->addIconGroup($btt);
      ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
</div>
<script>
  $('#tblspjList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 220, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblspjList').on("click",".ambil",function(){
    post_to_content('detilSPP','tambahSPJSPP','nospj='+$(this).data('elm'));
    closeModal();
  });

</script>
