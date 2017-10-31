<?php
/**
* @version $Id: letterman.searchbot.php,v 1.1 2006/03/06 20:31:55 soeren Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onSearch', 'botSearchLetter' );

/**
* Content Search method
*
* The sql must return the following fields that are used in a common display
* routine: href, title, section, created, text, browsernav
* @param string Target search string
* @param string mathcing option, exact|any|all
* @param string ordering option, newest|oldest|popular|alpha|category
*/
function botSearchLetter( $text, $phrase='', $ordering='' ) {
	global $my, $database;
	global $mosConfig_abolute_path, $mosConfig_offset;

		// load mambot params info
	$query = "SELECT id"
	. "\n FROM #__mambots"
	. "\n WHERE element = 'letterman.searchbot'"
	. "\n AND folder = 'search'"
	;
	$database->setQuery( $query );
	$id 	= $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load( $id );
	$botParams = new mosParameters( $mambot->params );
	
	$limit = $botParams->def( 'search_limit', 50 );
	
	$_SESSION['searchword'] = $text;

	$now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );

	$text = trim( $text );
	if ($text == '') {
		return array();
	}

	$wheres = array();
	switch ($phrase) {
		case 'exact':
			$wheres2 = array();
			$wheres2[] = "LOWER(a.subject) LIKE '%$text%'";
			$wheres2[] = "LOWER(a.html_message) LIKE '%$text%'";
			$wheres2[] = "LOWER(a.message) LIKE '%$text%'";
			$where = '(' . implode( ') OR (', $wheres2 ) . ')';
			break;
		case 'all':
		case 'any':
		default:
			$words = explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word) {
				$wheres2 = array();
				$wheres2[] = "LOWER(a.subject) LIKE '%$word%'";
				$wheres2[] = "LOWER(a.html_message) LIKE '%$word%'";
				$wheres2[] = "LOWER(a.message) LIKE '%$word%'";
				$wheres[] = implode( ' OR ', $wheres2 );
			}
			$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			break;
	}

	switch ($ordering) {
		case 'oldest':
			$order = 'a.created ASC';
			break;
		case 'popular':
			$order = 'a.hits DESC';
			break;
		case 'category':
		case 'alpha':
			$order = 'a.subject ASC';
			break;
		case 'newest':
		default:
			$order = 'a.created DESC';
			break;
	}

	$sql = "SELECT a.subject AS title,"
	. "\n a.created AS created,"
	. "\n html_message AS text,"
	. "\n 'Newsletter' AS section,"
	. "\n CONCAT( 'index.php?option=com_letterman&amp;task=view&amp;id=', a.id ) AS href,"
	. "\n '2' AS browsernav"
	. "\n FROM `#__letterman` AS a"
	. "\n WHERE ( $where )"
	. "\n AND a.published = '1'"
	. "\n AND a.access <= ".$my->gid
	. "\n AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now' )"
	. "\n AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )"
	. "\n ORDER BY $order";

	$database->setQuery( $sql, 0, $limit );

	$list = $database->loadObjectList();

	return $list;
}
?>
