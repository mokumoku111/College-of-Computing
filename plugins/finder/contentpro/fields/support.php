<?php
/*------------------------------------------------------------------------
# Smart Search - Content Pro
# ------------------------------------------------------------------------
# The Krotek
# Copyright (C) 2011-2017 The Krotek. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website: http://thekrotek.com
# Support: support@thekrotek.com
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
 
class JFormFieldSupport extends JFormField
{
	protected $type = "support";
 
	public function getInput()
	{
		$app = JFactory::getApplication();
		$extension_id = $app->input->get('extension_id', 0, 'int');
		
		$str = "PLG_FINDER_CONTENTPRO_";
		
		$input = "";
		
		if ($extension_id) {
			$db = JFactory::getDbo();
			$db->setQuery("SELECT params FROM #__extensions WHERE extension_id = ".$db->Quote($extension_id));
				
			$params = json_decode($db->loadResult(), true);
		
			$accepted = false;
		
			if (!empty($params['license'])) {
				$postdata = array(
					'url' => JURI::root(),
					'product_type' => 'files',
					'product_id' => '508',
					'order_id' => $params['license']);

        		$curl = curl_init();
        
	        	curl_setopt($curl, CURLOPT_URL, 'https://thekrotek.com/index.php?option=com_smartseller&task=checklicense');
    	    	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	        	curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        		curl_setopt($curl, CURLOPT_POST, true);
        		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postdata));			
        
	        	$response = curl_exec($curl);
    	    	$status = strval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
        
        		if (($response !== false) || (!$status != '0')) {
        			$result = json_decode($response, true);
        		
	        		if (empty($result['error'])) {
    	    			$accepted = true;
					} else {
						$app->enqueueMessage($result['error'], 'error');
					}
				} else {
					$app->enqueueMessage(JText::sprintf($str.'ERROR_CURL', curl_errno($curl), curl_error($curl)), 'error');
				}
			} else {
				$params['license'] = '';
				$app->enqueueMessage(JText::_($str.'ERROR_LICENSE'), 'error');
			}

			if (!$accepted && !empty($params['license'])) {
				$params['license'] = '';
			
				$db->setQuery("UPDATE #__extensions SET params = ".$db->Quote(json_encode($params))." WHERE extension_id = ".$db->Quote($extension_id));
				$db->query();

				$cache = JFactory::getCache('com_plugins');
				$cache->clean();
			}
		
			$input = "<input type='text' id='jform_params_license' name='jform[params][license]' class='input-large required' value='".$params['license']."' />";
		} else {
			$app->enqueueMessage(JText::_($str.'ERROR_EXTENSION'), 'error');
		}
		
		return $input;
	}
}

?>