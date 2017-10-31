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
* @version $Revision: 1.0.1 $
* @author Brent Stolle <dev@bs-squared.com>
*
*/

//ensure this file is being included by a parent file
defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

require_once('bsqlookups.php');

class BSQSitestatsCompress
{	
	/**
	* @param BSQSitestatsCFG Configuration class to get preferences from
	*/
	function BSQSitestatsCompress()
	{
	}
	
	/**
	* Try to compress some of the default ShortStat style rows into compressed rows. 
	*
	* @param integer How many seconds old should our data be before we consider compressing it?
	* @param integer Maximum rows to compress now (0 = don't care) 
	*
	* @return boolean true if there are more rows to do. false if not.
	*/
	function CompressHits($minAgeSeconds = 86400, $maxRows = 10000)
	{
		global $database;
		
		$firstSec = time() - $minAgeSeconds;
		
		$query = "SELECT * FROM #__bsq_hit 
		          WHERE dt <= '$firstSec' 
				  ORDER BY id ASC ";
		$database->setQuery($query, 0, $maxRows);
		$assoc = $database->loadObjectList();
		
		if($assoc === null || count($assoc) == 0)
			return false;
			
		foreach ($assoc as $row)
		{
			$browserID = bsq_lookupBrowserStr($row->browser);
			$domainID = $this->AddStringTableRef('#__bsq_domain', $row->domain, 'domainID');
			$refererID = $this->AddStringTableRef('#__bsq_referer', $row->referer, 'refererID');
			$resourceID = $this->AddStringTableRef('#__bsq_resource', $row->resource, 'resourceID');
			$useragentID = $this->AddStringTableRef('#__bsq_useragent', $row->user_agent, 'useragentID');
			$platformID = $this->AddStringTableRef('#__bsq_platform', $row->platform, 'platformID');
			$countryID = $this->AddStringTableRef('#__bsq_country', $row->country, 'countryID');
			$userID = $row->user_id;
			$lastId = $row->id;
			
			$query = "INSERT INTO #__bsq_smallhit VALUES ('', '$row->remote_ip', '$countryID', '$row->language', '$domainID',
			          '$refererID', '$resourceID', '$useragentID', '$platformID', '$browserID', '$row->version', '$row->dt', '$userID')";
			$database->setQuery($query);
			$database->query();
		}
		
		//delete all records matching our original select query in one query
		$deleteQuery = "DELETE FROM #__bsq_hit WHERE id<='$lastId' ";
		$database->setQuery($deleteQuery);
		$database->query();
		
		/* optimize table */
		$query = "OPTIMIZE TABLE #__bsq_hit";
		$database->setQuery($query);
		$database->query();
				
		return (count($assoc)==$maxRows ? true : false);
	}
	
	
	/**
	* Insert/update a string reference table. A reference table should have the following format:
	* keyname 	INT(11) --> 	auto_increment, primary key
	* lookupStr CHAR(255) --> 	String to lookup (UNIQUE!!)
	* refCount 	INT(11) -->		Number of times this string has occured (reference count)
	*
	* All other fields must be optionally NULL since insertions will occur without them
	*
	* @param string Table to add a lookup string to.
	* @param string String to add/update in the table
	* @param string Name of the primary key field to return
	*
	* @return integer ID to use as a foreign key into this table or null on error.
	*/
	function AddStringTableRef($table, $str, $pkField)
	{
		global $database;
		
		if (!$table || !$str || !$pkField)
			return null;
		
		$query  = "SELECT $pkField FROM $table WHERE lookupStr='$str' ";
		$database->setQuery($query, 0, 1);
		$recordID = $database->loadResult();
		
		if ($recordID === null)
		{
			$query = "INSERT INTO $table (lookupStr, refCount) VALUES ('$str', 1) ";
			$database->setQuery($query);
			$database->query();
			return $database->insertid();
		}
		else
		{
			$query = "UPDATE $table SET refCount = refCount + 1 WHERE $pkField='$recordID' ";
			$database->setQuery($query);
			$database->query();
			return $recordID;
		}
	}
}
?>