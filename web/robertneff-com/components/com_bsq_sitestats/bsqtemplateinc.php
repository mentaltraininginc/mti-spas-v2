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
* bsq_sitestats Class
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle <dev@bs-squared.com>
*
*/

//ensure this file is being included by a parent file
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');


include($mosConfig_absolute_path . '/administrator/components/com_bsq_sitestats/bsqglobals.inc.php');
require_once($bsqClassPath.'/bsqip2country.php');
	
$bsqSiteStat = new BSQSitestatsHit();	
$bsqSiteStat->RegisterHit();

class BSQSitestatsHit
{
	var $db;
	
	//Config parameters
	var $debugQueries;
	var $doKeywordSniffing;
	var $doIpToCountry;
	var $trackHits;
	
	/**
	* BSQ_Sitestats
	* Constructor.
	*/
	function BSQSitestatsHit() 
	{
		global $bsq_sitestats_debugQueries, $bsq_sitestats_doIpToCountry, $bsq_sitestats_doKeywordSniffing,
		       $bsq_sitestats_trackHits;
		
		//config values
		$this->doKeywordSniffing = $bsq_sitestats_doKeywordSniffing;
		$this->debugQueries = $bsq_sitestats_debugQueries;
		$this->doIpToCountry = $bsq_sitestats_doIpToCountry; 
		$this->trackHits = $bsq_sitestats_trackHits;
	}
	
	/**
	* RegisterHit
	* Call this to insert a "hit" into the database for whatever page
	* we're on.
	*
	*/
	function RegisterHit()
	{
		global $database, $my;
		
		if(!$this->trackHits) {
			return;
		}
			
		$ip	= $_SERVER['REMOTE_ADDR'];
		if ($this->doIpToCountry) {
			$cntry = bsq_ip2country_getCountryForIP($ip);
		}
		else {
			$cntry	= '';
		}
		$lang = $this->DetermineLanguage();
		if (isset($_SERVER['HTTP_REFERER'])) {
			$ref	= $_SERVER['HTTP_REFERER'];
			$url 	= parse_url($ref);
			$domain	= eregi_replace("^www.","",$url['host']);
		}
		else {
			$ref = '';
			$url = array();
			$domain = '';
		}
		
		$res	= $this->GetCleanURI();
		$ua		= $_SERVER['HTTP_USER_AGENT'];
		$br		= $this->ParseUserAgent($ua);
		$dt		= time();
		$myId   = isset($my->id) ? $my->id : '';
		
		if ($this->doKeywordSniffing) {
			$this->SniffKeywords($url);
		}
			
		$query = "INSERT INTO #__bsq_hit (remote_ip,country,language,domain,referer,resource,user_agent,platform,browser,version,dt, user_id) 
				  VALUES ('$ip','$cntry','$lang','$domain','$ref','$res','$ua','$br[platform]','$br[browser]','$br[version]',$dt, '$myId')";
		
		if($this->debugQueries)
			$this->DebugQuery($query);
		else
		{
			$database->setQuery($query);		
			$database->query();
		}
	}
	
	/**
	* Debug Query
	* Print out a query when in debug mode.
	*
	* @param string Query string
	* @return Nothing.
	*/
	function DebugQuery($query)
	{
		echo "<b>BSQ_sitestats Query</b>: $query<br />\n";
	}
	
