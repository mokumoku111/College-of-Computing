<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_jmgarticleslider
 *
 * @copyright   Copyright (C) 2021 - 2029 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

//$document = JFactory::getDocument();
//$document->addScript('/modules/mod_jmgarticleslider/assets/js/helper.js');

// Include the helper
JLoader::register('modJmgArticlesliderHelper', JPATH_SITE . '/modules/mod_jmgarticleslider/helper.php');

jimport('joomla.form.formfield');
jimport('joomla.filesystem.file');

 Jhtml::_('behavior.modal');

// The class name must always be the same as the filename (in camel case)
class JFormFieldInfo extends JFormField {

    //The field class must know its own type through the variable $type.
    protected $type = 'Info';  

    public function getInput() {
		
	$xml = simplexml_load_file(JPATH_ROOT . '/modules/mod_jmgarticleslider/mod_jmgarticleslider.xml');
	$uri = JURI::getInstance();
	$lang = JFactory::getLanguage();
	$downloadid = modJmgArticlesliderHelper::getDownloadId();
	$info = array();
	
	$info[] = '<link rel="stylesheet" href="../modules/mod_jmgarticleslider/theme/css/admin.css" type="text/css" />';
	$info[] = '<div class="jmg-admin-panel">';
	$info[] = '<div class="jmg-admin-row">';
	$info[] = '<div class="jmg-admin-col-3">';
	$info[] = '<a href="https://www.shop.framotec.com/detail/index/sArticle/57/sCategory/14" target="_blank">';
	$info[] = '<img src="../modules/mod_jmgarticleslider/assets/img/JMG-Articleslider.png" alt="JMG Articleslider">';
	$info[] = '</a>';
	$info[] = '</div>';
	$info[] = '<div class="jmg-admin-col-9">';
	$info[] = '<h3>JMG Articleslider</h3>';
	$info[] = '<p><span class="key"><i>Version '.$xml->version.'</i></span></p>';
	$info[] = '<p><span class="key">'.JText::_('MOD_JMGARTICLESLIDER_DOWNLOAD_ID').':</span> '.$downloadid;
	if($downloadid){
		$info[] = '<span class="icon-save"> </span>';
	}
	else{
		$info[] = '<span class="label label-important">'.JText::_('MOD_JMGARTICLESLIDER_NOT_VALID').'</span>';
	}		
	$info[] = '<br>';	
	$info[] = '<span class="key">'.JText::_('MOD_JMGARTICLESLIDER_DOMAIN').':</span> '.$uri->getHost();
	$info[] = '<span class="icon-save"> </span>';	
	$info[] = '<br>';
	$info[] = '</p>';
	if(!$downloadid){
		$info[] = '<p><a href="'.JURI::base().'index.php?option=com_plugins&view=plugins&filter_search=jmg license manager" class="btn btn-danger">'.JText::_('MOD_JMGARTICLESLIDER_DOWNLOAD_ID_BUTTON').'</a></p>';
	}
	$info[] = '</div>';
	$info[] = '</div>';
	$info[] = '</div>';
		
	return implode("\n", $info);
    }
}