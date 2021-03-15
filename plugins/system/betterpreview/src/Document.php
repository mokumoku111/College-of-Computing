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

namespace RegularLabs\Plugin\System\BetterPreview;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text as JText;
use RegularLabs\Library\Document as RL_Document;
use RegularLabs\Library\StringHelper as RL_String;

/**
 ** Plugin that places the button
 */
class Document
{
	public static function loadScriptsAndCSS()
	{
		RL_Document::script('betterpreview/script.min.js', '6.4.0');
		RL_Document::style('betterpreview/style.min.css', '6.4.0');

	}
}
