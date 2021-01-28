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
			$auth->forceAuth(false);

			// if saving data
			if ( isset( $_POST['save'] ) && $auth->checkAuth() ) {

			     // catch data
			     $id = isset( $_POST['id'] ) ? core::sanitize( $_POST['id'] ) : false;
                 $action = isset( $_POST['action'] ) ? core::sanitize( $_POST['action'] ) : 'edit';
			     $url = isset( $_POST['url'] ) && core::validateUrl( $_POST['url'] ) ? core::sanitize( $_POST['url'] ) : false;
			     $title = isset( $_POST['title'] ) ? core::sanitize( $_POST['title'] ) : false;
			     $max = isset( $_POST['max'] ) && $_POST['max'] > 0 && $_POST['max'] < 1000000 ? core::sanitize( $_POST['max'] ) : null;
			     $inactive = isset( $_POST['active'] ) && $_POST['active'] == 1 ? 1 : '';

			     // prepare update array
			     $update = array();
			     if ( $url )
			          $update['url'] = $url;
			     if ( $title )
			          $update['title'] = $title;
			     $update['max'] = $max;
			     $update['inactive'] = $inactive;
                 $update['date'] = date('Y-m-d H:i:s',time());
                    
			     // update data
			     if ( $id && $action == 'edit' ){
                     $db->update( $update, $config['table_prefix'] . $config['table_ads'], 'ID="' . $id . '"' );
			     }
			          
                 if( $action == 'new' && $url ){
                    $auth->setGoodLanding( $config['base_url'].'admin/ads.php' );
                    $db->insert( $update, $config['table_prefix'] . $config['table_ads']);
                 }     
                      
			}

			// redirect
			$auth->redirect();
