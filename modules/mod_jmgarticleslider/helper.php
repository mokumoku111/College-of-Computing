<?php
/**
 * @package    Joomla.Site
 * @subpackage Modules JMG Article Slider
 * @link http://joomega.com
 * @copyright   Copyright (C) 2021 - 2029 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class modJmgArticlesliderHelper
{
	public static function getFunktion($params)
    {   
		return $params;
    }

	public static function getDownloadId()
    {    
		// Get plugin jmg license manager
		$plugin = JPluginHelper::getPlugin('system', 'jmglicensemgr');
		// Check if plugin is enabled
		if ($plugin){
			// Get plugin params
			$pluginParams = new JRegistry($plugin->params);
			$key = $pluginParams->get('key');
			return $key;
		}
    }
	
	public static function getArticles($catid,$max_length)
    {   
		$lang = JFactory::getLanguage();
		$db = JFactory::getDbo();     
		$query = $db->getQuery(true);     
		$query->select('id,catid,title,images,SUBSTRING(introtext, 1, '.$max_length.') AS text')
		 ->from('#__content')
		 ->where('catid = '.$catid) 
		 ->where('language = '.$db->quote($lang->getTag()));
		$db->setQuery($query);     
		$rows = $db->loadObjectList();
		
		return $rows;
    }
}
?>