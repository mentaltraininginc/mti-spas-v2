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

/* ensure this file is being included by a parent file */
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

if(!$bsqClassPath) die('No bsqClassPath');
require_once($bsqClassPath . '/bsqfetchdata.php');
require_once($bsqClassPath . '/bsqdatetime.class.php');

if ($bsq_sitestats_useJpGraph) {
	require_once($bsqClassPath . '/bsqgraph.class.php');
}

class BSQSitestatsRender
{
	var $bsqCache = null;
	var $cssPrepend = '';
	var $isFrontend = true;
	
	/**
	 * Constructor for the BSQSitestatsRender Class
	 *
	 * @param BSQCache $bsqCache a cache object.
	 * @param string $cssPrepend String to prepend to every CSS class
	 * @param boolean $isFrontend Is this renderer being invoked from the Frontend? If so, certain things will be hidden
	 */
	function BSQSitestatsRender($bsqCache, $cssPrepend = '', $isFrontend=true)
	{
		$this->bsqCache = &$bsqCache;
		$this->cssPrepend = $cssPrepend;
		$this->isFrontend = $isFrontend;
	}
	
	/**
	 * General function to execute and display a tabular report. This uses the cache class's call
	 * mechanism as to cache the function call for whatever time has been specified in the
	 * cache class. 
	 *
	 * @param string $reportName Name of the report to execute. See switch statement below.
	 * @param integer $order Order. 1=descending. 0 = ascending.
	 * @param integer $limit How many rows to display
	 * @param integer $width Width of the graph to be generated
	 * @param integer $height Height of the graph to be generated
	 * @param integer $cacheTime Amount of time to cache the image
	 * @param string $valueColor Color to display values with. A valid JPGraph color string
	 * @param string $barFillColor Color to fill bars with. A valid JPGraph color string
	 *
	 * @return HTML code for the report to write to the display.
	 */
	
	function showBarGraph($reportName, $order, $limit, $width, $height, $cacheTime, $valueColor, $barFillColor)
	{	
		global $bsqAppTitleVer;
		
		if (!$reportName || !$limit) {
			return "<p>Missing param for BSQSitestatsRender::showBarGraph()</p>\n";
		}
			
		$reportName = strtolower($reportName);
		
		/* Don't bother to cache any of the following function calls as the graphs will be cached for the
		   exact same amount of time */
		switch ($reportName)
		{		
			case 'keywordfreq':
				$graphTitle = _BSQ_KEYWORDFREQ;
				break;
				
			case 'langfreq':
				$graphTitle = _BSQ_LANGUAGEFREQ;
				break;
				
			case 'platformfreq':
				$graphTitle = _BSQ_PLATFORMFREQ;
				break;
			
			case 'domainfreq':
				$graphTitle = _BSQ_DOMAINFREQ;
				break;
				
			case 'browserfreq':
				$graphTitle = _BSQ_BROWSERFREQ;
				break;
				
			case 'userfreq':
				$graphTitle = _BSQ_USERFREQ;
				break;
				
			default:
				return sprintf(_BSQ_BARCHARTNOTSUPPORTED, $reportName);
		}
		
		$barGraph = new BSQGraphBar();
		$result = $barGraph->init($width, $height, $cacheTime, $graphTitle, "bar$reportName");
		if (is_string($result)) {
			return $this->renderImage($result, $width, $height);
		}
		else if (!$result) {
			return '<strong>BSQGraph->init() failed from renderer->showBarGraph()</strong>';
		}
		else {
			/* Don't bother to cache any of the following function calls as the graphs will be cached for the
		       exact same amount of time */
			switch ($reportName)
			{		
				case 'keywordfreq':
					$result = bsq_getKeywordFrequency($order, $limit);
					break;
					
				case 'langfreq':
					$result = bsq_getLanguageFrequency($order, $limit);
					break;
					
				case 'platformfreq':
					$result = bsq_getPlatformFrequency($order, $limit, false);
					break;
					
				case 'domainfreq':
					$result = bsq_getDomainFrequency($order, $limit);
					break;
								
				case 'browserfreq':
					$result = bsq_getBrowserFrequency($order, $limit);
					break;
					
				case 'userfreq':
					$result = bsq_getTopUserFrequency(2, $order, $limit);
					break;
					
				default:
					$barGraph->abort();
					return sprintf('Impossible Error at %s:%d', __FILE__, __LINE__);
			}
			
			if ($result === null || $result === false) {
				$barGraph->abort();
				return sprintf("<p>Unknown error while doing bar graph of <strong>%s</strong>.</p>\n", $reportName);
			}
			else if (!count($result) || !count($result[0])) {
				$barGraph->abort();
				return sprintf('<h2>'._BSQ_NOTENOUGHFORBARCHART."</h2>\n", $graphTitle);
			}
			
			$barGraph->setBarsFromRows($result, 0, 1, $valueColor, $barFillColor);
			
			$result = $barGraph->flush();
			if (!$result) {
				return '<strong>BSQGraph->flush() failed from renderer->showBarGraph()</strong>';
			}
			else if (is_string($result)) {
				return $this->renderImage($result, $width, $height);
			}
		}
	}
	
