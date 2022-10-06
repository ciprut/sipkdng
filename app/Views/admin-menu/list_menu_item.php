<?  
  $form = new Form_render;

  $form->addButton(array("id"=>"btnAmbilMenu","icon"=>"check","title"=>"Ambil Menu","color"=>"success"));

  $tabel = array("tblMenuItemID",array("","No","Keterangan","Icon","Link"));
  $form->addTable($tabel);
  $grup = "";
  foreach($aksesgrup as $h){
    echo "<tr data-id='".$h->ID_Menu."'>";
      echo "<td>".$h->ID_Menu."</td>";
      echo "<td>".$h->No_Urut."</td>";
      echo "<td><a class='nmGrup' data-elm='".$h->ID_Grup."'>".$h->Menu."</a></td>";
      echo "<td>".$h->Icon."</td>";
      echo "<td>".$h->Link."</td>";
    echo "</tr>";
  }
  $form->closeTable($tabel);
?>
<form id='frmAksesList' method="POST">
  <input type='hidden' name='a' value='baru'>
  <input type='hidden' id='mnulist' name='menu' value=''>
</form>

<script>
  $('#tblMenuItemID').removeAttr('width').DataTable({
    "columnDefs": [
      { "width": 50, "targets": 0 },
      { "targets": 0,"checkboxes": {
        "selectRow": true
        }
      }
    ],
    "select": {
         "style": "multi"
      },
    "order": [[1, "asc"]],
    "fixedColumns": true,
    "paging":false
  });


  $(".btnAmbilMenux").click(function(){
    var rows_selected = $('#tblMenuItemID').column(0).checkboxes.selected();
    rows_selected.each(function(){
      alert("id");
    });
  });

  $("#btnAmbilMenu").click(function(){
//    var rows_selected = $(".dt-checkboxes:checked");
    var rows_selected = $(".selected");

    data = [];
    rows_selected.each(function(index, rowId){
      data.push($(this).closest('tr').attr('data-id'));
    });
    $("#mnulist").val(data.join("__"));
    post_to_tab("1","tambahAksesLevel","menu="+$("#mnulist").val());
  });
</script>
