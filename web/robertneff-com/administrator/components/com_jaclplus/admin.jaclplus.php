<?php
/******************************************************************/
/* Title........: JACLPlus Component for Joomla! 1.0.4 Stable
/* Description..: Joomla! ACL Enhancements Hacks for Joomla! 1.0.4 Stable
/* Author.......: Vincent Cheah
/* Version......: 1.0.4 (For Joomla! 1.0.4 ONLY)
/* Created......: 23/11/2005
/* Contact......: jaclplus@byostech.com
/* Copyright....: (C) 2005 Vincent Cheah, ByOS Technologies. All rights reserved.
/* Note.........: This script is a part of JACLPlus package.
/* License......: Released under GNU/GPL http://www.gnu.org/copyleft/gpl.html
/******************************************************************/
###################################################################
//JACLPlus Component for Joomla! 1.0.4 Stable (Joomla! ACL Enhancements Hacks)
//Copyright (C) 2005  Vincent Cheah, ByOS Technologies. All rights reserved.
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
//
//You should have received a copy of the GNU General Public License
//along with this program; if not, write to the Free Software
//Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
###################################################################

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed. [ <a href="http://www.byostech.com/jaclplus">JACLPlus Component for Joomla! 1.0.4 Stable</a> ]' );

if (!$acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_jaclplus' )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

if (file_exists($mosConfig_absolute_path . '/administrator/components/com_jaclplus/language/'.$mosConfig_lang.'.php')) {
  include($mosConfig_absolute_path . '/administrator/components/com_jaclplus/language/'.$mosConfig_lang.'.php');
} else {
  include($mosConfig_absolute_path . '/administrator/components/com_jaclplus/language/english.php');
}

require_once( $mainframe->getPath( 'admin_html' ) );

$task 	= mosGetParam( $_REQUEST, 'task' );
$cid 	= mosGetParam( $_REQUEST, 'cid', array( 0 ) );
$id 	= intval( mosGetParam( $_REQUEST, 'id', 0 ) );
if (!is_array( $cid )) {
	$cid = array ( 0 );
}

switch ($task) {
	case 'new':
		editGroup( 0, $option);
		break;

	case 'edit':
		editGroup( intval( $cid[0] ), $option );
		break;

	case 'editA':
		editGroup( $id, $option );
		break;

	case 'save':
	case 'apply':
 		saveGroup( $option, $task );
		break;

	case 'remove':
		removeGroups( $cid, $option );
		break;

	case 'block':
		changeGroupBlock( $cid, 1, $option );
		break;

	case 'unblock':
		changeGroupBlock( $cid, 0, $option );
		break;

	case 'logout':
		logoutGroup( $cid, $option, $task );
		break;

	case 'flogout':
		logoutGroup( $id, $option, $task );
		break;

	case 'cancel':
		cancelGroup( $option );
		break;

	case 'listAL':
		showAccess( $option );
		break;

	case 'newAL':
		editAccess( -1, $option);
		break;

	case 'editAL':
		editAccess( intval( $cid[0] ), $option );
		break;

	case 'editALA':
		editAccess( $id, $option );
		break;
		
	case 'cancelAL':
		cancelAccess( $option );
		break;

	case 'saveAL':
	case 'applyAL':
 		saveAccess( $option, $task );
		break;

	case 'removeAL':
		removeAccesses( $cid, $option );
		break;

	case 'about':
		showAbout( $option );
		break;
	case 'view':
	default:
		showGroups( $option );
		break;
}

function showAbout( $option )
{
    HTML_jaclplus::showAbout( $option );
}

function showGroups( $option ) {
	$list = getGroupList( true );

	HTML_jaclplus::showGroups( $list, $option );
}

function convertALS( $jaclplus ) {
	global $database;
	$query = "SELECT name FROM #__groups WHERE id IN ( $jaclplus )";
	$database->setQuery( $query );
	$groups = $database->loadResultArray();
	if(empty($groups)) {
		return "";
	} else {
		return implode( ", ", $groups );
	}
}

function getGroupList( $convertjaclplus=false, $exclude_group='' ) {
	global $database, $my, $acl, $mainframe;

	// ensure group can't see group higher than themselves and 'Public Frontend', 'Public Backend'
	$ex_groups = $acl->get_group_children( $my->gid, 'ARO', 'RECURSE' );
	if (is_array( $ex_groups ) && count( $ex_groups ) > 0) {
		array_push($ex_groups, '29', '30');
	} else {
		$ex_groups = array('29', '30'); 
	}
	if( $my->gid != 25 ) $ex_groups[] = '25';
	if(!empty($exclude_group)) $ex_groups[] = $exclude_group;
		
	$group_rows = $acl->_getBelow( '#__core_acl_aro_groups', 'g1.group_id, g1.name, g1.parent_id, g1.jaclplus, COUNT(g2.name) AS level',
		'g1.name', null, 'USERS', false );

	// remove exclude groups
	$list = array();
	foreach ( $group_rows as $group_row) {
		if (!in_array( $group_row->group_id, $ex_groups )) {
			if($group_row->group_id<=25) {
				$group_row->name .= " *";
			}
			if($convertjaclplus){
				$group_row->jaclplus = convertALS( $group_row->jaclplus );
			}
			$list[] = $group_row;
		}
	}
	
	// first pass get level limits
	$n = count( $list );
	$min = $list[0]->level;
	$max = $list[0]->level;
	for ($i=0; $i < $n; $i++) {
		$min = min( $min, $list[$i]->level );
		$max = max( $max, $list[$i]->level );
	}

	$indents = array();
	foreach (range( $min, $max ) as $i) {
		$indents[$i] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	// correction for first indent
	$indents[$min] = '';

	for ($i=0; $i < $n; $i++) {
		$shim = '';
		foreach (range( $min, $list[$i]->level ) as $j) {
			$shim .= $indents[$j];
		}
		$twist = "-&nbsp;";
		$list[$i]->name = $shim.$twist.$list[$i]->name;
	}
	return $list;
}

function editGroup( $gid='0', $option='com_jaclplus' ) {
	global $database, $my, $acl, $mainframe;

	$ex_groups = $acl->get_group_children( $my->gid, 'ARO', 'RECURSE' );
	if (count($ex_groups)>0) {
		array_push($ex_groups, '29', '30');
	} else {
		$ex_groups = array('29', '30'); 
	}
	if ( $my->gid != 25 ) $ex_groups[] = '25';
	// check to ensure only super admins can edit super admin info
	if ( ( $my->gid != 25 ) && ( in_array( $gid, $ex_groups ) ) ) {
		mosRedirect( 'index2.php?option='.$option, _NOT_AUTH );
	}

	// load the row from the db table
	$row = $acl->get_group_data( $gid );
	if(empty($row)){
		$row->jaclplus = '0,1';
		$row->name = '';
		$row->group_id = '';
		$row->parent_id = '';
	} else {
		$subtask 	= mosGetParam( $_REQUEST, 'subtask', '' );
		switch ($subtask) {
			case 'editACL':
				editGroupACL( $row, $option);
				break;
			case 'addACL':
				saveGroupACL( $row, $option);
				break;
			case 'removeACL':
				removeGroupACL( $row, $option);
				break;
			default:
				break;
		}
	}

	// build the html select list for the group access levels
	$lists['access'] 	= jaclplusMultiAccess( $row );
	if( !empty($gid) && $gid <= 25 ){
		$lists['name'] = '<input type="hidden" name="name" value="'. htmlentities( $row->name ) .'" /><strong>'. $row->name .'</strong> '._JACL_G_DEFAULT;
		$lists['parent_id'] 	= $acl->get_group_name( $row->parent_id );
	}else{
		$lists['name'] = '<input type="text" name="name" class="inputbox" size="40" value="'. htmlentities( $row->name ) .'" />';
		$parentids = getGroupList( false, $row->group_id );
		$lists['parent_id'] 	= mosHTML::selectList( $parentids, 'parent_id', 'class="inputbox" size="1"', 'group_id', 'name', intval( $row->parent_id ) );
	}

	if ( $row->group_id < 1 ) {
		$inheritfrom = array();
		$inheritfrom[] = mosHTML::makeOption( '0', 'None' );
		$inheritfrom[] = mosHTML::makeOption( '-1', 'Parent Group' );
		$inheritfrom[] = mosHTML::makeOption( $my->gid, 'My Group' );
		$inheritoptions = getGroupList( false, $my->gid );
		foreach ($inheritoptions as $inheritoption) {
			$inheritfrom[] = mosHTML::makeOption( $inheritoption->group_id, $inheritoption->name );
		}
   		$lists['inheritfrom'] = mosHTML::selectList( $inheritfrom, 'inheritfrom', 'class="inputbox" size="1"', 'value', 'text', '0' );
	}
	HTML_jaclplus::editGroup( $row, $option, $gid, $lists );
}

function showGroupACL( &$row, $option ) {
	global $database;
	$query = "SELECT * FROM #__jaclplus WHERE aro_value = '".strtolower($row->name)."' ORDER BY aco_section";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$aco_section = array();
	$aco_section[] = mosHTML::makeOption( 'action', 'action' );
	$aco_section[] = mosHTML::makeOption( 'administration', 'administration' );
	$aco_section[] = mosHTML::makeOption( 'workflow', 'workflow' );

   	$lists['aco_section'] = mosHTML::selectList( $aco_section, 'aco_section', 'class="inputbox" size="1"', 'value', 'text', 'action' );

	$aco_value = array();
	$aco_value[] = mosHTML::makeOption( 'add', 'add' );
	$aco_value[] = mosHTML::makeOption( 'config', 'config' );
	$aco_value[] = mosHTML::makeOption( 'edit', 'edit' );
	$aco_value[] = mosHTML::makeOption( 'email_events', 'email_events' );
	$aco_value[] = mosHTML::makeOption( 'install', 'install' );
	$aco_value[] = mosHTML::makeOption( 'login', 'login' );
	$aco_value[] = mosHTML::makeOption( 'manage', 'manage' );
	$aco_value[] = mosHTML::makeOption( 'publish', 'publish' );

   	$lists['aco_value'] = mosHTML::selectList( $aco_value, 'aco_value', 'class="inputbox" size="1"', 'value', 'text', 'add' );

	$axo_section = array();
	$axo_section[] = mosHTML::makeOption( '', 'null' );
	$axo_section[] = mosHTML::makeOption( 'components', 'components' );
	$axo_section[] = mosHTML::makeOption( 'content', 'content' );
	$axo_section[] = mosHTML::makeOption( 'languages', 'languages' );
	$axo_section[] = mosHTML::makeOption( 'mambots', 'mambots' );
	$axo_section[] = mosHTML::makeOption( 'modules', 'modules' );
	$axo_section[] = mosHTML::makeOption( 'templates', 'templates' );
	$axo_section[] = mosHTML::makeOption( 'user properties', 'user properties' );

   	$lists['axo_section'] = mosHTML::selectList( $axo_section, 'axo_section', 'class="inputbox" size="1"', 'value', 'text', '' );

	$axo_value = array();
	$axo_value[] = mosHTML::makeOption( '', 'null' );
	$axo_value[] = mosHTML::makeOption( 'own', 'own' );
	$axo_value[] = mosHTML::makeOption( 'all', 'all' );
	$axo_value[] = mosHTML::makeOption( 'block_user', 'block_user' );
	$axo_value[] = mosHTML::makeOption( 'com_dbadmin', 'com_dbadmin' );
	//$axo_value[] = mosHTML::makeOption( 'com_jaclplus', 'com_jaclplus' );
	$axo_value[] = mosHTML::makeOption( 'com_languages', 'com_languages' );
	$axo_value[] = mosHTML::makeOption( 'com_massmail', 'com_massmail' );
	$axo_value[] = mosHTML::makeOption( 'com_menumanager', 'com_menumanager' );
	$axo_value[] = mosHTML::makeOption( 'com_templates', ' com_templates' );
	$axo_value[] = mosHTML::makeOption( 'com_trash', 'com_trash' );
	$axo_value[] = mosHTML::makeOption( 'com_users', 'com_users' );
	$query = "SELECT DISTINCT `option`  FROM `#__components` WHERE `option` != '' ORDER BY `option`";
	$database->setQuery( $query );
	$axo_options = $database->loadRowList();
	foreach ($axo_options as $axo_option) {
		$axo_value[] = mosHTML::makeOption( $axo_option['option'], $axo_option['option'] );
	}
	//print_r($axo_options);

   	$lists['axo_value'] = mosHTML::selectList( $axo_value, 'axo_value', 'class="inputbox" size="1"', 'value', 'text', '' );

	$yes_no = array();
	$yes_no[] = mosHTML::makeOption( '0', 'No' );
	$yes_no[] = mosHTML::makeOption( '1', 'Yes' );

   	$lists['yes_no'] = mosHTML::selectList( $yes_no, 'yes_no', 'class="inputbox" size="1"', 'value', 'text', 0 );

	HTML_jaclplus::showGroupACL( $rows, $row, $lists, $option );
}

function editGroupACL( &$row, $option ) {
	global $database;
	if (jaclplus_check( $row->group_id )) {
		$aclid 	= intval( mosGetParam( $_REQUEST, 'aclid', 0 ) );
		$value 	= intval( mosGetParam( $_REQUEST, 'myvalue', 0 ) );
		if($aclid >0) {
			$query = "UPDATE #__jaclplus SET enable = '".( $value ? 0 : 1)  ."' WHERE id = ".$aclid;
			$database->setQuery( $query );
			$result = $database->query();
			if(!$result){
				mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_FAIL_EDIT );
			}
		}
	} else {
		mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_NOT_ALLOW );
	}
}

