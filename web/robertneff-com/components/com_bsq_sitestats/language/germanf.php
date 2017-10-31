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
* @author Markus Rueping <markus.rueping@t-online.de>
*
*/

if (!defined('BSQ_LANGUAGE')) {
define('BSQ_LANGUAGE', true);

/* General */

define('_BSQ_YES', 'Ja');

define('_BSQ_NO', 'Nein');

/* Report Titles */
define('_BSQ_SSS_TITLE', 'Seitenstatistikzusammenfassung');

/* Row and Column Titles */
define('_BSQ_TOTAL', 'Total');
define('_BSQ_TODAY', 'Heute');
define('_BSQ_WEEK', 'Woche');
define('_BSQ_MONTH', 'Monat');
define('_BSQ_YEAR', 'Jahr');
define('_BSQ_COUNT', 'Anzahl');
define('_BSQ_HITS', 'Hits');
define('_BSQ_DATE', 'Datum');
define('_BSQ_HOURS', 'Stunden');
define('_BSQ_SUMMARY', 'Allgemein');
define('_BSQ_LATESTVISITORS', 'Letzte Besucher');
define('_BSQ_RESOURCEFREQ', 'Resourcenstatistik');
define('_BSQ_RESOURCE', 'Resource');
define('_BSQ_RESOURCES', 'Resourcen');
define('_BSQ_BROWSER', 'Browser');
define('_BSQ_BROWSERS', 'Browser');
define('_BSQ_BROWSERFREQ', 'Browserstatistik');
define('_BSQ_REFERER', 'Referer');
define('_BSQ_REFERERS', 'Referer');
define('_BSQ_RECENTREFERERS', 'Neue Referers');
define('_BSQ_REFERERFREQ', 'Refererstatistik');
define('_BSQ_DOMAIN', 'Domain');
define('_BSQ_DOMAINS', 'Domains');
define('_BSQ_DOMAINFREQ', 'Domainstatistik');
define('_BSQ_LANGUAGE', 'Sprache');
define('_BSQ_LANGUAGES', 'Sprachen');
define('_BSQ_LANGUAGEFREQ', 'Sprachenstatistik');
define('_BSQ_KEYWORDS', 'Keywords');
define('_BSQ_KEYWORDFREQ', 'Keywordstatistik');
define('_BSQ_TOTALHITS', 'Hits Insgesamt');
define('_BSQ_UNIQUEVISITORS', 'Einzelbesucher');
define('_BSQ_HITSTODAY', 'Hits Heute');
define('_BSQ_UNIQUEVISITORSTODAY', 'Einzelne IPs heute');
define('_BSQ_VIEWSINWINDOW', "Views seit %s pro %d Sekunden");
define('_BSQ_AVERAGEHITSPERIP', 'Durchschnittliche Hits pro IP');
define('_BSQ_PLATFORM', 'Betriebssystem');
define('_BSQ_PLATFORMFREQ', 'Betriebssystemstatistik');
define('_BSQ_CLIENTIP', 'Besucher IP');
define('_BSQ_NOMATCHINGROWS', 'Keine Daten');
define('_BSQ_SITESTATSSUMMARY', 'Seitenstatistik Zusammenfassung');
define('_BSQ_VISITORS', 'Besucher');
define('_BSQ_USER', 'Benutzer');
define('_BSQ_USERS', 'Benutzer');
define('_BSQ_USERFREQ', 'Benutzerstatistik');
define('_BSQ_USERSRECENTHITS', 'Neue Benutzerhits');
define('_BSQ_LONGITUDE', 'Laengengrad');
define('_BSQ_LATITUDE', 'Breitengrad');
define('_BSQ_HOSTNAME', 'Hostname');
define('_BSQ_CITY', 'Stadt');
define('_BSQ_COUNTRY', 'Land');
define('_BSQ_COUNTRYFLAG', 'Landeskuerzel');
define('_BSQ_DATABASEUPGRADED', 'Datenbank wurde auf die letzte version aktualisiert');
define('_BSQ_DATABASEUPTODATE', 'Datenbank ist schon aktuell');
define('_BSQ_NA', 'nicht Verfuegbar');
define('_BSQ_IPADDRESS', 'IP Addresse');
define('_BSQ_IPADDRESSLOOKUP', 'IP Addresse Nachschlagen');
define('_BSQ_USERSUSED', 'Benutzer verwendeten');
define('_BSQ_PRIVATEADDRESS', 'Private Addresse');
define('_BSQ_LASTNHITSFORIP', 'Letzte %d Hits fuer IP');

/* Front-end general stuff */
define('_BSQ_ALLREPORTSDISABLED', '<i>Alle Ausgaben wurden vom Administrator deaktiviert</i>');

/* Back-end general stuff */
define('_BSQ_CFGNOTWRITEABLE', 'Konfigurationsdatei nicht beschreibbar!');
define('_BSQ_SETTINGSSAVED', 'Einstellungen gespeichert');
define('_BSQ_INSTALLWORKED', 
           "<p>Dies ist eine Seitenstatistik Komponente, die klein und handlich ist.</p>\n" . 
	       "<p><strong><font color=\"red\">Du musst diese Codezeilen in die index.php deines Templates einfuegen, damit die Komponente
	        Hits erfassen kann-<u>Diese Datei hat sich gegenueber v1.0.3 veraendert!</u>.</font></strong></p>" .
	        '<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>');

/* Graphing Stuff */
define('_BSQ_NOTENOUGHFORLINECHART', 'Nicht genug Daten fuer ein <strong>%s</strong> Liniendiagramm.');
  	 define('_BSQ_NOTENOUGHFORBARCHART', 'Nicht genug Daten fuer ein <strong>%s</strong> Balkendiagramm.');
define('_BSQ_BARCHARTNOTSUPPORTED', "<p>Balkendiagramme fuer <strong>%s</strong> werden nicht unterstuetzt. Bitte waehle eine andere Ausgabeart oder benutze Tabellen.</p>\n");	        
define('_BSQ_JPGRAPHMISSING', 'Du musst die JPGraph Komponente installieren, bevor du die Grafikausgabe in BSQ Sitestats aktivieren kannst');
define('_BSQ_MUSTENABLEGRAPH', 'Du musst die Grafikausgabe in den BSQ Sitestats\' Komponenteneinstellungen aktivieren');
define('_BSQ_HITSPER', 'Hits pro');
define('_BSQ_MINUTE', 'Minute');
define('_BSQ_MINUTES', 'Minuten');
define('_BSQ_HOUR', 'Stunde');
define('_BSQ_DAY', 'Tag');
define('_BSQ_DAYS', 'Tage');
define('_BSQ_WEEKS', 'Wochen');
define('_BSQ_GRAPHWIDTH', 'Diagramm-Breite');
define('_BSQ_GRAPHWIDTHDESC', 'Breite der mit JPGraph generierten Bilder. Waehle sie klein genug, damit sie in dein Template passt.');
define('_BSQ_GRAPHHEIGHT', 'Diagramm-Hoehe');
define('_BSQ_GRAPHHEIGHTDESC', 'Hoehe der mit JPGraph generierten Bilder.');
define('_BSQ_GRAPHFORCOMPONENT', 'Graph Komponente');
define('_BSQ_GRAPHFORCOMPONENTDESC', 'Benutze JPGraph, um Diagramme fuer Berichte zu erzeugen, die die grafische Ausgabe unterstuetzen.');
define('_BSQ_GRAPHCACHETIME', 'Cache Zeit');
define('_BSQ_GRAPHCACHETIMEDESC', 'Zeitrahmen in dem die Grafiken gecacht werden. Waehle einen groﬂen Wert, da die Grafikerstellung viel CPU-Zeit benoetigt.');
define('_BSQ_VISITORSGRAPHINTERVAL', 'Besucher-Diagramm-Abstand');
define('_BSQ_VISITORSGRAPHINTERVALDESC', 'Zeitabschnitt zwischen den Punkten, die im Besucher-Diagramm benutzt werden. Ein Punkt ist einem Punkt auf die X-Achse.');
define('_BSQ_BARCHARTVALUECOLOR', 'Balkenwert Farbe');
define('_BSQ_BARCHARTVALUECOLORDESC', 'Farbe des numerischen Werts, der rechts an jedem Balken steht. Farbe muss Hexadezimal angegeben werden.');
define('_BSQ_BARCHARTFILLCOLOR', 'Balken Fuellfarbe');
define('_BSQ_BARCHARTFILLCOLORDESC', 'Welche Farbe sollen die Balken in einer Balkentabelle haben? Farbe muss Hexadezimal angegeben werden.');


/* Back-end configuration stuff */
define('_BSQ_GRAPHING', 'Grafische Darstellung');
define('_BSQ_ENABLEGRAPHING', 'Grafische Darstellung aktivieren');
define('_BSQ_ENABLEGRAPHINGDESC', 'Grafische Darstellung in BSQ Sitestats aktivieren. Dies benoetigt die JPGraph Komponente.');
define('_BSQ_GRAPHTIMEFORMAT', 'Zeitformat');
define('_BSQ_GRAPHTIMEFORMATDESC', 'Gebe einen date() kompatiblen String ein, der die Zeit in der Grafik darstellt.'); 
define('_BSQ_GRAPHDATEFORMAT', 'Datumsformat');
define('_BSQ_GRAPHDATEFORMATDESC', 'Gebe einen date() kompatiblen String ein, der das Datum in der Grafik darstellt.'); 
define('_BSQ_REPORTING', 'Bericht');
define('_BSQ_COMPRESSION', 'Komprimierung');
define('_BSQ_HITTRACKING', 'Hiterfassung');
define('_BSQ_TRACKHITS', 'Hits erfassen?');
define('_BSQ_TRACKHITSDESC', 'Sollen alle Seitenaufrufe erfasst werden? Nein um bsq_sitestats komplett abzuschalten.');
define('_BSQ_DEBUGQUERIES', 'Debug Queries');
define('_BSQ_DEBUGQUERIESDESC', 'Ausgabe der MySQL Queries um die Fehlersuche zu erleichtern. (Die Queries werden dann nicht in die Datenbank geschrieben)');
define('_BSQ_IPTOCOUNTRY', 'Land aus IP');
define('_BSQ_IPTOCOUNTRYDESC', 'Soll das Land aus der IP Adresse ausgelesen werden? (1 extra <strong>langsame</strong> query pro hit)');
define('_BSQ_DOKEYWORDSNIFF', 'Suchmaschinen erfassen');
define('_BSQ_DOKEYWORDSNIFFDESC', 'Sollen erkannte Suchmaschinen extra erfasst werden? (2 queries pro Seitenaufruf)');
define('_BSQ_COMPRESSAGE', 'Mindestalter der Kompression');
define('_BSQ_COMPRESSAGEDESC', 'Wie alt sollen die Statistiken werden, bevor sie komprimiert werden.');
define('_BSQ_HITSPERCOMPRESS', 'Hits pro Kompression ');
define('_BSQ_HITSPERCOMPRESSDESC', 'Wie viele Hits sollen pro Kompressionsvorgang verarbeitet werden? Wenn das Limit zu hoch ist, kann es zu Timeouts kommen!');
define('_BSQ_CACHETIME', 'Cache Zeit');
define('_BSQ_CACHETIMEDESC', 'Wie lange sollen die Daten im Zwischenspeicher liegen, eh sie aktualisiert werden?');
define('_BSQ_ROWSPERREPORT', 'Anzahl der Eintraege');
define('_BSQ_ROWSPERREPORTDESC', 'Anzahl der Eintraege pro Statistikreport. Wenn die Anzahl sehr hoch ist, beeinflusst das die Datenbankleisung negativ');
define('_BSQ_CSSPREPEND', 'CSS Deklaration');
define('_BSQ_CSSPREPENDDESC', 'Mit was sollen die Klassen von BSQ_Sitestats in der CSS Datei deklariert werden?');
define('_BSQ_DATEFORMAT', 'Datumsformat');
define('_BSQ_DATEFORMATDESC', 'Gebe einen date() kompatiblen String ein, der die Formatierung darstellt.');
define('_BSQ_USEINTERNALCSS', 'Interne CSS Datei benutzen');
define('_BSQ_USEINTERNALCSSDESC', 'Benutze die interne CSS Datei (bsq_sitestats.css) anstatt der des Templates.');
define('_BSQ_USEDAYBOUNDARY', 'Tagesgrenzen benutzen');
define('_BSQ_USEDAYBOUNDARYDESC', 'Sollen die Tages-,Wochen- und Monatsstatistiken an der aktuellen Zeit ausgerichtet werden oder ab 24:00 Uhr Serverzeit ausgegeben werden.');
define('_BSQ_REPORTHOURSOFFSET', 'Zeitverschiebung ausgeben');
define('_BSQ_REPORTHOURSOFFSETDESC', 'Zeitverschiebung zwischen Server und Lokalzeit. Wenn die Serveruhr eine Stunde vorgeht, waehle \'-1 Hours\'');
define('_BSQ_FRONTEND', 'Seite');
define('_BSQ_SHOWONFRONTEND', 'Zeige die folgenden Statistiken auf der Seite:');
define('_BSQ_VISITORGRAPH', 'Besucherdiagramm');
define('_BSQ_SHOWUSERSAS', 'Zeige Benutzer als');
define('_BSQ_SHOWUSERSASDESC', 'Wie sollen Benutzer dargestellt werden. Mit UserID, Nickname oder Username');
define('_BSQ_ID', 'ID');
define('_BSQ_USERNAME', 'Username');
define('_BSQ_NICKNAME', 'Nickname');

/* Stats compression stuff */
define('_BSQ_SITESTATSCOMPRESSION', 'BSQ Sitestats Komprimierung');
define('_BSQ_COMPRESSCLICKAGAIN', "<p>Waehle das Menue mehrfach aus um mehrere Eintraege zu komprimieren.</p>\n");

/* Help stuff */
define('_BSQ_SHOWWELCOME', '
	<div style="font-size: 14px; text-align: left; width: 760px;">
	<h1>BSQ_Sitestats wurde von Brent Stolle entwickelt (c) 2005</h1>
		      <table>
  	                 <tr><td colspan="2" style="font-size: 14px; font-weight: bolder;">Das BSQ Sitestats Team</td></tr>
  	                 <tr><td width="100">Brent Stolle</td><td>Leadentwickler</td></tr>
  	                 <tr><td width="100">Michiel Bijland</td><td>Entwickler</td></tr>
  	                 <tr><td width="100">Markus Rueping</td><td>Uebersetzer (Deutsch)</td></tr>
  	                 <tr><td width="100">Dennis Pleiter</td><td>Uebersetzer (Niederlaendisch)</td></tr>
					 <tr><td width="100">Trond Bratli</td><td>Uebersetzer (Norwegisch)</td></tr>
  	         </table>
	
	<h2>Brent kann unter dev@bs-squared.com oder unter <a href="http://www.bs-squared.com/" target="_blank">http://www.bs-squared.com/</a> kontaktiert werden.</h2>
	<p>Diese Software ist frei und wurde unter der GNU/GPL Lizenz veroeffentlicht.<br />
	Details: <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a></p>
	<p>Wenn du dies benutzt um ein eigenes Projekt zu realisieren, dann mache bitte einen Hinweis auf BSQ Sitestats
	irgendwo in deinem Code oder baue einen Link zu http://www.bs-squared.com ein.</p>
	<p>BSQ Sitestats basiert auf Shaun Inman\'s <b>ShortStats</b>.
	<a href="http://www.shauninman.com/" target="_blank">http://www.shauninman.com/</a></p>
	<hr width="100%" size="1px">
	</div>
        ');

define('_BSQ_SHOWHELPTEXT', '
		<div style="font-size: 14px; text-align: left; width: 760px;">
			<h3>BSQ Sitestats</h3>
			<p>Um <strong>BSQ Sitestats</strong> auf deiner Joomla Seite einzurichten, fuege folgenden Code in deine Template HTML-Datei:</p>
			<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>
			<p>Um die Statistikkomprimierung zu automatisieren, fuege folgenden Cronjob ein:</p>');
define('_BSQ_SHOWHELPTEXT2', '			
			<p>Fuer persoenliche Hilfe, schau bitte unter <a href="http://www.bs-squared.com/forum" target="_blank">BS-Squared</a> in den Foren.</p>
			<hr width="100%" size="1px">
		</div>
		');

/* IP 2 Country */
define('_BSQ_IMPORTCOUNTRIESWORKED', 'IP zu Land CSV-Datei erfolgreich importiert!');
define('_BSQ_IMPORTCOUNTRIES',
                 "<h3>Importanleitung fuer IP zu Land Daten:</h3><p>\n" .
  			 	 "1. Lade die letzte IP zu Land Datei hier herunter: <a target=\"_blank\" ".
  			 	 "href=\"http://ip-to-country.webhosting.info/downloads/ip-to-country.csv.zip\">Download</a>.<br />\n" .
  			 	 "2.  Extrahiere die CSV Datei nach: <strong>");
define('_BSQ_IMPORTCOUNTRIES2',
  			 	 "</strong><br />\n" .
  			 	 "3.Rufe dieses Script erneut auf. Es wird dann ca. eine Minute dauern, je nachdem wie schnell deine Datenbank ist.</p>\n"
				 );
				 
/* Ip2City */
define('_BSQ_CANTOPENFORREADING', "Konnte '%s' nicht lesen.");
define('_BSQ_CANTFOPENURLS', 'Dein Server kann den PHP Befehl fopen() nicht verarbeiten, welcher fuer Ip2City notwendig ist. Setze <b>allow_url_fopen</b>=true in php.ini');
define('_BSQ_FLAGFORUSERSCOUNTRY', 'Kuerzel fuer Land des Benutzers');
define('_BSQ_IPTOSEARCHFOR', 'Suche nach IP Adresse:');
define('_BSQ_PLEASESPECIFYANIP', 'Bitte waehle oben eine Ip.');
define('_BSQ_LOOKUPIP', 'IP Nachschlagen');				 

} /* BSQ_LANGUAGE */
?>