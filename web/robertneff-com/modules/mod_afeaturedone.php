<?php
/**
* @version $Id: mod_ppolaroid.php 07 2005-10-31 16:15:08Z rabencor $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

global $mosConfig_live_site;

$imagepath		= $params->get( 'img' );
$imagewidth		= $params->get( 'imgwidth' );
$imageheight	= $params->get( 'imgheight' );

$link			= $params->get( 'link' );
$link_txt		= $params->get( 'link_txt' );
$link_url		= $params->get( 'link_url' );
$link_window	= $params->get( 'link_window' );

$text			= $params->get( 'text' );
$text_txt		= $params->get( 'text_txt' );

$frame			= $params->get( 'frame' );
$framew			= $params->get( 'framew' );
$framebg		= $params->get( 'framebg' );
$framebw		= $params->get( 'framebw' );
$framebcolor	= $params->get( 'framebcolor' );



if ($imagepath) {
	
	$absimage = $mosConfig_live_site  . $imagepath;
	$imagedimensions = getimagesize($absimage);
	
	if ($imagewidth=='') {
		$imagewidth = $imagedimensions[0];
	};
	
	if ($imageheight=='') {
		$imageheight = $imagedimensions[1];
	};
	
	$output_mod = '<img src="'.$absimage . '" width="'.$imagewidth.'" height="'.$imageheight.'" alt="" />';
	
	if($link) {
		
		if($link_window) {
			$link_destiny = '_blank';
		} else {
			$link_destiny = '_self';
		};
		$link_mod = '<div style="display:block;position:relative;margin-top:3px;margin-bottom:2px;line-height:normal; text-align:left;"><a href="'.$link_url.'" target="'.$link_destiny.'">'.$link_txt.'</a></div>';
		$output_mod = $output_mod.$link_mod;
	};
	
	if($text) {
		$text_mod = '<div style="display:block;position:relative;margin-top:3px;margin-bottom:2px;line-height:normal;font-size:10px; text-align:left;">'.$text_txt.'</div>';
		$output_mod = $output_mod.$text_mod;
	};
	
	if(!$frame) {
		$framebw = 'none';
		$framebg = 'none';
		$framew  = 0;
	};
	
} else {
	$output_mod = 'Please define an image';
};
?>


<div align="center"> 
	<div style="width:<?php echo $imagewidth ?>px;height:100%;padding:<?php echo $framew ?>px;background:<?php echo $framebg ?>;border:<?php echo $framebw ?>px solid <?php echo $framebcolor ?>;text-align:center;">
		<?php echo $output_mod ?>
	</div> 
</div>