<?php
/**
* @version $Id: contact_category_table.class.php 652 2005-10-25 22:23:27Z Jinx $
* @package Joomla
* @subpackage Menus
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

/**
* @package Joomla
* @subpackage Menus
*/
class contact_category_table_menu {

	/**
	* @param database A database connector object
	* @param integer The unique id of the category to edit (0 if new)
	*/
	function editCategory( $uid, $menutype, $option ) {
		global $database, $my, $mainframe;

		$menu = new mosMenu( $database );
		$menu->load( $uid );

		// fail if checked out not by 'me'
		if ($menu->checked_out && $menu->checked_out != $my->id) {
			mosErrorAlert( "The module ".$menu->title." is currently being edited by another administrator" );
		}

		if ( $uid ) {
			$menu->checkout( $my->id );
		} else {
			$menu->type 	= 'contact_category_table';
			$menu->menutype = $menutype;
			$menu->ordering = 9999;
			$menu->parent 	= intval( mosGetParam( $_POST, 'parent', 0 ) );
			$menu->published = 1;
		}

		// build list of categories
		$lists['componentid']	= mosAdminMenus::ComponentCategory( 'componentid', 'com_contact_details', intval( $menu->componentid ), NULL, 'ordering', 5, 0 );
		if ( $uid ) {
			$query = "SELECT name"
			. "\n FROM #__categories"
			. "\n WHERE section = 'com_contact_details'"
			. "\n AND published = 1"
			. "\n AND id = ". $menu->componentid
			;
			$database->setQuery( $query );
			$category = $database->loadResult();
			$lists['componentid'] = '<input type="hidden" name="componentid" value="'. $menu->componentid .'" />'. $category;
		}

		// build the html select list for ordering
		$lists['ordering'] 		= mosAdminMenus::Ordering( $menu, $uid );
		// build the html select list for the group access
		$lists['access'] 		= mosAdminMenus::Access( $menu );
		// build the html select list for paraent item
		$lists['parent'] 		= mosAdminMenus::Parent( $menu );
		// build published button option
		$lists['published'] 	= mosAdminMenus::Published( $menu );
		// build the url link output
		$lists['link'] 		= mosAdminMenus::Link( $menu, $uid );

		// get params definitions
		$params = new mosParameters( $menu->params, $mainframe->getPath( 'menu_xml', $menu->type ), 'menu' );

		contact_category_table_menu_html::editCategory( $menu, $lists, $params, $option );
	}
}
?>