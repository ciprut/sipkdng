<?
class Form_render{
	function addForm($id,$enctype='',$metod='POST',$action='#',$width='100%'){
			$style = "style=''";
			if($width != '100%'){
				$style = "style='width:".$width."'";
			}
			if($enctype != ''){
				echo "<form id='".$id."' enctype='multipart/form-data' method='".$metod."' action='".$action."' ".$style.">";
			}else{
				echo "<form id='".$id."' method='".$metod."' action='".$action."'>";
			}
			return;
		}

		function closeForm(){
			echo "<div style='height:1px'></div>";
			echo "<div class='clear'></div>";
			echo  "</form>";
			echo "<div style='height:15px'></div>";
			return;
		}

		function addHidden($data){
			$html = "<input type='hidden' name='".$data["id"]."' id='".$data["id"]."' value='".$data["value"]."'>";
			echo $html;
			return;
		}
		function addClear($txt=null){
			if($txt == null){
				$html = "<div style='height:1px;display:block;clear:both;float:none'></div>";
			}else{
				$html = "<div style='margin-bottom:".$txt."px;height:".$txt."px;display:block;clear:both;float:none;border-bottom:1px solid #999'></div>";
			}
			echo $html;
			return;
		}

		function addRow($data){			
			$html = "<div class='form-row'>";
			$cols = $data;
			for($i=0;$i<sizeof($data);$i++){
				$dats = $data[$i];
				$placeholder = (isset($dats["placeholder"])) ? $dats["placeholder"] : $dats["label"];
				$value = (isset($dats["value"])) ? $dats["value"] : "";
				$type = $dats["type"];
				$id = $dats["id"];
				$width = (isset($dats["width"])) ? $dats["width"] : "";
				$label = (isset($dats["label"])) ? $dats["label"] : "";
				$option = (isset($dats["option"])) ? $dats["option"] : "";
				$selected = (isset($dats["default"])) ? $dats["default"] : "";
				$readonly = (isset($dats["readonly"])) ? "readonly='".$dats["readonly"]."'" : "";				
				$mask = (isset($dats["mask"])) ? " input-mask-".$dats["mask"]."" : "";				
				$min_date = (isset($dats["min"])) ? "min='".$dats["min"]."'" : "";
				$max_date = (isset($dats["max"])) ? "max='".$dats["max"]."'" : "";

				if($type == "button"){
					$icon = (isset($dats["icon"])) ? $dats["icon"] : "adjust";
					$title = (isset($dats["title"])) ? $dats["title"] : "";
					$color = (isset($dats["color"])) ? $dats["color"] : "";
					if($width == 'auto'){
						$html .= "<div class='col-auto' style='padding-top:30px'>";
					}else{
						$html .= "<div class='form-group col-md-".$width."' style='padding-top:30px'>";
					}

					$html .= "<div type='button' class='btn btn-labeled btn-".$color." btn-xs' id='".$id."' style='margin-left:10px'>
						<span class='btn-label'><i class='glyphicon glyphicon-".$icon."' aria-hidden='true'></i></span>".$title."</div>";
					$html .= "</div>";
				}else
				if($type == "radio"){
					$name = $dats["id"];
					$options = $dats["options"];
					$default = (isset($dats["default"])) ? $dats["default"] : "";
					$color = (isset($dats["color"])) ? $dats["color"] : "primary";
					$html .= "<div class='col-auto btn-group' style='padding-top:22px'>";
//					$html = "<div class='btn-group btn-group' data-toggle='buttons'>";
					for($i=0;$i<sizeof($options);$i++){
						$dat = explode("|",$options[$i]);
						$c = $a = "";
						if($dat[0] == $default){
							$c = "checked";
							$a = "active";
						}
						$html .= "<label class='btn btn-".$color." form-check-label $a'>";
						$html .= "<input type='radio' class='form-check-input' id='".$dat[0]."' name='".$name."' autocomplete='off' $c>".$dat[1];
		  			$html .= "</label>";
					}
					$html .= "</div>";
				}else
				if($type == "date"){
					
					$html .= "<div class='form-group col-md-".$width."'>";
					$html .= "<label for='".$id."'>".$label."</label>";
					$html .= "<input type='".$type."' ".$min_date." ".$max_date." class='form-control date-picker' id='".$id."' name='".$id."' placeholder='".$placeholder."' value='".$value."' ".$readonly.">";
					$html .= "<span class='input-group-addon-date'><i class='glyphicon glyphicon-th'></i></span>";
					$html .= "</div>";
				}
				
				else{
					$html .= "<div class='form-group col-md-".$width."'>";
					$html .= "<label for='".$id."'>".$label."</label>";
					if($type == "select"){
						$html .= "<select id='".$id."' name='".$id."' class='form-control' data-live-search='true'>";
						for($n=0;$n<sizeof($option);$n++){
							$opt = explode("__",$option[$n]);
							$sel = ($opt[0] == $selected) ? "selected" : "";
							$html .= "<option ".$sel." value='".$opt[0]."'>".$opt[1]."</option>";
						}
						$html .= "</select>";
					}else if($type == "textarea"){
						$html .= "<textarea class='form-control' id='".$id."' name='".$id."' placeholder='".$placeholder."' rows='2' ".$readonly.">".$value."</textarea>";
					}else{
						$html .= "<input type='".$type."' class='form-control ".$mask."' id='".$id."' name='".$id."' placeholder='".$placeholder."' value='".$value."' ".$readonly.">";
					}
					$html .= "</div>";
				}
			}
			$html .= "</div>";
			$html .= "<div style='height:1px;display:block;clear:both;float:none'></div>";

			echo $html;
			return;
		}
		function addFrame($data){
			$dat = $data;
			$html = "<div class='form-row'>";
				for($i=0;$i<sizeof($data);$i++){
					$dats = $data[$i];
					$width = (isset($dats["width"])) ? $dats["width"] : "12";
					$label = (isset($dats["label"])) ? $dats["label"] : "Label";
					$value = (isset($dats["value"])) ? $dats["value"] : $dats["value"];
					$html .= "<div class='form-group col-md-".$width."'>";
					$html .= "<div style='font-size:11px;height:20px;line-height:20px;color:#999;margin-top:10px'><b>".$label."</b></div>";
					$html .= "<div style='font-size:12px;line-height:20px;color:#333;border:1px solid #999;padding:5px;background:#ededed'>".$value."</div>";
					$html .= "</div>";					
				}
			$html .= "</div>";
			echo $html;
			return;
		}

