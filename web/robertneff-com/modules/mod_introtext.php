<?php
/**
* IntroText
* Version: 1.0
* Based on: Newsflash module
* Author: Bárbara Irene Meclazcke
* URL:  ewriting.com.ar
* mail: aclaina@yahoo.com.ar
* FileName: mod_introtext.php
* Date: 01/02/2005
* MOS Version #: 4.5.1a
* License: GNU General Public License
**/


/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'front_html', 'com_content') );

global $my, $mosConfig_shownoauth, $mosConfig_offset;

$access = !$mosConfig_shownoauth;

$now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );

$item_title = $params->get( 'item_title' );
$image = $params->get( 'image' );
$items = intval( $params->get( 'items' ) );
$moduleclass_sfx = $params->get( 'moduleclass_sfx' );

$params->set( 'intro_only', 1 );
$params->set( 'hide_author', 1 );
$params->set( 'hide_createdate', 0 );
$params->set( 'hide_modifydate', 1 );

if ( $items ) { $limit = "LIMIT ". $items; } 
else { $limit = ""; }

if ($Itemid) {
	$database->setQuery( "SELECT contentid FROM #__introtext_link WHERE menuid = $Itemid AND enabled = 1" );
	$intros = null;
	$intros = $database->loadResultArray();
	if (count( $intros )) {
		$intro = new mosContent( $database ); 
		foreach ($intros as $id) {
			$intro->load( $id );
			$intro->text = $intro->introtext; 
			HTML_content::show( $intro, $params, $access, 0, 'com_content' ); 
		}  //foreach ($intros as $id)
	}//if (count( $intros ))
} //if ($Itemid)
?>
