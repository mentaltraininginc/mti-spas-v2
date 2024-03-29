<?php
/**
* @version $Id: content.searchbot.php 892 2005-11-06 16:08:11Z stingrey $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

$_MAMBOTS->registerFunction( 'onSearch', 'botSearchContent' );

/**
* Content Search method
*
* The sql must return the following fields that are used in a common display
* routine: href, title, section, created, text, browsernav
* @param string Target search string
* @param string mathcing option, exact|any|all
* @param string ordering option, newest|oldest|popular|alpha|category
*/
function botSearchContent( $text, $phrase='', $ordering='' ) {
	global $my, $database;
	global $mosConfig_offset;

	// load mambot params info
	$query = "SELECT id"
	. "\n FROM #__mambots"
	. "\n WHERE element = 'content.searchbot'"
	. "\n AND folder = 'search'"
	;
	$database->setQuery( $query );
	$id 	= $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load( $id );
	$botParams = new mosParameters( $mambot->params );
	
	$limit 		= $botParams->def( 'search_limit', 50 );
	$limit 		= "\n LIMIT $limit";	

	$nullDate 	= $database->getNullDate();
	$now 		= date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
	
	$text = trim( $text );
	if ($text == '') {
		return array();
	}

	$wheres = array();
	switch ($phrase) {
		case 'exact':
			$wheres2 	= array();
			$wheres2[] 	= "LOWER(a.title) LIKE '%$text%'";
			$wheres2[] 	= "LOWER(a.introtext) LIKE '%$text%'";
			$wheres2[] 	= "LOWER(a.fulltext) LIKE '%$text%'";
			$wheres2[] 	= "LOWER(a.metakey) LIKE '%$text%'";
			$wheres2[] 	= "LOWER(a.metadesc) LIKE '%$text%'";
			$where 		= '(' . implode( ') OR (', $wheres2 ) . ')';
			break;
			
		case 'all':
		case 'any':
		default:
			$words = explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word) {
				$wheres2 	= array();
				$wheres2[] 	= "LOWER(a.title) LIKE '%$word%'";
				$wheres2[] 	= "LOWER(a.introtext) LIKE '%$word%'";
				$wheres2[] 	= "LOWER(a.fulltext) LIKE '%$word%'";
				$wheres2[] 	= "LOWER(a.metakey) LIKE '%$word%'";
				$wheres2[] 	= "LOWER(a.metadesc) LIKE '%$word%'";
				$wheres[] 	= implode( ' OR ', $wheres2 );
			}
			$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			break;
	}

	$morder = '';
	switch ($ordering) {
		case 'oldest':
			$order = 'a.created ASC';
			break;
			
		case 'popular':
			$order = 'a.hits DESC';
			break;
			
		case 'alpha':
			$order = 'a.title ASC';
			break;
			
		case 'category':
			$order = 'b.title ASC, a.title ASC';
			$morder = 'a.title ASC';
			break;
			
		case 'newest':
		default:
			$order = 'a.created DESC';
			break;		
	}

	// search content items
	$query = "SELECT a.title AS title,"
	. "\n a.created AS created,"
	. "\n CONCAT(a.introtext, a.fulltext) AS text,"
	. "\n CONCAT_WS( '/', u.title, b.title ) AS section,"
	. "\n CONCAT( 'index.php?option=com_content&task=view&id=', a.id ) AS href,"
	. "\n '2' AS browsernav"
	. "\n FROM #__content AS a"
	. "\n INNER JOIN #__categories AS b ON b.id=a.catid AND b.access IN ( $my->jaclplus )"
	. "\n LEFT JOIN #__sections AS u ON u.id = a.sectionid"
	. "\n WHERE ( $where )"
	. "\n AND a.state = '1'"
	. "\n AND a.access IN ( $my->jaclplus )"
	. "\n AND u.published = '1'"
	. "\n AND b.published = '1'"
	. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
	. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )"
	. "\n ORDER BY $order"
	. $limit
	;
	$database->setQuery( $query );
	$list = $database->loadObjectList();

	// search static content
	$query = "SELECT a.title AS title, a.created AS created,"
	. "\n a.introtext AS text,"
	. "\n CONCAT( 'index.php?option=com_content&task=view&id=', a.id, '&Itemid=', m.id ) AS href,"
	. "\n '2' as browsernav, 'Menu' AS section"
	. "\n FROM #__content AS a"
	. "\n LEFT JOIN #__menu AS m ON m.componentid = a.id"
	. "\n WHERE ($where)"
	. "\n AND a.state = 1"
	. "\n AND a.access IN ( $my->jaclplus )"
	. "\n AND m.type = 'content_typed'"
	. "\n AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now' )"
	. "\n AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )"
	. "\n ORDER BY ". ($morder ? $morder : $order)
	. $limit
	;
	$database->setQuery( $query );
	$list2 = $database->loadObjectList();

	// search archived content
	$query = "SELECT a.title AS title,"
	. "\n a.created AS created,"
	. "\n a.introtext AS text,"
	. "\n CONCAT_WS( '/', '". _SEARCH_ARCHIVED ." ', u.title, b.title ) AS section,"
	. "\n CONCAT('index.php?option=com_content&task=view&id=',a.id) AS href,"
	. "\n '2' AS browsernav"
	. "\n FROM #__content AS a"
	. "\n INNER JOIN #__categories AS b ON b.id=a.catid AND b.access IN ( $my->jaclplus )"
	. "\n LEFT JOIN #__sections AS u ON u.id = a.sectionid"
	. "\n WHERE ( $where )"
	. "\n AND a.state = -1"
	. "\n AND a.access IN ( $my->jaclplus )"
	. "\n AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now' )"
	. "\n AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )"
	. "\n ORDER BY $order"
	. $limit
	;
	$database->setQuery( $query );
	$list3 = $database->loadObjectList();
	
	return array_merge( $list, $list2, $list3 );
}
?>