function removeGroupACL( &$row, $option ) {
	global $database;
	if (jaclplus_check( $row->group_id )) {
		$aclid 	= intval( mosGetParam( $_REQUEST, 'aclid', 0 ) );
		$value 	= intval( mosGetParam( $_REQUEST, 'myvalue', 0 ) );
		$aro_value = strtolower($row->name);
		if($aclid >0) {
			$query = "DELETE FROM #__jaclplus WHERE id = ".$aclid." AND aro_value = '".$aro_value."' AND enable = '".( $value ? 1 : 0)."'";
			$database->setQuery( $query );
			$result = $database->query();
			if(!$result){
				mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_FAIL_DELETE );
			}
		}
	} else {
		mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_NOT_ALLOW );
	}
}

function saveGroupACL( &$row, $option ) {
	global $database, $my, $acl;
	if (jaclplus_check( $row->group_id )) {
		$aco_section = mosGetParam( $_REQUEST, 'aco_section', '' );
		$aco_value = mosGetParam( $_REQUEST, 'aco_value', '' );
		//$aro_section = mosGetParam( $_REQUEST, 'aro_section', 'users' );
		$aro_section = 'users';
		$aro_value = strtolower($row->name);
		$axo_section = mosGetParam( $_REQUEST, 'axo_section', '' );
		$axo_value = mosGetParam( $_REQUEST, 'axo_value', '' );
		$yes_no = intval( mosGetParam( $_REQUEST, 'yes_no', 0 ) );
		
		// only allow to add ACL that user have and enabled
		$query = "SELECT id FROM #__jaclplus WHERE "
		."aco_section ='".$aco_section."' AND "
		."aco_value ='".$aco_value."' AND "
		."aro_section ='".$aro_section."' AND "
		."aro_value ='".strtolower( $acl->get_group_name( $my->gid ) )."' AND "
		.( $axo_section ? "axo_section ='".$axo_section."' AND " : "axo_section IS NULL AND " )
		.( $axo_value ? "axo_value ='".$axo_value."' " : "axo_value IS NULL ");
		//if ($my->gid != 25 || $row->group_id != 25) $query .= "AND enable=1 "; 
		// allow super administrator to add disabled ACL as well as long as the ACL is exist in super administrator list
		if ( $my->gid != 25 ) $query .= "AND enable=1 "; 
		$database->setQuery( $query );
		if($database->loadResult() > 0) { //okay found one similar and enabled
			if ($row->group_id != 25) { // for non super administrator group and skipped for super administrator group
				$query = "INSERT INTO #__jaclplus SET aco_section = '".$aco_section."', "
				."aco_value = '".$aco_value."', "
				."aro_section = '".$aro_section."', "
				."aro_value = '".$aro_value."', "
				.( $axo_section ? "axo_section = '".$axo_section."', " : "axo_section = NULL, " )
				.( $axo_value ? "axo_value = '".$axo_value."', " : "axo_value = NULL, ")
				."enable = '".( $yes_no ? 1 : 0)  ."'";
				$database->setQuery( $query );
				if(!$database->query()){
					mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_FAIL_ADD );
				}
			}
		} else {
			if ($my->gid == 25 && $row->group_id == 25) { //for super administrator to add new ACL
				$query = "INSERT INTO #__jaclplus SET aco_section = '".$aco_section."', "
				."aco_value = '".$aco_value."', "
				."aro_section = '".$aro_section."', "
				."aro_value = '".$aro_value."', "
				.( $axo_section ? "axo_section = '".$axo_section."', " : "axo_section = NULL, " )
				.( $axo_value ? "axo_value = '".$axo_value."', " : "axo_value = NULL, ")
				."enable = '".( $yes_no ? 1 : 0)  ."'";
				$database->setQuery( $query );
				if(!$database->query()){
					mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_FAIL_ADD );
				}
			} else {
				mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_DONT_HAVE );
			}
		}
	} else {
		mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_NOT_ALLOW );
	}
}

