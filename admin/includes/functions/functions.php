<?php

/*
** Title function that echo the page title in case the page  
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