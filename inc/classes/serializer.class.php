<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			class XML
			{
                 // get tabs
                 private static function getTabs( $tabcount )
			     {
			          $tabs = '';
			          for ( $i = 0; $i < $tabcount; $i++ ) {
			               $tabs .= "\t";
			          }
			          return $tabs;
			     }
                 
                 // make the xml   
			     private static function asxml( $arr, $elements = array(), $tabcount = 0 )
			     {
			          $result = '';
			          $tabs = self::getTabs( $tabcount );
			          foreach ( $arr as $key => $val ) {
			               $element = isset( $elements[0] ) ? $elements[0] : $key;
			               $result .= $tabs;
			               $result .= "<" . $element . ">";
			               if ( !is_array( $val ) )
			                    $result .= $val;
			               else {
			                    $result .= "\r\n";
			                    $result .= self::asxml( $val, array_slice( $elements, 1, true ), $tabcount + 1 );
			                    $result .= $tabs;
			               }
			               $result .= "</" . $element . ">\r\n";
			          }
			          return $result;
			     }
                 
                 // result   
			     public static function make( $arr, $root = "result", $elements = array() )
			     {
			          $result = '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
			          $result .= '<' . $root . '>'."\r\n";
			          $result .= self::asxml( $arr, $elements, 1 );
			          $result .= '</' . $root . '>'."\r\n";
			          return $result;
			     }
			}
            
            
            
            