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
*//*
	Redirect function v2.0
	parameters : Echo the msg [Error | Succsess | Warning]
				 seconds befor redirecting 
				 URL = the link to redirect to 

*/

function redirect_home ($the_msg , $url = null,  $seconds = 3 ){

		if($url === null){

			$url ='index.php';

			$link = 'Homepage';
		}else{

			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ""){

			$url = $_SERVER['HTTP_REFERER'];

			$link =' Previous Page';
			}else{	

			$url = 'index.php';

			$link = 'Homepage';

		}
	}

	echo $the_msg;

	echo "<div class='alert alert-info'>You will be directed to $link after $seconds Seconds. </div>";

	header("refresh:$seconds;url=$url");

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

/*
	Function to count Items
*/
	function count_items ($item, $table){

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

		$stmt2-> execute();

		return $stmt2->fetchColumn(); 
	}