// @version 1.0.0
// @package RSFinder! 1.0.0
// @copyright (C) 2009-2010 www.rsjoomla.com
// @license GPL, http://www.gnu.org/licenses/gpl-2.0.html

var RSFinder = {}
var generateResultsTimer = 0;

RSFinder = {
	keys: {
		esc: 	27,
		down: 	40,
		up: 	38,
		enter: 	13
	},
	
	checkKeycode: function(e) {
		var keycode;
		if (window.event) {
			keycode = window.event.keyCode;
			ctrlKey = window.event.ctrlKey;
		} else if (e) {
			keycode = e.which;
			ctrlKey = e.ctrlKey;
		}
		
		if (ctrlKey && keycode == RSFinder.keys.up) {
			document.getElementById('rsfinder_input').focus();
			document.getElementById('rsfinder_input').value = '';
		}
		if (keycode == RSFinder.keys.esc) {
			document.getElementById('rsfinder_results_container').style.display = 'none';
		}
		if (keycode == RSFinder.keys.down) {
			RSFinder.nextItem('down', rs_results);
		}
		if (keycode == RSFinder.keys.up) {
			RSFinder.nextItem('up', rs_results);
		}
		if (keycode == RSFinder.keys.enter) {
			RSFinder.gotoItem(rs_results);
		}
	},

	gotoItem: function(items) {
		for (i=0; i<items; i++)
			if (document.getElementById('result_' + i).className == 'rsActive')
				document.location = document.getElementById('result_' + i).href;
	},

	nextItem: function(direction, items) {
		if (items > 0) {
			current_active = -1;
			//get active item
			for (i=0; i<items; i++) {
				if (document.getElementById('result_' + i)) {
					if (document.getElementById('result_' + i).className == 'rsActive') {
						current_active = i;
					}
				}
			}
			
			if (direction == 'up') {
				current_active -= 1;
			} else {
				current_active += 1;
			}
			
			if (current_active == -1) {
				current_active = items-1;
			}
			if (current_active == items) {
				current_active = 0;
			}
			
			for (i=0; i<items; i++) {
				if (document.getElementById('result_' + i)) {
					document.getElementById('result_' + i).className = 'rsInactive';
				}
				if (i==current_active) {
					if(document.getElementById('result_' + i)) {
						document.getElementById('result_' + i).className = 'rsActive';
					}
				}
			}
		}
	},

	resolveMouseOver: function(items) {
		if (items > 0) {
			for (i=0; i<items; i++) {
				if (document.getElementById('result_' + i)) {
					document.getElementById('result_' + i).onmouseover = function(){
						for (i=0;i<items;i++) {
							document.getElementById('result_' + i).className = 'rsInactive';
						}
						this.className = 'rsActive';
					}
					document.getElementById('result_' + i).onmouseout = function() {
						this.className = 'rsInactive';
					}
				}
			}
		}
	},


	timerGenerateResults: function(evt) {
		if (generateResultsTimer > 0) {
			clearTimeout(generateResultsTimer);
		}
		
		generateResultsTimer = setTimeout(function(){ RSFinder.generateResults(evt); }, 1000);
	},

	generateResults: function(e) {
		var keycode;
		if (window.event) keycode = window.event.keyCode;
		else if (e) keycode = e.which;
		
		var textbox = document.getElementById('rsfinder_input');
		
		if (document.getElementById('rsfinder_input').value.length > 1 && keycode != RSFinder.keys.up && keycode != RSFinder.keys.down && keycode != RSFinder.keys.esc) {
			textbox.className = 'loading'
			query = document.getElementById('rsfinder_input').value;
			xmlHttp=RSFinder.createXMLHttpRequest();
			xmlHttp.open("GET", "index.php?rsquick=" + encodeURIComponent(query), true);
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4) 
				{
					var response = '<li class="rsClose"><a href="javascript:void(0);" onclick="RSFinder.close();">x</a></li>';
					response += xmlHttp.responseText;
					
					document.getElementById('rsfinder_results_list').innerHTML = response;
					document.getElementById('rsfinder_results_container').style.display='block';
					rs_results = xmlHttp.responseText.split("\n").length - 1;
					RSFinder.nextItem('down',1);
					RSFinder.resolveMouseOver(rs_results);
					
					textbox.className = '';
				}
			}
			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlHttp.setRequestHeader("Content-length", 1000);
			xmlHttp.setRequestHeader("Connection", "close");
			xmlHttp.send(null);
		} else {
			document.getElementById('rsfinder_results_list').innerHTML = '';
			textbox.className = '';	
		}
	},

	createXMLHttpRequest: function() {
		//Ajax script to create the browser based ActiveXObject object
		var xmlHttpRequest = false;
		try
		{
			if(window.ActiveXObject)
			{
				for(var i = 5; i; i--)
				{
					try
					{
						if(i == 2)
						{
							xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
						}
						 else
						{
							xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP." + i + ".0");
						}
						break;
					}
					catch(excNotLoadable)
					{
						xmlHttpRequest = false;
					}
				}
			}
			else if(window.XMLHttpRequest)
			{
				xmlHttpRequest = new XMLHttpRequest();
			}
		}
		catch(excNotLoadable)
		{
			xmlHttpRequest = false;
		}
		return xmlHttpRequest;
	},
	
	close: function() {
		document.getElementById('rsfinder_results_list').innerHTML = '';
		document.getElementById('rsfinder_input').className = '';	
	}
}