<!doctype html> 
<html lang="en"> 
<head> 
	<meta charset="utf-8" /> 
	<title>Shrinky | Dashboard</title>
    <link rel="alternate" type="application/rss+xml" title="Latest Urls" href="<?php echo $config['base_url'].'feed.rss?token='.$config['token']; ?>" />
    <link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/boxy.css" />
</head>

<!-- body -->
<body>

    <header>
        <div class="logo"><p>administration</p></div>
        <div class="logged"><p>Welcome, <span><?php echo $config['username']; ?></span> | <a href="logout.php">Logout</a></p></div>
            <ul class="navigation">
                <li class="selected"><a href="index.php">dashboard</a></li>
                <li><a href="urls.php">urls</a></li>
                <li><a href="ads.php">ads</a></li>
                <li><a href="resolver.php">resolver</a></li>
                <li><a href="banned.php">banned</a></li>
                <li><a href="clients.php">clients</a></li>
                <li><a href="settings.php">settings</a></li>
            </ul>
    </header>
            <div id="main">
                <div class="fullwidth">
        			<div id="big_stats">
        				<div class="stat">
        					<h4>Total Urls</h4>
        					<span class="value"><?php echo $total_urls;?></span>
        				</div>
        				<div class="stat">
        					<h4>Today Urls</h4>
        					<span class="value"><?php echo $today_urls;?></span>
        				</div>
        				<div class="stat">
        					<h4>Active Ads</h4>
        					<span class="value"><?php echo $total_ads;?></span>
        				</div>                      
        				<div class="stat">
        					<h4>Total Hits</h4>
        					<span class="value"><?php echo $total_hits;?></span>
        				</div>
        			</div>
                    <h1>Latest urls</h1>
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
                                    $tr_style = $url['inactive']=='1' ? 'inactive' : 'normal';
                                    $html .= '<tr class="row '.$tr_style.'" data-id="'.htmlspecialchars_decode($url['ID']).'">';
                                    $html .= '<td>'.$url['ID'].'</td>';
                                    $html .= '<td><a href="'.$config['base_url'].$url['short'].'" target="_blank"  data-tip="'.$url['url'].'">'.$config['base_url'].$url['short'].'</a></td>';
                                    $html .= '<td>'.$url['hits'].'</td>';
                                    $html .= '<td>'.$url['via'].'</td>';
                                    $html .= '<td>'.$url['created'].'</td>';
                                    $html .= '<td><a href="edit.php?action=edit&from=urls&id='.$url['ID'].'" rel="edit">edit</a> | <a href="edit.php?action=delete&from=urls&id='.$url['ID'].'" rel="askdelete">delete</a></td>';
                                    $html .= '</tr>'."\r\n";
                                }
                                echo $html;
                            }
                            ?>                    
        						</tbody>
        					</table>                   
                </div>
            </div><!-- end main-->
            <div id="nav"></div><!-- end nav-->                                 			
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