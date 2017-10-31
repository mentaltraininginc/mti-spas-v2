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

require_once($mosConfig_absolute_path . '/administrator/components/com_bsq_sitestats/bsqglobals.inc.php');

//Load library classes
require_once($bsqClassPath.'/bsqcache.class.php');
require_once($bsqClassPath.'/bsqsitestatsrender.php');	
require_once($bsqClassPath.'/bsqtabbedreport.class.php');
require_once($bsqClassPath.'/bsqip2city.class.php');

class BSQSitestatsHTML
{		
	function ShowWelcome( $option ) 
	{
		global $act, $task;
    	
		echo _BSQ_SHOWWELCOME;	
  	}
  	
  	/**
  	 * Writes a row of the configuration table to the output
  	 *
  	 * @param string $shortDesc Short description of the config parameter.
  	 * @param string $inputHtml HTML code for the input field
  	 * @param string $longDesc Long description of config parameter.
  	 */
  	function ConfigurationRow($shortDesc, $inputHtml, $longDesc)
  	{
  		echo  '<tr align="center" valign="middle">
			     <td width="130" align="left" valign="top"><strong>'.$shortDesc.'</strong></td>
			      <td width="80" align="left" valign="top">'.$inputHtml.'</td>
			  	  <td align="left">'.$longDesc.'</td>
		       </tr>
		       ';
  	}
  	
  	/**
  	 * Show the configuration table
  	 *
  	 */
	function ShowConfiguration( $option) 
	{
		global $act, $task, $BSQSitestatsCFG, $bsqTimeIntervals;
		
		$yesno[] = mosHTML::makeOption( '1', _BSQ_YES);
	    $yesno[] = mosHTML::makeOption( '0', _BSQ_NO);
	?>
	    <script language="javascript" type="text/javascript">
	    function submitbutton(pressbutton) 
	    {
	    	var form = document.adminForm;
	      	if (pressbutton == 'cancel') 
	      	{
	        	submitform( pressbutton );
	        	return;
	      	} 
	      	else 
	      	{
	        	submitform( pressbutton );
	      	}
	    }
	    </script>
		
	  	<form action="index2.php" method="post" name="adminForm" id="adminForm">
	  	<h1>BSQ Sitestats</h1>
	  	
		<?php    
	  	
		$tabs = new mosTabs(1);		
		$tabs->startPane('bsq_sitestats_cfg');
		
		
		$tabs->startTab(_BSQ_HITTRACKING, 'bsq_hittracking');
		echo '<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">'."\n";
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_trackHits', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'trackHits' ) ); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_TRACKHITS, $frmField, _BSQ_TRACKHITSDESC);
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_doKeywordSniffing', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'doKeywordSniffing' ) ); 		
		BSQSitestatsHTML::ConfigurationRow(_BSQ_DOKEYWORDSNIFF, $frmField, _BSQ_DOKEYWORDSNIFFDESC);
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_debugQueries', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'debugQueries' ) ); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_DEBUGQUERIES, $frmField, _BSQ_DEBUGQUERIESDESC);
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_doIpToCountry', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'doIpToCountry' ) ); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_IPTOCOUNTRY, $frmField, _BSQ_IPTOCOUNTRYDESC);
		
		echo "</table>\n";
		$tabs->endTab();
		
		
		
		
		
		
		$tabs->startTab(_BSQ_REPORTING, 'bsq_reporting');
		echo '<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">'."\n";
		
		$frmField = '<input type="text" name="bsq_sitestats_cacheTime" maxlength="5" size="5" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('cacheTime').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_CACHETIME, $frmField, _BSQ_CACHETIMEDESC);
    	
	    $frmField = '<input type="text" name="bsq_sitestats_rowLimit" maxlength="5" size="5" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg( 'rowLimit').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_ROWSPERREPORT, $frmField, _BSQ_ROWSPERREPORTDESC);
	    
	    $frmField = '<input type="text" name="bsq_sitestats_cssPrepend" maxlength="5" size="5" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg( 'cssPrepend').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_CSSPREPEND, $frmField, _BSQ_CSSPREPENDDESC);
	    
	    $frmField = '<input type="text" name="bsq_sitestats_dateFormat" maxlength="10" size="10" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('dateFormat').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_DATEFORMAT, $frmField, _BSQ_DATEFORMATDESC);
	    
	    $frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_useInternalCSS', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'useInternalCSS' ) ); ;
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_USEINTERNALCSS, $frmField, _BSQ_USEINTERNALCSSDESC);
	    
