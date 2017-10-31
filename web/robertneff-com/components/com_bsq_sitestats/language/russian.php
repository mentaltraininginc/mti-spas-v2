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
define('_BSQ_YES', '��');
define('_BSQ_NO', '���');

/* Report Titles */
define('_BSQ_SSS_TITLE', '����� ���������� �����');

/* Row and Column Titles */
define('_BSQ_TOTAL', '�����');
define('_BSQ_TODAY', '�������');
define('_BSQ_WEEK', '������');
define('_BSQ_MONTH', '�����');
define('_BSQ_YEAR', '���');
define('_BSQ_COUNT', '����������');
define('_BSQ_HITS', '���������');
define('_BSQ_DATE', '����');
define('_BSQ_HOURS', '�����');
define('_BSQ_SUMMARY', '����');
define('_BSQ_LATESTVISITORS', '��������� ����������');
define('_BSQ_RESOURCEFREQ', '������� �� �������');
define('_BSQ_RESOURCE', '������');
define('_BSQ_RESOURCES', '�������');
define('_BSQ_BROWSER', '�������');
define('_BSQ_BROWSERS', '��������');
define('_BSQ_BROWSERFREQ', '������� �� ��������');
define('_BSQ_REFERER', '�������');
define('_BSQ_REFERERS', '��������');
define('_BSQ_RECENTREFERERS', '��������� ��������');
define('_BSQ_REFERERFREQ', '������� �� ������');
define('_BSQ_DOMAIN', '�����');
define('_BSQ_DOMAINS', '������');
define('_BSQ_DOMAINFREQ', '������� �� ������');
define('_BSQ_LANGUAGE', '����');
define('_BSQ_LANGUAGES', '�����');
define('_BSQ_LANGUAGEFREQ', '������� �� �����');
define('_BSQ_KEYWORDS', '�����');
define('_BSQ_KEYWORDFREQ', '������� �� ��������� �����');
define('_BSQ_TOTALHITS', '����� ���������');
define('_BSQ_UNIQUEVISITORS', '���������� ����������');
define('_BSQ_HITSTODAY', '��������� �������');
define('_BSQ_UNIQUEVISITORSTODAY', '���������� IP �������');
define('_BSQ_VIEWSINWINDOW', "Views since %s per %d seconds");
define('_BSQ_AVERAGEHITSPERIP', '������� ���������/ip');
define('_BSQ_PLATFORM', '���������');
define('_BSQ_PLATFORMFREQ', '������� �� ���������');
define('_BSQ_CLIENTIP', 'IP �������');
define('_BSQ_NOMATCHINGROWS', '��� ���������� �����');
define('_BSQ_SITESTATSSUMMARY', '������� ���������� �����');
define('_BSQ_VISITORS', '����������');
define('_BSQ_USER', '������������');
define('_BSQ_USERS', '������������');
define('_BSQ_USERFREQ', '������� �� ������������');
define('_BSQ_USERSRECENTHITS', '��������� ��������� ������������\'��');
define('_BSQ_LONGITUDE', '�������');
define('_BSQ_LATITUDE', '������');
define('_BSQ_HOSTNAME', '��� �����');
define('_BSQ_CITY', '�����');
define('_BSQ_COUNTRY', '������');
define('_BSQ_COUNTRYFLAG', '���� ������');
define('_BSQ_DATABASEUPGRADED', '���� ������ ���� �������� �� ��������� ������');
define('_BSQ_DATABASEUPTODATE', '���� ������ ��� �����');
define('_BSQ_NA', 'N/A');
define('_BSQ_IPADDRESS', 'IP �����');
define('_BSQ_IPADDRESSLOOKUP', '����� IP ������');
define('_BSQ_USERSUSED', 'Users Used');
define('_BSQ_PRIVATEADDRESS', '������� �����');
define('_BSQ_LASTNHITSFORIP', '��������� %d ��������� ��� IP');

/* Front-end general stuff */
define('_BSQ_ALLREPORTSDISABLED', '<i>��� ������ ���� ��������� ���������������</i>');

