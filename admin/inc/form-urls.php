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
			     $url = isset( $_POST['url'] ) && core::validateUrl( $_POST['url'] ) ?  core::sanitize( $_POST['url'] ) : false;
                 $via = isset( $_POST['via'] ) ? core::sanitize( $_POST['via'] ) : false;
			     $private = isset( $_POST['private'] ) && $_POST['private'] == 1 ? 1 : '';
			     $password = isset( $_POST['password'] ) ? core::sanitize( $_POST['password'] ) : null;
			     $uses = isset( $_POST['uses'] ) && $_POST['uses']>0 && $_POST['uses']<1000000 ? core::sanitize( $_POST['uses'] ) : null;
                 $inactive = isset( $_POST['status'] ) && $_POST['status'] == 1 ? 1 : '';
                 $ads = isset( $_POST['ads'] ) && $_POST['ads'] == 1 ? 1 : '';
                 $expire = isset( $_POST['expire'] ) && core::validateDate($_POST['expire']) ? date('Y-m-d H:i:s',strtotime($_POST['expire'])) : false;

			     // prepare update array
			     $update = array();
			     if ( $url )
			          $update['url'] = $url;
			     if ( $via )
			          $update['via'] = $via;
			     if ( $expire )
			          $update['expire'] = $expire;
                 $update['password'] = $password;     
                 $update['uses'] = $uses;
                 $update['inactive'] = $inactive;
                 $update['private'] = $private;
                 $update['ads'] = $ads;  

			     // update data
                 if ($id)
			         $db->update( $update, $config['table_prefix'] . $config['table_name'], 'ID="' . $id . '"' );

			}

			// redirect
			$auth->redirect();
