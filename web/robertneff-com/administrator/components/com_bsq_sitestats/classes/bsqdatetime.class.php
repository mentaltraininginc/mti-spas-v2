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


defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Date and time management class
*
* @package bsq_sitestats
* @copyright Brent Stolle (c) 2005
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author  Brent Stolle
*/
class BSQDateTime
{	
	/**
	 * Get the current time in BSQ time, taking the time offset into account. 
	 *
	 * @param integer $timestamp Optional timestamp of the time to get
	 *
	 * @return integer Converted timestamp
	 */
	function Time($timestamp = 0)
	{
		global $bsq_sitestats_reportHoursOffset;
		
		$timestamp = intval($timestamp);
		
		if (!$timestamp) {
			$timestamp = time();
		}
		
		$timestamp += (3600 * $bsq_sitestats_reportHoursOffset);
		return $timestamp;
	}
	
	/**
	 * Get the first second of Today in BSQ time
	 * 
	 * @return integer Unix timestamp of the first second of today in BSQ time
	 */
	function StartOfToday()
	{
		$timestamp = BSQDateTime::Time();
		
		$timeArr = localtime($timestamp, true);
		$sinceMidnight = $timeArr['tm_sec'] + (60 * $timeArr['tm_min']) + (3600 * $timeArr['tm_hour']);
		
		return $timestamp - $sinceMidnight;
	}
}

?>