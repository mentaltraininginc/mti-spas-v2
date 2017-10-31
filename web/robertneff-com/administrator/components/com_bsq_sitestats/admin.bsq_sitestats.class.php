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
* Configuration management class.
*
* @package bsq_sitestats
* @copyright Brent Stolle (c) 2005
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author  Brent Stolle
*/

require_once('bsqglobals.inc.php');

class BSQSitestatsCFG
{
	/** @var config Configuration of the map */
	var $_config=null;

	/**
	 * Standard constructor
	 */
	function BSQSitestatsCFG() 
	{
		$this->LoadConfiguration();
	}
	
	/**
	* Loads the configuration.php file and assigns values to the internal variable
	*/
	function LoadConfiguration() 
	{
		global $bsqAdminPath;
		
		$this->_config = new stdClass();
		require($bsqAdminPath . '/config.bsq_sitestats.php');
		$this->_config->trackHits = $bsq_sitestats_trackHits;
		$this->_config->doKeywordSniffing = $bsq_sitestats_doKeywordSniffing;
		$this->_config->debugQueries = $bsq_sitestats_debugQueries;
		$this->_config->doIpToCountry = $bsq_sitestats_doIpToCountry;
		
		$this->_config->hoursBeforeCompress = $bsq_sitestats_hoursBeforeCompress;
		$this->_config->rowsPerCompress = $bsq_sitestats_rowsPerCompress;
		
		$this->_config->cacheTime = $bsq_sitestats_cacheTime;
		$this->_config->rowLimit = $bsq_sitestats_rowLimit;
		$this->_config->cssPrepend = $bsq_sitestats_cssPrepend;
		$this->_config->dateFormat = $bsq_sitestats_dateFormat;
		$this->_config->useInternalCSS = $bsq_sitestats_useInternalCSS;
		$this->_config->useDayBoundary = $bsq_sitestats_useDayBoundary;
		$this->_config->reportHoursOffset = $bsq_sitestats_reportHoursOffset;
		$this->_config->showUsersAs = $bsq_sitestats_showUsersAs;
		
		$this->_config->useJpGraph = $bsq_sitestats_useJpGraph;
		$this->_config->graphTimeFormat = $bsq_sitestats_graphTimeFormat;
		$this->_config->graphDateFormat = $bsq_sitestats_graphDateFormat;
		$this->_config->graphWidth = $bsq_sitestats_graphWidth;
		$this->_config->graphHeight = $bsq_sitestats_graphHeight;
		$this->_config->graphForComponent = $bsq_sitestats_graphForComponent;
		$this->_config->graphCacheTime = $bsq_sitestats_graphCacheTime;
		$this->_config->visitorsGraphInterval = $bsq_sitestats_visitorsGraphInterval;
		$this->_config->barChartValueColor = $bsq_sitestats_barChartValueColor;
		$this->_config->barChartFillColor = $bsq_sitestats_barChartFillColor;
		
		$this->_config->feshowSSSummary = $bsq_sitestats_feshowSSSummary;
		$this->_config->feshowVisitorGraph = $bsq_sitestats_feshowVisitorGraph;
		$this->_config->feshowLatestVisitors = $bsq_sitestats_feshowLatestVisitors;
		$this->_config->feshowUserFreq = $bsq_sitestats_feshowUserFreq;
		$this->_config->feshowResourceFreq = $bsq_sitestats_feshowResourceFreq;
		$this->_config->feshowBrowserFreq = $bsq_sitestats_feshowBrowserFreq;
		$this->_config->feshowRecentReferers = $bsq_sitestats_feshowRecentReferers;
		$this->_config->feshowRefererFreq = $bsq_sitestats_feshowRefererFreq;
		$this->_config->feshowDomainFreq = $bsq_sitestats_feshowDomainFreq;
		$this->_config->feshowLanguageFreq = $bsq_sitestats_feshowLanguageFreq;
		$this->_config->feshowKeywordFreq = $bsq_sitestats_feshowKeywordFreq;
	}

	/**
	* @param string The name of the variable (from configuration.php)
	* @return mixed The value of the configuration variable or null if not found
	*/
	function GetCfg( $varname ) 
	{
		if (isset( $this->_config->$varname )) 
			return $this->_config->$varname;
		else
			return null;
	}
	
	/**
	* @param string The name of the variable (from configuration.php)
	* @param mixed The value of the configuration variable
	*/
	function SetCfg( $varname, $newValue ) 
	{
		if (isset( $this->_config->$varname ))
			$this->_config->$varname = $newValue;
	}

