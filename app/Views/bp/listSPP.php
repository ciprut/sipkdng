<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahSPP","icon"=>"plus","title"=>"Tambah SPP","color"=>"primary"));
  $form->addHidden(array("id"=>"jns","value"=>strtoupper(session()->jnsSpp)));
  
  getFlashData();

  $tabel = array("tblSPP",array("NO SPP","TGL SPP","TGL SAH","NO SPD","REG SPP","NILAI",""));
  $form->addTable($tabel);
  foreach($spp as $h){ ?>
    <tr class=''>
      <td align='left'><a class='rinci' data-elm='<?php echo $h->NOSPP ?>'><?php echo $h->NOSPP ?></a></td>
      <td align='center'><?php echo ngSQLTanggal($h->TGSPP,"ddmmmyyyy") ?></td>
      <td align='center'><b  class='text-danger'><?php echo ngSQLTanggal($h->TGLVALID,"ddmmmyyyy") ?></b></td>
      <td align='center'><?php echo $h->NOSKO ?></td>
      <td align='center'><?php echo $h->NOREG ?></td>
      <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
      <td align='center'>
        <?php
//            array("id"=>"rinci","elm"=>$elm,"color"=>"primary","title"=>"Rincian SPP","placeholder"=>$h->NOSPP),
        $elm = $h->NOSPP;
        if($h->TGLVALID == ''){
          $act = array(
            array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah SPP","placeholder"=>""),
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Persetujuan SPP","placeholder"=>""),
            array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus SPP","placeholder"=>"")
          );
        }else{
          $act = array(
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Pembatalan SPP","placeholder"=>"")
          );
        }
        if($h->NOSPM == ''){
          $form->addDropdown($act);
        }else{
          echo "*";
        }
        ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);

  //$form->addTabs('Rincian SPP__Rincian SPJ','tabsSPP');
?>
<div id='detilSPP'></div>
<script>
  $('#tblSPP').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 100, "targets": 1 },
      { "width": 100, "targets": 2 },
      { "width": 100, "targets": 4 },
      { "width": 100, "targets": 5 },
      { "width": 50, "targets": 6 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });
  $("#btnTambahSPP").click(function(){
    post_form("formSPP","nospp=","S P P "+$("#jns").val());
  });

  $('#tblSPP').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_content("tab-1","hapusSPP","nospp="+elm)
    });
  });
  $('#tblSPP').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formSPP","nospp="+elm,"S P P");
  });
  $('#tblSPP').on("click",".rinci",function(){
    elm = $(this).data("elm");
    post_to_tab("2","rincianSPP","nospp="+elm,"Rincian SPP No "+elm);
//    $("#tabsSPP").fadeIn();
//    post_to_content("tabsSPP-1","rincianSPP","nospp="+elm,$(this).data("placeholder"));
//    $("#header-tabsSPP-1").click();
  });
  $('#tblSPP').on("click",".setuju",function(){
    elm = $(this).data("elm");
    post_form("formSPPSetuju","nospp="+elm,"Persetujuan S P P");
  });
  $('#tblSPP').on("click",".btnHapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_tab("1","hapusSPP","nospp="+elm,$(this).data("placeholder"));
    });
  });

</script>
