<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title> <?php echo $get_title?></title>
		<link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $css;?>jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo $css;?>jquery.selectBoxIt.css" />
		<link rel="stylesheet" href="<?php echo $css;?>front.css" />
	</head>
	<body>	
		<div class="upper-bar">
			<div class="container">
				<?php 
					if (isset($_SESSION['user'])){

						echo "welcome " . $session_user . ' ';

						echo '<a href="profile.php">My Profile</a>' . '  ';

						echo '<a href="logout.php"> Log Out</a>';

						echo '<a href="newad.php"> New Item</a>';

						$user_status = check_reg_status($session_user);

						if ($user_status == 1){

							// User Is Not Activated 

						}

					}else{

				?>
				<a href='login.php'>
					<span class='pull-right'>Login/Sign Up</span>
				</a>
 				<?php } ?>

			</div>
		</div>
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php>">Homepage</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="app-nav">
		      <ul class="nav navbar-nav  navbar-right">
		       <?php

		       	foreach (get_cats() as $cat){
		       		echo 
		       			'<li>
		       				<a href="categories.php?pageid= ' . $cat['ID']. ' "> ' . $cat['Name'] . ' </a>
		       			</li>';
		       	}

		        ?>
		      </ul>
		    </div>
		  </div>
		</nav>