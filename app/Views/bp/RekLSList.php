<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnAmbilRincianROLS","icon"=>"check","title"=>"Simpan Rincian Obyek","color"=>"primary"));

  $tabel = array("tblRinciROLS",array("KODE","URAIAN",""));
  $form->addTable($tabel);
  $idx = time();$total = 0;
  foreach($rek as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDPER ?></a></td>
      <td align='left'><?php echo $h->NMPER ?></a></td>
      <td align='center'>
        <?php
        $elm = trim($h->MTGKEY);
        $form->addCheckbox(array("id"=>"tambah","elm"=>$elm));
        ?>
      </td>
    </tr>
  <?php
  }
  $form->closeTable($tabel);
?>
<script>
  ro = new Array();
  $('#tblRinciROLS').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 80, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblRinciROLS').on("click",".ambil",function(){
    elm = $(this).data("elm");
    post_to_tab("1","tambahRO","mtgkey="+elm);
  });

  $('#tblRinciROLS').on("click",".tambah",function(){
    if($(this).prop("checked") == true){
      ro.push($(this).data('elm'));
    }else{
      ro.pop($(this).data('elm'));
    }
  })

  $("#btnAmbilRincianROLS").click(function(){
    if(ro.length > 0){
      post_to_tab("1","tambahROLS","mtgkey="+ro);
      closeModal();
    }else{
      alert('Anda belum memilih Sub Rincian Obyek..!');
    }
  })

</script>
