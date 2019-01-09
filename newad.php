<?php 

session_start();

$get_title = 'Create New Item';

include 'init.php'; 


if (isset($_SESSION['user'])){ 

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		$form_errors = array();

		$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$desc 		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
		$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
		$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
		$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

		if (strlen($name) < 4){

			$form_errors [] = 'Item Tiltle Must Be At Least 4 Charechtars';
		}

		if (strlen($desc) < 4){

			$form_errors [] = 'Item Description Must Be At Least 10 Charechtars';
		}


		if (strlen($country) < 4){

			$form_errors [] = 'Item Country Must Be At Least 4 Charechtars';
		}

		if (empty($price)){

			$form_errors [] = 'Item Price Must Not Be Empty';
		}

		if (empty($status)){

			$form_errors [] = 'Item Status Must Not Be Empty';
		}

		if (empty($category)){

			$form_errors [] = 'Item Category Must Not Be Empty';
		}

		if(empty($form_errore)){

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
					'zmember'	=> $_SESSION['uid'],
					'zcat'		=> $category
					));


					// Echo Success Meassage 

					if($stmt){
						echo "Your Item Has Been Inserted Successfully";
					}
				}


	}
?>
<h1 class="text-center"> <?php echo $get_title ?></h1>

<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">  <?php echo $get_title ?></div>
			<div class="panel-body">
				<div class='row'>
					<div class='col-md-8'>
						<form class="form-horizontal main-form" action=<?php echo $_SERVER['PHP_SELF'] ?> method= "POST">
							<!-- Start Name Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input 	type="text" 
											name="name" 
											class="form-control live" 
											required="required" 
											placeholder="Name of the Item"
											data-class= '.live-title'
									/>
								</div>
							</div>
							<!-- End Of Name Field -->
							<!-- Start Description Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10 ">
									<input 	type="text"
											name="description" 
											class="form-control live" 
											required="required" 
											placeholder="Descripe the new Item"
											data-class= '.live-desc'
									/>
								</div>
							</div>
							<!-- End Of Description Field -->

							<!-- Start Price Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label ">Price</label>
								<div class="col-sm-10">
									<input 	type="text"
											name="price" 
											class="form-control live" 
											required="required" 
											placeholder="The price of the Item"
											data-class = '.live-price'
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
											required="required" 
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
										<option value=''>...</option>
										<option value='1'>New</option>
										<option value='2'>Like New</option>
										<option value='3'>Used</option>
										<option value='4'>Old</option>
									</select>
								</div>
							</div>
							<!-- End Of Status Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-10">
									<select name="category">
										<option value=''>...</option>
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
									<input type="submit" value='Add Item' class="btn btn-primary btn btn-sm" />
								</div>
							</div>
							<!-- End Of Save Field -->
						</form>
					</div>
					<div class='col-md-4'>
						<div class='thumbnail item-box live-preview'>
							<span class='price-tag'>$<span class='live-price'></span></span>
							<img class='img-responsive' src='img.jpg' alt=''>
							<div class='caption'>
								<h3 class='live-title'>Title</h3>
								<p  class='live-desc'>Description</p>
							</div>
						</div>
					</div>
				</div>
				<!-- Start Looping Through Errors -->
				<?php if (!empty($form_errors)){
					foreach($form_errors as $error){
						echo "<div class= 'alert alert-danger '>" . $error . "</div>";					}

				}?>
				<!-- End Looping Through Errors -->
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