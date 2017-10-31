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
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle
*
*/

/* ensure this file is being included by a parent file */
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_lang;

/* Version Information */
$bsqVerMaj = 1;
$bsqVerMin = 7;
$bsqVerRev = 1;

$bsqVersion = "$bsqVerMaj.$bsqVerMin.$bsqVerRev";
$bsqAppTitle = 'BSQ Sitestats';
$bsqAppTitleVer = $bsqAppTitle.' '.$bsqVersion;

/* Define the paths for BSQ Sitestats */
$bsqAdminPath = $mosConfig_absolute_path . '/administrator/components/com_bsq_sitestats';
$bsqClassPath = $bsqAdminPath . '/classes';
$bsqFileCachePath = $bsqAdminPath . '/filecache';

$bsqComPath = $mosConfig_absolute_path . '/components/com_bsq_sitestats';
$bsqLangPath = $bsqComPath . '/language';
$bsqGraphImgPath = $bsqComPath . '/graphimg';
$bsqGraphImgWebPath = $mosConfig_live_site . '/components/com_bsq_sitestats/graphimg';

/* 3rd-party libraries */
$bsqGraphPath = $mosConfig_absolute_path . '/administrator/components/com_jpgraph/src';


/* Include all of the config variables as globals */
include 'config.bsq_sitestats.php';


/* Language constants */
if (file_exists($bsqLangPath . '/'.$mosConfig_lang.'.php'))
	require_once ($bsqLangPath . '/'.$mosConfig_lang.'.php');
else
	require_once ($bsqLangPath . '/english.php');

	
/* Date constants */
$bsqTimeIntervals = array(
			'1min' =>   array('1 '._BSQ_MINUTE, 	60),
			'5min' =>   array('5 '._BSQ_MINUTES, 	300),
			'10min' =>  array('10 '._BSQ_MINUTES, 	600),
			'30min' =>  array('30 '._BSQ_MINUTE, 	1800),
			'1hour' =>  array('1 '._BSQ_HOUR, 		3600),
			'4hour' =>  array('4 '._BSQ_HOURS, 		14400),
			'6hour' =>  array('6 '._BSQ_HOURS, 		21600),
			'12hour' => array('12 '._BSQ_HOURS, 	28800),
			'1day' =>   array('1 '._BSQ_DAY, 		86400),
			'5day' =>   array('5 '._BSQ_DAYS, 		432000),
			'1week' =>  array('1 '._BSQ_WEEK, 		604800),
			'2week' =>  array('2 '._BSQ_WEEKS, 		1209600)
			);
?>