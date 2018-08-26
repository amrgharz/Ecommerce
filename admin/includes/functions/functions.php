<?php

/*
** Title function v1.0
** that echo the page title in case the page  
** Has the variable $pageTitle and Echo Default title for other pages 
*/

function get_title (){

	global $page_title;

	if(isset($pagetitle)){
		echo "$page_title";

	}else{

		echo "Default";
	};
};

/*
	Home Redirect Function v1.0
	Parameters ([Echo the error message], [Seconds before Redirecting])
*/

function redirect_home ($error_msg , $seconds = 3 ){

	echo "<div class='alert alert-danger'>$error_msg</div>";

	echo "<div class='alert alert-info'>You will be directed to the home page after $seconds Seconds. </div>";

	header("refresh:$seconds;url=index.php");

	exit();
}

/*
	Check Items Function v1.0 function name (param1,param2,param3)
	Function to check Items in the database 
	parameters: $select = item to select [Example: users, item, categories]
				$from   = table to select from [Example: users, items, categories]
				$value = The vaalue of select [Example: amr, phone , electronics]
*/

function check_item($select, $from, $value){

	global $con;

	$statement = $con->prepare("SELECT $select FROM $from WHERE $select= ?");

	$statement->execute(array($value));

	$count = $statement->rowCount();

	return $count;
}