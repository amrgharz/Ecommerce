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
					<div class='stat st-members'>
						Total Mambers
						<span><a href="members.php"><?php echo count_items('UserID', 'shop.users')?></span></a>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat st-pending'>
						Pending Mambers
						<span><a href='members.php?do=Manage&page=pending'>25</a></span>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat st-items'>
						Total Items
						<span>1500</span>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat st-comments'>
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