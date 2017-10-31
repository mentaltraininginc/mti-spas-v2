<?php
// By: Chanh Ong
// $Id: modulebot.php,v 1.0 2004/06/13 14:19:00 alwarren Exp $
/**
* modulebot mambot
* @Copyright (C) 2004 Al Warren
* @ All rights reserved
* @ Modulebot mambot is Free Software
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
* 	{modulebot section=faq}
* 	{modulebot module=somemoduletitle}
*	{modulebot user1 (any module block position)
*	{modulebot list - display a list of available modules and block positions
**/

if ( preg_match_all( "/{(modulebot)\s*(.*?)}/i", $row->text, $bots, PREG_SET_ORDER ) ) {
	require_once("mambots/content/mosmodule/modulebot.inc.php");
	$row->text = modulebot::insertBots($row->text, $bots);
}
?>