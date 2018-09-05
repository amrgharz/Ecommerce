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
 		echo 'Welcome to items page';

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
										name="Description" 
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
										name="Price" 
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
										name="Country" 
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
								<select >
									<option value='0'>...</option>
									<option value='1'>New</option>
									<option value='2'>Like New</option>
									<option value='3'>Used</option>
									<option value='4'>Old</option>
								</select>
							</div>
						</div>
						<!-- End Of Status Field -->

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

 	}elseif ($do == 'Edit'){

 	}elseif ($do == 'Update'){

 	}elseif ($do == 'Delete'){

 	}elseif ($do == 'Approve'){

 	}

 	include $tpl . 'footer.php';

 } else {

 	header('Location: index.php');

 	exit ();
 }

 ?>