		//array("type"->"text","id"->"user_name","label"->"Username","placeholder"->"Username")
		function addGroup($data){
			$dat = $data;	
			$placeholder = (isset($data["placeholder"])) ? $data["placeholder"] : $data["label"];
			$value = (isset($data["value"])) ? $data["value"] : "";
			$type = $data["type"];
			$id = $data["id"];
			$label = $data["label"];
			$option = (isset($data["option"])) ? $data["option"] : "";
			$selected = (isset($data["default"])) ? $data["default"] : "";
			$icon = (isset($data["icon"])) ? $data["icon"] : "";

			$kelas = "";
			if($icon != ""){
				$kelas = "input-icon";
			}
			
			$html = "<div class='form-row' style='padding:0px'>";
			$html = "<div class='form-group col-md-12'>";
			$html .= "<label for='".$id."'>".$label."</label>";
			if($type == "select"){
				if($icon != ""){
					$html .= "<span class='input-group-addon'><i class='glyphicon glyphicon-".$icon."'></i></span>";
				}				
				$html .= "<select id='".$id."' name='".$id."' class='form-control ".$kelas."' data-live-search='true'>";
				for($n=0;$n<sizeof($option);$n++){
					$opt = explode("__",$option[$n]);
					$sel = ($opt[0] == $selected) ? "selected" : "";
					$html .= "<option ".$sel." value='".$opt[0]."'>".$opt[1]."</option>";
				}
				$html .= "</select>";
			}else if($type == "textarea"){
				$html .= "<textarea class='form-control' id='".$id."' name='".$id."' placeholder='".$placeholder."' rows='2'>".$value."</textarea>";
			}else if($type == "datepicker"){
				$html .= "<input type='text' class='datepicker form-control ".$kelas."' id='".$id."' name='".$id."' placeholder='".$placeholder."' value='".$value."'>";
			}else{
				if($icon != ""){
					$html .= "<span class='input-group-addon info'><i class='glyphicon glyphicon-".$icon."'></i></span>";
				}
				$html .= "<input type='".$type."' class='form-control ".$kelas."' id='".$id."' name='".$id."' placeholder='".$placeholder."' value='".$value."'>";
			}		
			$html .= "</div></div>";
			$html .= "<div style='height:1px;display:block;clear:both;float:none'></div>";

			echo $html;
			return;
		}