function saveGroup( $option, $task ) {
	global $database, $my, $acl;
	global $mosConfig_live_site, $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_sitename;

	$row = new stdClass();
	$row->group_id = mosGetParam( $_POST, 'id', 0 );
	$isNew 	= !$row->group_id;
	$row->name = mosGetParam( $_POST, 'name', '' );
	if (empty($row->name)) {
		mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_G_INVALID_NAME );
	}
	$old_name = $acl->get_group_name($row->group_id);
	// prevent duplicated name
	if( $old_name != $row->name ){
		if ($acl->get_group_id($row->name)) {
			mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_G_INVALID_NAME2 );
		}
	}
	$row->parent_id = intval( mosGetParam( $_POST, 'parent_id', 18 ) ); //parent id: 18 - Registered; 29 - Public Frontend
	
	if ($row->parent_id == 25 && $my->gid != 25 ){
		mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_G_INVALID_PARENT_ID );
	}
	
	// save access levels
	$access = mosGetParam( $_POST, 'access', '' );
	if (is_array( $access )) {
		$row->jaclplus = implode( ",", $access );
	}else{
		$row->jaclplus = mosGetParam( $_POST, 'jaclplus', '0' );
	}
	if(strlen($row->jaclplus)<1){
		mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_G_INVALID_ACCESS_LEVEL );
	}
	
	if ($isNew) {
		$result = $acl->add_group($row->name, $row->jaclplus, $row->parent_id, 'ARO');
		if($result){
			$row->group_id = $result;
			$inheritfrom = intval( mosGetParam( $_POST, 'inheritfrom', '0' ) );
			if ($inheritfrom == -1) {
				$errorcount = inheritACL( $row->parent_id, $row->group_id );
			} else if ($inheritfrom > 0) {
				$errorcount = inheritACL( $inheritfrom, $row->group_id );
			} else {
				$errorcount = 0;
			}
		}else{
			mosRedirect( 'index2.php?option='. $option, _JACL_G_FAIL_CREATE );
		}
	} else {
		if($row->group_id <= 25){
			$result = $acl->edit_group($row->group_id, $row->jaclplus, NULL, NULL, 'ARO');
		}else{
			$result = $acl->edit_group($row->group_id, $row->jaclplus, $row->name, $row->parent_id, 'ARO');
			if($old_name!=$row->name){
				//update ACL table as well if name change
				$query = "UPDATE #__jaclplus SET aro_value = '". strtolower( $row->name ) ."' WHERE aro_value = '". strtolower( $old_name )."'";
				$database->setQuery( $query );
				$result = $database->query();
				/* if(!$result){
					mosRedirect( 'index2.php?option='. $option .'&task=editA&id='. $row->group_id. '&hidemainmenu=1', _JACL_ACL_FAIL_EDIT );
				} */
			}
		}
	}

	switch ( $task ) {
		case 'apply':
			if($result){
				$msg = _JACL_G_SAVE_PASS. $row->name;
			}else{
				$msg = _JACL_G_SAVE_FAIL. $row->name;
			}
			mosRedirect( 'index2.php?option='.$option.'&task=editA&id='. $row->group_id. '&hidemainmenu=1', $msg );
			break;

		case 'save':
		default:
			if($result){
				$msg = _JACL_G_SAVE_PASS. $row->name;
			}else{
				$msg = _JACL_G_SAVE_FAIL. $row->name;
			}
			mosRedirect( 'index2.php?option='.$option, $msg );
			break;
	}
}

