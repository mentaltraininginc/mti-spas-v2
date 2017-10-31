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
* IpToCountry management for BSQ_Sitestats
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle
*
*/

/* ensure this file is being included by a parent file */
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

require_once('bsqstatcompress.class.php'); //Assumes same folder

/**
 * Populate the IpToCountry table from a CSV file obtained from http://www.ip-to-country.com/
 *
 * @param string $csvFileLoc Absolute location of the .csv file
 *
 * @return string null if went ok. Error string on error.
 */
function bsq_ip2country_fillFromCSV($csvFileLoc)
{
	global $database;
	
	if (!$csvFileLoc)
		return 'Missing .csv filename.';
		
	$handle = @fopen($csvFileLoc, 'r');
	if (!$handle)
		return "Unable to open '$csvFileLoc'";
	
	$query = "TRUNCATE TABLE #__bsq_iptocountry";
	$database->setQuery($query);
	$database->query();
		
	$currentRow = 0;
	while (is_array($row = fgetcsv($handle, 1000, ',')))
	{
		$currentRow++;
		
		if (count($row) != 5) {
			continue;
		}
		
		//Make the name database-safe
		$row[4] = $database->getEscaped($row[4]);
		
		$query = 'INSERT INTO #__bsq_iptocountry VALUES(\''.
		          $row[0].'\',\''.$row[1].'\',\''.$row[2].'\',\''.$row[3].'\',\''.$row[4].'\')';

		$database->setQuery($query);
		$database->query(); 
	}
	
	@fclose($handle);
	return null;
}

/**
 * Determines the viewers country based on their ip address.
 * 
 * @param string $ip IP Address to convert to a country code
 *
 * @return string country name
 */
function bsq_ip2country_getCountryForIP($ip) 
{
	global $database;
	
	$ip = sprintf("%u",ip2long($ip));
	
	$query = "SELECT country_name FROM #__bsq_iptocountry
			  WHERE ip_from <= $ip AND
			  ip_to >= $ip";
		
	$database->setQuery($query, 0, 1);
	$countryName = $database->loadResult();

	if (!$countryName) {
		return '';
	}
	else {
		return trim(ucwords(preg_replace("/([A-Z\xC0-\xDF])/e","chr(ord('\\1')+32)", $countryName)));
	}
}

/**
 * Fill in the hits and smallhits country tables based on their IPs
 *
 * @return integer Number of ips that have been converted to countries from
                   both the hits and smallhits tables. 
 */

function bsq_ip2country_fillInCountries()
{
	global $database;
	
	$converted = 0;
	
	//First, convert the hits table.
	$query = "SELECT DISTINCT remote_ip FROM #__bsq_hit 
	          WHERE country=''";
	$database->setQuery($query);
	$rows = $database->loadRowList();
	
	foreach ($rows as $row) {
		$ip = $row['remote_ip'];
		$country = bsq_ip2country_getCountryForIP($ip);
		
		if (!strlen($country)) {
			continue; //No point in updating it if the record didn't convert
		}
		
		$query = "UPDATE #__bsq_hit SET country='$country' 
		          WHERE remote_ip='$ip'";
		$database->setQuery($query);
		$database->query();
		$converted++;
	}
	
	//Then, convert the smallhits table. Since this table row is actually a foreign
	//key to the country table
	
	$query = "SELECT DISTINCT ip FROM #__bsq_smallhit
	          WHERE countryID='0'";
	$database->setQuery($query);
	$rows = $database->loadRowList();
	
	foreach ($rows as $row) {
		$ip = $row['ip'];
		$country = bsq_ip2country_getCountryForIP($ip);
		if (!strlen($country)) {
			continue; //Country not found
		}
		
		$countryID = BSQSitestatsCompress::AddStringTableRef('#__bsq_country', $country, 'countryID');
		
		$query = "UPDATE #__bsq_smallhit SET countryID='$countryID'
		          WHERE ip='$ip'";
		$database->setQuery($query);
		$database->query();
		$converted++;
	}
	
	return $converted;
}

?>