		function addRadio($data){
			$name = $data["id"];
			$options = $data["options"];
			$default = (isset($data["default"])) ? $data["default"] : "";
			$color = (isset($data["color"])) ? $data["color"] : "primary";
			$html = "<div class='btn-group' data-toggle='buttons'>";
			for($i=0;$i<sizeof($options);$i++){
				$dat = explode("|",$options[$i]);
				$c = $a = "";
				if($dat[0] == $default){
					$c = "checked";
					$a = "active";
				}
				$html .= "<label class='btn btn-".$color." form-check-label $a'>";
				$html .= "<input type='radio' class='form-check-input' id='".$dat[0]."' name='".$name."' autocomplete='off' $c>".$dat[1];
  			$html .= "</label>";
			}
			$html .= "</div>";
			echo $html;
			return;
		}

		//$data = array("id"=>"btnCetakRekap","icon"=>"print","title"=>"Cetak Rekap","color"=>"success")
		function addButton($data,$level=null){
			$id = $data["id"];
			$color = (isset($data["color"])) ? $data["color"] : "primary";
			$title = $data["title"];
			$icon = (isset($data["icon"])) ? $data["icon"] : "";
			if($icon != ""){
				$html = "<div type='button' class='btn btn-labeled btn-".$color."' id='".$id."'><span class='btn-label'><i class='glyphicon glyphicon-".$icon."' aria-hidden='true'></i></span>".$title."</div>";
			}else{
				$html = "<div type='button' class='btn btn-".$color."' id='".$id."'>".$title."</div>";
			}
			if($level != null && $_SESSION['level'] != $level){
				$html = '*';
			}
			echo $html;
			return;
		}

