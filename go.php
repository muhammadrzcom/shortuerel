<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include_once ( 'inc/load.php' );
			$template = $config['shrinky_template'];

			// catch the id or custom id
			$id = isset( $_GET['id'] ) ? core::sanitize( $_GET['id'] ) : false;

			// proccedd
			if ( isset( $id ) ) {

			     // check for database
			     $query = 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE BINARY short="' . $id . '"ORDER BY ID LIMIT 0,1';

			     // check if url already exist
			     $data = $db->fetch( $query );

			     // procced
			     if ( isset( $data[0]['ID'] ) ) {

			          $data = $data[0];

			          // user is logged reach url faster!
			          if ( $is_admin ) {
			               header( 'HTTP/1.1 301 Moved Permanently' );
			               header( 'Location: ' . htmlspecialchars_decode( $data['url'], ENT_NOQUOTES ) );
			               die();
			          }

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
			               $remove = true;
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
			                    $session->set( $config['base_url'] . $data['short'] );
			                    header( 'Location:' . $config['base_url'] . $data['short'] . '/unlock' );
			                    die();
			               }
			          }

			          // update
			          $update = array();
			          $update['hits'] = $data['hits'] + 1;
			          $update['last'] = date( 'Y-m-d H:i:s' );
			          $update['uses'] = $remove ? $data['uses'] - 1 : $data['uses'];

			          // update hits and last visit
			          $db->update( $update, $config['table_prefix'] . $config['table_name'], 'ID="' . $data['ID'] . '"' );

			          // if ads are disabled
			          if ( !$ads ) {

			               // google tracking
			               $tracking = new myTracking( $config['google_tracking'] );
			               $tracking->track( $config['domain'] . $data['ID'] );

			               // redirect and end
			               header( 'HTTP/1.1 301 Moved Permanently' );
			               header( 'Location: ' . htmlspecialchars_decode( $data['url'], ENT_NOQUOTES ) );
			               die();
			          }

			          // check if url already exist
			          $ads = $db->fetch( 'SELECT * FROM ' . $config['table_prefix'] . $config['table_ads'] .
			               ' WHERE inactive="" AND ( views <= max-1 OR max="" ) ORDER BY RAND() ASC LIMIT 0,1' );
			          if ( isset( $ads[0]['url'] ) ) {
			               $ads_url = $ads[0]['url'];
			               $db->update( array( 'views' => $ads[0]['views'] + 1 ), $config['table_prefix'] . $config['table_ads'], 'ID="' . $ads[0]['ID'] . '"' );
			          } else {
			               $ads_url = $config['default_ad'];
			          }
			          include ( 'inc/templates/'.$template.'/ads.tpl' );
			          die();
			     }

			     // invalid id
			     header( 'HTTP/1.0 404 Not Found' );
			     $msg = 'Invalid ID';
			     include ( 'inc/templates/'.$template.'/error.tpl' );
			}
