<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			
            // load the system
			include_once ( 'inc/load.php' );
               
            
            // admin can see everything
            $add_query = $is_admin ? '' : ' WHERE private="" AND inactive=""';

			// basic stats data
			$total_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] . $add_query );
			$total_urls = $total_urls[0]['TOTAL'];

			$today_urls = $db->fetch( 'SELECT COUNT(*) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] .
			     ' WHERE DATE(created) = DATE(CURDATE())' );
			$today_urls = $today_urls[0]['TOTAL'];

			$total_hits = $db->fetch( 'SELECT SUM(hits) AS TOTAL FROM ' . $config['table_prefix'] . $config['table_name'] );
			$total_hits = $total_hits[0]['TOTAL'] ? $total_hits[0]['TOTAL'] : 0;

            // start mypager
            $pager = new myPager();
            $pager->setTotalItems($total_urls);
            $pager->setItemsPerPage(14);
            $pager->setQueryVar('page');
            $pager->setClass('clean');    
            $pager->setNavigation(6);   
            $pager->showFirstButton(false);
            $pager->showLastButton(false);  
            $pager->showInfo(false);   
                        

			// lastest urls
			$urls = $db->fetch( 'SELECT * FROM ' . $config['table_prefix'] . $config['table_name'] . $add_query . ' ORDER BY ID DESC LIMIT '. $pager->getQueryLimit() . ',' . $pager->getQueryOffset() );
			$urls = isset( $urls[0]['ID'] ) ? $urls : false;
            
            // clean urls with password
            if(!$is_admin && $urls ){
                $cleanUrls = array();
                $i = 0;
                foreach ($urls as $url){
                    foreach ($url as $key=>$item){
                        if ($key=='url'){
                          $cleanUrls[$i]['url'] = empty( $url['password'] ) ? $item : 'Protected URL';
                        } else {
                            $cleanUrls[$i][$key] = $item;
                        }
                    }
                $i++;    
                }
                $urls = $cleanUrls;
            }
	
	$template = $config['shrinky_template'];
            
            include ( 'inc/templates/'.$template.'/public-stats.tpl');