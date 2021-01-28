<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			// load the config
			include ( 'load.php' );

			// set correct headers
			header( 'Content-type: application/json' );

			// allow crossdomain serving
			header( 'Access-Control-Allow-Origin: *' );

			// print response
			echo json_encode( array( 'success' => true, 'version' => SHRINKY_VERSION ) );
