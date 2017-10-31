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

class samSMconfig {
  var $_adminalert = '';
  var $_gparams = '';
  var $_params = '';

    function samSMconfig($gparams='',$params='',$configs=''){
    $this->setLanguage();
    $this->setOpts($gparams, $params, $configs);
//    $this->getRequest($post, $get);
    }

    function setOpts(&$gparams, &$params, &$configs){
      if (is_array($gparams)){
        foreach ($gparams as $key => $val){
          $this->_gparams[$key] =& $gparams[$key];
          }
        } else {
          global $database;
          $sql = "SELECT id,params FROM #__samsitemap_indexes WHERE id='1'";
          $database->setQuery($sql);
          $ret = $database->loadObjectList('id');
          if ($ret){
            $this->_gparams = $this->readparams($ret['1']->params);
          }
        }

      if (is_array($params)){
        foreach ($params as $key => $val){
          $this->_params[$key] =& $params[$key];
        }
      }
      
      if (is_array($configs)){
        foreach ($configs as $key => $val){
          $this->_configs[$key] =& $configs[$key];
        }
      }
    }

        function setLanguage ($lang='en_us'){
          global $mosConfig_absolute_path, $samSMLang, $mosConfig_lang, $mosConfig_locale;
          if (is_object($samSMLang)){
            $this->_lang =& $samSMLang->_lang;
          } else {
            $langdir = $mosConfig_absolute_path.samDS.'administrator'.samDS
                .'components'.samDS.'com_samsitemap'.samDS.'lang';
            $d = dir($langdir);
            while (false !== ($file = readdir($d->handle))){
              $files[] = strtolower($file);
            }
            if ($n = array_search('admin.samsitemap.lang.'
                .strtolower($mosConfig_locale).'.php', $files)){
              include ($d->path.samDS.$files[$n]);
            } else if ($filenm = array_search('admin.samsitemap.lang.'
                .strtolower($mosConfig_lang).'.php', $files)){
              include ($d->path.samDS.$files[$n]);
            } else {
              include ($d->path.samDS.'admin.samsitemap.lang.en_us.php');
            }
            foreach ($lang as $key => $val){
              $this->_lang->$key = $val;
            }
          }
        }

        function getLang ($idx){
          if (isset($this->_lang->$idx)){
            return $this->_lang->$idx;
          } else {
            $alert = "No variable set in language file for $idx";
            $this->adminalert($alert);
            return FALSE;
          }
        }
        
        function getOpt ($val){
          if (isset($this->_options->$val)){
            return $this->_options->$val;
          } else {
            return '';
          }
        }
        
        function getGOpt ($val){
          if (isset($this->_goptions->$key)){
            return $this->_goptions->$key;
          } else {
            return '';
          }
        }

        function adminalert ($message){
          $this->_adminalert .= "<br />\n" . $message;
        }

    function showIndexes($msg='notset'){
      return samSM_HTML::showIndexes ($msg);
    }


    function cpanel(){
      return samSM_HTML::cpanel();
    }

    function editIndex ($smid, $params=FALSE, $configs=FALSE, $gparams =FALSE, $tab = '1', $msg=''){
        return samSM_HTML::editIndex($smid, $params, $configs, $gparams, $tab, $msg);

    }
    
    function showhelp (){
        return samSM_HTML::showhelp();
    }
    
    function tTip ($text, $hpos='r', $vpos='b'){
      global $mosConfig_live_site;

      $hpos = ($hpos == 'r')? 'RIGHT':'LEFT';
      $vpos = ($vpos == 'b')? 'BELOW':'ABOVE';
      $text = addcslashes($text,'"');
    $html = "<a href='#' onMouseOver='hideselects();return overlib(\"".$text."\", CAPTION, \"&nbsp;&nbsp;&nbsp;&nbsp;".$this->getLang('index_asst')."&nbsp;&nbsp;&nbsp;&nbsp;\", $vpos, $hpos, OFFSETX, 20);' onmouseout='showselects();return nd();'><img src='".$mosConfig_live_site."/includes/js/ThemeOffice/tooltip.png' border='0' /></a>";


    return $html;
    }

