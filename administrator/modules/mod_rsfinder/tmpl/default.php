<?php
/**
* @version 1.0.0
* @package RSFinder! 1.0.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); ?>

<div id="rsfinder">
	<input type="text" id="rsfinder_input" autocomplete="off" />
	<div id="rsfinder_results_container">
		<ul id="rsfinder_results_list"></ul>
	</div>
</div>

<script type="text/javascript">
	var browser=navigator.appName;
	if(browser == 'Opera')document.onkeyup = RSFinder.checkKeycode;
	else document.onkeydown = RSFinder.checkKeycode;
	document.getElementById('rsfinder_input').onkeyup = RSFinder.timerGenerateResults;
	var xmlHttp = null;
	var rs_results = null;
</script>