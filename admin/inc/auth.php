<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include ( "../../inc/load.php" );

			// catch
			$username = isset( $_POST['username'] ) ? core::sanitize( $_POST['username'] ) : '';
			$password = isset( $_POST['password'] ) ? core::sanitize( $_POST['password'] ) : '';

			// auth
			$auth = new myAuth();
			$auth->setResource( 'mtro' );
    		$auth->setTimeout( 900 );
			$successful_login = $config['base_url'].'admin/index.php';
			$auth->setGoodLanding( $successful_login );
            $auth->setBadLanding( '../login.php' );
            $auth->forceAuth(false);
            

			// prepare to serve json data
			header( 'Content-type: application/json' );

			// if values are different from database die
			if ( $username != $config['username'] || md5( $password ) != $config['password'] ) {

			     // json data
			     $response = array( 'success' => false );

			     // print output
			     print json_encode( $response );

			     // redirect 
			     $auth->redirect();

			}

			// make authorization for user
			$auth->makeAuth( $username );

			// set OK response
			$response = array( 'success' => true, 'redir' => $successful_login );

			// print response
			print json_encode( $response );

			// redirect (will redirect only on non ajax calls)
			$auth->redirect();
