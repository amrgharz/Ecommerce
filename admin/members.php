<?php

/*
=======================================================
--Manage members page
--Here you can add | edit | delete members 
=======================================================
*/

session_start();
	$get_title = 'Members';

	if(isset($_SESSION['Username'])){

		include 'init.php';
 
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		// Start manage page 

		if ($do == 'Manage' ){// Manage Members Page

			$query = '';

			if(isset($_GET['page']) && $_GET['page'] =='pending'){

				$query = 'AND Regstatus == 0';
			}

				//select all users except admin

			$stmt = $con->prepare("SELECT * FROM shop.users WHERE GroupID !=1 $query ORDER BY UserID DESC");

			   // Excute The Satment

			$stmt->execute();

				// Assign to variable

			$rows = $stmt->fetchAll();

			if (! empty ($rows)){	

			?>

			<h1 class="text-center">Manage Members</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registered date</td>
							<td>RegStatus</td>
							<td>Control</td>
						</tr>

						<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['UserID'] . "</td>";
									echo "<td>" . $row['Username'] . "</td>";
									echo "<td>" . $row['Email'] . "</td>";
									echo "<td>" . $row['FullName'] . "</td>";
									echo "<td>" . $row['Date']  .  "</td>";
									echo "<td>" . $row['RegStatus']  .  "</td>";
									echo "<td> 
												<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class ='fa fa-edit'></i>Edit</a>
												<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class ='fa fa-close'></i>Delete</a>";

												if($row['RegStatus'] == 0){

													echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' class='btn btn-info'><i class ='fa fa-check'></i>Approve</a>";

												}
									echo "</td>";
								echo "</tr>";
							}
						?>
					</table>
				</div>
				<a href='members.php?do=Add'class="btn btn-primary "><i class=" fa fa-plus"></i>New Member </a>

			</div> 
		<?php } else {

				echo "<div class='container'>";
					echo "<div class='alert alert-info'>There's No record </div> ";
					echo "<a href='members.php?do=Add'class='btn btn-primary'><i class='fa fa-plus'></i>New Member </a>";
				echo "</div>";		
		} ?>

		<?php
				}elseif( $do == 'Add'){  //add members page ?>

			
				<h1 class="text-center ">Add New Member</h1>

				<div class="container">
					<form class="form-horizontal" action= "?do=Insert" method= "POST">
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input type="text" name="username" class="form-control" autocomplete="off" required = "required" placeholder="Please Enter A Username" />
							</div>
						</div>
						<!-- End Of USername Field -->
						<!-- Start password Field -->
						<div class="form-group  form-group-lg">
							<label class="col-sm-2 control-label">Passowrd</label>
							<div class="col-sm-10">
								<input type="Password" name="password" required= "required" class="password form-control" autocomplete="new-password"
								placeholder="Please Enter A strong Password" />
								<i class="show-pass fa fa-eye fa-2x"></i>
							</div>
						</div>
						<!-- End Of Password Field -->
						<!-- Start email Field -->
						<div class="form-group form-group-lg ">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="email" name="email" class="form-control" required = "required" placeholder="Please Enter A valid Email" />
							</div>
						</div>
						<!-- End Of email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10">
								<input type="text" name="fullname" class="form-control" required = "required" placeholder="Your Full name Goes here" />
							</div>
						</div>
						<!-- End Of Full Name Field -->
						<!-- Start Save Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-10 col-sm-offset-2">
								<input type="submit" value='Add member' class="btn btn-primary btn btn-lg" />
							</div>
						</div>
						<!-- End Of Save Field -->
					</form>

				</div>

		<?php
		}elseif( $do == 'Insert'){
			// Inserrt member page

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				echo "<h1 class='text-center'>Insert member</h1>";

				echo "<div class='container'>";


				// Get the variables From the Form 
				$user      	= $_POST['username'];
				$password  	= $_POST['password'];
				$email 	   	= $_POST['email'];
				$fullname  	= $_POST['fullname'];

				$hashed_pass = sha1($_POST['password']);

				// Validate The form

				$error_handler = array();

				if(empty($user)){
					$error_handler[]= 'username can\'t be empty';
				}

				if(strlen($user)<4 || strlen($user)>20){
					$error_handler[]= 'username should be between 4 and 20 charachters';
				}

				if(empty($password)){
					$error_handler[]= 'password should not be empty';
				}

				if(empty($email)){
					$error_handler[]= 'Email should not be empty';
				}

				if(empty($fullname)){
					$error_handler[]= " Fullname should not be empty";
				}

				foreach($error_handler as $error){

					echo "<div class= 'alert alert-danger'>" .  $error  . "</div>";
				}

				// check if there is no error proceed the update  operation

				if(empty($error_handler)){
				// Check if user Exists in Database

					$check = check_item("Username", "shop.users", $user);

						if($check == 1){

							$the_msg = "<div class= 'alert alert-danger'>hmmm this user already exists, you gotta change is </div>";

							redirect_home($the_msg, 'back');	
						}else{

							//Insert userinfo In the database

							$stmt = $con->prepare("INSERT INTO 
																shop.users(Username, Password, Email, Fullname, Regstatus, Date) 
													VALUES(:zuser, :zpass, :zmail, :zname,0 , now())");

							$stmt->execute(array(

							'zuser' => $user,
							'zpass' => $hashed_pass,
							'zmail' => $email,
							'zname' => $fullname

							));

							// Echo Success Meassage 

							$the_msg ="<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD INSERTED</div>';
							redirect_home($the_msg, 'back' );
						}
				}

			}else{

				echo "<div class='container'>";
				$the_msg = "<div class= 'alert alert-danger'>Yo Man Get The Fuck Out Of Here</div>";

				redirect_home($the_msg, 'back',10 );
				echo "</div>";
			}

			echo "</div>";
		}
		elseif($do == 'Edit'){// Edit page 

			// Check if get request userid is numeric and get the integer value of it 

			$userid =  isset ($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :  0;

			// Select all Data of this ID

			$stmt = $con->prepare("SELECT * FROM shop.users WHERE UserID= ? LIMIT 1");

			// EXecute Query

			$stmt->execute(array($userid));

			//Fech the data

			$row = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			//If there is Id show the form 

			if ($count > 0){ ?>
			
				<h1 class="text-center ">Edit Member</h1>

				<div class="container">
					<form class="form-horizontal" action= "?do=Update" method= "POST">
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input type="text" name="username" class="form-control" value = "<?php echo $row['Username']?>" autocomplete="off"  required = "required"/>
								<input type="hidden" name="userid" value="<?php echo $userid?>">
							</div>
						</div>
						<!-- End Of USername Field -->
						<!-- Start password Field -->
						<div class="form-group  form-group-lg">
							<label class="col-sm-2 control-label">Passowrd</label>
							<div class="col-sm-10">
								<input type="hidden" name="oldpassword" value='<?php echo $row['Password']?>'  />
								<input type="Passowrd" name="newPassowrd" class="form-control" autocomplete="new-password"
								placeholder="Leave blank if you do not want to change" />
							</div>
						</div>
						<!-- End Of Password Field -->
						<!-- Start email Field -->
						<div class="form-group form-group-lg ">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="email" name="email" class="form-control" value = "<?php echo $row['Email']?>" required = "required"/>
							</div>
						</div>
						<!-- End Of email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10">
								<input type="text" name="fullname" class="form-control" required = "required" value = "<?php echo $row['FullName']?>"/>
							</div>
						</div>
						<!-- End Of Full Name Field -->
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
			}
		}elseif ($do == 'Update' ){ //Update Page

			echo "<h1 class='text-center'>Update Member</h1>";

			echo "<div class='container'>";

				if($_SERVER['REQUEST_METHOD'] == 'POST'){

					// Get the variables From the Form 

					$id        	= $_POST['userid'];
					$user      	= $_POST['username'];
					$email 	   	= $_POST['email'];
					$fullname  	= $_POST['fullname'];

					// Password
					$pass = '';
					if(empty($_POST['newPassowrd']))
					{
						$pass = $_POST['oldpassword'];
					}else{
						$pass = sha1($_POST['newPassowrd']);
					}

					// Validate The form

					$error_handler = array();

					if(empty($user)){
						$error_handler[]= 'username can\'t be empty';
					}

					if(strlen($user)<4 || strlen($user)>20){
						$error_handler[]= 'username should be between 4 and 20 charachters';
					}

					if(empty($email)){
						$error_handler[]= 'Email should not be empty';
					}

					if(empty($fullname)){
						$error_handler[]= " Fullname should not be empty";
					}

					foreach($error_handler as $error){

						echo "<div class= 'alert alert-danger'>" .  $error  . "</div>";
					}


					// check if there is no error proceed the update  operation

					if(empty($error_handler)){
					//Update the database with this info
						$stmt2 = $con->prepare("SELECT 
														*
												FROM
														shop.users
												WHERE 
														Username = ?
												AND
														UserID != ? ");
						$stmt2->execute(array($user, $id));

						$count = $stmt2->rowCount();

						if(($count) == 1) {

							echo "This user is already exicted ";

							$the_msg = ",Sorry";	
							redirect_home($the_msg, 'back', 4);
						} else{

							$stmt = $con->prepare("UPDATE shop.users SET Username= ?, Email= ?, Fullname= ?, Password= ? WHERE UserID= ?");
							$stmt->execute(array($user, $email, $fullname, $pass, $id));

							// Echo Success Meassage 

							$the_msg = "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD UPDATED</div>';

							redirect_home($the_msg, 'back',5 );

					    }

				}

			}else{

				$the_msg =" <div class = 'alert alert-danger'> YOU Man Get the Fuck out of here</div>";
				redirect_home($the_msg);
			}

			echo "</div>";


		}elseif ($do == 'Delete') { // delete  member page

			echo "<h1 class='text-center'>Delete member</h1>";

			echo "<div class='container'>";

				
				// Check if userid is there and numeric & get the integer vakue of it 

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

				// SElect all the data associated with this userid 

				$check = check_item('userid', 'shop.users', $userid);

				// If there such Id Delete it

				if($check > 0){
						
					$stmt = $con->prepare("DELETE FROM shop.users WHERE UserID = :zuser");

						$stmt->bindParam(":zuser" , $userid);

						$stmt->execute();

						$the_msg =  "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD DELETED</div>';

						redirect_home($the_msg);
				}else{

					$the_msg = "<div class='alert alert-danger'>bad bad</div>";
					redirect_home($the_msg);
					echo "</div>";
			}
			
		}elseif ($do == 'Activate') { // delete  member page

			echo "<h1 class='text-center'>Activate member</h1>";

			echo "<div class='container'>";

				
				// Check if userid is there and numeric & get the integer vakue of it 

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

				// SElect all the data associated with this userid 

				$check = check_item('userid', 'shop.users', $userid);

				// If there such Id Delete it

				if($check > 0){
						
					$stmt = $con->prepare("UPDATE shop.users SET Regstatus = 1 WHERE UserID = ?");

						$stmt->execute(array($userid));

						$the_msg =  "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD DELETED</div>';

						redirect_home($the_msg);
				}else{

					$the_msg = "<div class='alert alert-danger'>This ID is not exicted</div>";
					redirect_home($the_msg);
			}
			echo "</div>";
		}



		include $tpl . 'footer.php';

	}else{

		header('Location: index.php');

		exit();
	}
	?>