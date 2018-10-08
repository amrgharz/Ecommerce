<?php
	
	session_start();
	
	$get_title = 'Dashboard';

	if(isset($_SESSION['Username'])){

		include 'init.php';

		// Start The Dashboard Page
		
		$latest_users = 4; //Variable to show the number of registered users dynamically

		$the_latest = get_latest("*", "shop.users", "UserID", $latest_users); // latest user array


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
						<span><a href='members.php?do=Manage&page=pending'>
							<?php echo check_item("Regstatus", "shop.users", 0) ?>
						</a></span>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat st-items'>
						Total Items
						<span><a href="Items.php"><?php echo count_items('Item_ID', 'shop.items')?></span></a>
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
							<i class='fa fa-users'></i>Latest <?php echo $latest_users?> Users
						</div>
					</div>
					<div class = 'panel-body'>
					 	<ul class= 'list-unstyled latest-user'>
							<?php 
								foreach ($the_latest as $user) {
									echo "<li>";
										echo $user['Username'];
										echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
											echo '<span class= "btn btn-success pull-right">';
												echo "<i class= 'fa fa-edit'></i> Edit";
											echo '</span>';
										echo '</a>'	;
									echo "</li>";
								}
							?>
						</ul>
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