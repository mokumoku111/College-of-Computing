<?php
/**
 * @package    Joomla.Site
 * @subpackage Modules JMG Article Slider
 * @link http://joomega.com
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$doc  = JFactory::getDocument();
$doc->addStyleSheet(Juri::base() . 'modules/mod_jmgarticleslider/assets/css/mod_jmgarticleslider.css');
$doc->addStyleSheet(Juri::base() . 'modules/mod_jmgarticleslider/assets/css/splide.min.css');
$doc->addScript(Juri::base() . 'modules/mod_jmgarticleslider/assets/js/splide.js');

if($img_height){
	$style = '.jmgarticleslider-body  .image{'
		. 'height: '.$img_height.'px;'
		. '}'; 
	$doc->addStyleDeclaration($style);	
}

$script = "
	document.addEventListener( 'DOMContentLoaded', function () {
			new Splide( '.splide', {
			type   : 'loop',
			perPage: ".$cols.",
			height     : '".$img_height."',
			cover      : true,
			perMove: 1,
			autoplay: true,
			pagination: true,
		} ).mount();
	} );
";
$doc->addScriptDeclaration($script);

$articles = modJmgArticlesliderHelper::getArticles($catid,$max_length);

?>

<div class="jmgarticleslider-body">
	<div class="splide">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach ($articles as $i => $item) : ?>
				<?php
				$images  = json_decode($item->images);
				?>
				<li class="splide__slide">
					<div class="item-wrapper">
						<div class="image">
							<a href="<?php echo JRoute::_('index.php?option=com_content&view=article&id='.$item->id.'&catid='.$item->catid); ?>">		
							<img src="<?php echo JURI::root().$images->image_intro; ?>" alt="<?php echo $item->title; ?>" />
							</a>	
						</div>
						<div class="headline">
							<h3 class="start"><?php echo $item->title; ?></h3>
						</div>
						<div class="text">
							<p><?php echo strip_tags($item->text); ?></p>
						</div>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>