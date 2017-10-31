<?php
/*samSiteMap� beta, Version .6.2 (Alpha for non-english websites)
* Copyright � 2005, Steve Graham, SAM Code Team
*
* samSiteMap� is free software; you can redistribute it and/or modify it under
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
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed, fucker.' );
// ################################################################

if (!defined('samDS')){
    if (substr(PHP_OS, 0, 3) == 'WIN') {
            define ('samDS', '\\');
            } else { define ('samDS', '/');
          }
}

$samSMBasepath = $mosConfig_absolute_path.samDS."components".samDS. "com_samsitemap";
$samSMiconurl = $mosConfig_live_site.'/components/icons';


if (isset($_GET['configid']) /*and ($my->gid == '2') and ($my->usertype == 'Super Administrator')*/ and is_numeric($_GET['configid'])) {
  $where = "WHERE id='".intval($_GET['configid'])."' OR id='1' OR id='2'";
} elseif (isset($_GET['Itemid']) and (is_numeric($_GET['Itemid']))){
  $where = "WHERE itemid='".intval($_GET['Itemid'])."' OR id='1' or id='2'";
} else {
  $where = "WHERE id='2' OR id='1'";
}
  $sql = "SELECT * from #__samsitemap_indexes $where";
  $database->setQuery($sql);
  $rows = $database->loadObjectList('id');

  if (count($rows) > 0){
    foreach ($rows as $key=>$val){
      if(($val->id == '1') or ($val->id == '2')){
        continue;
      } else {
        $use_configid = $val->id;
      }
    }
  }
  $index = (isset($use_configid))? $rows[$use_configid]: $rows['2'];
  $gindex = $rows['1'];
  $params =& new mosParameters ($index->params);
  $params->def ('title', $index->title);
  $mainframe->SetPageTitle( $index->title );
  $gparams =& new mosParameters ($gindex->params);
  $srparams =& new mosParameters ($gindex->description);

$search_ok = $params->get('search_ok','111');
$gsearch_ok = $gparams->get('search_ok', '0');

if (isset($_GET['search']) and (($search_ok == '1') or (($search_ok == '111')and ($gsearch_ok == '1')))){
      $params->def ('search', mosGetParam($_GET, 'search'));
      $params->def ('active_search', '1');
      $params->def ('search_mode', ((isset($_GET['smode']))? intval($_GET['smode']): '0'));
} else {
  $params->def ('active_search','0');
  $params->def ('search_mode','0');
}

if (isset($_GET['view'])){
    switch ($_GET['view']){
      case 'list':
      case 'map':
      case 'search':
      $params->set ('view', mosGetParam($_GET, 'view'));
      break;
      default:
      break;
    }
}

if (isset($_GET['sort'])){
    switch ($_GET['sort']){
      case 'normal':
//      case 'alpha':
      case 'hits':
      case 'rating':
      case 'votes':
      case 'search':
      $params->set ('sort', mosGetParam($_GET, 'sort'));
      break;
      default:
      break;
    }
}

if (isset($_GET['desc'])){
    switch ($_GET['desc']){
      case '1':
      case '0':
      $params->set ('desc', mosGetParam($_GET, 'desc'));
      break;
      default:
      break;
    }
}

$langdir = $mosConfig_absolute_path.samDS
    .'components'.samDS.'com_samsitemap'.samDS.'lang';
$d = dir($langdir);
while (false !== ($file = readdir($d->handle))){
  $files[] = strtolower($file);
}
if ($n = array_search('samsitemap.lang.'
    .strtolower($mosConfig_locale).'.php', $files)){
  $language = strtolower($mosConfig_locale);
} else if ($n = array_search('samsitemap.lang.'
    .strtolower($mosConfig_lang).'.php', $files)){
  $language = strtolower($mosConfig_lang);
} else {
  $language = 'en_us';
}
$params->def( 'configid', ((isset($use_configid))? $use_configid: '2'));
$params->def( 'language', $language);
$params->def( 'path',$samSMBasepath );
$params->def( 'iconurl', $samSMiconurl);
$params->def( 'Itemid', ((isset($_GET['Itemid']) and (is_numeric($_GET['Itemid']))) ? mosGetParam($_GET, 'Itemid') : ''));
$params->def( 'page_description', $index->description);
if ((isset($_GET['access'])) and ($my->gid == '2') and ($my->usertype == 'Super Administrator')){
  $access_level = mosGetParam ($_GET, 'access');
  $params->def( 'usergid', (is_numeric($access_level))? $access_level:intval($my->gid));
} else {
  $params->def( 'usergid', $my->gid);
}


if ((($params->get('usecache') == '1') or (($params->get('usecache')=='111') and ($gparams->get('usecache') == '1'))) and ($params->get('active_search') == '0')) {
    $allparms['params']= $params->_params;
    $allparms['gparams']= $gparams->_params;
    $allparms = md5(serialize($allparms));

       require_once($mosConfig_absolute_path.samDS.'includes'.samDS.'Cache'.samDS.'Lite.php');

           $coptions = array(
            'cacheDir' => "$mosConfig_cachepath".samDS,
            'caching' => $mosConfig_caching,
            'defaultGroup' => 'com_samsitemap',
            'lifeTime' => $mosConfig_cachetime
            );
       $smcache = new Cache_Lite($coptions);

       if ($html = $smcache->get($allparms, 'com_samsitemap')) { // cache hit !
           print $html;
       } else { // page has to be (re)constructed in $data
           require ($samSMBasepath.samDS."samsitemap_classes.php");
           $samSiteMap =& new samSiteMap ( $database, $params, $gparams, $srparams );
           $html = $samSiteMap->get('html');
           $smcache->save($html, $allparms, 'com_samsitemap');
           print $html;
       }
} else {
    require ($samSMBasepath.samDS."samsitemap_classes.php");
    $samSiteMap =& new samSiteMap ( $database, $params, $gparams, $srparams );
    print $samSiteMap->get('html');
}

?>
