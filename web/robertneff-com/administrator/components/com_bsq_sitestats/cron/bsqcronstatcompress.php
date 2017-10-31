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
* Compress the hit table into the smallhit table 
*
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle
*
*/

if ($_SERVER['REQUEST_URI'])
	die('Unauthorized script access');

$baseDir = dirname(__FILE__) . '/';	
	
// Setup a pseudo-Joomla environment
define('_VALID_MOS', 1); //Pretend we're Joomla
require_once($baseDir.'../../../../configuration.php');
require_once($baseDir .'../../../../includes/joomla.php');
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );

// Get the BSQ Sitestats configs
require_once($mosConfig_absolute_path.'/administrator/components/com_bsq_sitestats/config.bsq_sitestats.php');
require_once($mosConfig_absolute_path.'/administrator/components/com_bsq_sitestats/classes/bsqstatcompress.class.php');

$BSQCompress = new BSQSitestatsCompress();
$moreRows = $BSQCompress->CompressHits($bsq_sitestats_hoursBeforeCompress * 3600, $bsq_sitestats_rowsPerCompress);

if($moreRows) {
	echo "Compressed $bsq_sitestats_rowsPerCompress rows newer than $bsq_sitestats_hoursBeforeCompress hours.\n";
}
else {
	echo "Compressed all available rows newer than $bsq_sitestats_hoursBeforeCompress hours.\n";
}

?>