function cancelGroup( $option ) {
	mosRedirect( 'index2.php?option='. $option .'&task=view' );
}

function removeGroups( $cid, $option ) {
	global $database, $acl, $my;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		mosRedirect( 'index2.php?option='. $option, _JACL_SELECT_DELETE_ITEM );
	}

	if ( count( $cid ) ) {
		foreach ($cid as $gid) {
			// check for default groups
			if ( $gid <= 25 ) {
				$msg = _JACL_G_DELETE_DEFAULT;
 			} else if ( $gid == $my->gid ){
 				$msg = _JACL_G_DELETE_YOURS;
			} else {
				$old_name = $acl->get_group_name($gid);
				if($acl->del_group($gid)){
					$Queries = array();
					//$Queries[] = "UPDATE #__session SET gid = '18' WHERE gid = $gid";
					$Queries[] = "DELETE FROM #__session WHERE gid = $gid"; // logout group users
					$Queries[] = "UPDATE #__users SET gid = '18' WHERE gid = $gid";
					$Queries[] = "UPDATE #__core_acl_groups_aro_map SET group_id = '18' WHERE group_id = $gid";
					foreach( $Queries as $Query ) {
						$database->setQuery($Query);
						if (!$database->query()) {
							$echostr = $database->getErrorMsg()."<br/>\n";
							echo $echostr;
						}
					}

					$msg = _JACL_G_DELETE_PASS;
					//delet ACL table as well
					$query = "DELETE FROM #__jaclplus WHERE aro_value = '". strtolower( $old_name )."'";
					$database->setQuery( $query );
					$result = $database->query();
					if(!$result){
						$msg .= _JACL_G_DELETE_FAIL_ACL;
					}
				}else{
					$msg = _JACL_G_DELETE_FAIL;
				}
			}
		}
	}

	mosRedirect( 'index2.php?option='. $option, $msg );
}

