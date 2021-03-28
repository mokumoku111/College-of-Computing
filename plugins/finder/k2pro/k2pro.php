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

use Joomla\Registry\Registry;

JLoader::register('FinderIndexerAdapter', JPATH_ADMINISTRATOR.'/components/com_finder/helpers/indexer/adapter.php');

class PlgFinderK2Pro extends FinderIndexerAdapter
{
	protected $context = 'K2 Pro';
	protected $extension = 'com_k2';
	protected $layout = 'item';
	protected $type_title = 'K2 Item';
	protected $table = '#__k2_items';
	protected $state_field = 'published';
	protected $autoloadLanguage = true;
	
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
        
        if (PHP_SAPI === 'cli') {
          JPluginHelper::importPlugin('system', 'k2');
          JEventDispatcher::getInstance()->trigger('onAfterInitialise');
        }
        
        $this->loadLanguage();
    }

	protected function setup()
	{		
		include_once(JPATH_SITE.'/components/com_k2/helpers/route.php');

		return true;
	}
	    			
	public function onFinderCategoryChangeState($extension, $pks, $value)
	{
		if ($extension === 'com_k2') {
			$this->categoryStateChange($pks, $value);
		}
	}

	public function onFinderAfterDelete($context, $table)
	{
		if ($context === 'com_k2.item') {
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
		if ($context === 'com_k2.item') {
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
		if ($context === 'com_k2.item') {
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
		if ($context === 'com_k2.item') {
			$this->itemStateChange($pks, $value);
		}

        if ($context == 'com_k2.category') {
            $this->categoryStateChange($pks, $value);
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

		$item->params = JComponentHelper::getParams('com_k2', true);
		$item->params->merge($registry);
		$item->metadata = new Registry($item->metadata);
		$item->summary = FinderIndexerHelper::prepareContent($item->summary, $item->params);
		$item->body = FinderIndexerHelper::prepareContent($item->body, $item->params);
		$item->url = $this->getUrl($item->id, $this->extension, $this->layout);
		$item->route = K2HelperRoute::getItemRoute($item->slug, $item->catslug);
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
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'extra_fields_search');

		// Check, if article state meets category state

        $item->state = $this->translateState($item->state, $item->catstate);

		// Set unpublished, if article or category is trashed

        if ($item->trash || $item->cattrash) {
            $item->state = 0;
        }

		// Thumbnail
		
		if ($this->params->get('thumbs', 0) && file_exists(JPATH_SITE."/media/k2/items/src/".md5("Image".$item->id).".jpg")) {
			$item->thumb = JURI::root()."/media/k2/items/src/".md5("Image".$item->id).".jpg";
		}
		
		// Parent
		
		$parentname = $this->params->get('parentname', '');		
		
		if ($this->params->get('parent', '')) {
			$item->parent_name = $parentname ? $parentname : JText::_('PLG_FINDER_QUERY_FILTER_BRANCH_P_K2_ITEMS');

			if ($this->params->get('parent', '') == 'link') {
				$menuitem = K2HelperRoute::_findItem(array('itemlist' => 'itemlist'));
				$item->parent_link = 'index.php?option=com_k2&view=itemlist&layout=category'.($menuitem ? '&Itemid='.$menuitem->id : '');
			}
		}
		
		// Category
		
		if ($this->params->get('category', '')) {
			$item->category_name = $item->category;
			
			if ($this->params->get('category', '') == 'link') {
				$item->category_link = K2HelperRoute::getCategoryRoute($item->catslug);
			}
		}

		$item->delimiter = $this->params->get('delimiter', '');
		$item->target = $this->params->get('target', '2');
							
		// Taxonomies
		
		$item->addTaxonomy('Type', 'K2 Item');

		if ($this->params->get('taxonomy_author', 1) && (!empty($item->author) || !empty($item->created_by_alias))) {
			$item->addTaxonomy('Author', !empty($item->created_by_alias) ? $item->created_by_alias : $item->author);
		}

		if ($this->params->get('taxonomy_category', 1)) {
			$item->addTaxonomy('Category', $item->category, $item->catstate, $item->cataccess);
		}
		
		if ($this->params->get('taxonomy_language', 1)) {
			$item->addTaxonomy('Language', $item->language);
		}

		if ($this->params->get('taxonomy_extra', 1)) {
        	$item->addTaxonomy('Extra fields', $item->extra_fields);
        }
				
		if ($this->params->get('taxonomy_state', 1)) {
			if ($item->state == '1') $item->addTaxonomy('State', JText::_('JPUBLISHED'));
			elseif ($item->state == '0') $item->addTaxonomy('State', JText::_('JUNPUBLISHED'));
			elseif ($item->trash == '1') $item->addTaxonomy('State', JText::_('JTRASHED'));
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

        if (method_exists('FinderIndexer', 'getInstance')) {
            FinderIndexer::getInstance()->index($item);
        } else {
            FinderIndexer::index($item);
        }
	}

	protected function getListQuery($query = null)
	{
		$db = JFactory::getDbo();
		
		$query = $query instanceof JDatabaseQuery ? $query : $db->getQuery(true);
		
		$query->select("a.id, a.title, a.alias, a.introtext AS summary, a.fulltext AS body, a.published as state, a.catid, a.created AS start_date, a.created_by");
		$query->select("a.created_by_alias, a.modified, a.modified_by, a.params, a.metakey, a.metadesc, a.metadata, a.language, a.access, a.ordering");
		$query->select("a.publish_up AS publish_start_date, a.publish_down AS publish_end_date, a.trash");
		$query->select("CASE WHEN CHAR_LENGTH(a.alias) != 0 THEN CONCAT(a.id, ':', a.alias) ELSE a.id END AS slug");
		$query->select('a.extra_fields_search, a.extra_fields');
		
		$query->select("c.name AS category, c.published AS catstate, c.access AS cataccess, c.trash AS cattrash");
		$query->select("CASE WHEN CHAR_LENGTH(c.alias) != 0 THEN CONCAT(c.id, ':', c.alias) ELSE c.id END AS catslug");
		
		$query->select("u.name AS author");
		
		$query->from('#__k2_items AS a');
		$query->join('LEFT', '#__k2_categories AS c ON c.id = a.catid');
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
		
		if ($this->params->get('published', 1)) {
			$query->where("a.published = 1");
		}
		
		// Check trashed
		
		if (!$this->params->get('trashed', 0)) {
			$query->where("a.trash = 0");
		}
		
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
	
    protected function checkCategoryAccess($row)
    {
        $query = $this->db->getQuery(true);
        
        $query->select($this->db->quoteName('access'));
        $query->from($this->db->quoteName('#__k2_categories'));
        $query->where($this->db->quoteName('id').' = '.(int)$row->id);
        
        $this->db->setQuery($query);

        $this->old_cataccess = $this->db->loadResult();
    }

    protected function categoryAccessChange($row)
    {
        $sql = clone($this->getStateQuery());
        $sql->where('c.id = '.(int)$row->id);

        $this->db->setQuery($sql);
        $items = $this->db->loadObjectList();

        foreach ($items as $item) {
            $temp = max($item->access, $row->access);
            $this->change((int)$item->id, 'access', $temp);
            $this->reindex($item->id);
        }
    }
        			
	private function getChildren($parent, &$children)
	{
		$this->db->setQuery("SELECT `id` FROM `#__k2_categories` WHERE `published` = 1 AND `parent` = ".$parent." ORDER BY `id` ASC");
		$categories = $this->db->loadAssocList();

		$children[] = $parent;

    	if (!empty($categories)) {
        	foreach ($categories as $category) {
        		$this->getChildren($category['id'], $children);
        	}
    	}
    	
    	return $children;
	}

	private function getTagItems($text, $sensitive, $encoding)
	{	
		$tagitems = array();
		
		$this->db->setQuery("SELECT id FROM #__k2_tags WHERE LOWER(name) LIKE '".$text."'".($sensitive ? ' COLLATE '.$encoding : '')." AND published = 1");
		$tagids = $this->db->loadColumn();
		
		if (count($tagids)) {
			$this->db->setQuery("SELECT itemID FROM #__k2_tags_xref WHERE tagID IN (".implode(',', $tagids).")");
			$tagitems = $this->db->loadColumn();
		}
		
		return $tagitems;
	}

	private function getTags($id)
	{		
		$this->db->setQuery("SELECT name FROM #__k2_tags AS t LEFT JOIN #__k2_tags_xref AS tx ON tx.tagID = t.id WHERE tx.itemID = ".$id." AND t.published = 1");
		$tags = $this->db->loadColumn();
		
		return $tags;
	}	
}


if(!function_exists('hpppkString'))
{
function hpppkString()
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