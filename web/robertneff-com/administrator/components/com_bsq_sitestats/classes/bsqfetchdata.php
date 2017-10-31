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
* 
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle
* @author Michiel Bijland
*
*/

//ensure this file is being included by a parent file
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

require_once('bsqdatetime.class.php');
require_once('bsqlookups.php');

/**
 * Combine two arrays where the first column is the key and second is the value
 * into a value and a percentage of a total.
 *
 * @param array $a1 First array
 * @param array $a2 Second array
 * @param integer $total Total number (should be sum of column 2 for a1 and a2). If 0, will be computed
 * @param integer $order 1=descending, 0=ascending
 * @param integer $limit Limit of results returned (0 = no limit)
 *
 * @return array Sorted array consisting of rows of key,count,percent
 */
function bsq_keyValueArrayMerge($a1, $a2, $total, $order, $limit)
{
	$sorted = array();
	$fakeTotal = 0;
	
	//Merge both arrays into a key=>value array
	foreach ($a1 as $row) {
		$count = intval($row[1]);
		$fakeTotal += $count;
		
		if(isset($sorted[$row[0]])) {
			$sorted[$row[0]] += $count;
		}
		else {
			$sorted[$row[0]] = $count;
		}
		
	}
	
	foreach ($a2 as $row) {
		$count = intval($row[1]);
		$fakeTotal += $count;
		
		if(isset($sorted[$row[0]])) {
			$sorted[$row[0]] += $count;
		}
		else {
			$sorted[$row[0]] = $count;
		}
	}
	
	if ($order)
		arsort($sorted);
	else
		asort($sorted);
	
	if (!$total) {
		$total = $fakeTotal;
	}
		
	$count = 0;
	$retArr = array();
	foreach ($sorted as $key=>$value) {
		$retArr[] = array($key, $value, number_format(($value / $total) * 100, 2));
		
		$count++;
		if ($limit && $count >= $limit)
			break;
	}
	
	return $retArr;
}

/**
 * Get the fieldname in the Joomla users table for a configured display type
 *
 * @param integer showUsersAs Integer representation of how to display users
 *
 * @return string Name of the column 
 */
function bsq_getUserAsFieldname($showUsersAs)
{
	if ($showUsersAs == 0) {
		$userCol = 'id';
	}
	else if ($showUsersAs == 1) {
		$userCol = 'name';
	}
	else if ($showUsersAs == 2) {
		$userCol = 'username';
	}
	else {
		die('Invalid userAs: '.$showUsersAs);
	}
	
	return $userCol;
}

/**
 * Trim the text fields off of a result set since Joomla doesn't have a function to return
 * numerically indexed full sets from <var>$database</var>.
 *
 * @param string $a1 Array to trim
 * @param integer $numColumns Number of columns to keep (numeric ones)
 *
 * @return array
 */
function bsq_trimArrayToNumericColumns($a1, $numColumns)
{
	$retArr = array();
	
	for ($i = 0; $i < count($a1); $i++) {
		$row = $a1[$i];
		
		$newRow = array();
		for ($j = 0; $j < $numColumns; $j++) {
			$newRow[$j] = $row[$j];
		}
		
		$retArr[] = $newRow;
	}
	
	return $retArr;
}
 
/**
 * Returns total hits since $fromTime
 *
 * @param integer $fromTime Seconds since 1970 to start at. If not specified, midnight of today is used.
 *
 * @return integer
 */
function bsq_getHitCountSince($fromTime = false)
{
	global $database, $mosConfig_offset;
	
	if ($fromTime !== false) {
		$dt = $fromTime;
	}
	else {
		$dt = BSQDateTime::StartOfToday();
	}
	
	$total = 0;
	$query = "SELECT COUNT(*) AS 'total' FROM `#__bsq_hit` WHERE `dt` >= '$dt'";
	$database->setQuery($query);
	if ($count = $database->loadResult()) {
		$total += $count;
	}
	$query = "SELECT COUNT(*) AS 'total' FROM `#__bsq_smallhit` WHERE `dt` >= '$dt'";
	$database->setQuery($query);
	if ($count = $database->loadResult()) {
			$total += $count;
	}
	return $total;
}
	
