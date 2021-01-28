<?php



			
			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include ( '../inc/load.php' );

			// choose origin
			$method = isset( $_GET['method'] ) && in_array( strtoupper( $_GET['method'] ), array( 'GET', 'POST' ) ) ? strtoupper( $_GET['method'] ) :
			     'POST';

			$type = isset( $_GET['type'] ) && in_array( strtolower( $_GET['type'] ), array( 'xml', 'json' ) ) ? strtolower( $_GET['type'] ) : 'json';

			// quick abort
			if ( $method == 'POST' && !isset( $_POST['url'] ) )
			     die();

			// check if request was made via ajax
			$is_ajax = isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ? true : false;

			// make new instance of grab Vars
			$vars = new grabVars();

			// set the origin of variables
			$vars->setVarOrigin( $method );

			// set the type of variables that we expect: string
			$vars->setVarType( 'string' );

			// catch the vars
			$getUrl = urldecode( $vars->get( 'url' ) );
			$getCustom = utf8_decode( urldecode( $vars->get( 'custom' ) ) );

			$getPassword = utf8_decode( urldecode( $vars->get( 'password' ) ) );
			$getUses = utf8_decode( urldecode( $vars->get( 'uses' ) ) );
			$getExpire = utf8_decode( urldecode( $vars->get( 'expire' ) ) );
			$getPrivate = utf8_decode( urldecode( $vars->get( 'is_private' ) ) );
			$getVia = utf8_decode( urldecode( $vars->get( 'via' ) ) );

			// choose where from data
			$via = isset( $getVia ) && $getVia != '' ? core::sanitize( $getVia ) : 'api';


			// start session when js is disabled
			if ( !$is_ajax && $via == 'web' ) {
			     $session = new mySession();
			     $session->setName( 'metro_shrink' );
			}

			// sanitize
			$getUrl = core::sanitize( $getUrl );
			$getCustom = core::sanitize( $getCustom );
			$getPassword = core::sanitize( $getPassword );
			$getUses = core::sanitize( $getUses );
			$getExpire = core::sanitize( $getExpire );
			$getPrivate = core::sanitize( $getPrivate );

			// validate url
			$valid_url = core::validateUrl( $getUrl ) ? true : false;

			// set correct headers
			header( 'Content-type: application/' . $type );

			// allow crossdomain serving
			if ( $method == 'POST' ) {
			     header( 'Access-Control-Allow-Origin: *' );
			}

			// set url error
			if ( $valid_url ) {

			     // resolve url
			     $getUrl = resolve_url( $getUrl );

			     // compare domain with banned ones
			     if ( is_banned_domain( $getUrl ) ) {
			          $error['code'] = 0;
			          $error['msg'] = 'domain not allowed';
			     }

			     // prepare data for insert
			     $getPassword = $getPassword != '' && strlen( $getPassword ) <= 10 ? $getPassword : null;
			     $getUses = is_numeric( $getUses ) && $getUses > 0 && $getUses <= 1000000 ? $getUses : null;
			     $getExpire = core::validateDate( $getExpire ) ? date( 'Y-m-d H:i:s', strtotime( $getExpire ) ) : null;
			     $getPrivate = $getPrivate == 'true' ? 1 : null;

			} else {
			     $error['code'] = 1;
			     $error['msg'] = 'invalid url';
			}

			// set custom name error
			if ( $getCustom != '' && ( strlen( $getCustom ) > 60 ) ) {
			     $error['code'] = 2;
			     $error['msg'] = 'custom name must be less than 60 chars';
			}

			// admin can make a lot of urls
			if ( !$is_admin ) {
			 
			     // check spam
			     if ( $config['spam'] == 1 && is_spam() ) {
			          $error['code'] = 3;
			          $error['msg'] = 'spam detected!';
			     }
                 
			     // check banned ip
			     if ( in_array( $_SERVER['REMOTE_ADDR'], $config['banned_clients'] ) ) {
			          $error['code'] = 4;
			          $error['msg'] = 'banned';
			     }
			}

			// return to app
			if ( isset( $error ) && count( $error ) > 0 ) {

			     // print response error
			     switch ( $type ) {
			          case 'json':
			               print json_encode( array( 'success' => false, 'error' => $error ) );
			               break;
			          case 'xml':
			               print XML::make( array( 'success' => 0, 'error' => $error ), 'response' );
			               break;
			     }

			     // is ajax?
			     if ( !$is_ajax && $via == 'web' ) {
			          $session->set( array( 'success' => false, 'error' => $error ) );
			          header( 'Location: ' . $config['base_url'] );
			     }
			     die();
			}

			//everything is fine proceed
			$id = makeurl( $getUrl, $getCustom, $via, $getPassword, $getUses, $getExpire, $getPrivate );

			$api_response = array();

			// construct api response
			if ( $id ) {
			     $data = getDataFromId( $id );
			     $api_response['id'] = $data['short'];
			     $api_response['url'] = $config['base_url'] . $data['short'];
			     $api_response['full'] = htmlspecialchars_decode( $data['url'] );
			} else {
			     $api_response['status'] = 'custom-taken';
			}

			// print response
			switch ( $type ) {
			     case 'json':
			          print json_encode( array( 'success' => true, 'data' => $api_response ) );
			          break;
			     case 'xml':
			          print XML::make( array( 'success' => 1, 'data' => $api_response ), 'response' );
			          break;
			}

			// is ajax?
			if ( !$is_ajax && $via == 'web' ) {
			     $session->set( array( 'success' => true, 'data' => $api_response ) );
			     header( 'location: ' . $config['base_url'] );
			}
