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
		
		}elseif($do == 'Edit'){

			// Edit page 
			echo 'welcome to edit page';
		}

		include $tpl . 'footer.php';

	}else{

		header('Location: index.php');

		exit();
	}