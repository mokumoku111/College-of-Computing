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
 
class JFormFieldSupport extends JFormField
{
	protected $type = "support";
 
	public function getInput()
	{
		$app = JFactory::getApplication();
		$extension_id = $app->input->get('extension_id', 0, 'int');
		
		$str = "PLG_FINDER_K2PRO_";
		
		$input = "";
		
		if ($extension_id) {
			$db = JFactory::getDbo();
			$db->setQuery("SELECT params FROM #__extensions WHERE extension_id = ".$db->Quote($extension_id));
				
			$params = json_decode($db->loadResult(), true);
		
			$accepted = false;
		
			if (!empty($params['license'])) {
				$postdata = array(
					'source' => 'joomla',
					'url' => JURI::root(),
					'product_type' => 'files',
					'product_id' => '526',
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
        		
	        		if (!is_null($result)) {
    	    			if (!isset($result['error']) || ($result['error']['code'] != 3)) {
							if (isset($result['error'])) {
								$params['license_result'] = $result['error']['message'];
							
								$app->enqueueMessage($result['error']['message'], 'error');
							} else {
								$params['license_result'] = '';
							}
						} else {
							$app->enqueueMessage($result['error']['message'], 'error');
						}
					} else {
						$app->enqueueMessage(JText::_($str.'ERROR_RESPONSE'), 'error');
					}
				} else {
					$app->enqueueMessage(JText::sprintf($str.'ERROR_CURL', curl_errno($curl), curl_error($curl)), 'error');
				}
			} else {
				$params['license'] = '';
				$params['license_result'] = '';
				
				$app->enqueueMessage(JText::_($str.'ERROR_LICENSE'), 'error');
			}
			
			$db->setQuery("UPDATE #__extensions SET params = ".$db->Quote(json_encode($params))." WHERE extension_id = ".$db->Quote($extension_id));
			$db->query();

			$cache = JFactory::getCache('com_plugins');
			$cache->clean();
		
			$input .= "<input type='text' id='jform_params_license' name='jform[params][license]' class='input-large required' value='".$params['license']."' />";
		} else {
			$app->enqueueMessage(JText::_($str.'ERROR_EXTENSION'), 'error');
		}
		
		return $input;
	}
}

?>