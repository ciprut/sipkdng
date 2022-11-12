<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahSPM","icon"=>"plus","title"=>"Tambah SPM","color"=>"primary"));

  getFlashData();

  $tabel = array("tblSPM",array("NO SPM","TGL SPM","TGL SAH","NO SPP","NO SPD","KEPERLUAN",""));
  $form->addTable($tabel);
  foreach($spm as $h){ ?>
    <tr class=''>
      <td align='left'><a class="rinci" data-elm="<?php echo $h->NOSPM ?>"><?php echo $h->NOSPM." ".session()->Idxkode ?></a></td>
      <td align='center'><?php echo ngSQLTanggal($h->TGLSPM,"ddmmmyyyy") ?></td>
      <td align='center'><?php echo ngSQLTanggal($h->TGLVALID,"ddmmmyyyy") ?></td>
      <td align='center'><?php echo $h->NOSPP ?></td>
      <td align='center'><?php echo $h->KETOTOR ?></td>
      <td align='center'><?php echo $h->KEPERLUAN ?></td>
      <td align='center'>
        <?php
        $elm = $h->NOSPM;

//        array("id"=>"rinci","elm"=>$elm,"color"=>"primary","title"=>"Rincian SPM","placeholder"=>$h->NOSPM),
        IF($h->TGLVALID == ''){
          $act = array(
            array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah SPM","placeholder"=>""),
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Persetujuan SPM","placeholder"=>""),
            array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus SPM","placeholder"=>"")
          );
        }else{
          $act = array(
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Pembatalan SPM","placeholder"=>"")
          );
        }
        if($h->NOSP2D == ''){
          $form->addDropdown($act);
        }
        ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);

  $form->addTabs('Rincian Kegiatan__Rincian Pajak','tabsSPM');
?>
<div id='detilSPM'></div>
<script>
  $( "#myTabs" ).tabs();
  $('#tblSPM').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 100, "targets": 1 },
      { "width": 100, "targets": 2 },
      { "width": 250, "targets": 3 },
      { "width": 100, "targets": 4 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true
  });
  $("#btnTambahSPM").click(function(){
    txt = $("#jnsSPM option:selected").text();
    post_form("formSPM","nospm=",txt);
  });

  $('#tblSPM').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_content("listSPM","hapusSPM","nospm="+elm)
    });
  });
  $('#tblSPM').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formSPM","nospm="+elm,"PERUBAHAN S P M");
  });
  $('#tblSPM').on("click",".rinci",function(){
    elm = $(this).data("elm");
    //$("#tabsSPM").fadeIn();
    post_to_tab("1","rincianSPM","nospm="+elm,"Rincian Kegiatan");
    //post_to_content("tabsSPM-1","rincianSPM","nospm="+elm,$(this).data("placeholder"));
    //$("#header-tabsSPM-1").click();
  });
  $('#tblSPM').on("click",".setuju",function(){
    elm = $(this).data("elm");
    post_form("formSPMSetuju","nospm="+elm,"Persetujuan S P M");
  });

</script>
