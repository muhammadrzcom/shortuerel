<?php



			
			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include ( "../../inc/load.php" );

			// auth
			$auth = new myAuth();
			$auth->setResource( 'mtro' );
			$auth->setBadLanding( $config['base_url'] . 'admin/login.php' );
			$auth->setGoodLanding( $_SERVER['HTTP_REFERER'] );
			$auth->forceAuth( false );


			// if saving data
			if ( isset( $_POST['save'] ) && $auth->checkAuth() ) {

			     // catch data
			     $id = isset( $_POST['id'] ) ? core::sanitize( $_POST['id'] ) : false;
			     $action = isset( $_POST['action'] ) ? core::sanitize( $_POST['action'] ) : 'edit';
			     $ip = isset( $_POST['ip'] ) && core::validateIP( $_POST['ip'] ) && $_POST['ip']!='0.0.0.0' ? core::sanitize( $_POST['ip'] ) : false;
			     $description = isset( $_POST['description'] ) ? core::sanitize( $_POST['description'] ) : false;

			     // prepare update array
			     $update = array();
			     if ( $ip )
			          $update['ip'] = $ip;

			     if ( $description )
			          $update['description'] = $description;
                      
			     $update['date'] = date( 'Y-m-d H:i:s', time() );

			     // update data
			     if ( $id && $action == 'edit' ) {
			          $db->update( $update, $config['table_prefix'] . $config['table_clients'], 'ID="' . $id . '"' );
			     }
			     if ( $ip && $action == 'new') {
			          $auth->setGoodLanding( $config['base_url'] . 'admin/clients.php' );
			          $db->insert( $update, $config['table_prefix'] . $config['table_clients'] );
			     }
			}

			// redirect
			$auth->redirect();
