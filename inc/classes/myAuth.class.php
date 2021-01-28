<?php

			
            //error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			class myAuth
			{

			     // variables
                 private $resource = 'myAuth';
			     private $timeout = 900;
			     private $goodLanding = 'index.php';
			     private $badLanding = 'login.php';
			     private $securityType = 'md5';
			     private $securitySalt = '+Dq_uJM(EtJ3/+TsgZFQQndsBZUKWCHy(ki2/Nn9=CfTxioc_pb5_p27WvGAmD^T';
                 private $path = '/';
			     private $forceAuth = true;
			     private $isLogged = false;


			     // encrypt data
			     private function encrypt( $data )
			     {
			          return $this->securityType == 'md5' ? md5( $data ) : sha1( $data );
			     }

			     // compare self files
			     private function selfCompare( $_file = null )
			     {
			          $self_ = explode( '/', $_SERVER['PHP_SELF'] );
			          $self = end( $self_ );
			          $file_ = explode( '/', $_file );
			          $file = end( $file_ );
			          return $self == $file ? true : false;
			     }

			     // make secure hash from local and remote values
			     private function makeHash( $hash )
			     {
			          $hash = $_SERVER['SERVER_NAME'];
			          $hash .= $_SERVER['REMOTE_ADDR'];
			          $hash .= $hash;
			          $hash .= $_SERVER['HTTP_USER_AGENT'];
			          $hash .= $this->securitySalt;
			          return $this->encrypt( $hash );
			     }

			     // check if we have an ajax call
			     private function isAjaxCall()
			     {
			          return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ? true : false;
			     }

			     // check auth
			     public function checkAuth()
			     {
			          // first auth check
			          if ( ( !isset( $_COOKIE['auth_' . $this->resource] ) ) || empty( $_COOKIE['auth_' . $this->resource] ) || ( !isset( $_COOKIE['hash_' . $this->resource] ) ) || empty( $_COOKIE['hash_' . $this->resource] ) ) {
			               return false;
			          }

			          // check and compare data from cookie
			          $sData = $_COOKIE['auth_' . $this->resource];
			          $sData = get_magic_quotes_gpc() ? stripslashes( $sData ) : $sData;
			          $vHash = $this->makeHash( $this->encrypt( $sData ) );

			          // compare hash
			          if ( $vHash != $_COOKIE['hash_' . $this->resource] ) {
			               return false;
			          }

			          // logged
			          $this->isLogged = true;

			          // restart timeout of cookie
			          if ( !$this->forceAuth ) {
			               setcookie( 'auth_' . $this->resource, $sData, ( time() + $this->timeout ), $this->path );
			               setcookie( 'hash_' . $this->resource, $vHash, ( time() + $this->timeout ), $this->path );
			          }

			          // check for array or object
			          $sData = self::is_serialized( $sData ) ? unserialize( $sData ) : $sData;

			          // return data
			          return true;
			     }

			     // check for serialized data
			     private function is_serialized( $string )
			     {
			          return ( @unserialize( $string ) !== false );
			     }
    			
                 // make slugs from string
    			 private static function makeSlug( $text, $spacer='-', $lower_case=true)
    			 {
                       // remove non alpha chars
                       $text = preg_replace("/[^\p{L}\p{N}\\s\-]/", '', $text);
                       // replace new lines
                       $text = preg_replace('/\s+/', ' ', $text);
                       // remove extra spaces
                       $text = trim($text);
                       // replace spaces with -  
    			       $text = preg_replace( '/\\s/', $spacer, $text );
                       // array of chars
                       $chars = array( 'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                       'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                       'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                       'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                       'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
                       // replace unwanted chars                
                       $text = strtr( $text, $chars );
                       // clean spaces
                       $text = preg_replace('/\s+/', '',$text);
                       // change to lowercase
                       $text = $lower_case ? strtolower($text) : $text;
                       // remove extra spaces
                       $text = trim($text);
                       // return
    			       return !empty( $text ) ? $text : false;
    			}

			     /* public functions */
			     

                 // set name resource
			     public function setResource( $resource = null )
			     {
			          return $this->resource = is_string( $resource ) ? self::makeSlug( $resource ) : $this->resource;
			     }

			     // set Timeout in seconds
			     public function setTimeout( $ttl = null )
			     {
			          return $this->timeout = is_numeric( $ttl ) ? $ttl : $this->timeout;
			     }

			     // set the good landing page
			     public function setGoodLanding( $page = null )
			     {
			          return $this->goodLanding = is_string( $page ) ? trim($page) : $this->goodLanding;
			     }

			     // set the bad landing page
			     public function setBadLanding( $page = null )
			     {
			          return $this->badLanding = is_string( $page ) ? trim($page) : $this->badLanding;
			     }

			     // set encryption type
			     public function setEncryptionType( $type = null )
			     {
			          return $this->securityType = in_array( strtolower( $type ), array( 'md5', 'sha1' ) ) ? strtolower( $type ) : $this->securityType;
			     }

			     // set security hash
			     public function setSalt( $hash = null )
			     {
			          return $this->securitySalt = is_string( $hash ) ? trim( $hash ) : $this->securitySalt;
			     }
                 
			     // set cookie path
			     public function setPath( $path = null )
			     {
			          return $this->path = is_string( $path ) ? trim( $path ) : $this->path;
			     }                 

			     // set security hash
			     public function forceAuth( $force = null )
			     {
			          return $this->forceAuth = is_bool( $force ) ? $force : $this->forceAuth;
			     }

			     // redirect
			     public function redirect()
			     {
			          $location = $this->isLogged ? $this->goodLanding : $this->badLanding;
			          if ( !self::isAjaxCall() ) {
			               if ( !$this->selfCompare( $location ) ) {
			                    @header( 'Location: ' . $location );
			                    // avoid execution of code after redirection
			                    die();
			               }
			               return false;
			          }
			          die();
			          return false;
			     }
			     
                 // make authorization
			     public function makeAuth( )
			     {
			          $data =  $this->resource;
                      $sData = ( is_object( $data ) || is_array( $data ) ) ? serialize( $data ) : trim( $data );
			          $vData = $this->makeHash( $this->encrypt( $sData ) );
			          setcookie( 'auth_' . $this->resource, $sData, ( time() + $this->timeout ), $this->path );
			          setcookie( 'hash_' . $this->resource, $vData, ( time() + $this->timeout ), $this->path );
			          $this->isLogged = true;
			          return true;
			     }                 
			     
                 // deauthorize login setting past time cookies
			     public function deAuth()
			     {
			          setcookie( 'auth_' . $this->resource, '', ( time() - 86400 ), $this->path );
			          setcookie( 'hash_' . $this->resource, '', ( time() - 86400 ), $this->path );
			          $this->isLogged = false;
			          return true;
			     }                                  
			     
                 // sanitize string
			     public static function sanitize( $str )
			     {
			          $str = ini_get( 'magic_quotes_gpc' ) ? stripslashes( $str ) : $str;
			          $str = strip_tags( $str );
			          $str = trim( $str );
			          $str = htmlspecialchars( $str );
			          $str = mysql_real_escape_string( $str );
			          return $str;
			     }
                 
                 

			}
