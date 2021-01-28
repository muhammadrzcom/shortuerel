<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			class myQrCode
			{
			     const ENDPOINT = 'http://chart.apis.google.com/chart';
			     private $data;
			     private $timeout = 30;
                 private $encoding = 'UTF-8';
                 private $correction_level = 'L';

			     // bookmarks
			     public function bookmark( $title = null, $url = null )
			     {
			          return $this->data = 'MEBKM:TITLE:' . $title . ';URL:' . $title . ';';
			     }

			     // memcards
			     public function contact( $name = null, $address = null, $phone = null, $email = null )
			     {
			          return $this->data = 'MECARD:N:' . $name . ';ADR:' . $address . ';TEL:' . $phone . ';EMAIL:' . $email . ';';
			     }

			     // content
			     public function content( $type = null, $size = null, $content = null )
			     {
			          return $this->data = 'CNTS:TYPE:' . $type . ';LNG:' . $size . ';BODY:' . $content . ';';
			     }

			     // email
			     public function email( $email = null, $subject = null, $message = null )
			     {
			          return $this->data = 'MATMSG:TO:' . $email . ';SUB:' . $subject . ';BODY:' . $message . ';';
			     }

			     // geo location
			     public function geo( $lat = null, $lon = null, $height = null )
			     {
			          return $this->data = 'GEO:' . $lat . ',' . $lon . ',' . $height . ';';
			     }

			     // phone number
			     public function phone( $phone = null )
			     {
			          return $this->data = 'TEL:' . $phone;
			     }

			     // sms
			     public function sms( $phone = null, $text = null )
			     {
			          return $this->data = 'SMSTO:' . $phone . ':' . $text;
			     }

			     // text
			     public function text( $text = null )
			     {
			          return $this->data = $text;
			     }

			     // url
			     public function url( $url = null )
			     {
			          return $this->data = preg_match( '#^https?\:\/\/#', $url ) ? $url : 'http://' . $url;
			     }

			     // wifi
			     public function wifi( $type = null, $ssid = null, $password = null )
			     {
			          return $this->data = 'WIFI:T:' . $type . ';S:' . $ssid . ';P:' . $password . ';;';
			     }

			     // draw the qrcode
			     function draw( $size = 150, $margin = 0 )
			     {
			          if ( !$this->data )
			               return false;
                      // api charst size limits     
                      $size = $size > 500 ? 500 : ( $size < 30 ? 30 : $size );
			          $ch = curl_init();
			          curl_setopt( $ch, CURLOPT_URL, self::ENDPOINT );
			          curl_setopt( $ch, CURLOPT_POST, true );
			          curl_setopt( $ch, CURLOPT_POSTFIELDS, 'chs=' . $size . 'x' . $size . '&cht=qr&chl=' . urlencode( $this->data ) . '&choe=' . $this->encoding . '&chld='.$this->correction_level.'|' . $margin );
			          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			          curl_setopt( $ch, CURLOPT_HEADER, false );
			          curl_setopt( $ch, CURLOPT_TIMEOUT, $this->timeout );
			          $img = curl_exec( $ch );
			          curl_close( $ch );
                      
                      // if we have image
			          if ( $img ){
        	              header( 'Content-type: image/png' );
    			          print $img;
    			          return true;			             
			          }
			          return false;
			     }

                 // set timeout
                 public function setTimeout( $timeout = null )
                 {
                    return $this->timeout = isset( $timeout ) && is_numeric( $timeout ) ? $timeout : $this->timeout;
                 }
                 
                 // set timeout
                 public function setEncoding( $encoding = null )
                 {
                    $valid = array('UTF-8','Shift_JIS','ISO-8859-1');
                    return $this->encoding = isset( $encoding ) && in_array( $encoding, $valid ) ? $timeout : $this->encoding;
                 }   
                 
                 // set timeout
                 public function setCorrection( $correction = null )
                 {
                    $valid = array('L','M','Q','H');
                    return $this->correction_level = isset( $correction ) && in_array( $correction , $valid ) ? $correction : $this->correction_level;
                 }                                

			}
            
            
            
            