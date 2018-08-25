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

		if ($do == 'Manage ' ){

			// Manage Page
		
		}elseif($do == 'Edit'){// Edit page 

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
								<input type="text" name="username" class="form-control" value = "<?php echo $row['Username']?>" autocomplete="off" />
								<input type="hidden" name="userid" value="<?php echo $userid?>">
							</div>
						</div>
						<!-- End Of USername Field -->
						<!-- Start password Field -->
						<div class="form-group  form-group-lg">
							<label class="col-sm-2 control-label">Passowrd</label>
							<div class="col-sm-10">
								<input type="Passowrd" name="Passowrd" class="form-control" autocomplete="new-password" />
							</div>
						</div>
						<!-- End Of Password Field -->
						<!-- Start email Field -->
						<div class="form-group form-group-lg ">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="email" name="email" class="form-control" value = "<?php echo $row['Email']?>"/>
							</div>
						</div>
						<!-- End Of email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10">
								<input type="text" name="fullname" class="form-control" value = "<?php echo $row['Fullname']?>"/>
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

				echo 'there is no such id ';
			}
		}elseif ($do == 'Update' ){ //Update Page

			echo "<h1 class='text-center'>Update Page</h1>";

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				// Get the variables From the Form 

				$id        	= $_POST['userid'];
				$user      	= $_POST['username'];
				$email 	   	= $_POST['email'];
				$fullname  	= $_POST['fullname'];

				//Update the database with this info

				$stmt = $con->prepare("UPDATE shop.users SET Username= ?, Email= ?, Fullname= ? WHERE UserID= ?");
				$stmt->execute(array($user, $email, $fullname, $id));

				// Echo Success Meassage 

				echo $stmt->rowCount() . ' RECORD UPDATED';

			}else{

				echo " YOU Man Get the Fuck out of here";
			}


		}



		include $tpl . 'footer.php';

	}else{

		header('Location: index.php');

		exit();
	}
	?>