		function addIconGroup($data,$level=null){
			$html = "";
			$html .= "<div class='btn-group'>";
			for($i=0;$i<sizeof($data);$i++){
				$id = (isset($data[$i]["id"])) ? $data[$i]["id"] : "";
				$elm = $data[$i]["elm"];
				$icon = (isset($data[$i]["icon"])) ? $data[$i]["icon"] : "plus";
				$placeholder = (isset($data[$i]["placeholder"])) ? $data[$i]["placeholder"] : "";
				$title = (isset($data[$i]["title"])) ? $data[$i]["title"] : "";
				$color = (isset($data[$i]["color"])) ? $data[$i]["color"] : "primary";
				$html .= "<button class='btn btn-xs ".$id." btn-".$color."' type='button' 
				data-toggle='tooltip' 
				title='".$title."'
				data-elm='".$elm."' 
				data-placeholder='".$placeholder."' 
				style='margin-right:0px;margin-left:0px;font-size:9px;position:static !important'>
				<span class='glyphicon glyphicon-".$icon."'></span>
				</button>";
			}
			$html .= "</div>";
			if($level != null && $_SESSION['level'] != $level){
				$html = '*';
			}
			echo $html;
			return;
		}
		/*
		$data = array("title"=>"Cetak","id"=>"btnAksiPrint","icon"=>"print","color"=>"success",
      "options"=>array(
        array("class"=>"btnCetakRekap","elm"=>$elm,"title"=>"Pagu Pembahasan","icon"=>"edit"),
        array("class"=>"btnCetakRekapPendapatan","elm"=>$elm,"title"=>"Pagu Sumber Dana","icon"=>"edit"),
        array("class"=>"btnCetakRekapSumberDana","elm"=>$elm,"title"=>"Pagu Pendapatan","icon"=>"edit")
      )
		);
    */
		function addButtonIconGroup($data,$level=null){
			$options = $data["options"];
			$id = $data["id"];
			$color = (isset($data["color"])) ? $data["color"] : "primary";
			$icon = (isset($data["icon"])) ? $data["icon"] : "th-list";
			$title = $data["title"];

			$html = "<div class='btn-group' style='margin-left:10px'>";

				$html .= "<div type='button' class='btn btn-labeled dropdown-toggle btn-".$color."' id='".$id."' data-toggle='dropdown'>";
				$html .= "<span class='btn-label'><i class='glyphicon glyphicon-".$icon."' aria-hidden='true'></i></span>".$title."</div>";
			$html .= "<ul class='dropdown-menu' style='background:#FFFFFF;padding:2px'>";
				for($n=0;$n<sizeof($options);$n++){
					$opt = $options[$n];
					$separator = (isset($opt["type"])) ? $opt["type"] : "link";
					if($separator != "separator"){
						$class = $opt["class"];
						$elm = $opt["elm"];
						$title = $opt["title"];
						$icon = (isset($opt["icon"])) ? $opt["icon"] : "th-list";
						$glyp = "<i class='glyphicon glyphicon-".$icon."' aria-hidden='true'></i>";
					}
					if($separator == "separator"){
						$html .= "<li role='separator' class='divider' style='border-bottom:1px solid #cccccc;margin:2px'></li>";
					}else{
						$html .= "<li style='padding:0px;margin-bottom:2px'><a href='#' class='dropdown-link' id='".$class."' data-elm='".$elm."'>".$glyp." ".$title."</a></li>";
					}
				}
			$html .= "</ul></div>";
			if($level != null && $_SESSION['level'] != $level){
				$html = '*';
			}
			echo $html;
			return;
		}

		/*
		$data = array("title"=>"Action","id"=>"btnAksiPembahasan",
      "options"=>array(
        array("class"=>"btnUsulanPaguOPD","elm"=>$elm,"title"=>"Pagu Pembahasan","icon"=>"edit"),
        array("class"=>"btnUsulanSumberDana","elm"=>$elm,"title"=>"Pagu Sumber Dana","icon"=>"edit"),
        array("class"=>"btnUsulanPendapatan","elm"=>$elm,"title"=>"Pagu Pendapatan","icon"=>"edit")
      )
		);
    */
		function addButtonGroup($data,$level=null){
			$options = $data["options"];
			$html = "<div class='btn-group' style='margin-left:10px'>";
			$html .= "<button type='button' class='btn btn-outline-primary btn-sm dropdown-toggle icon-only' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
    	$html .= "<span class=''></span></button>";
			$html .= "<ul class='dropdown-menu' style='background:#FFFFFF;padding:2px'>";
				for($n=0;$n<sizeof($options);$n++){
					$opt = $options[$n];
					$separator = (isset($opt["type"])) ? $opt["type"] : "link";
					if($separator != "separator"){
						$class = $opt["class"];
						$elm = $opt["elm"];
						$title = $opt["title"];
						$icon = (isset($opt["icon"])) ? $opt["icon"] : "th-list";
						$glyp = "<i class='glyphicon glyphicon-".$icon."' aria-hidden='true'></i>";
					}
					if($separator == "separator"){
						$html .= "<li role='separator' class='divider' style='border-bottom:1px solid #cccccc;margin:2px'></li>";
					}else{
						$html .= "<li style='padding:0px;margin-bottom:2px'><a href='#' class='dropdown-link ".$class."' data-elm='".$elm."'>".$glyp." ".$title."</a></li>";
					}
				}
			$html .= "</ul></div>";

			if($level != null && $_SESSION['level'] != $level){
				$html = '*';
			}
			echo $html;
			return;
		}
		function addAceIconGroup($data,$level=null){
			$options = $data["options"];
			$html = "<div class='pull-right pos-rel dropdown-hover'>";
			$html .= "<button class='btn btn-minier bigger btn-primary'>
				<i class='ace-icon fa fa-th-list icon-only bigger-120'></i>
			</button>";
			$html .= "<ul class='dropdown-menu dropdown-only-icon dropdown-yellow dropdown-caret dropdown-close dropdown-menu-right'>";
				for($n=0;$n<sizeof($options);$n++){
					$opt = $options[$n];
					$separator = (isset($opt["type"])) ? $opt["type"] : "link";
					if($separator != "separator"){
						$class = $opt["class"];
						$elm = $opt["elm"];
						$title = $opt["title"];
						$icon = (isset($opt["icon"])) ? $opt["icon"] : "th-list";
						$color = (isset($opt["color"])) ? $opt["color"] : "blue";
					}
					$html .= "<li>
					<a href='#' class='tooltip-success ".$class." has-tooltip' data-toggle='tooltip' data-placement='left' data-rel='tooltip' title='".$title."' data-elm='".$elm."'>
						<span class='".$color."'>
							<i class='ace-icon fa fa-".$icon." bigger-110'></i>
						</span>
					</a></li>";
				}
			$html .= "</ul></div>";

			if($level != null && $_SESSION['level'] != $level){
				$html = '*';
			}
			echo $html;
			return;
		}

