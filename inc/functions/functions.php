<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

		
        	// get current url
			function getCurrentUrl()
			{
			     $url = 'http';
			     $url .= isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on' ? 's' : '';
			     $url .= "://";
			     $url .= $_SERVER["SERVER_PORT"] != '80' ? $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'] : $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			     return $url;
			}
            
            // check allowed domains
            function resolve_url( $url )
            {
                global $db, $config;

			    // get host of url
			    $host = parse_url( $url );
			    $host = $host['host'];

			    // resolve short urls
			    if ( in_array( $host, $config['allowed_domains'] ) ) {
			         $headers = myURL::resolve( $url );
			         $url = isset( $headers['Location'] ) ? $headers['Location'] : $url;
			    }
                return $url;                       
            }            
            
            
            // check banned domains
            function is_banned_domain( $url )
            {
                global $db, $config;

			    // get host of url
			    $host = parse_url( $url );
			    $host = $host['host'];
                return in_array($host, $config['banned_domains']) ? true : false;                       
            }
            
            // check for spam
            function is_spam()
            {
                global $db, $config;
                
                $now = date('Y-m-d H:i:s');
                $ip = core::validateIP( $_SERVER['REMOTE_ADDR'] ) ?  ip2long( $_SERVER['REMOTE_ADDR'] ) : $_SERVER['REMOTE_ADDR'];
                $query = 'SELECT ID,ip,created,TIME_TO_SEC(timediff("'.$now.'",created)) as wait FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE ip="' . $ip . '" AND TIME_TO_SEC(timediff("'.$now.'",created))<'.$config['spam_time'].' ORDER BY ID ASC';
                $data = $db->fetch( $query );
                if ( isset( $data[0]['ID'] ) )
                    return count ($data)> $config['spam_max'] ? true : false;
                return false;
            }    
            
            // make urls
			function makeurl( $url = null, $custom = null, $via = 'api', $password = null, $uses = null, $expire = null, $private = null )
			{
			     // declare globals
			     global $db, $config;
                 
                 // check slug   
			     $slug = core::makeSlug( $custom ) ? core::makeSlug( $custom, '-', false ) : false;

			     // prepare data to insert
			     $data = array();
			     $data['url'] = $url;
			     $data['via'] = $via;
			     $data['ip'] = core::validateIP($_SERVER['REMOTE_ADDR']) ?  ip2long( $_SERVER['REMOTE_ADDR'] ) : $_SERVER['REMOTE_ADDR'];
			     $data['private'] = $private;
			     $data['password'] = $password;
			     $data['uses'] = $uses;
                 $data['ads'] = 1;
			     $data['created'] = date( 'Y-m-d H:i:s' );
			     $data['expire'] = $expire;

                 // if custom   
			     if ( $slug ) {

			          // insert custom url
			          $data['short'] = $slug;
			          $data['custom'] = 1;
			          $id = @$db->insert( $data, $config['table_prefix'] . $config['table_name'] );
                      if(!$id){
    			             $query = 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE BINARY url="' . $url . '" AND short="' . core::makeSlug( $custom, '-' , false ) . '" AND custom="1"  ORDER BY ID ASC LIMIT 0,1';
                             $check = $db->fetch( $query );
    			             $id = isset( $check[0]['ID'] ) ? $check[0]['ID'] : false;
                      }

                 // else   
			     } else {

			          // prepare query
			          $add_query = ' AND private="' . $private . '"';
			          $add_query .= ' AND password="' . $password . '"';
			          $add_query .= ' AND uses="' . $uses . '"';
			          $add_query .= !is_null($expire) ? ' AND expire="' . $expire . '"' : '';

			          // check if exists with exact data
			          $query = 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE BINARY url="' . $url . '" AND custom="" ' . $add_query .
			               ' ORDER BY ID ASC LIMIT 0,1';
			          $check = $db->fetch( $query );

			          $id = isset( $check[0]['ID'] ) ? $check[0]['ID'] : false;

			          if ( !$id ) {

			               // total of urls
			               $total_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] );
			               $total_urls = $total_urls[0]['TOTAL'];
			               $total_urls = $total_urls == 0 ? 1 : $total_urls;

			               // calculate hash && hash size
			               $total_chars = strlen( $config['pattern'] );
			               $hash_size = getpowers( $total_chars, $total_urls );
			               $hash = substr( str_shuffle( $config['pattern'] ), 0, $hash_size );

			               // insert
			               $key = true;
			               while ( $key ) {
			                    $data['short'] = substr( str_shuffle( $config['pattern'] ), 0, $hash_size );
			                    $id = @$db->insert( $data, $config['table_prefix'] . $config['table_name'] );
			                    if ( $id )
			                         $key = false;
			               }

			          }
			     }

			     // return
			     return isset( $id ) ? ( int )$id : false;
			}

            // get max value    
            function getpowers($base, $maxvalue){
                return $maxvalue >= $base ?  floor( log ( $maxvalue, $base ) ) + 1 : 1;
            }
            
            // get data from ID            
            function getDataFromId($id)
            {
			    // declare globals
			    global $db, $config;
                $data = $db->fetch( 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE ID ="'.$id.'"' );
                return isset($data[0]) ? $data[0] : false;              
            }   
            
            // get data from short ID            
            function getDataFromShortId($short)
            {
			    // declare globals
			    global $db, $config;
                $data = $db->fetch( 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE BINARY short ="'.$short.'"' );
                return isset($data[0]) ? $data[0] : false;                
            }                      
