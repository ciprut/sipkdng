<?php
  $form = new Form_render;
  $tabel = array("tblPegawaiList",array("NIP","NAMA","JABATAN",""));
  $form->addTable($tabel);
  foreach($pegawai as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo str_replace(" ",'',$h->NIP) ?></td>
      <td align='left'><?php echo $h->NAMA ?></td>
      <td align='left'><?php echo $h->JABATAN ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NIP;
        $act = array(
          array("id"=>"ambil","elm"=>$elm,"color"=>"primary","title"=>"Ambil Data Pegawai","placeholder"=>"")
        );
       // $form->addDropdown($act);
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data Pegawai")
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
  $('#tblPegawaiList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 250, "targets": 2 },
      { "width": 50, "targets": 3 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblPegawaiList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    closeModal();
    post_form("formBendahara","nip="+elm,"Form Edit Pegawai");
  });

</script>
