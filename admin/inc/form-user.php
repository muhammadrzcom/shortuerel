<?php



			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include ( "../../inc/load.php" );

			// start myAuth
			$auth = new myAuth();
			$auth->setResource( 'mtro' );
			$auth->setGoodLanding( $config['base_url'] . 'admin/settings.php' );
			$auth->forceAuth(false);

			// if saving data
			if ( isset( $_POST['update'] ) && $auth->checkAuth() ) {

			     // catch data
			     $username = isset( $_POST['username'] ) ? core::sanitize( $_POST['username'] ) : false;
			     $password = isset( $_POST['current_password'] ) ? core::sanitize( $_POST['current_password'] ) : false;
			     $new_password = isset( $_POST['new_password'] ) ? core::sanitize( $_POST['new_password'] ) : false;
			     $repeat_password = isset( $_POST['repeat_password'] ) ? core::sanitize( $_POST['repeat_password'] ) : false;
                 
                 // require current password to allow changes   
			     $check = $config['password'] === md5( $password ) ? true : false;

			     if ( $check ) {
			          // prepare update array
			          $update = false;
			          $array = array();
			          if ( $username && is_string( $username ) && strlen( $username ) >= 4 && $username != $config['username'] ) {
			               $array['username'] = $username;
                           $update = true;
			          }
			          if ( $new_password === $repeat_password && strlen( $new_password ) >= 6 && md5( $new_password ) != $config['password'] ) {
			               $array['password'] = md5( $new_password );
			               $update = true;
			               $auth->deAuth();
			               $auth->setBadLanding( $config['base_url'] . 'admin/login.php' );
			          }

			          // update data
			          if ( $update )
			               $db->update( $array, $config['table_prefix'] . $config['table_settings'], 'ID="1"' );
			     }

			}

			// redirect
			$auth->redirect();