		function addTable($data){
			$id = $data[0];
			$class = (isset($data[2])) ? $data[2] : "table-bordered";;

			$html = "<table id='".$id."' class='display ".$class."' style='width:100% !important'>";
      $html .= "<thead><tr>";
      $th = $data[1];

      for($n=0;$n<sizeof($th);$n++){
      	$html .= "<th>".$th[$n]."</th>";
      }
      $html .= "</tr></thead><tbody>";
      echo $html;
			return;
		}

		function closeTable($data){
			$id = $data[0];
      $html = "</tbody><tfoot><tr>";
      $th = $data[1];

      for($n=0;$n<sizeof($th);$n++){
      	$html .= "<th>".$th[$n]."</th>";
      }
      $html .= "</tr></tfoot></table>";
      echo $html;
			return;
		}

		function addJudul($data){
      $html = "<div class='web-judul' style='margin-top:10px'>".$data."</div>";
      echo $html;
			return;
		}
		function addTitle($data){
      $html = "<div class='web-judul' style='margin-top:10px'>".$data."</div>";
      echo $html;
			return;
		}
		function addFooterTitle($data){
      $html = "<div style='margin-top:10px;margin-bottom:10px;font-size:10px;color:#B71C1C;border-top:1px solid #CCC;padding:0px'>".$data."</div>";
      echo $html;
			return;
		}

		function addCard($data){
			$width = (isset($data["width"])) ? $data["width"] : "12";
			$color = (isset($data["color"])) ? $data["color"] : "primary";
			$header = (isset($data["header"])) ? $data["header"] : "Header";
			$title = (isset($data["title"])) ? $data["title"] : "title";
			$content = (isset($data["content"])) ? $data["content"] : "content";

			$html = '<div class="col-sm-'.$width.'"><div class="card text-white border-'.$color.' mb-2">';
  		$html .= '<div class="card-header text-'.$color.'">'.$header.'</div>';
  		$html .= '<div class="card-body">';
    	$html .= '<h5 class="card-title text-'.$color.'">'.$title.'</h5>';
    	$html .= '<p class="card-text text-'.$color.'" style="font-size:12px">'.$content.'</p>';
    	$html .= '</div></div></div>';
    	echo $html;
			return;
		}

		function openCard($data){
			$width = (isset($data["width"])) ? $data["width"] : "12";
			$color = (isset($data["color"])) ? $data["color"] : "primary";
			$header = (isset($data["header"])) ? $data["header"] : "Header";
			$title = (isset($data["title"])) ? $data["title"] : "title";

			$html = '<div class="col-sm-'.$width.'"><div class="card border-'.$color.' mb-2">';
  		$html .= '<div class="card-header text-'.$color.'">'.$header.'</div>';
  		$html .= '<div class="card-body" style="font-size:12px">';
    	$html .= '<h5 class="card-title text-'.$color.'">'.$title.'</h5>';
  		$html .= '<div style="font-size:12px" class="text-'.$color.'">';
    	echo $html;
			return;
		}