	/**
	 * General function to execute and display a tabular report. This uses the cache class's call
	 * mechanism as to cache the function call for whatever time has been specified in the
	 * cache class. 
	 *
	 * @param string $reportName Name of the report to execute. See switch statement below.
	 * @param integer $order Order. 1=descending. 0 = ascending.
	 * @param integer $limit How many rows to display
	 * @param integer $beforeNow For time-based reports, how many seconds before now to start the report. 0 = now
	 * @param integer $duration For time-based reports, how long to do the report for (window size) 
	 * @param string $dateFormat Date format string that is compatible with date() (for time window functions)
	 * @param boolean $showCountAndPct Show count and percentage for aggregate columns
	 *
	 * @return HTML code for the report to write to the display.
	 */
	
	function showTabularReport($reportName, $order, $limit, $beforeNow, $duration, $dateFormat, $showCountAndPct=true)
	{	
		if (!$reportName || !$limit) {
			return "<p>Missing param for BSQSitestatsRender::showTabularReport()</p>\n";
		}
			
		$reportName = strtolower($reportName);
		
		switch ($reportName)
		{
			case 'totalhits':
				$result = $this->bsqCache->call('bsq_getHitCountSince', 0);
				$colTitles = array(_BSQ_TOTALHITS);
				break;
				
			case 'totalunique':
				$result = $this->bsqCache->call('bsq_getUniqueIPCountSince', 0);
				$colTitles = array(_BSQ_UNIQUEVISITORS);
				break;
			
			case 'todaycount':
				$result = $this->bsqCache->call('bsq_getHitCountSince');
				$colTitles = array(_BSQ_HITSTODAY);
				break;	
			
			case 'todayuniqueip':
				$result = $this->bsqCache->call('bsq_getUniqueIPCountSince');
				$colTitles = array(_BSQ_UNIQUEVISITORSTODAY);
				break;

			case 'viewswindowcount':
				$result = $this->bsqCache->call('bsq_getPageViewsInWindowCount', $beforeNow, $duration);
				$start = time() - $beforeNow;
				$viewsInWindow = _BSQ_VIEWSINWINDOW;
				$title = sprintf($viewsInWindow, date($dateFormat, $start), $duration); 
				$colTitles = array($title);
				break;	

			case 'averageperip':
				$result = $this->bsqCache->call('bsq_getAvgViewsPerIPCount', $beforeNow);
				$colTitles = array(_BSQ_AVERAGEHITSPERIP);
				break;	

			case 'keywordfreq':
				$result = $this->bsqCache->call('bsq_getKeywordFrequency', $order, $limit);
				$colTitles = $showCountAndPct ? array(_BSQ_KEYWORDS, _BSQ_COUNT) : array(_BSQ_KEYWORDS);
				break;
				
			case 'langfreq':
				$result = $this->bsqCache->call('bsq_getLanguageFrequency', $order, $limit);
				$colTitles = $showCountAndPct ? array(_BSQ_LANGUAGE, _BSQ_HITS, '%') : array(_BSQ_LANGUAGE);
				break;
				
			case 'platformfreq':
				$result = $this->bsqCache->call('bsq_getPlatformFrequency', $order, $limit, false);
				$colTitles = $showCountAndPct ? array(_BSQ_PLATFORM, _BSQ_COUNT, '%') : array(_BSQ_PLATFORM);
				break;
				
			case 'domainfreq':
				$result = $this->bsqCache->call('bsq_getDomainFrequency', $order, $limit);
				$colTitles = $showCountAndPct ? array(_BSQ_DOMAIN, _BSQ_COUNT, '%') : array(_BSQ_DOMAIN);
				break;
				
			case 'refererfreq':
				$result = $this->bsqCache->call('bsq_getRefererFrequency', $order, $limit, true);
				$result = $this->makeColumnIntoLinks($result, 0, 75);
				$colTitles = $showCountAndPct ? array(_BSQ_REFERER, _BSQ_COUNT, '%') : array(_BSQ_REFERER);
				break;
			
			case 'resourcefreq':
				$result = $this->bsqCache->call('bsq_getResourceFrequency', $order, $limit);
				$result = $this->makeColumnIntoLinks($result, 0, 75);
				$colTitles = $showCountAndPct ? array(_BSQ_RESOURCE, _BSQ_COUNT, '%') : array(_BSQ_RESOURCE);
				break;
				
			case 'browserfreq':
				$result = $this->bsqCache->call('bsq_getBrowserFrequency', $order, $limit);
				$colTitles = $showCountAndPct ? array(_BSQ_BROWSER, _BSQ_COUNT, '%') : array(_BSQ_BROWSER);
				break;
				
			case 'recentreferers':
				$result = $this->bsqCache->call('bsq_getLatestReferers', $limit, $dateFormat, true, 0);
				$colTitles = array(_BSQ_REFERER, _BSQ_RESOURCE, _BSQ_CLIENTIP, _BSQ_DATE);
				$result = $this->makeColumnIntoLinks($result, 0, 35, 1);
				$result = $this->makeColumnIntoLinks($result, 1, 35);
				break;
				
			case 'userfreq':
				$result = $this->bsqCache->call('bsq_getTopUserFrequency', 2, $order, $limit);
				$colTitles = array(_BSQ_USER, _BSQ_COUNT, '%');
				break;
						
			default:
				return "<p>Invalid report:<strong>$reportName</strong></p>\n";
		}
		
		if ($result === null || $result === false) {
			return "<p>Unknown error while executing <strong>$reportName</strong>.</p>\n";
		}
		
		$retStr = '';
		if (is_array($result)) {
			$retStr .= '<table class="'.$this->cssPrepend."reporttable\">\n";
			
			//Write out the header row
			$retStr .= '    <tr class="'.$this->cssPrepend."reportheaderrow\">\n";
			foreach ($colTitles as $colTitle) {
				$retStr .= '        <td class="'.$this->cssPrepend.'reportheadercol">'.$colTitle."</td>\n";
			}
			$retStr .= "    </tr>\n";
			
			if (!count($result)) {
				$numCols = count($colTitles);
				$retStr .= "    <tr>\n        <td colspan=\"$numCols\"><strong>"._BSQ_NOMATCHINGROWS."</strong></td>\n    </tr>\n";
			}
			else {
				//Treat it like a tabular
				foreach ($result as $key=>$value) {
					$retStr .= '    <tr class="'.$this->cssPrepend."reportrow\">\n";
					
					$rowCount = 0;
					//Iterate over each column
					foreach ($value as $colName=>$colValue) {
						$retStr .= '        <td class="'.$this->cssPrepend.'reportcol">'.$colValue."</td>\n";
						/* Don't write more data columns than we have headers for */
						$rowCount++;
						if($rowCount >= count($colTitles)) {
							break;
						}
					}
					$retStr .= "    </tr>\n";
				}
			}
			$retStr .= "</table>\n";
		}
		else {
			$retStr .= '<p class="'.$this->cssPrepend.'reportheader">'.$colTitles[0] .
			           ': <span class="'.$this->cssPrepend."reportvalue\">$result</span></p>";
		}
	return $retStr;
	} 
	
