<?php

session_start();
$get_title = 'login';

if (isset($_SESSION['user'])){
	header('location: index.php');
}
 // Redirect to Dashboard Page

 include 'init.php'; 

    // Check If User Coming From HTTP Post Request

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	 	$user = $_POST['username'];
	 	$pass = $_POST['password'];
	 	$hashed_pass = sha1($pass);

	 	// Check If The User Exist In The DataBase

	 	$stmt = $con->prepare("SELECT
	 								Username, Password
	 						    From
	 						    	shop.users
	 						    WHERE
	 						    	Username = ?
	 						    AND
	 						    	Password = ?");
	 	$stmt->execute(array($user , $hashed_pass));

	 	$count = $stmt->rowCount();

	 	// If Count Is > 0 That means there is record in the db related to this user.

	 	if ($count > 0 ){

	 		$_SESSION['user'] = $user; //Register session name
	 		
	 		header('Location: index.php'); // Redirect To Dashboard Page

	 		exit();
	 	}
	}
?>


<div class="container  login-page">
	<h1 class='text-center'>
		<span class='selected' data-class='login'>Login</span> | <span data-class='signup'> SignUp</span>
	</h1>
	<form class='login' action="<?php echo $_SERVER['PHP_SELF']?>" method='POST'>
		
		<div class="input-container">
			<input class='form-control' type='text' name='username' autocomplete= 'off' placeholder="Username" required />
		</div>
		<div class="input-container">
			<input class='form-control' type='password' name='password' autocomplete='new-password' placeholder="Password" required />
		</div>
		<div class="input-container">
			<input class='btn btn-primary btn-block' type='submit' value='Login' />
		</div>
	</form>
	<form class='signup'>
		
		<input class='form-control' type='text' name='username' autocomplete= 'off' placeholder="Username" />
		<input class='form-control' type='email' name='email' autocomplete="off"/ placeholder="Email">
		<input class='form-control' type='password' name='passowrd' autocomplete='new-password' placeholder="Password" />
		<input class='btn btn-primary btn-block' type='submit' value='SignUp' />

	</form>


</div>

<?php include $tpl . 'footer.php'; ?>