<?php
/**
* @version 1.0.0
* @package RSFinder! 1.0.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if (JPluginHelper::isEnabled('system', 'rsfinder')) {
	$document = JFactory::getDocument();
	$document->addScript(JURI::root(true).'/administrator/modules/mod_rsfinder/assets/js/script.js' );
	$document->addStyleSheet(JURI::root(true).'/administrator/modules/mod_rsfinder/assets/css/style.css');	

	require JModuleHelper::getLayoutPath('mod_rsfinder');
} else {
	echo JText::_('MOD_RSFINDER_PLEASE_ENABLE_PLUGIN');
}