	/**
	 * Render a latest visitor report, which uses special formatting
	 *
	 * @param integer $limit Maximum rows to return
	 * @param string $dateFormat Date format to be passed to date()
	 * @param string $ipAddress Optional IP address to filder on
	 *
	 * Returns $rows to Render
	 */
	function showLatestVisitors($limit, $dateFormat, $ipAddress=false)
	{
		global $bsq_sitestats_showUsersAs;
		
		$result = $this->bsqCache->call('bsq_getLatestVisitors', $limit, 0, $dateFormat, $bsq_sitestats_showUsersAs, $ipAddress);
		if ($result === false) {
			return "<i>Could not generate latest visitor report</i>";
		}
		else if (!count($result)) {
			return _BSQ_NOMATCHINGROWS;
		}
		
		$result = $this->makeColumnIntoLinks($result, 1, 75, 0);
		
		$retStr = '';
		$prevIp = '';
		$prevUserName = '';
		
		foreach ($result as $key=>$row) {
			$ip = $row[0];
			$uri = $row[1];
			$agent = $row[2];
			$dateTime = $row[3];
			$userName = $row[4];
			
			if ($userName) {
				$userName = "$userName - ";
			}
			else {
				$userName = '';
			}
			
			
			
			if (($ip != $prevIp) || ($userName != $prevUserName)) {
				$displayIp = $this->getIpLookupLink($ip);
				$retStr .= "<strong>[$userName$displayIp - $agent - $dateTime]</strong><br />\n";
			}
			
			$retStr .= "$uri<br />\n";
			$prevIp = $ip;
			$prevUserName = $userName;
		}
		
		return $retStr;
	}
	
