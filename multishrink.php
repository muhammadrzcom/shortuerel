<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			// load the config
			include ( 'inc/load.php' );

			// catch data
			$urls = isset( $_POST['urls'] ) ? core::sanitize( $_POST['urls'] ) : false;
			$getPassword = isset( $_POST['password'] ) && $_POST['password'] != '' && strlen( $_POST['password'] ) <= 10 ? core::sanitize( $_POST['password'] ) : null;
			$getUses = isset( $_POST['uses'] ) && is_numeric( $_POST['uses'] ) && $_POST['uses'] > 0 && $_POST['uses'] <= 1000000 ? core::sanitize( $_POST['uses'] ) : null;
			$getExpire = isset( $_POST['expire'] ) && core::validateDate( $_POST['expire'] ) ? date( 'Y-m-d H:i:s', strtotime( $_POST['expire'] ) ) : null;
			$getPrivate = isset( $_POST['private'] ) ? 1 : null;
			$getDownload = isset( $_POST['download'] ) ? true : false;

			

			// basic stats data
			$total_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] . $add_query );
			$total_urls = $total_urls[0]['TOTAL'];

			$today_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] .
			     ' WHERE DATE(created) = DATE(CURDATE())' );
			$today_urls = $today_urls[0]['TOTAL'];

			$total_hits = $db->fetch( 'SELECT SUM(hits) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] );
			$total_hits = $total_hits[0]['TOTAL'] ? $total_hits[0]['TOTAL'] : 0;


			$new_urls = '';
			// if have text to work
			if ( $urls ) {
			     $urls = core::getAllUrls( $urls );
			     $urls = array_unique( $urls );
			     $urls = isset( $config['multi_max'] ) && is_numeric( $config['multi_max'] ) ? array_slice( $urls, 0, $config['multi_max'] ) : $urls;

			     // if have urls
			     if ( count( $urls ) > 0 ) {
			          $short_urls = array();
			          foreach ( $urls as $url ) {
                           if (! is_banned_domain( $url ) ){
    			               $id = makeurl( resolve_url( $url ) , null, 'multi', $getPassword, $getUses, $getExpire, $getPrivate );
                               $data = getDataFromId( $id );
			                   $short_urls[] = $config['base_url'] . $data['short'];
                           }
			          }

			          // separate short urls
			          $new_urls = implode( "\r\n", $short_urls );

			          // download
			          if ( $getDownload ) {
			               header( 'Content-type: text/plain' );
			               header( 'Content-Disposition: attachment; filename="multishrink-urls[' . count( $short_urls ) . '].txt"' );
			               echo $config['site_name'] . "\r\n";
			               echo 'Created: ' . date( 'Y-m-d H:i:s' ) . "\r\n";
			               echo '---------------------------' . "\r\n";
			               echo 'Total urls: ' . count( $short_urls ) . "\r\n";
			               echo isset( $getPassword ) ? 'Password: ' . $getPassword . "\r\n" : '';
			               echo isset( $getUses ) ? 'Max uses: ' . $getUses . "\r\n" : '';
			               echo isset( $getExpire ) ? 'Expires: ' . $getExpire . "\r\n" : '';
			               echo isset( $getPrivate ) ? 'Private urls ' . "\r\n" : 'Public urls' . "\r\n";
			               echo '---------------------------' . "\r\n";
			               echo $new_urls . "\r\n";
			               echo '---------------------------';
			               exit;
			          }
			     }
			}
			$template = $config['shrinky_template'];
			include ( 'inc/templates/'.$template.'/multishrink.tpl' );
