<?php 

session_start();

$get_title = 'Profile';

include 'init.php'; 

if (isset($_SESSION['user'])){ 

	$get_user = $con->prepare("SELECT * From shop.users WHERE Username = ?");

	$get_user->execute(array($session_user));

	$info = $get_user->fetch();

?>

<h1 class="text-center"> My Profile</h1>

<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"> My Information</div>
			<div class="panel-body">
				<ul class = "list-unstyled">
					<li> 
						<i class = "fa fa-unlock alt fa-fw"></i>
						<span>LoginName </span> 			: <?php  echo $info['Username']?>
					</li>
					<li> 
						<i class = "fa fa-envelope  fa-fw"></i>
						<span>Email</span> 			: <?php  echo $info['Email']?>
					</li>
					<li> 
						<i class = "fa fa-user  fa-fw"></i>
						<span>Full Name</span> 		: <?php  echo $info['FullName']?>
					</li>
					<li> 
						<i class = "fa fa-calendar  fa-fw"></i>
						<span>Register Date</span> 	: <?php  echo $info['Date']?> 
					</li>
					<li> 
						<i class = "fa fa-tags  fa-fw"></i>
						<span>Favorit Category</span> :
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"> Latest Ads</div>
				<div class="panel-body">
					<?php
					if(!empty(get_items('Member_ID', $info['UserID']))){
						echo "<div class='row'>";
						foreach (get_items('Member_ID', $info['UserID'], 1 ) as $item){
								echo '<div class="col-sm-6 col-md-3">';
									echo '<div class="thumbnail item-box">';
									if ($item['Approve'] == 0){ echo '<span class="approve-status">Not Approved</span>'; }
									echo '<span class="price-tag">' . $item['Price'] . '</span>';
										echo "<img class='img-responsive' src='img.jpg' alt='' />";
										echo '<div class="caption">';
											echo '<h3> <a href="items.php?itemid=' . $item['Item_ID']. '">' . $item['Name'] . '</a></h3>';
											echo '<p>' . $item['Description']. '</p>';
											echo '<p class="date">' . $item['Add_Date']. '</p>';
										echo '</div>';
									echo '</div>';
								echo "</div>";
							}
						echo "</div>";		
						}else{

							echo "Sorry There's No Comments To Show, Create <a href='newad.php'> New Add</a>" ;
						}
					?>
				</div>
		</div>
	</div>
</div>

<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"> Latest Comments</div>
			<div class="panel-body">
				<?php

					$stmt = $con->prepare("SELECT Comment FROM shop.comments WHERE User_ID = ?");

					$stmt->execute(array($info['UserID']));

					$comments = $stmt->fetchAll();

					if(!empty($comments)){

						foreach( $comments as $comment){

						echo "<p>" .  $comment['Comment']  . "</p>";

						}
					}else{
					echo 'There\'s no comments to show';
					}

				 ?>
			</div>
		</div>
	</div>
</div>

<?php 
 }else{
 	 header('Location: login.php');

 	 exit();
 }
include $tpl . 'footer.php'; 

?>