<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahSP2D","icon"=>"plus","title"=>"Tambah SP2D","color"=>"primary"));

  getFlashData();

  $tabel = array("tblSP2D",array("NO SP2D","TANGGAL","TGL SAH","NO SPD","NO REG SP2D","KEPERLUAN","*"));
  $form->addTable($tabel);
  foreach($sp2d as $h){ ?>
    <tr class=''>
      <td align='left'><a class="rinci" data-elm="<?php echo $h->NOSP2D; ?>"><?php echo $h->NOSP2D ?></a></td>
      <td align='left'><?php echo $h->TGLSP2D ?></td>
      <td align='left'><?php echo $h->TGLVALID ?></td>
      <td align='left'><?php echo $h->KETOTOR ?></td>
      <td align='center'><?php echo $h->NOREG ?></td>
      <td align='center'><?php echo $h->KEPERLUAN ?></td>
      <td align='center'>
        <?php
        $elm = $h->NOSP2D;

        if($h->TGLVALID == NULL){
          $act = array(
            array("id"=>"ubah","elm"=>$elm,"color"=>"primary","title"=>"Ubah SP2D","placeholder"=>""),
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Persetujuan SP2D","placeholder"=>""),
            array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus SP2D","placeholder"=>"")
          );
        }else{
          $act = array(
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Pembatalan SP2D","placeholder"=>"")
          );
        }
        if($h->TGLVALID == NULL){
          $form->addDropdown($act);
        }
        ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
  
?>
<div id='detilSP2D'></div>
<script>
  $('#tblSP2D').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 100, "targets": 1 },
      { "width": 100, "targets": 2 },
      { "width": 250, "targets": 3 },
      { "width": 100, "targets": 4 },
      { "width": 50, "targets": 6 }
    ],
    "fixedColumns": true
  });

  $("#btnTambahSP2D").click(function(){
    post_form("formSP2D","nosp2d=","S P 2 D");
  });

  $('#btnTambahSP2D').on("click",".hapus",function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_tab("1","hapusSP2D","nosp2d="+elm)
    });
  });
  $('#tblSP2D').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formSP2D","nosp2d="+elm,"PERUBAHAN S P 2 D");
  });
  $('#tblSP2D').on("click",".rinci",function(){
    elm = $(this).data("elm");
    post_to_content("detilSP2D","rincianSP2D","nosp2d="+elm,$(this).data("placeholder"))
    //post_to_tab("2","rincianSPM","nospp="+elm,$(this).data("placeholder"))
  });
  $('#tblSP2D').on("click",".setuju",function(){
    elm = $(this).data("elm");
    post_form("formSP2DSetuju","nosp2d="+elm,"Persetujuan S P 2 D");
  });
</script>