	/**
	 * Render a latest visitors report for a user, which uses special formatting
	 *
	 * @param integer userId
	 * @param integer Limit
	 * @param string Date format to be passed to date()
	 *
	 * Returns $rows to Render
	 */
	function showUsersLatestVisitors($userId, $limit, $dateFormat)
	{	
		$result = $this->bsqCache->call('bsq_getUsersLatestHits', $userId, $limit, 0, $dateFormat);
		if ($result === false) {
			return "<i>Could not generate latest visitor report</i>";
		}
		else if (!count($result)) {
			return _BSQ_NOMATCHINGROWS;
		}
		
		$result = $this->makeColumnIntoLinks($result, 1, 75, 0);
		
		$retStr = '';
		$prevIp = '';
		$prevUserName = '';
		
		foreach ($result as $key=>$row) {
			$ip = $row[0];
			$uri = $row[1];
			$agent = $row[2];
			$dateTime = $row[3];
			$userName = $row[4];
			
			if ($userName) {
				$userName = "$userName - ";
			}
			else {
				$userName = '';
			}
			
			if (($ip != $prevIp) || ($userName != $prevUserName)) {
				$retStr .= "<strong>[$userName$ip - $agent - $dateTime]</strong><br />\n";
			}
			
			$retStr .= "$uri<br />\n";
			$prevIp = $ip;
			$prevUserName = $userName;
		}
		
		return $retStr;
	}
	
	/**
	 * Get a hyperlink to an IP address's lookup page
	 *
	 * @param string $ip IP Address to lookup
	 *
	 * @return string HTML for the hyperlink
	 */
	function getIpLookupLink($ip)
	{
		//This is only allowed for the backend.
		if ($this->isFrontend) {
			return $ip;
		}
		
		return "<a target=\"_blank\" href=\"index2.php?option=com_bsq_sitestats&act=iplookup&ip=$ip\">$ip</a>";
	}
	
