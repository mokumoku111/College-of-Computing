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

defined('_JEXEC') or die;

use RegularLabs\Library\Document as RL_Document;
use RegularLabs\Plugin\System\BetterPreview\Component as BP_Component;

if ( ! is_file(JPATH_LIBRARIES . '/regularlabs/autoload.php'))
{
	return;
}

if ( ! is_file(JPATH_PLUGINS . '/system/betterpreview/vendor/autoload.php'))
{
	return;
}

require_once JPATH_LIBRARIES . '/regularlabs/autoload.php';

if ( ! RL_Document::isJoomlaVersion(3))
{
	return;
}

require_once JPATH_PLUGINS . '/system/betterpreview/vendor/autoload.php';

if (true)
{
	class PlgButtonBetterPreview
		extends \RegularLabs\Library\EditorButtonPlugin
	{
		var $require_core_auth = false;

		public function extraChecks($params)
		{
			if (RL_Document::isClient('site'))
			{
				return false;
			}

			if ( ! $class = BP_Component::getClass('Button'))
			{
				return false;
			}

			return true;
		}
	}
}
