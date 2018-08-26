<?php
	
	session_start();
	$get_title = 'Dashboard';

	if(isset($_SESSION['Username'])){

		include 'init.php';

		// Start The Dashboard Page

?>
		<div class='container home-stats text-center'>
			<h1>Dashboard</h1>
			<div class='row'>
				<div class='col-md-3'>
					<div class='stat'>
						Total Mambers
						<span><?php echo count_items('UserID', 'shop.users')?></span>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat'>
						Pending Mambers
						<span>25</span>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat'>
						Total Items
						<span>1500</span>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat'>
						Total Comments
						<span>200</span>
					</div>	
				</div>
			</div>
		</div>

		<div class='container latest'>
			<div class = 'row'>
				<div class = col-sm-6>
					<div class = 'panel panel-default'>
						<div class='panel-heading'>
							<i class='fa fa-users'></i>Latest Users
						</div>
					</div>
					<div class = 'panel-body'>
						Test
					</div>
				</div>
				<div class = col-sm-6>
					<div class = 'panel panel-default'>
						<div class='panel-heading'>
							<i class='fa fa-tag'></i>Latest Items
						</div>
					</div>
					<div class = 'panel-body'>
						Test
					</div>
				</div>
			</div>
		</div>
<?php
		// End of Dashboard Page

		include $tpl . 'footer.php';

	}else{

		header('Location: index.php');

		exit();
	}