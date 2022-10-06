<div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top">
	<div class="navbar-container ace-save-state" id="navbar-container">
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
		<div class="navbar-header pull-left">
			<a href="index.html" class="navbar-brand">
				<small>
					<i class="fa fa-user-secret"></i>
					SIPKD NG modul <?php echo strtoupper(session()->modul) ?><span style='font-size:12px'>
				</span>
				</small>
			</a>
		</div>

		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="light-blue dropdown-modal">
					
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<span class="user-info">
							<?php echo $_SESSION['operator_name'] ?>
						</span>

						<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo base_url("home/login");?>">
								<i class="ace-icon fa fa-power-off"></i>
								Logout
							</a>
						</li>
						<li class='divider'></li>
					</ul>
				
				</li>
			</ul>
		</div>
	</div><!-- /.navbar-container -->
</div><!-- /.navbar -->
