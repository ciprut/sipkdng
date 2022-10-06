<?
  $form = new Form_render;

  foreach($listOPD as $h){
    $elm = $h->id_unit."__".kd_skpd($h->kode_skpd)."__".$h->kd_urusan.".".pjg($h->kd_bidang,2).".".pjg($h->kd_unit,2).".".pjg($h->kd_sub,2);
    $ttl = $h->id_unit." ".kd_skpd($h->kode_skpd)." ".$h->kd_urusan.".".pjg($h->kd_bidang,2).".".pjg($h->kd_unit,2).".".pjg($h->kd_sub,2);
    echo "<div class='elemen' style='float:left;padding:3px;margin:1px;border:1px solid #999;display:none'
    data-elm='".$elm."' data-title='".$elm." ".$h->nama_skpd."'>".$ttl." ".$h->nama_skpd."</div>";
  }
?>
<script>
  $('#tblSubUnits').tabel({
    'title':'Data SPP',
    'message':'Tidak ada data tagihan',
    "widths": [
      { "value": 50, "col": 0 },
      { "value": 160, "col": 1 },
      { "value": 100, "col": 3 },
      { "value": 90, "col": 4 }
    ]
   });

</script>
