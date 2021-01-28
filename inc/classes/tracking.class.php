<?php


			//error_reporting(E_ALL);
			//ini_set('display_errors', '1');


			class myTracking
			{

			     // variables
			     private $UA;
			     private $domain;
			     private $page;

			     // constructor
			     public function __construct( $UA = null, $domain = null, $page = null )
			     {

			          $this->UA = isset( $UA ) ? $UA : '';
			          $this->domain = isset( $domain ) ? $domain : $_SERVER['SERVER_NAME'];
			          $this->page = isset( $page ) ? $page : $_SERVER['PHP_SELF'];
			     }


			     // send data to google analytics
			     public function track( $page = null )
			     {

			          $this->page = isset( $page ) ? $page : $this->page;
			          $var_utmp = $this->page;
			          $var_utmn = rand( 1000000000, 9999999999 );
			          $var_cookie = rand( 10000000, 99999999 );
			          $var_random = rand( 1000000000, 2147483647 );
			          $var_referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '';
			          $var_uservar = '-';
			          $url = 'http://www.google-analytics.com/__utm.gif?utmwv=1&utmn=' . $var_utmn . '&utmsr=-&utmsc=-&utmul=-&utmje=0&utmfl=-&utmdt=-&utmhn=' . $this->
			               domain . '&utmr=' . $var_referer . '&utmp=' . $var_utmp . '&utmac=' . $this->UA . '&utmcc=__utma%3D' . $var_cookie . '.' . $var_random . '.' .
			               time() . '.' . time() . '.' . time() . '.2%3B%2B__utmb%3D' . $var_cookie . '%3B%2B__utmc%3D' . $var_cookie . '%3B%2B__utmz%3D' . $var_cookie .
			               '.' . time() . '.2.2.utmccn%3D(direct)%7Cutmcsr%3D(direct)%7Cutmcmd%3D(none)%3B%2B__utmv%3D' . $var_cookie . '.' . $var_uservar . '%3B';
                      return self::request($url);  

			     }
                
                 // make url request   
			     private function request( $url = null )
			     {
			          if ( function_exists( 'curl_init' ) ) {
			               $ch = curl_init();
			               curl_setopt( $ch, CURLOPT_URL, $url );
			               curl_setopt( $ch, CURLOPT_HEADER, false );
			               curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			               curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
			               $output = curl_exec( $ch );
			               curl_close( $ch );
			          } else {
			               $handle = fopen( $url, "r" );
			               $test = fgets( $handle );
			               fclose( $handle );
			          }
                      return true;
			     }
			}