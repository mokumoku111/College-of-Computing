<?php
/**
* @version 1.0.0
* @package RSFinder! 1.0.0
* @copyright (C) 2009-2010 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
define ('RSFINDER','EXISTS');

$user 		= JFactory::getUser();
$rsquick 	= JRequest::getVar('rsquick');
if ($rsquick && !$user->get('id')) {
	echo '<li><a href="index.php" id="result_0" class="rsInactive">Session Expired. Please log in.</a></li>'."\n";
	exit;
}


/**
 * RSFinder! system plugin
 */
class plgSystemRSFinder extends JPlugin
{
	public function __construct( &$subject, $config ) {
		parent::__construct( $subject, $config );
	}
	
	public function onAfterRender() {
		$db		= JFactory::getDbo();
		$lang	= JFactory::getLanguage();
		$app	= JFactory::getApplication();	
		$user	= JFactory::getUser();
		$search = $app->input->getString('rsquick');
		
		$lang->load('plg_system_rsfinder', JPATH_ADMINISTRATOR);
		
		if ($app->getName() != 'site') {
			if (isset($search) && strlen($search) > 1 && $user->get('id')) 	{	
				
				$search = str_replace('&','',$search);
				$output = '';
				$index	= 0;
				$limit	= $this->params->get('limit', 0);
				if($limit == 0) $limit == 50;
				
				// Joomla! Articles
				if ($this->params->get('searchArticles', 0) && $index < $limit) {
					$db->setQuery("SELECT id as value, title as text FROM #__content WHERE title LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_content&task=article.edit&id='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.$this->escape($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_ARTICLE').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}
				
				// Joomla! Components
				if ($this->params->get('searchComponents', 0) && $index < $limit) {
					$db->setQuery("SELECT name as text, element FROM #__extensions WHERE type = 'component' AND name LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach($results as $result) {
							if ($index < $limit) {
								$lang->load($result->element);
								$output .= '<li><a href="index.php?option='.$result->element.'" id="result_'.$index.'" class="rsInactive">'.JText::_($result->text).' <em>(component)</em></a></li>'."\n";
							}
						$index ++;
						}
					}
				}
				
				// Joomla! Categories
				if ($this->params->get('searchCategories', 0) && $index < $limit) {
					$db->setQuery("SELECT id as value, title as text, extension FROM #__categories WHERE title LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach ($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_categories&task=category.edit&id='.$result->value.'&extension='.$result->extension.'" id="result_'.$index.'" class="rsInactive">'.$this->escape($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_CATEGORY').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}
				
				// Joomla! Users
				if ($this->params->get('searchUsers', 0) && $index < $limit) {
					$db->setQuery("SELECT id as value, username as text FROM #__users WHERE username LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_users&task=user.edit&id='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.$this->escape($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_USER').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}
					
				// Joomla! menu items
				if ($this->params->get('searchMenuItems', 0) && $index < $limit) {
					$db->setQuery("SELECT id as value, `title` as text FROM #__menu WHERE `menutype` != 'main' AND `menutype` != 'menu' AND title LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach ($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_menus&task=item.edit&id='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.JText::_($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_MENU_ITEM').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}
				
				// Joomla! Menus
				if ($this->params->get('searchMenus', 0) && $index < $limit) {
					$db->setQuery("SELECT DISTINCT menutype as value, `title` as text FROM #__menu_types WHERE menutype LIKE '%".$db->escape($search)."%' OR title LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach ($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_menus&task=view&menutype='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.$this->escape($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_MENU').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}
				
				// Joomla! Modules
				if ($this->params->get('searchModules', 0) && $index < $limit) {
					$db->setQuery("SELECT id as value, `title` as text FROM #__modules WHERE title LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach ($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_modules&task=module.edit&id='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.JText::_($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_MODULE').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}
				
				// Joomla! Plugins
				if ($this->params->get('searchPlugins', 0) && $index < $limit) {
					$db->setQuery("SELECT extension_id as value, `name` as text, element FROM #__extensions WHERE type = 'plugin' AND name LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach ($results as $result) {
							if ($index < $limit) {
								$lang->load($result->text);
								$output .= '<li><a href="index.php?option=com_plugins&task=plugin.edit&extension_id='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.JText::_($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_PLUGIN').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}
				
				// RSEvents!Pro events
				if ($this->params->get('searchRseventsPro', 0) && $index < $limit) {
					$db->setQuery("SELECT id as value, `name` as text FROM #__rseventspro_events WHERE name LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach ($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_rseventspro&task=event.edit&id='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.$this->escape($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_EVENT').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}

				// K2 articles
				if ($this->params->get('searchk2', 0) && $index < $limit) {
					$db->setQuery("SELECT id as value, `title` as text FROM #__k2_items WHERE title LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach ($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_k2&view=item&cid='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.$this->escape($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_K2_ARTICLE').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}

				// Virtuemart products
				if ($this->params->get('searchVirtuemart', 0) && $index < $limit) {
					$db->setQuery("SELECT product_id as value, `product_name` as text FROM #__vm_product WHERE product_name LIKE '%".$db->escape($search)."%' LIMIT ".$limit);
					$results = $db->loadObjectList();
					
					if (!empty($results)) {
						foreach ($results as $result) {
							if ($index < $limit) {
								$output .= '<li><a href="index.php?option=com_virtuemart&page=product.product_form&product_id='.$result->value.'" id="result_'.$index.'" class="rsInactive">'.$this->escape($result->text).' <em>'.JText::_('PLG_SYSTEM_RSFINDER_EDIT_VM').'</em></a></li>'."\n";
							}
							$index ++;
						}
					}
				}

				
				
				// Default joomla links
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_ARTICLE')			,'value'=>'index.php?option=com_content&task=article.add');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_CATEGORY')			,'value'=>'index.php?option=com_categories&task=category.add&extension=com_content');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_MENU')				,'value'=>'index.php?option=com_menus&view=item&layout=edit&menutype=mainmenu');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_USER')				,'value'=>'index.php?option=com_users&task=user.add');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_VIEW_CATEGORIES')		,'value'=>'index.php?option=com_categories&extension=com_content');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_VIEW_USERS')			,'value'=>'index.php?option=com_users&view=users');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_VIEW_MENU_MANAGER')	,'value'=>'index.php?option=com_menus&view=menus');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_GROUP')			,'value'=>'index.php?option=com_users&task=group.add');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_ACCESS_LEVEL')		,'value'=>'index.php?option=com_users&task=level.add');
				
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_TEMPLATES')			,'value'=>'index.php?option=com_templates');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_LANGUAGES')			,'value'=>'index.php?option=com_languages');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_MODULES')				,'value'=>'index.php?option=com_modules');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_PLUGINS')				,'value'=>'index.php?option=com_plugins');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_EXTENSION_MANAGER')	,'value'=>'index.php?option=com_installer');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_GLOBAL_CONFIG')		,'value'=>'index.php?option=com_config');
				$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_MEDIA')				,'value'=>'index.php?option=com_media');
				
				if ($this->params->get('searchRseventsPro',0) && file_exists(JPATH_SITE.'/components/com_rseventspro/rseventspro.php')) {
					$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_EVENT'),'value'=>'index.php?option=com_rseventspro&task=event.add');
				}
				
				if ($this->params->get('searchk2',0)) {
					$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_K2_ARTICLE'),'value'=>'index.php?option=com_k2&view=item');
				}
				
				if ($this->params->get('searchVirtuemart', 0)) {
					$matches[] = array('text'=>JText::_('PLG_SYSTEM_RSFINDER_NEW_VM'),'value'=>'index.php?option=com_virtuemart&pshop_mode=admin&page=product.product_form');
				}
				
				foreach($matches as $match) {
					if (stristr($match['text'],$search) && $index < $limit) {
						if ($index < $limit) {
							$output .= '<li><a href="'.$match['value'].'" id="result_'.$index.'" class="rsInactive">'.$match['text'].'</a></li>'."\n";
						}
						$index++;
					}
				}
				
				if($output == '') 
					$output = '<li><a href="javascript:void(0)" class="rsInactive">'.JText::_('PLG_SYSTEM_RSFINDER_NO_RESULTS').'</a></li>';
				
				echo $output;
				exit;
			}
		}
	}
	
	protected function escape($string) {
		return htmlentities($string, ENT_COMPAT, 'utf-8');
	}
}