	    $frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_useDayBoundary', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'useDayBoundary' ) ); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_USEDAYBOUNDARY, $frmField, _BSQ_USEDAYBOUNDARYDESC);
		
		
		for($i = -23; $i < 24; $i++) {
			$hoursOffset[] = mosHTML::makeOption("$i", "$i ". _BSQ_HOURS);	
		}
		
    	$frmField = mosHTML::selectList( $hoursOffset, 'bsq_sitestats_reportHoursOffset', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'reportHoursOffset' ) ); 
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_REPORTHOURSOFFSET, $frmField, _BSQ_REPORTHOURSOFFSETDESC);
		
	    $usersOpt = array();
	    $usersOpt[] = mosHTML::makeOption( '0', _BSQ_ID);
	    $usersOpt[] = mosHTML::makeOption( '1', _BSQ_NICKNAME);
	    $usersOpt[] = mosHTML::makeOption( '2', _BSQ_USERNAME);
    	$frmField = mosHTML::selectList( $usersOpt, 'bsq_sitestats_showUsersAs', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'showUsersAs' ) ); 
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_SHOWUSERSAS, $frmField, _BSQ_SHOWUSERSASDESC);
	    
		echo "</table>\n";
		$tabs->endTab();
		
		
		
		
		
		$tabs->startTab(_BSQ_COMPRESSION, 'bsq_compression');
		echo '<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">'."\n";
		
		$hoursOpt = array();
		$hoursOpt[] = mosHTML::makeOption( '0', 'None' );
	    $hoursOpt[] = mosHTML::makeOption( '1', '1 '. _BSQ_HOUR);
    	$hoursOpt[] = mosHTML::makeOption( '8', '8 '. _BSQ_HOURS);
    	$hoursOpt[] = mosHTML::makeOption( '24', '1 '. _BSQ_DAY);
	    $hoursOpt[] = mosHTML::makeOption( '48', '2 '. _BSQ_DAYS);
	    $hoursOpt[] = mosHTML::makeOption( '72', '3 '. _BSQ_DAYS);
	    $hoursOpt[] = mosHTML::makeOption( '168', '1 '. _BSQ_WEEK);
    	$frmField = mosHTML::selectList( $hoursOpt, 'bsq_sitestats_hoursBeforeCompress', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'hoursBeforeCompress' ) ); 
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_COMPRESSAGE, $frmField, _BSQ_COMPRESSAGEDESC);
		
	    $rowsOpt = array();
	    $rowsOpt[] = mosHTML::makeOption( '100', '100' );
	    $rowsOpt[] = mosHTML::makeOption( '200', '200' );
    	$rowsOpt[] = mosHTML::makeOption( '500', '500' );
    	$rowsOpt[] = mosHTML::makeOption( '1000', '1000' );
	    $rowsOpt[] = mosHTML::makeOption( '2500', '2500' );
	    $rowsOpt[] = mosHTML::makeOption( '10000', '10000' );
	    $rowsOpt[] = mosHTML::makeOption( '20000', '20000' );
    	$frmField = mosHTML::selectList( $rowsOpt, 'bsq_sitestats_rowsPerCompress', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'rowsPerCompress' ) ); 
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_HITSPERCOMPRESS, $frmField, _BSQ_HITSPERCOMPRESSDESC);
		
	    echo "</table>\n";
	    $tabs->endTab();
	    
	    
	    
	    
	    
	    $tabs->startTab(_BSQ_GRAPHING, 'bsq_compression');
		echo '<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">'."\n";
	    
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_useJpGraph', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'useJpGraph' ) ); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_ENABLEGRAPHING, $frmField, _BSQ_ENABLEGRAPHINGDESC);
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_graphForComponent', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'graphForComponent' ) ); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_GRAPHFORCOMPONENT, $frmField, _BSQ_GRAPHFORCOMPONENTDESC);
		
		$frmField = '<input type="text" name="bsq_sitestats_graphTimeFormat" maxlength="10" size="10" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('graphTimeFormat').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_GRAPHTIMEFORMAT, $frmField, _BSQ_GRAPHTIMEFORMATDESC);
		
		$frmField = '<input type="text" name="bsq_sitestats_graphDateFormat" maxlength="10" size="10" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('graphDateFormat').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_GRAPHDATEFORMAT, $frmField, _BSQ_GRAPHDATEFORMATDESC);
	    
	    $frmField = '<input type="text" name="bsq_sitestats_graphWidth" maxlength="5" size="5" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('graphWidth').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_GRAPHWIDTH, $frmField, _BSQ_GRAPHWIDTHDESC);
	    
	    $frmField = '<input type="text" name="bsq_sitestats_graphHeight" maxlength="5" size="5" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('graphHeight').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_GRAPHHEIGHT, $frmField, _BSQ_GRAPHHEIGHTDESC);
	    
	    $frmField = '<input type="text" name="bsq_sitestats_graphCacheTime" maxlength="5" size="5" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('graphCacheTime').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_GRAPHCACHETIME, $frmField, _BSQ_GRAPHCACHETIMEDESC);
	    
	    $timeIntOpt = array();
	    foreach ($bsqTimeIntervals as $key=>$arr) {
	    	$timeIntOpt[] = mosHTML::makeOption($key, $arr[0]);
	    }
    	$frmField = mosHTML::selectList( $timeIntOpt, 'bsq_sitestats_visitorsGraphInterval', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'visitorsGraphInterval' ) ); 
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_VISITORSGRAPHINTERVAL, $frmField, _BSQ_VISITORSGRAPHINTERVALDESC);
	    
		$frmField = '<input type="text" name="bsq_sitestats_barChartValueColor" maxlength="10" size="10" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('barChartValueColor').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_BARCHARTVALUECOLOR, $frmField, _BSQ_BARCHARTVALUECOLORDESC);
	    
	    $frmField = '<input type="text" name="bsq_sitestats_barChartFillColor" maxlength="10" size="10" class="inputbox" value="'.$BSQSitestatsCFG->GetCfg('barChartFillColor').'">';
	    BSQSitestatsHTML::ConfigurationRow(_BSQ_BARCHARTFILLCOLOR, $frmField, _BSQ_BARCHARTFILLCOLORDESC);
	    
		echo "</table>\n";
	    $tabs->endTab();
	    
	    
	    
	    
	    $tabs->startTab(_BSQ_FRONTEND, 'bsq_frontend');
	    
	    echo '<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">'."\n";
	    echo "<tr><td colspan=\"3\"><h3 style=\"margin: 0; border: 0; padding: 0;\">"._BSQ_SHOWONFRONTEND."</h3></td></tr>\n";
	    
	    $frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowSSSummary', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowSSSummary')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_SITESTATSSUMMARY, $frmField, '');
	    
	    $frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowVisitorGraph', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowVisitorGraph')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_VISITORGRAPH, $frmField, '');
	    
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowLatestVisitors', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowLatestVisitors')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_LATESTVISITORS, $frmField, '');
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowUserFreq', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowUserFreq')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_USERFREQ, $frmField, '');
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowResourceFreq', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowResourceFreq')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_RESOURCEFREQ, $frmField, '');
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowBrowserFreq', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowBrowserFreq')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_BROWSERFREQ, $frmField, '');
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowRecentReferers', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowRecentReferers')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_RECENTREFERERS, $frmField, '');
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowRefererFreq', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowRefererFreq')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_REFERERFREQ, $frmField, '');
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowDomainFreq', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowDomainFreq')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_DOMAINFREQ, $frmField, '');
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowLanguageFreq', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowLanguageFreq')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_LANGUAGEFREQ, $frmField, '');
		
		$frmField = mosHTML::selectList( $yesno, 'bsq_sitestats_feshowKeywordFreq', 'class="inputbox" size="1"', 'value', 'text', $BSQSitestatsCFG->GetCfg( 'feshowKeywordFreq')); 
		BSQSitestatsHTML::ConfigurationRow(_BSQ_KEYWORDFREQ, $frmField, '');
		
	    echo "</table>\n";
	    $tabs->endTab();
	    
	    
	    
	    $tabs->endPane();
	    
		?>
  		
	    <input type="hidden" name="task" value="saveedit" />
	    <input type="hidden" name="act" value="<?php echo $act; ?>" />
	    <input type="hidden" name="option" value="<?php echo $option; ?>" />
	  </form>
	  
	    <?php
	}

	function ShowHelp( $option) 
	{
		global $act, $task, $bsqAdminPath;
		
		echo _BSQ_SHOWHELPTEXT;
		echo '<p style="font-size: 10px; font-weight: bolder;">php -f '.$bsqAdminPath . '/components/com_bsq_sitestats/cron/bsqcronstatcompress.php</p>';
		echo _BSQ_SHOWHELPTEXT2;
		
		BSQSitestatsHTML::Footer();
  	}
	
  	function CompressStats($option, $BSQCfg)
  	{
  		global $act, $task;
  		
  		$numRows = $BSQCfg->GetCfg('rowsPerCompress');
		$hoursBefore = $BSQCfg->GetCfg( 'hoursBeforeCompress');
		
		$secondsBefore = $hoursBefore * 3600;
		
		$BSQCompress = new BSQSitestatsCompress();
		$moreRows = $BSQCompress->CompressHits($secondsBefore, $numRows);
		
		echo "<div style=\"font-size: 14px; text-align: left; width: 760px;\">\n" .
			 "<h3>"._BSQ_SITESTATSCOMPRESSION."</h3>\n";
		if ($moreRows)
		{
			echo "<p>Compressed <strong>$numRows</strong> rows older than <strong>$hoursBefore Hours</strong>.</p>\n" .
				 _BSQ_COMPRESSCLICKAGAIN;
		}
		else
		{
			echo "<p>Compressed maximum of <strong>$numRows</strong> rows older than <strong>$hoursBefore Hours</strong>.</p>\n";
		}
		echo "</div>\n<hr width=\"100%\" size=\"1px\">\n";
		BSQSitestatsHTML::Footer();
  	}
  	
  	function ConvertIPsToCountries()
  	{
  		$rowsConverted = bsq_ip2country_fillInCountries();
  	
  		echo "\n<h1>Added countries for $rowsConverted IP addresses.</h1>\n";
  		
  		BSQSitestatsHTML::Footer();
  	}
  	
  	function ImportCountries()
  	{
  		global $bsqAdminPath;
  		
  		$csvFilename = $bsqAdminPath . '/ip-to-country.csv';
  		
  		$retStr = bsq_ip2country_fillFromCSV($csvFilename);
  		if ($retStr === null) {
  			echo "\n<h1>"._BSQ_IMPORTCOUNTRIESWORKED."</h1>\n";
  		}
  		else {
			echo "<div style=\"font-size: 14px; text-align: left; width: 760px;\">\n" .
  			 	 "<h2>Import Error:</h2>\n<p style=\"font-size: 12;\"><i>$retStr</i></p>\n" . 
  			 	 _BSQ_IMPORTCOUNTRIES . $csvFilename . _BSQ_IMPORTCOUNTRIES2 .
  			 	 "</div>\n";
  			 	 
  		}
  		
  		BSQSitestatsHTML::Footer();
  	}
  	
  	function ShowStats($option, $BSQCfg)
  	{
  		global $bsq_sitestats_cacheTime, $bsq_sitestats_rowLimit, $bsq_sitestats_cssPrepend,
  		       $bsq_sitestats_dateFormat, $bsq_sitestats_useInternalCSS, $mosConfig_live_site,
  		       $bsqAppTitle;
  		
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
		
		$bsqRender = new BSQSitestatsRender($bsqCache, $cssPrepend, false);
		
		if ($useInternalCSS) {
			$cssPath = $mosConfig_live_site . '/components/com_bsq_sitestats/bsq_sitestats.css';
			echo '<link rel="stylesheet" href="'.$cssPath.'" type="text/css" />'."\n";
		}
		
		echo "<h1>$bsqAppTitle</h1>\n";
		echo "<div align=\"left\">\n";
		BSQTabbedReport::show($bsqRender, $order, $limit, $howDisplay, $beforeNow, $duration, $dateFormat, $cssPrepend, false);
		echo "</div>\n";
		
		BSQSitestatsHTML::Footer();
  	}
  	
  	function IpLookup($option)
  	{
  		global $act, $task, $bsq_sitestats_showUsersAs, $bsq_sitestats_cssPrepend, $bsq_sitestats_dateFormat;
  		
  		$ip = mosGetParam($_REQUEST, 'ip', '');
  		
  		?>
  		<div style="text-align: center; width: 700px;">
  		<div style="text-align: left; ">
  	 	<form action="index2.php" method="post" name="adminForm" id="adminForm">
	  		<h1><?php echo _BSQ_IPADDRESSLOOKUP; ?></h1>
	  		<?php echo _BSQ_IPTOSEARCHFOR; ?>&nbsp;<input type="text" name="ip" value="<?php echo $ip; ?>" size="15" maxlength="15">
	  		<input type="submit" name="submit" value="<?php echo _BSQ_LOOKUPIP; ?>">
	  		<input type="hidden" name="task" value="<?php echo _BSQ_IPADDRESSLOOKUP; ?>" />
	    	<input type="hidden" name="act" value="<?php echo $act; ?>" />
	    	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	 	</form>
	 	<br />
	 	<?php
	 	
	 	if (!strlen($ip)) {
	 		echo '<i>'._BSQ_PLEASESPECIFYANIP."</i>\n";
	 	}
	 	else {
	 		
	 		//IP and Hostname
	 		echo '<strong>'._BSQ_IPADDRESS.'</strong>: ' . $ip . "<br />\n";
	 		echo '<strong>'._BSQ_HOSTNAME.'</strong>: ' . gethostbyaddr($ip) . "<br />\n";
	 		
	 		//Usernames used
	 		$userArr = bsq_getUsersForIpAddress($bsq_sitestats_showUsersAs, $ip);
	 		if (!count($userArr)) {
	 			$userStr = _BSQ_NA;
	 		}
	 		else {
	 			$userStr = $userArr[0];
	 			for ($i = 1; $i < count($userArr); $i++) {
	 				$userStr .= ', '.$userArr[1];
	 			}
	 		}
	 		echo '<strong>'._BSQ_USERSUSED.'</strong>: ' . $userStr . "<br />\n";

			//IP 2 City RPC	 		
	 		$ip2City = new BSQIp2City($ip);
	 		if (!$ip2City->fetch()) {
	 			echo $ip2City->errorText;
	 		}
	 		else {
	 			echo '<strong>'._BSQ_COUNTRY.'</strong>: ' . $ip2City->country . "<br />\n";
	 			echo '<strong>'._BSQ_CITY.'</strong>: '.$ip2City->city."<br />\n";
	 			echo '<strong>'._BSQ_LATITUDE.'</strong>: '.$ip2City->latitude."<br />\n";
	 			echo '<strong>'._BSQ_LONGITUDE.'</strong>: '.$ip2City->longitude."<br />\n";
	 			
	 			echo "<br />\n<strong>"._BSQ_COUNTRYFLAG."</strong>:<br />\n".$ip2City->getFlagHTML()."\n<br />\n<br />\n";
	 		}
	 		
	 		$numLatestHits = 100;
	 		
	 		$bsqCache = new BSQCache(array());
	 		$bsqCache->enableCache(false);
	 		$bsqRenderer = new BSQSitestatsRender($bsqCache, $bsq_sitestats_cssPrepend, false);
	 		
	 		$latestForIPTitle = sprintf(_BSQ_LASTNHITSFORIP, $numLatestHits);
	 		
	 		echo "<br /><h2 style=\"margin: 0; padding: 0; border: 0;\">$latestForIPTitle</h2>\n";
	 		echo $bsqRenderer->showLatestVisitors($numLatestHits, $bsq_sitestats_dateFormat, $ip);
	 	}
	 	
	 	echo "</div>\n</div>\n<hr width=\"100%\" size=\"1px\">\n";
	 	BSQSitestatsHTML::Footer();
  	}
  	
	function Footer() 
	{
		global $BSQSitestatsCFG;
		
  		echo '<div align="center" style="clear: both;"><span class="smalldark">BSQ Sitestats ' . $BSQSitestatsCFG->getVersion() . "<br />\n" .
    		 '<a href="http://www.bs-squared.com/mambo/index.php" target="_blank" class="smalldark">BS-Squared. More than enough BS</a>, released under the GPL.</span></div>'."\n";
	}
}
?>