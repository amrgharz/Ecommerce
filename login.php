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

		if(isset($_POST['login'])){

		 	$user = $_POST['username'];
		 	$pass = $_POST['password'];
		 	$hashed_pass = sha1($pass);

		 	// Check If The User Exist In The DataBase

		 	$stmt = $con->prepare("SELECT
		 								UserID, Username, Password
		 						    From
		 						    	shop.users
		 						    WHERE
		 						    	Username = ?
		 						    AND
		 						    	Password = ?");
		 	$stmt->execute(array($user , $hashed_pass));

		 	$get =  $stmt->fetch();

		 	$count = $stmt->rowCount();

		 	// If Count Is > 0 That means there is record in the db related to this user.

		 	if ($count > 0 ){

		 		$_SESSION['user'] = $user; //Register session name

		 		$_SESSION['uid']  = $get['UserID']; // Register User ID 
		 		
		 		header('Location: index.php'); // Redirect To Dashboard Page

		 		exit();
		 	}
		}else{

			$form_errors = array();

			$username 	= $_POST['username'];
			$password 	= $_POST['password'];
			$password2 	= $_POST['password2'];
			$email 		= $_POST['email'];

			if(isset($username)){

				$filtered_user = filter_var($username, FILTER_SANITIZE_STRING);

				if (strlen($filtered_user) < 4 ){

					$form_errors [] = 'Username must be larger than 4 charecters';

				}
			}
			if(isset($password) &&  isset($password2)){

				if (empty($password)){

					$form_errors [] = 'Sorry Password can not be empty';
				}

				if ( sha1($password) !== sha1($password2) ){

					$form_errors [] = 'Passwords are not matched';
				}

			}

			if(isset($email)){

				$filtered_email = filter_var ($email, FILTER_SANITIZE_EMAIL );

				if(filter_var($filtered_email, FILTER_VALIDATE_EMAIL ) != true){

					$form_errors [] = 'This Eail Is Not Valid';
				}
			}

			//Check If There IS No Error Porceed To The DataBase

			if(empty($form_errors)){

				//Check If The User Exists In The DataBase

				$check = check_item("Username", "shop.users", $username);

				if ($check == 1 ){

					$form_errors [] = 'Sorry This User is already exist';
				
				}else{

				// Insert The User Info Inside The DataBase

				$stmt = $con->prepare("INSERT INTO shop.users(Username, Password, Email, RegStatus, Date)
										VALUES(:zuser, :zpass, :zmail, 0, now())");
				$stmt->execute(array(

							'zuser' => $username,
							'zpass' => sha1($password),
							'zmail' => $email
						));
				// Echo success message

					$success_msg = 'Congarts, Now You are registered user';
				}
			}
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
			<input class='btn btn-primary btn-block' type='submit' name='login' value='Login' />
		</div>
	</form>
	<form class='signup' action= "<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
		
		<div class='input-container'> 
			<input 	pattern=".{4,}"
					title="Username must be more than 4 chars" 
					class='form-control' 
					type='text' 
					name='username' 
					autocomplete= 'off' 
					placeholder="Username" 
					required/>
		</div>
		<div class='input-container'>
			<input 
					class='form-control' 
					type='email' 
					name='email' 
					autocomplete="off" 
					placeholder="Email" 
				     />
		</div>
		<div class='input-container'>
			<input 
					minlength="4" 
					class='form-control' 
					type='password' 
					name='password' 
					autocomplete='new-password' 
					placeholder="Password" 
					required/>
		</div>
		<div class='input-container'>
			<input 
					minlength="4" 
					class='form-control' 
					type='password' 
					name='password2' 
					autocomplete='new-password' 
					placeholder="Re-type Password" 
					required />
		</div>
		<div class='input-container'>
			<input class='btn btn-primary btn-block' type='submit' name='signup' value='SignUp' />
		</div>

	</form>
	<div class='errors text-center'>
		<?php

			if(!empty($form_errors)){

				foreach ($form_errors as $error) {

					echo $error . '<br>';

				}

			}else{

				if(isset($success_msg)){

				echo "<h3 class = 'msg success'>" . $success_msg. "</h3>";
				}
			}
		 ?>
	</div> 

</div>


<?php include $tpl . 'footer.php'; ?>