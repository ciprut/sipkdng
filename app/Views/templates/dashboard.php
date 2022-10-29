<?php $this->extend('templates/layout') ?>
 
<?php $this->section('content') ?>
<div class="container">
    <h1 class="mt-5">Modul <?php echo strtoupper(session()->modul) ?></h1>
    <?php 
    echo ngTanggal("29101977","ddmmmyyyy")."<br>";
    echo ngTanggal("29101977","ddmmmmyyyy")."<br>";
    echo ngTanggal("29101977","ddmmyyyy")."<br>";
    echo ngTanggal("29101977","mmmyyyy")."<br>";
    echo ngTanggal("29101977","mysql")."<br>";
    echo ngTanggal("29101977","sqlserver")."<br>";

    echo ngTanggal("29101977","dd")."<br>";
    echo ngTanggal("29101977","mm")."<br>";
    echo ngTanggal("29101977","yyyy")."<br>";
    echo "Unitkey SKPKD : ".session()->cur_skpkd;
?>
    <p class="lead"></p>
</div>

<script>
</script>
<?php $this->endSection() ?>