	/**
	* SniffKeywords 
	* Find search engine keywords and insert them into 
	*
	* @param array $url An array created by parse_url($ref)
	* @return Nothing.
	*/
	function SniffKeywords($url) 
	{
		global $database;
		
		if (!isset($url['host'])) {
			return;
		}
		
		// Check for google first
		if (preg_match("/google\./i", $url['host'])) 
		{
			parse_str($url['query'],$q);
			// Googles search terms are in "q"
			$searchterms = $q['q'];
		}
		else if (preg_match("/alltheweb\./i", $url['host'])) 
		{
			parse_str($url['query'],$q);
			// All the Web search terms are in "q"
			$searchterms = $q['q'];
		}
		else if (preg_match("/yahoo\./i", $url['host'])) 
		{
			parse_str($url['query'],$q);
			// Yahoo search terms are in "p"
			$searchterms = $q['p'];
		}
		else if (preg_match("/search\.aol\./i", $url['host'])) 
		{
			parse_str($url['query'],$q);
			// Yahoo search terms are in "query"
			$searchterms = $q['query'];
		}
		else if (preg_match("/search\.msn\./i", $url['host'])) 
		{
			parse_str($url['query'],$q);
			// MSN search terms are in "q"
			$searchterms = $q['q'];
		}
		
		if (isset($searchterms) && !empty($searchterms)) 
		{
			// Remove BINARY from the SELECT statement for a case-insensitive comparison
			$exists_query = "SELECT id FROM #__bsq_searchterms WHERE searchterms = BINARY '$searchterms'";
			
			if($this->debugQueries)
			{
				$this->DebugQuery($exists_query);
				$exists = false;
			}
			else
			{
				$database->setQuery($exists_query);
				$exists = $database->loadResult();
			}
			
			if ($exists !== null) 
			{
				$query = "UPDATE #__bsq_searchterms SET count = (count+1) WHERE id = '$exists'";
				if($this->debugQueries)
					$this->DebugQuery($query);
				else
				{
					$database->setQuery($query);		
					$database->query();
				}
			}
			else 
			{
				$query = "INSERT INTO #__bsq_searchterms (searchterms,count) VALUES ('$searchterms',1)";
				if($this->debugQueries)
					$this->DebugQuery($query);
				else
				{
					$database->setQuery($query);		
					$database->query();
				}
			}
		}
	}
	/**
	* DetermineLanguage
	* Guess the language of the client, based on the HTTP_ACCEPT_LANGUAGE
	* of the client.
	*
	* @return string Language string or "empty" if it can't be matched. 
	*/
	function DetermineLanguage() 
	{
		global $_SERVER;
		if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) 
		{
			// Capture up to the first delimiter (, found in Safari)
			preg_match("/([^,;]*)/",$_SERVER["HTTP_ACCEPT_LANGUAGE"], $langs);
			$lang_choice=$langs[0];
		}
		else  
			$lang_choice="empty"; 

