<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahPanjar","icon"=>"plus","title"=>"Tambah Data Panjar","color"=>"primary"));

  $tabel = array("tblListPanjar",array("NO","TANGGAL","TGL BKU","STATUS","KETERANGAN",""));
  $form->addTable($tabel);
  foreach($panjar as $h){ ?>
    <tr class=''>
      <td align='left' width='120px'><a class="detil" data-elm="<?php echo $h->NOPANJAR ?>"><?php echo $h->NOPANJAR ?></a></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLPANJAR) ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLVALID) ?></td>
      <td align='left'><?php echo $h->URAISTATUS ?></td>
      <td align='left'><?php echo $h->URAIAN ?></td>
      <td align='center' width='50px'>
        <?php
        $elm = $h->NOPANJAR;
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning","title"=>"Ambil Data","placeholder"=>$h->NOPANJAR)
        );

        $act = array(
          array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah Panjar","placeholder"=>""),
          array("id"=>"rinci","elm"=>$elm,"color"=>"primary","title"=>"Rincian Panjar","placeholder"=>""),
          array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus Panjar","placeholder"=>"")
        );
        if(session()->jnsSpp != "up"){
          $form->addDropdown($act);
        }
      ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblListPanjar').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 320, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 120, "targets": 2 },
      { "width": 150, "targets": 3 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true,
    "bLengthChange" : false,
    "autoWidth" : false
  });
  $("#btnTambahPanjar").click(function(){
    post_form("formPanjar","nopanjar=","P A N J A R");
  })
  $('#tblListPanjar').on("click",".detil",function(){
    elm = $(this).data("elm");
    post_to_tab("1","rinciPanjar","nopanjar="+elm,elm);
  });
  $('#tblListPanjar').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_content("listPanjar","hapusPanjar","nopanjar="+elm)
    });
  });

</script>
