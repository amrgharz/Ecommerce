<?php

/*
============================
== Categories page
============================
*/

session_start();

 $get_title = "Categories";

 if(isset($_SESSION['Username'])){

 	include 'init.php';

 	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

 	if($do == 'Manage'){

 		$stmt2 = $con->prepare("SELECT * FROM shop.categories");

 		$stmt2->execute();

 		$cats = $stmt2->fetchAll(); ?>
 		<h1 class= 'text-center'> Manage Categories</h1>
 		<div class= "container categories">
 			<div class= 'panel panel-default'>
 				<div class='panel-heading'>Manage Categories</div>
 				<div class='panel-body'>
 				 <?php
 				 foreach ( $cats as $cat ){
 				 	echo "<div class= 'cat' >";
 				 		echo "<div class= 'hidden-buttons'>";
 				 			echo "<a href='#' class='btn btn-primary'><i class='fa fa-edit'></i>Edit</a>";
 				 			echo "<a href='#' class='btn btn-danger'><i class='fa fa-close'></i>Delete</a>";
 				 		echo "</div>";
	 				 	echo "<h3>" . $cat['Name'] . "</h3>";
	 				 		echo "<p>"; 
	 				 		if($cat['Description'] == ''){
	 				 			echo 'This category description is empty';
	 				 		}else{
	 				 			echo $cat['Description'] ;
	 				 		}
	 				 		echo'</p>';
	 				 	if($cat['Visibility'] == 1){echo "<span class= 'visible'> Hidden </span>"; }
	 				 	if($cat['Allow_Comments'] == 1){echo "<span class= 'comment'> Comments Disabled </span>"; }
	 				 	if($cat['Allow_Ads'] == 1){echo "<span class= 'ad'> Ads Disabled</span>"; }
 				 	echo "</div>";
 				 	echo "<hr>";
 				 }
 				 ?>
 				</div>
 			</div>
 		</div>

 		<?php

 	}elseif ($do == 'Add' ){?>

 		<h1 class="text-center ">Add New Categories</h1>

				<div class="container">
					<form class="form-horizontal" action= "?do=Insert" method= "POST">
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" autocomplete="off" required = "required" placeholder="Name of the Category" />
							</div>
						</div>
						<!-- End Of Name Field -->
						<!-- Start Description Field -->
						<div class="form-group  form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<input type="text" name="description" class="form-control"
								placeholder="Descripe the category" />
							</div>
						</div>
						<!-- End Of Description Field -->
						<!-- Start Ordering Field -->
						<div class="form-group form-group-lg ">
							<label class="col-sm-2 control-label">Ordering</label>
							<div class="col-sm-10">
								<input type="text" name="ordering" class="form-control" placeholder="Number to arrange Category" />
							</div>
						</div>
						<!-- End Of Ordering Field -->
						<!-- Start Visibility Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10">
								<div>
									<input id="vis-yes" type="radio" name="visibility" value='0' checked />
									<label for="vis-yes">Yes</label>
								</div>
								<div>
									<input id="vis-no" type="radio" name="visibility" value='1' />
									<label for="vis-no">No</label>
								</div>
							</div>
						</div>					
						<!-- End Visibility Field -->
						<!-- Start Comminting Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Comment</label>
							<div class="col-sm-10">
								<div>
									<input id="com-yes" type="radio" name="comminting" value='0' checked />
									<label for="com-yes">Yes</label>
								</div>
								<div>
									<input id="com-no" type="radio" name="comminting" value='1' />
									<label for="com-no">No</label>
								</div>
							</div>
						</div>					
						<!-- End Comminting Field -->
						<!-- Start Ads Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10">
								<div>
									<input id="ads-yes" type="radio" name="advertising" value='0' checked />
									<label for="ads-yes">Yes</label>
								</div>
								<div>
									<input id="ads-no" type="radio" name="advertising" value='1' />
									<label for="ads-no">No</label>
								</div>
							</div>
						</div>					
						<!-- End Ads Field -->
						<!-- Start Save Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-10 col-sm-offset-2">
								<input type="submit" value='Add Category' class="btn btn-primary btn btn-lg" />
							</div>
						</div>
						<!-- End Of Save Field -->
					</form>

				</div>



 		<?php

 	}elseif ($do == 'Insert'){
 		// Inserrt Category page

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				echo "<h1 class='text-center'>Insert Category</h1>";

				echo "<div class='container'>";


				// Get the variables From the Form 
				$name     	= $_POST['name'];
				$disc  		= $_POST['description'];
				$order 	   	= $_POST['ordering'];
				$visible  	= $_POST['visibility'];
				$comment  	= $_POST['comminting'];
				$ads 	  	= $_POST['advertising'];

				// Check if Category Exists in Database

				$check = check_item("Name", "shop.categories", $name);

				if($check == 1){

						$the_msg = "<div class= 'alert alert-danger'>hmmm this Category already exists, you gotta change is </div>";

						redirect_home($the_msg, 'back');	
				}else{

						//Insert Category info In the database

						$stmt = $con->prepare("INSERT INTO 
									shop.categories(Name, Description, Ordering, Visibility, Allow_Comments, Allow_Ads) 
									VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads)");

						$stmt->execute(array(

							'zname' 	=> $name,
							'zdesc' 	=> $disc,
							'zorder' 	=> $order,
							'zvisible' 	=> $visible,
							'zcomment' 	=> $comment,
							'zads'  	=> $ads

						));

						// Echo Success Meassage 

						$the_msg ="<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD INSERTED</div>';
						redirect_home($the_msg, 'back' );
					}

			}else{

				echo "<div class='container'>";
				$the_msg = "<div class= 'alert alert-danger'>Yo Man Get The Fuck Out Of Here</div>";

				redirect_home($the_msg, 'back',10 );
				echo "</div>";
			}

			echo "</div>";

 	}elseif ($do == 'Edit'){

 	}elseif ($do == 'Update'){

 	}elseif ($do == 'Delete'){

 	} 	

 	include $tpl . 'footer.php';

 } else {

 	header('Location: index.php');

 	exit ();
 }
