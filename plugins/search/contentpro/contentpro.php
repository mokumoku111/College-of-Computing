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

defined('_JEXEC') or die;

class plgSearchContentPro extends JPlugin
{
	var $db, $app, $str;
	
    public function __construct(&$subject, $config)
	{
		$this->db = JFactory::getDbo();
		$this->app = JFactory::getApplication();
		$this->str = 'PLG_SEARCH_CONTENTPRO_';
		
		$this->checkContentPlugin();
		
        parent::__construct($subject, $config);
        
    	$this->loadLanguage();
	}
		
	public function onContentSearchAreas()
	{		
		static $areas = array();

		$areas['content_all'] = JText::_($this->str.'AREAS_ALL');
		
		if ($this->params->get('archivedarea', 1) && $this->params->get('archived', 1)) {
			$areas['content_archived'] = JText::_($this->str.'AREAS_ARCHIVED');
		}
		
		if ($this->params->get('featuredarea', 1) && $this->params->get('featured', 1)) {
			$areas['content_featured'] = JText::_($this->str.'AREAS_FEATURED');
		}
		
		if ($this->params->get('tagsarea', 1) && $this->params->get('tags', 1)) {
			$areas['content_tags'] = JText::_($this->str.'AREAS_TAGS');
		}
				
		$fields = $this->params->get('fields', array());
		$display = $this->params->get('areas', array());

		foreach ($fields as $field) {
			if (in_array($field, $display)) {
				$area = str_replace('.', '_', str_replace('`', '', $field));
				$areas['content_'.$area] = JText::_($this->str.'AREAS_LABEL').JText::_($this->str.'AREAS_'.$area);
			}
		}
					
		return $areas;
	}

