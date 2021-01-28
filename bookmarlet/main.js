(function() {
	// start the main function
	var metroShrink = (typeof(metroShrink) == 'undefined') ? {} : metroShrink;
	var loc = window.location.domain;
	metroShrink.vh = "javascript:void(null);";
	metroShrink.setAttribute = function(e, k, v) {
		if (k == "class") {
			e.setAttribute("className", v); // set both "class" and "className"
		}
		return e.setAttribute(k, v);
	};
	// create elements
	metroShrink.createElement = function(e, attrs) {
		var el = document.createElement(e);
		for (var k in attrs) {
			if (k == "text") {
				el.appendChild(document.createTextNode(attrs[k]));
			} else {
				metroShrink.setAttribute(el, k, attrs[k]);
			}
		}
		return el;
	};
	// make popup
	metroShrink.popup = function(url, width, height) {
		var left = (screen.width - width) / 2,
			top = (screen.height - height) / 2,
			params = 'width=' + width + ', height=' + height;
		params += ', top=' + top + ', left=' + left;
		params += ', directories=no';
		params += ', location=no';
		params += ', menubar=no';
		params += ', resizable=no';
		params += ', scrollbars=no';
		params += ', status=no';
		params += ', toolbar=no';
		newwin = window.open(url, 'mtro_share_window', params);
		if (window.focus) {
			newwin.focus()
		}
		return false;
	};
	// remove function
	metroShrink.remove = function(e) {
		e.parentNode.removeChild(e);
	};
	// event handler for ie and other browsers
	metroShrink.listen = function(elem, evnt, func) {
		if (elem.addEventListener) // W3C DOM
		elem.addEventListener(evnt, func, false);
		else if (elem.attachEvent) { // IE DOM
			var r = elem.attachEvent("on" + evnt, func);
			return r;
		}
	};
	// close handler
	metroShrink.close = function() {
		var overlay = document.getElementById('metroShrink_main');
		if (overlay != undefined) {
			metroShrink.remove(overlay);
		}
		if (metroShrink.timeout_handle != undefined) {
			clearTimeout(metroShrink.timeout_handle);
		}
	};
    
	metroShrink.openTwitter = function() {
		metroShrink.popup('https://twitter.com/?status=' + escape(metroShrink_url), 680, 380);
	}
    
	// start the show
	metroShrink.drawOverlay = function() {
		var overlay = metroShrink.createElement('div');
		overlay.id = 'metroShrink_main';
		var content = metroShrink.createElement('div', {
			'id': '_mtro_content'
		});
		var closeBtn = metroShrink.createElement('div', {
			'id': '_mtro_close',
			'onclick': metroShrink.vh
		});
		metroShrink.listen(closeBtn, 'click', metroShrink.close);
		content.appendChild(closeBtn);
        
		var input = metroShrink.createElement('input', {
			'id': '_mtro_url',
			'type': 'text',
			'value': metroShrink_url,
			'readonly': 'readonly',
			'onclick': 'javascript:this.focus();this.select();',
		});
		content.appendChild(input);
        
		var qrcode = metroShrink.createElement('div', {
			'id': '_mtro_qrcode',
			'class': '_mtro_social arrow-center',
			'style': 'background-image:url(http://chart.apis.google.com/chart?cht=qr&chs=64x64&chl=' + escape(metroShrink_url) + '&chld=L|1);background-position:center center;',
			'data-tip': 'Scan this code!',
			'onclick': 'javascript:window.open("' + metroShrink_url + '.qrcode?download", "_parent");return false;'
		});
		content.appendChild(qrcode);
        
		var twitter = metroShrink.createElement('div', {
				'id': '_mtro_tw',
				'class': '_mtro_social arrow-center',
				'data-tip': 'Share on twitter!',
				'onClick': metroShrink.vh,
			});
        metroShrink.listen(twitter, 'click', function(){
            metroShrink.popup('https://twitter.com/?status=' + escape(metroShrink_url), 680, 380);
        });    
		content.appendChild(twitter);
        
		var facebook = metroShrink.createElement('div', {
				'id': '_mtro_fb',
				'class': '_mtro_social arrow-center',
				'data-tip': 'Share on facebook!',
				'onclick': metroShrink.vh
			});
        metroShrink.listen(facebook, 'click', function(){
            metroShrink.popup('https://www.facebook.com/sharer.php?u=' + escape(metroShrink_url), 680, 380);
        }); 
		content.appendChild(facebook);
        
		var googleplus = metroShrink.createElement('div', {
				'id': '_mtro_gp',
				'class': '_mtro_social arrow-center',
				'data-tip': 'Share on google plus!',
				'onclick': metroShrink.vh
			});
        metroShrink.listen(googleplus, 'click', function(){
            metroShrink.popup('https://plus.google.com/share?url=' + escape(metroShrink_url), 680, 520);
        }); 
		content.appendChild(googleplus);        
        
        
		overlay.appendChild(content);
		document.body.appendChild(overlay);
		// auto hide after 30 secs
		//setTimeout(function() {
		//	try {
		//		metroShrink.close();
		//	} catch (error) {}
		//}, 30000);
	};
	metroShrink.drawOverlay();
})();