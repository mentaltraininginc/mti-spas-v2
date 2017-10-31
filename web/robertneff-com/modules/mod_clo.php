<?php
/**
* CLO handling functions
* @package CLO 
* @Copyright Chanh Ong 12/29/2004
* @ All rights reserved
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/
// mod_clo global variables
global $clopath,$clolpath,$clodtree;
global $clouseSelection,$clouseLines,$clouseIcons,$clouseStatusText,$clocloseSameLevel,$cloopenAll,$clobasetext;
global $cloclass_sfx,$cloitmid;
$clopath = "modules/mod_clo";
$clolpath = $mosConfig_live_site."/".$clopath;
$clodtree = $clolpath."/";  // js don't have slash
$clouseSelection=1;
$clouseLines=1;
$clouseIcons=1;
$clouseStatusText=0;
$clocloseSameLevel=1;

/* 
define("_VALID_MOS", 1);
include_once("globals.php");
require_once("configuration.php");
require_once("includes/mambo.php");
require_once("includes/sef.php");
include_once ('language/' . $mosConfig_lang . '.php');
global $database;
$database = new database($mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix);
$cloclass_sfx = "_clo";
$secid = "3";
$catid = "67";
$ltype = "tree";
$orderby = "id";
$itmid="159";
require_once( "./modclo.class.php" );
#require_once( "./mod_clo.class.php" );
*/

///*
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

# quick fix for old module in 4.5.1
$params = mosParseParams( $module->params );
#$catid = intval( $params->catid );
$cloitmid = $params->itemid;
$secid = $params->secid;
$catid = $params->catid;
$ltype = $params->ltype;
$orderby = $params->orderby;
$showupdated = $params->showupdated;
$cloclass_sfx	= $params->moduleclass_sfx;
$clouseSelection =   $params->useSelection;
$clouseLines =       $params->useLines;
$clouseIcons =       $params->useIcons;
$clouseStatusText =  $params->useStatusText;
$clocloseSameLevel = $params->closeSameLevel;
$cloopenAll = $params->openAll;
$clobasetext = $params->basetext;

require_once( "$mosConfig_absolute_path/modules/mod_clo/cotoolkit.php" );
require_once( "$mosConfig_absolute_path/modules/mod_clo/mod_clo.class.php" );
//*/

if ($ltype == "") {$ltype = "list";}
$query=co_mk_sql($secid,$catid,$orderby,$showupdated);

// initialise the query in the $database connector
// this translates the '#__' prefix into the real database prefix
$database->setQuery( $query );

// retrieve the list of returned records as an array of objects
$rows = $database->loadObjectList();
if ($rows) { co_get_contents_per_category($rows,$ltype); }
?>
