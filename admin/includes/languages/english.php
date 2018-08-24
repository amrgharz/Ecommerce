<?php

	function lang ($phrase) {

		//Dashboard langs 

		static $lang = array(

			'HOME'			=>  'Home',
			'CATEGORIES' 	=>  'categories',
			'ITEMS' 		=>  'items',
			'MEMBERS' 		=>  'members',
			'STATISTICS' 	=>  'statistcs',
			'LOGS' 			=>  'logs',
 
		);
			return $lang[$phrase];
		
	}
