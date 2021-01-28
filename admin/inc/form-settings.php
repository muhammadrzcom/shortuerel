<?php



			
			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include ( "../../inc/load.php" );

			// start myAuth
			$auth = new myAuth();
			$auth->setResource( 'mtro' );
			$auth->setBadLanding( $config['base_url'] . 'admin/login.php' );
			$auth->setGoodLanding( $config['base_url'] . 'admin/settings.php' );
			$auth->forceAuth(false);
            
			// if saving data
			if ( isset( $_POST['save'] ) && $auth->checkAuth() ) {

			     // catch data
			     $site_name = isset( $_POST['site_name'] ) ? core::sanitize( $_POST['site_name'] ) : false;
		 $shrinky_template = isset( $_POST['shrinky_template'] ) ? core::sanitize( $_POST['shrinky_template'] ) : '';
                 $base_url = isset( $_POST['base_url'] ) && core::validateUrl( $_POST['base_url'] ) ? core::sanitize( $_POST['base_url'] ) : false;
			     $multi_max = isset( $_POST['multi_max'] ) ? core::sanitize( $_POST['multi_max'] ) : false;
			     $use_ads = isset( $_POST['use_ads'] ) && $_POST['use_ads'] == 1 ? 1 : '';
                 $use_spam = isset( $_POST['spam'] ) && $_POST['spam'] == 1 ? 1 : '';
                 $spam_time = isset( $_POST['spam_time'] ) ? core::sanitize( $_POST['spam_time'] ) : false;
                 $spam_max = isset( $_POST['spam_max'] ) ? core::sanitize( $_POST['spam_max'] ) : false;
			     $default_ad = isset( $_POST['default_ad'] ) ? core::sanitize( $_POST['default_ad'] ) : false;
			     $timezone = isset( $_POST['timezone'] ) ? core::sanitize( $_POST['timezone'] ) : false;
                 $pattern = isset( $_POST['pattern'] ) ? core::sanitize( $_POST['pattern'] ) : false;
			     $shrinky_email = isset( $_POST['shrinky_email'] ) ? core::sanitize( $_POST['shrinky_email'] ) : '';
			     $google_adsense = isset( $_POST['google_adsense'] ) ? core::sanitize( $_POST['google_adsense'] ) : '';
			     $google_tracking = isset( $_POST['google_tracking'] ) ? core::sanitize( $_POST['google_tracking'] ) : '';
                 $token = isset( $_POST['token'] ) && !empty($_POST['token']) ? core::sanitize( $_POST['token'] ) : false;
                 

			     // prepare update array
			     $update = array();
			     if ( $site_name && is_string( $site_name ) ) {
			          $update['site_name'] = $site_name;
			     }
			     if ( $base_url ) {
			          $update['base_url'] = $base_url;
			     }  
			     if ( $shrinky_template ) {
			          $update['shrinky_template'] = $shrinky_template;
			     }               
			     if ( $multi_max && $multi_max > 0 && $multi_max <= 100 ) {
			          $update['multi_max'] = $multi_max;
			     }
			     if ( $default_ad && core::validateUrl( $default_ad ) ) {
			          $update['default_ad'] = $default_ad;
			     }
			     if ( $pattern && is_string( $pattern ) ) {
			          $update['pattern'] = $pattern;
			     }
			     if ( $timezone && is_string( $timezone ) ) {
			          $update['timezone'] = $timezone;
			     }
			     if ( $shrinky_email ) {
			          $update['shrinky_email'] = $shrinky_email;
			     }  
			     if ( $google_adsense ) {
			          $update['google_adsense'] = $google_adsense;
			     }                 
			     if ( $google_tracking ) {
			          $update['google_tracking'] = $google_tracking;
			     }
			     if ( $spam_time && $spam_time > 0 && $spam_time <= 3600 ) {
			          $update['spam_time'] = $spam_time;
			     }
			     if ( $spam_max && $spam_max > 0 && $spam_max <= 1000 ) {
			          $update['spam_max'] = $spam_max;
			     }   
                 
			     if ( $token ) {
			          $update['token'] = $token;
			     }                                                      
			     $update['use_ads'] = $use_ads;
                 $update['spam'] = $use_spam;

			     // update data
			     $db->update( $update, $config['table_prefix'] . $config['table_settings'], 'ID="1"' );

			}

			// redirect
			$auth->redirect();
