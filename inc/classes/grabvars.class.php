<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			class grabVars
			{

			     // default variables
			     private $varDefaultValue = false;
			     private $varOrigin = 'raw';
			     private $varType = 'string';
			     private $varSwitch;
			     private $callback = false;
			     private $sanitize = false;
			     private $return;
                 private $version = '1.0';

			     // set default value if data doesn't pass
			     public function setDefaultValue( $value = null )
			     {
			          return $this->varDefaultValue = is_string( $value ) ? trim( $value ) : false;
			     }

			     // get default value
			     private function getVarDefaultValue()
			     {
			          return $this->varDefaultValue;
			     }

			     // set var origin
			     public function setVarOrigin( $var = null )
			     {
			          $var = self::clean( $var );
			          $options = array( 'get', 'post', 'raw' );
			          return $this->varOrigin = in_array( $var, $options ) ? $var : $this->varOrigin;
			     }

			     // get var origin
			     private function getVarOrigin()
			     {
			          return $this->varOrigin;
			     }

			     // set var type integer, string, etc.
			     public function setVarType( $var = null )
			     {
			          $var = self::clean( $var );
			          $options = array( 'tags', 'html', 'mysql', 'int', 'integer', 'float', 'string' );
			          $this->varType = in_array( $var, $options ) ? $var : $this->varType;
			     }

			     // set sanitize
			     public function setSanitize( $var = null )
			     {
			          $this->sanitize = is_bool( $var ) ? $var : $this->sanitize;
			     }

			     // get var type
			     private function getVarType()
			     {
			          return $this->varType;
			     }

			     // set varSwitch
			     public function setVarSwitch( $var = null )
			     {
			          return $this->varSwitch = ( is_array( $var ) || is_string( $var ) ) ? self::getSwitchArray( $var ) : false;
			     }

			     // get var Switch
			     private function getVarSwitch()
			     {
			          return $this->varSwitch;
			     }

			     // choose filters
			     private function getFilters()
			     {
			          switch ( $this->getVarType() ) {
			               case 'integer':
			               case 'int':
			                    $filter = FILTER_SANITIZE_NUMBER_INT;
			                    break;
			               case 'float':
			                    $filter = FILTER_SANITIZE_NUMBER_FLOAT;
			                    break;
			               case 'string':
			                    $filter = FILTER_SANITIZE_STRING;
			                    break;
			          }
			          return $filter;
			     }

			     // choose flags
			     private function getFlags()
			     {
			          switch ( $this->getVarType() ) {
			               case 'integer':
			               case 'int':
			                    $flags = null;
			                    break;
			               case 'float':
			                    $flags = FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND;
			                    break;
			               case 'string':
			                    $flags = FILTER_FLAG_NO_ENCODE_QUOTES;
			                    break;
			          }
			          return $flags;
			     }

			     // prepare array from string
			     private function prepareArrayFromString( $var = null )
			     {
			          $data = is_string( $var ) ? explode( ',', $var ) : $var;

			          $array = array();
			          foreach ( $data as $item ) {
			               $array[]['value'] = self::clean( $item );
			          }
			          $this->callback = false;
			          return $array;
			     }

			     // prepare array from another array
			     private function prepareArrayFromArray( $var = null )
			     {
			          $data = is_string( $var ) ? explode( ',', $var ) : $var;
			          $array = array();
			          $i = 0;
			          foreach ( $data as $key => $value ) {
			               $array[$i]['value'] = self::clean( $key );
			               $array[$i]['callback'] = $value;
			               $i++;
			          }
			          $this->callback = true;
			          return $array;
			     }

			     // find key in array
			     private function find( $needle, $haystack )
			     {
			          foreach ( $haystack as $key => $value ) {
			               if ( is_array( $value ) && array_search( $needle, $value ) !== false ) {
			                    return $key;
			               }
			          }
			          return false;
			     }

			     // find key in varSwitch
			     private function findMyKey( $search, $array, $sub = 'value' )
			     {
			          foreach ( $array as $key => $value ) {
			               if ( is_array( $value ) && isset( $value['value'] ) && $value['value'] == $search ) {
			                    return $key;
			               }
			          }
			          return false;
			     }

			     // get an array of possible options to use
			     private function getSwitchArray( $data = null )
			     {
			          $data = !is_array( $data ) ? self::prepareArrayFromString( $data ) : self::prepareArrayFromArray( $data );
			          $array = array();
			          $i = 0;
			          if ( count( $data ) > 0 ) {
			               foreach ( $data as $value ) {
			                    $array[$i] = $value;
			                    $i++;
			               }
			          }
                      $check = self::findMyKey($this->getVarDefaultValue(), $array );
                      if ( $this->getVarDefaultValue() && !is_int($check) ) {
			               $array[$i]['value'] = $this->getVarDefaultValue();
                           if ( isset( $array[0]['callback'] ) ) {
			                    $array[$i]['callback'] = true;
			               }
			          }
			          return $array;
			     }

			     // set correct type of data
			     private function setVarOutput( $var = null )
			     {
			          switch ( $this->varType ) {
			               case 'integer':
			               case 'int':
			                    $return = ( int )$var;
			                    break;
			               case 'float':
			                    $return = ( float )$var;
			                    break;
			               case 'string':
                           default:
			                    $return = ( string )$var;
			                    break;
			          }
			          return $return;
			     }

			     // get stage
			     private function getStage()
			     {
			          $checkV = $this->getVarDefaultValue() ? true : false;
			          $checkS = $this->getVarSwitch() ? true : false;
			          return $checkV && $checkS ? 1 : ( !$checkV && $checkS ? 2 : ( $checkV && !$checkS ? 3 : 4 ) );
			     }

			     // callback function
			     private function callback()
			     {
			          $var = $this->return ? $this->return : $this->getVarDefaultValue();
			          switch ( self::getStage() ) {
			               case 1:
			               case 2:
                                $check = $this->getVarSwitch() && is_int( self::findMyKey( $var, $this->getVarSwitch() ) ) ? self::findMyKey( $var, $this->varSwitch ): self::findMyKey( $this->varDefaultValue, $this->varSwitch );
                                $return = $this->callback ? 'callback' : 'value';
                                $callback = $this->varSwitch[$check][$return];   
			                    break;
			               case 3:
			                    $callback = $this->getVarDefaultValue() == $this->return ? true : false;
			                    break;
			               case 4:
			               default:
			                    $callback = $var;
			                    break;
			          }
			          return $this->sanitize ? self::sanitizeMySql( $callback ) : $callback;
			     }

			     // reset to default values
			     private function reset()
			     {
			          $this->varDefaultValue = false;
			          $this->varSwitch = false;
			     }

			     // remove spaces and set to lowercase
			     private static function clean( $var )
			     {
			          return trim( strtolower( $var ) );
			     }

			     // sanitize mysql data
			     private function sanitizeMySql( $data = null )
			     {
			          $data = get_magic_quotes_gpc() ? stripslashes( $data ) : $data;
			          return mysql_real_escape_string( $data );
			     }

			     // get the var
			     public function get( $var = null )
			     {
			          $data = is_string( $var ) ? trim( $var ) : $var;
			          $return = false;
			          switch ( $this->getVarOrigin() ) {
			               case 'raw':
			                    $return = filter_var( $data, $this->getFilters(), $this->getFlags() );
			                    break;
			               case 'get':
			                    $return = filter_input( INPUT_GET, $data, $this->getFilters() );
			                    break;
			               case 'post':
			                    $return = filter_input( INPUT_POST, $data, $this->getFilters() );
			                    break;
			          }
			          $return = self::setVarOutput( $return );
			          $this->return = $return != '' ? $return : false;
			          return $this->callback();
			     }

			}
            
            
            
            