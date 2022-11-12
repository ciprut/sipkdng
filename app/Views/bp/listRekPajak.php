<div style='height:400px'>
<?php
  $form = new Form_render;
  $tabel = array("tblRekPajak",array("KODE","URAIAN",""));
  //var_dump($rp);die();
  $form->addTable($tabel);
  foreach($rp as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDPAJAK ?></td>
      <td align='left'><?php echo $h->NMPAJAK ?></td>
      <td align='center'>
        <?php
        $elm = $h->PJKKEY;
        $ph = $h->NOBPK."__".$h->TGLBPK;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data Pegawai","placeholder"=>$ph)
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
  $('#tblRekPajak').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblRekPajak').on("click",".ambil",function(){
    elm = $(this).data("elm");
    post_to_content("detilPajak",'simpanDetilPajak/'+elm,'a=a');
    closeModal();
  });

</script>
