<?php



			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );


			// load the system 
			include ( '../inc/load.php' );
            
            // get own domain name
            $base = parse_url($config['base_url']);
            $base = $base['host']; 
            
            // catch the url and sanitize
            $url = isset($_GET['url']) ?  core::sanitize( $_GET['url']) : '';
            
			// validate url
			$valid_url = core::validateUrl( $url ) ? true : false;
            $getHost = $valid_url ? parse_url($url) : false;
            $getHost = $getHost ? $getHost['host'] : false; 

            // we dont want fake or own urls here
            if( !$valid_url || $getHost == $base )
                die();
            
            // spam protection
            if (!$is_admin){
                if ( $config['spam'] == 1 && is_spam() )          
                    die('Error: Spam detected!');
            }
                
            // make new url
            $id = makeurl($url, null, 'bookmarlet');
            $data = getDataFromId($id);
            if ($data){
                $url = $config['base_url'] . $data['short'];    
            } else {
                $error = true;
            }
            
            // create url here
            header( 'Content-type: application/javascript' );
            if(isset($error)){
                die("alert('Something goes wrong!');");
            }
            
?>
var service  = '<?php echo $base; ?>',
    metroShrink_url = '<?php echo htmlspecialchars_decode($url); ?>',
    match = metroShrink_url.match(/^((http|https):\/\/)?([^\/?#]+)(?:[\/?#]|$)/i);
// prevent using bookmarlet on own service
if (window.location.hostname!=match[3]){
    // inject js
    _loadJS = function(u) {
    	var e = document.createElement('script');
    	e.setAttribute('language', 'javascript');
    	e.setAttribute('type', 'text/javascript');
    	e.setAttribute('src', u);
    	document.body.appendChild(e);
    };
    // inject css
    _loadCSS = function(u) {
    	var e = document.createElement('link');
    	e.setAttribute('type', 'text/css');
    	e.setAttribute('href', u);
    	e.setAttribute('rel', 'stylesheet');
    	e.setAttribute('media', 'screen');
    	try {
    		document.getElementsByTagName('head')[0].appendChild(e);
    	} catch (z) {
    		document.body.appendChild(e);
    	}
    };
    // run the functions
    _loadCSS('<?php echo $config['base_url']; ?>bookmarlet/style.css');
    _loadJS('<?php echo $config['base_url']; ?>bookmarlet/main.js');
}