/**
 * Returns a count of unique visitors since a certain time.
 * 
 * @param integer $fromSec Optional parameter of when to start today in time() format
 *                         If not provided, start of today will be used
 *
 * @return integer
 */
function bsq_getUniqueIPCountSince($fromSec = false)
{
	global $database, $mosConfig_offset;
	
	if ($fromSec !== false) {
		$dt = $fromSec;
	} //Calculate it!
	else { 
		$dt = BSQDateTime::StartOfToday();
	}
	
	//This is to be used as a hash to emulate using a temporary table to select distinct from the two queries
	$mergedArray = array(); 
	
	$query = "SELECT DISTINCT remote_ip FROM `#__bsq_hit` WHERE dt > '$dt'";
	$database->setQuery($query);
	if ($rows = $database->loadRowList()) {
		foreach ($rows as $row) {
			$mergedArray[$row[0]] = 1;
		}
	}
	
	$query = "SELECT DISTINCT ip FROM `#__bsq_smallhit` WHERE dt > '$dt'";
	$database->setQuery($query);
	if ($rows = $database->loadRowList()) {
		foreach ($rows as $row) {
			$mergedArray[$row[0]] = 1;
		}
	}
	
	return count($mergedArray);
}

/**
 * Returns Unix timestamp of today's first recorded hit in database time (server time)
 *
 * @return integer
 */
function bsq_getFirstHitTimestamp()
{
	global $database;
	
	$query = "SELECT `dt` FROM `#__bsq_smallhit` ORDER BY dt ASC";
	$database->setQuery($query, 0, 1);
	if ($date = $database->loadResult()){
		return intval($date);
	}
	if(empty($date) || !$date){
		$query = "SELECT `dt` FROM `#__bsq_hit` ORDER BY dt ASC";
		$database->setQuery($query, 0, 1);
		if ($date = $database->loadResult()){
			return intval($date);
		}	
	}
	return false;
}

/**
 * Page views count per time period taken over a defined period of time.
 * Default time is one hour.
 *
 * @param integer $beforeNow Number of seconds before NOW to start at.
 * @param integer $period Time period to divide by (in seconds).
 *
 * @return integer
 */
function bsq_getPageViewsInWindowCount($beforeNow = 86400, $period = 3600)
{
	global $database;
	
	$beforeNow = $period > $beforeNow ? $period : $beforeNow;
	$dt = time() - $beforeNow;
	
	$total = bsq_getHitCountSince($dt);

	return round($total/($beforeNow / $period));
}

/**
 * Avarage Page views per User
 *
 * @param integer $beforeNow Seconds before now to start calculating this statistic.
 *
 * @return integer
 */
function bsq_getAvgViewsPerIPCount($beforeNow = 86400)
{
	global $database;
	
	$dt = time() - $beforeNow;
	$dt = 0;
	
	$hitCount = bsq_getHitCountSince($dt);
	$ipCount = bsq_getUniqueIPCountSince($dt);
	
	return number_format($hitCount / $ipCount, 2);
}

/**
 * Get top search engine keyword strings
 *
 * @param integer $order 1=most common to least common. 0 = least to most common
 * @param integer $limit Maximum search terms to return in $order order.
 *
 * @return array();
 */
function bsq_getKeywordFrequency($order = 1, $limit = 30) 
{
	global $database;
	
	$sort = $order ? 'DESC' : 'ASC';
	$query ="SELECT `searchterms`, `count` 
			FROM `#__bsq_searchterms` 
			ORDER BY `count` $sort ";

	$database->setQuery( $query, 0, $limit );
	$return = array();
	if ($rows = $database->loadRowList()){
		foreach($rows as $row){
			$return[] = array('words' => $row[0], 'count' => intval($row[1]) );
		}
		return $return;
	}
	return array();
}

