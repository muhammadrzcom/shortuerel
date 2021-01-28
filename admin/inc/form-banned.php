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
			     $host = isset( $_POST['host'] ) && core::validateUrl( $_POST['host'] ) ? core::sanitize( $_POST['host'] ) : false;
			     $name = isset( $_POST['name'] ) ? core::sanitize( $_POST['name'] ) : false;

			     // prepare update array
			     $update = array();
			     if ( $host ) {
			          $host = parse_url( $host );
			          $host = $host['host'];
			          $update['host'] = $host;
			     }

			     if ( $name )
			          $update['name'] = $name;
			     $update['date'] = date( 'Y-m-d H:i:s', time() );

			     // update data
			     if ( $id && $action == 'edit' ) {
			          $db->update( $update, $config['table_prefix'] . $config['table_domains_banned'], 'ID="' . $id . '"' );
			     }
			     if ( $action == 'new' && $host ) {
			          $auth->setGoodLanding( $config['base_url'] . 'admin/banned.php' );
			          $db->insert( $update, $config['table_prefix'] . $config['table_domains_banned'] );
			     }
			}

			// redirect
			$auth->redirect();
