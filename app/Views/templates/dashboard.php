<?php $this->extend('templates/layout') ?>
 
<?php $this->section('content') ?>
<div class="container">
    <h1 class="mt-5">Modul <?php echo strtoupper(session()->modul) ?></h1>
    <p class="lead"></p>
</div>

<script>
</script>
<?php $this->endSection() ?>