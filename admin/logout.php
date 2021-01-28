<?php



			
			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			// load the system
			include ( "../inc/load.php" );           
            
            // start myAuth 
            $auth = new myAuth();
            $auth->setResource('mtro');
            $auth->deAuth();
            $auth->setBadLanding('login.php');
            $auth->redirect();