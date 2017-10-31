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
* BSQTabbedReport Class
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle <dev@bs-squared.com>
*
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

require_once($mosConfig_absolute_path . '/administrator/components/com_bsq_sitestats/bsqglobals.inc.php');

//Load library classes
require_once($bsqClassPath . '/bsqcache.class.php');
require_once($bsqClassPath . '/bsqsitestatsrender.php');

if ($bsq_sitestats_useJpGraph) {
	require_once($bsqClassPath . '/bsqgraph.class.php');
}

class BSQTabbedReport
{
	/**
	 * Show the bsq_sitestats tabbed report
	 *
	 */	
	function show($renderer, $order, $limit, $howDisplay, $beforeNow, $duration, $dateFormat, $cssPrepend, $isFrontend=true)
	{
		global $bsq_sitestats_cacheTime, $bsq_sitestats_useJpGraph, $bsq_sitestats_graphWidth, $bsq_sitestats_graphHeight, 
		       $bsq_sitestats_graphForComponent, $bsq_sitestats_graphCacheTime, $bsq_sitestats_visitorsGraphInterval, 
		       $bsq_sitestats_barChartValueColor, $bsq_sitestats_barChartFillColor,
		       $bsq_sitestats_feshowSSSummary, $bsq_sitestats_feshowVisitorGraph, $bsq_sitestats_feshowLatestVisitors,
		       $bsq_sitestats_feshowUserFreq,
               $bsq_sitestats_feshowResourceFreq, $bsq_sitestats_feshowBrowserFreq, $bsq_sitestats_feshowRecentReferers,
			   $bsq_sitestats_feshowRefererFreq, $bsq_sitestats_feshowDomainFreq, $bsq_sitestats_feshowLanguageFreq,
			   $bsq_sitestats_feshowKeywordFreq;

		if ($isFrontend && !$bsq_sitestats_feshowSSSummary && !$bsq_sitestats_feshowVisitorGraph && !$bsq_sitestats_feshowLatestVisitors
		    && !$bsq_sitestats_feshowUserFreq
            && !$bsq_sitestats_feshowResourceFreq && !$bsq_sitestats_feshowBrowserFreq && !$bsq_sitestats_feshowRecentReferers
			&& !$bsq_sitestats_feshowRefererFreq && !$bsq_sitestats_feshowDomainFreq && !$bsq_sitestats_feshowLanguageFreq
			&& !$bsq_sitestats_feshowKeywordFreq) {
			echo _BSQ_ALLREPORTSDISABLED;
			return;	
		}
			    
		$tabs = new mosTabs(1);
		$tabs->startPane('bsq_sitestats');
		
		/* Summary tab */
		if (!$isFrontend || $bsq_sitestats_feshowSSSummary || $bsq_sitestats_feshowVisitorGraph || $bsq_sitestats_feshowLatestVisitors) {
			$tabs->startTab(_BSQ_SUMMARY, 'bsq_summary');
			
			/* Site Stats Summary */
			if (!$isFrontend || $bsq_sitestats_feshowSSSummary) {
				echo $renderer->sssRender(1, 1, 1, 1, 1, $cssPrepend);
			}
			
			/* Visitor Graph */
			if ((!$isFrontend || $bsq_sitestats_feshowVisitorGraph) && $bsq_sitestats_useJpGraph && $bsq_sitestats_graphForComponent) {
				echo '<p>'.$renderer->visitorsLineGraph($bsq_sitestats_graphWidth, $bsq_sitestats_graphHeight, 
				                                        $bsq_sitestats_cacheTime, $bsq_sitestats_visitorsGraphInterval).'</p>';
			}
			
			/* Latest Visitors */
			if(!$isFrontend || $bsq_sitestats_feshowLatestVisitors) {
				echo BSQTabbedReport::makeReportTitle(_BSQ_LATESTVISITORS, $cssPrepend);
				echo $renderer->showLatestVisitors(100, $dateFormat);
			}
			
			$tabs->endTab();
		}
		
		/* Users Tab */
		if (!$isFrontend || $bsq_sitestats_feshowUserFreq) {
			$tabs->startTab(_BSQ_USERS, 'bsq_users');
			echo BSQTabbedReport::makeReportTitle(_BSQ_USERFREQ, $cssPrepend);
			if ($bsq_sitestats_useJpGraph && $bsq_sitestats_graphForComponent) {
				echo $renderer->showBarGraph('userfreq', $order, $limit, $bsq_sitestats_graphWidth, $bsq_sitestats_graphHeight, 
				                             $bsq_sitestats_graphCacheTime, $bsq_sitestats_barChartValueColor, $bsq_sitestats_barChartFillColor);
			}
			else {
				echo $renderer->showTabularReport('userfreq', $order, $limit, $beforeNow, $duration, $dateFormat);
			}
			$tabs->endTab();
		}
		
		/* Resources tab */
		if (!$isFrontend || $bsq_sitestats_feshowResourceFreq) {
			$tabs->startTab(_BSQ_RESOURCES, 'bsq_resources');
			echo BSQTabbedReport::makeReportTitle(_BSQ_RESOURCEFREQ, $cssPrepend);
			echo $renderer->showTabularReport('resourcefreq', $order, $limit, $beforeNow, $duration, $dateFormat);
			$tabs->endTab();
		}
			
		/* Browsers tab */
		if (!$isFrontend || $bsq_sitestats_feshowBrowserFreq) {	
			$tabs->startTab(_BSQ_BROWSERS, 'bsq_browsers');
			echo BSQTabbedReport::makeReportTitle(_BSQ_BROWSERFREQ, $cssPrepend);
			
			if ($bsq_sitestats_useJpGraph && $bsq_sitestats_graphForComponent) {
				echo $renderer->showBarGraph('browserfreq', $order, $limit, $bsq_sitestats_graphWidth, $bsq_sitestats_graphHeight, 
				                             $bsq_sitestats_graphCacheTime, $bsq_sitestats_barChartValueColor, $bsq_sitestats_barChartFillColor);
			}
			else {
				echo $renderer->showTabularReport('browserfreq', $order, $limit, $beforeNow, $duration, $dateFormat);
			}
			$tabs->endTab();
		}
		
		/* Referer tab */
		if (!$isFrontend || $bsq_sitestats_feshowRecentReferers || $bsq_sitestats_feshowRefererFreq) {
			$tabs->startTab(_BSQ_REFERERS, 'bsq_referers');
			
			if (!$isFrontend || $bsq_sitestats_feshowRecentReferers) {
				echo BSQTabbedReport::makeReportTitle(_BSQ_RECENTREFERERS, $cssPrepend);
				echo $renderer->showTabularReport('recentreferers', $order, $limit, $beforeNow, $duration, $dateFormat);
			}
			
			if (!$isFrontend || $bsq_sitestats_feshowRefererFreq) {
				echo BSQTabbedReport::makeReportTitle(_BSQ_REFERERFREQ, $cssPrepend);
				echo $renderer->showTabularReport('refererfreq', $order, $limit, $beforeNow, $duration, $dateFormat);
			}
			
			$tabs->endTab();
		}
		
		/* Domain tab */
		if (!$isFrontend || $bsq_sitestats_feshowDomainFreq) {
			$tabs->startTab(_BSQ_DOMAINS, 'bsq_domains');
			echo BSQTabbedReport::makeReportTitle(_BSQ_DOMAINFREQ, $cssPrepend);
			if ($bsq_sitestats_useJpGraph && $bsq_sitestats_graphForComponent) {
				echo $renderer->showBarGraph('domainfreq', $order, $limit, $bsq_sitestats_graphWidth, $bsq_sitestats_graphHeight, 
				                             $bsq_sitestats_graphCacheTime, $bsq_sitestats_barChartValueColor, $bsq_sitestats_barChartFillColor);
			}
			else {
				echo $renderer->showTabularReport('domainfreq', $order, $limit, $beforeNow, $duration, $dateFormat);
			}
			$tabs->endTab();
		}
		
		/* Languages tab */
		if (!$isFrontend || $bsq_sitestats_feshowLanguageFreq) {
			$tabs->startTab(_BSQ_LANGUAGES, 'bsq_languages');
			echo BSQTabbedReport::makeReportTitle(_BSQ_LANGUAGEFREQ, $cssPrepend);
			if ($bsq_sitestats_useJpGraph && $bsq_sitestats_graphForComponent) {
				echo $renderer->showBarGraph('langfreq', $order, $limit, $bsq_sitestats_graphWidth, $bsq_sitestats_graphHeight, 
				                             $bsq_sitestats_graphCacheTime, $bsq_sitestats_barChartValueColor, $bsq_sitestats_barChartFillColor);
			}
			else {
				echo $renderer->showTabularReport('langfreq', $order, $limit, $beforeNow, $duration, $dateFormat);
			}
			$tabs->endTab();
		}
		
		/* Keywords tab */
		if (!$isFrontend || $bsq_sitestats_feshowKeywordFreq) {
			$tabs->startTab(_BSQ_KEYWORDS, 'bsq_keywords');
			echo BSQTabbedReport::makeReportTitle(_BSQ_KEYWORDFREQ, $cssPrepend);
			echo $renderer->showTabularReport('keywordfreq', $order, $limit, $beforeNow, $duration, $dateFormat);
			$tabs->endTab();
		}
		
		$tabs->endPane();
	}
	
	
	/**
	 * Make a report title for the component
	 *
	 */
	function makeReportTitle($title, $cssPrepend)
	{
		return '<h1 class="'.$cssPrepend."reportheading\">$title</h1>\n";
	}
}

?>