	public function onContentSearch($text, $phrase = '', $ordering = '', $areas = null)
	{
		if ($this->params->get('license_result', '')) {
			$this->app->enqueueMessage($this->params->get('license_result'), 'error');
		}		
		
		if ($this->app->isAdmin()) return array();

		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) return array();
		}

		$fields = $this->params->get('fields', array());
				
		if (empty($fields)) return array();

		$user = JFactory::getUser();
		$groups = array_unique($user->getAuthorisedViewLevels());
		$tag = JFactory::getLanguage()->getTag();

		$limit = $this->params->get('limit', 50);
		$delimiter = $this->params->get('delimiter', '');	
		$sensitive = $this->params->get('sensitive', 0);

		$cfilter = $this->params->get('categories', array());
		$ctype = $this->params->get('categoriesaction', 'exclude');
		
		$afilter = $this->params->get('articles', array());
		$atype = $this->params->get('articlesaction', 'exclude');
		
		$archived = $this->params->get('archived', 1);
		$featured = $this->params->get('featured', 1);
		$tags = $this->params->get('tags', 1);
		
		$nullDate = $this->db->getNullDate();
		$now = JFactory::getDate()->toSQL();
 	 	
		if ($sensitive) {
			$text = trim(str_replace(array('#', '>', '<', '\\'), '', JFactory::getApplication()->input->getString('searchword', null, 'post')));
		}

		$searchText = $text;
		
		$text = trim($text);

		if ($text == '') return array();
		
		$where = '';
		$wheres = array();
		$tagitems = array();

		$encoding = (version_compare(JVERSION, '3.5', '<') ? 'utf8_bin' : 'utf8mb4_bin');

		switch ($phrase) {
			case 'exact':
				$text = ($sensitive ? '' : 'LOWER(_utf8 ').$this->db->Quote('%'.$this->db->escape($text, true).'%', false).($sensitive ? '' : ')');
				$wheres2 = array();
				
				foreach ($fields as $field) {
					if (!$areas || in_array('content_all', $areas) || in_array('content_archived', $areas) || in_array('content_archived', $areas) || in_array('content_featured', $areas) || in_array('content_tags', $areas) || in_array('content_'.str_replace('.', '_', str_replace('`', '', $field)), $areas)) {
						$wheres2[] = $field.' LIKE '.$text.($sensitive ? ' COLLATE '.$encoding : '');
					}
				}
				
				if ($wheres2) {
					$where .= '('.implode(') OR (', $wheres2).')';
				}

				if ($tags) {
					$tagitems = $this->getTagItems($text, $sensitive, $encoding);
				}
								
				break;
			case 'all':
			case 'any':
			default:
				$words = explode(' ', $text);
				$wheres = array();
				
				foreach ($words as $word) {
					$word = ($sensitive ? '' : 'LOWER(_utf8 ').$this->db->Quote('%'.$this->db->escape($word, true).'%', false).($sensitive ? '' : ')');
					$wheres2 = array();

					foreach ($fields as $field) {
						if (!$areas || in_array('content_all', $areas) || in_array('content_archived', $areas) || in_array('content_featured', $areas) || in_array('content_tags', $areas) || in_array('content_'.str_replace('.', '_', str_replace('`', '', $field)), $areas)) {
							$wheres2[] = $field.' LIKE '.$word.($sensitive ? ' COLLATE '.$encoding : '');
						}
					}
									
					$wheres[] = implode(' OR ', $wheres2);
					
					if ($tags) {
						$tagitems = array_merge($tagitems, $this->getTagItems($word, $sensitive, $encoding));
					}					
				}
				
				if ($wheres) {
					$where .= '('.implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres).')';
				}
				
				break;
		}
		
		$encoding = (version_compare(JVERSION, '3.5', '<') ? 'utf8_general_ci' : 'utf8mb4_general_ci');
		
		switch ($ordering) {
			case 'oldest':
				$order = 'a.`created` ASC';
				break;
			case 'popular':
				$order = 'a.`hits` DESC';
				break;
			case 'alpha':
				$order = 'a.`title` COLLATE '.$encoding.' ASC';
				break;
			case 'category':
				$order = 'c.`title` COLLATE '.$encoding.' ASC, a.`title` COLLATE '.$encoding.' ASC';
				break;
			case 'newest':
			default:
				$order = 'a.`created` DESC';
				break;
		}

		if (!empty($cfilter)) {
			$catids = array();
				
			foreach ($cfilter as $catid) {
				$this->getChildren($catid, $catids);
			}
				
			$catids = array_unique($catids);
		}
		
		$states = array('1');
		
		if ($areas && in_array('content_archived', $areas) && $archived) $states[] = '2';
		
		$authors = $this->getAuthors();

		if ($tags && !empty($tagitems)) {
			$where .= ($where ? " OR " : "")."a.id IN (".implode(',', $tagitems).")";
		}
		
		$sql  = " SELECT a.`id`, a.`alias`, a.`catid`, a.`state`, a.`language`, a.`created`, a.`images`, a.`featured`,";
		$sql .= " CONCAT(a.`introtext`, a.`fulltext`) AS `text`, a.`title`, a.`metadesc`, a.`metakey`,";
		$sql .= " CASE WHEN CHAR_LENGTH(a.alias) != 0 THEN CONCAT(a.id, ':', a.alias) ELSE a.id END AS slug,";

		$sql .= " c.`title` AS `category`, c.`alias` AS `catalias`, c.`description`, c.`params`, c.`metadesc` AS `catmetadesc`, c.`metakey` AS `catmetakey`, u.`name` AS `author`,";
		$sql .= " CASE WHEN CHAR_LENGTH(c.alias) != 0 THEN CONCAT(c.id, ':', c.alias) ELSE c.id END AS catslug";

		$sql .= " FROM #__content AS a";
		$sql .= " LEFT JOIN #__categories AS c ON (c.`id` = a.`catid`".(!empty($groups) ? " AND c.`access` IN (".implode(',', $groups).")" : "").")";
		$sql .= " LEFT JOIN #__users AS u ON ((u.`id` = a.`created_by`) OR (u.`id` = a.`modified_by`))";
		
		$sql .= " WHERE c.`published` = 1".(!empty($groups) ? " AND a.`access` IN (".implode(',', $groups).")" : "");
		
		if ($where) $sql .= " AND (".$where.")";
		
		$sql .= " AND a.`state` IN (".implode(',', $states).")".(!empty($authors) ? " AND u.`id` IN (".implode(',', $authors).")" : "");
			
		if ($areas && in_array('content_featured', $areas) && $featured) $sql .= " AND a.`featured` = 1";
			
		if (!empty($catids)) $sql .= " AND a.`catid` ".($ctype == 'exclude' ? "NOT " : "")."IN (".implode(',', $catids).")";
		if (!empty($afilter)) $sql .= " AND a.`id` ".($atype == 'exclude' ? "NOT " : "")."IN (".implode(',', $afilter).")";
			
		$sql .= " AND (a.`publish_up` = ".$this->db->Quote($nullDate)." OR a.`publish_up` <= ".$this->db->Quote($now).")";
		$sql .= " AND (a.`publish_down` = ".$this->db->Quote($nullDate)." OR a.`publish_down` >= ".$this->db->Quote($now).")";

		if ($this->app->isSite() && $this->app->getLanguageFilter()) {
			$sql .= " AND a.`language` IN (".$this->db->Quote($tag).", ".$this->db->Quote('*').")";
			$sql .= " AND c.`language` IN (".$this->db->Quote($tag).", ".$this->db->Quote('*').")";
		}
						
		$sql .= " GROUP BY a.`id`, a.`title`, a.`alias`, a.`metadesc`, a.`metakey`, a.`created`, a.`language`, a.`catid`, a.`introtext`, a.`fulltext`, c.`title`, c.`alias`, c.`id`";
		$sql .= " ORDER BY ".$order.($limit ? " LIMIT 0, ".$limit : "");

		$this->db->setQuery($sql);
		$articles = $this->db->loadObjectList();

		if (!empty($articles)) {
			require_once(JPATH_SITE.'/components/com_content/helpers/route.php');
			require_once(JPATH_ADMINISTRATOR.'/components/com_search/helpers/search.php');
			
			$articles = array_unique($articles, SORT_REGULAR);
			
			foreach($articles as $key => $article) {
				if (!searchHelper::checkNoHTML($article, $searchText, array('text', 'title', 'metadesc', 'metakey', 'category', 'description', 'catmetadesc', 'catmetakey', 'author'))) {
					unset($articles[$key]);
				} else {
					if ($this->params->get('thumbs', 0) && !empty($article->images)) {
						$images = json_decode($article->images);

						if (!empty($images->image_intro)) $article->thumb = $images->image_intro;
						elseif (!empty($images->image_fulltext)) $article->thumb = $images->image_fulltext;						
					}
											
					$article->href = ContentHelperRoute::getArticleRoute($article->id, $article->catid, $article->language);
					$article->browsernav = $this->params->get('target', '2');
						
					$sections = array();

					if ($this->params->get('parent', '')) {
						$parentname = $this->params->get('parentname', '');
						
						if ($article->state == 2) {
							$article->parent_name = $parentname ? $parentname : JText::_('JARCHIVED');
							
							if ($this->params->get('parent', '') == 'link') {
								$item = $this->app->getMenu()->getItems('link', 'index.php?option=com_content&view=archive', true);
								$itemid = isset($item->id) ? '&Itemid='.$item->id : '';
								$date = JFactory::getDate($article->created);
								$month = $date->format("n");
								$year = $date->format("Y");
								$article->parent_link = JRoute::_('index.php?option=com_content&view=archive&year='.$year.'&month='.$month.$itemid, false);
							}

							$sections[] = $article->parent_name;
						} else {
							$article->parent_name = $parentname ? $parentname : JText::_($this->str.'ARTICLES');
							
							if ($this->params->get('parent', '') == 'link') {
								if ($article->featured == 1) {
									$item = $this->app->getMenu()->getItems('link', 'index.php?option=com_content&view=featured', true);
									$itemid = isset($item->id) ? '&Itemid='.$item->id : '';
									$article->parent_link = JRoute::_('index.php?option=com_content&view=featured'.$itemid, false);
								} else {
									$item = $this->app->getMenu()->getItems('link', 'index.php?option=com_content&view=categories&id=0', true);
									$itemid = isset($item->id) ? '&Itemid='.$item->id : '';
									$article->parent_link = JRoute::_('index.php?option=com_content&view=categories&id=0'.$itemid, false);									
								}
							}
							
							$sections[] = $article->parent_name;
						}
					}
						
					if ($this->params->get('category', '')) {
						$article->category_name = $article->category;
						
						if ($this->params->get('category', '') == 'link') {
							$article->category_link = ContentHelperRoute::getCategoryRoute($article->catid, $article->language);
						}
						
						$sections[] = $article->category_name;
					}
						
					$article->section = implode(' '.$delimiter.' ', $sections);
					$article->delimiter = $delimiter;
					
					$articles[$key] = $article;
				}
			}
		}

		return $articles;
	}
			
	private function getChildren($parent, &$children)
	{
		$this->db->setQuery("SELECT `id` FROM `#__categories` WHERE `extension` = 'com_content' AND `published` = 1 AND `parent_id` = ".$parent." ORDER BY `id` ASC");
		$categories = $this->db->loadAssocList();

		$children[] = $parent;

    	if (!empty($categories)) {
        	foreach ($categories as $category) {
        		$this->getChildren($category['id'], $children);
        	}
    	}
    	
    	return $children;
	}
	
	private function getAuthors()
	{
		$this->db->setQuery("SELECT DISTINCT(`created_by`) FROM `#__content` WHERE `created_by` > 0");
		$created = $this->db->loadColumn();

		$this->db->setQuery("SELECT DISTINCT(`modified_by`) FROM `#__content` WHERE `modified_by` > 0");
		$modified = $this->db->loadColumn();
		
		$authors = array_unique(array_merge($created, $modified));
    	
    	return $authors;
	}

	private function getTagItems($text, $sensitive, $encoding)
	{	
		$tagitems = array();
		
		$this->db->setQuery("SELECT id FROM #__tags WHERE LOWER(title) LIKE ".$text.($sensitive ? ' COLLATE '.$encoding : '')." AND published = 1");
		$tagids = $this->db->loadColumn();
		
		if (count($tagids)) {
			$this->db->setQuery("SELECT content_item_id FROM #__contentitem_tag_map WHERE tag_id IN (".implode(',', $tagids).")");
			$tagitems = $this->db->loadColumn();
		}
		
		return $tagitems;
	}
	
	private function checkContentPlugin()
	{	
		$this->db->setQuery("SELECT `enabled` FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'search' AND `element` = 'content'");
		$enabled = $this->db->loadResult();
			
		if ($enabled) {
			jimport('joomla.cache.cache');
		
			$this->db->setQuery("UPDATE `#__extensions` SET `enabled` = 0 WHERE `type` = 'plugin' AND `folder` = 'search' AND `element` = 'content'");
			$this->db->query();
					
			$cache = JFactory::getCache('com_plugins', 'output');
			$cache->clean();
			
			$this->app->redirect(JRoute::_(JURI::getInstance()->toString(), false), '');
		}
	}
}

?>