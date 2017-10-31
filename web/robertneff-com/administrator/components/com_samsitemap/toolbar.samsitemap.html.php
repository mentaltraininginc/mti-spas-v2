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

if (!defined('samDS')){
    if (substr(PHP_OS, 0, 3) == 'WIN') {
            define ('samDS', '\\');
            } else { define ('samDS', '/');
          }
}

class TOOLBAR_samsitemap {

   function _SHOW_HELP() {
     global $samSMLang;
      mosMenuBar::startTable();
      TOOLBAR_samsitemap::cancel('cancel', $samSMLang->get('tb_cancel'));
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }


   function _Indexes() {
     global $samSMLang;
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::addNew('addIndex');
      mosMenuBar::editList('editIndex');
      TOOLBAR_samsitemap::cancel('cancel', $samSMLang->get('tb_cancel'));
      mosMenuBar::deleteList('', 'deleteindex');
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }


   function _EDIT_globals() {
     global $samSMLang;
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save('saveglobals',$samSMLang->get('tb_save'));
      TOOLBAR_samsitemap::cancel('cancelglobals', $samSMLang->get('tb_cancel'));
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }

   function _EDIT_SEARCH_SETTINGS() {
     global $samSMLang;
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save('savesearchsettings',$samSMLang->get('tb_save'));
      TOOLBAR_samsitemap::cancel('cancelsearch', $samSMLang->get('tb_cancel'));
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }

   function _EDIT_Index($notGS_or_new) {
     global $samSMLang;
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save('saveIndex',$samSMLang->get('tb_save'));
      mosMenuBar::save('saveIndex_exit', $samSMLang->get('tb_save_exit'));
      TOOLBAR_samsitemap::cancel('cancelindex', $samSMLang->get('tb_cancel'));
        switch ($notGS_or_new){
          case TRUE:
          mosMenuBar::divider();
          $rootitems = '<td align="right">'.$samSMLang->get('tb_root_items').'</td>';
          echo $rootitems;
          mosMenuBar::addNew('newrootitem', $samSMLang->get('tb_new_root_item'));
//          mosMenuBar::editList('editrootitem',$samSMLang->get('tb_edit_root_item'));
          mosMenuBar::deleteList('','deleterootitem',$samSMLang->get('tb_delete_root_item'));
          break;
          case FALSE:
          default:
          break;
          }
      mosMenuBar::spacer();
      mosMenuBar::endTable();
   }

   function _NEW_ROOT_ITEM() {
     global $samSMLang;
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::custom( 'selectitem', 'next.png', 'next_f2.png', $samSMLang->get('tb_select_item') );
      mosMenuBar::divider();
      mosMenuBar::cancel('editIndex', $samSMLang->get('tb_cancel'));
      mosMenuBar::endTable();
   }

   function IndexMgr() {
     global $samSMLang;
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save( 'saveconfig' );
      mosMenuBar::back();
      mosMenuBar::spacer();
      mosMenuBar::endTable();


   }


    function _SELECT_ROOT_ITEM (){
      global $samSMLang;
      mosMenuBar::startTable();
      mosMenuBar::spacer();
      mosMenuBar::save('saverootitem');
      mosMenuBar::cancel('newrootitem');
      mosMenuBar::endTable();

    }

    function cancel( $task='cancel', $alt='Cancel' ) {
            $image = mosAdminMenus::ImageCheckAdmin( 'cancel.png', '/administrator/images/', NULL, NULL, $alt, $task );
            $image2 = mosAdminMenus::ImageCheckAdmin( 'cancel_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 0 );
            $option = $_REQUEST['option'];
            $url = 'index2.php?option='.$option.'&amp;task='.$task;
            ?>
            <td>
            <a class="toolbar" href="javascript:window.location='<?php echo $url;?>';" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('<?php echo $task;?>','','<?php echo $image2; ?>',1);">
            <?php echo $image; ?>
            <?php echo $alt;?>
            </a>
            </td>
            <?php
    }
    
}

class samAdminLang{
  var $_lang = '';
  
          function samAdminLang(){
            global $mosConfig_absolute_path, $mosConfig_lang, $mosConfig_locale;
            
            $langdir = $mosConfig_absolute_path.samDS.'administrator'.samDS
                .'components'.samDS.'com_samsitemap'.samDS.'lang';
            $d = dir($langdir);
            while (false !== ($file = readdir($d->handle))){
              $files[] = strtolower($file);
            }

            if ($n = array_search('admin.samsitemap.lang.'
                .strtolower($mosConfig_locale).'.php', $files)){
              include ($d->path.samDS.$files[$n]);
            } else if ($n = array_search('admin.samsitemap.lang.'
                .strtolower($mosConfig_lang).'.php', $files)){
              include ($d->path.samDS.$files[$n]);
            } else {
              include ($d->path.samDS.'admin.samsitemap.lang.en_us.php');
            }
//                require_once ($mosConfig_absolute_path.'/administrator/components/com_samsitemap/lang/admin.samsitemap.lang.en-us.php');
                if (is_array($lang)){
                  foreach($lang as $key=>$val){
                    $this->_lang->$key = $val;
                  }
                }

          }
          function get ($idx){
          if (isset($this->_lang->$idx)){
            return $this->_lang->$idx;
          } else {
            return FALSE;
          }
        }
}
$GLOBALS['samSMLang'] =& new samAdminLang();
$GLOBALS['samlang'] =& $samSMlang->_lang;
//print $GLOBALS['samlang']->hide;
?>
