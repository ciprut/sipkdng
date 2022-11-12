<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahSPJ","icon"=>"plus","title"=>"Tambah SPJ","color"=>"primary"));

  $tabel = array("tblListSPJ",array("NO","TANGGAL","NOMOR SAH","TGL SAH","KETERANGAN",""));
  $form->addTable($tabel);
  foreach($spj as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><?php echo $h->NOSPJ ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLSPJ) ?></td>
      <td align='left'><?php echo $h->NOSAH ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLSAH) ?></td>
      <td align='left'><?php echo $h->KETERANGAN ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOSPJ;
        $btt = array(
          array("id"=>"detil","icon"=>"ok","elm"=>$elm,"color"=>"primary","title"=>"Detil","placeholder"=>$h->NOSPJ)
        );
        //$form->addIconGroup($btt);
        $act = array(
          array("id"=>"detil","elm"=>$elm,"color"=>"primary","title"=>"Detil Tagihan","placeholder"=>$h->NOSPJ),
          array("id"=>"subkeg","elm"=>$elm,"color"=>"primary","title"=>"Detil Sub Kegiatan","placeholder"=>$h->NOSPJ)
        );
        if($h->NOSAH == ''){
          array_push($act,array("id"=>"validasi","elm"=>$elm,"color"=>"primary","title"=>"Validasi SPJ","placeholder"=>$h->NOSPJ));
        }
        $form->addDropdown($act);
      ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblListSPJ').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 220, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 220, "targets": 2 },
      { "width": 120, "targets": 3 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true,
    "bLengthChange" : false,
    "autoWidth" : false
  });
  $("#btnTambahSPJ").click(function(){
    post_form("formSPJ","noSPJ=","Surat Pertanggungjawaban - SPJ");
  });

  $('#tblListSPJ').on("click",".detil",function(){
    elm = $(this).data("elm");
    post_to_tab("1","rincSPJBPK","noSPJ="+elm," Data Tagihan "+$(this).data("placeholder"));
  });
  $('#tblListSPJ').on("click",".subkeg",function(){
    elm = $(this).data("elm");
    post_to_tab("1","rinciSPJSubKeg","noSPJ="+elm," Data Sub Kegiatan "+$(this).data("placeholder"));
  });
  $('#tblListSPJ').on("click",".validasi",function(){
    elm = $(this).data("elm");
    post_form("formValidasiSPJ","noSPJ="+elm," Validasi SPJ");
  });

</script>
