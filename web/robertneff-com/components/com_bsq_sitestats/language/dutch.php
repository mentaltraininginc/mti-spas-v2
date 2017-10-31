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
* @author Dennis Pleiter <info@pro-net.nl> (Dutch translation)
*/

if (!defined('BSQ_LANGUAGE')) {
define('BSQ_LANGUAGE', true);

/* General */
define('_BSQ_YES', 'Ja');
define('_BSQ_NO', 'Nee');

/* Report Titles */
define('_BSQ_SSS_TITLE', 'Site Stats Samenvatting');

/* Row and Column Titles */
define('_BSQ_TOTAL', 'Totaal');
define('_BSQ_TODAY', 'Vandaag');
define('_BSQ_WEEK', 'Week');
define('_BSQ_MONTH', 'Maand');
define('_BSQ_YEAR', 'Jaar');
define('_BSQ_COUNT', 'Totaal');
define('_BSQ_HITS', 'Hits');
define('_BSQ_DATE', 'Datum');
define('_BSQ_HOURS', 'Uren');
define('_BSQ_SUMMARY', 'Samenvatting');
define('_BSQ_LATESTVISITORS', 'Recente bezoekers');
define('_BSQ_RESOURCEFREQ', 'Doel Pagina\'s');
define('_BSQ_RESOURCE', 'Pagina');
define('_BSQ_RESOURCES', 'Pagina\'s');
define('_BSQ_BROWSER', 'Browser');
define('_BSQ_BROWSERS', 'Browsers');
define('_BSQ_BROWSERFREQ', 'Browser Teller');
define('_BSQ_REFERER', 'Bron');
define('_BSQ_REFERERS', 'Herkomst');
define('_BSQ_RECENTREFERERS', 'Recente Bronnen');
define('_BSQ_REFERERFREQ', 'Bron Pagina\'s');
define('_BSQ_DOMAIN', 'Domein');
define('_BSQ_DOMAINS', 'Domeinen');
define('_BSQ_DOMAINFREQ', 'Domeinen Teller');
define('_BSQ_LANGUAGE', 'Taal');
define('_BSQ_LANGUAGES', 'Talen');
define('_BSQ_LANGUAGEFREQ', 'Voorkomende Talen');
define('_BSQ_KEYWORDS', 'Zoekwoorden');
define('_BSQ_KEYWORDFREQ', 'Voorkomende Zoekwoord');
define('_BSQ_TOTALHITS', 'Hit Totaal');
define('_BSQ_UNIQUEVISITORS', 'Unieke Bezoekers');
define('_BSQ_HITSTODAY', 'Hits Vandaag');
define('_BSQ_UNIQUEVISITORSTODAY', 'Unieke IPs Vandaag');
define('_BSQ_VIEWSINWINDOW', "Kijkers sinds %s per %d seconden");
define('_BSQ_AVERAGEHITSPERIP', 'Gemiddeld Hits/ip');
define('_BSQ_PLATFORM', 'Platform');
define('_BSQ_PLATFORMFREQ', 'Platform Frequentie');
define('_BSQ_CLIENTIP', 'Bezoekers IP');
define('_BSQ_NOMATCHINGROWS', 'Geen Overeenkomende Rijen');
define('_BSQ_SITESTATSSUMMARY', 'Statistieken');
define('_BSQ_VISITORS', 'Bezoekers');
define('_BSQ_USER', 'Gebruiker');
define('_BSQ_USERS', 'Gebruikers');
define('_BSQ_USERFREQ', 'Bezoek Frequentie');
define('_BSQ_USERSRECENTHITS', 'Gebruiker\'s Recente Hits');
define('_BSQ_LONGITUDE', 'Lengte');
define('_BSQ_LATITUDE', 'Breedte');
define('_BSQ_HOSTNAME', 'Hostnaam');
define('_BSQ_CITY', 'Plaats');
define('_BSQ_COUNTRY', 'Land');
define('_BSQ_COUNTRYFLAG', 'Land Vlag');
define('_BSQ_DATABASEUPGRADED', 'Database is naar de laatste versie bijgewerkt');
define('_BSQ_DATABASEUPTODATE', 'Database reeds bijgewerkt');
define('_BSQ_NA', 'N/A');
define('_BSQ_IPADDRESS', 'IP Adres');
define('_BSQ_IPADDRESSLOOKUP', 'IP Adres Opzoeken');
define('_BSQ_USERSUSED', 'Gebruikers Verwerkt');
define('_BSQ_PRIVATEADDRESS', 'Prive Adres');
define('_BSQ_LASTNHITSFORIP', 'Laatste %d Hits voor IP');

/* Front-end general stuff */
define('_BSQ_ALLREPORTSDISABLED', '<i>Alle rapporten zijn uitgeschakeld door de administrator</i>');

/* Back-end general stuff */
define('_BSQ_CFGNOTWRITEABLE', 'Configuratie bestand niet schrijfbaar!');
define('_BSQ_SETTINGSSAVED', 'Configuratie Bijgewerkt');
define('_BSQ_INSTALLWORKED', 
           "<p>Dit is een lichtgewicht component voor Joomla voor het bijhouden van statistieken.</p>\n" . 
	       "<p><strong><font color=\"red\">De volgende code moet aan alle gebruikte Joomla template's worden toegevoegd in index.php.
		   <u>Deze code is veranderd tussen versie 1.3.0 en 1.4.0</u>.</font></strong></p>" .
	        '<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>');

/* Graphing Stuff */	        
define('_BSQ_NOTENOUGHFORLINECHART', 'Onvoldoende data voor een <strong>%s</strong> line chart.');
define('_BSQ_NOTENOUGHFORBARCHART', 'Onvoldoende data om een <strong>%s</strong> staaf diagram te genereren.');

define('_BSQ_BARCHARTNOTSUPPORTED', "<p>Staaf diagram niet ondersteund voor:<strong>%s</strong>. Kies een ander rapport of verander de weergave naar een tabel.</p>\n");	        
define('_BSQ_JPGRAPHMISSING', 'Het JPGraph component moet geinstalleerd en ingeschakeld zijn, voor grafieken in BSQ Sitestats');
define('_BSQ_MUSTENABLEGRAPH', 'Grafieken moet ingeschakeld zijn in BSQ Sitestats\' component instellingen');
define('_BSQ_HITSPER', 'Hits Per');
define('_BSQ_MINUTE', 'Minuut');
define('_BSQ_MINUTES', 'Minuten');
define('_BSQ_HOUR', 'Uren');
define('_BSQ_DAY', 'Dag');
define('_BSQ_DAYS', 'Dagen');
define('_BSQ_WEEKS', 'Weken');
define('_BSQ_GRAPHWIDTH', 'Grafiek Breedte');
define('_BSQ_GRAPHWIDTHDESC', 'Breedte van de afbeeldingen vanuit JPGraph. Breedte voldoende groot aanpassen aan de template.');
define('_BSQ_GRAPHHEIGHT', 'Grafiek Hoogte');
define('_BSQ_GRAPHHEIGHTDESC', 'Hoogte van de afbeeldingen vanuit JPGraph.');
define('_BSQ_GRAPHFORCOMPONENT', 'Graph Component');
define('_BSQ_GRAPHFORCOMPONENTDESC', 'Gebruik JPGraph voor het genereren van grafieken, voor rapporten die dit ondersteunen.');
define('_BSQ_GRAPHCACHETIME', 'Cache Tijd');
define('_BSQ_GRAPHCACHETIMEDESC', 'De tijd dat grafieken gecashed moeten blijven. Neem de tijd niet te kort, vanwege de belasting op de CPU.');
define('_BSQ_VISITORSGRAPHINTERVAL', 'Bezoekers Grafiek Interval');
define('_BSQ_VISITORSGRAPHINTERVALDESC', 'Tijd interval tussen punten op de X-as voor de bezoekers grafiek.');
define('_BSQ_BARCHARTVALUECOLOR', 'Staaf tekst kleur');
define('_BSQ_BARCHARTVALUECOLORDESC', 'Kleur van de waarde aan de rechter zeide van elke Staaf in een staaf diagram. HTML kleur, voorafgegaan door #.');
define('_BSQ_BARCHARTFILLCOLOR', 'Staaf Kleur');
define('_BSQ_BARCHARTFILLCOLORDESC', 'De kleur van de stafen in een staaf grafiek. HTML kleur, voorafgegaan door #.');

/* Back-end configuration stuff */
define('_BSQ_GRAPHING', 'Grafieken');
define('_BSQ_ENABLEGRAPHING', 'Grafieken Inschakelen');
define('_BSQ_ENABLEGRAPHINGDESC', 'Inschakelen van grafieken in BSQ Sitestats. Afhankelijk van het JPGraph component.');
define('_BSQ_GRAPHTIMEFORMAT', 'Tijd Formaat');
define('_BSQ_GRAPHTIMEFORMATDESC', 'String overeenkomstig aan PHP date(), voor tijd notatie in grafieken.'); 
define('_BSQ_GRAPHDATEFORMAT', 'Datum Formaat');
define('_BSQ_GRAPHDATEFORMATDESC', 'String overeenkomstig aan PHP date(), voor datum notatie in grafieken.'); 
define('_BSQ_REPORTING', 'Rapportage');
define('_BSQ_COMPRESSION', 'Compressie');
define('_BSQ_HITTRACKING', 'Traceren');
define('_BSQ_TRACKHITS', 'Registreer Hits?');
define('_BSQ_TRACKHITSDESC', 'Zet dit op nee om bsq_sitestats buiten werking te stellen');
define('_BSQ_DEBUGQUERIES', 'Debug Queries');
define('_BSQ_DEBUGQUERIESDESC', 'Toon queries op scherm in plaats van het uitvoeren op de database (debugging)');
define('_BSQ_IPTOCOUNTRY', 'Land zoeken bij IP');
define('_BSQ_IPTOCOUNTRYDESC', 'Aan de hand van het IP adres het land bepalen? (1 extra <strong>langzame</strong> query per Hit)');
define('_BSQ_DOKEYWORDSNIFF', 'Registreer Zoekmachines');
define('_BSQ_DOKEYWORDSNIFFDESC', 'Registreer zoekwoorden van zoek machines? (2 queries per pagina Hit)');
define('_BSQ_COMPRESSAGE', 'Min Compressie Leeftijd');
define('_BSQ_COMPRESSAGEDESC', 'Hoe oud moeten statistieken zijn voor dat ze worden gecomprimeerd?');
define('_BSQ_HITSPERCOMPRESS', 'Hits Per Compressie');
define('_BSQ_HITSPERCOMPRESSDESC', 'Hoeveel Hits worden er per compressie gecomprimeerd. Een te groot aantal kan een script timeout tot gevolg hebben.');
define('_BSQ_CACHETIME', 'Cache Tijd');
define('_BSQ_CACHETIMEDESC', 'Hoe lang moet het resultaat van dit component gecached blijven?');
define('_BSQ_ROWSPERREPORT', 'Rijen Per Rapport');
define('_BSQ_ROWSPERREPORTDESC', 'Aantal rijen per rapport. Heeft invloed op de laadtijd van de pagina en de belasting op de database');
define('_BSQ_CSSPREPEND', 'CSS Voorvoegsel');
define('_BSQ_CSSPREPENDDESC', 'Voorvoegsel in de CSS voor BSQ Sitestats classes?');
define('_BSQ_DATEFORMAT', 'Datum Formaat');
define('_BSQ_DATEFORMATDESC', 'Vul een datum formaat in, overeenkomstig aan PHP date().');
define('_BSQ_USEINTERNALCSS', 'Interne CSS gebruiken');
define('_BSQ_USEINTERNALCSSDESC', 'Gebruik de bijgevoegde bsq_sitestats.css in plaats van de template CSS.');
define('_BSQ_USEDAYBOUNDARY', 'Gebruik Dag Grens');
define('_BSQ_USEDAYBOUNDARYDESC', 'Bij periodieke stats zoals per dag, week, of maand, telling starten bij overgang van de dag ipv. de afgelopen 24 uur.');
define('_BSQ_REPORTHOURSOFFSET', 'Tijd Offset');
define('_BSQ_REPORTHOURSOFFSETDESC', 'Tijd verschil lokale tijd en server tijd. Als de server 1 uur voorloopt op de lokale tijd, kies \'-1 Uur\'');
define('_BSQ_FRONTEND', 'Front End');
define('_BSQ_SHOWONFRONTEND', 'Toon de volgende rapporten in het Front End component:');
define('_BSQ_VISITORGRAPH', 'Bezoekers Grafiek');
define('_BSQ_SHOWUSERSAS', 'Toon Gebruikers Als');
define('_BSQ_SHOWUSERSASDESC', 'Hoe gebruikers weer te geven in rapporten, gebruikers ID, login naam of nickname.');
define('_BSQ_ID', 'ID');
define('_BSQ_USERNAME', 'Naam');
define('_BSQ_NICKNAME', 'Nickname');

/* Stats compression stuff */
define('_BSQ_SITESTATSCOMPRESSION', 'BSQ Sitestats Compressie');
define('_BSQ_COMPRESSCLICKAGAIN', "<p>Open het menu opnieuw om meer rijen te comprimeren.</p>\n");

/* Help stuff */
define('_BSQ_SHOWWELCOME', '
	<div style="font-size: 14px; text-align: left; width: 760px;">
	<h1>BSQ Sitestats</h1>
	<table>
		<tr<td colspan="2" style="font-size: 14px; font-weight: bolder;">Het BSQ Sitestats Team</td></tr>
		<tr><td width="100">Brent Stolle</td><td>Hoofd Ontwikkeling</td></tr>
		<tr><td width="100">Michiel Bijland</td><td>Ontwikkelaar</td></tr>
		<tr><td width="100">Markus Rüping</td><td>Vertaler (German)</td></tr>
		<tr><td width="100">Dennis Pleiter</td><td>Vertaler (Dutch)</td></tr>
		<tr><td width="100">Trond Bratli</td><td>Translator (Norwegian)</td></tr>
	</table>
	<p>Deze software is VRIJ. Svp. distribueren volgens de regels vastgelegd in de GNU/GPL Licentie.<br />
	Zie <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a> GNU/GPL voor details.</p>
	
	<p>Als u een afsplitsing creëert van dit project, refereer dan svp. aan BSQ_Sitestats
	ergens in uw code middels een link naar http://www.bs-squared.com</p>

	<p>BSQ_Sitestats is gebaseerd op en kan worden uitgevoerd in combinatie met Shaun Inman\'s <b>ShortStat</b>
	<a href="http://www.shauninman.com/" target="_blank">http://www.shauninman.com/</a></p>
	<p>U kunt in contact treden middels <a href="mailto:dev@bs-squared.com">dev@bs-squared.com</a> of via <a href="http://www.bs-squared.com/mambo/index.php" target="_blank">http://www.bs-squared.com/</a></p>
	<hr width="100%" size="1px">
	</div>
	');

define('_BSQ_SHOWHELPTEXT', '
		<div style="font-size: 14px; text-align: left; width: 760px;">
			<h3>BSQ Sitestats</h3>
			<p>Om gebruik te kunnen maken van <strong>BSQ Sitestats</strong> dient de volgende code aan alle gebruikte Joomla template\'s te worden toegevoegd in index.php.</p>
			<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>
			<p>Om compressie van statistieken te automatiseren dient de volgende cron taak te worden aangemaakt:</p>');
define('_BSQ_SHOWHELPTEXT2', '			
			<p>Voor hulp zie de forums op <a href="http://www.bs-squared.com/forum" target="_blank">BS-Squared</a>.</p>
			<hr width="100%" size="1px">
		</div>
		');

/* IP 2 Country */
define('_BSQ_IMPORTCOUNTRIESWORKED', 'Importeren van IP naar Land CSV bestand succesvol');
define('_BSQ_IMPORTCOUNTRIES',
                 "<h3>Importeren van IP naar Land data:</h3><p>\n" .
  			 	 "1. Haal <a target=\"_blank\" href=\"http://ip-to-country.webhosting.info/downloads/ip-to-country.csv.zip\">hier</a> het laatste iptocountry CSV bestand.<br />\n" .
  			 	 "2. Pak het .csv bestand uit naar <strong>");

define('_BSQ_IMPORTCOUNTRIES2',  			 	 
  			 	 "</strong><br />\n" .
  			 	 "3. Voer dit script opnieuw uit. Import kan enige tijd in beslag nemen afhankelijk van de database server.</p>\n"
				 );
				 
/* Ip2City */
define('_BSQ_CANTOPENFORREADING', "Kan het bestand '%s' niet lezen.");
define('_BSQ_CANTFOPENURLS', 'Deze server kan geen URLs openen middels fopen(), dit is noodzakelijk voor Ip2City. Zet <b>allow_url_fopen</b>=true in php.ini');
define('_BSQ_FLAGFORUSERSCOUNTRY', 'Vlag voor Gernuikers Land');
define('_BSQ_IPTOSEARCHFOR', 'Opzoeken van IP Adres voor:');
define('_BSQ_PLEASESPECIFYANIP', 'Vul een IP adres in.');
define('_BSQ_LOOKUPIP', 'Opzoeken IP');

} /* BSQ_LANGUAGE */		
?>
