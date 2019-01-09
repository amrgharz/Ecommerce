<?php

	// Error Reborting

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	include 'admin/connect.php';

	$session_user= '';
	if (isset($_SESSION['user'])){
		$session_user = $_SESSION['user'];
	}
	//Routs

	$tpl = 'includes/templates/'; // Template Directory

	$css = 'layout/css/'; // Css Directory

	$js = 'layout/js/'; // JavaScript Directory

	$lang = 'includes/languages/'; //Language Directory 

	$func = 'includes/functions/'; // Functions directory 

	// include the important files

	include $func . 'functions.php';

	include $lang . 'english.php';

	include $tpl . 'header.php';
?>
	