	/**
	 * Convert a column of a table to HTML links.
	 * 
	 * @param array $a1 Array from which to convert a column
	 * @param integer $colNum Column number to convert to a link
	 * @param integer $maxTextLen Maximum length of the hyperlink text left behind
	 * @param integer $urlToDomain Truncate URL column to a domain name 
	 *
	 * @return array Modified array where column $colNum is replaced.
	 *
	 */
	function makeColumnIntoLinks($a1, $colNum, $maxTextLen=10000, $urlToDomain=0)
	{
		global $mosConfig_live_site;
		
		$linkPrepend = '';
		
		for ($i = 0; $i < count($a1); $i++) {
			$row = $a1[$i];
			
			if (!isset($row[$colNum])) {
				continue;
			}
			
			$str = $row[$colNum];
			
			if (strpos($str, 'http://') !== 0) {
				$url = parse_url($mosConfig_live_site);
				$linkPrepend = $url['scheme'] .'://'. $url['host'];
			}
		
			if ($urlToDomain) {
				$url = parse_url($str);
				$refererText = $url['host'];
			}
			else {
				$refererText = $str;
			}
			
			$outStr = "<a target=\"_blank\" href=\"$linkPrepend$str\">".htmlentities(substr($refererText,0,$maxTextLen))."</a>";
			$a1[$i][$colNum] = $outStr;
		}	
		
		return $a1; //Pass by value, return by value
	}
	
	/**
	 * Render a single row of the site stats summary table.
	 * 
	 * @param string $rowName What to put in the first column for this row.
	 * @param string $cssPrepend What to prepend to the CSS class before renderering it.
	 * @param integer $ageSeconds Seconds old the hits should be (3600 = 1 hour)
	 *
	 * @return string HTML for the row.
	 */
	function sssRow($rowName, $cssPrepend, $ageSeconds)
	{
		global $bsq_sitestats_useDayBoundary;
	
		if ($ageSeconds) {
			if (!$bsq_sitestats_useDayBoundary) {
				//Old way. Just compute from NOW
				$since = BSQDateTime::Time() - $ageSeconds;
			}
			else {
				//This way is a little tricky. The ultimate goal is to round anything larger
				//than a day to an offset from a day boundary. This assumes that all parameters
				//are multiples of a day
				$ageSeconds -= 86400;
				
				$since = BSQDateTime::StartOfToday();
				$since -= $ageSeconds;
			}
			
		}
		else {
			$since = 0; //Default to the beginning of time
		}
		
		$hits = bsq_getHitCountSince($since);
		$visitors = bsq_getUniqueIPCountSince($since);
		
		$retStr = "    <tr class=\"".$cssPrepend."ssscom_row\">\n".
				  "        <td class=\"".$cssPrepend."ssscom_firstcol\"><b>$rowName</b></td>\n".
				  "        <td class=\"".$cssPrepend."ssscom_col\">$hits</td>\n".
				  "        <td class=\"".$cssPrepend."ssscom_col\">$visitors</td>\n".
				  "    </tr>\n";
		return $retStr;
	}
	
	/**
	 * Render a Site Stat Summary report. (Not cached)
	 *
	 */
	function sssRender($showTotal, $showToday, $showThisWeek, $showThisMonth, $showThisYear, $cssPrepend)
	{
		$retStr = '<table class="'.$cssPrepend."ssscom_table\">\n" .
		          "    <tr>\n".
		          "        <td colspan=\"3\" class=\"".$cssPrepend."ssscom_topheading\">"._BSQ_SITESTATSSUMMARY."</td>\n".
		          "    </tr>\n".
				  "    <tr class=\"".$cssPrepend."ssscom_heading_row\">\n".
		          "        <td>&nbsp;</td>\n".
		          "        <td class=\"".$cssPrepend."ssscom_heading_col\"><strong>"._BSQ_HITS."</strong></td>\n".
		          "        <td class=\"".$cssPrepend."ssscom_heading_col\"><strong>"._BSQ_VISITORS."</strong></td>\n".
		          "    </tr>\n";
		          
		if ($showTotal) {
			$retStr .= $this->sssRow(_BSQ_TOTAL, $cssPrepend, 0);
		}
		
		if ($showToday) {
			$retStr .= $this->sssRow(_BSQ_TODAY, $cssPrepend, 3600*24);
		}
		
		if ($showThisWeek) {
			$retStr .= $this->sssRow(_BSQ_WEEK, $cssPrepend, 3600*24*7);
		}
		
		if ($showThisMonth) {
			$retStr .= $this->sssRow(_BSQ_MONTH, $cssPrepend, 3600*24*7*4); //Assumes 28-day month
		}
		
		if ($showThisYear) {
			$retStr .= $this->sssRow(_BSQ_YEAR, $cssPrepend, 3600*24*365);
		}
		
		$retStr .= "</table>\n";
		
		return $retStr;
	}
	
