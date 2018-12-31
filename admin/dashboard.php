<?php
	
	session_start();
	
	$get_title = 'Dashboard';

	if(isset($_SESSION['Username'])){

		include 'init.php';

		// Start The Dashboard Page
		
		$users_num = 4; //Variable to show the number of registered users dynamically

		$latest_users = get_latest("*", "shop.users", "UserID", $users_num); // latest user array

		$items_num = 4;

		$latest_items = get_latest("*", "shop.items", "Item_ID", $items_num);

		$comments_num = 4;

		$latest_comments = get_latest("*", "shop.comments", "C_ID", $comments_num);
?>
		<div class='container home-stats text-center'>
			<h1>Dashboard</h1>
			<div class='row'>
				<div class='col-md-3'>
					<div class='stat st-members'>
						<i class= "fa fa-users"></i>
						<div class="info">
							Total Mambers
							<span><a href="members.php"><?php echo count_items('UserID', 'shop.users')?></a></span>
						</div>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat st-pending'>
						<i class= "fa fa-user-plus"></i>
						<div class="info">
							Pending Mambers
							<span><a href='members.php?do=Manage&page=pending'>
							<?php echo check_item("Regstatus", "shop.users", 0) ?>
							</a></span>
						</div>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat st-items'>
						<i class="fa fa-tag"></i>
						<div class="info">
							Total Items
						<span><a href="Items.php"><?php echo count_items('Item_ID', 'shop.items')?></a></span>
						</div>
					</div>	
				</div>
				<div class='col-md-3'>
					<div class='stat st-comments'>
						<i class="fa fa-comment"></i>
						<div class="info">
							Total Comments
							<span><a href="comments.php"><?php echo count_items('C_ID', 'shop.comments')?></a></span>
						</div>
					</div>	
				</div>
			</div>
		</div>

		<div class='container latest'>
			<div class = 'row'>
				<div class = col-sm-6>
					<div class = 'panel panel-default'>
						<div class='panel-heading'>
							<i class='fa fa-users'></i>Latest <?php echo $users_num?> Users
							<span class="toggle-info pull-right">
								<i class="fa fa-plus fa-lg"></i>
							</span>
						</div>
					</div>
					<div class='panel-body'>
					 	<ul class= 'list-unstyled latest-user'>
							<?php 
								if(!empty ($latest_users)){
									foreach ($latest_users as $user) {
										echo "<li>";
											echo $user['Username'];
											echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
												echo '<span class= "btn btn-success pull-right">';
													echo "<i class= 'fa fa-edit'></i> Edit";

												echo '</span>';
											echo '</a>'	;
										echo "</li>";
									}
								}else{
									echo 'There\'s no record to show';
								}	
							?>
						</ul>
					</div>
				</div>
				<div class = col-sm-6>
					<div class = 'panel panel-default'>
						<div class='panel-heading'>
							<i class='fa fa-tag'></i>Latest <?php echo $items_num ?> Items
							<span class="toggle-info pull-right">
								<i class="fa fa-tag"></i>								
							</span>
						</div>
					</div>
					<div class = 'panel-body'>
						<ul class= 'list-unstyled latest-user'>
							<?php 
							if (! empty ($latest_items)) {
								foreach ($latest_items as $item) {
									echo "<li>";
										echo $item['Name'];
										echo '<a href="items.php?do=Edit&userid=' . $item['Item_ID'] . '">';
											echo '<span class= "btn btn-success pull-right">';
												echo "<i class= 'fa fa-edit'></i> Edit";
												if($item['Approve'] == 0){

													echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info pull-right'><i class ='fa fa-check'></i>Approve</a>";

												}
											echo '</span>';
										echo '</a>'	;
									echo "</li>";
								}
							} else{
								echo 'There\'s no record to show';
							}
							?>
						</ul>
					</div>
				</div>
			</div>
			<!-- Start Latest Comments-->
			<div class = 'row'>
				<div class = col-sm-6>
					<div class = 'panel panel-default'>
						<div class='panel-heading'>
							<i class='fa fa-comments-o'></i>Latest <?php echo $comments_num ?> Comments
							<span class="toggle-info pull-right">
								<i class="fa fa-plus fa-lg"></i>
							</span>
						</div>
					</div>
					<div class='panel-body'>
						<?php
							$stmt = $con->prepare("SELECT 	
													shop.comments.*, shop.users.Username AS Member
											FROM
													shop.comments
											INNER JOIN 
													shop.users
											ON 
													shop.users.UserID = shop.comments.User_ID
											ORDER BY
											        C_ID DESC

											LIMIT $comments_num");

					   		// Excute The Satment

							$stmt->execute();

							// Assign to variable

							$comments = $stmt->fetchAll();
							if (!empty ($comments)){

								foreach($comments as $comment){
									echo "<div class='comment-box'>";
										echo "<span class='member-n'> " . $comment ['Member']  . "</span>";
										echo "<p class='member-c'> " . $comment ['Comment'] . "</p>";
									echo "</div>";

								}}else{
									echo "There is no record to show";
								}

						 ?>
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