		return $lang_choice;
	}
	
	/**
	* ParseUserAgent() 
	* Attempts to suss out the browser info from its user agent string.
 	* It is possible to spoof a string though so don't blame me if 
 	* something doesn't seem right. This will need updating as newer 
 	* browsers are released. 
 	*
	* @return array of items that describe the browser of the client:
	* 		  platform, browser, version, majorver, minorver 
	*/
	function ParseUserAgent($ua) 
	{
		$browser['platform']	= "Indeterminable";
		$browser['browser']		= "Indeterminable";
		$browser['version']		= "Indeterminable";
		$browser['majorver']	= "Indeterminable";
		$browser['minorver']	= "Indeterminable";
		
		// Test for platform
		if (eregi('Win',$ua)) 
			$browser['platform'] = "Windows";
		else if (eregi('Mac',$ua))
			$browser['platform'] = "Macintosh";
		else if (eregi('Linux',$ua))
			$browser['platform'] = "Linux";
		
		// Test for browser type
		if (eregi('Mozilla/4',$ua) && !eregi('compatible',$ua))
		{
			$browser['browser'] = "Netscape";
			eregi('Mozilla/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Mozilla/5',$ua) || eregi('Gecko',$ua)) 
		{
			$browser['browser'] = "Mozilla";
			eregi('rv(:| )([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[2];
		}
		if (eregi('Safari',$ua)) 
		{
			$browser['browser'] = "Safari";
			$browser['platform'] = "Macintosh";
			eregi('Safari/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
			
			if (eregi('125',$browser['version'])) 
			{
				$browser['version'] 	= 1.2;
				$browser['majorver']	= 1;
				$browser['minorver']	= 2;
			}
			else if (eregi('100',$browser['version'])) 
			{
				$browser['version'] 	= 1.1;
				$browser['majorver']	= 1;
				$browser['minorver']	= 1;
			}
			else if (eregi('85',$browser['version'])) 
			{
				$browser['version'] 	= 1.0;
				$browser['majorver']	= 1;
				$browser['minorver']	= 0;
			}
			else if ($browser['version']<85)
				$browser['version'] 	= "Pre-1.0 Beta";
		}
		if (eregi('iCab',$ua)) 
		{
			$browser['browser'] = "iCab";
			eregi('iCab/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Firefox',$ua)) 
		{
			$browser['browser'] = "Firefox";
			eregi('Firefox/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Firebird',$ua)) 
		{
			$browser['browser'] = "Firebird";
			eregi('Firebird/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Phoenix',$ua)) 
		{
			$browser['browser'] = "Phoenix";
			eregi('Phoenix/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Camino',$ua)) 
		{
			$browser['browser'] = "Camino";
			eregi('Camino/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Chimera',$ua)) 
		{
			$browser['browser'] = "Chimera";
			eregi('Chimera/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Netscape',$ua)) 
		{
			$browser['browser'] = "Netscape";
			eregi('Netscape[0-9]?/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('MSIE',$ua)) 
		{
			$browser['browser'] = "Internet Explorer";
			eregi('MSIE ([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Opera',$ua)) 
		{
			$browser['browser'] = "Opera";
			eregi('Opera( |/)([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[2];
		}
		if (eregi('OmniWeb',$ua)) 
		{
			$browser['browser'] = "OmniWeb";
			eregi('OmniWeb/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Konqueror',$ua)) 
		{
			$browser['platform'] = "Linux";
	
			$browser['browser'] = "Konqueror";
			eregi('Konqueror/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Crawl',$ua) || eregi('bot',$ua) || eregi('slurp',$ua) || eregi('spider',$ua))
			$browser['browser'] = "Crawler/Search Engine";
		if (eregi('Lynx',$ua)) 
		{
			$browser['browser'] = "Lynx";
			eregi('Lynx/([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		if (eregi('Links',$ua)) 
		{
			$browser['browser'] = "Links";
			eregi('\(([[:digit:]\.]+)',$ua,$b);
			$browser['version'] = $b[1];
		}
		
		// Determine browser versions
		if ($browser['browser']!='Safari' && $browser['browser'] != "Indeterminable" && $browser['browser'] != "Crawler/Search Engine" && $browser['version'] != "Indeterminable")
		{
			// Make sure we have at least .0 for a minor version
			$browser['version'] = (!eregi('\.',$browser['version']))?$browser['version'].".0":$browser['version'];
			
			eregi('^([0-9]*).(.*)$',$browser['version'],$v);
			$browser['majorver'] = $v[1];
			$browser['minorver'] = $v[2];
		}
		if (empty($browser['version']) || $browser['version']=='.0') 
		{
			$browser['version']		= "Indeterminable";
			$browser['majorver']		= "Indeterminable";
			$browser['minorver']		= "Indeterminable";
		}
		
		return $browser;
	}
	
	/**
	 * Clean and return the request URI
	 *
	 */
	function GetCleanURI()
	{
		global $mosConfig_live_site;
		
		$uri = $_SERVER['REQUEST_URI'];
		
		$parsed = parse_url($mosConfig_live_site);
		$defaultURI = $parsed['path'].'/index.php';
		
		/* this will go no problem what so ever just eleminates faulty urls wich end with benign characters */
		$uri = rtrim($uri, '?&');
		
		/* If we have the root site without /index.php, make it /index.php */
		if (rtrim($uri,'/') == $parsed['path']) {
			$uri = $defaultURI;
		}
		
		return $uri;
	}
}
?>