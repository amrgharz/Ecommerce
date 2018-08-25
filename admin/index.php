<?php
	session_start();
	$noNavbar = '';
	$get_title = 'login';
	if(isset($_SESSION['Username'])){
	
		header('Location: dashboard.php');
	};	
	include 'init.php';
	include $tpl . 'header.php' ;

	//Check If User is coming from http post request 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedpass = sha1($password);

		// check if user exicts in database

		$stmt = $con->prepare("SELECT
										UserID, Username, Password
								FROM 
										shop.users
								WHERE 
										Username = ? 
								AND 
										Password = ? 
								AND
										GroupID = 1
								LIMIT 1");
		$stmt->execute(array($username, $hashedpass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		// If the count > 1 that means the database has record about this user

		if ($count> 0){
			$_SESSION['Username'] = $username; // Register Session name
			$_SESSION['UserID'] = $row['UserID'];  // Regester Session ID 
			header('location: dashboard.php'); // redirect to dashboard page
			exit();
		}
	}
?>


  
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" >
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off"/>
		<input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-lg btn-primary btn-block" type="submit" value="login"/>
	</form>

<?php
	include $tpl . 'footer.php';
?>