function changeGroupBlock( $cid=null, $block=1, $option ) {
	global $database;

	if (count( $cid ) < 1) {
		$action = $block ? _JACL_BLOCK : _JACL_UNBLOCK;
		mosRedirect( 'index2.php?option='. $option, _JACL_SELECT_ITEM_TO.$action );
	}

	$cids = implode( ',', $cid );

	$query = "UPDATE #__groups"
	. "\n SET block = $block"
	. "\n WHERE id IN ( $cids )"
	;
	$database->setQuery( $query );
	if (!$database->query()) {
		mosRedirect( 'index2.php?option='. $option, $database->getErrorMsg() );
	}

	mosRedirect( 'index2.php?option='. $option );
}

function logoutGroup( $cid=null, $option, $task ) {
	global $database, $my;

	$cids = $cid;
	if ( is_array( $cid ) ) {
		if (count( $cid ) < 1) {
			mosRedirect( 'index2.php?option='. $option, _JACL_ITEM_TO_LOGOUT );
		}
		$cids = implode( ',', $cid );
	}

	$query = "DELETE FROM #__session"
 	. "\n WHERE gid IN ( $cids )"
 	;
	$database->setQuery( $query );
	$database->query();

	switch ( $task ) {
		case 'flogout':
			mosRedirect( 'index2.php', $database->getErrorMsg() );
			break;

		default:
			mosRedirect( 'index2.php?option='. $option, $database->getErrorMsg() );
			break;
	}
}

