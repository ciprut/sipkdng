<?php
  $form = new Form_render;
  $jn = array('bkud'=>'BKU Penerimaan','bkuk'=>'BKU Pengeluaran','bkut'=>'BKU Transfer');
  $form->addTitle($jn[session()->jns]);

  $form->addClear("10");
  $form->addButton(array("id"=>"btnTambahVal","icon"=>"plus","title"=>"Tambah","color"=>"primary"));

  getFlashData();

  $tabel = array("tblValidasi",array("NO","TANGGAL","TGL SAH","NO SP2D","AFEKTASI","POTONGAN","PAJAK","DIBAYAR","*"));
  $form->addTable($tabel);
  foreach($valid as $h){ ?>
    <tr class=''>
      <td align='left'><a class="rinci" data-elm="<?php echo $h->NOSP2D; ?>"><?php echo $h->NOBUKAS ?></a></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLKAS) ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLVALID) ?></td>
      <td align='left'><?php echo $h->NOSP2D ?></td>
      <td align='right'><?php echo number_format($h->AFEKTASI,2) ?></td>
      <td align='right'><?php echo number_format($h->POTONGAN,2) ?></td>
      <td align='right'><?php echo number_format($h->PAJAK,2) ?></td>
      <td align='right'><?php echo number_format($h->DIBAYAR,2) ?></td>
      <td align='center'>
        <?php
        $elm = $h->NOSP2D;

        if($h->TGLVALID == NULL){
          $act = array(
            array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus Validasi BUD","placeholder"=>"")
          );
        }else{
          $act = array(
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Pembatalan Validasi BUD","placeholder"=>"")
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
  $('#tblValidasi').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 100, "targets": 1 },
      { "width": 100, "targets": 2 },
      { "width": 120, "targets": 4 },
      { "width": 120, "targets": 5 },
      { "width": 120, "targets": 6 },
      { "width": 120, "targets": 7 },
      { "width": 50, "targets": 8 }
    ],
    "fixedColumns": true
  });

  $("#btnTambahVal").click(function(){
    post_form("formValidasi","nobbantu="+$("#nobbantu").val(),"BKU BUD");
  });

  $('#tblValidasi').on("click",".hapus",function(){
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
  $('#tblValidasi').on("click",".rinci",function(){
    elm = $(this).data("elm");
    post_to_content("detilSP2D","rincianValSP2D","nosp2d="+elm,$(this).data("placeholder"))
  });
  $('#tblValidasi').on("click",".setuju",function(){
    elm = $(this).data("elm");
    post_form("formSP2DSetuju","nosp2d="+elm,"Persetujuan S P 2 D");
  });
</script>
