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

require_once( $mainframe->getPath( 'admin_html' ) );
	
require_once($mosConfig_absolute_path . '/administrator/components/com_bsq_sitestats/bsqglobals.inc.php');



require_once($bsqAdminPath . '/admin.bsq_sitestats.class.php');
$BSQSitestatsCFG = new BSQSitestatsCFG();

require_once($bsqClassPath.'/bsqstatcompress.class.php');
require_once($bsqClassPath.'/bsqip2country.php');
require_once($bsqClassPath.'/bsqtabbedreport.class.php');

switch($act) 
{
	case "config":
		if($task=='saveedit') 
		{
			foreach ($_POST as $k=>$v) {
				if($k !='act' AND $k !='option' AND $k !='conf' AND $k !='task') {
					$$k=$v;
				}
			}
			$BSQSitestatsCFG->SetCfg( 'trackHits', $bsq_sitestats_trackHits );
			$BSQSitestatsCFG->SetCfg( 'debugQueries', $bsq_sitestats_debugQueries );
			$BSQSitestatsCFG->SetCfg( 'doIpToCountry' , $bsq_sitestats_doIpToCountry );
			$BSQSitestatsCFG->SetCfg( 'doKeywordSniffing', $bsq_sitestats_doKeywordSniffing);
			
			$BSQSitestatsCFG->SetCfg( 'rowsPerCompress', $bsq_sitestats_rowsPerCompress);
			$BSQSitestatsCFG->SetCfg( 'hoursBeforeCompress', $bsq_sitestats_hoursBeforeCompress);
			
			$BSQSitestatsCFG->SetCfg( 'cacheTime', $bsq_sitestats_cacheTime);
		    $BSQSitestatsCFG->SetCfg( 'rowLimit', $bsq_sitestats_rowLimit);
		    $BSQSitestatsCFG->SetCfg( 'cssPrepend', $bsq_sitestats_cssPrepend);
		    $BSQSitestatsCFG->SetCfg( 'dateFormat', $bsq_sitestats_dateFormat);
		    $BSQSitestatsCFG->SetCfg( 'useInternalCSS', $bsq_sitestats_useInternalCSS);
		    $BSQSitestatsCFG->SetCfg( 'useDayBoundary', $bsq_sitestats_useDayBoundary);
		    $BSQSitestatsCFG->SetCfg( 'reportHoursOffset',  $bsq_sitestats_reportHoursOffset);
		    $BSQSitestatsCFG->SetCfg( 'showUsersAs', $bsq_sitestats_showUsersAs);
		    
		    $BSQSitestatsCFG->SetCfg( 'useJpGraph', $bsq_sitestats_useJpGraph);
		    $BSQSitestatsCFG->SetCfg( 'graphTimeFormat', $bsq_sitestats_graphTimeFormat);
			$BSQSitestatsCFG->SetCfg( 'graphDateFormat', $bsq_sitestats_graphDateFormat);
			$BSQSitestatsCFG->SetCfg( 'graphWidth', $bsq_sitestats_graphWidth);
		    $BSQSitestatsCFG->SetCfg( 'graphHeight', $bsq_sitestats_graphHeight);
		    $BSQSitestatsCFG->SetCfg( 'graphForComponent', $bsq_sitestats_graphForComponent);
		    $BSQSitestatsCFG->SetCfg( 'graphCacheTime', $bsq_sitestats_graphCacheTime);
		    $BSQSitestatsCFG->SetCfg( 'visitorsGraphInterval', $bsq_sitestats_visitorsGraphInterval);
		    $BSQSitestatsCFG->SetCfg( 'barChartValueColor', $bsq_sitestats_barChartValueColor);
		    $BSQSitestatsCFG->SetCfg( 'barChartFillColor', $bsq_sitestats_barChartFillColor);
		    
		    $BSQSitestatsCFG->SetCfg( 'feshowSSSummary', $bsq_sitestats_feshowSSSummary);
			$BSQSitestatsCFG->SetCfg( 'feshowVisitorGraph', $bsq_sitestats_feshowVisitorGraph);
			$BSQSitestatsCFG->SetCfg( 'feshowLatestVisitors', $bsq_sitestats_feshowLatestVisitors);
			$BSQSitestatsCFG->SetCfg( 'feshowUserFreq', $bsq_sitestats_feshowUserFreq);
			$BSQSitestatsCFG->SetCfg( 'feshowResourceFreq', $bsq_sitestats_feshowResourceFreq);
			$BSQSitestatsCFG->SetCfg( 'feshowBrowserFreq', $bsq_sitestats_feshowBrowserFreq);
			$BSQSitestatsCFG->SetCfg( 'feshowRecentReferers', $bsq_sitestats_feshowRecentReferers);
			$BSQSitestatsCFG->SetCfg( 'feshowRefererFreq', $bsq_sitestats_feshowRefererFreq);
			$BSQSitestatsCFG->SetCfg( 'feshowDomainFreq', $bsq_sitestats_feshowDomainFreq);
			$BSQSitestatsCFG->SetCfg( 'feshowLanguageFreq', $bsq_sitestats_feshowLanguageFreq);
			$BSQSitestatsCFG->SetCfg( 'feshowKeywordFreq', $bsq_sitestats_feshowKeywordFreq);
		    
			$BSQSitestatsCFG->SaveConfiguration();
		}
		
		BSQSitestatsHTML::ShowConfiguration( $option, $BSQSitestatsCFG );
		break;
	
	case "showstats":
		BSQSitestatsHTML::ShowStats($option, $BSQSitestatsCFG);
		break;
		
	case "help":
		BSQSitestatsHTML::ShowHelp( $option, $BSQSitestatsCFG );
		break;
	
	case "compress":
		BSQSitestatsHTML::CompressStats($option, $BSQSitestatsCFG);	
		break;
		
	case "doiptocountry":
		BSQSitestatsHTML::ConvertIPsToCountries($option, $BSQSitestatsCFG);
		break;
		
	case "recreateiptocountry":
		BSQSitestatsHTML::ImportCountries($option, $BSQSitestatsCFG);
		break;

	case "iplookup":
		BSQSitestatsHTML::IpLookup($option);
		break;
		
	default:
		BSQSitestatsHTML::ShowWelcome( $option, $BSQSitestatsCFG );
		break;
}

