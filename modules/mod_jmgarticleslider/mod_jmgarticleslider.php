<?php
/**
 * @package    Joomla.Site
 * @subpackage Modules JMG Article Slider
 * @link http://joomega.com
 * @copyright   Copyright (C) 2021 - 2029 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$catid = $params->get('category');
$elements = $params->get('elements');
$cols = $params->get('cols',3);
$img_height = $params->get('img_height');
$max_length = $params->get('max_length',100);
$template = $params->get('template');

require( JModuleHelper::getLayoutPath( 'mod_jmgarticleslider' ) );
?>