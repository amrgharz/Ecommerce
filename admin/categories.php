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

 		$sort = 'ASC' ;

 		$sort_array = array('ASC' , 'DESC');

 		if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

 			$sort = $_GET['sort'];
 		}

 		$stmt2 = $con->prepare("SELECT * FROM shop.categories ORDER BY Ordering $sort ");

 		$stmt2->execute();

 		$cats = $stmt2->fetchAll(); ?>
 		<h1 class= 'text-center'> Manage Categories</h1>
 		<div class= "container categories">
 			<div class= 'panel panel-default'>
 				<div class='panel-heading'>
					Manage Categories
					<div class='ordering pull-right'>Ordering
						<a class = "<?php if($sort == 'ASC'){echo 'active';}?>" href="?sort=ASC">Asc</a>
						<a class = "<?php if($sort == 'DESC'){echo 'active';}?>" href="?sort=DESC">Desc</a>
					</div>
				</div>
 				<div class='panel-body'>
 				 <?php
 				 foreach ( $cats as $cat ){
 				 	echo "<div class= 'cat' >";
 				 		echo "<div class= 'hidden-buttons'>";
 				 			echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-primary'><i class='fa fa-edit'></i>Edit</a>";
 				 			echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-danger'><i class='fa fa-close'></i>Delete</a>";
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
 			<a class="add-category btn btn-primary "href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Category</a>
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
 		// Edit page 

			// Check if get request catid is numeric and get the integer value of it 

			$catid =  isset ($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :  0;

			// Select all Data of this ID

			$stmt = $con->prepare("SELECT * FROM shop.categories WHERE ID= ? ");

			// EXecute Query

			$stmt->execute(array($catid));

			//Fech the data

			$cat = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			//If there is Id show the form 

			if ($count > 0){ ?>
			
				<h1 class="text-center ">Edit Categories</h1>

				<div class="container">
					<form class="form-horizontal" action= "?do=Update" method= "POST">
						<input type="hidden" name="catid" value="<?php echo $catid ?>">
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" value="<?php echo $cat['Name']?>" required = "required" placeholder="Name of the Category" />
							</div>
						</div>
						<!-- End Of Name Field -->
						<!-- Start Description Field -->
						<div class="form-group  form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<input type="text" name="description" class="form-control"
								placeholder="Descripe the category" value="<?php echo $cat['Description']?>" />
							</div>
						</div>
						<!-- End Of Description Field -->
						<!-- Start Ordering Field -->
						<div class="form-group form-group-lg ">
							<label class="col-sm-2 control-label">Ordering</label>
							<div class="col-sm-10">
								<input type="text" name="ordering" class="form-control" placeholder="Number to arrange Category"  value="<?php echo $cat['Ordering']?>"/>
							</div>
						</div>
						<!-- End Of Ordering Field -->
						<!-- Start Visibility Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10">
								<div>
									<input id="vis-yes" type="radio" name="visibility" value='0' <?php if($cat['Visibility'] == 0 ){ echo 'checked';}?> />
									<label for="vis-yes">Yes</label>
								</div>
								<div>
									<input id="vis-no" type="radio" name="visibility" value='1' <?php if($cat['Visibility'] == 1 ){ echo 'checked';}?>/>
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
									<input id="com-yes" type="radio" name="commenting" value='0' <?php if($cat['Allow_Comments'] == 0 ){ echo 'checked';}?> />
									<label for="com-yes">Yes</label>
								</div>
								<div>
									<input id="com-no" type="radio" name="commenting" value='1' <?php if($cat['Allow_Comments'] == 1 ){ echo 'checked';}?>/>
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
									<input id="ads-yes" type="radio" name="advertising" value='0' <?php if($cat['Allow_Ads'] == 0 ){ echo 'checked';}?> />
									<label for="ads-yes">Yes</label>
								</div>
								<div>
									<input id="ads-no" type="radio" name="advertising" value='1' <?php if($cat['Allow_Ads'] == 1 ){ echo 'checked';}?>/>
									<label for="ads-no">No</label>
								</div>
							</div>
						</div>					
						<!-- End Ads Field -->
						<!-- Start Save Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-10 col-sm-offset-2">
								<input type="submit" value='Save' class="btn btn-primary btn btn-lg" />
							</div>
						</div>
						<!-- End Of Save Field -->
					</form>

				</div>
				
		<?php

			// If there is no such ID show an error message 

			}else{
				echo "<div class='container'>";

				$the_msg = "<div class='alert alert-danger'>there is no such ID</div>" ;

				redirect_home($the_msg);

				echo "</div>";
			}

 	}elseif ($do == 'Update'){

 		//Update Category

			echo "<h1 class='text-center'>Update Category</h1>";

			echo "<div class='container'>";

				if($_SERVER['REQUEST_METHOD'] == 'POST'){

					// Get the variables From the Form 

					$id       	= $_POST['catid'];
					$name      	= $_POST['name'];
					$desc 	   	= $_POST['description'];
					$order  	= $_POST['ordering'];
					$visible  	= $_POST['visibility'];
					$comment  	= $_POST['commenting'];
					$ad  		= $_POST['advertising'];

					// check if there is no error proceed the update  operation

			
					$stmt = $con->prepare("UPDATE 
												shop.categories
											SET Name = ?,
										 	 	Description= ?, 
										 	 	Ordering= ?,
										 	 	Visibility= ?,
										 	 	Allow_Comments= ?,
										 	 	Allow_Ads = ?
										  	WHERE ID= ?");

					$stmt->execute(array($name, $desc, $order, $visible, $comment, $ad, $id));

					// Echo Success Meassage 

					$the_msg = "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD UPDATED</div>';

					redirect_home($the_msg, 'back',5 );

			}else{

				$the_msg =" <div class = 'alert alert-danger'> YOU Man Get the Fuck out of here</div>";
				redirect_home($the_msg);
			}

			echo "</div>";


 	}elseif ($do == 'Delete'){
 		echo "<h1 class='text-center'>Delete Category</h1>";

			echo "<div class='container'>";

				
				// Check if catid is there and numeric & get the integer vakue of it 

				$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

				// SElect all the data associated with this userid 

				$check = check_item('ID', 'shop.categories', $catid);

				// If there such Id Delete it

				if($check > 0){
						
					$stmt = $con->prepare("DELETE FROM shop.categories WHERE ID= :zid");

						$stmt->bindParam(":zid" , $catid);

						$stmt->execute();

						$the_msg =  "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD DELETED</div>';

						redirect_home($the_msg , 'back');
				}else{

					$the_msg = "<div class='alert alert-danger'>bad bad</div>";
					redirect_home($the_msg);
			}
			echo "</div>";

 	} 	

 	include $tpl . 'footer.php';

 } else {

 	header('Location: index.php');

 	exit ();
 }