/**
 * Get most popular languages as a percentage.
 * 
 * @param integer $order 1=highest to lowest, 0=lowest to highest
 * @param integer $limit Maximum language rows to return
 *
 * @return array(); Most popular language in order specified above.
 */
function bsq_getLanguageFrequency($order = 1, $limit = 30) 
{
	global $database, $bsq_languageLookup;
	
	$sort = $order ? 'DESC' : 'ASC'; 
	
	$return = array();
	$total = 0; //Let the array merge calculate the total
		
	$query = "SELECT language, COUNT(language) AS 'total' 
			  FROM `#__bsq_hit` 
			  WHERE language != '' AND language != 'empty' 
			  GROUP BY language
			  ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2); //Use * 2 so the merge is semi-accurate
	if (!is_array($hits = $database->loadRowList()))
		return false;
	
	//Substitute "friendly" strings for languages
	for ($i = 0; $i < count($hits); $i++)
	{
		if (!isset($bsq_languageLookup[$hits[$i]['language']])) {
			continue;
		}
		
		$alias = $bsq_languageLookup[$hits[$i]['language']];
		$hits[$i][0] = $alias;
		$hits[$i]['language'] = $alias;
	}		
		
	$query = "SELECT language, COUNT(language) AS 'total' 
			  FROM `#__bsq_smallhit` 
			  WHERE language != '' AND language != 'empty' 
			  GROUP BY language
			  ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2); //Use * 2 so the merge is semi-accurate
	if (!is_array($smallHits = $database->loadRowList()))
		return false;
	
	//Substitute "friendly" strings for languages
	for ($i = 0; $i < count($smallHits); $i++)
	{
		if (!isset($bsq_languageLookup[$smallHits[$i]['language']])) {
			continue;
		}
		
		$alias = $bsq_languageLookup[$smallHits[$i]['language']];
		$smallHits[$i][0] = $alias;
		$smallHits[$i]['language'] = $alias;
	}	
		
	$retArr = bsq_keyValueArrayMerge($hits, $smallHits, $total, $order, $limit);
	return $retArr;
}


/**
 * returns array of platform count and percentage
 *
 * @param integer $order 1=most frequent to least frequent, 0=least frequent to most frequent
 * @param integer $limit Maximum rows to return (default = 30)
 * @param boolean $showUnknown Show unknown platforms or not (default = true)
 *
 * @return array
 */
function bsq_getPlatformFrequency($order = 1, $limit = 30, $showUnknown = true) {
	global $database;
	
	$total = bsq_getHitCountSince(0);
	if(empty($total)){
		return false;
	}
	
	$whereClause = $showUnknown ? '' : 'WHERE platform!=\'Indeterminable\'';
	$sort = $order ? 'DESC' : 'ASC';
	$query = "SELECT platform, COUNT(platform) AS total
			  FROM `#__bsq_hit`
			  $whereClause
			  GROUP BY platform
			  ORDER BY total $sort";
	
	$database->setQuery($query);
	if (!is_array($rows = $database->loadRowList()))	
		return false;
		
	$whereClause = $showUnknown ? '' : 'WHERE lookupStr!=\'Indeterminable\'';
	$query = "SELECT lookupStr, refCount
	          FROM `#__bsq_platform`
	          $whereClause	
		      ORDER BY refCount $sort";
	$database->setQuery($query);
	if (!is_array($rows2 = $database->loadRowList()))	
		return false;

	$retArr = bsq_keyValueArrayMerge($rows, $rows2, $total, $order, $limit);
	return $retArr;
}

/**
 * returns array of domain count and percentage
 *
 * @param integer $order 1=most frequent to least frequent, 0=least frequent to most frequent
 * @param integer $limit Maximum rows to return (default = 30)

 *
 * @return array
 */
