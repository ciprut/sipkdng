<?
  $form = new Form_render;

  $form->addButton(array("id"=>"btnTambahLevelUser","icon"=>"plus","title"=>"Tambah User","color"=>"success"));

  $tabel = array("tblPenggunaMenu",array("No","Nama User","Keterangan","Kode","Satuan Kerja","Action"));
  $form->addTable($tabel);
  $nom = 1;
  $grup = '';
  foreach($user as $h){
    echo "<tr>";
      echo "<td>".$nom."</td>";
      echo "<td>".$h->username."</td>";
      echo "<td>".$h->nama."</td>";
      $kd = $h->kd_urusan.".".pjg($h->kd_bidang,2).".".pjg($h->kd_unit,2).".".pjg($h->kd_sub,2);
      echo "<td align='center'>".$kd."</td>";
      echo "<td>".$h->nama_skpd."</td>";
      echo "<td align='center'>";
        $elm = $h->id;
        $btt = array(
          array("id"=>"btnHapusUserLevel","icon"=>"trash","elm"=>$elm,"color"=>"danger","title"=>"Hapus")
        );
        if(($_SESSION['lv'] != '2') || ($h->username != 'admin')){
          $form->addIconGroup($btt);
        }
      echo "</td>";
    echo "</tr>";
    $nom++;
  }
  $form->closeTable($tabel);

?>

<script>
  $('#tblPenggunaMenu').removeAttr('width').DataTable({
    'order':false,
    'paging': false,
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "width": 100, "targets": 1 },
      { "width": 150, "targets": 2 },
      { "width": 100, "targets": 3 },
      { "width": 50, "targets": 5 }
    ],
    "fixedColumns": true
  });

  $("#btnTambahLevelUser").click(function(){
    post_to_tab("2","listUserLevel","a=a","List User OPD");
    //window.location.href = "listAksesLevel";
  });

  $(".btnHapusUserLevel").click(function(){
    elm = $(this).data("elm");
    modal = {
      color:"danger",
      icon:"minus-circle"
    };
    showModal({color:"danger",isi:"Yakin akan melanjutkan proses ini?"},function(){
      //window.location.href = "hapusAksesLevel/"+elm;
      post_to_tab("1","btnHapusUserLevel","id="+elm);
    });
  });
</script>
