<?php



			
			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include ( "../inc/load.php" );

			// auth
			$auth = new myAuth();
			$auth->setResource( 'mtro' );
			$auth->setBadLanding( 'login.php' );
			$auth->checkAuth();
			$auth->forceAuth( false );
			$auth->redirect();

			// basic dashboard data
			$total_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] );
			$total_urls = $total_urls[0]['TOTAL'];

			$today_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] .
			     ' WHERE DATE(created) = DATE(CURDATE())' );
			$today_urls = $today_urls[0]['TOTAL'];

			$total_hits = $db->fetch( 'SELECT SUM(hits) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] );
			$total_hits = $total_hits[0]['TOTAL'] ? $total_hits[0]['TOTAL'] : 0;

			$total_ads = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_ads'] . ' WHERE inactive=""' );
			$total_ads = $total_ads[0]['TOTAL'];


			// lastest urls
			$urls = $db->fetch( 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' ORDER BY ID DESC LIMIT 0,8' );
			$urls = isset( $urls[0]['ID'] ) ? $urls : false;

			include ( 'inc/templates/index.tpl' );
