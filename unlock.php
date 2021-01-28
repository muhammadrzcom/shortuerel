<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include_once ( 'inc/load.php' );

			// catch data
			$id = isset( $_GET['id'] ) ? core::sanitize( $_GET['id'] ) : false;
			$password = isset( $_POST['password'] ) ? core::sanitize( $_POST['password'] ) : false;

			// check session
			$session = new mySession();
			$session->setName( $id );
			$check_session = $session->get();

			// check session redir
			$session->setName( $id . '_redir' );
			$redir = $session->get();

			// avoid re-entry
			if ( $check_session ) {
			     header( 'Location: ' . $redir );
			     die();
			}

			// check for database
			$query = 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE BINARY short="' . $id . '"ORDER BY ID LIMIT 0,1';

			// check if url already exist
			$data = $db->fetch( $query );
			$check_password = isset( $data[0]['password'] ) && $data[0]['password'] != '' ? true : false;

			if ( !$check_password ) {
			     header( 'Location: ' . $config['base_url'] . $data[0]['short'] );
			     die();
			}

			// if password
			if ( $check_password && $password ) {

			     if ( $password === $data[0]['password'] ) {
			          $session->setName( $id );
			          $session->set( true );
			          header( 'Location: ' . $redir );
			          die();
			     }
			}

			// include html
			$template = $config['shrinky_template'];
			include_once ( 'inc/templates/'.$template.'/unlock.tpl' );
