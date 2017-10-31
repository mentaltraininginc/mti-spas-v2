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

class samSM_HTML {

    function cpanel(){
      global $mosConfig_live_site;
      $imgp = $mosConfig_live_site.'/administrator/images/';
      $link = $mosConfig_live_site.'/administrator/index2.php?option=com_samsitemap&amp;task=';
      $form = '';
      $form .= "<table class=\"adminheading\">
        <tr>
        <th class=\"cpanel\">&nbsp;".
        ($this->getLang('samSiteMap').'::'.$this->getLang('cpanel_title'))."
        </th>
        </tr>
        </table>
        <form action='index2.php' method='post' name='adminForm'>
        <table cellpadding='3' cellspacing='0' border='0' style='width:700px;height:300px' class='adminlist'>
        <tr class='row0'>
        <td style='vertical-align:center;text-align:center;width:33%'><a href='".$link."editglobals'><img src='".$imgp."impressions.png' width=\"48px\" height=\"48px\" align=\"middle\" border=\"0\"/></a><br />".$this->getLang('cpanel_global_defaults')."
        </td>
        <td style='vertical-align:center;text-align:center;width:33%'><a href='".$link."showindexes'><img src='".$imgp."sections.png' width=\"48px\" height=\"48px\" align=\"middle\" border=\"0\"/></a><br />".$this->getLang('cpanel_index_manager')."
        </td>
        <td style='vertical-align:center;text-align:center;width:33%'><a href='".$link."searchsettings'><img src='".$imgp."searchtext.png' width=\"48px\" height=\"48px\" align=\"middle\" border=\"0\"/></a><br />".$this->getLang('cpanel_search_settings')."
        </td>
        </tr>
        <tr class='row0'>
        <td style='vertical-align:center;text-align:center;width:33%'><a href='".$link."clearcache'><img src='".$imgp."trash.png' width=\"48px\" height=\"48px\" align=\"middle\" border=\"0\"/></a><br />".$this->getLang('cpanel_clear_cache')."
        </td>
        <td style='vertical-align:center;text-align:center;width:33%'><!-- <a href='".$link."searchsettings'><img src='".$imgp."searchtext.png' width=\"48px\" height=\"48px\" align=\"middle\" border=\"0\"/></a><br />".$this->getLang('cpanel_search_settings')."-->
        </td>
        <td style='vertical-align:center;text-align:center;width:33%'><a href='".$link."showhelp'><img src='".$imgp."support.png' width=\"48px\" height=\"48px\" align=\"middle\" border=\"0\"/></a><br />".$this->getLang('cpanel_help')."
        </td>
        </tr>
        </table>
        </form>";
      return $form;
    }

    function showhelp(){
      global $mosConfig_absolute_path;
      $dir = $mosConfig_absolute_path.samDS.'administrator'.samDS.'components'.samDS.'com_samsitemap'.samDS;
        $sr =& $this;
        $l = 'getLang';
      $form = "<table class=\"adminheading\">
                <tr>
                        <th class=\"support\">
                        ".$sr->$l('samSiteMap').'::'.$sr->$l('cpanel_help')."
                        </th>
                </tr>
                </table>
                <form action='index2.php' method='post' name='adminForm'>\n
         <table style='padding:0 10 10 10;width:90%;' class=\"adminlist\">
         <tr class='row0'>
         <td style='padding:10px'>
         ";
//     ob_start();
    include ($dir.'admin.samsitemap.help.htm.php');
//     $form .= ob_get_contents();
//     ob_end_clean();
     $form .= "$page
     </td>
     </tr>
     </table>";
     return $form;

    }

    function showIndexes($msg='notset'){
      global $database, $option, $mosConfig_list_limit, $mainframe, $samSMconfig;
        $l = "getLang";
        $sr =& $this;

        $limit = $mainframe->getUserStateFromRequest( "viewlistlimit",
            'limit', $mosConfig_list_limit );
        $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart",
            'limitstart', 0 );
        $database->setQuery( "SELECT count(*) FROM #__samsitemap_indexes" );
        $total = $database->loadResult();

