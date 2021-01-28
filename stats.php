<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			
            // load the system
			include_once ( 'inc/load.php' );
			$template = $config['shrinky_template'];

			// catch data
			$id = isset( $_GET['id'] ) ? core::sanitize( $_GET['id'] ) : false;
			$password = isset( $_POST['password'] ) ? core::sanitize( $_POST['password'] ) : false;

			// check for database
			$query = 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE BINARY short="' . $id . '"ORDER BY ID LIMIT 0,1';

			// basic stats data
			$total_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] . $add_query );
			$total_urls = $total_urls[0]['TOTAL'];

			$today_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] .
			     ' WHERE DATE(created) = DATE(CURDATE())' );
			$today_urls = $today_urls[0]['TOTAL'];

			$total_hits = $db->fetch( 'SELECT SUM(hits) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] );
			$total_hits = $total_hits[0]['TOTAL'] ? $total_hits[0]['TOTAL'] : 0;


			// check if url already exist
			$data = $db->fetch( $query );
			if ( isset( $data[0]['ID'] ) && $data[0]['ID'] != '' ) {

			     $data = $data[0];

			     // quick checks
			     $inactive = $data['inactive'] == 1 ? true : false;
			     $expire = $data['expire'] != '0000-00-00 00:00:00' ? true : false;
			     $uses = $data['uses'] != '' ? true : false;
			     $password = $data['password'] != '' ? true : false;
			     $ads = $config['use_ads'] == true && $data['ads'] == 1 ? true : false;
			     $remove = false;

			     // if url is inactive
			     if ( $inactive ) {
			          $msg = 'This Url is inactive';
			     }

			     // expired
			     if ( $expire ) {
			          $diff = strtotime( $data['expire'] ) - time();
			          if ( $diff <= 0 ) {
			               $msg = 'This Url has expired';
			          }
			     }

			     // uses
			     if ( $uses ) {
			          if ( $data['uses'] == 0 ) {
			               $msg = 'Number of clicks ran out!';
			          }
			     }

			     // handle errors
			     if ( isset( $msg ) ) {
			          include ( 'inc/templates/'.$template.'/error.tpl' );
			          die();
			     }

			     // password protected?
			     $session = new mySession();
			     $session->setName( $id );
			     $check_session = $session->get() ? true : false;
			     if ( !$check_session ) {
			          if ( $password ) {
			               $session->setName( $id . '_redir' );
			               $session->set( $config['base_url'] . $data['short'] . '/stats' );
			               header( 'Location:' . $config['base_url'] . $data['short'] . '/unlock' );
			               die();
			          }
			     }
			     include_once ( 'inc/templates/'.$template.'/stats.tpl' );
			} else {
			     // invalid id
			     header( 'HTTP/1.0 404 Not Found' );
			     $msg = 'Invalid ID';
			     include ( 'inc/templates/'.$template.'/error.tpl' );
			}
