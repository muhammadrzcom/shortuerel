<?php



			
			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

		
        	// load the system
			include ( "../inc/load.php" );

			// auth
			$auth = new myAuth();
			$auth->setResource( 'mtro' );
			$auth->setBadLanding( $config['base_url'] . 'admin/login.php' );
			$auth->setGoodLanding( $config['base_url'] . 'admin/index.php' );
            $auth->forceAuth(false); 
                
			if ( !$auth->checkAuth() )
                $auth->redirect();    


			// catch
			$actions_array = array( 'new', 'edit', 'delete' );
			$from_array = array(
			     'urls',
			     'ads',
			     'resolver',
			     'banned',
                 'clients' );
			$action = isset( $_GET['action'] ) && in_array( strtolower( $_GET['action'] ), $actions_array ) ? strtolower( core::sanitize( $_GET['action'] ) ) :
			     'edit';
			$from = isset( $_GET['from'] ) && in_array( strtolower( $_GET['from'] ), $from_array ) ? strtolower( core::sanitize( $_GET['from'] ) ) : false;
			$id = isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ? core::sanitize( $_GET['id'] ) : false;
			$confirm = isset( $_GET['confirm'] ) && $_GET['confirm'] == 'yes' ? true : false;


			if ( !$from )
			     die();

			// select table
			switch ( $from ) {
			     case 'urls':
			          $table = $config['table_name'];
			          break;
			     case 'ads':
			          $table = $config['table_ads'];
			          break;
			     case 'resolver':
			          $table = $config['table_domains_allowed'];
			          break;
			     case 'banned':
			          $table = $config['table_domains_banned'];
			          break;
			     case 'clients':
			          $table = $config['table_clients'];
			          break;                      
			}

			// prepare table
			$table = $config['table_prefix'] . $table;

			// quick check
			$data = $db->fetch( 'SELECT * FROM ' . $table . ' WHERE id="' . $id . '" LIMIT 0,1' );
			$check = isset( $data[0]['ID'] ) ? true : false;
			$data = $check ? $data[0] : false;

			// actions
			switch ( $action ) {
                 case 'new':
                 case 'edit':
			             include ( 'inc/templates/form-' . $from . '.tpl' );
			          break;
			     case 'delete':
			          if ( $check && !$confirm ) {
			               echo 'Confirm to Delete: <a href="' . $_SERVER['REQUEST_URI'] . '&confirm=yes">YES</a> | <a href="' . $config['base_url'] . 'admin/' . $from .
			                    '.php">NO</a>';
			          } elseif ( $check && $confirm ) {
			               $data = array( 'ID' => $id );
			               $done = $db->delete( $table, 'ID=?', array( $id ) );
			               echo 'deleted';
			          }
			          break;
			}
