<?php
?>
  <option value="" selected>Pilih Unit/Sub Unit Satuan Kerja</option>
  <?php
  foreach($unit as $h){ ?>
    <option value="<?php echo $h->UNITKEY ?>"><?php echo $h->KDUNIT." ".$h->NMUNIT." [".$h->UNITKEY."]"; ?></option>
  <?php
  }
?>
<script>
  //$("#listUnit").extendSelect();//.selectpicker('destroy').attr("data-live-search","true").selectpicker({dropupAuto: false});
</script>