<!doctype html> 
<html lang="en"> 
<head> 
	<meta charset="utf-8" /> 
	<title>Shrinky | Dashboard</title>
    <link rel="alternate" type="application/rss+xml" title="Latest Urls" href="<?php echo $config['base_url'].'feed.rss?token='.$config['token']; ?>" />
    <link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/boxy.css" />    
    <link rel="stylesheet" href="css/myPager.css" />
</head>

<!-- body -->
<body>

    <header>
        <div class="logo"><p>administration</p></div>
        <div class="logged"><p>Welcome, <span><?php echo $config['username']; ?></span> | <a href="logout.php">Logout</a></p></div>
            <ul class="navigation">
                <li><a href="index.php">dashboard</a></li>
                <li class="selected"><a href="urls.php">urls</a></li>
                <li><a href="ads.php">ads</a></li>
                <li><a href="resolver.php">resolver</a></li>
                <li><a href="banned.php">banned</a></li>
                <li><a href="clients.php">clients</a></li>
                <li><a href="settings.php">settings</a></li>
            </ul>
                    <form method="get" class="search">
                        <input type="text" name="query" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" placeholder="Quick Search" />
                        <select name="from" id="from">
                            <option value="All" <?php echo isset($_GET['from']) && $_GET['from']=='All' ? 'selected="selected"' : ''; ?>>Full & Short Urls</option>
                            <option value="Short" <?php echo isset($_GET['from']) && $_GET['from']=='Short' ? 'selected="selected"' : ''; ?>>Short Urls</option>
                            <option value="Full" <?php echo isset($_GET['from']) && $_GET['from']=='Full' ? 'selected="selected"' : ''; ?>>Full Urls</option>
                            <option value="ID" <?php echo isset($_GET['from']) && $_GET['from']=='ID' ? 'selected="selected"' : ''; ?>>ID</option>
                        </select>
                        <input type="submit" value="search" />
                    </form>            
    </header>
            <div id="main">
                <div class="fullwidth">
                        <form method="get" class="filter">
                        <label for="show">Show</label>
                        <select name="show" id="show" style="width: 190px;">
                        <?php
                            foreach($array_show as $item){
                                $selected = $show == $item ? 'selected="selected"' : '';
                                echo '<option value="'.$item.'" '.$selected.'>'.ucwords($item).'</option>';
                            }
                        ?>
                        </select>
                        
                        <label for="order_by">Order by</label>                         
                        <select name="order_by" id="order_by">
                        <?php
                            foreach($array_by as $item){
                                $selected = $order_by == $item ? 'selected="selected"' : '';
                                echo '<option value="'.$item.'" '.$selected.'>'.ucwords($item).'</option>';
                            }
                        ?>
                        </select> 
                        
                        <label for="via">Via</label> 
                        <select name="via" id="via"  style="width: 140px;">
                        <?php
                            foreach($array_via as $item){
                               $selected = $via == $item ? 'selected="selected"' : '';
                               echo '<option value="'.$item.'" '.$selected.'>'.$item.'</option>';
                            }
                        ?>
                        </select>

                        <label for="custom">Custom ID</label> 
                        <select name="custom" id="custom">
                        <?php
                            foreach($array_custom as $item){
                               $selected = $custom == $item ? 'selected="selected"' : '';
                               echo '<option value="'.$item.'" '.$selected.'>'.ucwords($item).'</option>';
                            }
                        ?>
                        </select>
                        
                        <label for="sort">Sort</label>
                        <select name="sort" id="order">
                        <?php
                            foreach($array_order as $item){
                                $selected = $order == $item ? 'selected="selected"' : '';
                                echo '<option value="'.$item.'" '.$selected.'>'.$item.'</option>';
                            }
                        ?>
                        </select>                        
                        
                        <label for="results">Results</label> 
                        <select name="results" id="results">
                        <?php
                            foreach($array_count as $item){
                                $selected = $results == $item ? 'selected="selected"' : '';
                                echo '<option value="'.$item.'" '.$selected.'>'.$item.'</option>';
                            }
                        ?>
                        </select>  
                        <input type="hidden" name="from" value="<?php echo isset($_GET['from']) ? $_GET['from'] : ''; ?>"/>
                        <input type="hidden" name="query" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>"/>                        
                        <input type="submit" class="submit filter" value="filter" style="margin:4px -20px 0 0;"/>
                        </form>
        				<table class="data display">
        					<thead>
        						<tr>
        							<th width="6%">ID</th>
        							<th width="34%">Url</th>
                                    <th width="10%">Hits</th>
                                    <th width="20%">Via</th>
                                    <th width="20%">Date</th>
        							<th width="10%">Actions</th>
        						</tr>
        					</thead>
        					<tbody>
                            <?php
                            if ( $urls ){
                                $html = '';
                                foreach($urls as $url ){
                                    $tr_style = $url['inactive']=='1' ? 'inactive ' : 'normal ';
                                    $html .= '<tr class="'.$tr_style.'">';
                                    $html .= '<td>'.$url['ID'].'</td>';
                                    $html .= '<td><a href="'.$config['base_url'].$url['short'].'" target="_blank" data-tip="'.htmlspecialchars_decode($url['url']).'">'.$config['base_url'].$url['short'].'</a></td>';
                                    $html .= '<td>'.$url['hits'].'</td>';
                                    $html .= '<td>'.$url['via'].'</td>';
                                    $html .= '<td>'.$url['created'].'</td>';
                                    $html .= '<td><a href="edit.php?action=edit&from=urls&id='.$url['ID'].'">edit</a> | <a href="edit.php?action=delete&from=urls&id='.$url['ID'].'" rel="askdelete">delete</a></td>';
                                    $html .= '</tr>'."\r\n";
                                }
                                echo $html;
                            }
                            ?>                    
        						</tbody>
        					</table>                    
                </div>
                <?php echo $pager->render();?>
            </div><!-- end main-->
                                             			
			<footer>
				<p><?php echo $config['site_name'] . ' ' . SHRINKY_VERSION; ?> Copyright &copy; <a href="http://script.cr.ma" target=_blank>Shrinky </a> -- All Rights Reserved </span></p>
			</footer><!-- end footer-->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
            <script>window.jQuery || document.write('<script src="../js/libs/jquery-1.7.1.min.js"><\/script>')</script>
            <script src="../js/jquery.datepick.js"></script>
            <script src="js/boxy.js"></script>
            <script src="js/script.js"></script>               
</body><!-- end-->
</html>