        require_once( $GLOBALS['mosConfig_absolute_path']
            .samDS. 'administrator'.samDS.'includes'.samDS.'pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

      $sql = "SELECT sc.name as name, sc.title AS title, sc.itemid AS itemid,"
        . " sc.id AS id, sc.search_title as stitle, m.name as mentitle, "
        . "m.id as mid, m.link, m.menutype AS menutype from #__samsitemap_indexes"
        . " AS sc "
        ."\n LEFT JOIN #__menu AS m ON m.id = sc.itemid AND m.link LIKE('index.php?option=com_samsitemap')"
        ."\n ORDER BY id ASC"
        ."\n LIMIT $pageNav->limitstart,$pageNav->limit";

      $database->setQuery($sql);
      $rows = $database->loadObjectList();
      $count = count($rows);
      $msghtml = ($msg == 'notset')? '':
        "<tr>
        <td colspan='7' align='left'><b>$msg</b></td>
        </tr>";
      $form = "<table class=\"adminheading\">
                <tr>
                        <th class=\"sections\">
                        ".$sr->$l('samSiteMap').'::'.$sr->$l('showconfigs_title')."
                        </th>
                </tr>
                </table>
                <form action='index2.php' method='post' name='adminForm'>\n"
         ."<table class=\"adminlist\">"
         .$msghtml
         ."<tr>"
         ."<th width='20px'>#</th>
                        <th width=\"20px\">
                        <input type=\"checkbox\" name=\"toggle\" value=\"\" onclick=\"checkAll($count);\" />
                        </th>
                        <th class=\"title\" width=\"15%\"  align=\"left\">
                        ".$sr->$l('showconfigs_config_name')."
                        </th>
                        <th nowrap=\"nowrap\" width=\"15%\"  align=\"left\">
                        ".$sr->$l('showconfigs_page_title')."
                        </th>
                        <th nowrap=\"nowrap\"  width=\"15%\" align=\"left\">
                        ".$sr->$l('showconfigs_search_title')."
                        </th>
                        <th nowrap=\"nowrap\" width=\"10%\"  align=\"left\">
                        ".$sr->$l('showconfigs_assignment')."
                        </th>
                        <th nowrap=\"nowrap\" width=\"10%\"  align=\"left\">
                        ".$sr->$l('showconfigs_menu_type')."
                        </th>
                        <th nowrap=\"nowrap\" align=\"left\">
                        ".$sr->$l('showconfigs_menu_item_title')."
                        </th>
                </tr>";


      if (isset($rows)){
        $notset = $sr->$l('notset');
        $na = $sr->$l('na');
        $notused = $sr->$l('notused');
        $itemid_label = $sr->$l('showconfigs_itemid');

        $class = '0';
        for ($i=0, $n=count( $rows ); $i < $n; $i++) {
          $row =& $rows[$i];
          $type = '';
          $id = $row->id;
          if ($id == '1'){continue;}
          $classt = "class='row$class'";
          $idbox = mosHTML::idBox ($i, $row->id, FALSE );
          if (($id == '1') or ($id =='2')){
          $type = ($id == '1')? 'global':'default';
          $name = $sr->$l($type.'_Index_name');
          $title = ($id == '1')? $na : (($row->title != '')? $row->title: $notset);
          $mentitle = ($id == '1')? $na : (($row->mentitle != '')? $row->mentitle: $notset);
          $menutype = ($id == '1')? $na : (($row->menutype != '')? $row->menutype: $notset);
          $itemid = ($id == '1')? $na : (($row->itemid != '')? $itemid_label.$row->itemid: $notset);
          $stitle = ($id == '1')? $na : (($row->stitle != '')? $row->stitle: $notset);
          } else {
          $name = $row->name;
          $title = $row->title;
          $mentitle = ($row->mentitle != '')? $row->mentitle: $notset;
          $menutype = ($row->menutype != '')? $row->menutype: $notset;
          $menid = ($row->mid != '')? $row->mid: $notset;
          $itemid = ($row->itemid != '')? $itemid_label.$row->itemid: $notset;
          $stitle = ($row->stitle != '')? $row->stitle: $notset;
          }

          $form .= "<tr $classt>\n"
          . "<td >".$pageNav->rowNumber($i )."</td>
          <td >$idbox</td>
          <td ><a href='#editIndex' onclick=\"return listItemTask('cb".$i."','editIndex')\">$name</a></td>
          <td >$title</td>
          <td >$stitle</td>
          <td >$itemid</td>
          <td nowrap=\"nowrap\" >$menutype</td>
          <td nowrap=\"nowrap\" >$mentitle</td>

          </tr>";
          $class = ($class == '0')? '1':'0';

        }

      }
      $form .= $pageNav->getListFooter()."</table><input type=\"hidden\" name=\"option\" value=\"$option\" />
                <input type=\"hidden\" name=\"task\" value=\"\" />
                <input type=\"hidden\" name=\"boxchecked\" value=\"0\" />
                <input type='hidden' name='hidemainmenu' value='1' />
                </form>";
      return $form;
    }