/* Back-end general stuff */
define('_BSQ_CFGNOTWRITEABLE', '���� ������������ �� ������������!');
define('_BSQ_SETTINGSSAVED', '��������� ���������');
define('_BSQ_INSTALLWORKED', 
           "<p>��� ��������� ������� ���������� ����� ��� Joomla ������ ����� �������, ����� ���� ������ � ����������.</p>\n" . 
	       "<p><strong><font color=\"red\">�� ������ �������� ��������� ������ � index.php �������'�� Joomla ��� ���� �����
	        ���� ��������� ������������� ���������. <u>���� ���� ������� ����� 1.3.0 � 1.4.0</u>.</font></strong></p>" .
	        '<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>');

/* Graphing Stuff */
define('_BSQ_NOTENOUGHFORLINECHART', '�� ���������� ������ ��� ���������� �������� ��������� <strong>%s</strong>.');
define('_BSQ_NOTENOUGHFORBARCHART', '�� ���������� ������ ��� ���������� ���������� ��������� <strong>%s</strong>.');

define('_BSQ_BARCHARTNOTSUPPORTED', "<p>���������� ��������� �� �������������� ���:<strong>%s</strong>. ���������� �������� ������ ����� ��� ��������� ��� ��������.</p>\n");	        
define('_BSQ_JPGRAPHMISSING', '�� ������ ���������� ��������� JPGraph ����� ���������� ������� � BSQ Sitestats');
define('_BSQ_MUSTENABLEGRAPH', '�� ������ �������� ������� ����� ���������� BSQ Sitestats\' ����������');
define('_BSQ_HITSPER', '��������� �');
define('_BSQ_MINUTE', '������');
define('_BSQ_MINUTES', '������');
define('_BSQ_HOUR', '���');
define('_BSQ_DAY', '����');
define('_BSQ_DAYS', '���');
define('_BSQ_WEEKS', '������');
define('_BSQ_GRAPHWIDTH', '������ �������');
define('_BSQ_GRAPHWIDTHDESC', '������ ������� ��� ��������� ��� ������ JPGraph. �������� �� ���������� ��������� ��� �������� � ��� ������ �� ���������� ������� ����� ������ ���.');
define('_BSQ_GRAPHHEIGHT', '������ �������');
define('_BSQ_GRAPHHEIGHTDESC', '������ �������� ��� ��������� ��� ������ JPGraph');
define('_BSQ_GRAPHFORCOMPONENT', '��������� ��������');
define('_BSQ_GRAPHFORCOMPONENTDESC', '���������� JPGraph ��� ��������� �������� ��� ������� ���������� ������� ������������ �������.');
define('_BSQ_GRAPHCACHETIME', '����� �����������');
define('_BSQ_GRAPHCACHETIMEDESC', '���������� ������� ��� ����������� ��������. �������� ��� ������� ��������� ��������� �������� �������� ����� ������������� �������.');
define('_BSQ_VISITORSGRAPHINTERVAL', '�������� ������� �����������');
define('_BSQ_VISITORSGRAPHINTERVALDESC', '��������� �������� ����� ����� ��� ������������� � ������� �����������. ��� - ��� ���� ����� �� ��� X.');
define('_BSQ_BARCHARTVALUECOLOR', '���� �������� ������');
define('_BSQ_BARCHARTVALUECOLORDESC', '���� ��������� �������� �� ������ ������� ������� ������� ���������� ���������. HTML ����, ������������ � #.');
define('_BSQ_BARCHARTFILLCOLOR', '���� ������� �������');
define('_BSQ_BARCHARTFILLCOLORDESC', '������ ����� ������ ���� ������� �� ���������� ���������? HTML ����, ������������ � #.');

