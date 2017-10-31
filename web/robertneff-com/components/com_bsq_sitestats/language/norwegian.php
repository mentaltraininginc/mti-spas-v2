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
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle <dev@bs-squared.com>
* @author Trond Bratli <Trond@trust-me.nu>
*/

if (!defined('BSQ_LANGUAGE')) {
define('BSQ_LANGUAGE', true);

/* General */
define('_BSQ_YES', 'Ja');
define('_BSQ_NO', 'Nei');

/* Report Titles */
define('_BSQ_SSS_TITLE', 'Statistikk Oversikt');

/* Row and Column Titles */
define('_BSQ_TOTAL', 'Totalt');
define('_BSQ_TODAY', 'I dag');
define('_BSQ_WEEK', 'Uke');
define('_BSQ_MONTH', 'Måned');
define('_BSQ_YEAR', 'År');
define('_BSQ_COUNT', 'Antall');
define('_BSQ_HITS', 'Hits');
define('_BSQ_DATE', 'Dato');
define('_BSQ_HOURS', 'Timer');
define('_BSQ_SUMMARY', 'Oversikt');
define('_BSQ_LATESTVISITORS', 'Siste Besøk');
define('_BSQ_RESOURCEFREQ', 'Hyppighet');
define('_BSQ_RESOURCE', 'Resurs');
define('_BSQ_RESOURCES', 'Resurser');
define('_BSQ_BROWSER', 'Nettleser');
define('_BSQ_BROWSERS', 'Nettlesere');
define('_BSQ_BROWSERFREQ', 'Nettleser Hyppighet');
define('_BSQ_REFERER', 'Referent');
define('_BSQ_REFERERS', 'Referenter');
define('_BSQ_RECENTREFERERS', 'Siste Referenter');
define('_BSQ_REFERERFREQ', 'Referent Hyppighet');
define('_BSQ_DOMAIN', 'Domene');
define('_BSQ_DOMAINS', 'Domener');
define('_BSQ_DOMAINFREQ', 'Domene Hyppighet');
define('_BSQ_LANGUAGE', 'Språk');
define('_BSQ_LANGUAGES', 'Språk');
define('_BSQ_LANGUAGEFREQ', 'Språk Hyppighet');
define('_BSQ_KEYWORDS', 'Nøkkelord');
define('_BSQ_KEYWORDFREQ', 'Nøkkelord Hyppighet');
define('_BSQ_TOTALHITS', 'Treff Totalt');
define('_BSQ_UNIQUEVISITORS', 'Unike Besøk');
define('_BSQ_HITSTODAY', 'Treff i dag');
define('_BSQ_UNIQUEVISITORSTODAY', 'Unike IP i dag');
define('_BSQ_VIEWSINWINDOW', "Visninger siden %s pr %d sekunder");
define('_BSQ_AVERAGEHITSPERIP', 'Gjennomsnitt treff/ip');
define('_BSQ_PLATFORM', 'Plattform');
define('_BSQ_PLATFORMFREQ', 'Plattform Hyppighet');
define('_BSQ_CLIENTIP', 'Klient IP');
define('_BSQ_NOMATCHINGROWS', 'Ingen Identiske Rader');
define('_BSQ_SITESTATSSUMMARY', 'Statistikk Oversikt');
define('_BSQ_VISITORS', 'Besøkende');
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
define('_BSQ_CFGNOTWRITEABLE', 'Konfigurasjonsfilen er ikke skrivbar!');
define('_BSQ_SETTINGSSAVED', 'Innstillinger lagret');
define('_BSQ_INSTALLWORKED', 
           "<p>Dette er en statistikk komponent for Joomla som er laget for å være liten og lett.</p>\n" . 
	       "<p><strong><font color=\"red\">For at denne komponenten skal registrere treff, må du legge til koden nedenfor i index.php som tilhører den Joomla-malen du bruker (templates/Din-Mal/index.php).<br />
		   <u>Denne filen ble endret mellom versjon 1.3.0 og 1.4.0</u>.</font></strong></p>" .
	        '<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>');

/* Graphing Stuff */
define('_BSQ_NOTENOUGHFORLINECHART', 'Ikke nok data til å lage <strong>%s</strong> linje-graf.');
define('_BSQ_NOTENOUGHFORBARCHART', 'Ikke nok data til å lage <strong>%s</strong> stolpe-graf.');

define('_BSQ_BARCHARTNOTSUPPORTED', "<p>Stolpegraf er ikke støttet for:<strong>%s</strong>. Velg en annen type eller formater som tabular.</p>\n");	        
define('_BSQ_JPGRAPHMISSING', 'Du må innstallere komponenten JPGraph før du kan aktivere grafer i BSQ Sitestats');
define('_BSQ_MUSTENABLEGRAPH', 'Du må aktivere grafikk i inntillingene til komponenten BSQ Sitestats');
define('_BSQ_HITSPER', 'Treff Pr');
define('_BSQ_MINUTE', 'Minutt');
define('_BSQ_MINUTES', 'Minutter');
define('_BSQ_HOUR', 'Time');
define('_BSQ_DAY', 'Dag');
define('_BSQ_DAYS', 'Dager');
define('_BSQ_WEEKS', 'Uker');
define('_BSQ_GRAPHWIDTH', 'Grafikk Bredde');
define('_BSQ_GRAPHWIDTHDESC', 'Bredde på grafikken som blir laget av JPGraph. Denne må ikke være større enn at den passer i malen din, men stor nok til at du kan se alt.');
define('_BSQ_GRAPHHEIGHT', 'Graikk Høyde');
define('_BSQ_GRAPHHEIGHTDESC', 'Høyden på grafikken som blir laget av JPGraph');
define('_BSQ_GRAPHFORCOMPONENT', 'Grafikk Komponent');
define('_BSQ_GRAPHFORCOMPONENTDESC', 'Bruk JPGraph til å lage grafer for komponent-rapporter som støtter dette.');
define('_BSQ_GRAPHCACHETIME', 'Intervall for Mellomlagring');
define('_BSQ_GRAPHCACHETIMEDESC', 'Hvor lang tid grafen skal mellomlagres som midlertidige filer. Denne må være stor fordi det trengs mye CPU-tid for å lage grafer.');
define('_BSQ_VISITORSGRAPHINTERVAL', 'Besøkende Graf Hyppighet');
define('_BSQ_VISITORSGRAPHINTERVALDESC', 'Tids-intervall mellom klikkene til hver gjest som skal legges til grunn for en graf. Et klikk er et punkt på X-akselen.');
define('_BSQ_BARCHARTVALUECOLOR', 'Stolpe-Verdi Farge');
define('_BSQ_BARCHARTVALUECOLORDESC', 'Farge på den numeriske verdien på høyre side av hver stolpe i en Stolpegraf. En HTML farge, som starter med # og inneholder seks siffer.');
define('_BSQ_BARCHARTFILLCOLOR', 'Stolpe Farge');
define('_BSQ_BARCHARTFILLCOLORDESC', 'Hvilken farge skal det være på stolpene i en stolpegraf? En HTML farge, starter med # og inneholder seks siffer.');

/* Back-end configuration stuff */
define('_BSQ_GRAPHING', 'Grafikk');
define('_BSQ_ENABLEGRAPHING', 'Aktiver Grafer');
define('_BSQ_ENABLEGRAPHINGDESC', 'Aktiver funksjonen for å lage grafer i BSQ Sitestats. Dette er avhengig av komponenten JPGraph.');
define('_BSQ_GRAPHTIMEFORMAT', 'Tids Format');
define('_BSQ_GRAPHTIMEFORMATDESC', 'dato() kompatible strenger for hvordan tider skal vises i en graf.'); 
define('_BSQ_GRAPHDATEFORMAT', 'Dato Format');
define('_BSQ_GRAPHDATEFORMATDESC', 'dato() kompatible strenger for hvordan datoer skal vises i en graf.'); 
define('_BSQ_REPORTING', 'Rapportering');
define('_BSQ_COMPRESSION', 'Komprimering');
define('_BSQ_HITTRACKING', 'Treff-Logging');
define('_BSQ_TRACKHITS', 'Logge Treff?');
define('_BSQ_TRACKHITSDESC', 'Skal vi loggføre treff i det hele tatt? Velg NEI for å deaktivere bsq_sitestats');
define('_BSQ_DEBUGQUERIES', 'Feilsøk Spørringer');
define('_BSQ_DEBUGQUERIESDESC', 'Vis spørringer på siden i stedet for å sende dem til databasen (nyttig for feilsøking)');
define('_BSQ_IPTOCOUNTRY', 'Finn Land ut i fra IP');
define('_BSQ_IPTOCOUNTRYDESC', 'Skal vi konvertere IP-adresser til landsnavn? (1 ekstra <strong>treg</strong> spørring pr treff)');
define('_BSQ_DOKEYWORDSNIFF', 'Logge Søkemotorer');
define('_BSQ_DOKEYWORDSNIFFDESC', 'Skal vi logge søkemotor-strenger? (2 spørringer pr sidelasting)');
define('_BSQ_COMPRESSAGE', 'Minimum Komprimerings Alder');
define('_BSQ_COMPRESSAGEDESC', 'Hvor gammel skal statistikken være før den blir komprimert?');
define('_BSQ_HITSPERCOMPRESS', 'Treff Pr Komprimering');
define('_BSQ_HITSPERCOMPRESSDESC', 'Hvor mange treff skal komprimeres i hver komprimering. For høy verdi kan gjøre at skriptet gir timeout.');
define('_BSQ_CACHETIME', 'Mellomlagring Tid');
define('_BSQ_CACHETIMEDESC', 'Hvor lenge skal komponent resultater mellomlagres som midlertidige filer?');
define('_BSQ_ROWSPERREPORT', 'Rader Pr Rapport');
define('_BSQ_ROWSPERREPORTDESC', 'Antall rader pr rapport. Høyere verdi vil gjøre at sidene bruker lengre tid på å laste, og vil bruke mer database-ressurser');
define('_BSQ_CSSPREPEND', 'CSS Prefiks');
define('_BSQ_CSSPREPENDDESC', 'Hva skal alle BSQ Sitestats klasser starte med i databasen?');
define('_BSQ_DATEFORMAT', 'Dato Format');
define('_BSQ_DATEFORMATDESC', 'Skriv en dato() kompatibel streng for hvordan datoer skal formateres.');
define('_BSQ_USEINTERNALCSS', 'Bruk Intern CSS');
define('_BSQ_USEINTERNALCSSDESC', 'Bruk den inkluderte bsq_sitestats.css filen for å formatere. Dette overstyrer malens CSS fil.');
define('_BSQ_USEDAYBOUNDARY', 'Bruk Dags-Porsjoner');
define('_BSQ_USEDAYBOUNDARYDESC', 'Når det blir laget periodisk statistikk, for eksempel daglig, ukentlig, eller månedlig, samle alt i daglige avsnitt.');
define('_BSQ_REPORTHOURSOFFSET', 'Rapportens Tids-Offset');
define('_BSQ_REPORTHOURSOFFSETDESC', 'Tidsavvik i timer i rapporten i forhold til serverens tid. Hvis serverens tid er en time tidligere enn tiden hos deg, velger du \'-1 Timer\'');
define('_BSQ_FRONTEND', 'Front End');
define('_BSQ_SHOWONFRONTEND', 'Show the following reports on the component Front End:');
define('_BSQ_VISITORGRAPH', 'Visitor Graph');
define('_BSQ_SHOWUSERSAS', 'Show Users As');
define('_BSQ_SHOWUSERSASDESC', 'How do display users on reports. This can be the user ID, the user\'s login name, or the user\'s nickname');
define('_BSQ_ID', 'ID');
define('_BSQ_USERNAME', 'Username');
define('_BSQ_NICKNAME', 'Nickname');

/* Stats compression stuff */
define('_BSQ_SITESTATSCOMPRESSION', 'BSQ Sitestats Komprimering');
define('_BSQ_COMPRESSCLICKAGAIN', "<p>Klikk på denne menyen igjen for å komprimere flere rader.</p>\n");

/* Help stuff */
define('_BSQ_SHOWWELCOME', '
	<div style="font-size: 14px; text-align: left; width: 760px;">
	<h1>BSQ Sitestats</h1>
	<table>
		<tr<td colspan="2" style="font-size: 14px; font-weight: bolder;">BSQ Sitestats Teamet</td></tr>
		<tr><td width="100">Brent Stolle</td><td>Hoved Utvikler</td></tr>
		<tr><td width="100">Michiel Bijland</td><td>Utvikler</td></tr>
		<tr><td width="100">Markus Rüping</td><td>Oversetter (Tysk)</td></tr>
		<tr><td width="100">Dennis Pleiter</td><td>Oversetter (Nederlandsk)</td></tr>
		<tr><td width="100">Trond Bratli</td><td>Oversetter (Norwegian)</td></tr>		
	</table>
	<p>Dette er GRATIS software. Det kan distribueres under vilkårene i GNU/GPL Lisensen<br />
	Se <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a> GNU/GPL for detaljer.</p>
	
	<p>Hvis du bruker hele eller deler av denne softwaren for å lage ditt eget prosjekt, vennligst lag en referanse til BSQ Sitestats
	et eller annet sted i koden din og legg til en link til http://www.bs-squared.com</p>

	<p>BSQ Sitestats er basert på og laget for å brukes ved siden av Shaun Inman\'s <b>ShortStat</b>
	<a href="http://www.shauninman.com/" target="_blank">http://www.shauninman.com/</a></p>
	<p>Brent kan kontaktes på <a href="mailto:dev@bs-squared.com">dev@bs-squared.com</a> eller på <a href="http://www.bs-squared.com/mambo/index.php" target="_blank">http://www.bs-squared.com/</a></p>
	<hr width="100%" size="1px">
	</div>
        ');

define('_BSQ_SHOWHELPTEXT', '
		<div style="font-size: 14px; text-align: left; width: 760px;">
			<h3>BSQ Sitestats</h3>
			<p>For å aktivere <strong>BSQ Sitestats</strong> på dine Joomla sider, legg til linjene nedenfor i din mals index.php eller den HTML-filen som brukes som oppstartsfil:</p>
			<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>
			<p>Får å utføre statistikk-komprimering automatisk, legg til følgende som en cron jobb på serveren:</p>');
define('_BSQ_SHOWHELPTEXT2', '			
			<p>For Personlig Hjelp, vennligst besøk <a href="http://www.bs-squared.com/forum" target="_blank">BS-Squared</a> forumet.</p>
			<hr width="100%" size="1px">
		</div>
		');

/* IP 2 Country */
define('_BSQ_IMPORTCOUNTRIESWORKED', 'IP til Landsnavn CSV filen ble importert');
define('_BSQ_IMPORTCOUNTRIES',
                 "<h3>Hvordan importere IP til Landsnavn data:</h3><p>\n" .
  			 	 "1. Last ned den siste iptocountry CSV filen <a target=\"_blank\" ".
  			 	 "href=\"http://ip-to-country.webhosting.info/downloads/ip-to-country.csv.zip\">her</a>.<br />\n" .
  			 	 "2. Pakk ut .csv filen til <strong>");
define('_BSQ_IMPORTCOUNTRIES2',
  			 	 "</strong><br />\n" .
  			 	 "3. Kjør dette skriptet igjen. Det vil ta omtrent et minutt å importere, avhengig av hvor rask din database server er.</p>\n"
				 );
				 

} /* BSQ_LANGUAGE */
?>