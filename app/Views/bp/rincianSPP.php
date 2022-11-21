<?php
  $form = new Form_render;
  $form->addTitle("Detil SPP No ".session()->nospp);
  $form->addClear("10");
  if(session()->jnsSpp == "gu"){
    $form->addButton(array("id"=>"btnTambahRincGU","icon"=>"plus","title"=>"Tambah SPJ","color"=>"primary"));
  }
  if(session()->jnsSpp == "ls"){
    $form->addButton(array("id"=>"btnTambahRincLS","icon"=>"plus","title"=>"Tambah Rekening LS","color"=>"primary"));
    $form->addButton(array("id"=>"btnHapusRincLS","icon"=>"trash","title"=>"Hapus","color"=>"danger"));
  }

  getFlashData();

  $total = 0;
  if(session()->jnsSpp == "ls"){
    $tabel = array("tblSPPLSRinci",array("KODE","URAIAN","NILAI",""));
    $form->addTable($tabel);
    foreach($rinci as $h){ ?>
      <tr class=''>
        <td align='center'><a class='rinciSDLS' data-elm="<?php echo $h->MTGKEY ?>" data-placeholder="<?php echo$h->NMPER ?>"><?php echo $h->KDPER ?></a></td>
        <td align='left'><?php echo $h->NMPER ?></td>
        <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
        <td align='center'>
          <?php
          $elm = trim($h->MTGKEY);
          if($h->NILAI < 1){
            $btt = array(
              array(
                "id"=>"hapus","icon"=>"trash","elm"=>$elm,"color"=>"danger",
                "title"=>"Hapus Data",
                "placeholder"=>""
              )
            );
            $form->addIconGroup($btt);
          }else{
            $btt = array(
              array(
                "id"=>"","icon"=>"remove","elm"=>$elm,"color"=>"disabled",
                "title"=>" ",
                "placeholder"=>""
              )
            );
            $form->addIconGroup($btt);
          }
          $total += $h->NILAI;
          ?>
        </td>
      </tr>
    <?php
    }
    ?>
    <tr class='bold'><td></td><td align='right'>TOTAL</td><td align='right'><?php echo number_format($total,2) ?></td><td></td></tr>
    <?php
    $form->closeTable($tabel);
  }else{
    $tabel = array("tblSPPRinci",array("KODE","TANGGAL","URAIAN","NILAI",""));
    $form->addTable($tabel);
    foreach($rinci as $h){ ?>
      <tr class=''>
        <?php if(session()->jnsSpp != "up"){ ?>
          <td align='left'><a class='rincSPJ' data-elm="<?php echo$h->NOSPJ ?>" data-placeholder="<?php echo$h->NOSPJ ?>"><?php echo$h->NOSPJ ?></a></td>
        <?php } else { ?>
          <td align='left'>*</td>
        <?php } ?>
        <td align='center'><?php echo ngSQLSRVTGL($h->TGLSPJ) ?></td>
        <td align='left'><?php echo $h->KDPER." ".$h->KETERANGAN ?></td>
        <td align='right'><?php echo number_format($h->NILAI,2) ?></td>
        <td align='center'>
          <?php
          $elm = trim($h->NOSPJ);
          if($h->NILAI < 1){
            $btt = array(
              array(
                "id"=>"hapus","icon"=>"trash","elm"=>$elm,"color"=>"danger",
                "title"=>"Hapus Data",
                "placeholder"=>""
              )
            );
            $form->addIconGroup($btt);
          }else{
            $btt = array(
              array(
                "id"=>"","icon"=>"remove","elm"=>$elm,"color"=>"danger",
                "title"=>" ",
                "placeholder"=>""
              )
            );
            $form->addIconGroup($btt);
          }
          $total += $h->NILAI;
          ?>
        </td>
      </tr>
    <?php
    }
    ?>
    <tr class='bold'><td></td><td align='right'>TOTAL</td><td align='right'><?php echo number_format($total,2) ?></td></tr>
    <?php
    $form->closeTable($tabel);
  }
?>
<div id='rincSPJ'></div>
<script>
  $("#btnHapusRincLS").hide();
  $('#tblSPPRinci').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 250, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 150, "targets": 3 },
      { "width": 50, "targets": 4 }
    ],
    "fixedColumns": true,
    "autoWidth":false
  });
  
  $("#btnTambahRincGU").click(function(){
    post_to_modal("SPJList","a=","S P J");
  });
  $("#btnTambahRincLS").click(function(){
    post_to_modal("RekLSList","a=","Data Rekening");
  });

  $('#tblSPPRinci').on("click",".rincSPJ",function(){
    elm = $(this).data("elm");
    post_to_tab("2","rincianSPJSPP","nospj="+elm,$(this).data("placeholder"));
  });
  $('#tblSPPRinci').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_tab("2","hapusRinciSPP","nospj="+elm);
    });
  });

  /* ----- SPP LS -----*/
  $('#tblSPPLSRinci').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 100, "targets": 0 },
      { "width": 120, "targets": 2 },
      { "width": 50, "targets": 3 }
    ],
    "fixedColumns": true,
    "autoWidth":false
  });
  $('#tblSPPLSRinci').on("click",".rinciSDLS",function(){
    elm = $(this).data("elm");
    post_to_tab("3","rinciSDLS","mtgkey="+elm,$(this).data("placeholder"));
  });

  $('#tblSPPLSRinci').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_tab("2","hapusRinciSPPLS","mtgkey="+elm);
    });
  });


</script>
