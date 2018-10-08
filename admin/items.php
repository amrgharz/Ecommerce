<?php
/*
 Items Page
*/

 session_start();

 $get_title = "";

 if(isset($_SESSION['Username'])){

 	include 'init.php';

 	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

 	if($do == 'Manage'){
 		$stmt = $con->prepare("SELECT shop.items.*, shop.categories.Name AS category_name, shop.users.Username 
 								FROM shop.items
								INNER JOIN shop.categories ON categories.ID = items.Cat_ID
								INNER JOIN shop.users ON users.UserID = items.Member_ID");

			   // Excute The Satment

			$stmt->execute();

				// Assign to variable

			$items = $stmt->fetchAll();


			?>

			<h1 class="text-center">Manage items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Control</td>
						</tr>

						<?php
							foreach ($items as $item) {
								echo "<tr>";
									echo "<td>" . $item['Item_ID'] . "</td>";
									echo "<td>" . $item['Name'] . "</td>";
									echo "<td>" . $item['Description'] . "</td>";
									echo "<td>" . $item['Price'] . "</td>";
									echo "<td>" . $item['Add_Date']  .  "</td>";
									echo "<td>" . $item['category_name'] . "</td>";
									echo "<td>" . $item['Username'];
									echo "<td> 
												<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class ='fa fa-edit'></i>Edit</a>
												<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class ='fa fa-close'></i>Delete</a>";
												}
									echo "</td>";
								echo "</tr>";
						?>
					</table>
				</div>
				<a href='items.php?do=Add'class="btn btn-primary "><i class=" fa fa-plus"></i>New Item </a>

			</div>

		<?php
 	}elseif ($do == 'Add' ){?>
 		<h1 class="text-center">Add New Item</h1>

			<div class="container">
				<form class="form-horizontal" action= "?do=Insert" method= "POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input 	type="text" 
									name="name" 
									class="form-control" 
									required = "required" 
									placeholder="Name of the Item"
							/>
						</div>
					</div>
					<!-- End Of Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<input 	type="text"
									name="description" 
									class="form-control" 
									required = "required" 
									placeholder="Descripe the new Item"
							/>
						</div>
					</div>
					<!-- End Of Description Field -->

					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10">
							<input 	type="text"
									name="price" 
									class="form-control" 
									required = "required" 
									placeholder="The price of the Item"
							/>
						</div>
					</div>
					<!-- End Of Price Field -->

					<!-- Start Country Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10">
							<input 	type="text"
									name="country" 
									class="form-control" 
									required = "required" 
									placeholder="Country of made"
							/>
						</div>
					</div>
					<!-- End Of Country Field -->

					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<select name="status">
								<option value='0'>...</option>
								<option value='1'>New</option>
								<option value='2'>Like New</option>
								<option value='3'>Used</option>
								<option value='4'>Old</option>
							</select>
						</div>
					</div>
					<!-- End Of Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10">
							<select name="member">
								<option value='0'>...</option>
								<?php
								$stmt = $con->prepare("SELECT * FROM shop.users");
								$stmt->execute();
								$users = $stmt->fetchAll();
								foreach($users as $user){
									echo "<option value='". $user[UserID] ."'> ".$user[Username] ."</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10">
							<select name="category">
								<option value='0'>...</option>
								<?php
								$stmt = $con->prepare("SELECT * FROM shop.categories");
								$stmt->execute();
								$cats = $stmt->fetchAll();
								foreach($cats as $cat){
									echo "<option value='". $cat[ID] ."'> ".$cat[Name] ."</option>";
								}
								?>
							</select>
						</div>
					</div>
					<!-- Start Save Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-10 col-sm-offset-2">
							<input type="submit" value='Add Category' class="btn btn-primary btn btn-sm" />
						</div>
					</div>
					<!-- End Of Save Field -->
				</form>

			</div>

	<?php		
 	}elseif ($do == 'Insert'){

 		if($_SERVER['REQUEST_METHOD'] == 'POST'){

				echo "<h1 class='text-center'>Insert Item</h1>";

				echo "<div class='container'>";


				// Get the variables From the Form 
				$name      	= $_POST['name'];
				$desc  		= $_POST['description'];
				$price 	   	= $_POST['price'];
				$country  	= $_POST['country'];
				$status     = $_POST['status'];
				$member     = $_POST['member'];
				$category 	= $_POST['category'];	

				// Validate The form

				$error_handler = array();

				if(empty($name)){
					$error_handler[]= 'name can not be empty';
				}

				if(empty($desc)){
					$error_handler[]= 'description can not be empty';
				}

				if(empty($price)){
					$error_handler[]= 'Price can not be empty';
				}

				if(empty($country)){
					$error_handler[]= 'Country can not be empty';
				}

				if($status == 0 ){
					$error_handler[]= "You need to chose a status";
				}
				if($member == 0 ){
					$error_handler[]= "You need to chose a status";
				}
				if($category == 0 ){
					$error_handler[]= "You need to chose a status";
				}


				foreach($error_handler as $error){

					echo "<div class= 'alert alert-danger'>" .  $error  . "</div>";
				}

				// check if there is no error proceed the update  operation

				if(empty($error_handler)){

					//Insert userinfo In the database

					$stmt = $con->prepare("INSERT INTO 
														shop.items(Name, Description, Price, Country_Made, Status, Add_Date, Member_ID, Cat_ID) 
											VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zmember, :zcat)");

					$stmt->execute(array(

					'zname' 	=> $name,
					'zdesc' 	=> $desc,
					'zprice' 	=> $price,
					'zcountry' 	=> $country,
					'zstatus' 	=> $status,
					'zmember'	=> $member,
					'zcat'		=> $category
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
 	// Check if get request userid is numeric and get the integer value of it 

			$itemid =  isset ($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;

			// Select all Data of this ID

			$stmt = $con->prepare("SELECT * FROM shop.items WHERE Item_ID= ? LIMIT 1");

			// EXecute Query

			$stmt->execute(array($itemid));

			//Fech the data

			$item = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			//If there is Id show the form 

			if ($count > 0){ ?>
			<h1 class="text-center">Edit Item</h1>

			<div class="container">
				<form class="form-horizontal" action= "?do=Insert" method= "POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input 	type="text" 
									name="name" 
									class="form-control" 
									required = "required" 
									placeholder="Name of the Item"
									value="<?php echo $item['Name']?>"
							/>
							<input type="hidden" name="itemid" value="<?php echo $itemid?>">
						</div>
					</div>
					<!-- End Of Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<input 	type="text"
									name="description" 
									class="form-control" 
									required = "required" 
									placeholder="Descripe the new Item"
									value="<?php echo $item['Description']?>"
							/>
						</div>
					</div>
					<!-- End Of Description Field -->

					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10">
							<input 	type="text"
									name="price" 
									class="form-control" 
									required = "required" 
									placeholder="The price of the Item"
									value="<?php echo $item['Price']?>"
							/>
						</div>
					</div>
					<!-- End Of Price Field -->

					<!-- Start Country Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10">
							<input 	type="text"
									name="country" 
									class="form-control" 
									required = "required" 
									placeholder="Country of made"
									value="<?php echo $item['Country_Made']?>"
							/>
						</div>
					</div>
					<!-- End Of Country Field -->

					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<select name="status">
								<option value='0'>...</option>
								<option value='1' <?php if ($item['Status'] == 1){echo 'selected';}?>>New</option>
								<option value='2' <?php if ($item['Status'] == 2){echo 'selected';}?>>Like New</option>
								<option value='3' <?php if ($item['Status'] == 3){echo 'selected';}?>>Used</option>
								<option value='4' <?php if ($item['Status'] == 4){echo 'selected';}?>>Old</option>
							</select>
						</div>
					</div>
					<!-- End Of Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10">
							<select name="member">
								<option value='0'>...</option>
								<?php
								$stmt = $con->prepare("SELECT * FROM shop.users");
								$stmt->execute();
								$users = $stmt->fetchAll();
								foreach($users as $user){
									echo "<option value='". $user['UserID'] ."'";
									if ($item['Member_ID'] == $user['UserID']) {echo 'selected';}
									echo ">" . $user['Username']  ."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10">
							<select name="category">
								<option value='0'>...</option>
								<?php
								$stmt = $con->prepare("SELECT * FROM shop.categories");
								$stmt->execute();
								$cats = $stmt->fetchAll();
								foreach($cats as $cat){
									echo "<option value='". $cat[ID] ."'";
									if ($item['Cat_ID'] == $cat['ID']) {echo 'selected';}
									echo ">" . $cat['Name'] ."</option>";
								}
								?>
							</select>
						</div>
					</div>
					<!-- Start Save Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-10 col-sm-offset-2">
							<input type="submit" value='Add Category' class="btn btn-primary btn btn-sm" />
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
			}

 	}elseif ($do == 'Update'){
 	echo "<h1 class='text-center'>Update Member</h1>";

			echo "<div class='container'>";

				if($_SERVER['REQUEST_METHOD'] == 'POST'){

					// Get the variables From the Form 

					$id        	= $_POST['itemid'];
					$name      	= $_POST['name'];
					$desc 	   	= $_POST['description'];
					$price  	= $_POST['price'];
					$country  	= $_POST['country'];
					$status  	= $_POST['status'];
					$member  	= $_POST['member'];
					$category 	  	= $_POST['category'];

					// Validate The form

					$error_handler = array();

				if(empty($name)){
					$error_handler[]= 'name can not be empty';
				}

				if(empty($desc)){
					$error_handler[]= 'description can not be empty';
				}

				if(empty($price)){
					$error_handler[]= 'Price can not be empty';
				}

				if(empty($country)){
					$error_handler[]= 'Country can not be empty';
				}

				if($status == 0 ){
					$error_handler[]= "You need to chose a status";
				}
				if($member == 0 ){
					$error_handler[]= "You need to chose a status";
				}
				if($category == 0 ){
					$error_handler[]= "You need to chose a status";
				}


				foreach($error_handler as $error){

					echo "<div class= 'alert alert-danger'>" .  $error  . "</div>";
				}

					// check if there is no error proceed the update  operation

					if(empty($error_handler)){
					//Update the database with this info

					$stmt = $con->prepare("UPDATE shop.items
											 SET 
											 	Name= ?,
											 	Description= ?,
											 	Price= ?,
											 	Country_Made= ?,
											 	Status =?,
											 	Cat_ID = ?,
											 	Member_ID =?
											 WHERE 
											 	Item_ID= ?");
					$stmt->execute(array($name, $desc, $price, $country, $status, $member, $category, $id));

					// Echo Success Meassage 

					$the_msg = "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD UPDATED</div>';

					redirect_home($the_msg, 'back',5 );



				}

			}else{

				$the_msg =" <div class = 'alert alert-danger'> YOU Man Get the Fuck out of here</div>";
				redirect_home($the_msg);
			}

			echo "</div>";



 	}elseif ($do == 'Delete'){

 	}elseif ($do == 'Approve'){

 	}

 	include $tpl . 'footer.php';

 } else {

 	header('Location: index.php');

 	exit ();
 }


 ?>