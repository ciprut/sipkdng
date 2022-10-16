<?php
  $form = new Form_render;
  $form->addClear("10");
  if(session()->jnsSpp != "up"){
    $form->addButton(array("id"=>"btnTambahSPP","icon"=>"plus","title"=>"Tambah SPP","color"=>"primary"));
  }

  $tabel = array("tblSPPRinci",array("NO SPP","KD STATUS","URAIAN","JUMLAH",""));
  $form->addTable($tabel);
  foreach($rinci as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo$h->NOSPP ?></td>
      <td align='center'><?php echo $h->NOJETRA ?></td>
      <td align='left'><?php echo $h->KDPER." ".$h->NMPER ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center'>
        <?php
        $elm = $h->NOSPP;

        $act = array(
          array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah SPP","placeholder"=>""),
          array("id"=>"rinci","elm"=>$elm,"color"=>"primary","title"=>"Rincian SPP","placeholder"=>""),
          array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus SPP","placeholder"=>"")
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
  echo "Webset ".session()->webset." Jenis SPP : ".session()->jns;
?>
<script>
  $('#tblSPPRinci').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 1 },
      { "width": 150, "targets": 3 },
      { "width": 50, "targets": 4 }
    ],
    "fixedColumns": true
  });
  /*
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
    post_to_tab("2","rincianSPP","nospp="+elm)
  });
*/
</script>
