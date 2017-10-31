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

$samdir = $mosConfig_absolute_path.samDS.'administrator'.samDS.'components'.samDS.'com_samsitemap'.samDS;
require_once ($samdir.'admin.samsitemap.classes.php');
require_once ($samdir.'admin.samsitemap.html.php');

$request = null;

$psr = null;
if (isset($_POST['sr']) and is_array($_POST['sr'])){
  $psr = '';
  foreach ($_POST['sr'] as $key=>$val){
    if ($key == 'sr_search_clr'){
      $psr[$key] = mosGetParam($_POST['sr'],$key);
    } else {
    $psr[$key] = intval($_POST['sr'][$key]);
    }
  }
}

$pparams = null;
if (isset($_POST['params']) and is_array($_POST['params'])){
          $pparams = '';
          foreach ($_POST['params'] as $key => $val){
            $pparams[$key] = mosGetParam($_POST['params'],$key);
          }
}
$pgparams = null;
if (isset($_POST['gparams']) and is_array($_POST['gparams'])){
          $pgparams = '';
          foreach ($_POST['gparams'] as $key => $val){
            $pgparams[$key] = mosGetParam($_POST['gparams'],$key);
          }
}
$pconfigid = null;
if (isset($_REQUEST['configid'])){
  $pconfigid = ($_REQUEST['configid'] == 'new')? 'new':intval($_REQUEST['configid']);
}
$pconfigs = null;
if (isset($_POST['configs']) and is_array($_POST['configs'])){
  foreach ($_POST['configs'] as $key => $val){
    if (($key != 'itemid') or ($key != 'componentid')){
      if (!get_magic_quotes_gpc()){
        $pconfigs[$key] = $val;
        } else {
        $pconfigs[$key] = stripslashes($val);
        }
      } else {
    $pconfigs[$key] = mosGetParam($_POST['configs'],$key);
    }
  }
}
$ptask = null;
if (isset($_REQUEST['task'])){
  $ptask = mosGetParam($_REQUEST, 'task');
}
$pcid = null;
if (isset($_POST['cid']) and (is_array($_POST['cid']))){
  foreach($_POST['cid'] as $key => $val){
    $pcid[$key] = intval($val);
  }
}

$samSMconfig =& new samSMconfig ($pparams,$pgparams,$pconfigs);

if (!isset($ptask)){$ptask = '';}
switch ($ptask) {
    case 'saveglobals':
        if (isset($pparams) and isset($pconfigs) and isset($pconfigid)){
          $msg = $samSMconfig->saveIndex($pconfigid,$pparams,$pconfigs);
          $samSMconfig->clearcache();
        } else {
          $name = $_POST['configs']['name'];
          $msg = "Insufficient Parameters to save Index: $name";
        }
      mosRedirect('index2.php?option=com_samsitemap',$msg);
    break;

    case "saverootitem":
//    $configid = mosGetParam($_POST, 'configid');
    $smtype = mosGetParam($_POST, 'itemtype');
    $iid = mosGetParam($_POST, 'iid');
    $samSMconfig->saveRootItem($pconfigid, $smtype, $iid);


    case 'ritem_orderup':
    case 'ritem_orderdown':
    if (($ptask == 'ritem_orderup') or ($task == 'ritem_orderdown')){
      if (isset($pcid)){
        $msg = $samSMconfig->changeRootOrder ($pcid[0], $ptask);
      }
    }

    case "deleterootitem":
    if ($ptask == 'deleterootitem'){
    if (isset($pcid)){
          $msg = $samSMconfig->deleterootitem($pcid);
      }
    }


    $tab = '4';
    case "saveIndex":
      if ($ptask == 'saveIndex'){
        if (isset($pparams) and isset($pconfigs) and isset($pconfigid)){
          $msg = $samSMconfig->saveIndex($pconfigid,$pparams,$pconfigs);
          $pconfigid = ($pconfigid != 'new')? $pconfigid:intval($_POST['configid']);
        } else {
          $name = $_POST['configs']['name'];
          $msg = "Insufficient Parameters to save Index: $name";
        }
      }
      $samSMconfig->clearcache();

    case "editIndex":
    case "addIndex":
        switch (($ptask == 'editIndex') and isset($pcid)){
          case TRUE:
          case true:
            $html = $samSMconfig->editIndex($pcid['0']);
            print $html;
          break;
          case FALSE:
          case false:
          $tab = (isset($tab))? intval($tab): '1';
          if ($ptask == 'saveIndex'){
            $html = $samSMconfig->editIndex($pconfigid,FALSE,FALSE,FALSE,'1',$msg);
            print $html;
          } elseif (isset($pparams) and isset($pgparams) and isset($pconfigid)){
            $msg = (isset($msg))? $msg:'';
            $html = $samSMconfig->editIndex($pconfigid, TRUE, TRUE, TRUE, $tab,$msg);
            print $html;
          } else {
            $html = $samSMconfig->editIndex('new');
            print $html;
          }
          break;
          }

    break;

    case 'editglobals':
     $html = $samSMconfig->editIndex('1');
     print $html;
    break;

    case "newrootitem":
    $html = $samSMconfig->selectitemtype($pconfigid);
    print $html;
    break;

    case "editrootitem":
    $html = $samSMconfig->editrootitem();
    print $html;


    case 'selectitem':
    $itemtype = mosGetParam($_POST, 'itemtype');
    $html = $samSMconfig->selectItem($pconfigid,$itemtype);
    print $html;
    break;

    case "deleteindex":
    if (isset($pcid)){
      $msg = $samSMconfig->deleteindex($pcid);
    }
    $samSMconfig->clearcache();
    case "canceledit":
    if (isset($_POST['hidemainmenu'])){
    unset ($_POST['hidemainmenu']);
    unset ($_REQUEST['hidemainmenu']);
    }
    case "showindexes":
    case "cancelindex":
    if (isset($msg)){
        $html = $samSMconfig->showIndexes($msg);
    } else {
      $html = $samSMconfig->showIndexes();
    }
    print $html;
    break;

    case 'savesearchsettings':
    $msg = $samSMconfig->savesearchsettings($psr);
    $samSMconfig->clearcache();
    mosRedirect('index2.php?option=com_samsitemap',$msg);
    break;

    case 'searchsettings':
    $html = $samSMconfig->searchSettings();
    print $html;
    break;

    case 'showhelp':
    $html = $samSMconfig->showhelp();
    print $html;
    break;

    case 'clearcache':
      if ($ptask == 'clearcache'){
        $samSMconfig->clearcache();
        mosRedirect('index2.php?option=samsitemap', $samSMconfig->getLang('cpanel_clear_cache_msg'));
      }
    case "saveIndex_exit":
      if ($ptask == 'saveIndex_exit'){
        if (isset($pparams) and isset($pconfigs) and isset($pconfigid)){
          $msg = $samSMconfig->saveIndex($pconfigid,$pparams,$pconfigs);
        } else {
          $name = $_POST['configs']['name'];
          $msg = "Insufficient Parameters to save Index: $name";
        }

      $samSMconfig->clearcache();
      mosRedirect('index2.php?option=samsitemap', $msg);
      }
    default:
    $html = $samSMconfig->cpanel();
    print $html;
    break;
}
echo "<div style='clear:both' /><p><font class='small'><b>samSiteMap ver .6.2 beta</b> - &copy Copyright 2005 by Steve Graham - <a href='http://coders.mlshomequest.com/' target='_blank'>SAM Code Team</a></font></p>";

?>