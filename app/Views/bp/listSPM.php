<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahSPM","icon"=>"plus","title"=>"Tambah SPM","color"=>"primary"));

  $tabel = array("tblSPP",array("NO SPM","TGL SPM","TGL SAH","NO SPP","REG SPM","NILAI",""));
  $form->addTable($tabel);
  foreach($spp as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->NOSPP." ".session()->Idxkode ?></td>
      <td align='left'><?php echo $h->TGSPP ?></td>
      <td align='left'><?php echo $h->TGLVALID ?></td>
      <td align='center'><?php echo $h->NOSKO ?></td>
      <td align='center'><?php echo $h->NOREG ?></td>
      <td align='center'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center'>
        <?php
        $elm = $h->NOSPP;

        $act = array(
          array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah SPP","placeholder"=>""),
          array("id"=>"rinci","elm"=>$elm,"color"=>"primary","title"=>"Rincian SPP","placeholder"=>$h->NOSPP),
          array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Persetujuan SPP","placeholder"=>""),
          array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus SPP","placeholder"=>"")
        );
        $form->addDropdown($act);
        ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
  echo "Webset ".session()->webset." Jenis SPP : ".session()->jns;
?>
<script>
  $('#tblSPP').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 150, "targets": 1 },
      { "width": 150, "targets": 2 },
      { "width": 100, "targets": 3 },
      { "width": 100, "targets": 4 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true
  });
  $("#btnTambahSPP").click(function(){
    post_form("formSPP","nospp=","S P P");
  });

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
    post_to_tab("2","rincianSPP","nospp="+elm,$(this).data("placeholder"))
  });
  $('#tblSPP').on("click",".setuju",function(){
    elm = $(this).data("elm");
    post_form("formSPPSetuju","nospp="+elm,"Persetujuan S P P");
  });

</script>