function showAccess( $option ) {
	global $database, $my, $acl, $mainframe;

	$query = "SELECT id, name"
	. "\n FROM #__groups"
	. "\n ORDER BY id"
	;
	$database->setQuery( $query );
	$groups = $database->loadObjectList();

	HTML_jaclplus::showAccess( $groups, $option );
}

function editAccess( $aid='-1', $option='com_jaclplus' ) {
	global $database, $my, $acl, $mainframe;

	// check to ensure only super admins can manage access level
	/* if ( $my->gid != 25 ) {
		mosRedirect( 'index2.php?option='.$option, _NOT_AUTH );
	} */

	if( $aid != -1 && $aid <= 2 ){
		$msg = _JACL_A_DEFAULT;
		mosRedirect( 'index2.php?option='. $option .'&task=listAL', $msg );
	}
	
	$query = "SELECT name"
	. "\n FROM #__groups"
	. "\n WHERE id = '".$aid."'"
	. "\n ORDER BY id"
	;
	$database->setQuery( $query );
	$name = $database->loadResult();

	$lists['name'] = '<input type="text" name="name" class="inputbox" size="40" value="'. htmlentities( $name ) .'" />';

	HTML_jaclplus::editaccess( $option, $aid, $lists );
}

function cancelAccess( $option ) {
	mosRedirect( 'index2.php?option='. $option .'&task=listAL' );
}

