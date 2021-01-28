<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
<title>Login | Shrinky Panel</title>
</head>
<body>
	<h1>Control Panel</h1>
	<p class="info">use your credentials to Login.</p>
        <form action="<?php echo $config['base_url'].'admin/inc/';?>auth.php" method="post" autocomplete="off">
            <p>
                <input name="username" type="text" id="username" class="input large" placeholder="username" />
            </p>
            <p>
                <input name="password" type="password" id="password" class="input large" placeholder="password" />
            </p>
            <p>
                <input type="submit" name="Submit" id="button" value="Login" class="submit"/>
                <div id="loader"></div>
            </p>
	</form>

<footer>
				<p><?php echo $config['site_name'] . ' ' . SHRINKY_VERSION; ?> Copyright &copy; <a href="http://script.cr.ma" target=_blank>Shrinky </a> -- All Rights Reserved </span></p>
			</footer><!-- end footer-->


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/libs/jquery-1.7.1.min.js"><\/script>')</script>
    <script src="js/login.js"></script>            
</body>
</html>