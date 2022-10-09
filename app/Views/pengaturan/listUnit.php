<?php
?>
  <option value="" selected>PILIH UNIT/SUB UNIT SATUAN KERJA</option>
  <?php
  foreach($unit as $h){ ?>
    <option value="<?php echo $h->UNITKEY ?>"><?php echo $h->KDUNIT." ".$h->NMUNIT ?></option>
  <?php
  }
?>
<script>
</script>