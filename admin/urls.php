<?php



			
            //error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			// load the system
			include ( "../inc/load.php" );

            // auth 
            $auth = new myAuth();
            $auth->setResource('mtro');
            $auth->setBadLanding('login.php');
            $auth->setGoodLanding('urls.php');
            $auth->forceAuth(false);
            $auth->checkAuth();   
                       
            $auth->redirect();    
            
            // prepare arrays
            $array_show = array('all','private','inactive', 'expired by date', 'expired by clicks', 'with ads', 'without ads', 'with password','without password', 'with limited uses','without limited uses','with expire date','without expire date' );
            $array_by = array('ID','url','short','custom','via','private','password','uses','hits','inactive','ads','created','expire','last');
            $array_order = array('DESC','ASC');
            $array_count = array('20','40','60','80','100');
            $array_custom = array('All','show','hide');

            $array_via = false; 
            $unique_via = $db->fetch( 'SELECT DISTINCT via FROM ' . $config['table_prefix'] . $config['table_name'] . ' ORDER BY via ASC');
            if(count($unique_via)>0){
                $array_via = array();
                $array_via[] = 'All';
                foreach( $unique_via as $via ){
                    $array_via[] = $via['via'];
                }
            }
            
            // catch the variables
            $results = isset($_GET['results']) && is_numeric($_GET['results'])? core::sanitize(min(max(intval($_GET['results']), 10), 100)) : 20;
            $order = isset($_GET['sort']) && in_array(strtoupper($_GET['sort']),$array_order) ? core::sanitize(strtoupper($_GET['sort'])) : 'DESC';
            $order_by = isset($_GET['order_by']) && in_array(strtolower($_GET['order_by']), $array_by)? core::sanitize(strtolower($_GET['order_by'])) : 'ID';
            $via = isset($_GET['via']) && in_array(strtolower($_GET['via']), $array_via) ? core::sanitize(strtolower($_GET['via'])) : 'All';
            $show = isset($_GET['show']) && in_array(strtolower($_GET['show']), $array_show) ? core::sanitize(strtolower($_GET['show'])) : '';
            $custom = isset($_GET['custom']) && in_array(strtolower($_GET['custom']), $array_custom) ? core::sanitize(strtolower($_GET['custom'])) : 'All';
            $query = isset($_GET['query']) ? core::sanitize($_GET['query']) : false;
            $queryFrom = isset($_GET['from']) && in_array(strtolower($_GET['from']), array('all','short','full','id')) ? core::sanitize(strtolower($_GET['from'])) : 'all';
            


            // choose
            $add_query = '';
			switch ( $show ) {
			     case '':
                 case 'all':
			          break;
			     case 'inactive':
			          $add_query .= 'WHERE inactive="1"';
			          break;
			     case 'expired by date':
			          $add_query .= 'WHERE expire<>"0000-00-00 00:00:00" AND DATEDIFF(expire, CURDATE()) <= 0 ';
			          break; 
			     case 'expired by clicks':
			          $add_query .= 'WHERE uses="0"';
			          break;                                                
			     case 'private':
			          $add_query .= 'WHERE private="1"';
			          break;
			     case 'with password':
			          $add_query .= 'WHERE password<>""';
			          break;
			     case 'without password':
			          $add_query .= 'WHERE password=""';
			          break;
			     case 'with ads':
			          $add_query .= 'WHERE ads="1"';
			          break;
			     case 'without ads':
			          $add_query .= 'WHERE ads=""';
			          break;
			     case 'with limited uses':
			          $add_query .= 'WHERE uses<>""';
			          break;
			     case 'without limited uses':
			          $add_query .= 'WHERE uses=""';
			          break;
			     case 'with expire date':
			          $add_query .= 'WHERE expire<>"0000-00-00 00:00:00"';
			          break;
			     case 'without expire date':
			          $add_query .= 'WHERE expire="0000-00-00 00:00:00"';
			          break;                      
			}
               
            if ($via!='All'){
                $add_query = $add_query ? $add_query . ' AND ' : ' WHERE ';
                $add_query .= 'via="'.$via.'"';
            }
            if ($custom!='All'){
                $custom_query = $custom == 'show' ? '1' : '';
                $add_query = $add_query ? $add_query . ' AND ' : ' WHERE ';
                $add_query .= 'custom="'.$custom_query.'"';
            }
            
            // search
            if ($query){
                $add_query .= $add_query != '' ? ' AND ' : ' WHERE ';
    			switch ( $queryFrom ) {
    			     case 'all':
                     case '':
    			          $add_query .= ' (short LIKE "%'.core::sanitize($query).'%" OR url LIKE "%'.core::sanitize($query).'%")';
    			          break;
    			     case 'short':
    			          $add_query .= ' short LIKE "%'.core::sanitize($query).'%"';
    			          break;
    			     case 'full':
    			          $add_query .= ' url LIKE "%'.core::sanitize($query).'%"';
    			          break;
    			     case 'id':
    			          $add_query .= ' ID LIKE "%'.core::sanitize($query).'%"';
    			          break;                          
    			}                
            }
            
                       
            // total items
            $total_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name']. ' ' . $add_query );
            $total_urls = $total_urls[0]['TOTAL'];

            // pager
            $pager = new myPager();
            $pager->setTotalItems($total_urls);
            $pager->setItemsPerPage($results);
            $pager->setQueryVar('page');
            $pager->setClass('nice');
            
            // the query
            $query = 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . ' ' . $add_query . ' ORDER BY ' . $order_by . ' ' . $order . ' LIMIT ' . $pager->getQueryLimit() . ',' . $pager->getQueryOffset();
            $urls = $db->fetch( $query );
            $urls = isset($urls[0]['ID']) ? $urls : false;       
              
            
            include('inc/templates/urls.tpl');