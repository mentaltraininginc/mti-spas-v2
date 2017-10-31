<?php
/*
BSQ_Sitestats is written by Brent Stolle (c) 2005
Brent can be contacted at dev@bs-squared.com or at http://www.bs-squared.com/

This software is FREE. Please distribute it under the terms of the GNU/GPL License
See http://www.gnu.org/copyleft/gpl.html GNU/GPL for details.

If you fork this to create your own project, please make a reference to BSQ_Sitestats
someplace in your code and provide a link to http://www.bs-squared.com

BSQ_Sitestats is based on and made to operate along side of Shaun Inman's ShortStat
http://www.shauninman.com/
*/

/**
* Front-end display for BSQ Sitestats
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle <dev@bs-squared.com>
*
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

require_once($mosConfig_absolute_path . '/administrator/components/com_bsq_sitestats/bsqglobals.inc.php');

//Load library classes
require_once($bsqClassPath.'/bsqcache.class.php');
require_once($bsqClassPath.'/bsqsitestatsrender.php');	
require_once($bsqClassPath.'/bsqtabbedreport.class.php');

$cacheTime = $bsq_sitestats_cacheTime;
$limit = $bsq_sitestats_rowLimit;
$cssPrepend = $bsq_sitestats_cssPrepend;
$dateFormat = $bsq_sitestats_dateFormat;
$useInternalCSS = $bsq_sitestats_useInternalCSS;
$order = 1;
$howDisplay = 0;
$beforeNow = 3600;
$duration = 3600;

$bsqCache = new BSQCache(array('lifetime'=>$cacheTime));
//If the cache time is 0, turn off caching. Otherwise, set it
if(!$cacheTime) {
	$bsqCache->enableCache(false);
}
else {
	$bsqCache->enableCache(true);
	$bsqCache->setLifeTime($cacheTime);
}

$bsqRender = new BSQSitestatsRender($bsqCache, $cssPrepend);

if ($useInternalCSS) {
	$cssPath = $mosConfig_live_site . '/components/com_bsq_sitestats/bsq_sitestats.css';
	echo '<link rel="stylesheet" href="'.$cssPath.'" type="text/css" />'."\n";
}

// NOT USED FOR NOW. Load the HTML class
//require_once($mainframe->getPath('front_html')); 	

BSQTabbedReport::show($bsqRender, $order, $limit, $howDisplay, $beforeNow, $duration, $dateFormat, $cssPrepend);

echo "\n<!-- Site statistics by BSQ Sitestats, (c) 2005 Brent Stolle, http://www.bs-squared.com/mambo/index.php -->\n";

?> 