function saveAccess( $option, $task ) {
	global $database, $my, $acl;

	$row = new stdClass();
	$row->name = mosGetParam( $_POST, 'name', NULL );
	if (empty($row->name)) {
		mosRedirect( 'index2.php?option='. $option .'&task=listAL', _JACL_A_INVALID_NAME );
	}
	$row->id = mosGetParam( $_POST, 'id', -1 );
	if($row->id == -1){
		$isNew 	= true;
	}else if ($row->id < 2) {
		mosRedirect( 'index2.php?option='. $option .'&task=listAL', _JACL_A_INVALID_ID );
	}else{
		$isNew 	= false;
	}

	if ($isNew) {
		$database->setQuery( "SELECT MAX(id)+1 FROM #__groups" );
		$row->id = intval( $database->loadResult() );
		if ($row->id < 99) { //as limited by Joomla!
			$query = "INSERT INTO #__groups"
			. "\n SET id = '$row->id', name = '$row->name'"
			;
			$database->setQuery( $query );
			$result = $database->query();
			if(!$result){
				mosRedirect( 'index2.php?option='. $option .'&task=listAL', _JACL_A_FAIL_CREATE );
			}
			// Update super administrator access levels
			$database->setQuery( "SELECT jaclplus FROM #__core_acl_aro_groups WHERE group_id = '25'" );
			$jaclplus = $database->loadResult();
			if(empty($jaclplus)) {
				$jaclplus = $row->id;
			}else{
				$jaclplus = $jaclplus.",".$row->id;
			}
			$database->setQuery( "UPDATE #__core_acl_aro_groups SET jaclplus = '$jaclplus' WHERE group_id = '25'");
			$result = $database->query();
		} else {
			$result = false;
			$row->name = _JACL_A_REACH_MAX;
		}
	} else {
		$database->setQuery( "UPDATE #__groups SET name = '$row->name' WHERE id = $row->id");
		$result = $database->query();
	}

	switch ( $task ) {
		case 'applyAL':
			if($result){
				$msg = _JACL_A_SAVE_PASS. $row->name;
			}else{
				$msg = _JACL_A_SAVE_FAIL. $row->name;
			}
			mosRedirect( 'index2.php?option='. $option .'&task=editALA&hidemainmenu=1&id='.$row->id, $msg );
			break;

		case 'saveAL':
		default:
			if($result){
				$msg = _JACL_A_SAVE_PASS. $row->name;
			}else{
				$msg = _JACL_A_SAVE_FAIL. $row->name;
			}
			mosRedirect( 'index2.php?option='. $option .'&task=listAL', $msg );
			break;
	}
}