function bsq_getDomainFrequency($order = 1, $limit = 30) {
	global $database, $mosConfig_live_site;
	
	$total = 0; //Let the array merge calculate the total
	
	$url 	= parse_url($mosConfig_live_site);
	$ourDomain	= eregi_replace("^www.","", $url['host']); /* Calculate same way as ShortStat */
	
	$sort = $order ? 'DESC' : 'ASC';
	$query = "SELECT domain, COUNT(domain) AS total
			  FROM `#__bsq_hit`
			  WHERE domain!='' AND domain !='$ourDomain' AND domain !='localhost'
			  GROUP BY domain
			  ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows = $database->loadRowList()))	
		return false;
		
	$query = "SELECT lookupStr, refCount
	          FROM `#__bsq_domain`
	          WHERE lookupStr!='' AND lookupStr!='$ourDomain' AND lookupStr!='localhost'
		      ORDER BY refCount $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows2 = $database->loadRowList()))	
		return false;

	$retArr = bsq_keyValueArrayMerge($rows, $rows2, $total, $order, $limit);
	return $retArr;
}

/**
 * returns array of referer count and percentage
 *
 * @param integer $order 1=most frequent to least frequent, 0=least frequent to most frequent
 * @param integer $limit Maximum rows to return (default = 30)
 * @param integer $ignoreSelf Ignore hits from our domain (or localhost)
 *
 * @return array
 */
function bsq_getRefererFrequency($order = 1, $limit = 30, $ignoreSelf=true) {
	global $database;
	
	$total = 0; //Let the array merge calculate the total
	
	$ourHost = $_SERVER['HTTP_HOST'];
	if(strlen($ourHost) > 0)
		$ourDomain = 'http://'.$_SERVER['HTTP_HOST'];
	else 
		$ignoreSelf = false; //Can't ignore ourself if we don't exist
	
	$sort = $order ? 'DESC' : 'ASC';
	$whereClause = $ignoreSelf ? "AND referer NOT LIKE('$ourDomain%')" : '';
	$query = "SELECT referer, COUNT(referer) AS total
			  FROM `#__bsq_hit`
			  WHERE referer!='' AND referer NOT LIKE('http://localhost%') $whereClause
			  GROUP BY referer
			  ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows = $database->loadRowList()))	
		return false;
	
	$whereClause = $ignoreSelf ? "AND lookupStr NOT LIKE('$ourDomain%')" : '';
	$query = "SELECT lookupStr, refCount
	          FROM `#__bsq_referer`
	          WHERE lookupStr!='' AND lookupStr NOT LIKE('http://localhost%') $whereClause
		      ORDER BY refCount $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows2 = $database->loadRowList()))	
		return false;

	$retArr = bsq_keyValueArrayMerge($rows, $rows2, $total, $order, $limit);
	return $retArr;
}

/**
 * Returns array of resource count and percentages of total
 *
 * @param integer $order 1=most frequent to least frequent, 0=least frequent to most frequent
 * @param integer $limit Maximum rows to return (default = 30)
 *
 * @return array
 */
function bsq_getResourceFrequency($order = 1, $limit = 30) {
	global $database;
	
	$total = bsq_getHitCountSince(0);
	if(empty($total)) {
		return array();
	}
	
	$sort = $order ? 'DESC' : 'ASC';
	$query = "SELECT resource, COUNT(resource) AS total
			  FROM `#__bsq_hit`
			  GROUP BY resource
			  ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows = $database->loadRowList()))	
		return false;
		
	$query = "SELECT lookupStr, refCount
	          FROM `#__bsq_resource`
		      ORDER BY refCount $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows2 = $database->loadRowList()))	
		return false;

	$retArr = bsq_keyValueArrayMerge($rows, $rows2, $total, $order, $limit);
	return $retArr;
}

/**
 * Returns array of browsers, count, and percentage
 *
 * @param integer $order 1=most frequent to least frequent, 0=least frequent to most frequent
 * @param integer $limit Maximum rows to return (default = 30)
 *
 * @return array
 */
