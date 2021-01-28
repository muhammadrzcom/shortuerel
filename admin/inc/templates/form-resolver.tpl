<!doctype html> 
<html lang="en"> 
<head> 
	<meta charset="utf-8" /> 
	<title>Shrinky | Settings</title>
    <link rel="alternate" type="application/rss+xml" title="Latest Urls" href="<?php echo $config['base_url'].'feed.rss?token='.$config['token']; ?>" />
    <link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/style.css" />
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
                <li class="selected"><a href="resolver.php">resolver</a></li>
                <li><a href="banned.php">banned</a></li>
                <li><a href="clients.php">clients</a></li>
                <li><a href="settings.php">settings</a></li>
            </ul>
    </header>
            <div id="main">
                <div class="fullwidth">
                    <form action="<?php echo $config['base_url'].'admin/inc/';?>form-resolver.php" class="form" autocomplete="off" method="post">
<?php if($action=='edit') { ?>
                    	<p>
                    		<label for="id">ID:</label>
                            <input type="text" name="id" id="id" value="<?php echo $data['ID'];?>" readonly="readonly"/>
                    	</p>
<?php } ?>
                    	<p>
                    		<label for="host">Host:</label>
                            <input type="text" name="host" id="host" value="http://<?php echo $data['host'];?>"/>
                    	</p>
                        
                    	<p>
                    		<label for="name">Name:</label>
                            <input type="text" name="name" id="name" value="<?php echo $data['name'];?>"/>
                    	</p>                                                
                            
                    	<p>
                    		<input type="hidden" value="<?php echo $action; ?>" name="action"/>
                            <input type="submit" name="save" class="submit" value="Save" />
                    	</p>
                    </form>

                </div>
            </div><!-- end main-->
            
            <div id="nav"></div><!-- end nav-->                                 			
			
			<footer>
				<p><?php echo $config['site_name'] . ' ' . SHRINKY_VERSION; ?> Copyright &copy; <a href="http://script.cr.ma" target=_blank>Shrinky </a> -- All Rights Reserved </span></p>
			</footer><!-- end footer-->
</body><!-- end-->
</html>