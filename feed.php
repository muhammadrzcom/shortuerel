<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include_once ( 'inc/load.php' );


			// catch token
			$checkToken = isset( $_GET['token'] ) && $_GET['token'] == $config['token'] ? true : false;

			// token
			$add_query = '';
			if ( $checkToken )
			     $add_query = ' WHERE private="" AND inactive=""';

			// grab data
			$data = $db->fetch( 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . $add_query . ' ORDER BY ID DESC LIMIT 0,20' );

			// start my feed
			$rss = new myFeed();
			$rss->setChannelTitle( $config['site_name'] . ' latest urls' );
			$rss->setChannelDesc( $config['site_name'] );
			$rss->setChannelGenerator( 'Shrinky Script' );
			$rss->setChannelTTL( 3600 );
			$rss->setChannelLink( $config['base_url'] );

			// items loop
			if ( count( $data ) > 0 ) {
			     foreach ( $data as $item ) {
			          $rss->setItemTitle( $config['base_url'] . $item['short'] );

			          $itemData = 'Hits: ' . $item['hits'] . "\r\n";
			          if ( $checkToken ) {
			               $ip = !empty( $item['ip'] ) ? $item['ip'] : '';
			               $itemData .= ' | IP: ' . $ip . "\r\n";
			               $itemData .= ' | URL: ' . htmlspecialchars_decode( $item['url'], ENT_NOQUOTES ) . "\r\n";
			          }
			          $itemData .= ' | VIA: ' . $item['via'];

			          $rss->setItemDesc( $itemData );
			          $rss->setItemLink( $config['base_url'] . $item['short'] );
			          $rss->setItemDate( $item['created'] );
			     }
			}

			// render feed
			echo $rss->showFeed();
