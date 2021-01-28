<?php



			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system
			include ( '../inc/load.php' );

			// choose origin
			$method = isset( $_GET['method'] ) && in_array( strtoupper( $_GET['method'] ), array( 'GET', 'POST' ) ) ? strtoupper( $_GET['method'] ) :
			     'POST';

			$type = isset( $_GET['type'] ) && in_array( strtolower( $_GET['type'] ), array( 'xml', 'json' ) ) ? strtolower( $_GET['type'] ) : 'json';

			// check if request was made via ajax
			$is_ajax = isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ? true : false;

			// make new instance of grab Vars
			$vars = new grabVars();

			// set the origin of variables
			$vars->setVarOrigin( $method );

			// set the type of variables that we expect: string
			$vars->setVarType( 'string' );

			// catch the vars
			$getID = utf8_decode( urldecode( $vars->get( 'id' ) ) );
			$getPassword = utf8_decode( urldecode( $vars->get( 'password' ) ) );

			// sanitize
			$getID = core::sanitize( $getID );
			$getPassword = core::sanitize( $getPassword );


			// check
			if ( $getID == '' ) {
			     $error['code'] = 0;
			     $error['msg'] = 'You need to specify an ID';
			} else {
			     $data = getDataFromShortId( $getID );
			     if ( !$data ) {
			          $error['code'] = 1;
			          $error['msg'] = 'Invalid ID';
			     } else {
			          $is_inactive = $data['inactive'] == 1 ? true : false;
			          $is_private = $data['private'] == 1 ? true : false;
			          $is_expired = $data['expire'] != '0000-00-00 00:00:00' ? true : false;
			          $use_password = $data['password'] != '' ? true : false;
			     }
			}

			// is active
			if ( isset( $is_inactive ) && $is_inactive == true ) {
			     $error['code'] = 2;
			     $error['msg'] = 'Inactive Url';
			}

			// expired
			if ( isset( $is_expired ) && $is_expired == true ) {
			     $diff = strtotime( $data['expire'] ) - time();
			     if ( $diff <= 0 ) {
			          $error['code'] = 3;
			          $error['msg'] = 'Expired Url';
			     }
			}

			// check for password
			if ( isset( $use_password ) && $use_password == true ) {
			     if ( $getPassword != $data['password'] ) {
			          $error['code'] = 4;
			          $error['msg'] = 'Invalid Password';
			     } else {
			          $auth = true;
			     }
			}

			// check for password
			elseif ( isset( $is_private ) && $is_private == true ) {
			     if ( !isset( $auth ) ) {
			          $error['code'] = 5;
			          $error['msg'] = 'Private Url';
			     }
			}

			// set correct headers
			header( 'Content-type: application/' . $type );

			// allow crossdomain serving
			if ( $method == 'POST' ) {
			     header( 'Access-Control-Allow-Origin: *' );
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
			     die();
			}

			// prepare response
			$api_response = array();

			// construct api response
			if ( $data ) {
			     $api_response['id'] = $data['short'];
			     $api_response['uses'] = $data['uses'];
			     $api_response['hits'] = $data['hits'];
			     $api_response['ads'] = $data['ads'];
			     $api_response['url'] = $config['base_url'] . $data['short'];
			     $api_response['full'] = htmlspecialchars_decode($data['url']);
			     $api_response['created'] = strtotime( $data['created'] );
			     $api_response['expire'] = $is_expired ? strtotime( $data['expire'] ) : '';
			     $api_response['last'] = isset( $data['last'] ) && $data['last'] != '0000-00-00 00:00:00' ? strtotime( $data['last'] ) : '';
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
