<?php
	
	session_start();
	$get_title = 'Dashboard';

	if(isset($_SESSION['Username'])){

		include 'init.php';

		print_r ($_SESSION);

		include $tpl . 'footer.php';

	}else{

		header('Location: index.php');

		exit();
	}