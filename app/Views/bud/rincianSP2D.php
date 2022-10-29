<?php
  $form = new Form_render;
  $form->addTitle("Detil SP2D No ".session()->nosp2d);
  $form->addClear("10");

  $tabel = array("tblSP2DRinci",array("KODE","KD STATUS","URAIAN","JUMLAH"));
  $form->addTable($tabel);
  foreach($rinci as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo$h->MTGKEY ?></td>
      <td align='center'><?php echo $h->NOJETRA ?></td>
      <td align='left'><?php echo $h->NMPER ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  $('#tblSP2DRinci').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 100, "targets": 1 },
      { "width": 150, "targets": 3 }
    ],
    "fixedColumns": true
  });
  
  $("#btnTambahSP2D").click(function(){
    post_form("formSP2D","nospp=","S P P");
  });
/*
  $('#tblSPP').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_tab("1","hapusSPP","nospp="+elm)
    });
  });
  $('#tblSPP').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formSPP","nospp="+elm,"S P P");
  });
  $('#tblSPP').on("click",".rinci",function(){
    elm = $(this).data("elm");
    post_to_tab("2","rincianSPP","nospp="+elm)
  });
*/
</script>
