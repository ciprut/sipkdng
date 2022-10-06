<?
  echo "<div id='divControl' style='display:none'>".$_SESSION['control']."</div>";
  echo "<div id='divElement' style='display:none'>".$_SESSION['element']."</div>";
  echo "<div id='divFinish' style='display:none'>".$_SESSION['finish']."</div>";
?>
<script>
  finish = $("#divFinish").text();
  el = $("#divElement").text();
  cn = $("#divControl").text();

	$("#modal-process").append("...Selesai...<br>").scrollTop(100000);
  $("."+el).eq(0).remove();
  if($("."+el).length > 0){
  	p = $("."+el).eq(0);
    judul = p.data("title");
    kode = p.data("elm");
	  $("#modal-process").append($("."+el).length+". "+judul+"...").scrollTop(100000);
	  post_to_content("divProses",cn,"data="+kode);
  }else{
    $("#modal-judul-process").html("...All done...");
  	$("#modal-process").append("<br><br><b>...Selesai...<b>").scrollTop(100000);
    //post_to_content("tab-1",finish,"tabel=subkegiatan","Sub Kegiatan OPD");
    //$('#processModal').modal('hide');
  }
  
</script>
