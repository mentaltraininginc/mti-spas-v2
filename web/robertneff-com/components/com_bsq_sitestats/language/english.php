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
* HTML_com_bsq_sitestats Class
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle <dev@bs-squared.com>
*
*/

if (!defined('BSQ_LANGUAGE')) {
define('BSQ_LANGUAGE', true);

/* General */
define('_BSQ_YES', 'Yes');
define('_BSQ_NO', 'No');

/* Report Titles */
define('_BSQ_SSS_TITLE', 'Site Stats Summary');

/* Row and Column Titles */
define('_BSQ_TOTAL', 'Total');
define('_BSQ_TODAY', 'Today');
define('_BSQ_WEEK', 'Week');
define('_BSQ_MONTH', 'Month');
define('_BSQ_YEAR', 'Year');
define('_BSQ_COUNT', 'Count');
define('_BSQ_HITS', 'Hits');
define('_BSQ_DATE', 'Date');
define('_BSQ_HOURS', 'Hours');
define('_BSQ_SUMMARY', 'Summary');
define('_BSQ_LATESTVISITORS', 'Latest Visitors');
define('_BSQ_RESOURCEFREQ', 'Resource Frequencies');
define('_BSQ_RESOURCE', 'Resource');
define('_BSQ_RESOURCES', 'Resources');
define('_BSQ_BROWSER', 'Browser');
define('_BSQ_BROWSERS', 'Browsers');
define('_BSQ_BROWSERFREQ', 'Browser Frequencies');
define('_BSQ_REFERER', 'Referer');
define('_BSQ_REFERERS', 'Referers');
define('_BSQ_RECENTREFERERS', 'Recent Referers');
define('_BSQ_REFERERFREQ', 'Referer Frequencies');
define('_BSQ_DOMAIN', 'Domain');
define('_BSQ_DOMAINS', 'Domains');
define('_BSQ_DOMAINFREQ', 'Domain Frequencies');
define('_BSQ_LANGUAGE', 'Language');
define('_BSQ_LANGUAGES', 'Languages');
define('_BSQ_LANGUAGEFREQ', 'Language Frequencies');
define('_BSQ_KEYWORDS', 'Keywords');
define('_BSQ_KEYWORDFREQ', 'Keyword Frequencies');
define('_BSQ_TOTALHITS', 'Total Hits');
define('_BSQ_UNIQUEVISITORS', 'Unique Visitors');
define('_BSQ_HITSTODAY', 'Hits Today');
define('_BSQ_UNIQUEVISITORSTODAY', 'Unique IPs Today');
define('_BSQ_VIEWSINWINDOW', "Views since %s per %d seconds");
define('_BSQ_AVERAGEHITSPERIP', 'Average hits/ip');
define('_BSQ_PLATFORM', 'Platform');
define('_BSQ_PLATFORMFREQ', 'Platform Frequency');
define('_BSQ_CLIENTIP', 'Client IP');
define('_BSQ_NOMATCHINGROWS', 'No Matching Rows');
define('_BSQ_SITESTATSSUMMARY', 'Site Stats Summary');
define('_BSQ_VISITORS', 'Visitors');
define('_BSQ_USER', 'User');
define('_BSQ_USERS', 'Users');
define('_BSQ_USERFREQ', 'User Frequencies');
define('_BSQ_USERSRECENTHITS', 'User\'s Recent Hits');
define('_BSQ_LONGITUDE', 'Longitude');
define('_BSQ_LATITUDE', 'Latitude');
define('_BSQ_HOSTNAME', 'Hostname');
define('_BSQ_CITY', 'City');
define('_BSQ_COUNTRY', 'Country');
define('_BSQ_COUNTRYFLAG', 'Country Flag');
define('_BSQ_DATABASEUPGRADED', 'Database was upgraded to latest version');
define('_BSQ_DATABASEUPTODATE', 'Database was already up to date');
define('_BSQ_NA', 'N/A');
define('_BSQ_IPADDRESS', 'IP Address');
define('_BSQ_IPADDRESSLOOKUP', 'IP Address Lookup');
define('_BSQ_USERSUSED', 'Users Used');
define('_BSQ_PRIVATEADDRESS', 'Private Address');
define('_BSQ_LASTNHITSFORIP', 'Last %d Hits for IP');

/* Front-end general stuff */
define('_BSQ_ALLREPORTSDISABLED', '<i>All reports have been disabled by the administrator</i>');

/* Back-end general stuff */
define('_BSQ_CFGNOTWRITEABLE', 'Config file not writeable!');
define('_BSQ_SETTINGSSAVED', 'Settings saved');
define('_BSQ_INSTALLWORKED', 
           "<p>This is a site statistics component for Joomla that's made to be lightweight and persistent.</p>\n" . 
	       "<p><strong><font color=\"red\">You must add the following to your Joomla template's index.php in order for 
	        this component to register hits. <u>This file changed between 1.3.0 and 1.4.0</u>.</font></strong></p>" .
	        '<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>');

/* Graphing Stuff */
define('_BSQ_NOTENOUGHFORLINECHART', 'Not enough data for a <strong>%s</strong> line chart.');
define('_BSQ_NOTENOUGHFORBARCHART', 'Not enough data to generate a <strong>%s</strong> bar chart.');

define('_BSQ_BARCHARTNOTSUPPORTED', "<p>Bar chart not supported for:<strong>%s</strong>. Please chose a different report or a render it as a tabular.</p>\n");	        
define('_BSQ_JPGRAPHMISSING', 'You must install the JPGraph component before enabling graphing in BSQ Sitestats');
define('_BSQ_MUSTENABLEGRAPH', 'You must enable graphing within BSQ Sitestats\' component settings');
define('_BSQ_HITSPER', 'Hits Per');
define('_BSQ_MINUTE', 'Minute');
define('_BSQ_MINUTES', 'Minutes');
define('_BSQ_HOUR', 'Hour');
define('_BSQ_DAY', 'Day');
define('_BSQ_DAYS', 'Days');
define('_BSQ_WEEKS', 'Weeks');
define('_BSQ_GRAPHWIDTH', 'Graph Width');
define('_BSQ_GRAPHWIDTHDESC', 'Width of the images to be generated with JPGraph. Make this small enough to fit in your template but large enough to see everything.');
define('_BSQ_GRAPHHEIGHT', 'Graph Height');
define('_BSQ_GRAPHHEIGHTDESC', 'Height of the image to be generated with JPGraph');
define('_BSQ_GRAPHFORCOMPONENT', 'Graph Component');
define('_BSQ_GRAPHFORCOMPONENTDESC', 'Use JPGraph to generate graphs for component reports that support graphing.');
define('_BSQ_GRAPHCACHETIME', 'Cache Time');
define('_BSQ_GRAPHCACHETIMEDESC', 'Amount of time to cache graphs for. Make this large as generating graphs takes a lot of CPU time.');
define('_BSQ_VISITORSGRAPHINTERVAL', 'Visitor Graph Interval');
define('_BSQ_VISITORSGRAPHINTERVALDESC', 'Time interval between ticks to use for the visitors graph. A tick is one point on the X axis.');
define('_BSQ_BARCHARTVALUECOLOR', 'Bar Value Color');
define('_BSQ_BARCHARTVALUECOLORDESC', 'Color of the numeric value on the right side of each bar on a Bar Chart. A HTML color, starting with a #.');
define('_BSQ_BARCHARTFILLCOLOR', 'Bar Fill Color');
define('_BSQ_BARCHARTFILLCOLORDESC', 'What color should the bars on a bar chart be? A HTML color, starting with a #.');

/* Back-end configuration stuff */
define('_BSQ_GRAPHING', 'Graphing');
define('_BSQ_ENABLEGRAPHING', 'Enable Graphing');
define('_BSQ_ENABLEGRAPHINGDESC', 'Enable graphing in BSQ Sitestats. This depends on the JPGraph component.');
define('_BSQ_GRAPHTIMEFORMAT', 'Time Format');
define('_BSQ_GRAPHTIMEFORMATDESC', 'date() compatible string for how times should be displayed on graphs.'); 
define('_BSQ_GRAPHDATEFORMAT', 'Date Format');
define('_BSQ_GRAPHDATEFORMATDESC', 'date() compatible string for how dates should be displayed on graphs.'); 
define('_BSQ_REPORTING', 'Reporting');
define('_BSQ_COMPRESSION', 'Compression');
define('_BSQ_HITTRACKING', 'Hit Tracking');
define('_BSQ_TRACKHITS', 'Track Hits?');
define('_BSQ_TRACKHITSDESC', 'Should we track hits at all? Set this to NO to disable bsq_sitestats');
define('_BSQ_DEBUGQUERIES', 'Debug Queries');
define('_BSQ_DEBUGQUERIESDESC', 'Print queries to the page instead of executing them against the database (useful for debugging)');
define('_BSQ_IPTOCOUNTRY', 'Get Country from IP');
define('_BSQ_IPTOCOUNTRYDESC', 'Should we set the country based on the IP address? (1 extra <strong>slow</strong> query per hit)');
define('_BSQ_DOKEYWORDSNIFF', 'Track Search Engines');
define('_BSQ_DOKEYWORDSNIFFDESC', 'Should we track the search engine strings we find? (2 queries per page hit)');
define('_BSQ_COMPRESSAGE', 'Min Compression Age');
define('_BSQ_COMPRESSAGEDESC', 'How old should stats be before they are compressed?');
define('_BSQ_HITSPERCOMPRESS', 'Hits Per Compression');
define('_BSQ_HITSPERCOMPRESSDESC', 'How many hits should we compress per compression. Setting this too high might cause your script to timeout.');
define('_BSQ_CACHETIME', 'Cache Time');
define('_BSQ_CACHETIMEDESC', 'How long should we cache component output for?');
define('_BSQ_ROWSPERREPORT', 'Rows Per Report');
define('_BSQ_ROWSPERREPORTDESC', 'Number of rows per report. Making this number larger will make page loads take longer and will hit the database harder');
define('_BSQ_CSSPREPEND', 'CSS Prepend');
define('_BSQ_CSSPREPENDDESC', 'What should we prepend all of the BSQ Sitestats classes with?');
define('_BSQ_DATEFORMAT', 'Date Format');
define('_BSQ_DATEFORMATDESC', 'Enter a date() compatible string for how you want dates formatted.');
define('_BSQ_USEINTERNALCSS', 'Use Internal CSS');
define('_BSQ_USEINTERNALCSSDESC', 'Use the included bsq_sitestats.css file for formatting to override your template\'s CSS.');
define('_BSQ_USEDAYBOUNDARY', 'Use Day Boundary');
define('_BSQ_USEDAYBOUNDARYDESC', 'When doing periodic stats like daily, weekly, and monthly, align stats to day boundaries.');
define('_BSQ_REPORTHOURSOFFSET', 'Report Time Offset');
define('_BSQ_REPORTHOURSOFFSETDESC', 'Number of hours to report as NOW compared to the server\'s time. If the server is 1 hour ahead of you, pick \'-1 Hours\'');
define('_BSQ_FRONTEND', 'Front End');
define('_BSQ_SHOWONFRONTEND', 'Show the following reports on the component Front End:');
define('_BSQ_VISITORGRAPH', 'Visitor Graph');
define('_BSQ_SHOWUSERSAS', 'Show Users As');
define('_BSQ_SHOWUSERSASDESC', 'How do display users on reports. This can be the user ID, the user\'s login name, or the user\'s nickname');
define('_BSQ_ID', 'ID');
define('_BSQ_USERNAME', 'Username');
define('_BSQ_NICKNAME', 'Nickname');

/* Stats compression stuff */
define('_BSQ_SITESTATSCOMPRESSION', 'BSQ Sitestats Compression');
define('_BSQ_COMPRESSCLICKAGAIN', "<p>Click this menu again to compress more rows.</p>\n");

/* Help stuff */
define('_BSQ_SHOWWELCOME', '
	<div style="font-size: 14px; text-align: left; width: 760px;">
	<h1>BSQ Sitestats</h1>
	<table>
		<tr<td colspan="2" style="font-size: 14px; font-weight: bolder;">The BSQ Sitestats Team</td></tr>
		<tr><td width="100">Brent Stolle</td><td>Lead Developer</td></tr>
		<tr><td width="100">Michiel Bijland</td><td>Developer</td></tr>
		<tr><td width="100">Markus Rüping</td><td>Translator (German)</td></tr>
		<tr><td width="100">Dennis Pleiter</td><td>Translator (Dutch)</td></tr>
		<tr><td width="100">Trond Bratli</td><td>Translator (Norwegian)</td></tr>
	</table>
	<p>This software is FREE. Please distribute it under the terms of the GNU/GPL License<br />
	See <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a> GNU/GPL for details.</p>
	
	<p>If you fork this to create your own project, please make a reference to BSQ Sitestats
	someplace in your code and provide a link to http://www.bs-squared.com</p>

	<p>BSQ Sitestats is based on and made to operate along side of Shaun Inman\'s <b>ShortStat</b>
	<a href="http://www.shauninman.com/" target="_blank">http://www.shauninman.com/</a></p>
	<p>Brent can be contacted at <a href="mailto:dev@bs-squared.com">dev@bs-squared.com</a> or at <a href="http://www.bs-squared.com/mambo/index.php" target="_blank">http://www.bs-squared.com/</a></p>
	<hr width="100%" size="1px">
	</div>
        ');

define('_BSQ_SHOWHELPTEXT', '
		<div style="font-size: 14px; text-align: left; width: 760px;">
			<h3>BSQ Sitestats</h3>
			<p>To enable <strong>BSQ Sitestats</strong> on your Joomla page, add the following to your template\'s HTML:</p>
			<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>
			<p>To do stat compression automatically, add the following as a cron job:</p>');
define('_BSQ_SHOWHELPTEXT2', '			
			<p>For Personal Help, please check out the <a href="http://www.bs-squared.com/forum" target="_blank">BS-Squared</a> forums.</p>
			<hr width="100%" size="1px">
		</div>
		');

/* IP 2 Country */
define('_BSQ_IMPORTCOUNTRIESWORKED', 'Imported IP to Country CSV file successfully');
define('_BSQ_IMPORTCOUNTRIES',
                 "<h3>How to import IP to Country data:</h3><p>\n" .
  			 	 "1. Download the lastest iptocountry CSV file from <a target=\"_blank\" ".
  			 	 "href=\"http://ip-to-country.webhosting.info/downloads/ip-to-country.csv.zip\">here</a>.<br />\n" .
  			 	 "2. Extract the .csv file to <strong>");
define('_BSQ_IMPORTCOUNTRIES2',
  			 	 "</strong><br />\n" .
  			 	 "3. Run this script again. It will take about a minute to import, depending on how fast your database server is.</p>\n"
				 );
				 
/* Ip2City */
define('_BSQ_CANTOPENFORREADING', "Unable to open '%s' for reading.");
define('_BSQ_CANTFOPENURLS', 'Your server is incapable of opening URLs via fopen(), which is required for Ip2City. Set <b>allow_url_fopen</b>=true in php.ini');
define('_BSQ_FLAGFORUSERSCOUNTRY', 'Flag for User\'s Country');
define('_BSQ_IPTOSEARCHFOR', 'IP Address to Search For:');
define('_BSQ_PLEASESPECIFYANIP', 'Please specify an IP above.');
define('_BSQ_LOOKUPIP', 'Lookup IP');

} /* BSQ_LANGUAGE */
?>