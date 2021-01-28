<?php



			
			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			// load the config
			include_once ( 'inc/load.php' );
	$template = $config['shrinky_template'];
            include_once ( 'inc/templates/'.$template.'/developer.tpl');