	function SaveConfiguration () 
	{
		global $option, $bsqAdminPath;
		
		$configfile = $bsqAdminPath . '/config.bsq_sitestats.php';
		@chmod ($configfile, 0766);
		$permission = is_writable($configfile);
		if (!$permission) {
			$mosmsg = _BSQ_CFGNOTWRITEABLE;
			mosRedirect("index2.php?option=$option&act=config",$mosmsg);
			break;
		}
		
		$config = "<?php\n";
		
		//trackHits
		$config .= "/** @var trackHits Flag that says whether or not we should track hits at all. Set to no to disable hit tracking. */\n";
		$config .= '$bsq_sitestats_trackHits = ' . $this->_config->trackHits . ";\n";
		
		//debugQueries
		$config .= "/** @var debugQueries Flag that says if we should write queries to output instead of to the database */\n";
		$config .= '$bsq_sitestats_debugQueries = ' . $this->_config->debugQueries . ";\n";
		
		//doIpToCountry
		$config .= "/** @var doIpToCountry Flag that says if we should convert IP addressed to countries (one extra SQL query per hit) */\n";
		$config .= '$bsq_sitestats_doIpToCountry = ' .$this->_config->doIpToCountry. ";\n";
		
		//doKeywordSniffing
		$config .= "/** @var doKeywordSniffing Flag that says if we should sniff keywords or not (2 extra SQL queries per hit) */\n";
		$config .= '$bsq_sitestats_doKeywordSniffing = ' . $this->_config->doKeywordSniffing . ";\n";
		
		//hoursBeforeCompress
		$config .= "/** @var hoursBeforeCompress Integer of how many hours before we compress stats. */\n";
		$config .= '$bsq_sitestats_hoursBeforeCompress = ' . $this->_config->hoursBeforeCompress . ";\n";
		
		//rowsPerCompress
		$config .= "/** @var rowsPerCompress Integer that says how many rows we should compress pre compression. */\n";
		$config .= '$bsq_sitestats_rowsPerCompress = ' . $this->_config->rowsPerCompress . ";\n";
		
		//cacheTime
		$config .= "/** @var cacheTime Integer that says how many seconds component reports should be cached for. */\n";
		$config .= '$bsq_sitestats_cacheTime = ' . $this->_config->cacheTime . ";\n";
		
		//rowLimit
		$config .= "/** @var rowLimit Integer that says how many rows to show on each component report's tab. */\n";
		$config .= '$bsq_sitestats_rowLimit = ' . $this->_config->rowLimit . ";\n";
		
		//cssPrepend
		$config .= "/** @var cssPrepend String that says what we should prepend each class with */\n";
		$config .= '$bsq_sitestats_cssPrepend = \'' . $this->_config->cssPrepend . "';\n";
		
		//dateFormat
		$config .= "/** @var dateFormat String that dictates how to format dates in date() format. */\n";
		$config .= '$bsq_sitestats_dateFormat = \'' . $this->_config->dateFormat . "';\n";
		
		//useInternalCSS
		$config .= "/** @var useInternalCSS Boolean as to whether or not we should include bsq_sitestats's native CSS */\n";
		$config .= '$bsq_sitestats_useInternalCSS = ' . $this->_config->useInternalCSS . ";\n";
		
		//userDayBoundary
		$config .= "/** @var useDayBoundary Boolean as to if our periodic stats should line up with day boundaries */\n";
		$config .= '$bsq_sitestats_useDayBoundary = ' . $this->_config->useDayBoundary . ";\n";
		
		//reportHoursOffset
		$config .= "/** @var reportHoursOffset Integer. Number of hours to offset reporting from server time. */\n";
		$config .= '$bsq_sitestats_reportHoursOffset = ' . $this->_config->reportHoursOffset . ";\n";
		
		//showUsersAs
		$config .= "/** @var showUsersAs Integer. Format to show users in on reports. */\n";
		$config .= '$bsq_sitestats_showUsersAs = ' . $this->_config->showUsersAs . ";\n";
		
		//useJpGraph
		$config .= "/** @var useJpGraph Integer. Should we use the JpGraph component. If this is false, graphing will be disabled. */\n";
		$config .= '$bsq_sitestats_useJpGraph = ' . $this->_config->useJpGraph . ";\n";
		
		//graphTimeFormat
		$config .= "/** @var graphTimeFormat String. How to format time strings when being displayed on a graph */\n";
		$config .= '$bsq_sitestats_graphTimeFormat = \'' . $this->_config->graphTimeFormat . "';\n";
		
		//graphDateFormat
		$config .= "/** @var graphDateFormat String. How to format date strings when being displayed on a graph */\n";
		$config .= '$bsq_sitestats_graphDateFormat = \'' . $this->_config->graphDateFormat . "';\n";
		
		//graphWidth
		$config .= "/** @var graphWidth Width of the graphs to be generated with JPGraph. */\n";
		$config .= '$bsq_sitestats_graphWidth = ' . $this->_config->graphWidth . ";\n";
		
		//graphHeight
		$config .= "/** @var graphHeight Height of the graphs to be generated with JPGraph. */\n";
		$config .= '$bsq_sitestats_graphHeight = ' . $this->_config->graphHeight . ";\n";
		
		//graphForComponent
		$config .= "/** @var graphForComponent Should we display graphs for reports in our component that support them? */\n";
		$config .= '$bsq_sitestats_graphForComponent = ' . $this->_config->graphForComponent . ";\n";
		
		//graphCacheTime
		$config .= "/** @var graphCacheTime How long should we cache graphs for? */\n";
		$config .= '$bsq_sitestats_graphCacheTime = ' . $this->_config->graphCacheTime . ";\n";
		
		//visitorsGraphInterval
		$config .= "/** @var visitorsGraphInterval What should be the tick interval for visitors graphs in the component. */\n";
		$config .= '$bsq_sitestats_visitorsGraphInterval = \'' . $this->_config->visitorsGraphInterval . "';\n";
		
		//barChartValueColor
		$config .= "/** @var barChartValueColor Color of the value to the right of bars on a bar chart. */\n";
		$config .= '$bsq_sitestats_barChartValueColor = \'' . $this->_config->barChartValueColor . "';\n";
		
		//barChartFillColor
		$config .= "/** @var barChartFillColor Color of the bars on a bar chart. */\n";
		$config .= '$bsq_sitestats_barChartFillColor = \'' . $this->_config->barChartFillColor . "';\n";
		
		//feshowSSSummary
		$config .= "/** @var feshowSSSummary Show the SSSummary report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowSSSummary = ' . $this->_config->feshowSSSummary . ";\n";
		
		//feshowVisitorGraph
		$config .= "/** @var feshowVisitorGraph Show the Visitor Graph on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowVisitorGraph = ' . $this->_config->feshowVisitorGraph . ";\n";
		
		//feshowLatestVisitors
		$config .= "/** @var feshowLatestVisitors Show the Latest Visitors on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowLatestVisitors = ' . $this->_config->feshowLatestVisitors . ";\n";
		
		//feshowUserFreq
		$config .= "/** @var feshowUserFreq Show the User Frequencies report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowUserFreq = ' . $this->_config->feshowUserFreq . ";\n";
		
		//feshowResourceFreq
		$config .= "/** @var feshowResourceFreq Show the Resource Frequency report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowResourceFreq = ' . $this->_config->feshowResourceFreq . ";\n";
		
		//feshowBrowserFreq
		$config .= "/** @var feshowBrowserFreq Show the Browser Frequency report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowBrowserFreq = ' . $this->_config->feshowBrowserFreq . ";\n";
		
		//feshowRecentReferers
		$config .= "/** @var feshowRecentReferers Show the Recent Referers report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowRecentReferers = ' . $this->_config->feshowRecentReferers . ";\n";
		
		//feshowRefererFreq
		$config .= "/** @var feshowRefererFreq Show the Referer Freqeuncy report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowRefererFreq = ' . $this->_config->feshowRefererFreq . ";\n";
		
		//feshowDomainFreq
		$config .= "/** @var feshowDomainFreq Show the Domain Freq report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowDomainFreq = ' . $this->_config->feshowDomainFreq . ";\n";
		
		//feshowLanguageFreq
		$config .= "/** @var feshowLanguageFreq Show the Language Frequency report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowLanguageFreq = ' . $this->_config->feshowLanguageFreq . ";\n";
		
		//feshowKeywordFreq
		$config .= "/** @var feshowKeywordFreq Show the Keyword Frequency report on the Front End? */\n";
		$config .= '$bsq_sitestats_feshowKeywordFreq = ' . $this->_config->feshowKeywordFreq . ";\n";
		
		//END
		$config .= "?>";
		
		if ($fp = fopen("$configfile", "w")) 
		{
			fputs($fp, $config, strlen($config));
			fclose ($fp);
		}
		$this->LoadConfiguration();
		mosRedirect("index2.php?option=$option&act=config", _BSQ_SETTINGSSAVED);
	}

	/**
	 * Version String
	 */
	function GetVersion() 
	{
		global $bsqVersion;
		
		return $bsqVersion;
	}
}
?>