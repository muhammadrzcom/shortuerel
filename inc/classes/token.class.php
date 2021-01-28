<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			class myToken
			{
			     const ALPHA = 'abcdefghijklmnopqrstvwxyz';
			     const NUMERIC = '0123456789';

			     public static function make( $length = 64, $chars = "" )
			     {
			          if ( $chars == "" ) {
			               $chars .= self::NUMERIC . self::ALPHA . strtoupper( self::ALPHA );
			          }
			          $token = "";
			          for ( $i = 0; $i < $length; $i++ ) {
			               $token .= $chars[mt_rand( 0, strlen( $chars ) - 1 )];
			          }
			          return $token;
			     }

			}