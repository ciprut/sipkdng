<?php
  $form = new Form_render;
  $form->addClear("10");
  $form->addButton(array("id"=>"btnAmbilPotongan","icon"=>"check","title"=>"Ambil","color"=>"primary"));

  $tabel = array("tblPotonganLSList",array("KODE","URAIAN",""));
  $form->addTable($tabel);
  $idx = time();$total = 0;
  foreach($rek as $h){ ?>
    <tr class=''>
      <td align='left'><?php echo $h->KDPER ?></a></td>
      <td align='left'><?php echo $h->NMPER ?></a></td>
      <td align='center'>
        <?php
        $elm = trim($h->MTGKEY);
        $btt = array(
          array("id"=>"ambil","icon"=>"ok","elm"=>$elm,"color"=>"warning",
          "title"=>"Ambil Data",
          "placeholder"=>$h->KDPAJAK."__".$h->NMPAJAK
          )
        );
        //$form->addIconGroup($btt);
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
  $('#tblPotonganLSList').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":5,
    "columnDefs": [
      { "width": 120, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "bLengthChange" : false,
    "autoWidth" : false,
    "fixedColumns": true
  });

  $('#tblPotonganLSList').on("click",".tambah",function(){
    if($(this).prop("checked") == true){
      ro.push($(this).data('elm'));
    }else{
      ro.pop($(this).data('elm'));
    }
  })

  $("#btnAmbilPotongan").click(function(){
    if(ro.length > 0){
      post_to_tab("3","tambahPotonganLS","mtgkey="+ro);
    }else{
      alert('Anda belum memilih Sub Rincian Obyek..!');
    }
    closeModal();
  })

</script>
