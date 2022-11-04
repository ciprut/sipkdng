<?php
  $form = new Form_render;
  $tabel = array("tblBKUBPList",array("TGL DOKUMEN","NO DOKUMEN","URAIAN","TGL CAIR",""));
  $form->addTable($tabel);
  $tgjb = array(
    'SP2D'=>"01,Tgl. SP2D,10,C,C,X",
    'BPK'=>'01,Tgl. BPK,10,C,C,X',
    'Pajak'=>'01,Tgl. BK Pajak,10,C,C,X',
    'Panjar'=>'01,Tgl. Panjar,10,C,C,X',
    'Bank'=>'01,Tgl. Buku,10,C,C,X'
  );
  $nojb = array(
    'SP2D'=>'02,No. SP2D,30,C,C,X',
    'BPK'=>'02,No. BPK,30,C,C,X',
    'Pajak'=>'02,No. BK Pajak,30,C,C,X',
    'Panjar'=>'02,No. Panjar,30,C,C,X',
    'Bank'=>'02,No. Buku,30,C,C,X'
  );
  foreach($lBKU as $h){ ?>
    <tr class=''>
      <td align='center' width='120px'><?php echo $h[$tgjb[session()->jb]] ?></td>
      <td align='center' width='120px'><?php echo $h[$nojb[session()->jb]] ?></td>
      <td align='left'><?php echo $h ["03,Uraian,50,L,C,X"] ?></td>
      <td align='center'><?php echo $h ["04,Tgl.Cair,10,C,C,X"] ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h[$tgjb[session()->jb]];
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data SPM",
          "placeholder"=>$h[$tgjb[session()->jb]]."__".$h[$nojb[session()->jb]]."__".$h["03,Uraian,50,L,C,X"]
          )
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
  $('#tblBKUBPList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 100, "targets": 0 },
      { "width": 250, "targets": 1 },
      { "width": 100, "targets": 3 },
      { "width": 50, "targets": 4 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": false
  });

  $('#tblBKUBPList').on("click",".ambil",function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#txtNoBukti").val(dats[1]);
    $("#txtTanggalBukti").val(dats[0]);
    $("#txtUntuk").val(dats[2]);
    closeModal();
  });

</script>
