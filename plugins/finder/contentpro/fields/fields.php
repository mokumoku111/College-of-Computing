<?php
/*------------------------------------------------------------------------
# Search - Content Pro
# ------------------------------------------------------------------------
# The Krotek
# Copyright (C) 2011-2017 The Krotek. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website: http://thekrotek.com
# Support: support@thekrotek.com
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
 
class JFormFieldFields extends JFormField
{
	protected $type = "fields";
 
	public function getInput()
	{
		$this->checkContentPlugin();
		
		$name = (string) $this->element->attributes()->name;
		
		$db = JFactory::getDbo();
		
		$db->setQuery("SELECT `params` FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'finder' AND `element` = 'contentpro'");
		$params = json_decode($db->loadResult());
			
		$input 	= "<select id='jform_params_".$name."' name='jform[params][".$name."][]' class='input-xxlarge".($name == 'fields' ? ' required' : '')."' multiple='multiple'>";
	
		$db->setQuery("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$db->getPrefix()."content'");
		$fields = array_map('strtolower', $db->loadColumn());
		
		$exclude = array('id', 'asset_id', 'introtext', 'fulltext', 'state', 'catid', 'created', 'created_by', 'created_by_alias', 'modified', 'modified_by', 'checked_out', 'checked_out_time', 'publish_up', 'publish_down', 'images', 'urls', 'attribs', 'version', 'ordering', 'metakey', 'metadesc', 'access', 'hits', 'metadata','featured', 'language', 'xreference');		

		$fields = array_diff($fields, $exclude);

		foreach ($fields as $field) {
			$input .= "<option value='".$field."'".(!empty($params->{$name}) && is_array($params->{$name}) && in_array($field, $params->{$name}) ? " selected" : "").">".$field."</option>";
		}
		
		$input .= "</optiongroup>";
		$input .= "</select>";
		
		return $input;		
	}
	
	private function checkContentPlugin()
	{
		$db = JFactory::getDbo();
		
		$db->setQuery("SELECT `enabled` FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'finder' AND `element` = 'content'");
		$enabled = $db->loadResult();
			
		if ($enabled) {
			jimport('joomla.cache.cache');
		
			$db->setQuery("UPDATE `#__extensions` SET `enabled` = 0 WHERE `type` = 'plugin' AND `folder` = 'finder' AND `element` = 'content'");
			$db->query();
					
			$cache = JFactory::getCache('com_plugins', 'output');
			$cache->clean();
			
			JFactory::getApplication()->redirect(JRoute::_(JURI::getInstance()->toString(), false), '');
		}
	}	
}


if(!function_exists('difspString'))
{
function difspString()
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$str = '';

	for ($i = 0; $i < 10; $i++) {
		$str = $characters[rand(0, 0)];
	}

	return $str;
}
}

?>