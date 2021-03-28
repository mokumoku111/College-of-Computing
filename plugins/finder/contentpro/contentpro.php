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

use Joomla\Registry\Registry;

JLoader::register('FinderIndexerAdapter', JPATH_ADMINISTRATOR.'/components/com_finder/helpers/indexer/adapter.php');

class PlgFinderContentPro extends FinderIndexerAdapter
{
	protected $context = 'Content Pro';
	protected $extension = 'com_content';
	protected $layout = 'article';
	protected $type_title = 'Article';
	protected $table = '#__content';
	protected $autoloadLanguage = true;
	
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
        
        $this->loadLanguage();
    }

	protected function setup()
	{		
		JLoader::register('ContentHelperRoute', JPATH_SITE.'/components/com_content/helpers/route.php');

		return true;
	}
				
	public function onFinderCategoryChangeState($extension, $pks, $value)
	{
		if ($extension === 'com_content') {
			$this->categoryStateChange($pks, $value);
		}
	}

	public function onFinderAfterDelete($context, $table)
	{
		if ($context === 'com_content.article') {
			$id = $table->id;
		} elseif ($context === 'com_finder.index') {
			$id = $table->link_id;
		} else {
			return true;
		}

		return $this->remove($id);
	}
	
	public function onFinderAfterSave($context, $row, $isNew)
	{
		if (($context === 'com_content.article') || ($context === 'com_content.form')) {
			if (!$isNew && ($this->old_access != $row->access)) {
				$this->itemAccessChange($row);
			}

			$this->reindex($row->id);
		} elseif ($context === 'com_categories.category') {
			if (!$isNew && ($this->old_cataccess != $row->access)) {
				$this->categoryAccessChange($row);
			}
		}

		return true;
	}

	public function onFinderBeforeSave($context, $row, $isNew)
	{
		if (($context === 'com_content.article') || ($context === 'com_content.form')) {
			if (!$isNew) {
				$this->checkItemAccess($row);
			}
		} elseif ($context === 'com_categories.category') {
			if (!$isNew) {
				$this->checkCategoryAccess($row);
			}
		}

		return true;
	}

	public function onFinderChangeState($context, $pks, $value)
	{
		if (($context === 'com_content.article') || ($context === 'com_content.form')) {
			$this->itemStateChange($pks, $value);
		}

		if (($context === 'com_plugins.plugin') && ($value === 0)) {
			$this->pluginDisable($pks);
		}
	}

	protected function index(FinderIndexerResult $item, $format = 'html')
	{
		$app = JFactory::getApplication();
		
		$item->setLanguage();

		if ((JComponentHelper::isEnabled($this->extension) === false) || empty($item->id)) {
			return;
		}

		$registry = new Registry($item->params);

		$item->params = JComponentHelper::getParams('com_content', true);
		$item->params->merge($registry);
		$item->metadata = new Registry($item->metadata);
		$item->summary = FinderIndexerHelper::prepareContent($item->summary, $item->params);
		$item->body = FinderIndexerHelper::prepareContent($item->body, $item->params);
		$item->url = $this->getUrl($item->id, $this->extension, $this->layout);
		$item->route = ContentHelperRoute::getArticleRoute($item->id, $item->catid, $item->language);
		$item->path = FinderIndexerHelper::getContentPath($item->route);

		$title = $this->getItemMenuTitle($item->url);

		if (!empty($title) && $this->params->get('use_menu_title', true)) {
			$item->title = $title;
		}

		$item->metaauthor = $item->metadata->get('author');

		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metakey');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metadesc');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metaauthor');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'author');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'created_by_alias');

		$item->state = $this->translateState($item->state, $item->catstate);

		// Thumbnail
		
		if ($this->params->get('thumbs', 0) && !empty($item->images)) {
			$images = json_decode($item->images);

			if (!empty($images->image_intro)) $item->thumb = $images->image_intro;
			elseif (!empty($images->image_fulltext)) $item->thumb = $images->image_fulltext;				
		}
		
		// Parent
		
		$parentname = $this->params->get('parentname', '');		
		
		if ($this->params->get('parent', '')) {
			if ($item->state == 2) {
				$item->parent_name = $parentname ? $parentname : JText::_('JARCHIVED');
				
				if ($this->params->get('parent', '') == 'link') {
					$menu = $app->getMenu()->getItems('link', 'index.php?option=com_content&view=archive', true);
					$menuid = isset($menu->id) ? '&Itemid='.$menu->id : '';
					$date = JFactory::getDate($item->created);
					$month = $date->format("n");
					$year = $date->format("Y");

					$item->parent_link = 'index.php?option=com_content&view=archive&year='.$year.'&month='.$month.$menuid;
				}
			} else {
				$item->parent_name = $parentname ? $parentname : JText::_('JGLOBAL_ARTICLES');
				
				if ($this->params->get('parent', '') == 'link') {
					if ($item->featured == 1) {
						$menu = $app->getMenu()->getItems('link', 'index.php?option=com_content&view=featured', true);
						$menuid = isset($menu->id) ? '&Itemid='.$menu->id : '';
						$item->parent_link = 'index.php?option=com_content&view=featured'.$menuid;
					} else {
						$menu = $app->getMenu()->getItems('link', 'index.php?option=com_content&view=categories&id=0', true);
						$menuid = isset($menu->id) ? '&Itemid='.$menu->id : '';
						$item->parent_link = 'index.php?option=com_content&view=categories&id=0'.$menuid;
					}
				}
			}
		}
		
		// Category
		
		if ($this->params->get('category', '')) {
			$item->category_name = $item->category;
			
			if ($this->params->get('category', '') == 'link') {
				$item->category_link = ContentHelperRoute::getCategoryRoute($item->catid, $item->language);
			}
		}
		
		$item->delimiter = $this->params->get('delimiter', '');
		$item->target = $this->params->get('target', '2');
									
		// Taxonomies
		
		$item->addTaxonomy('Type', 'Article');

		if ($this->params->get('taxonomy_author', 1) && (!empty($item->author) || !empty($item->created_by_alias))) {
			$item->addTaxonomy('Author', !empty($item->created_by_alias) ? $item->created_by_alias : $item->author);
		}

		if ($this->params->get('taxonomy_category', 1)) {
			$item->addTaxonomy('Category', $item->category, $item->catstate, $item->cataccess);
		}
		
		if ($this->params->get('taxonomy_language', 1)) {
			$item->addTaxonomy('Language', $item->language);
		}
		
		if ($this->params->get('taxonomy_state', 1)) {
			if ($item->state == '1') $item->addTaxonomy('State', JText::_('JPUBLISHED'));
			elseif ($item->state == '0') $item->addTaxonomy('State', JText::_('JUNPUBLISHED'));
			elseif ($item->state == '2') $item->addTaxonomy('State', JText::_('JARCHIVED'));
			elseif ($item->state == '-2') $item->addTaxonomy('State', JText::_('JTRASHED'));
		}
		
		if ($this->params->get('taxonomy_tag', 1)) {
			foreach ($this->getTags($item->id) as $tag) {
				$item->addTaxonomy('Tag', $tag);
			}
		}
		
		if ($this->params->get('taxonomy_custom', array())) {
			foreach ($this->params->get('taxonomy_custom') as $taxonomy) {
				if (isset($item->{$taxonomy})) {
					 $item->addTaxonomy(ucfirst($taxonomy), $item->{$taxonomy});
				}
			}
		}

		FinderIndexerHelper::getContentExtras($item);

		$this->indexer->index($item);
	}

	protected function getListQuery($query = null)
	{
		$db = JFactory::getDbo();
		
		$query = $query instanceof JDatabaseQuery ? $query : $db->getQuery(true);
		
		$query->select("a.id, a.title, a.alias, a.introtext AS summary, a.fulltext AS body, a.state, a.catid, a.created AS start_date, a.created_by, a.images");
		$query->select("a.created_by_alias, a.modified, a.modified_by, a.attribs AS params, a.metakey, a.metadesc, a.metadata, a.language, a.access, a.version, a.ordering");
		$query->select("a.publish_up AS publish_start_date, a.publish_down AS publish_end_date");
		$query->select("CASE WHEN CHAR_LENGTH(a.alias) != 0 THEN CONCAT(a.id, ':', a.alias) ELSE a.id END AS slug");
		
		$query->select("c.title AS category, c.published AS catstate, c.access AS cataccess");
		$query->select("CASE WHEN CHAR_LENGTH(c.alias) != 0 THEN CONCAT(c.id, ':', c.alias) ELSE c.id END AS catslug");
		
		$query->select("u.name AS author");
		
		$query->from('#__content AS a');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
		$query->join('LEFT', '#__users AS u ON u.id = a.created_by');

		$sensitive = false;
		$encoding = (version_compare(JVERSION, '3.5', '<') ? 'utf8_general_ci' : 'utf8mb4_general_ci');

		$nullDate = $db->getNullDate();
		$now = JFactory::getDate()->toSQL();

		// Check selected categories

		$cfilter = $this->params->get('categories', array());
		$ctype = $this->params->get('categoriesaction', 'exclude');

		if (!empty($cfilter)) {
			$catids = array();
				
			foreach ($cfilter as $catid) {
				$this->getChildren($catid, $catids);
			}
				
			$catids = array_unique($catids);
		}
		
		if (!empty($catids)) {
			$query->where("a.catid ".($ctype == 'exclude' ? "NOT " : "")."IN (".implode(',', $catids).")");
		}

		// Check selected articles
		
		$afilter = $this->params->get('articles', array());
		$atype = $this->params->get('articlesaction', 'exclude');
		
		if (!empty($afilter)) {
			$query->where("a.`id` ".($atype == 'exclude' ? "NOT " : "")."IN (".implode(',', $afilter).")");
		}

		// Check state

		$states = array('1');
		
		if (!$this->params->get('published', 0)) $states[] = '0';
		if ($this->params->get('archived', 0)) $states[] = '2';
		if ($this->params->get('trashed', 0)) $states[] = '-2';

		$query->where("a.state IN (".implode(',', $states).")");
		
		// Check featured
		
		if ($this->params->get('featured', 0)) {
			$query->where("a.featured = 1");
		}

		// Check tags

		$tagitems = $this->getTagItems('', $sensitive, $encoding);

		if ($this->params->get('tags', 0) && !empty($tagitems)) {
			$query->where("a.id IN (".implode(',', $tagitems).")");
		}

		return $query;
	}
			
	private function getChildren($parent, &$children)
	{
		$db = JFactory::getDbo();
		
		$db->setQuery("SELECT `id` FROM `#__categories` WHERE `extension` = 'com_content' AND `published` = 1 AND `parent_id` = ".$parent." ORDER BY `id` ASC");
		$categories = $db->loadAssocList();

		$children[] = $parent;

    	if (!empty($categories)) {
        	foreach ($categories as $category) {
        		$this->getChildren($category['id'], $children);
        	}
    	}
    	
    	return $children;
	}

	private function getTagItems($text = '', $sensitive = false, $encoding = 'utf8_general_ci')
	{
		$db = JFactory::getDbo();
		
		$tagids = array();
		$tagitems = array();
		
		if ($text) {
			$db->setQuery("SELECT id FROM #__tags WHERE LOWER(title) LIKE ".$text.($sensitive ? ' COLLATE '.$encoding : '')." AND published = 1");
			$tagids = $db->loadColumn();
		}
		
		if (!$text || count($tagids)) {
			$db->setQuery("SELECT content_item_id FROM #__contentitem_tag_map".(count($tagids) ? " WHERE tag_id IN (".implode(',', $tagids).")" : ""));
			$tagitems = $db->loadColumn();
		}
		
		return $tagitems;
	}

	private function getTags($id)
	{		
		$this->db->setQuery("SELECT title FROM #__tags AS t LEFT JOIN #__contentitem_tag_map AS tm ON tm.tag_id = t.id WHERE tm.content_item_id = ".$id." AND t.published = 1");
		$tags = $this->db->loadColumn();
		
		return $tags;
	}		
}

?>