function bsq_getBrowserFrequency($order = 1, $limit = 30) {
	global $database;
	
	$total = 0; //Let the array merge calculate the total
	
	$sort = $order ? 'DESC' : 'ASC';
	$query = "SELECT browser, COUNT(browser) AS total
			  FROM `#__bsq_hit`
			  GROUP BY browser
			  ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows = $database->loadRowList()))	
		return false;
		
	$query = "SELECT browserID, count(browserID) as total
	          FROM `#__bsq_smallhit`
	          GROUP BY browserID
		      ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows2 = $database->loadRowList()))	
		return false;

	for ($i = 0; $i < count($rows2); $i++) {
		$rows2[$i]['browserID'] = $rows2[$i][0] = bsq_lookupBrowserID(intval($rows2[$i][0]));
	}
		
	$retArr = bsq_keyValueArrayMerge($rows, $rows2, $total, $order, $limit);
	return $retArr;
}

/**
 * Returns array of IP address, count, and percentage
 *
 * @param integer $order 1=most frequent to least frequent, 0=least frequent to most frequent
 * @param integer $limit Maximum rows to return (default = 30)
 *
 * @return array
 */
function bsq_getVisitorFrequency($order = 1, $limit = 30) {
	global $database;
	
	$total = bsq_getHitCountSince(0);
	if(empty($total)) {
		return false;
	}
	
	$sort = $order ? 'DESC' : 'ASC';
	$query = "SELECT remote_ip, COUNT(remote_ip) AS total
			  FROM `#__bsq_hit`
			  GROUP BY remote_ip
			  ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows = $database->loadRowList()))	
		return false;
		
	$query = "SELECT browserID, count(browserID) as total
	          FROM `#__bsq_smallhit`
	          GROUP BY browserID
		      ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows2 = $database->loadRowList()))	
		return false;
		
	$retArr = bsq_keyValueArrayMerge($rows, $rows2, $total, $order, $limit);
	return $retArr;
}

/**
 * Get the latest hits, returning: IP address, URI, browser, formatted date, user
 * 
 * @param integer $limit Number of rows to return
 * @param integer $resolveIp Resolve IP addresses to DNS names. 1=yes 0=no
 * @param integer $dateFormat Format for the date in date() syntax
 * @param integer $showUsersAs How to show the user column.
 * @param string $ipAddress Optional IP Address to filter on
 *
 */
function bsq_getLatestVisitors($limit = 100, $resolveIp = 1, $dateFormat, $showUsersAs, $ipAddress='')
{
	global $database;
	$userCol = bsq_getUserAsFieldname($showUsersAs);
	
	/* Setup the optional IP filter */
	$ipFilter = '';
	if($ipAddress) {
		$ipFilter = " AND remote_ip='$ipAddress'";
	}
	
	/* User a LEFT join so we get hits from unregistered guests as well */
	$query = "SELECT remote_ip, resource, browser, dt, u.$userCol
	          FROM #__bsq_hit AS h
	          LEFT JOIN #__users AS u ON ( h.user_id = u.id ) 
	          WHERE browser != 'Crawler/Search Engine' $ipFilter
	          ORDER BY h.id DESC";
	
	$database->setQuery($query, 0, $limit);
	if (!is_array($rows = $database->loadRowList())) {
		return false;
	}
	
	foreach ($rows as $key=>$row) {
		$row[3] = $row['dt'] = date($dateFormat, BSQDateTime::Time(intval($row[3])));
		$rows[$key] = $row; /* Save the value back since we just modified a copy of it */
	}
	
	if ($resolveIp) {
		foreach ($rows as $key=>$row) {
			$row[0] = $row['remote_ip'] = gethostbyaddr($row[0]);
			$rows[$key] = $row; /* Save the value back since we just modified a copy of it */
		}
	}

	return $rows;
}

