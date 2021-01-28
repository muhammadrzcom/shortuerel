<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			class myURL
			{
			     private $url;
                 public $headers;

                 // constructor   
			     public function __construct( $url )
			     {
			          $this->url = $url;
			          $this->run();
			     }
                 
                 // set the data and make the call   
			     public function run()
			     {
                    $ch = curl_init();
                    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt ($ch, CURLOPT_URL, $this->url);
                    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
                    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11');
                    curl_setopt($ch, CURLOPT_HEADER, true); // header will be at output
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD'); // HTTP request is 'HEAD'
                    $this->headers = curl_exec ($ch);
                    curl_close ($ch);
			     }
                 
			     // convert headers to array
			     private function headersToArray( $headers )
			     {
			          $return = array();
			          foreach ( $headers as $item ) {
			               if ( preg_match( '#HTTP/1\.\d (?P<code>\d{3}) (?P<text>.*)#', $item, $matches ) ) {
			                    $return['Http'][$matches[1]] = $matches[0];
			               } else {
			                    $split = strpos( $item, ':' );
			                    $key = substr( $item, 0, $split );
			                    $value = trim( substr( $item, $split + 1 ) );
			                    $return[$key] = $value;
                                
			               }
			          }
			          return $return;
			     }                 

			     // get the redirection page
                 public function headers()
			     {
                      return self::headersToArray(explode( "\r\n", $this->headers ));
			     }
                 
                 // static function   
			     public static function resolve($url)
                 {
                    $get__ = new myURL($url);
                    return $get__->headers() ? $get__->headers() : false;
                 }
			}
            
            
            
            