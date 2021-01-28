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
        <div class="logged"><p>Welcome, <span><?php echo $config['username']; ?></span> | <a href="logout.php">Logout</a> | <a href="<?php echo $config['base_url'].'feed.rss?token='.$config['token']; ?>">rss</a></p></div>
            <ul class="navigation">
                <li><a href="index.php">dashboard</a></li>
                <li><a href="urls.php">urls</a></li>
                <li><a href="ads.php">ads</a></li>
                <li><a href="resolver.php">resolver</a></li>
                <li><a href="banned.php">banned</a></li>
                <li><a href="clients.php">clients</a></li>
                <li class="selected"><a href="settings.php">settings</a></li>
            </ul>
    </header>
            <div id="main">
                <div class="fullwidth">
                    <form action="<?php echo $config['base_url'].'admin/inc/';?>form-settings.php" class="form" autocomplete="off" method="post">
                    
                    	<p>
                    		<label for="site_name">Site Name:</label>
                            <input type="text" name="site_name" id="site_name" value="<?php echo $config['site_name'];?>"/>
                    	</p>
                        
                    	<p>
                    		<label for="base_url">Base Url:</label>
                            <input type="text" name="base_url" id="base_url" value="<?php echo $config['base_url'];?>"/>
                    	</p>  
<p>
                    		<label for="shrinky_template">Template:</label>
                            <select name="shrinky_template" id="shrinky_template">


<?php
$dir = '../inc/templates/';
$template = scandir($dir);
$template = array_slice($template, 2);

	$options = array();
        $html = '';
        foreach ( $template as $value )
        {
            $selected = $config['shrinky_template'] == $value ? 'selected="selected"' : '';
            $html .= '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
        }
        echo $html;
  
?>


                            </select>                             
                    	</p>                       
                    
                    	<p>
                    		<label for="multi_max">MultiShrink Max Urls:</label>
                            <input type="number" min="0" max="100" name="multi_max" id="multi_max" value="<?php echo $config['multi_max'];?>" />
                    	</p>
                    
                    	<p>
                    		<label for="use_ads">Advertising:</label>
                            <select name="use_ads" id="use_ads">
<?php
        $options = array( 'Enabled' => 1, 'Disabled' => '' );
        $html = '';
        foreach ( $options as $key => $value )
        {
            $selected = $config['use_ads'] == $value ? 'selected="selected"' : '';
            $html .= '<option value="' . $value . '" ' . $selected . '>' . $key . '</option>';
        }
        echo $html;
?>
                            </select>                             
                    	</p>
                        
                    	<p>
                    		<label for="default_ad">Default Ad:</label>
                            <input type="text" name="default_ad" id="default_ad" value="<?php echo $config['default_ad'];?>" />
                    	</p>
                        
                    	<p>
                    		<label for="spam">Spam protection:</label>
                            <select name="spam" id="spam">
<?php
        $options = array( 'Enabled' => 1, 'Disabled' => '' );
        $html = '';
        foreach ( $options as $key => $value )
        {
            $selected = $config['spam'] == $value ? 'selected="selected"' : '';
            $html .= '<option value="' . $value . '" ' . $selected . '>' . $key . '</option>';
        }
        echo $html;
?>
                            </select>                             
                    	</p> 
                        
                    	<p>
                    		<label for="spam_max">Spam Max Urls:</label>
                            <input type="number" min="0" max="1000" name="spam_max" id="spam_max" value="<?php echo $config['spam_max'];?>" />
                    	</p>
                        
                    	<p>
                    		<label for="spam_time">Spam Timeout:</label>
                            <input type="number" min="0" max="3600" name="spam_time" id="spam_time" value="<?php echo $config['spam_time'];?>" />
                    	</p>

			<p>
                    		<label for="shrinky_email">Contact Email:</label>
                            <input type="text" name="shrinky_email" id="shrinky_email" value="<?php echo $config['shrinky_email'];?>" />
                    	</p>


			<p>
                    		<label for="google_adsense">Google Adsense ID:</label>
                            <input type="text" name="google_adsense" id="google_adsense" value="<?php echo $config['google_adsense'];?>" />
                    	</p>
                                                                        

                    	<p>
                    		<label for="timezone">Timezone:</label>
                            <select name="timezone" id="timezone">
<?php
        $html = '';
        foreach ( $timezones as $value )
        {
            $selected = $config['timezone'] == $value ? 'selected="selected"' : '';
            $html .= '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
        }
        echo $html;
?>
                            </select> 
                    	</p>                        
                    
                    	<p>
                    		<label for="pattern">Custom Pattern:</label>
                            <input type="text" name="pattern" id="pattern" value="<?php echo $config['pattern'];?>" />
                    	</p>

                    	<p>
                    		<label for="google_tracking">Google Analytics:</label>
                            <input type="text" name="google_tracking" id="google_tracking" value="<?php echo $config['google_tracking'];?>" />
                    	</p>
                        
                    	<p>
                    		<label for="token">Secret Token:</label>
                            <input type="text" name="token" id="token" value="<?php echo $config['token'];?>" />
                    	</p>                        
                                            
                    	<p>
                    		<input type="submit" name="save" class="submit" value="Save" />
                    	</p>
                    </form>
                    <form action="<?php echo $config['base_url'].'admin/inc/';?>form-user.php" class="form" autocomplete="off" method="post">
                    
                    	<p>
                    		<label for="username">Username:</label>
                            <input type="text" name="username" id="username" value="<?php echo $config['username'];?>"/>
                    	</p>

                    	<p>
                    		<label for="current_password">Current Password:</label>
                            <input type="password" name="current_password" id="current_password" value="" />
                    	</p>                        
                    
                    	<p>
                    		<label for="new_password">New Password:</label>
                            <input type="password" name="new_password" id="new_password" value="" />
                    	</p>

                    	<p>
                    		<label for="repeat_password">Repeat Password:</label>
                            <input type="password" name="repeat_password" id="repeat_password" value="" />
                    	</p>
                        
                    	<p>
                    		<input type="submit" name="update" class="submit" value="update" />
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