function removeAccesses( $cid, $option ) {
	global $database, $acl, $my;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		mosRedirect( 'index2.php?option='. $option .'&task=listAL', _JACL_SELECT_DELETE_ITEM );
	}

	if ( count( $cid ) ) {
		foreach ($cid as $aid) {
			// check for default groups
			if ( $aid <= 2 ) {
				$msg = _JACL_A_DELETE_DEFAULT;
			} else {
				$database->setQuery( "SELECT group_id, jaclplus FROM #__core_acl_aro_groups WHERE jaclplus LIKE '%$aid%'" );
				$rows = $database->loadObjectList();
				foreach ($rows as $row) {
					$jaclplusarray = explode(",", $row->jaclplus);
					$i = 0;
					$result = count( $jaclplusarray );
					while ($i < $result) {
						if (intval($jaclplusarray[$i]) == $aid) {
							array_splice( $jaclplusarray, $i, 1 );
						} else {
							$i++;
						}
					}
					if(count( $jaclplusarray )>0){
						$new_jaclplus = implode(",", $jaclplusarray);
					}else{
						$new_jaclplus = '0';
					}
					if($new_jaclplus != $row->jaclplus){
						$database->setQuery( "UPDATE #__core_acl_aro_groups SET jaclplus = '$new_jaclplus' WHERE group_id = $row->group_id");
						$result = $database->query();
					}
				}
				$database->setQuery( "DELETE FROM #__groups WHERE id = $aid" );
				if($database->query()){
					$Queries = array();
					$Queries[] = "UPDATE #__categories SET access = '2' WHERE access = $aid";
					$Queries[] = "UPDATE #__contact_details SET access = '2' WHERE access = $aid";
					$Queries[] = "UPDATE #__content SET access = '2' WHERE access = $aid";
					$Queries[] = "UPDATE #__mambots SET access = '2' WHERE access = $aid";
					$Queries[] = "UPDATE #__menu SET access = '2' WHERE access = $aid";
					$Queries[] = "UPDATE #__modules SET access = '2' WHERE access = $aid";
					$Queries[] = "UPDATE #__polls SET access = '2' WHERE access = $aid";
					$Queries[] = "UPDATE #__sections SET access = '2' WHERE access = $aid";
					foreach( $Queries as $Query ) {
						$database->setQuery($Query);
						if (!$database->query()) {
							$echostr = $database->getErrorMsg()."<br/>\n";
							echo $echostr;
						}
					}
					$msg = _JACL_A_DELETE_PASS;
				}else{
					$msg = _JACL_A_DELETE_FAIL;
				}
			}
		}
	}

	mosRedirect( 'index2.php?option='. $option .'&task=listAL', $msg );
}

/**
* build the select list for multi access levels
*/
function jaclplusMultiAccess( &$row ) {
	global $database;

	$jaclplusarray = explode( ",", $row->jaclplus );
	$i = 0;
	$result = count($jaclplusarray);
	while($i < $result){
		$jaclpluslists[$i] = new stdClass();
		$jaclpluslists[$i]->value = $jaclplusarray[$i];
		$i++;
	}

	$query = "SELECT id AS value, name AS text"
	. "\n FROM #__groups"
	. "\n ORDER BY id"
	;
	$database->setQuery( $query );
	$groups = $database->loadObjectList();
	$access = mosHTML::selectList( $groups, 'access', 'class="inputbox" size="8" multiple="true"', 'value', 'text', $jaclpluslists );

	return $access;
}

function jaclplus_check( $gid ) {
	global $database, $my, $acl;

	$ex_groups = $acl->get_group_children( $my->gid, 'ARO', 'RECURSE' );
	if (count($ex_groups)>0) {
		array_push($ex_groups, '29', '30');
	} else {
		$ex_groups = array( '29', '30'); 
	}
	if ( $my->gid != 25 ) {
		array_push($ex_groups, '25', $my->gid); //not allow to edit own group as well
	}
	// check to ensure only super admins can edit super admin info
	if ( ( $my->gid != 25 ) && ( in_array( $gid, $ex_groups ) ) ) {
		//mosRedirect( 'index2.php?option='.$option, _NOT_AUTH );
		return false;
	}
	return true;
}

function inheritACL( $gid, $inherit_gid ) {
	global $database, $acl, $my;
	
	$query = "SELECT * FROM #__jaclplus WHERE aro_value ='".strtolower( $acl->get_group_name( $gid ) )."' ";
	if ($my->gid != 25) $query .= "AND enable=1 "; 
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$inherit_group_name = strtolower( $acl->get_group_name( $inherit_gid ) );
	$status = 0;
	for ($i=0, $n=count( $rows ); $i < $n; $i++) {
		$row 	=& $rows[$i];
		$query = "INSERT INTO #__jaclplus SET aco_section = '".$row->aco_section."', "
			."aco_value = '".$row->aco_value."', "
			."aro_section = '".$row->aro_section."', "
			."aro_value = '".$inherit_group_name."', " //to new user
			.( $row->axo_section ? "axo_section = '".$row->axo_section."', " : "axo_section = NULL, " )
			.( $row->axo_value ? "axo_value = '".$row->axo_value."', " : "axo_value = NULL, ")
			."enable = '".( $row->enable ? 1 : 0)  ."'";
		$database->setQuery( $query );
		if(!$database->query()){
			$status++;
		}
	}
	return $status; // 0 for no error or ACL inherited
}
?>