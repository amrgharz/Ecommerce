<?php

/*
=======================================================
--Manage Comments page
--Here you can add | edit | delete Comments
=======================================================
*/

session_start();
	$get_title = 'Comments';

	if(isset($_SESSION['Username'])){

		include 'init.php';
 
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		// Start manage page 

		if ($do == 'Manage' ){

				//select all users except admin

			$stmt = $con->prepare("SELECT 	
											shop.comments.*, shop.items.Name AS Item_Name, shop.users.Username AS Member
									FROM
											shop.comments
									INNER JOIN
											shop.items
									ON
											shop.items.Item_ID = shop.comments.Item_ID
									INNER JOIN 
											shop.users
									ON 
											shop.users.UserID = shop.comments.User_ID
									ORDER BY 
											C_ID DESC");

			   // Excute The Satment

			$stmt->execute();

				// Assign to variable

			$rows = $stmt->fetchAll();

			if (!empty ($rows)){

			?>

			<h1 class="text-center">Manage Commetns</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Add Date</td>
							<td>Control</td>
						</tr>

						<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['C_ID'] . "</td>";
									echo "<td>" . $row['Comment'] . "</td>";
									echo "<td>" . $row['Item_Name'] . "</td>";
									echo "<td>" . $row['Member'] . "</td>";
									echo "<td>" . $row['Comment_Date']  .  "</td>";
									echo "<td> 
												<a href='comments.php?do=Edit&comid=" . $row["C_ID"] . "' class='btn btn-success'><i class ='fa fa-edit'></i>Edit</a>
												<a href='comments.php?do=Delete&comid=" . $row['C_ID'] . "' class='btn btn-danger confirm'><i class ='fa fa-close'></i>Delete</a>";

												if($row['Status'] == 0){

													echo "<a href='comments.php?do=Approve&comid=" . $row['C_ID'] . "' class='btn btn-info'><i class ='fa fa-check'></i>Approve</a>";

												}
									echo "</td>";
								echo "</tr>";
							}
						?>
					</table>
				</div>
				<?php } else {

				echo "<div class='container'>";
					echo "<div class='alert alert-info'>There's No record </div> ";
				echo "</div>";		
		} ?>
			</div>

		<?php
				
		}elseif($do == 'Edit'){// Edit page 

			// Check if get request userid is numeric and get the integer value of it 

			$comid =  isset ($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) :  0;

			// Select all Data of this ID

			$stmt = $con->prepare("SELECT * FROM shop.comments WHERE C_ID= ?");

			// EXecute Query

			$stmt->execute(array($comid));

			//Fech the data

			$row = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			//If there is Id show the form 

			if ($count > 0){ ?>
			
				<h1 class="text-center ">Edit Comment</h1>

				<div class="container">
					<form class="form-horizontal" action= "?do=Update" method= "POST">
						<input type='hidden' name='comid' value="<?php echo $comid ?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Comment</label>
							<div class="col-sm-10">
								<textarea class='form-control' name='comment'><?php echo $row['Comment']?></textarea>
							</div>
						</div>
						<!-- End Of USername Field -->	
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

					$comid        	= $_POST['comid'];
					$comment      	= $_POST['comment'];

					//Update the database with this info

					$stmt = $con->prepare("UPDATE shop.comments SET comment= ? WHERE C_ID= ?");
					$stmt->execute(array($comment, $comid));

					// Echo Success Meassage 

					$the_msg = "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD UPDATED</div>';

					redirect_home($the_msg, 'back',5 );


			}else{

				$the_msg =" <div class = 'alert alert-danger'> YOU Man Get the Fuck out of here</div>";
				redirect_home($the_msg);
			}

			echo "</div>";


		}elseif ($do == 'Delete') { // Delete Comment page

			echo "<h1 class='text-center'>Delete Comment</h1>";

			echo "<div class='container'>";

				
				// Check if userid is there and numeric & get the integer vakue of it 

				$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

				// SElect all the data associated with this userid 

				$check = check_item('C_ID', 'shop.comments', $comid);

				// If there such Id Delete it

				if($check > 0){
						
					$stmt = $con->prepare("DELETE FROM shop.comments WHERE C_ID = :zid");

						$stmt->bindParam(":zid" , $comid);

						$stmt->execute();

						$the_msg =  "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD DELETED</div>';

						redirect_home($the_msg, 'back');
				}else{

					$the_msg = "<div class='alert alert-danger'>bad bad</div>";
					redirect_home($the_msg);
					echo "</div>";
			}
			
		}elseif ($do == 'Approve') { // delete  member page

			echo "<h1 class='text-center'>Activate member</h1>";

			echo "<div class='container'>";

				
				// Check if userid is there and numeric & get the integer vakue of it 

				$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

				// SElect all the data associated with this userid 

				$check = check_item('C_ID', 'shop.comments', $comid);

				// If there such Id Delete it

				if($check > 0){
						
					$stmt = $con->prepare("UPDATE shop.comments SET Status = 1 WHERE C_ID = ?");

						$stmt->execute(array($comid));

						$the_msg =  "<div class= 'alert alert-success'>" . $stmt->rowCount() . ' RECORD APPROVED</div>';

						redirect_home($the_msg, 'back');
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