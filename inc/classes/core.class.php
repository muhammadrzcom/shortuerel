<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			class core
			{
			     // url validator
			     public static function validateUrl( $url )
			     {
			         $url = strtolower( $url );
                     $regex = "/^".
                              "(?:https?:\\/\\/)".  // Look for http://, but make it optional.
                              "(?:[a-zA-Z0-9\p{Cyrillic}][a-zA-Z0-9\p{Cyrillic}_-]*(?:\\.[a-zA-Z0-9\p{Cyrillic}][a-zA-Z0-9\p{Cyrillic}_-]*))". // Server name
                              "(?:\\d+)?".         // Optional port number
                              "(?:\\/\\.*)?/iu";    // Optional training forward slash and page info                      
			          return preg_match( $regex, $url ) ? true : false;
			     }
                 
                 // get all urls from string    
                 public static function getAllUrls($string)
                 {
                    $regex = '@((https?://)([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.\,]*(\?\S+)?)?)*)@';
                    preg_match_all( $regex, $string , $matches );
                    return $matches[0];
                 }

			     // validate file extension
			     public static function checkExt( $url, $ext )
			     {
			          return preg_match( '/\.' . $ext . '$/i', $url ) ? true : false;
			     }

			     // url image validator
			     public static function validateImageUrl( $url )
			     {
			          return preg_match( "#(http:\/\/(.*)\.(gif|png|jpg|jpeg)&?.*?)#i", $url ) ? true : false;
			     }

			     // email validator
			     public static function validateEmail( $email )
			     {
			          return preg_match( '/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email ) ? true : false;
			     }
                 
    			// make slugs from string
    			public static function makeSlug( $text, $spacer='-', $lower_case=true)
    			{
                      // remove non alpha chars
                      $text = preg_replace("/[^\p{L}\p{N}\\s]/", '', $text);
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
                
                // sanitize string
                public static function sanitize($str)
                {
                    if(ini_get('magic_quotes_gpc'))
                        $str = stripslashes($str);
                   	$str = strip_tags($str);
                   	$str = trim($str);
                   	$str = htmlspecialchars($str);
                   	$str = mysql_real_escape_string($str);
                   	return $str;
                }
                
                // validate date
                public static function validateDate($str)
                {
                    if (substr_count($str, '/') == 2) {
                        list($m, $d, $y) = explode('/', $str);
                        return checkdate($m, $d, sprintf('%04u', $y));
                    }
                
                    return false;
                }
                
                // validate ip v4 / v6
                public static function validateIP($ip)
                {
                    return inet_pton($ip) !== false;
                }
                
                // get current url
			    public static function getCurrentUrl()
			    {
			        $url = 'http';
			        $url .= isset( $_SERVER["HTTPS"] ) && $_SERVER["HTTPS"] == 'on' ? 's' : '';
			        $url .= "://";
			        $url .= $_SERVER["SERVER_PORT"] != '80' ? $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'] : $_SERVER['SERVER_NAME'] .
			             $_SERVER['REQUEST_URI'];
			        return $url;
			    }                
                                
			}