/* ��������� �������� �������� ���������������� ����� */
define('_BSQ_GRAPHING', '�������');
define('_BSQ_ENABLEGRAPHING', '�������� �������');
define('_BSQ_ENABLEGRAPHINGDESC', '�������� ������� � BSQ Sitestats. ��� ������� �� ���������� JPGraph.');
define('_BSQ_GRAPHTIMEFORMAT', '������ �������');
define('_BSQ_GRAPHTIMEFORMATDESC', 'date() ����������� ������ ������������ ��� ����� ������ ������������ �� ��������.'); 
define('_BSQ_GRAPHDATEFORMAT', '������ ����');
define('_BSQ_GRAPHDATEFORMATDESC', 'date() ����������� ������ ������������ ��� ���� ������ ������������ �� ��������.'); 
define('_BSQ_REPORTING', '������');
define('_BSQ_COMPRESSION', '������');
define('_BSQ_HITTRACKING', '���������');
define('_BSQ_TRACKHITS', '���� ���������?');
define('_BSQ_TRACKHITSDESC', '������ �� ��������� ��������� ��������� ������? ���������� � ��� ��� ���������� bsq_sitestats');
define('_BSQ_DEBUGQUERIES', '������� ��������');
define('_BSQ_DEBUGQUERIESDESC', '�������� ������� �� ������� ������ ���������� �� � ���� ������ (������� ��� �������)');
define('_BSQ_IPTOCOUNTRY', '������ �� IP');
define('_BSQ_IPTOCOUNTRYDESC', '������ �� ��������� ������������� ������ ����������� �� IP ������? (1 �������������� <strong>���������</strong> ������ �� ���������)');
define('_BSQ_DOKEYWORDSNIFF', '����������');
define('_BSQ_DOKEYWORDSNIFFDESC', '������ �� ��������� ��������� ������ ��������� ����� ������� ������? (2 ������� �� ��������� � ��������)');
define('_BSQ_COMPRESSAGE', '����������� ������� ������');
define('_BSQ_COMPRESSAGEDESC', '��������� ������ ������ ���� ���������� ����� �������?');
define('_BSQ_HITSPERCOMPRESS', '��������� ��� ������');
define('_BSQ_HITSPERCOMPRESSDESC', '��� ����� ��������� ������ ��������� ������������ �� ���� ������. ��������� ����� ��������� � ������� ������� �������� ����� ����� �������� ��������� ��������.');
define('_BSQ_CACHETIME', '����� �����������');
define('_BSQ_CACHETIMEDESC', '��� ����� ���� ���������� ����� ����������?');
define('_BSQ_ROWSPERREPORT', '����� � ������');
define('_BSQ_ROWSPERREPORTDESC', '����� ����� �� �����. ���������� ����� ����� ������� �������� ������� ����� ������ � ��������� � ���� ������ ����� �������.');
define('_BSQ_CSSPREPEND', 'CSS ���������');
define('_BSQ_CSSPREPENDDESC', '��� ���� ��������� ������� ���� ������� BSQ Sitestats?');
define('_BSQ_DATEFORMAT', '������ ����');
define('_BSQ_DATEFORMATDESC', '������� ����������� � date() ������ ��� �������������� ����.');
define('_BSQ_USEINTERNALCSS', '���������� CSS');
define('_BSQ_USEINTERNALCSSDESC', '������������ ��� �������������� ���������� � �������� ���� bsq_sitestats.css ����� ��������� CSS �������.');
define('_BSQ_USEDAYBOUNDARY', '���������� �� ���');
define('_BSQ_USEDAYBOUNDARYDESC', '����������� ���������� �� ��� ��� ������������ ������������� ���������� ���� �������, ���������, � ��������.');
define('_BSQ_REPORTHOURSOFFSET', '�������� �������');
define('_BSQ_REPORTHOURSOFFSETDESC', '���������� ����� ���������� ��� NOW ������������� ������� �������. ���� ������ �� 1 ��� ������� ���, ���������� \'-1 ���\'');
define('_BSQ_FRONTEND', '����');
define('_BSQ_SHOWONFRONTEND', '������������ ��������� ������ �� �����:');
define('_BSQ_VISITORGRAPH', '������ �����������');
define('_BSQ_SHOWUSERSAS', '������������ ���');
define('_BSQ_SHOWUSERSASDESC', '��� ���������� ������������� � �������. ���� �������� ����� ���� ID ������������, ������� ������������, ��� ����� ������������');
define('_BSQ_ID', 'ID');
define('_BSQ_USERNAME', '�����');
define('_BSQ_NICKNAME', '���');

/* Stats compression stuff */
define('_BSQ_SITESTATSCOMPRESSION', 'BSQ Sitestats ������');
define('_BSQ_COMPRESSCLICKAGAIN', "<p>������� �� ��� ���� ��� ��� ����� ����� ������ �����.</p>\n");

