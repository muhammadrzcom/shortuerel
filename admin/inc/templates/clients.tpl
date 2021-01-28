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
                <li><a href="urls.php">urls</a></li>
                <li><a href="ads.php">ads</a></li>
                <li><a href="resolver.php">resolver</a></li>
                <li><a href="banned.php">banned</a></li>
                <li class="selected"><a href="clients.php">clients</a></li>
                <li><a href="settings.php">settings</a></li>
            </ul>
    </header>
            <div id="main">
                <div class="fullwidth">
                        <form method="get" class="filter">
                        
                        <label for="order_by">Order by</label>                         
                        <select name="order_by" id="order_by">
                        <?php
                            foreach($array_by as $item){
                                $selected = $order_by == $item ? 'selected="selected"' : '';
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
                        <input type="button" class="submit filter" value="add New" onClick="window.location.href='edit.php?action=new&from=clients'" style="margin:4px -20px 0 0;" />
                        <input type="submit" class="submit filter" value="filter" style="margin:4px 20px 0 0;"/>
                        </form>
        				<table class="data display">
        					<thead>
        						<tr>
        							<th width="10%">ID</th>
        							<th width="15%">IP</th>
                                    <th width="45%">Description</th>
                                    <th width="20%">Date</th>                                    
        							<th width="10%">Actions</th>
        						</tr>
        					</thead>
        					<tbody>
                            <?php
                            if ( $urls ){
                                $html = '';
                                foreach($urls as $url ){
                                    $html .= '<tr>';
                                    $html .= '<td>'.$url['ID'].'</td>';
                                    $html .= '<td>'.$url['ip'].'</td>';
                                    $html .= '<td>'.$url['description'].'</td>';
                                    $html .= '<td>'.$url['date'].'</td>';
                                    $html .= '<td><a href="edit.php?action=edit&from=clients&id='.$url['ID'].'">edit</a> | <a href="edit.php?action=delete&from=clients&id='.$url['ID'].'" rel="askdelete">delete</a></td>';
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