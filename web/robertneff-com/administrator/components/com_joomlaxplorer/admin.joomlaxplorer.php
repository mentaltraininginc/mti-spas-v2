<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/** joomlaXplorer
* This is a component with full access to the filesystem of your joomla Site
* I wouldn't recommend to let in Managers
* allowed: Superadministrator
**/
if (!$acl->acl_check( 'administration', 'config', 'users', $my->usertype )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}
?>
<!--
Internet Explorer Transparency Fix
-->
<script type="text/javascript" src="components/com_joomlaxplorer/_style/sleight.js"></script>
<script type="text/javascript" src="components/com_joomlaxplorer/_style/sleightbg.js"></script>
<?php
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is index.php, released on 2003-04-02.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net

Comment:
	QuiXplorer Version 2.3
	Main File
	
	Have Fun...
------------------------------------------------------------------------------*/
define ( "_QUIXPLORER_PATH", $mosConfig_absolute_path."/administrator/components/com_joomlaxplorer" );
define ( "_QUIXPLORER_URL", $mosConfig_live_site."/administrator/components/com_joomlaxplorer" );
global $action;
//------------------------------------------------------------------------------
umask(002); // Added to make created files/dirs group writable
//------------------------------------------------------------------------------
require _QUIXPLORER_PATH . "/.include/init.php";	// Init
//------------------------------------------------------------------------------
$dir = mosGetParam( $_REQUEST, "dir" );
$action = stripslashes(mosGetParam( $_REQUEST, "action" ));
if( $action == "post" )
  $action = mosGetParam( $_REQUEST, "do_action" );
elseif( empty( $action ))
  $action = "list";
$item = mosGetParam( $_REQUEST, "item" );
switch($action) {		// Execute action
//------------------------------------------------------------------------------
  // EDIT FILE
  case "edit":
	  require _QUIXPLORER_PATH . "/.include/fun_edit.php";
	  edit_file($dir, $item);
  break;
//------------------------------------------------------------------------------
  // DELETE FILE(S)/DIR(S)
  case "delete":
	  require _QUIXPLORER_PATH . "/.include/fun_del.php";
	  del_items($dir);
  break;
//------------------------------------------------------------------------------
  // COPY/MOVE FILE(S)/DIR(S)
  case "copy":	case "move":
	  require _QUIXPLORER_PATH ."/.include/fun_copy_move.php";
	  copy_move_items($dir);
  break;
//------------------------------------------------------------------------------
  // DOWNLOAD FILE
  case "download":
	  if( strstr( $_SERVER['PHP_SELF'], "index2.php" ) ) {
		mosRedirect( $mosConfig_live_site . "/administrator/index3.php?". $_SERVER['QUERY_STRING']."&no_html=1" );
	  }
	  require _QUIXPLORER_PATH . "/.include/fun_down.php";
	  ob_end_clean(); // get rid of cached unwanted output
	  download_item($dir, $item);
	  ob_start(false); // prevent unwanted output
	  exit;
  break;
//------------------------------------------------------------------------------
  // UPLOAD FILE(S)
  case "upload":
	  require _QUIXPLORER_PATH . "/.include/fun_up.php";
	  upload_items($dir);
  break;
//------------------------------------------------------------------------------
  // CREATE DIR/FILE
  case "mkitem":
	  require _QUIXPLORER_PATH ."/.include/fun_mkitem.php";
	  make_item($dir);
  break;
//------------------------------------------------------------------------------
  // CHMOD FILE/DIR
  case "chmod":
	  require _QUIXPLORER_PATH ."/.include/fun_chmod.php";
	  chmod_item($dir, $GLOBALS["item"]);
  break;
//------------------------------------------------------------------------------
  // SEARCH FOR FILE(S)/DIR(S)
  case "search":
	  require _QUIXPLORER_PATH ."/.include/fun_search.php";
	  search_items($dir);
  break;
//------------------------------------------------------------------------------
  // CREATE ARCHIVE
  case "arch":
	  require _QUIXPLORER_PATH . "/.include/fun_archive.php";
	  archive_items($dir);
  break;
//------------------------------------------------------------------------------
  // EXTRACT ARCHIVE
  case "extract":
	  require _QUIXPLORER_PATH . "/.include/fun_archive.php";
	  extract_item($dir, $item);
  break;
//------------------------------------------------------------------------------
  // USER-ADMINISTRATION
  case "admin":
	  require _QUIXPLORER_PATH . "/.include/fun_admin.php";
	  show_admin($dir);
  break;
//------------------------------------------------------------------------------
  // joomla System Info, Missing in joomla >= 4.5.2
  case 'sysinfo':
	  require _QUIXPLORER_PATH . "/.include/fun_system_info.php";
  break;
//------------------------------------------------------------------------------
  // DEFAULT: LIST FILES & DIRS
  case "list":
  default:
	  require _QUIXPLORER_PATH . "/.include/fun_list.php";
	  list_dir($dir);
//------------------------------------------------------------------------------
}				// end switch-statement
//------------------------------------------------------------------------------
show_footer();
//------------------------------------------------------------------------------
?>
