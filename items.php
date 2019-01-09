<?php 

session_start();

$get_title = 'Profile';

include 'init.php'; 

	// Check if get request userid is numeric and get the integer value of it 

			$itemid =  isset ($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;

			// Select all Data of this ID

			$stmt = $con->prepare("SELECT 
											shop.items.*, 
											shop.categories.Name AS category_name,
											shop.users.Username
									FROM 
											shop.items
									INNER JOIN 
											shop.categories
									ON
											shop.categories.ID = shop.items.Cat_ID
									INNER JOIN 
											shop.users
									ON
											shop.users.UserID = shop.items.Member_ID
									WHERE 
									 		Item_ID= ? 
									AND
											Approve = 1 ");

			// EXecute Query

			$stmt->execute(array($itemid));

			$count = $stmt->rowCount();

			if ($count > 0){

			//Fech the data

			$item = $stmt->fetch();


?>
<h1 class="text-center"> <?php echo $item['Name'] ?></h1>
<div class='container'>
	<div class='row'>
		<div class="col-md-3">
			<img class="img-responsive img-thumpnail" src='img.jpg' alt=''/> 
		</div>
		<div class="col-md-9 item-info">
			<h2> 			<?php 	echo $item['Name'] ?>		</h2>
			<p> 			<?php 	echo $item['Description']?>	</p>
			<ul class="list-unstyled">
				<li> 
					<i class='fa fa-calendar fa-fw'></i>	
					<span>Add-Date:</span> <?php 	echo $item['Add_Date']?>		
				</li>
				<li>	
					<i class='fa fa-money fa-fw'></i>
					<span>Price:   </span> <?php 	echo $item['Price']?>			
				</li>
				<li>
					<i class='fa fa-building  fa-fw'></i>	
					<span>Countey: </span> <?php 	echo $item['Country_Made'] ?>	
				</li>
				<li>
					<i class='fa fa-tags fa-fw'></i>	
					<span>Category:</span> <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>">  <?php 	echo $item['category_name'] ?></a>	
				</li>
				<li>
					<i class='fa fa-user fa-fw'></i>	
					<span>Added-By:</span> <a href="#"> <?php 	echo $item['Username'] ?></a>		
				</li>
			</ul>
		</div>
	</div>
	<hr class="custom-hr">
		<?php if(isset($_SESSION['user'])) { ?> 
		<!-- Start Add Comment -->
		<div class="row">
			<div class='col-md-offset-3'>
				<div class="add-comment">
					<h3>Add Your Comment</h3>
					<form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']?>" method="POST">
						<textarea name="comment"></textarea>
						<input class="btn btn-primary "type="submit" value="Add Comment">
					</form>	
				</div>
			</div>
		</div>
		<?php 
				if($_SERVER['REQUEST_METHOD'] == 'POST'){

					$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
					$itemid  = $item['Item_ID'];
					$userid  = $_SESSION['uid'];

					if(! empty($comment)){

						$stmt = $con->prepare("INSERT INTO
							                              shop.comments(comment, status, comment_date, item_id, user_id)
							                              VALUES (:zcomment, 0, NOW(), :zitemid, :zuserid)
							                              ");
						$stmt->execute(array(

							'zcomment' => $comment,
							'zitemid'  => $itemid,
							'zuserid'  => $userid
							));

						if($stmt){

							echo "Comment Added";
						}
					}
				}

			} else{
			echo "<a href='login.php'>Log In </a>" .  "OR <a href='login.php'>Sign Up </a> To Add Comment";
			}?>
		<!-- End Add Comment -->
	<hr class="custom-hr">
			<?php $stmt = $con->prepare("SELECT
											shop.comments.*, shop.users.Username AS Member
										FROM
											shop.comments
										INNER JOIN 
											shop.users
										ON
											shop.users.UserID = shop.comments.user_id
										WHERE 
											item_id = ?
										AND
											status = 1
										ORDER BY
											C_ID
										 DESC");

			// Execute The Statment

				$stmt->execute(array($item['Item_ID']));

			// Assign To Variable

				$comments = $stmt->fetchAll();

			?>
	<?php
		foreach($comments as $comment){ ?>

			<div class="comment-box">
				<div class='row'>
					<div class='col-sm-2 text-center'>
						<?php  echo $comment['Member']?>
						<img class="img-responsive img-thumbnail img-circle center-block" src="img.jpg" alt="">
					</div>
					<div class='col-sm-10'>
						<p class="lead "><?php  echo $comment['Comment']?></p>		 
					</div>
				</div>			
			</div>
			<hr class="custom-hr">
		<?php }

	 ?>
</div>

<?php }else{

	echo 'There is no such ID Or The Item Is Awaiting Approval';
}

	include $tpl . 'footer.php'; 

?>