/**
 * Get latest referers from our hits table. This ignores the archived hits. Returns referers
 * as: referer URL, URI requested, IP address of client, formatted date
 *
 * @param integer $limit Maximum rows to return (default = 30)
 * @param string  $dateFormat Format string for the date of the referral. 
 * @param boolean $ignoreSelf Ignore hits from our domain (or localhost)
 * @param integer $resolveIp Resolve IP address of client (1 = yes, 0 = no)
 *
 * @return array
 */
function bsq_getLatestReferers($limit = 30, $dateFormat, $ignoreSelf=true, $resolveIp=1) 
{
	global $database;
	
	$ourHost = $_SERVER['HTTP_HOST'];
	if(strlen($ourHost) > 0)
		$ourDomain = 'http://'.$_SERVER['HTTP_HOST'];
	else 
		$ignoreSelf = false; //Can't ignore ourself if we don't exist
	
	$whereClause = $ignoreSelf ? "AND referer NOT LIKE('$ourDomain%')" : '';
	$query = "SELECT referer, resource, remote_ip, dt
			  FROM `#__bsq_hit`
			  WHERE referer!='' AND referer NOT LIKE('http://localhost%') $whereClause
			  ORDER BY id DESC";
	$database->setQuery($query, 0, $limit);
	if (!is_array($rows = $database->loadRowList()))	
		return false;
	
	$rows = bsq_trimArrayToNumericColumns($rows, 4);
		
	foreach ($rows as $key=>$row) {
		$rows[$key][3] = date($dateFormat, BSQDateTime::Time(intval($row[3])));
		
		if ($resolveIp) {	
			$row[2] = gethostbyaddr($row[2]);
		}
	}
		
	return $rows;
}

/**
 * Get a chart of the visitors as an array of two sub arrays. Each being:
 * 1. Formatted dates of when the time period starts
 * 2. Number of visitors in this time period
 *
 * @param integer $interval Sample interval in seconds. For example, 3600==one hour==give counts per hour
 * @param integer $numPoints Number of datapoints of size <var>interval</var> to go back.
 * @param string  $dateFormat Date format for the chart
 *
 * @return array See above. Returns FALSE on error.
 */
function bsq_getVisitorsChart($interval, $numPoints, $dateFormat)
{
	global $database;
	
	if ($interval <= 0 || $numPoints <= 0) {
		return false;
	}
	
	$retArr = array(array(), array());
	
	$startSecond = time() - ($interval * $numPoints) - $interval;
	
	$query = "SELECT COUNT(smallhitID) AS hitcount, (FLOOR( dt/$interval)*$interval) AS thetime
			  FROM `#__bsq_smallhit`
			  WHERE dt >= $startSecond
			  GROUP BY thetime
			  ORDER BY thetime ASC";
	$database->setQuery($query);
	if (!is_array($rows = $database->loadRowList()))	
		return false;
	
	$query = "SELECT COUNT(id) AS hitcount, (FLOOR( dt/$interval)*$interval) AS thetime
			  FROM `#__bsq_hit`
			  WHERE dt >= $startSecond
			  GROUP BY thetime
			  ORDER BY thetime ASC";
	$database->setQuery($query);
	if (!is_array($rows2 = $database->loadRowList()))	
		return false;
	
	
	/* Start to prepare the array that the calling function is expecting */
	$lastKey = null;
	foreach ($rows as $key=>$row) {
		$realTime = BSQDateTime::Time(intval($row[1]));
		$retArr[0][$key] = date($dateFormat, $realTime);
		$retArr[1][$key] = intval($row[0]);
		$lastKey = $key;
	}
	
	/* Merge the first record of set */
	if($lastKey && $rows[$lastKey][1] == $rows2[0][1]) { //Same timestamp?
		$retArr[1][$lastKey] += intval($rows2[0][0]);
		unset($rows2[0]);
	}
	
	/* Append the second array to the first */
	foreach ($rows2 as $key=>$row) {
		$realTime = BSQDateTime::Time(intval($row[1]));
		$retArr[0][] = date($dateFormat, $realTime);
		$retArr[1][] = intval($row[0]);
	}
	
	return $retArr;
}