		function closeCard(){
    	$html = '</div></div></div></div>';
    	echo $html;
			return;
		}

				//Title
		function addButtonGroups($data,$level=null){
			$d = explode("->",$data);
			$html = "<div class='btn-group' style='margin-left:10px'>";
			//$html .= "<button type='button' class='btn btn-primary'>".$d[0]."</button>";
			$html .= "<button type='button' class='btn btn-outline-primary btn-sm dropdown-toggle icon-only' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
//    	$html .= $d[0]."<span class=''></span></button>";
    	$html .= "<span class=''></span></button>";
			$html .= "<ul class='dropdown-menu' style='background:#FFFFFF;padding:2px'>";
				$a = explode("__",$d[2]);
				for($n=0;$n<sizeof($a);$n++){
					$b = explode(",",$a[$n]);
						$glyp = "<i class='glyphicon glyphicon-th-list' aria-hidden='true'></i>";
					if(sizeof($b) > 2){
						$glyp = "<i class='glyphicon glyphicon-".$b[2]."' aria-hidden='true'></i>";
					}
					if($b[0] == "separator"){
						$html .= "<li role='separator' class='divider'></li>";
					}else{
						$html .= "<li style='padding:0px;'><a href='#' class='dropdown-link ".$d[1]."' data-elm='".$b[0]."'>".$glyp." ".$b[1]."</a></li>";
					}
				}
			$html .= "</ul></div>";

			if($level != null && $_SESSION['level'] != $level){
				$html = '*';
			}
			echo $html;
			return;
		}

		function addFlash(){
			$flash = session()->getFlashdata('flash');
			if($flash != ''){
				$html = "<div class='alert alert-".$flash['color']."' role='alert' 
				style='position:fixed;top:45px;right:0px;margin:20px;z-index:99999;padding:0px;margin:0px;left:260px'>";
				/*<h4 class='alert-heading'><b>".$flash['title']."</b></h4>
					<hr style='margin:5px'>
					<p style='height:50px;line-height:50px;font-size:11px;min-width:60%'>".$flash['content']."</p>
					<hr style='margin:5px'>
					<center><small>click untuk menutup pesan ini</small></center>
					*/
				$html .= "
					<div style='height:40px;line-height:40px;font-size:12px;width:100%;padding-left:10px'>
					<b>".$flash['title']."</b> 
					<i class='ace-icon fa fa-angle-double-right'></i>
					".$flash['content']."
						<button type='button' class='close' style='margin-top:11px;margin-right:11px'>
				    <span aria-hidden='true'>&times;</span>
				  	</button>
					</div>
				</div>
				<script>
					$('.alert').click(function(){
						$(this).alert('close');
					});
					window.setTimeout(function() {
						$('.alert').fadeTo(300, 0).slideUp(300, function(){
							$(this).remove(); 
						});
					}, 5000);
				</script>";
				echo $html;
			}
			return;
		}

		function addInfoBox($data){
			$width = (isset($data['width'])) ? $data['width'] : "210px";
			$color = (isset($data['color'])) ? $data['color'] : "blue";
			$icon = (isset($data['icon'])) ? $data['icon'] : "comments";
			$number = (isset($data['number'])) ? "<span class='infobox-data-number'>".$data['number']."</span>" : "";
			$text = (isset($data['text'])) ? "<span class='infobox-data-text'>".$data['text']."</span>" : "";
			$content = (isset($data['content'])) ? $data['content'] : "";

			$html = "<div class='infobox infobox-".$color."' style='width:".$width.";min-width:210px'>";
			$html .= "<div class='infobox-icon'><i class='ace-icon fa fa-".$icon."'></i></div>";
			$html .= "<div class='infobox-data'>".$number.$text."<div class='infobox-content'>".$content."</div></div>";
			$html .= "</div>";
			echo $html;
			return;
		}

		function addTest(){
			$html = "Form ready<br>";
			echo $html;
			return;
		}
}
//$form = new Form_render;
//$form->addTest();
?>