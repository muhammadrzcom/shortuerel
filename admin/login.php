<?php



            //error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

		
        	// load the system
			include ( "../inc/load.php" );
            
            //auth
            $auth = new myAuth();
            $auth->setResource('mtro');
            $auth->forceAuth(false);
            $auth->checkAuth();
            $auth->redirect(); 
            
            include('inc/templates/login.tpl');