	<ul class="nav nav-list">
		<li class="active">
			<a style='font-size:12px' class="dropdown-toggle">
				<i class="menu-icon fa fa-server"></i>
				<span class="menu-text">Application</span>
				<b class="arrow fa fa-angle-down"></b>
			</a>
			<b class="arrow"></b>
			<ul class='submenu'>
				<li class=''>
          <a class='dropdown-toggle sidebar-menu-item' data-address='<?=base_url("home/dashboard");?>' title='dashboard'>
          	<i class='menu-icon fa fa-home'></i>Home
          </a>
          <b class="arrow"></b>
        </li>
        <li>
          <a class='dropdown-toggle sidebar-menu-item' data-address='<?=base_url("home/fa_test");?>' title='dashboard'>
          	<i class='menu-icon fa fa-home'></i>Fa Test</a>
          <b class="arrow"></b>
        </li>
        <li>
          <a class='dropdown-toggle sidebar-menu-item' data-address='<?=base_url("home/glyp_test");?>' title='dashboard'>
          	<i class='menu-icon fa fa-home'></i>Glyph Test</a>
          <b class="arrow"></b>
        </li>
        <li>
          <a class='dropdown-toggle sidebar-menu-item' data-address='setting' title='setting'>
          	<i class='menu-icon fa fa-cog'></i>Setting</a>
          <b class="arrow"></b>
        </li>
        <li>
          <a class='dropdown-toggle sidebar-menu-item' data-address='<?=base_url("home/login");?>' title='logout'>
          	<i class='menu-icon fa fa-home'></i>Logout</a>
          <b class="arrow"></b>
        </li>
			</ul>
		</li>

		<?php
		$mn = "";

		$mnu = json_decode($menu);
		foreach($mnu as $h){
			$idx = $h->ID_Grup;
			if($mn != $h->ID_Grup){
				if($mn != ""){
					echo "</ul>";
					echo "</li>";
				}
				echo "<li class=''>";
					echo "<a style='font-size:12px' class='dropdown-toggle'>
						<i class='menu-icon fa ".$h->IconGrup."'></i>
						<span class='menu-text'>".$h->Nm_Grup."</span>
						<b class='arrow fa fa-angle-down'></b>
					</a>
					<b class='arrow'></b>";
					echo "<ul class='submenu'>";
				$mn = $h->ID_Grup;
			}
			echo "<li class=''>";
				echo "<a class='dropdown-toggle sidebar-menu-item' data-address='".base_url("/".$h->Link)."' title='".$h->Link."'>
				<i class='menu-icon fa ".$h->Icon."'></i>".$h->Nama_Menu."</a>
				<b class='arrow'></b>";
			echo "</li>";
		}
		echo "</ul>";
		echo "</li>";
			
		?>
	</ul>

<script>
	
	$(".sidebar-menu-item").click(function(){
		addr = $(this).data("address");
		vars = $(this).data("var");
		if(addr == "login"){
			if($(this).attr("title") == "logout"){
				window.location.href = "logout";
			}
		}else if(addr == "setting"){//if(addr != '')
			post_form("formSetting","a=a","Setting");
  	}else {//if(addr != '')
//			location.href = addr;
			window.location.href = addr;
			$('.sidebar').removeClass('active');
	    $('.overlay').removeClass('active');
  	}
    hide_form();
	})
</script>