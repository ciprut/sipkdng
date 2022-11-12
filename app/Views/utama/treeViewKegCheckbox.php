<div style='border:1px solid #999'>
<?php

  $form = new Form_render;
  $form->addTitle('Program / Kegiatan dan Sub Kegiatan');
?>
<div style='padding:10px;height:350px;overflow: scroll;'>

<?php
  $n = 0;
  foreach($tree as $h){ 
    $parent[trim($h->LEVELKEG)] = str_replace(".","_", $h->NUKEG);
    $padding = (int)$h->LEVELKEG * 15 ."px";
    if(trim($h->LEVELKEG) > 0){
      //$dis = ($h->LEVELKEG > 1) ? "none" : "block";
      $class = "";
      $selisih = trim($h->LEVELKEG) - $n;
      if($selisih > 0){
        echo "<ul class='level-".trim($h->LEVELKEG)." prokeg'>";
      }
      if($selisih == -1){
        echo "</li></ul>";
      }
      if($selisih == -2){
        echo "</ul></li></ul>";
      }
      if($selisih == 0){
        echo "</li>";
      }
      $fa = '';//<i class="fa fa-caret-right"></i>&nbsp;&nbsp;';
      $class="";
      $noNm = "<input type='checkbox' data-elm='".$h->KDKEGUNIT."' class='sk' style='margin-right:5px;'><font style='color:#870000;line-height:20px'>".$h->NUKEG." ".$h->NMKEGUNIT."</font>";
      if(trim($h->LEVELKEG) == 1){
        $fa = '<i class="fa fa-angle-double-right"></i>';
        $class="treex";
        $noNm = "<b style='color:#333333'>".$h->NUKEG." ".$h->NMKEGUNIT."</b>";
      }
      if(trim($h->LEVELKEG) == 2){
        $fa = '<i class="fa fa-angle-right"></i>';
        $noNm = "<b style='color:#333333'>".$h->NUKEG." ".$h->NMKEGUNIT."</b>";
        $class="treex";
      }
    ?>
      <li>
      
      <div class='<?php echo $class; ?>' style="cursor:pointer" data-elm='<?php echo $h->KDKEGUNIT ?>' data-placeholder="<?php echo $h->NUKEG."__".$h->NMKEGUNIT ?>">
      <?php echo $fa.$noNm ?></div>
    <?php
      $n = trim($h->LEVELKEG);
    }
  }
?>
  </li></ul>
</div>
</div>
<?php
  $form->addClear("5");
  $form->addButton(array("id"=>"btnAmbilSubs","icon"=>"save","title"=>"Simpan","color"=>"primary"));
?>
<script>
  $(".level-2,.level-3").hide();
  $(".treex").click(function(){
    $(this).closest('li').find('ul').first().slideToggle();
    $(this).find('i').toggleClass("rot");
  });

  $('#tblTree').removeAttr('width').DataTable({
    "ordering":false,
    "pageLength":25,
    "columnDefs": [
      { "width": 150, "targets": 0 },
      { "width": 50, "targets": 2 }
    ],
    "fixedColumns": true,
    "autoWidth" : false
  });
  $("#btnAmbilSubs").click(function(){
    subs = new Array();
    $(".sk").each(function(){
      if($(this).prop('checked') == true){
        subs.push($(this).data('elm'));
      }
    });
    if(subs.length < 1){
      alert('Anda belum memilih Sub Kegiatan!');
    }else{
      $("#idSub").val(subs).keyup();
      closeModal();
    }
  });
  $('.subKeg').click(function(){
    elm = $(this).data("elm");
    dats = $(this).data("placeholder").split("__");
    $("#idSub").val(elm);
    $("#kdSub").val(dats[0]);
    $("#namaSub").val(dats[1]);
    gotoTab("0");
    closeModal();
  });
</script>