    function jshideselect(){
        $js = 'function hideselects(){
          if (navigator.appName == "Microsoft Internet Explorer"){
          svn=document.adminForm.getElementsByTagName("SELECT");
          for (a=0;a<svn.length;a++){
          svn[a].style.visibility="hidden";
          }
          }
        }
        function showselects(){
          if (navigator.appName == "Microsoft Internet Explorer"){
          svn=document.adminForm.getElementsByTagName("SELECT");
          for (a=0;a<svn.length;a++){
          svn[a].style.visibility="visible";
          }
          }
        }';
        return $js;
    }

    function htmlRadioGrp($smid, $cval, $name, $block, $labels=null){
        if ($labels == null){
          $hide = $this->getLang('hide');
          $show = $this->getLang('show');
          $global = $this->getLang('useglobal');
        } else {
          $hide = $this->getLang ($labels[0]);
          $show = $this->getLang ($labels[1]);
          $global = $this->getLang ($labels[2]);
        }
      $html = "<input type='radio' name='$name' value='0' ".$this->checkedtest($cval, '0')." />"
        ."$hide
        <input type='radio' name='$name' value='1' ".$this->checkedtest($cval, '1')." />"
        ."$show";
      $html .= ($smid == $block)? '':
        "<input type='radio' name='$name' value='111' ".$this->checkedtest($cval, '111')." />"
        ."$global";
      return $html;
    }

    function selecttest ($option, $val){
        if ($option == $val){
          return "selected='selected'";
        } else {
          return '';
        }
    }

    function checkedtest ($option, $val){
        if ($option == $val){
          return "checked='checked'";
        } else {
          return '';
        }
    }

    function selectitemtype($configid) {
      return samSM_HTML::selectitemtype($configid);
    }

    function selectItem ($configid,$itemtype){
        return samSM_HTML::selectItem($configid,$itemtype);
    }
    
    function searchSettings(){
      return samSM_HTML::searchSettings();
    }

    function saveRootItem($configid, $smtype, $id, $itemid='none'){
      global $database;

      $id = (is_numeric($id))? $id : FALSE;
      $configid = (is_numeric($configid))? $configid : FALSE;
      if ((!$id) or (!$configid)){return FALSE;}

      $sql = "SELECT MAX(ordering) as ordering FROM #__samsitemap_items WHERE config_id='$configid'";
      $database->setQuery($sql);
      $result = $database->loadObjectList();
      $result = $result['0'];
      $neword = $result->ordering + 1;

      $itemidsql = ($itemid != 'none')? 'itemid,':'';
      $itemidval = ($itemid != 'none')? "'".$itemid."'," : '';
      $sql = "INSERT INTO #__samsitemap_items (id,$itemidsql smtype,ordering,config_id,componentid)"
        ."\n VALUES ('0',$itemidval '$smtype','$neword','$configid','$id')";
      $database->setQuery($sql);
      $database->query();
      

    }
    
    function changeRootOrder($id, $task){
      global $configid, $database;
      $id = (is_numeric($id))? intval($id):FALSE;
      $configid = (is_numeric($configid))? intval($configid):FALSE;
      if ((!$id) or (!$configid)){return FALSE;}
      
      $sql = "SELECT id,ordering,config_id FROM #__samsitemap_items WHERE "
        ."config_id='$configid'"
        ."\n ORDER BY ordering ASC";
      $database->setQuery($sql);
      $result = $database->loadObjectList('id');
      if (is_array($result) and (count($result) > 0)){
        $ids = '';
        $orders = '';
        $gaps = '';
        $commons = '';
        $cnt = count(get_object_vars($result))-1;
        $n = $cnt;
        $lastorder = 0;
            foreach($result as $row){
              if ($lastorder != ($row->ordering - 1)){
                switch (TRUE){
                case ($lastorder == $row->ordering):
                $commons[] = array('id'=>$row->id,'ordering'=>$row->ordering);
                break;
                case ($lastorder < ($row->ordering - 1)):
                $gaps[] = array(0=>$lastorder,1=>$row->ordering);
                break;
                }
              }
              $rowid = $row->id;
              $roworder = $row->ordering;
              $ids->$rowid =& $result[$rowid];
              $orders->$roworder =& $result[$rowid];
              $n--;
              $lastorder = $row->ordering;
            }
        }
        $changed = '0';

        if (isset($gaps) and is_array($gaps)){
          //gaps found, close them.
            $sofar = 0;
          foreach ($gaps as $key => $val){
            $diff = ($gaps[$key][1] - $gaps[$key][0])-1;

            $low = $gaps[$key][0] - $sofar;
            $sofar = $sofar + $diff;
            $sql = "UPDATE #__samsitemap_items SET ordering=ordering-$diff"
                ."\nWHERE config_id='$configid' and ordering > $low";
            $database->setQuery($sql);
            $database->query();
          }
          $changed = '1';
          unset($gaps);
        }
          
          if (isset($commons) and is_array($commons)){

            if ($changed = '1'){
              $sql = "SELECT id,ordering,config_id FROM #__samsitemap_items WHERE "
                ."config_id='$configid'"
                ."\n ORDER BY ordering ASC";
              $database->setQuery($sql);
              $result = $database->loadObjectList('id');
              if (is_array($result) and (count($result) > 0)){
                $ids = '';
                $orders = '';
                $gaps = '';
                $commons = '';
                $cnt = count(get_object_vars($result))-1;
                $n = $cnt;
                $lastorder = 0;
                foreach($result as $row){
                  if ($lastorder != ($row->ordering - 1)){
                    switch (TRUE){
                    case ($lastorder == $row->ordering):
                    $commons[] = array('id'=>$row->id,'ordering'=>$row->ordering);
                    break;
                    case ($lastorder < ($row->ordering - 1)):
                    $gaps[] = array(0=>$lastorder,1=>$row->ordering);
                    break;
                    }
                  }
                  $rowid = $row->id;
                  $roworder = $row->ordering;
                  $ids->$rowid =& $result[$rowid];
                  $orders->$roworder =& $result[$rowid];
                  $n--;
                  $lastorder = $row->ordering;
                  }
              }
            }
                $sofar = 0;
                $change = 0;
                $lastorder = 0;
            foreach ($commons as $key=>$val){
              $change = ($val['ordering'] == $lastorder)? $change:$sofar;
              $neworder = $val['ordering'] + $change;
              $sql = "UPDATE #__samsitemap_items SET ordering=ordering+1"
                ."\nWHERE ordering > $neworder or id='".$val['id']."'";
              $database->setQuery($sql);
              $database->query();
              $lastorder = $val['ordering'];
              $sofar = $sofar + 1;
            }
          unset($commons);
          $changed = '1';
          }

          // Now start over...
          if ($changed == '1'){
              $sql = "SELECT id,ordering,config_id FROM #__samsitemap_items WHERE "
                ."config_id='$configid'"
                ."\n ORDER BY ordering ASC";
              $database->setQuery($sql);
              $result = $database->loadObjectList('id');
              if (is_array($result) and (count($result) > 0)){
                $ids = '';
                $orders = '';
                $gaps = '';
                $commons = '';
                $cnt = count(get_object_vars($result))-1;
                $n = $cnt;
                $lastorder = 0;
                foreach($result as $row){
                  if ($lastorder != ($row->ordering - 1)){
                    switch (TRUE){
                    case ($lastorder == $row->ordering):
                    $commons[] = array('id'=>$row->id,'ordering'=>$row->ordering);
                    break;
                    case ($lastorder < ($row->ordering - 1)):
                    $gaps[] = array(0=>$lastorder,1=>$row->ordering);
                    break;
                    }
                  }
                  $rowid = $row->id;
                  $roworder = $row->ordering;
                  $ids->$rowid =& $result[$rowid];
                  $orders->$roworder =& $result[$rowid];
                  $n--;
                  $lastorder = $row->ordering;
                }
              }
            }
            if (is_array($gaps) or is_array($commons)){
              return 'error';}


       $order = $ids->$id->ordering;
       $prevorder = $order - 1;
       $nextorder = $order + 1;
       if ($task == 'ritem_orderup')$previd = $orders->$prevorder->id;
       if ($task == 'ritem_orderdown')$nextid = $orders->$nextorder->id;
      switch ($task){
        case 'ritem_orderup':
            $sql = "UPDATE #__samsitemap_items SET ordering='$order' WHERE id='$previd'"
                ." AND config_id='$configid'";
            $database->setQuery($sql);
            $test = $database->query();
            if ($test){
            $sql = "UPDATE #__samsitemap_items SET ordering='$prevorder' WHERE id='$id'"
                ." AND config_id='$configid'";
            $database->setQuery ($sql);
            $database->query();
            }
        break;
        case 'ritem_orderdown':
            $sql = "UPDATE #__samsitemap_items SET ordering='$order' WHERE id='$nextid'"
                ." AND config_id='$configid'";
            $database->setQuery($sql);
            $test = $database->query();
            if ($test){
            $sql = "UPDATE #__samsitemap_items SET ordering='$nextorder' WHERE id='$id'"
                ." AND config_id='$configid'";
            $database->setQuery ($sql);
            $database->query();
            }
        break;
      }
    }

    
    function getMenuDesc ($id){

    }

    function clearcache(){
      global $mosConfig_absolute_path, $mosConfig_cachepath, $mosConfig_caching;
      global $mosConfig_cachetime;
          //clear the cache
          if (!isset($this->_cache)){
          require_once($mosConfig_absolute_path.samDS.'includes'.samDS.'Cache'.samDS.'Lite.php');
           $coptions = array(
            'cacheDir' => "$mosConfig_cachepath/",
            'caching' => $mosConfig_caching,
            'defaultGroup' => 'com_samsitemap',
            'lifeTime' => $mosConfig_cachetime
            );
          $this->_cache = new Cache_Lite($coptions);
          }
          if (!isset($this->_cache_cleaned)){
            $this->_cache->clean('com_samsitemap');
            $this->_cache_cleaned = '1';
          }
    }

    
    function saveIndex ($configid, $params, $configs) {
            global $database;
        if (is_array( $params )) {
            $parms = array();
            foreach ($params as $key=>$val) {
                $txt[] = "$key=$val";
                }
                $parms = implode( "\n", $txt );
        }
        if ($configid != 'new'){
          if (isset($params['itemid']) and is_numeric($params['itemid'])){
          $sql = "UPDATE #__samsitemap_indexes SET itemid='' WHERE itemid='".$configs['itemid']."'";
          $database->setQuery($sql);
          $database->query();
          }
          $desc_set = ($configid == '1')? '':",description='".addslashes(@$configs['description'])."'";

          $sql = "UPDATE #__samsitemap_indexes SET name='".addslashes(@$configs['name'])
            ."',title='".addslashes(@$configs['title'])."',search_title='"
            .addslashes(@$configs['search_title'])."',"
            ."itemid='".@$configs['itemid']."',params='$parms'$desc_set"
            ."\nWHERE id='$configid'";

        } else {
          if (isset($params['itemid']) and is_numeric($params['itemid'])){
          $sql = "UPDATE #__samsitemap_indexes SET itemid='' WHERE itemid='".$params['itemid']."'";
          $database->setQuery($sql);
          $database->query();
          }
          $sql = "INSERT INTO #__samsitemap_indexes (id,name,title,search_title,"
            ."itemid,params,description) VALUES ('0','".addslashes(@$configs['name'])."','"
            .addslashes($configs['title'])."','".addslashes($configs['search_title'])."','".@$configs['itemid']."','$parms','"
            .addslashes(@$configs['description'])."')";
        }
        $database->setQuery($sql);
        $ret = $database->query();
        if ($configid == 'new'){$_POST['configid'] = $database->insertid();}
//        $this->clearcache();
        if ($ret != false){
          return $configs['name'].' '.$this->getLang('save_success');
        } else {
          return $this->getLang('save_failure').' '.$configs['name'];
        }
    }

    function savesearchsettings($params){
        global $database;
        if (is_array( $params )) {
            $parms = array();
            foreach ($params as $key=>$val) {
                $txt[] = "$key=$val";
                }
                $parms = implode( "\n", $txt );
        }
      $sql = "UPDATE #__samsitemap_indexes SET description='$parms' WHERE id='1'";
      $database->setQuery($sql);
      $ret = $database->query();
      if ($ret != false){
        return $this->getLang('sr_title').' '.$this->getLang('saved');
      } else {
        return $this->getLang('not_saved').' '.$this->getLang('sr_title');
      }
    }

    function deleterootitem($arryids){
      global $database;
        if (is_array($arryids)){
          $where = "WHERE id='".join("' OR id='", $arryids)."'";
          $sql = "DELETE FROM #__samsitemap_items $where";
          $database->setQuery($sql);
          $ret = $database->query();
          if ($ret != false) {
            return 'Index Deleted';
          } else {
            return 'Error Deleting Index';
          }
        }
    }

    function deleteindex($arryids){
      global $database;
        $ret = false;
        $alert = '';
        if (is_array($arryids)){
          foreach ($arryids as $key=>$val){
            if ($val == '1' or $val == '2'){
              unset ($arryids[$key]);
              $alert = $this->getLang('delete_index_not_allowed').'&nbsp;&nbsp;';
            }
          }
          if (count($arryids) > 0){
          $where = "WHERE id='".join("', OR id='", $arryids)."'";
          $sql = "DELETE FROM #__samsitemap_indexes $where";
          $database->setQuery($sql);
          $ret = $database->query();
          }
          if ($ret != false) {
            $where = "WHERE config_id='".join("', OR config_id='",$arryids)."'";
            $sql = "DELETE FROM #__samsitemap_items $where";
            $database->setQuery($sql);
            $ret = $database->query();
            if ($ret != false){
              return $alert.$this->getLang('delete_index_successful');
            }
          } else {
            return $alert.$this->getLang('delete_index_failed');
          }
          }
    }

    function editorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
        global $_MAMBOTS;
        $html ='';
        $results = $_MAMBOTS->trigger( 'onEditorArea', array( $name, $content, $hiddenField, $width, $height, $col, $row ) );
        foreach ($results as $result) {
            if (trim($result)) {
                $html .= $result;
                }
        }
    return $html;
    }

    function readparams($txt){
        $text = explode ("\n", $txt);
        $ret = FALSE;
            if (is_array($text) and ($text[0] != $txt)){
              foreach ($text as $line){
                $line = trim($line);
                if ($line == ''){continue;}
                $newval = explode('=',$line);
                
                if ($newval['0'] != $line){
                    $nkey = trim($newval['0']);
                    if ($nkey == ''){continue;}
                    $nval = (isset($newval['1']))?trim($newval['1']):'';
                    $ret[$nkey] = $nval;
                }
              }
            }
        unset ($txt);
        unset ($text);
        return $ret;
    }

    function setNewParams($retarray){
      $params = array('useconfig'=>'0','pospri'=>'','usecache'=>'111','noauth'=>'111',
            'showself'=>'111','menutitles'=>'111','desc'=>'111','icons'=>'111','showempty'=>'111',
            'multirender'=>'111','view'=>'111','sort'=>'111','showmenu'=>'111','search_ok'=>'111',
            'showview'=>'111','showsearch'=>'111','showsort'=>'111','ratingsort'=>'111','showdesc'=>'111',
            'exp_sections'=>'111','exp_categories'=>'111','exp_content'=>'111',
            'exp_nf_cat'=>'111','exp_newsfeeds'=>'111','exp_wl_cat'=>'111','exp_weblinks'=>'111',
            'exp_ct_cat'=>'111','exp_contacts'=>'111' );
      if ($retarray == 1){
        return $params;
      } else {
        $sparams = '';
        foreach ($params as $key=>$val){
          $sparams .= "$key=$val\n";
        }
          return $sparams;

      }
    }
}


?>
