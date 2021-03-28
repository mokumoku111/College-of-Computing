<?php
/*------------------------------------------------------------------------
# Smart Search - K2 Pro
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
		$this->checkK2Plugin();
		
		$name = (string) $this->element->attributes()->name;
		
		$db = JFactory::getDbo();
		
		$db->setQuery("SELECT `params` FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'finder' AND `element` = 'k2pro'");
		$params = json_decode($db->loadResult());
			
		$input 	= "<select id='jform_params_".$name."' name='jform[params][".$name."][]' class='input-xxlarge".($name == 'fields' ? ' required' : '')."' multiple='multiple'>";
	
		$db->setQuery("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$db->getPrefix()."k2_items'");
		$fields = array_map('strtolower', $db->loadColumn());
		
		$exclude = array('id', 'introtext', 'fulltext', 'published', 'catid', 'created', 'created_by', 'created_by_alias', 'modified', 'modified_by', 'checked_out', 'checked_out_time', 'publish_up', 'publish_down', 'trash', 'params', 'ordering', 'metakey', 'metadesc', 'access', 'hits', 'metadata', 'featured', 'featured_ordering', 'plugins', 'language', 'video', 'gallery', 'extra_fields', 'extra_fields_search');

		$fields = array_diff($fields, $exclude);

		foreach ($fields as $field) {
			$input .= "<option value='".$field."'".(!empty($params->{$name}) && is_array($params->{$name}) && in_array($field, $params->{$name}) ? " selected" : "").">".$field."</option>";
		}
		
		$input .= "</optiongroup>";
		$input .= "</select>";
		
		return $input;		
	}
	
	private function checkK2Plugin()
	{
		$db = JFactory::getDbo();
		
		$db->setQuery("SELECT `enabled` FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'finder' AND `element` = 'k2'");
		$enabled = $db->loadResult();
		
		if ($enabled) {
			jimport('joomla.cache.cache');
		
			$db->setQuery("UPDATE `#__extensions` SET `enabled` = 0 WHERE `type` = 'plugin' AND `folder` = 'finder' AND `element` = 'k2'");
			$db->query();
					
			$cache = JFactory::getCache('com_plugins', 'output');
			$cache->clean();
			
			JFactory::getApplication()->redirect(JRoute::_(JURI::getInstance()->toString(), false), '');
		}
	}	
}

?>