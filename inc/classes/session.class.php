<?php


            //error_reporting(E_ALL);
            //ini_set('display_errors', '1');


			class mySession
			{

			     // declare variables
			     private $name = 'mySession';
			     private $id;

			     // constructor
			     public function __construct( $startSession = true )
			     {
			          $check = self::checkSession();
                      if ( $startSession ) {
			               if ( !$check ) {
			                    session_start();
			               }
			          }
			          $this->id = $check ? session_id() : null;
                      return;
			     }

			     // check for started session
			     private function checkSession()
			     {
			          return ( strlen( session_id() ) < 1 ) ? false : true;
			     }

			     // set name of session var
			     public function setName( $name = null )
			     {
			          return $this->name = ( !is_array( $name ) || !is_object( $name ) ) ? trim( $name ) : $this->name;
			     }

			     // set data of session var
			     public function set( $data = null )
			     {
			         return $_SESSION[$this->name] = ( is_object( $data ) || is_array( $data ) ) ? $data : ( is_string($data) ? trim ($data) : $data);

			     }

			     // get data of session var
			     public function get()
			     {
			          return isset( $_SESSION[$this->name] ) ? $_SESSION[$this->name] : false;
			     }

			     // delete session var
			     public function del()
			     {
			          if ( isset( $_SESSION[$this->name] ) ) {
			               $_SESSION[$this->name] = '';
			               unset( $_SESSION[$this->name] );
			          }
                      return;
			     }

			     // delete all session vars
			     public function kill()
			     {
			          foreach ( $_SESSION as $key => $value ) {
			               $_SESSION[$key] = '';
			               unset( $_SESSION[$key] );
			          }
                      return;
			     }

			}
            
            
            
            