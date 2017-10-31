<?php
/**
* @version $Id: install.joomlaxplorer.php,v 1.0 2006/06/26 13:34:34 mic Exp $
* @package joomlaXplorer
* @copyright (C) 2005 joomla Dev Team - Soeren
* @license http://www.mozilla.org/MPL/
* @author mic (joomlaworld@gmail.com)
* joomla is Free Software
*/
function com_install(){
	global $database;

	$database->setQuery( "SELECT id FROM #__components WHERE admin_menu_link = 'option=com_joomlaxplorer'" );
	$id = $database->loadResult();

	//add new admin menu images
	$database->setQuery( "UPDATE #__components SET admin_menu_img = '../administrator/components/com_joomlaxplorer/_img/joomlax_icon.png', admin_menu_link = 'option=com_joomlaxplorer' WHERE id='$id'");
	$database->query();
}
?>