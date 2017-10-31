<?php
/*samSiteMap™ beta, Version .6.2 (Alpha for non-english websites)
* Copyright © 2005, Steve Graham, SAM Code Team
*
* samSiteMap™ is free software; you can redistribute it and/or modify it under
* the terms of the GNU General Public License (GNU GPL) as published by the Free
* Software Foundation; either version 2 of the license, or (at your option) any
* later version, subject to our requirements listed in the license file
* included with this distribution.  If the license file has not been included
* in this distribution, you can find a copy at our website:
* http://coders.mlshomequest.com
*
* Derivative works must comply with the "Credit Requirements for Derivative Works"
* section in that file.
*
* In the event that there is a conflict between any current or future releaase
* of the GNU GPL, and any of our requirements stated in our license, Our
* requirements will take precedence and void the conflicting sections only,
* or conflicting subsections only of the GNU GPL license.
*
* Please note that the GPL states (and we require, in the event that the GNU GPL
* changes) that any headers in files, and Copyright notices, as well as credits
* in headers, source files and output (screens, prints, etc.) can not be removed.
* You can however, extend them with your own credits.  Make sure you understand
* our conditions for this, in the included license file, if you choose to create
* a derivative work based on samSiteMap.
*
* Per GNU GPL guidelines your derivative product must also be released under,
* and conform to, GNU GPL Licensing.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS  FOR A PARTICULAR PURPOSE.  See the GNU General
* Public License for more details.
* You should have recieved a copy of the GNU General Public License along with
* this program;  if not, write to the Free Software Foundation, Inc.,
* 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
* The "GNU General Public License" (GNU GPL) is available at:
* http://www.gnu.org/copyleft/gpl.html
*/
// ################################################################
// MOS Intruder Alerts
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// ################################################################


require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
         case "new":
        break;

        case 'editglobals':
           TOOLBAR_samsitemap::_EDIT_globals();
        break;
        
        case 'ritem_orderup':
        case 'ritem_orderdown':
        case "saverootitem":
        case "deleterootitem":
        case "saveIndex":
        case "editIndex":
        case "addIndex":
            switch (((isset($_POST['cid']) and ($_POST['cid']['0'] == '1')) and (($task != 'ritem_orderup') and ($task != 'ritem_orderdown'))) or ($task == 'addIndex') or ((isset($_POST['configid'])) and ($_POST['configid'] == '1'))){
              case true:
              case TRUE:
              TOOLBAR_samsitemap::_EDIT_Index(FALSE);
              break;
              case false:
              case FALSE:
              TOOLBAR_samsitemap::_EDIT_Index(TRUE);
              break;
            }
        break;

        case "newrootitem":
             TOOLBAR_samsitemap::_NEW_ROOT_ITEM();
        break;

        case 'selectitem':
            TOOLBAR_samsitemap::_SELECT_ROOT_ITEM();
        break;

        case "instructions";
        break;

        case "showindexes":
        case "deleteindex":
        case "cancelindex":
            TOOLBAR_samsitemap::_Indexes();
        break;

        case 'searchsettings':
            TOOLBAR_samsitemap::_EDIT_SEARCH_SETTINGS();
        break;
        
        case 'showhelp':
            TOOLBAR_samsitemap::_SHOW_HELP();
        break;

        default:
        case 'saveIndex_exit':
        case 'saveglobals':
        case 'cancel':
        break;
}
?>
