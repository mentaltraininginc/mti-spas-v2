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

function com_install()
{
	global $database;
	
	//Create the database tables needed for BSQ Sitestats
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_hit (
			  id int(11) unsigned NOT NULL auto_increment,
			  remote_ip varchar(15) NOT NULL default '',
			  country varchar(50) NOT NULL default '',
			  language VARCHAR(5) NOT NULL default '',
			  domain varchar(255) NOT NULL default '',
			  referer varchar(255) NOT NULL default '',
			  resource varchar(255) NOT NULL default '',
			  user_agent varchar(255) NOT NULL default '',
			  platform varchar(50) NOT NULL default '',
			  browser varchar(50) NOT NULL default '',
			  version varchar(15) NOT NULL default '',
			  dt int(10) unsigned NOT NULL default '0',
			  user_id int(11) NOT NULL default '0',
			  UNIQUE KEY id (id)
			  ) TYPE=MyISAM";
	  
	$database->setQuery($query);
	$database->query();
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_searchterms (
			  id int(11) unsigned NOT NULL auto_increment,
			  searchterms varchar(255) NOT NULL default '',
			  count int(10) unsigned NOT NULL default '0',
			  PRIMARY KEY  (id)
			  ) TYPE=MyISAM;";
		
	$database->setQuery($query);
	$database->query();
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_iptocountry (
			  ip_from double NOT NULL default '0',
			  ip_to double NOT NULL default '0',
			  country_code2 char(2) NOT NULL default '',
			  country_code3 char(3) NOT NULL default '',
			  country_name varchar(50) NOT NULL default ''
			  ) TYPE=MyISAM;";
	
	$database->setQuery($query);
	$database->query();
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_domain (
              domainID int(8) NOT NULL auto_increment,
              lookupStr char(255) NOT NULL default '',
              refCount int(11) NOT NULL default '0',
              ignoreMe enum('y','n') NOT NULL default 'n',
              PRIMARY KEY  (domainID),
              UNIQUE KEY lookupStr (lookupStr),
              KEY refCount (refCount)
              ) TYPE=MyISAM;";
	
	$database->setQuery($query);
	$database->query();
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_platform (
             platformID int(5) NOT NULL auto_increment,
             lookupStr char(255) NOT NULL default '',
             refCount int(11) NOT NULL default '0',
             ignoreMe enum('y','n') NOT NULL default 'n',
             PRIMARY KEY  (platformID),
             UNIQUE KEY lookupStr (lookupStr),
             KEY refCount (refCount)
             ) TYPE=MyISAM;";
	
	$database->setQuery($query);
	$database->query();
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_referer (
             refererID int(11) NOT NULL auto_increment,
             lookupStr char(255) NOT NULL default '',
             refCount int(11) NOT NULL default '0',
             ignoreMe enum('y','n') NOT NULL default 'n',
             PRIMARY KEY  (refererID),
             UNIQUE KEY lookupStr (lookupStr),
             KEY refCount (refCount)
             ) TYPE=MyISAM;";
	
	$database->setQuery($query);
	$database->query();
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_resource (
             resourceID int(11) NOT NULL auto_increment,
             lookupStr char(255) NOT NULL default '',
             refCount int(11) NOT NULL default '0',
             ignoreMe enum('y','n') NOT NULL default 'n',
             PRIMARY KEY  (resourceID),
             UNIQUE KEY lookupStr (lookupStr),
             KEY refCount (refCount)
             ) TYPE=MyISAM;";
	
	$database->setQuery($query);
	$database->query();
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_useragent (
             useragentID int(5) NOT NULL auto_increment,
             lookupStr char(255) NOT NULL default '',
             refCount int(11) NOT NULL default '0',
             ignoreMe enum('y','n') NOT NULL default 'n',
             PRIMARY KEY  (useragentID),
             UNIQUE KEY lookupStr (lookupStr),
             KEY refCount (refCount)
             ) TYPE=MyISAM;";
	
	$database->setQuery($query);
	$database->query();
	
	$query = "CREATE TABLE IF NOT EXISTS #__bsq_smallhit (
             smallhitID int(11) NOT NULL auto_increment,
			 ip char(15) NOT NULL default '',
			 countryID int(5) default '0',
			 language char(5) NOT NULL default '',
			 domainID int(8) NOT NULL default '0',
			 refererID int(11) NOT NULL default '0',
			 resourceID int(11) NOT NULL default '0',
			 useragentID int(5) NOT NULL default '0',
			 platformID int(5) NOT NULL default '0',
			 browserID int(6) NOT NULL default '0',
			 version char(15) NOT NULL default '',
			 dt int(11) NOT NULL default '0',
			 user_id int(11) NOT NULL default '0',
			 PRIMARY KEY  (smallhitID),
			 KEY ip (ip),
			 KEY dt (dt)
			 ) TYPE=MyISAM;";
	
	$database->setQuery($query);
	$database->query();
	
	
	
	/* Database update for 1.7.0 */
	$tables = array();
	$tables[] = '#__bsq_hit';
	$tables[] = '#__bsq_smallhit';
	$result = $database->getTableFields($tables);
	
	if(!isset($result['#__bsq_hit']['user_id'])) {
		$query = "ALTER TABLE `#__bsq_hit` ADD `user_id` INT( 11 ) DEFAULT '0' NOT NULL";
		$database->setQuery($query);
		$database->query();
	}
	if(!isset($result['#__bsq_smallhit']['user_id'])) {
		$query = "ALTER TABLE `#__bsq_smallhit` ADD `user_id` INT( 11 ) DEFAULT '0' NOT NULL";
		$database->setQuery($query);
		$database->query();
	}
	/* END Database update for 1.7.0 */
	
	return _BSQ_INSTALLWORKED;
}
?>