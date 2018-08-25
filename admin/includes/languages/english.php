<?php

	function lang ($phrase) {

		//Dashboard langs 

		static $lang = array(

			'HOME'			=>  'Home',
			'CATEGORIES' 	=>  'Categories',
			'ITEMS' 		=>  'Items',
			'MEMBERS' 		=>  'Members',
			'STATISTICS' 	=>  'Statistcs',
			'LOGS' 			=>  'Logs',
 
		);
			return $lang[$phrase];
		
	}
