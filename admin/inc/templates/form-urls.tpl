<!doctype html> 
<html lang="en"> 
<head> 
	<meta charset="utf-8" /> 
	<title>Shrinky | Settings</title>
    <link rel="alternate" type="application/rss+xml" title="Latest Urls" href="<?php echo $config['base_url'].'feed.rss?token='.$config['token']; ?>" />
    <link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/date-picker.css" />
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
    </header>
            <div id="main">
                <div class="fullwidth">
                    <form action="<?php echo $config['base_url'].'admin/inc/';?>form-urls.php" class="form" autocomplete="off" method="post">
                    
                    	<p>
                    		<label for="id">ID:</label>
                            <input type="text" name="id" id="id" value="<?php echo $data['ID'];?>" readonly="readonly"/>
                    	</p>
                        
                    	<p>
                    		<label for="url">Url:</label>
                            <input type="text" name="url" id="url" value="<?php echo $data['url'];?>"/>
                    	</p>
                        
                    	<p>
                    		<label for="via">Via:</label>
                            <input type="text" name="via" id="via" value="<?php echo $data['via'];?>"/>
                    	</p>                                                

                    	<p>
                    		<label for="private">Listed:</label>
                            <select name="private" id="private">
<?php
        $options = array( 'Private' => 1, 'Public' => '' );
        $html = '';
        foreach ( $options as $key => $value )
        {
            $selected = $data['private'] == $value ? 'selected="selected"' : '';
            $html .= '<option value="' . $value . '" ' . $selected . '>' . $key . '</option>';
        }
        echo $html;
?>
                            </select>                             
                    	</p>
                        
                    	<p>
                    		<label for="password">Password:</label>
                            <input type="text" name="password" id="password" value="<?php echo $data['password'];?>"/>
                    	</p>
                                               
                    	<p>
                    		<label for="uses">Max Uses:</label>
                            <input type="number" min="1" max="1000000" name="uses" id="uses" value="<?php echo $data['uses'];?>" />
                    	</p>
                    
                    	<p>
                    		<label for="status">Status:</label>
                            <select name="status" id="status">
<?php
        $options = array( 'Inactive' => 1, 'Active' => '' );
        $html = '';
        foreach ( $options as $key => $value )
        {
            $selected = $data['inactive'] == $value ? 'selected="selected"' : '';
            $html .= '<option value="' . $value . '" ' . $selected . '>' . $key . '</option>';
        }
        echo $html;
?>
                            </select>                             
                    	</p>

                    	<p>
                    		<label for="ads">Advertising:</label>
                            <select name="ads" id="ads">
<?php
        $options = array( 'With Ads' => 1, 'Without Ads' => '' );
        $html = '';
        foreach ( $options as $key => $value )
        {
            $selected = $data['ads'] == $value ? 'selected="selected"' : '';
            $html .= '<option value="' . $value . '" ' . $selected . '>' . $key . '</option>';
        }
        echo $html;
?>
                            </select>                             
                    	</p>
                    	
                        <p>
                    		<label for="expire">Expire:</label>
<?php 
        $expire_data = $data['expire']!='0000-00-00 00:00:00'?date('m/d/Y',strtotime($data['expire'])):'';
?>                            
                            <input type="text" name="expire" id="expire" value="<?php echo $expire_data; ?>" readonly="readonly"/>
                    	</p>
                                 
                    	<p>
                    		<input type="submit" name="save" class="submit" value="Save" />
                    	</p>
                    </form>
                   
                </div>
            </div><!-- end main-->
            
            <div id="nav"></div><!-- end nav-->                                 			
			
			<footer>
				<p><?php echo $config['site_name'] . ' ' . SHRINKY_VERSION; ?> Copyright &copy; <a href="http://script.cr.ma" target=_blank>Shrinky </a> -- All Rights Reserved </span></p>
			</footer><!-- end footer-->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
            <script>window.jQuery || document.write('<script src="../js/libs/jquery-1.7.1.min.js"><\/script>')</script>
            <script src="../js/jquery.datepick.js"></script>
            <script src="js/script.js"></script>              
</body><!-- end-->
</html>