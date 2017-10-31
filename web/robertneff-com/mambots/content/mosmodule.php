<?php
// By: Chanh Ong
// $Id: mosmodule.php,v 1.0 2004/06/13 14:19:00 alwarren Exp $
/**
* mosmodule mambot
* @Copyright (C) 2004 Al Warren
* @ All rights reserved
* @ MosModule mambot is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.0 $
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Usage:
* 	{mosmodule section=faq}
* 	{mosmodule module=somemoduletitle}
*	{mosmodule user1 (any module block position)
*	{mosmodule list - display a list of available modules and block positions
**/
$_MAMBOTS->registerFunction('onPrepareContent', 'mosmodule') ;

function mosmodule($published, &$row, &$params, $page=0) {
  global $database ;

  if ( preg_match_all( "/{(mosmodule)\s*(.*?)}/i", $row->text, $bots, PREG_SET_ORDER ) ) {
   require_once( $GLOBALS['mosConfig_absolute_path'] . '/mambots/content/mosmodule/mosmodule.inc.php' );
  //	require_once("mambots/content/modulebot.inc");
	$row->text = mosmodulebot::insertBots($row->text, $bots);
  }
}

?>