    function editIndex ($smid, $params=FALSE, $configs=FALSE, $gparams =FALSE, $tab = '1', $msg=''){
      global $database, $mainframe, $mosConfig_list_limit, $mosConfig_live_site;
      global $mosConfig_absolute_path, $mosConfig_offset, $my, $option;
      $sr =& $this;
      $l = 'getLang';

        if (($params) and ($configs) and ($gparams)){
          $temp ='';
          foreach ($this->_params as $key => $val){
            $temp .="$key=$val\n";
          }
          $params =& new mosParameters($temp);
          $temp ='';
          foreach ($this->_configs as $key => $val){
            $temp .="$key=$val\n";
          }
          $configs =& new mosParameters($temp);
          $temp ='';
          foreach ($this->_gparams as $key => $val){
            $temp .="$key=$val\n";
          }
          $gparams =& new mosParameters($temp);
        } else {
            $where = (($smid == 'new') or ($smid == '1'))? " WHERE id='1'":" WHERE id='$smid' OR id='1'";
            $database->setQuery( "SELECT * FROM #__samsitemap_indexes $where" );
            $config = $database->loadObjectList('id');
            if (count($config) == '0'){
              $msg = "Error encountered loading configuration for Configurationid ".$smid;
              mosRedirect('index2.php?option='.$_POST['option'], $msg);
            }
            if ($smid != 'new'){
              $temp = '';
              foreach ($config[$smid] as $key => $val){
                if (($key == 'params') or ($key == 'description')){ continue;}
                $temp .="$key=$val\n";
              }
              $configs =& new mosParameters($temp);
              $configs->set('description', $config[$smid]->description);
              $ref =& $config[$smid];
              $params = new mosParameters($ref->params);
              $ref =& $config['1'];
              $gparams =& new mosParameters($ref->params);
            } else {
              $configs =& new mosParameters('');
              $configs->def('name', $sr->$l('newIndex_def_name'));
              $configs->def('title', $sr->$l('newIndex_def_title'));
//                .'\ntitle='.$this->getLang('editIndex_db_title'));
              $ref =& $config['1'];
              $gparams =& new mosParameters($ref->params);
              $params =& new mosParameters($this->setNewParams('0'));
            }
        }
        $sql = "SELECT count(*) FROM #__samsitemap_items WHERE config_id='".$smid."'";
        $database->setQuery( $sql );
        $total = $database->loadResult();
        $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit',
            $mosConfig_list_limit );
        $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart",
            'limitstart', 0 );
        $where = "WHERE config_id = '".$smid."'";
        require_once( $GLOBALS['mosConfig_absolute_path']
            .samDS.'administrator'.samDS.'includes'.samDS.'pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );
        $sql = "SELECT i.id as id, i.itemid as itemid, i.smtype as smtype,"
            ." i.ordering as ordering, tp.position as tpname, tp.id as tpid, "
            ."mdl.id as mdlid, mdl.title as mdlname, mi.id as miid, mi.name as "
            ."miname  FROM #__samsitemap_items as i"
            ."\nLEFT JOIN #__template_positions as tp ON (tp.id = i.componentid) "
            ."\nLEFT JOIN #__menu as mi ON (mi.id = i.componentid) "
            ."\nLEFT JOIN #__modules as mdl ON (mdl.id = i.componentid)"
            ."\n $where "
            ."\nORDER BY i.ordering ASC"
            ."\n LIMIT $pageNav->limitstart,$pageNav->limit";

      $database->setQuery($sql);
      $rows = $database->loadObjectList();
      $count = count($rows);

      $sql = "SELECT m.id as id, m.menutype as menutype, m.name as name, m.type"
        ." as type, m.published as published, m.componentid as componentid, "
        ."c.id as cid, c.name as cname, c.parent as parent FROM #__menu as m"
        . "\nLEFT JOIN #__components as c ON (m.componentid=c.id)"
        . "WHERE m.type='components' AND c.name='samSiteMap'";
      $database->setQuery($sql);
      $menuitems = $database->loadObjectList();

      $pagetitle = $sr->$l('samSiteMap').'::'.$sr->$l('editIndex_title');
      switch ($smid){
        case '1':
        $pagetitle = $sr->$l('samSiteMap').'::'.$sr->$l('global_Index_name');
        break;
        case '2':
        $pagetitle .= $sr->$l('default_Index_name');
        break;
        default:
        $pagetitle .= $configs->get('name');
        break;
      }

      $form = '';
      $form .="<div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:10000;\">
        </div>
        ".(($msg == '')?'':"<div class='message'>$msg</div>")."
        <table class=\"adminheading\">
        <tr>
        <th class=\"".(($smid == '1')? 'impressions':'sections')."\">
        $pagetitle
        </th>
        </tr>
        </table>
        <!-- <script language='javascript' src='js/dhtml.js'></script> -->
        <form action='index2.php' method='post' name='adminForm'>
        <table cellpadding='3' cellspacing='0' border='0' width='100%'>
        <tr>

        <td id='tab1' class='offtab' onclick='dhtml.cycleTab(this.id)'>"
            .$sr->$l('editIndex_tab_config')."</td>
        ";
      $form .="<td id='tab2' class='offtab' onclick='dhtml.cycleTab(this.id)'>"
            .$sr->$l('editIndex_tab_menuoptions')."</td>";

    if ($smid != '1'){
      $form .="
        <td id='tab4' class='offtab' onclick='dhtml.cycleTab(this.id)'>"
            .$sr->$l('editIndex_tab_root')."</td>";
    }
    $form .="
        <td id='tab5' class='offtab' onclick='dhtml.cycleTab(this.id)'>"
            .$sr->$l('editIndex_tab_expand')."</td>
            ";
    if ($smid != '1'){
        $form .= "<td id='tab6' class='offtab' onclick='dhtml.cycleTab(this.id)'>"
            .$sr->$l('editIndex_tab_preview')."</td>
        ";
    }
    $form .="
    <td class='tabpadding'>&nbsp;</td>
    </tr>
    </table>
         ";

      //Configuration Section
      $cfgname = '';
      if ($smid == '1') $cfgname = $sr->$l('global_Index_name');
      if ($smid == '2') $cfgname = $sr->$l('default_Index_name');

      $form .= "<div id='page1' class='pagetext'>
      <table style='vertical-align:top;padding:0px;margin:0px;border:0px;'><tr>";

      if ($smid != '1'){
        $form .="<td style='vertical-align:top;padding:0px;margin:0px;border:0px;'>
        <table class='adminlist' align='left'>
      <tr>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      </tr>
      <tr class='row0'>
      <td align='left'>".$sr->$l('vconfigs_title_lbl')."</td>
      <td align='left'><input type='text' name='configs[title]' value='"
            .$configs->get('title', $sr->$l('editIndex_default_title'))
            ."' class='inputbox'/></td>
      <td align='left'>".$sr->$l('editIndex_config_name_label')."</td>
      <td align='left'>".((($smid == '2') or ($smid == '1'))? $cfgname
      ."<input type='hidden' name='configs[name]' value='$cfgname'":
      "<input type='text' name='configs[name]' value='"
            .$configs->get('name', $sr->$l('newIndex_def_name'))
            ."' class='inputbox'/>")."</td>
      </tr>

      <tr class='row1'>
      <td align='left'>".$sr->$l('vconfigs_search_title_lbl')."</td>
      <td align='left'><input type='text' name='configs[search_title]' value='"
            .$configs->get('search_title')."' class='inputbox'/></td>
      <td align='left'>".$sr->$l('vconfigs_itemid_lbl')."</td>
      <td align='left'>
      ";

     if (count($menuitems) > 0){
       $form .= "<select name='configs[itemid]' style='width:175' class='inputbox' >
       ";
       $form .="<option value='' ".$this->selecttest($configs->get('itemid'),'')
                .">".$sr->$l('not_assigned_lbl')."</option>";

       foreach ($menuitems as $key => $val){
            $form .= "<option value='".$val->id."' "
                .$this->selecttest($configs->get('itemid'), $val->id).">
                        ".$val->menutype.":".$val->name."</option>
                        ";
       }
       $form .= "</select>
       ";
     } else {
        $form .= $sr->$l('editIndex_assign_fail');
     }
      $form .= "</td>
      </tr>

      <tr>
      <th colspan='4' align='center'>".$sr->$l('editIndex_text_th')."</th>
      </tr>

      <tr class='row1'>
      <td colspan='4'>".$sr->$l('editIndex_editr_wrng')."
      </td>
      </tr>

      <tr class='row0'>
        <td colspan='4' rowspan='11'style='text-align:center;vertical-align:top;'>
        ";
     ob_start();
     editorArea( 'editor1',  $configs->get('description') , 'configs[description]', 500, 200, '50', '15' );
     $form .= ob_get_contents();
     ob_end_clean();
     $form .= "</td>
      </tr>
      </table>
      </td>
      ";
      }

      $form .="<td style='vertical-align:top;padding:0;margin:0;border:0;'>
      <table class='adminlist' align='left'>

      <tr>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left' ></th>

      </tr>";

      if ($smid != '1'){
        $form .="
      <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_useconfig_lbl')."</td>
      <td align='left'>
            <select name='params[useconfig]' class='inputbox'>
	           <option value='0' ".$this->selecttest($params->get('useconfig'), '0')
               .">".$sr->$l('vparams_useconfig_opt1')."</option>
	           <option value='1' ".$this->selecttest($params->get('useconfig'), '1')
               .">".$sr->$l('vparams_useconfig_opt2')."</option>
            </select>
      </td>
      <td align='left'>".$this->tTip($sr->$l('vparams_useconfig_desc'),'l','b')."</td>
      </tr>

      <tr class='row1'>
      <td align='left'>".$sr->$l('vparams_pospri_lbl')."</td>
      <td align='left'><input type='text' name='params[pospri]' value='"
            .$params->get('pospri', '')."' class='inputbox' /></td>
      <td align='left'>".$this->tTip($this->getLang('vparams_pospri_desc'),'l','b')."</td>
      </tr>
      ";
      } else {
        $form .="
      <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_pad_lbl')."</td>
      <td align='left'>
           <input type='text' name='params[pad]' value='".$params->get('pad', '5')
            ."' class='inputbox' size='10'/></td>
      <td align='left'>".$this->tTip($sr->$l('vparams_pad_desc'),'l','a')."</td>
      </tr>

      <tr class='row1'>
      <td align='left'>".$sr->$l('vparams_desclen_lbl')."</td>
      <td align='left'><input type='text' name='params[desc_len]' value='"
        .$params->get('desc_len', '250')."' size='10' class='inputbox' /></td>
      <td align='left'>".$this->tTip($sr->$l('vparams_desclen_desc'),'l','a')."</td>
      </tr>
      ";
      }


      $form .="
      <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_usecache_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid, $params->get('usecache'),'params[usecache]', '1', array('0'=>'no','1'=>'yes','2'=>'useglobal'))."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_usecache_desc'),'l','b')."</td>
      </tr>

	   <tr class='row1'>
       <td align='left'>".$sr->$l('vparams_noauth_lbl')."</td>
      <td align='left'>
      ".$this->htmlRadioGrp($smid,$params->get('noauth'),
        'params[noauth]','1')."</td>
	   <td align='left'>".$this->tTip($sr->$l('vparams_noauth_desc'),'l','b')."</td>
	   </tr>

	   <tr class='row0'>
       <td align='left'>".$sr->$l('vparams_showself_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('showself'),
        'params[showself]','1')."</td>
           <td align='left'>".$this->tTip($sr->$l('vparams_showself_desc'),'l','b')."</td>
           </tr>

           <tr class='row1'>
       <td align='left'>".$sr->$l('vparams_menutitles_lbl')."
      </td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('menutitles'),
        'params[menutitles]','1')."</td>
           <td align='left'>".$this->tTip($sr->$l('vparams_menutitles_desc'),'l','a')."</td>
           </tr>";

    if ($smid == '1'){
      $form .= "</table></td>
        <td style='vertical-align:top;padding:0;margin:0;border:0;'>
      <table class='adminlist' align='left'>
            <tr>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left' ></th>
      </tr>";
    }

      $form .="
      <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_desc_lbl')."
      </td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('desc'),
        'params[desc]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_desc_desc'),'l','a')."</td>
      </tr>
      <tr class='row1'>
      <td align='left'>".$sr->$l('vparams_icons_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('icons'),
        'params[icons]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_icons_desc'),'l','a')."</td>
      </tr>

          <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_showempty_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('showempty'),
        'params[showempty]','1')."</td>
           <td align='left'>".$this->tTip($sr->$l('vparams_showempty_desc'),'l','a')."</td>
           </tr>

           <tr class='row1'>
       <td align='left'>".$sr->$l('vparams_multirender_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('multirender'),
        'params[multirender]','1')."</td>
           <td align='left'>".$this->tTip($sr->$l('vparams_multirender_desc'),'l','a')."</td>
           </tr>

      <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_view_lbl')."</td>
      <td align='left'>
        <select name='params[view]' class='inputbox'>
               <option value='map' ".$this->selecttest($params->get('view'), 'map')
                .">".$sr->$l('vparams_view_option1')."</option>
               <option value='list' ".$this->selecttest($params->get('view'), 'list')
                .">".$sr->$l('vparams_view_option2')."</option>";
      if ($smid !== '1'){
      $form .="
               <option value='111' ".$this->selecttest($params->get('view'), '111')
               .">".$sr->$l('use_global')."</option>";
      }
      $form .="
        </select></td>
      <td align='left'>".$this->tTip($sr->$l('vparams_option_view_desc'),'l','a')."</td>
      </tr>

      <tr class='row1'>
      <td align='left'>".$sr->$l('vparams_sort_lbl')."</td>
      <td align='left'>
        <select name='params[sort]' class='inputbox'>
               <option value='normal' ".$this->selecttest($params->get('sort'), 'normal')
                .">".$sr->$l('vparams_sort_option1')."</option>
               <option value='hits' ".$this->selecttest($params->get('sort'), 'hits')
                .">".$sr->$l('vparams_sort_option2')."</option>
               <option value='rating' ".$this->selecttest($params->get('sort'), 'rating')
                .">".$sr->$l('vparams_sort_option3')."</option>
               <option value='votes' ".$this->selecttest($params->get('sort'), 'votes')
                .">".$sr->$l('vparams_sort_option4')."</option>";
      if ($smid !== '1'){
      $form .="
               <option value='111' ".$this->selecttest($params->get('sort'), '111')
               .">".$sr->$l('use_global')."</option>";
      }
      $form .="
        </select></td>
      <td>".$this->tTip($sr->$l('vparams_sort_desc'),'l','a')."</td>
      </tr>

      </table>
      </td>
      </tr>
      </table>
      </div>";

     // User Options Section
      $form .= "<div id='page2' class='pagetext'>
      <table class='adminlist' align='left'>
      <tr>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left'><b>".$sr->$l('editIndex_config_description')."</b></th>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left'><b>".$sr->$l('editIndex_config_description')."</b></th>
      </tr>

	   <tr class='row0'>
       <td align='left'>".$sr->$l('vparams_showmenu_lbl')."</td>
      <td align='left'>
      ".$this->htmlRadioGrp($smid,$params->get('showmenu'),
        'params[showmenu]','1')."</td>
	   <td align='left'>".$this->tTip($sr->$l('vparams_showmenu_desc'))."</td>
       <td align='left'>".$sr->$l('vparams_search_ok_lbl')."</td>
      <td align='left'>
      ".$this->htmlRadioGrp($smid,$params->get('search_ok'),
        'params[search_ok]','1', array('0'=>'no','1'=>'yes','2'=>'useglobal'))."</td>
	   <td align='left'>".$this->tTip($sr->$l('vparams_search_ok_desc'))."</td>
	   </tr>

	   <tr class='row1'>
       <td align='left'>".$sr->$l('vparams_showview_lbl')."</td>
      <td align='left'>
      ".$this->htmlRadioGrp($smid,$params->get('showview'),
        'params[showview]','1')."</td>
	   <td align='left'>".$this->tTip($sr->$l('vparams_showview_desc'))."</td>
       <td align='left'>".$sr->$l('vparams_showsearch_lbl')."</td>
      <td align='left' >
      ".$this->htmlRadioGrp($smid,$params->get('showsearch'),
        'params[showsearch]','1')."</td>
	   <td align='left'>".$this->tTip($sr->$l('vparams_showsearch_desc'))."</td>
	   </tr>

	   <tr class='row0'>
       <td align='left'>".$sr->$l('vparams_showsort_lbl')."
      </td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('showsort'),
        'params[showsort]','1')."
	   </td>
	   <td align='left'>".$this->tTip($sr->$l('vparams_showsort_desc'))."</td>
       <td align='left' colspan='3'></td>
	   </tr>

	   <tr class='row1'>
       <td align='left'>".$sr->$l('vparams_ratingsort_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('ratingsort'),
        'params[ratingsort]','1')."</td>
	   <td align='left'>".$this->tTip($sr->$l('vparams_ratingsort_desc'))."</td>
       <td align='left' colspan='3'></td>
	   </tr>

	   <tr class='row0'>
       <td align='left'>".$sr->$l('vparams_showdesc_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('showdesc'),
        'params[showdesc]','1')."</td>
	   <td align='left'>".$this->tTip($sr->$l('vparams_showdesc_desc'))."</td>
       <td align='left' colspan='3'></td>
	   </tr>

      </table>
      </div>
      ";

      // Root Items Section
      if ($smid != '1'){
      $form .= "<div id='page4' class='pagetext'>
<table class=\"adminlist\">
 <tr>
  <th width='20px'>#</th>
  <th width='20px'>
  <input type=\"checkbox\" name=\"toggle\" value=\"\" onclick=\"checkAll($count)\" />
  </th>
  <th class=\"title\" width=\"100px\"  align=\"left\">
   ".$sr->$l('editIndex_root_item')."
   </th>
   <th nowrap=\"nowrap\" width='200px' align=\"left\">
   ".$sr->$l('editIndex_root_type')."
   </th>
   <th colspan='2' nowrap=\"nowrap\" width='50px' align=\"left\">
   ".$sr->$l('editIndex_root_ordering')."
   </th>
   <th nowrap=\"nowrap\" align=\"left\">
   ".$sr->$l('editIndex_root_itemid')."
   </th>
   </tr>";

      if ($count >= 1){
        $class = '0';
        for ($i=0, $n=count( $rows ); $i < $n; $i++) {
          $item = '';
          $type = '';
          $row =& $rows[$i];
          $classt = "class='row$class'";
          switch ($row->smtype){
            case '#__template_positions':
            $item = $row->tpname;
            $type = $sr->$l('editIndex_root_tp');
            break;

            case '#__menu':
            $item = $row->miname;
            $type = $sr->$l('editIndex_root_mi');
            break;

            case '#__modules':
            $item = $row->mdlname;
            $type = $sr->$l('editIndex_root_menu');
            break;
          }

          $mentitle = (isset($row->mentitle))? $row->mentitle: 'Not Found';

          $menid = (isset($row->mid))? $row->mid: '';
          $itemid = (isset($row->itemid))? $row->itemid: $sr->$l('notused');
          $ordering = $row->ordering;

          $form .= "<tr $classt>\n"
          . "<td >".$pageNav->rowNumber($i )."</td>
          <td >".mosHTML::idBox ($i, $row->id, FALSE )."</td>
          <td >"./*"<a href='#edit' onclick=\"return listItemTask('cb".$i."','edit')\">*/$item/*</a>*/."</td>
          <td nowrap=\"nowrap\">$type</td>
          <td width='25px'>".$pageNav->orderUpIcon($i, true, 'ritem_orderup')."</td>
          <td width='25px'>".$pageNav->orderDownIcon($i, $n, true, 'ritem_orderdown')."</td>
          <td  >Itemid: $itemid</td>

          </tr>";
          $class = ($class == '0')? '1':'0';

        }
      } else {
        if ($smid != 'new'){
            $form .= "<tr class='row0'>
            <td align='left' colspan='7'>".$sr->$l('editIndex_root_nonefound')."
            </td>
            </tr>";
        } else {
          $form .= "<tr class='row0'>
          <td align='left' colspan='7'><b>".$sr->$l('editIndex_root_savefirst')."</b>
          </td>
          </tr>";
        }
      }
      $form .= '<tr><td colspan="7" style="padding:0;margin:0;">'.$pageNav->getListFooter()."
      </td>
      </tr>
      </table>
      </div>
      ";
    }

      //Expand options
      $form .="<div id='page5' class='pagetext'>
      <table class='adminlist'>
      <tr><td colspan='6'>".$sr->$l('editIndex_expand_desc')."</td>
      </tr>
      <tr>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left'><b>".$sr->$l('editIndex_config_description')."</b></th>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left'><b>".$sr->$l('editIndex_config_description')."</b></th>
      </tr>


      <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_exp_sections_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_sections'),
        'params[exp_sections]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_sections_desc'))."</td>
      <td colspan='3'></td>
      </tr>

      <tr class='row1'>
      <td align='left'>".$sr->$l('vparams_exp_categories_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_categories'),
        'params[exp_categories]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_categories_desc'))."</td>
      <td align='left'>".$sr->$l('vparams_exp_content_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_content'),
        'params[exp_content]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_content_desc'),'l')."</td>
      </tr>

      <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_exp_nf_cat_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_nf_cat'),
        'params[exp_nf_cat]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_nf_cat_desc'))."</td>
      <td align='left'>".$this->getLang('vparams_exp_newsfeeds_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_newsfeeds'),
        'params[exp_newsfeeds]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_newsfeeds_desc'),'l')."</td>
      </tr>

      <tr class='row1'>
      <td align='left'>".$sr->$l('vparams_exp_wl_cat_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_wl_cat'),
        'params[exp_wl_cat]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_wl_cat_desc'))."</td>
      <td align='left'>".$sr->$l('vparams_exp_weblinks_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_weblinks'),
        'params[exp_weblinks]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_weblinks_desc'),'l')."</td>
      </tr>

      <tr class='row0'>
      <td align='left'>".$sr->$l('vparams_exp_ct_cat_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_ct_cat'),
        'params[exp_ct_cat]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_ct_cat_desc'))."</td>
      <td align='left'>".$sr->$l('vparams_exp_contacts_lbl')."</td>
      <td align='left'>".$this->htmlRadioGrp($smid,$params->get('exp_contacts'),
        'params[exp_contacts]','1')."</td>
      <td align='left'>".$this->tTip($sr->$l('vparams_exp_contacts_desc'),'l')."</td>
      </tr>

      </table>
      </div>
      ";

      //Preview Tab
      if ($smid != '1'){

        $target = ($configs->get('itemid') > '1')?
        $mosConfig_live_site."/index.php?option=com_samsitemap&amp;Itemid="
            .$configs->get('itemid'):
            $mosConfig_live_site."/index.php?option=com_samsitemap&amp;configid="
            .$smid;
        $target0 = $target.'&access=0';
        $target1 = $target.'&access=1';
        $target2 = $target.'&access=2';

      $form .="<div id='page6' class='pagetext'>
      <table class='adminlist' align='left' width='100%'>
      <tr class='row0'>
      <td colspan='3' align='center'><b>".$sr->$l('editIndex_preview_desc')."</b><br /><hr />"
        .$sr->$l('editIndex_preview_desc2')."</td>
      </tr>
      <tr class='row1'>
      <td align='center' width='33%'><a href='$target0' target='smframe'>"
        .$sr->$l('editIndex_preview_link0')."</a></td>
      <td align='center' width='33%'><a href='$target1' target='smframe'>"
        .$sr->$l('editIndex_preview_link1')."</a></td>
      <td align='center' width='34%'><a href='$target2' target='smframe'>"
        .$sr->$l('editIndex_preview_link2')."</a></td>
      </tr>

      <tr class='row0'>
      <td colspan='3' align='center'>
      ";

        $form .= "<IFRAME name='smframe' src='' width='100%' height='400'
             scrolling='auto' frameborder='1'>
            [Your user agent does not support frames or is currently configured"
            ." not to display frames.]
            </IFRAME>
        </td>
        </tr>
        </table>
        </div>";
        }

      //  End of tab divisions
      $hidemainmenu = (isset($_POST['hidemainmenu']))?
        "<input type='hidden' name='hidemainmenu' value='".$_POST['hidemainmenu']."' />" :
        '';
      $form .="
      <input type=\"hidden\" name=\"option\" value=\"$option\" />
                <input type=\"hidden\" name=\"task\" value=\"\" />
                <input type=\"hidden\" name=\"boxchecked\" value=\"0\" />
                <input type=\"hidden\" name=\"configid\" value=\"".$smid."\" />
                $hidemainmenu
                ";
      if (($smid == '1') or ($smid == '2')){
        $idxname = ($smid == '1')? $sr->$l('global_Index_name'):$sr->$l('default_Index_name');
        $form .= "\n<input type='hidden' name='configs[name]' value='$idxname'>";
      }
//      $temp = get_object_vars($gparams->_params);
      if (is_array($this->_gparams)){
        foreach ($this->_gparams as $key => $val){
          $form .= "<input type='hidden' name='gparams[$key]' value='$val' />
          ";
        }
      }
      ob_start();
      getEditorContents('editor1', 'configs[description]');
      $getEditorContents = ob_get_contents();
      ob_end_clean();

      $form .= "<script language='javascript' type='text/javascript'>dhtml.cycleTab('tab$tab');</script>"              ."
      </form>
      <script language='javascript' src='".$GLOBALS['mosConfig_live_site']."/includes/js/overlib_mini.js'></script>
      <script language='javascript'>".$this->jshideselect()."</script>
      <script language='javascript' type='text/javascript'>

                function submitbutton(pressbutton) {
                        var form = document.adminForm;

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        // do field validation
                        $getEditorContents
                        submitform( pressbutton );

                }
                </script>";

      return $form;

    }

    function selectitemtype($configid) {
        global $database, $mainframe, $mosConfig_list_limit, $option;
          $form = "<table class=\"adminheading\">
                <tr>
                        <th class=\"modules\">

                        ".$this->getLang('samSiteMap').'::'.$this->getLang('selectItemt_title')."
                        </th>
                </tr>
                </table>
                <form action='index2.php' method='post' name='adminForm'>\n"
         ."<table class=\"adminlist\">"
         ."<tr>"
         ."<th ></th><th align='left'>".$this->getLang('selectItemt_table_select')
         ."</th><th align='left'>".$this->getLang('selectItemt_table_desc')."</th>"
         ."<tr><td>"
         ."<input type='radio' name='itemtype' value='#__template_positions' onclick=\"isChecked(this.checked);\">
         </td><td>
         ".$this->getLang('selectItemt_pos_label')."
         </td><td>
         ".$this->getLang('selectItemt_pos_desc')."
         </td></tr><tr><td>
         <input type='radio' name='itemtype' value='#__modules' onclick=\"isChecked(this.checked);\">
         </td><td>
         ".$this->getLang('selectItemt_menu_label')."
         </td><td>
         ".$this->getLang('selectItemt_menu_desc')."
         </td></tr><tr><td>
         <input type='radio' name='itemtype' value='#__menu' onclick=\"isChecked(this.checked);\">
         </td><td>
         ".$this->getLang('selectItemt_mitem_label')."
         </td><td>
         ".$this->getLang('selectItemt_mitem_desc')."
         </td></tr></table>";
         if (is_array($this->_params)){
           foreach ($this->_params as $key => $val){
             $form .= "
                <input type='hidden' name='params[$key]' value='$val' />
                ";
           }
         }
         if (is_array($this->_gparams)){
           foreach ($this->_gparams as $key => $val){
             $form .= "
                <input type='hidden' name='gparams[$key]' value='$val' />
                ";
           }
         }
         if (is_array($this->_configs)){
           foreach ($this->_configs as $key => $val){
             $form .= "
                <input type='hidden' name='configs[$key]' value='$val' />
                ";
           }
         }
          $hidemainmenu = (isset($_POST['hidemainmenu']))?
            "<input type='hidden' name='hidemainmenu' value='".$_POST['hidemainmenu']."' />" :
            '';
         $form .= "<input type=\"hidden\" name=\"option\" value=\"$option\" />
                <input type=\"hidden\" name=\"task\" value=\"\" />
                <input type=\"hidden\" name=\"boxchecked\" value=\"0\" />
                <input type='hidden' name='configid' value='".$configid."'>
                $hidemainmenu
           </form>";

           return $form;

    }

    function selectItem ($configid,$itemtype){
      global $database, $option;

      $sql = '';

      switch ($itemtype){
        case '#__template_positions':
        $sql = "SELECT id,position as name  FROM #__template_positions";
        break;

        case '#__modules':
        $sql = "SELECT id, title as name FROM #__modules WHERE module='mod_mainmenu' AND published='1'";
        break;

        case '#__menu':
        $sql = "SELECT id,CONCAT(menutype,': ',name) as name,type FROM #__menu "
            ."\nWHERE published = '1' AND type!='seperator'"
            ."\nORDER BY menutype, name ASC";
        break;

        case 'descendent':
        break;
            }

        $database->setQuery($sql);
        $items = $database->loadObjectList('id');

        $form ="<table class=\"adminheading\">
                <tr>
                        <th class=\"modules\">

                        ".$this->getLang('samSiteMap').'::'.$this->getLang('selectItem_title')."
                        </th>
                </tr>
                </table>
                <form action='index2.php' method='post' name='adminForm'>\n"
         ."<table class=\"adminlist\">"
         ."<tr>"
         ."<th width='20px'></th><th align='left'>".$this->getLang('selectItem_table_select')."</th>";

        if (is_array ($items) and (count($items)>0)){
          $itemlist ='';
          $class = '0';
          foreach ($items as $key => $val){
            $id = $val->id;
            $smtype = $itemtype;
            $itemid = '';
            $name = $val->name;
            $form .="<tr class='row$class'><td>
         <input type='radio' name='iid' value='$id' onclick=\"isChecked(this.checked);\">
         </td><td>
         ".$name."
         </td></tr>";
            $class = ($class == '0')? '1':'0';
          }
        }
        $form .= "</table>";
                 if (is_array($this->_params)){
           foreach ($this->_params as $key => $val){
             $form .= "
                <input type='hidden' name='params[$key]' value='$val' />
                ";
           }
         }
         if (is_array($this->_gparams)){
           foreach ($this->_gparams as $key => $val){
             $form .= "
                <input type='hidden' name='gparams[$key]' value='$val' />
                ";
           }
         }
         if (is_array($this->_configs)){
           foreach ($this->_configs as $key => $val){
             $form .= "
                <input type='hidden' name='configs[$key]' value='$val' />
                ";
           }
         }
          $hidemainmenu = (isset($_POST['hidemainmenu']))?
            "<input type='hidden' name='hidemainmenu' value='".$_POST['hidemainmenu']."' />" :
            '';
         $form .= "<input type=\"hidden\" name=\"option\" value=\"$option\" />
                <input type=\"hidden\" name=\"task\" value=\"\" />
                <input type=\"hidden\" name=\"boxchecked\" value=\"0\" />
                <input type='hidden' name='configid' value='".$configid."'>
                <input type='hidden' name='itemtype' value='$itemtype'>
                $hidemainmenu
           </form>";
    return $form;
      }

    function searchSettings(){
      global $database;
      $sr =& $this;
      $l = 'getLang';
      $sql = "SELECT description, id FROM #__samsitemap_indexes WHERE id='1'";
      $database->setQuery($sql);
      $result = $database->loadObjectList('id');
      $params =& new mosParameters($result[1]->description);
      
      $form = '';
      $form .= "<div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:10000;\">
        </div>
        <form action='index2.php' method='post' name='adminForm'>
        <table class=\"adminheading\">
        <tr>
        <th class=\"searchtext\">&nbsp;".
        ($this->getLang('samSiteMap').'::'.$this->getLang('sr_title'))."
        </th>
        </tr>
        </table>
        <table class='adminlist'>
        <tr>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left'><b>".$sr->$l('editIndex_config_description')."</b></th>
      <th align='left' width='".$sr->$l('option_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_option')."</b></th>
      <th align='left' width='".$sr->$l('settings_tdwidth')."'><b>"
            .$sr->$l('editIndex_config_setting')."</b></th>
      <th align='left'><b>".$sr->$l('editIndex_config_description')."</b></th>
      </tr>

      <tr class='row0'>
       <td align='left'>".$sr->$l('vsr_show_hl_lbl')."
       </td>
       <td align='left'>".$this->htmlRadioGrp('1',$params->get('sr_show_hl'),
        'sr[sr_show_hl]','1',array('0'=>'no','1'=>'yes','2'=>'useglobal'))."
        </td>
       <td align='left'>".$this->tTip($sr->$l('vsr_show_hl_desc'))."
       </td>
       <td align='left'>".$sr->$l('vsr_search_clr_lbl')."
       </td>
       <td align='left'><input type='text' name='sr[sr_search_clr]' value='"
        .$params->get('sr_search_clr')."' class='inputbox' size='7' >
        </td>
       <td align='left'>".$this->tTip($sr->$l('vsr_search_clr_desc'))."
       </td>
      </tr>
      
      <tr class='row1'>
      <td align='left'>".$sr->$l('vsr_title_hl_lbl')."
      </td>
      <td align='left'>".$this->htmlRadioGrp('1',$params->get('sr_title_hl'),
      'sr[sr_title_hl]','1',array('0'=>'no','1'=>'yes','2'=>'useglobal'))."
      </td>
      <td align='left'>".$this->tTip($sr->$l('vsr_title_hl_desc'))."
      </td>
       <td align='left'>".$sr->$l('vsr_search_bld_lbl')."
       </td>
       <td align='left'>".$this->htmlRadioGrp('1',$params->get('sr_search_bld'),
       'sr[sr_search_bld]','1',array('0'=>'no','1'=>'yes','2'=>'useglobal'))."
       </td>
       <td align='left'>".$this->tTip($sr->$l('vsr_search_bld_desc'))."
       </td>
      </tr>
      
      <tr class='row0'>
      <td align='left'>".$sr->$l('vsr_desc_len_lbl')."
      </td>
      <td align='left'><input type='text' name='sr[sr_desc_len]') value='".$params->get('sr_desc_len')."' class='inputbox' size='5'>
      </td>
      <td align='left'>".$this->tTip($sr->$l('vsr_desc_len_desc'))."
      </td>
       <td align='left'>".$sr->$l('vsr_sho_wc_lbl')."
       </td>
       <td align='left'>".$this->htmlRadioGrp('1',$params->get('sr_sho_wc'),
       'sr[sr_sho_wc]','1')."
       </td>
       <td align='left'>".$this->tTip($sr->$l('vsr_sho_wc_desc'))."
       </td>
      </tr>

      <tr class='row1'>
      <td align='left'>".$sr->$l('vsr_sho_rtng_lbl')."
      </td>
       <td align='left'>".$this->htmlRadioGrp('1',$params->get('sr_sho_rtng'),
       'sr[sr_sho_rtng]','1')."
       </td>
      <td align='left'>".$this->tTip($sr->$l('vsr_sho_rtng_desc'))."
      </td>
       <td colspan='3'>
       </td>

      <tr>
      <th colspan='6'>".$sr->$l('sr_weight_title')."
      </th>
      </tr>
      
      <tr>
      <td align='left' colspan='6'>".$sr->$l('sr_weight_label')."
      </td>
      </tr>
      
      <tr class='row0'>
      <td align='left'>".$sr->$l('vsr_maxdens_lbl')."
      </td>
      <td align='left'><input type='text' name='sr[sr_maxdens]' value='".$params->get('sr_maxdens')."' size='3' class='inputbox'>
      </td>
      <td align='left'>".$this->tTip($sr->$l('vsr_maxdens_desc'))."
      </td>
      <td align='left'>".$sr->$l('vsr_densw_lbl')."
      </td>
      <td align='left'><input type='text' name='sr[sr_densw]' value='".$params->get('sr_densw')."' size='2' class='inputbox'>
      </td>
      <td align='left'>".$this->tTip($sr->$l('vsr_densw_desc'))."
      </td>


      </tr>
      
      <tr class='row1'>
      <td align='left'>".$sr->$l('vsr_allw_label')."
      </td>
      <td align='left'><input type='text' name='sr[sr_allw]' value='".$params->get('sr_allw')."' size='2' class='inputbox'>
      </td>
      <td align='left'>".$this->tTip($sr->$l('vsr_allw_desc'))."
      </td>
      <td align='left'>".$sr->$l('vsr_titlew_lbl')."
      </td>
      <td align='left'><input type='text' name='sr[sr_titlew]' value='".$params->get('sr_titlew')."' size='2' class='inputbox'>
      </td>
      <td align='left'>".$this->tTip($sr->$l('vsr_titlew_desc'))."
      </td>
      </td>
      </tr>

      <tr class='row0'>
      <td align='left' colspan='6'>".$sr->$l('sr_formulas')."
      </td>
      </tr>
      
        </table>
        ";
        
      $form .= "
      <script language='javascript' src='".$GLOBALS['mosConfig_live_site']."/includes/js/overlib_mini.js'></script>
      <script language='javascript'>".$this->jshideselect()."</script>
      ";
      $hidemainmenu = (isset($_POST['hidemainmenu']))?
        "<input type='hidden' name='hidemainmenu' value='".$_POST['hidemainmenu']."' />" :
        '';
      $form .="
      <input type=\"hidden\" name=\"option\" value=\"".$_REQUEST['option']."\" />
                <input type=\"hidden\" name=\"task\" value=\"\" />
                <input type=\"hidden\" name=\"boxchecked\" value=\"0\" />
                $hidemainmenu
        </form>";
        
      return $form;
    }


}

class samSMhtml{
  var $_options = null;
  var $_lang = null;
  var $_style = null;
  
  function samSMhtl (){
//    $this->_options =& $samSMconfig->_options;
    $this->_lang =& $samSMconfig->_lang;
    $this->setDefaults();
  }

  function getLang ($param){
    $var = $samSMconfig->getLang($param);
    return $var;
  }
  
  function getStyle ($var){
    if (isset($this->_style->$var)){
      return $this->_style->$var;
    } else {
      return '';
    }
  }

  function getOpt ($var){
    if (isset($this->_option->$var)){
      return $this->_options;
    }
  }
  function th ($options){
    $align = ($align == '')?'':"align='$align'";
    $html = '';
    if (is_array($optarray)){
        foreach($optarray as $val){
          $html .= "\n<th $align>$val\n</th>";
        }
    } else {
      $html = "\n<th $align>$optarray\n</th>";
    }
    return $html;
  }
  
  function tdopen ($class='', $style=''){
    $class = ($class == '')?'':"class='$class'";
    $style = ($style == '')?"style='".$this->getSyle('td')."'":"style='$style'";
    
  }
  
  function setDefaults($fn=''){
    $fn = ($fn == '')? 'default.php' : $fn;
    require ($samSMref);

  }
}
?>
