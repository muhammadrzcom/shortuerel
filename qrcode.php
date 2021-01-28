<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			
            // include system
			include ( 'inc/load.php' );

			// catch 
			$id = isset( $_GET['id'] ) ? trim( $_GET['id'] ) : false;
            $download = isset( $_GET['download'] ) ? true : false;
            
            // catch size
			$size = isset( $_GET['s'] ) && is_numeric( $_GET['s'] ) ? ( $_GET['s'] ) : 250;

			// if we catch an id
			if ( isset($id) ) {

			     // check for database
			     $query = 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' WHERE BINARY short="' . $id . '" ORDER BY ID LIMIT 0,1';

			     // check if url already exist
			     $data = $db->fetch( $query );

			     // if we have data
			     if ( isset( $data[0]['ID'] ) ) {
			          
                      // force download   
                      if ($download)
                            header( 'Content-Disposition: attachment; filename="'.$id.'_qrcode.png"' );
                                                    
                      // create qrcode  			             
			          $qr = new myQrCode();
			          $qr->url( $config['base_url'] . $data[0]['short'] );
			          $qr->draw( $size );
			     }

			}
