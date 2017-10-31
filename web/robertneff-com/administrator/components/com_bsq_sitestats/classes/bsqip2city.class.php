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

class BSQIp2City
{
	var $errorText = null;
	var $isPossible = null;
	var $ip = null;
	var $rpcUrl = null;
	var $flagUrl = null;
	
	var $rawString = '';
	var $latitude;
	var $longitude;
	var $city;
	var $country;
	
	
	var $rpcBaseUrl = "http://api.hostip.info/get_html.php?ip=%s&position=true";
	var $flagBaseUrl = "http://api.hostip.info/flag.php?ip=%s";
	var $sockReadSize = 8192;
	
	/**
	 * Standard constructor
	 *
	 * @param string $ip IP Address to lookup
	 *
	 */
	function BSQIp2City($ip)
	{
		$this->isPossible = true;
		$this->errorText = '';
		$this->ip = $ip;
		
		if(!$this->ip) {
			die('Missing IP parameter for BSQIp2City()');
		}
		
		$this->rpcUrl = sprintf($this->rpcBaseUrl, $this->ip);
		$this->flagUrl = sprintf($this->flagBaseUrl, $this->ip);
		
		$this->isPossible = (bool)ini_get('allow_url_fopen');
	}
	
	
	/**
	 * Fetch the Ip2City information. After this call, member variables latitude, longitude, city, and country will be set.
	 *
	 * @return boolean TRUE on success. FALSE on failure. $this->errorText will contain an error string on error.
	 *
	 */
	function fetch()
	{
		if (!$this->isPossible) {
			$this->errorText = _BSQ_CANTFOPENURLS;
			return false;
		}
		
		$handle = @fopen($this->rpcUrl, 'r');
		if ($handle===false) {
			$this->errorText = sprintf(_BSQ_CANTOPENFORREADING, $this->rpcUrl);
			return false;
		}
		
		
		/* Read the data, 8k at a time */
		$contents = '';
		while (!feof($handle)) {
  			$contents .= fread($handle, $this->sockReadSize);
		}
		fclose($handle);
		$this->rawString = $contents;
		
		/* Read the values */
		$contentsArr = split("\n", $contents);
		$this->country = trim(substr($contentsArr[0], 8));
		$this->city = trim(substr($contentsArr[1], 6));
		sscanf($contentsArr[2], "Latitude: %f\n", $this->latitude);
		sscanf($contentsArr[3], "Longitude: %f\n", $this->longitude);
		
		
		/* Filter and translate the values */
		if ($this->country == '(Unknown Country?) (XX)') {
			$this->country = _BSQ_NA;
		}
		else if ($this->country == '(Private Address) (XX)') {
			$this->country = _BSQ_PRIVATEADDRESS;	
		}
		
		if ($this->city == '(Unknown city)' || $this->city == '(Unknown City?)') {
			$this->city = _BSQ_NA;
		}
		else if ($this->city == '(Private Address)') {
			$this->city = _BSQ_PRIVATEADDRESS;
		}
		
		if (!$this->latitude) {
			$this->latitude = _BSQ_NA;
		}
		
		if (!$this->longitude) {
			$this->longitude = _BSQ_NA;
		}
		
		return true;
	}
	
	/**
	 * Get flag HTML
	 * 
	 * @return string HTML for the image if successful. FALSE on error.
	 *
	 */
	function getFlagHTML()
	{
		$retStr = '<a href="http://www.hostip.info" target="_blank"><img border=\"0\" src="'.$this->flagUrl.'" alt="'._BSQ_FLAGFORUSERSCOUNTRY.'"></a>';
		return $retStr;
	}
}




?>