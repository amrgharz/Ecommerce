<?php

	include 'connect.php';
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

	//include navbar in all pages except the pages that have $noNavbar

	if(!isset($noNavbar)){include $tpl . 'navbar.php';}

	