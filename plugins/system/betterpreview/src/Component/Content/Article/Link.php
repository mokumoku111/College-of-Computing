<?php
/**
 * @package         Better Preview
 * @version         6.4.0
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2021 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Plugin\System\BetterPreview\Component\Content\Article;

defined('_JEXEC') or die;

use RegularLabs\Plugin\System\BetterPreview\Component\Link as Main_Link;

class Link extends Main_Link
{
	public function getLinks()
	{
		if ( ! $item = Helper::getArticle())
		{
			return [];
		}

		$parents = Helper::getArticleParents($item);

		return array_merge([$item], $parents);
	}
}