	/**
	 * Render an image with the proper wrapper
	 *
	 * @param string $webPath HTTP path to the image to pass back to the browser
	 * @param integer $width Width of the image
	 * @param integer $height Height of the image
	 *
	 * @return string Properly formatted image
	 */
	function renderImage($webPath, $width, $height)
	{
		$retStr = "\n";		
		$retStr .= '<a href="http://www.bs-squared.com/mambo/index.php" target="_blank">';
		$retStr .= "<img border=\"0\" width=\"$width\" height=\"$height\" src=\"$webPath\"></a>\n";
		return $retStr;
	}
	
	/**
	 * Render a line graph of site visitors
	 *
	 * @param integer $width Width of the image to be rendered
	 * @param integer $height Height of the image to be rendered
	 * @param integer $cacheTime Amount of time to cache this image
	 * @param string $interval String constant of the interval you want to graph.
	 *
	 * @return String to write to the screen
	 */
	function visitorsLineGraph($width, $height, $cacheTime, $interval)
	{
		global $bsqTimeIntervals, $bsq_sitestats_useJpGraph, $bsq_sitestats_graphDateFormat, $bsq_sitestats_graphTimeFormat;
		
		$numPoints = 50;
		$tickInterval = 5;
		
		if (!$bsq_sitestats_useJpGraph) {
			return '<strong>'._BSQ_MUSTENABLEGRAPH.'</strong>';
		}
		
		if (!$bsqTimeIntervals[$interval]) {
			return "<strong>Invalid interval $interval</strong>";
		}
		
		$secPerTick = $bsqTimeIntervals[$interval][1];
		$tickInterval = 5;
		
		$title = _BSQ_HITSPER.' '.$bsqTimeIntervals[$interval][0];
		$uniqueKey = 'graphhitsper'.$interval;
		
		$bsqGraph = new BSQGraphLine();
		$result = $bsqGraph->init($width, $height, $cacheTime, $title, $uniqueKey);
		if (is_string($result)) {
			return $this->renderImage($result, $width, $height);
		}
		else if (!$result) {
			return '<strong>BSQGraph->init() failed from renderer->visitorsLineGraph()</strong>';
		}
		else {
			$timeFormat = $secPerTick < 86400 ? $bsq_sitestats_graphTimeFormat : $bsq_sitestats_graphDateFormat;
			$points = bsq_getVisitorsChart($secPerTick, $numPoints, $timeFormat);
			
			if(!count($points) || count($points[0]) < 2) {
				/* Nothing to report */
				$bsqGraph->abort();
				return sprintf('<h2>'._BSQ_NOTENOUGHFORLINECHART."</h2>\n", $bsqTimeIntervals[$interval][0]);
			}
			
			/* $bsqGraph->setYAxis(_BSQ_HITS); //TODO: Make this fit */
			$bsqGraph->setXAxis($points[0], $tickInterval);
			$bsqGraph->addDataset($points[1], '');
			$result = $bsqGraph->flush();
			if (!$result) {
				return '<strong>BSQGraph->flush() failed from renderer->visitorsLineGraph()</strong>';
			}
			else if (is_string($result)) {
				return $this->renderImage($result, $width, $height);
			}
		}
	}
}