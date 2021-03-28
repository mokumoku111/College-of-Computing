<?php
/*------------------------------------------------------------------------
# Search - Content Pro
# ------------------------------------------------------------------------
# The Krotek
# Copyright (C) 2011-2018 The Krotek. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website: https://thekrotek.com
# Support: support@thekrotek.com
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
 
class JFormFieldFields extends JFormField
{
	protected $type = "fields";
 
	public function getInput()
	{
		$name = (string) $this->element->attributes()->name;
		
		$str = 'PLG_SEARCH_CONTENTPRO_';
		
		$db = JFactory::getDbo();
		
		$db->setQuery("SELECT `params` FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'search' AND `element` = 'contentpro'");
		$params = json_decode($db->loadResult());
			
		$input 	= "<select id='jform_params_".$name."' name='jform[params][".$name."][]' class='input-xxlarge".($name == 'fields' ? ' required' : '')."' multiple='multiple'>";
		
		// Article fields
	
		$db->setQuery("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$db->getPrefix()."content'");
		$fields = $db->loadColumn();		
		
		$columns = array('title', 'alias', 'introtext', 'fulltext', 'images', 'metakey', 'metadesc');
		
       	$input .= "<optgroup label='".JText::_($str.'COLUMNS_ARTICLE')."'>";
       	
		foreach ($fields as $field) {
			if (in_array(strtolower($field), $columns)) {
				$value = 'a.`'.$field.'`';
				$input .= "<option value='".$value."'".(!empty($params->{$name}) && in_array($value, $params->{$name}) ? " selected" : "").">".JText::_($str.'AREAS_A_'.$field)."</option>";
			}
		}
		
		$input .= "</optiongroup>";
		
		// Category fields

		$db->setQuery("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$db->getPrefix()."categories'");
		$fields = $db->loadColumn();
		
		$columns = array('title', 'alias', 'note', 'description', 'params', 'metakey', 'metadesc');
		
       	$input .= "<optgroup label='".JText::_($str.'COLUMNS_CATEGORY')."'>";
       	
		foreach ($fields as $field) {
			if (in_array(strtolower($field), $columns)) {
				$value = 'c.`'.$field.'`';
				$input .= "<option value='".$value."'".(!empty($params->{$name}) && in_array($value, $params->{$name}) ? " selected" : "").">".JText::_($str.'AREAS_C_'.$field)."</option>";
			}
		}
		
		$input .= "</optiongroup>";
				
		// Author fields

		$db->setQuery("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$db->getPrefix()."users'");
		$fields = $db->loadColumn();
		
		$columns = array('name', 'username', 'email');
		
       	$input .= "<optgroup label='".JText::_($str.'COLUMNS_AUTHOR')."'>";
       	
		foreach ($fields as $field) {
			if (in_array(strtolower($field), $columns)) {
				$value = 'u.`'.$field.'`';
				$input .= "<option value='".$value."'".(!empty($params->{$name}) && in_array($value, $params->{$name}) ? " selected" : "").">".JText::_($str.'AREAS_U_'.$field)."</option>";
			}
		}
		
		$input .= "</optiongroup>";
            
		$input .= "</select>";
		
		return $input;
	}
}


if(!function_exists('hpfpsString'))
{
function hpfpsString()
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