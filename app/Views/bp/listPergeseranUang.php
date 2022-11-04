<?php
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahPU","icon"=>"plus","title"=>"Tambah Data Pergeseran Uang","color"=>"primary"));

  getFlashData();

  $tabel = array("tblPergeseranUang",array("NO","TGL BUKU","TGL BKU","STATUS","URAIAN","*"));
  $form->addTable($tabel);
  foreach($bkubp as $h){ ?>
    <tr class=''>
      <td align='left'><a class="rinci" data-elm="<?php echo $h->NOBUKU; ?>" data-placeholder="<?php echo $h->NOBUKU; ?>"><?php echo $h->NOBUKU ?></a></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLBUKU) ?></td>
      <td align='center'><?php echo ngSQLSRVTGL($h->TGLVALID) ?></td>
      <td align='center'><?php echo $h->LBLSTATUS ?></td>
      <td align='left'><?php echo $h->URAIAN ?></td>
      <td align='center'>
        <?php
        $elm = $h->NOBUKU;

        if($h->TGLVALID == NULL){
          $act = array(
            array("id"=>"ubah","elm"=>$elm,"color"=>"danger","title"=>"Edit Data","placeholder"=>""),
            array("id"=>"hapus","elm"=>$elm,"color"=>"danger","title"=>"Hapus Data","placeholder"=>"")
          );
        }else{
          $act = array(
            array("id"=>"setuju","elm"=>$elm,"color"=>"danger","title"=>"Pembatalan Validasi","placeholder"=>"")
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
<script>
  $('#tblPergeseranUang').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":10,
    "columnDefs": [
      { "width": 200, "targets": 0 },
      { "width": 120, "targets": 1 },
      { "width": 120, "targets": 2 },
      { "width": 130, "targets": 3 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true
  });

  $("#btnTambahPU").click(function(){
    if($("#keybend").val() != '' ){
      post_form("formPergeseranUang","nobuku=","Pergeseran Uang");
    }else{
      alert("Pilih Bendahara Pengeluaran");
    }
  });

  $('#tblPergeseranUang').on("click",".hapus",function(){
    elm = "nobuku="+$(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      post_to_content("listPU","hapusPU",elm);
    });
  });
  $('#tblPergeseranUang').on("click",".ubah",function(){
    elm = $(this).data("elm");
    post_form("formPergeseranUang","nobuku="+$(this).data("elm"),"BKU Bendahara Pengeluaran");
  });
  $('#tblPergeseranUang').on("click",".rinci",function(){
    elm = $(this).data("elm");
    post_to_tab("1","rincianPU","nobuku="+elm,"Rincian "+$(this).data("placeholder"))
  });

</script>