/* Help stuff */
define('_BSQ_SHOWWELCOME', '
	<div style="font-size: 14px; text-align: left; width: 760px;">
	<h1>BSQ Sitestats</h1>
	<table>
		<tr<td colspan="2" style="font-size: 14px; font-weight: bolder;">The BSQ Sitestats Team</td></tr>
		<tr><td width="100">Brent Stolle</td><td>Lead Developer</td></tr>
		<tr><td width="100">Michiel Bijland</td><td>Developer</td></tr>
		<tr><td width="100">Markus R�ping</td><td>Translator (German)</td></tr>
		<tr><td width="100">Dennis Pleiter</td><td>Translator (Dutch)</td></tr>
		<tr><td width="100">Trond Bratli</td><td>Translator (Norwegian)</td></tr>
		<tr><td width="100">Paul Ishenin</td><td>Translator (Russian)</td></tr>
	</table>
	<p>��� ����������� ����������� �������� ���������. ����������, ��������������� ��� ��� ��������� GNU/GPL<br />
	���������� <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a> GNU/GPL ��� �������������� ����������.</p>
	
	<p>���� �� �������� ���� ������ �� ������ ���� ���������, ���������� �������� ������ �� BSQ Sitestats
	���-���� � ����� ���� � ���������� ������ �� http://www.bs-squared.com</p>

	<p>BSQ Sitestats is based on and made to operate along side of Shaun Inman\'s <b>ShortStat</b>
	<a href="http://www.shauninman.com/" target="_blank">http://www.shauninman.com/</a></p>
	<p>Brent can be contacted at <a href="mailto:dev@bs-squared.com">dev@bs-squared.com</a> or at <a href="http://www.bs-squared.com/mambo/index.php" target="_blank">http://www.bs-squared.com/</a></p>
	<hr width="100%" size="1px">
	</div>
        ');

define('_BSQ_SHOWHELPTEXT', '
		<div style="font-size: 14px; text-align: left; width: 760px;">
			<h3>BSQ Sitestats</h3>
			<p>����� �������� <strong>BSQ Sitestats</strong> � ����� Joomla, �������� ��������� ������ � HTML �������\'��:</p>
			<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>
			<p>����� ��������� �������������� ������ ����������, �������� ��������� � �������� cron:</p>');
define('_BSQ_SHOWHELPTEXT2', '			
			<p>��� �������� ������������ ������, �������� ������ <a href="http://www.bs-squared.com/forum" target="_blank">BS-Squared</a>.</p>
			<hr width="100%" size="1px">
		</div>
		');

/* IP 2 Country */
define('_BSQ_IMPORTCOUNTRIESWORKED', '������ IP � CSV ���� ����� �������� �������');
define('_BSQ_IMPORTCOUNTRIES',
                 "<h3>��� ��������� ������ IP � ������ �����:</h3><p>\n" .
  			 	 "1. �������� ��������� iptocountry CSV ���� � <a target=\"_blank\" ".
  			 	 "href=\"http://ip-to-country.webhosting.info/downloads/ip-to-country.csv.zip\">�����</a>.<br />\n" .
  			 	 "2. ���������� .csv ���� � <strong>");
define('_BSQ_IMPORTCOUNTRIES2',
  			 	 "</strong><br />\n" .
  			 	 "3. ��������� ���� ������ ��� ���. ������ ������ ����� ������, � ����������� �� �������� ������ ������� ���� ������.</p>\n"
				 );
				 
/* Ip2City */
define('_BSQ_CANTOPENFORREADING', "�� �������� ������� '%s' ��� ������.");
define('_BSQ_CANTFOPENURLS', '��� ������ �� ����� ����������� �������� URL ����� fopen(), ������� ��������� ��� Ip2City. ���������� <b>allow_url_fopen</b>=true � php.ini');
define('_BSQ_FLAGFORUSERSCOUNTRY', '���� ��� ������ ������������\'��');
define('_BSQ_IPTOSEARCHFOR', 'IP ����� ��� ������:');
define('_BSQ_PLEASESPECIFYANIP', '����������, ������� IP ����.');
define('_BSQ_LOOKUPIP', '����� IP');

} /* BSQ_LANGUAGE */
?>