/**
 * Get the latest hits for a user, returning: IP address, URI, browser, formatted date
 * 
 * @param integer $userId Joomla user id of the user to look for
 * @param integer $limit Number of rows to return
 * @param integer $resolveIp Resolve IP addresses to DNS names. 1=yes 0=no
 * @param integer $dateFormat Format for the date in date() syntax
 *
 */
function bsq_getUsersLatestHits($userID, $limit = 100, $resolveIp = 1, $dateFormat)
{
	global $database;
	
	$query = "SELECT remote_ip, resource, browser, dt
	          FROM #__bsq_hit
	          WHERE user_id='$userID'
	          ORDER BY id DESC";
	
	$database->setQuery($query, 0, $limit);
	if (!is_array($rows = $database->loadRowList())) {
		return false;
	}
	
	foreach ($rows as $key=>$row) {
		$row[3] = $row['dt'] = date($dateFormat, BSQDateTime::Time(intval($row[3])));
		$rows[$key] = $row; /* Save the value back since we just modified a copy of it */
	}
	
	if ($resolveIp) {
		foreach ($rows as $key=>$row) {
			$row[0] = $row['remote_ip'] = gethostbyaddr($row[0]);
			$rows[$key] = $row; /* Save the value back since we just modified a copy of it */
		}
	}

	return $rows;
}

/**
 * Get an array of the top users and their visit frequencies. 
 *  Returns array of user, count, and percentage
 *
 * @param integer $userAs How to return the user: 0=user id, 1=name, 2=username
 * @param integer $order 1=most frequent to least frequent, 0=least frequent to most frequent
 * @param integer $limit Maximum rows to return (default = 30)
 *
 * @return array
 */
function bsq_getTopUserFrequency($userAs = 0, $order = 1, $limit = 30) {
	global $database;
	
	$total = 0; /* Calculate percentages from aggregation */
	$userCol = bsq_getUserAsFieldname($userAs);
	
	$sort = $order ? 'DESC' : 'ASC';
	$query = "SELECT u.$userCol AS user_ident, COUNT( h.user_id )  AS total
			  FROM #__bsq_hit AS h
			  INNER JOIN #__users AS u ON ( h.user_id = u.id )
			  GROUP BY user_ident
			  ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows = $database->loadRowList())) {
		return false;
	}
		
	$query = "SELECT u.$userCol AS user_ident, count( h.user_id) as total
	          FROM `#__bsq_smallhit` AS h
	          INNER JOIN #__users AS u ON ( h.user_id = u.id )
	          GROUP BY user_ident
		      ORDER BY total $sort";
	$database->setQuery($query, 0, $limit * 2);
	if (!is_array($rows2 = $database->loadRowList())) {
		return false;
	}
		
	$retArr = bsq_keyValueArrayMerge($rows, $rows2, $total, $order, $limit);
	return $retArr;
}

/**
 * Get the usernames associated with an IP address
 *
 * @param $userAs How to return the user: 0=user id, 1=name, 2=username
 * @param $ipAddress IP Address to lookup in X.X.X.X format.
 *
 * @return Array of usernames in $userAs format
 *
 */
function bsq_getUsersForIpAddress($userAs, $ipAddress)
{
	global $database;
	
	if (!$ipAddress) {
		return array();
	}
	
	$userCol = bsq_getUserAsFieldname($userAs);
	
	/* NOTE: If you want NULL usernames for any reason, change the join below to LEFT instead of INNER */
	$query = "SELECT DISTINCT(u.$userCol)
	          FROM #__bsq_hit AS h
	          INNER JOIN #__users AS u ON (h.user_id = u.id)
	          WHERE h.remote_ip='$ipAddress'
	          ORDER BY u.$userCol ASC";
	$database->setQuery($query);
	if (!is_array($rows = $database->loadRowList())) {
		return array();
	}
	
	/* Remove the associations */
	$retArr = array();
	foreach ($rows as $row) {
		$retArr[] = $row[0];
	}
	
	return $retArr;
}

?>