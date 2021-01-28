<?php



			
			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include ( '../inc/load.php' );

			// catch the data
			$url = isset( $_GET['url'] ) && core::validateUrl( $_GET['url'] ) ? core::sanitize( $_GET['url'] ) : false;
			$custom = isset( $_GET['custom'] ) && $_GET['custom'] != '' ? core::sanitize( str_replace( array( '+', '%20' ), ' ', $_GET['custom'] ) ) : null;

			// quick checks
			if ( !$url )
			     die( 'Error: Invalid Url!' );
			if ( isset( $custom ) && strlen( $custom ) > 60 ) {
			     die( 'Error: Custom name must be less than 60 chars.' );
			}

			// compare domain with banned ones
			if ( is_banned_domain( $url ) ) {
			     die('Error: Domain not allowed');
			}
            
            // spam protection
            if (!$is_admin){
                if ( is_spam() )                
                    die('Error: Spam detected!');
            }

			// make url
			$id = makeurl( resolve_url( $url ), $custom, $via = 'simple-api' );

			// responses
			if ( $id ) {
			     $data = getDataFromId( $id );
			     echo $config['base_url'] . $data['short'];
			} else {
			     $custom = core::makeSlug( $custom, '-', false );
			     $data = $db->fetch( 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE short ="' . $custom . '" LIMIT 0,1' );
			     if ( isset( $data[0] ) && $data[0]['short'] == $custom && $data[0]['url'] == $url ) {
			          echo $config['base_url'] . $data[0]['short'];
			     } else {
			          echo 'Error: Custom name already taken.';
			     }
			}
