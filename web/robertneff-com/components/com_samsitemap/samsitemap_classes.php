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


class samSiteMap {
        var $_adminalert = '';
        var $_renderlist = null;
        var $_rootcontainer = null;
        var $_options = null;
        var $_db = null;
        var $_false = FALSE;
        var $version = '.6.2 beta';

        function samSiteMap (&$dbs, &$params, &$gparams, $srparams) {
          global $mosConfig_absolute_path, $mosConfig_live_site;
            $GLOBALS['samSMref'] =& $this;

            $this->_db =& new samDBinterface($dbs);
            $this->_options->table_prefix = $this->_db->_table_prefix;
            $this->Index =& new samSMIndex ('master');
            $this->_valtrack =& new samValtracker;
            $this->_options->abspath = $mosConfig_absolute_path.samDS.'components'.samDS.'com_samsitemap'.samDS;
            $this->_options->absurl = $mosConfig_live_site.'/components/com_samsitemap/';

            $this->setOpts ($params, $gparams, $srparams);
            if ($this->getOpt('active_search') == '1'){
            $this->setSearchOpts($this->getOpt('search'), $this->getOpt('search_mode'));
            }
            $this->params =& $params;
            $this->gparams =& $gparams;
            $this->setLanguage($this->getOpt('language'));
            $this->setIcons();
            $this->collectItems();
            $this->render();
            $this->_html = $this->displayMap();
        }

        function get ($var) {
            $var = '_'.$var;
          if (isset($this->$var)){
            return $this->$var;
          } else {
            return FALSE;
          }
        }

        function chooseOpt($option, &$params, &$gparams, $default=''){
          $set =& $this->_options;
//          $soption = substr($option, 7);
          if ($params->get($option, '111') == '111'){
            $set->$option = $gparams->get($option, $default);
          } else {
            $set->$option = $params->get($option, $default);
          }
        }

        function setOpts (&$p, &$gp, &$sr){
            $set =& $this->_options;

            //Configuration Options
            $set->active_search = $p->get('active_search', '0');
            if ($set->active_search == '1'){
                $set->search = $p->get('search');
                $set->search_mode = $p->get('search_mode');
                }
            $this->chooseOpt('useconfig',$p,$gp,'1');
            $this->chooseOpt('configid',$p,$gp,'2');
            $set->path = $p->get('path');
            $this->chooseOpt ('noauth',$p,$gp,'1');
            $set->title = $p->get ('title', 'Site Map');
            $set->page_desc = $p->get ('page_description', '');
            $this->chooseOpt('search_ok',$p,$gp,'1');
            $this->chooseOpt('showsearch', $p,$gp,'1');
            $this->chooseOpt('icondirurl',$p,$gp,$this->getOpt('absurl').'icons/default/');
            $this->chooseOpt('useconfig', $p, $gp, '0');
            $ttble = $this->getOpt('table_prefix').'template_positions';
            $set->priority->$ttble = $this->makeArray($p->get('pospri'));
            $this->chooseOpt('view',$p,$gp,'map');
            $this->chooseOpt('sort',$p,$gp,'ordering');
            $this->chooseOpt('desc',$p,$gp,'1');
            $this->chooseOpt('showmenu',$p,$gp,'1');
            $this->chooseOpt('showempty',$p,$gp,'1');
            $this->chooseOpt('multirender',$p,$gp,'0');
            $this->chooseOpt('icons',$p,$gp,'1');
            $this->chooseOpt('menutitles',$p,$gp,'1');
            //Menu Options
            $this->chooseOpt('showview',$p,$gp,'1');
            $this->chooseOpt('showsort',$p,$gp,'1');
            $this->chooseOpt('ratingsort',$p,$gp,'1');
            $this->chooseOpt('showdesc',$p,$gp,'1');
            //Search Options
            $set->sr_show_hl = $sr->get('show_hl','1');
            $set->sr_search_clr = $sr->get('sr_search_clr','#FF0000');
            $set->sr_title_hl = $sr->get('sr_title_hl','1');
            $set->sr_search_bld = $sr->get('sr_search_bld', '1');
            $set->sr_desc_len = $sr->get('sr_desc_len', '300');
            $set->sr_sho_wc = $sr->get('sr_sho_wc', '1');
            $set->sr_sho_rtng = $sr->get('sr_sho_rtng', '1');

            $set->sr_maxdens = $sr->get('sr_maxdens', '5');
            $set->sr_densw = $sr->get('sr_densw','10' );
            $set->sr_titlew = $sr->get('sr_titlew','1' );
            $set->sr_allw = $sr->get('sr_allw','1' );

            //Display Options
            $this->chooseOpt('showself',$p,$gp,'0');
            $set->pad = $gp->get ('pad', '20');

            $set->desc_len = $gp->get ('desc_len', '250');
            $set->seperator = $p->get ('seperator', '<010203>');
            $set->deriveurl = $p->get ('deriveurl', '<!derive!>');
            $set->usergid = $p->get ('usergid', '0');
            $set->language = $p->get ('language', 'en_us');
            $set->Itemid = $p->get ('Itemid', '');

            // Expand Options
            $this->chooseOpt('exp_sections',$p,$gp,'1');
            $this->chooseOpt('exp_categories',$p,$gp,'1');
            $this->chooseOpt('exp_content',$p,$gp,'1');
            $this->chooseOpt('exp_newsfeeds',$p,$gp,'1');
            $this->chooseOpt('exp_weblinks',$p,$gp,'1');
            $this->chooseOpt('exp_contacts',$p,$gp,'1');
            $this->chooseOpt('exp_nf_cat',$p,$gp,'1');
            $this->chooseOpt('exp_wl_cat',$p,$gp,'1');
            $this->chooseOpt('exp_ct_cat',$p,$gp,'1');

        }

        function collectItems(){

          $vt =& $this->_valtrack;
          $tmp = '';

            $configid[]= $this->getOpt('configid');
            $this->setRootItems($configid);

            if ($tmp = $vt->get('#__template_positions') ){
                $this->getMosPositions($tmp);
            }

            $pos = ($posn = $vt->get('template_positions_names'))? $posn: '';
            $menus = ($m = $vt->get('#__modules'))? $m:'';
            if (($pos != '') or ($menus != '')){
                $this->getMenuModules($menus,$pos);
            }
            $tmp = $vt->get('mosMenuName');
            $tmp2 = $vt->get('#__menu');
            if (($tmp != '') or ($tmp2 != '')){
                $this->getMenuItems ($tmp, $tmp2);
            }

            if ($tmp = $vt->get('#__components')){
                $this->getComponents ($tmp);
            }

            if ($tmp = $vt->get('#__sections')){
                $this->getSections ($tmp);
            }

            $cats = $vt->get('#__categories');
            $secref = $vt->get('mosSectionCatRef');
            if (($cats != FALSE) or ($secref != FALSE)){
                $this->getCats ($cats,$secref);
            }

            $cats = $vt->get('#__categories');
            $conts = $vt->get('#__content');
            if (($cats != FALSE) or ($conts != FALSE)){
                $this->getContentItems($cats, $conts);
            }

//            $cats = $vt->get('#_categories');
            $tmp = $vt->get('#_contact_details');
            if (($cats != FALSE) or ($tmp != FALSE)){
                $this->getContacts($cats,$tmp);
            }

            $cats = $vt->get('#__categories');
            $nf = $vt->get('#__newsfeeds');
            if (($cats != FALSE) or ($nf != FALSE)){
              $this->getNewsfeeds($cats, $nf);
            }

            $cats = $vt->get('#__categories');
            $wl = $vt->get('#__weblinks');
            if (($cats != FALSE) or ($wl != FALSE)){
              $this->getWebLinks ($cats, $wl);
            }
        }

        function setLanguage ($lang='en_us'){
          global $mosConfig_absolute_path/*, $mosConfig_locale, $mosConfig_lang*/;

            $langdir = $mosConfig_absolute_path.samDS
                .'components'.samDS.'com_samsitemap'.samDS.'lang';

            require ($langdir.samDS.'samsitemap.lang.'.$lang.'.php');

            $this->_lang->label_view = $label_view;
            $this->_lang->label_sort = $label_sort;
            $this->_lang->label_desc = $label_desc;
            $this->_lang->label_submit = $label_submit;
            $this->_lang->option_view_list = $option_view_list;
            $this->_lang->option_view_tree = $option_view_tree;
            $this->_lang->option_sort_normal = $option_sort_normal;
            $this->_lang->option_sort_hits = $option_sort_hits;
            $this->_lang->option_sort_rating = $option_sort_rating;
            $this->_lang->option_sort_votes = $option_sort_votes;
            $this->_lang->option_desc_hide = $option_desc_hide;
            $this->_lang->option_desc_show = $option_desc_show;
            $this->_lang->menu_button_name = $menu_button_name;
            $this->_lang->noauth = $noauth;
            $this->_lang->adminonly = $adminonly;
            $this->_lang->label_rating = $label_rating;
            $this->_lang->label_hits = $label_hits;
            $this->_lang->label_rank = $label_rank;
            $this->_lang->label_doctree = $label_doctree;
            $this->_lang->label_title = $label_title;
            $this->_lang->label_credit = $label_credit;
            $this->_lang->label_star = $label_star;
            $this->_lang->label_nf_articles = $label_nf_articles;
            $this->_lang->label_votes = $label_votes;
            $this->_lang->label_search_nf = $label_search_nf;
            $this->_lang->label_search_find = $label_search_find;
            $this->_lang->label_search_sm0 = $label_search_sm0;
            $this->_lang->label_search_sm1 = $label_search_sm1;
            $this->_lang->label_search_sm2 = $label_search_sm2;
            $this->_lang->label_search_submit = $label_search_submit;
            $this->_lang->label_cancel = $label_cancel;
            $this->_lang->label_search_wild = $label_search_wild;
        }

        function setIcons (){
          $set =& $this->_icons;
          $set->folder = 'folder.png';
          $set->nafolder = 'nafolder.png';
          $set->page = 'page.png';
          $set->napage = 'napage.png';
//          $set->list = 'list.png';
//          $set->nalist = 'nalist.png';
        }

        function getIcon($type){
          if (isset($this->_icons->$type)){
            return $this->_icons->$type;
          } else {
            return FALSE;
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

        function adminalert ($message){
          $this->_adminalert .= "<br />\n" . $message;
        }

        function render () {
        $root =& $this->_rootcontainer;
          $this->renderclient($root);
        }

        function addRenderItem ($idx, $title, $url, &$client){
              if (($this->getOpt('active_search') == '1') and ($client->get('search_hits') < '1')) {return;}
            $this->_renderlistn = (isset($this->_renderlistn))? $this->_renderlistn + 1:0;
            $n = $this->_renderlistn;
            $this->_renderlist[$n]['idx'] = $idx;
            $this->_renderlist[$n]['client'] =& $client;
            $this->_renderlist[$n]['url'] = $url;
            $this->_renderlist[$n]['title'] = $title;
        }


        function setRootItems ($configid = array('0'=>'0')){

            $root = '';
            $root->title = '';
            $root->id = '0';
            $this->_rootcontainer = new samSMblock ($root);
            $this->_rootcontainer->set('SMtype', 'master_root');
            $this->_rootcontainer->set('access', '0');
            $this->_rootcontainer->set('render', '0');
            $this->_rootcontainer->set('url', '');

//            $vt =& $this->_valtrack;
            if (!is_array($configid)){return FALSE;}
            foreach($configid as $key=>$val){
            $root = '';
            $root->title = '';
            $root->id = $val;
            $ref =& $this->Index->addItem('root', $val, $root);
            $ref->set ('SMtype', 'root');
            $ref->set ('access', '0');
            $ref->set ('render', '0');
            $ref->set ('ordering', $key);
            $ref->set ('url', '');

            if ($this->getOpt('useconfig')== '0'){
                $ref->addchild('#__template_positions','all');
                $test = TRUE;
            } else {
              $test = $this->getRootItems($val);
            }
            if (!$test) {
                $ref->addchild('#__template_positions', 'all');
            }
            $this->_rootcontainer->addchild('root', $val);
            }
        }

        function getRootItems ($configid) {

          $db =& $this->_db;
          $db->clearall();
          $db->addsql ('table', '#__samsitemap_items');
          $db->addsql ('field', '*');
          $db->addsql ('and', $configid, 'config_id');

          $ret = $db->autoquery();
          if (!$ret) {return FALSE;}
          while ($row = $db->getNextRow()){
              $item = '';
              $item->id = $row['id'];
              $item->title = '';
              $ref =& $this->Index->addItem('#__samsitemap_items',$row['id'], $item);
              $ref->set('ordering',$row['ordering']);
              $ref->set('url','');
              $ref->set('render','0');
              $ref->set('SMtype','#__samsitemap_items');
              $ref->set('access','0');
              $this->Index->addchild('root',$configid,'#__samsitemap_items', $row['id']);
              $this->Index->addchild('#__samsitemap_items', $row['id'], $row['smtype'], $row['componentid']);
              $this->_valtrack->add('#__samsitemap_items',$row['id']);

          }
          return TRUE;
        }

        function getMenuModules ($menu='', $pos=''){
            if ($menu=='' and $pos=='') return FALSE;
            $db =& $this->_db;
            $db->clearall();
            $db->addsql ('table','#__modules');
            $fields = array('id','title','ordering','position','published','access','module','showtitle','params');
            $db->addsql ('field', $fields);
            $db->addsql ('and', 'mod_mainmenu', 'module');
            $db->addsql ('and', '1', 'published');
            $access = $this->getOpt('usergid');
            $db->addsql('and',"$access",'access','','<=');

            if (($pos == 'all')){ }else{
                if (is_array($pos)) {
                  $db->addsql('or', $pos, 'position');
                  }
                if (is_array($menu)){
                  $db->addsql('or', $menu, 'id');
                  }
            }

            $ret = $db->autoquery();
            if (!$ret){return FALSE;}
                  while ($row = $db->getNextRow()){
                  $params = new mosParameters ($row['params']);
                  $menutype = $params->get('menutype');
                      $item = '';
                      $item->id = $row['id'];
                      $item->special = $menutype;
                      $item->title = $row['title'];
                      $ref =& $this->Index->addItem('#__modules',$row['id'], $item);
                      $ref->set('ordering',$row['ordering']);
                      $ref->set('url','');
                      $render = (($this->getOpt('view')=='list') or ($this->getOpt('menutitles')=='0'))? '0':'1';
                      $ref->set('render',$render);
                      $ref->set('SMtype','#__modules');
                      $ref->set('access',$row['access']);

                      if ($posid = $this->Index->getIDbyTitle ('#__template_positions',$row['position'])){
                      $this->Index->addchild('#__template_positions',$posid,'#__modules', $row['id']);
                      }
                      $this->_valtrack->add('mosMenuName',$menutype);
                      unset ($item);

                }
           unset ($row);
        }

        function getMosPositions ($positions) {

            $db =& $this->_db;
            $db->clearall();
            $db->addsql ('table','#__template_positions');
            $db->addsql ('field', '*');
            if (is_array($positions)) {
              $db->addsql('andor', $positions, 'id');
            }
            $ret = $db->autoquery();
            if (!$ret) {return FALSE;}

            while ($row = $db->getNextRow()){
            $name = $row['position'];
              $item = '';
              $item->id = $row['id'];
              $item->title = $row['position'];
              $item->SMtype = '#__template_positions';
              $ref =& $this->Index->addItem ('#__template_positions',$row['id'],$item);
              $ref->set('ordering',($this->getPriority ($row['id'],$this->getOpt('table_prefix').'template_positions',$row['id'])));
              $ref->set('url','');
              $ref->set('render','0');
              $ref->set('access','0');
              $this->_valtrack->add('template_positions_names', $name);
              unset ($item);
            }

         }


        function getMenuItems ($menus, $ids) {
                 global $my, $params;
                 if (($menus == FALSE) and ($ids == FALSE)){return FALSE;}
                 if (is_array($menus)){
                     $menutype = "(menutype='"
                       . join ("' OR menutype='", $menus) . "')";
                     } elseif (is_string($menus) and ($menus != '')) {
                        $menutype = "menutype='" . $menus . "'";
//                       $menus = explode(',', $menus);
//                       $menutype = "(menutype='"
//                         . join ("' OR menutype='", $menus) . "')";
                       } else {
                     $menutype = '';
                 }

                 if (is_array($ids)){
                   $idss = "(id='".join("' OR id='", $ids)."')";
                 } elseif (is_string($ids) and is_numeric($ids)){
                   $idss = "(id='$ids')";
                 } else {
                   $idss = '';
                 }

                 $connctr = (($menutype != '') and ($idss != ''))?
                    ' OR ': '';
                 $where = '('.$menutype.$connctr.$idss.') AND';

                 $access = ($this->getOpt('noauth') == '0') ?
                   "AND access <= '" . $this->getOpt('usergid') . "' " : '';

                 $sql = "SELECT id,link,type,name,menutype,ordering,params,"
                 ."\npublished,access,parent,componentid,browserNav FROM #__menu "
                 ."\nWHERE " . $where . " published='1' " . $access
                 ."\nORDER BY parent,ordering ASC";

                 $this->_db->setQuery ($sql);
//                 $items = array ();
                 $ret = $this->_db->query();
                 if (!$ret){return FALSE;}
                 while ($row = $this->_db->getNextRow()){
                    if (($this->getOpt('Itemid') == $row['id']) and ($this->getOpt('showself')=='0')){
                      continue;
                    }
                    $item = '';
                    $item->id = $row['id'];
                    $item->title = $row['name'];
                    $ref =& $this->Index->addItem('#__menu',$row['id'], $item);
                    $ref->set('ordering',$row['ordering']);
                    $ref->set('mosItemid',$row['id']);
                    $ref->set('SMtype','#__menu');
                    $ref->set('parent', $row['parent']);
                    $ref->set('url',$row['link']);
                    $ref->set('mosMenuType',$row['type']);
                    $ref->set('access',$row['access']);
                    $ref->set('linktype',$row['browserNav']);
                    $ref->set('componentid', $row['componentid']);

                    $mosMenuid = $this->Index->getIDbySpecial ('#__modules',$row['menutype']);
                    $parent = $row['parent'];
                    if (($parent == '0') and ($this->Index->Itemexists('#__modules',$mosMenuid))){
                      $this->Index->addchild('#__modules',$mosMenuid, '#__menu', $row['id']);
                      $pref =& $this->_false;//FALSE;

                     } elseif (($parent > '0') and $this->Index->Itemexists('#__menu',$parent)) {
                         $this->Index->addchild('#__menu',$parent, '#__menu', $row['id']);
                         $pref =& $this->Index->getref('#__menu', $parent);
                      } else {
                        $pref =& $this->_false;// FALSE;
                      }

                     switch ($row['type']) {
                             case 'content_section':
                                   $secid = '';
                                   $secid = $row['componentid'];
                                   $this->_valtrack->add ('#__sections',$secid);
                                   if ($ref){
                                   $ref->setaquire ($this->getOpt('table_prefix').'sections', $row['componentid']);
                                   $ref->set('blocktype', 'container');
                                   }
                                   $this->Index->addchild ('#__menu',$row['id'], '#__sections', $row['componentid']);
                                   if ($pref){
                                     $pref->blockchild('#__sections', $secid);
                                   }

                             break;
                             case 'content_blog_category':
                             case 'content_blog_section':
                                   $secid = '';
                                   $bsparams =& new mosParameters( $row['params'] );
                                   $secid = $bsparams->get ('sectionid', '');
                                   $secid = ($secid == '')? 'all': $secid;
                                    $cSMtype = '';
                                    $cSMtype = ($row['type'] == 'content_blog_section')?
                                        $this->getOpt('table_prefix').'sections':
                                        $this->getOpt('table_prefix').'categories';
                                   $this->_valtrack->addvals ($cSMtype,$secid);
                                   $ref->set('show_cats', $bsparams->get('category', '0'));
                                   $ref->set('link_cats', $bsparams->get('category_link', '1'));
                                   $ref->set('blocktype', 'container');
                                   if ($ref){
                                       if ($row['componentid'] != '0'){
                                         $ref->setaquire ($cSMtype, $row['componentid']);
                                       }
                                       $this->Index->addchild ('#__menu',$row['id'], $cSMtype, $secid);
                                   }
                                   if (($pref) and ($row['componentid'] != '0')){
                                     $pref->blockchild($cSMtype, $secid);
                                   }
                                   $bsparams = '';
                             break;
                             case 'content_category':
                             case 'content_archive_category':
                             case 'contact_category_table':
                             case 'newsfeed_category_table':
                             case 'weblink_category_table':

                                   $catid ='';
                                   $catid = $row['componentid'];
                                   $this->_valtrack->add('#__categories',$catid);
                                   if ($ref){
                                   $ref->setaquire ($this->getOpt('table_prefix').'categories', $row['componentid']);
                                   $this->Index->addchild('#__menu',$row['id'], '#__categories', $row['componentid']);
                                   $ref->set('blocktype','container');
                                   }
                                   if ($pref){
                                     $pref->blockchild('#__categories', $catid);
                                   }
                             break;
                             case 'components':
                                   $compid = '';
                                   $compid = $row['componentid'];
                                   $this->_valtrack->add('#__components',$compid);
                                   if ($ref) {
                                     $ref->setaquire ($this->getOpt('table_prefix').'components', $row['componentid']);
                                     $ref->set('blocktype', 'container');
                                   }
                                   $this->Index->addchild('#__menu',$row['id'], '#__components', $row['componentid']);
                             break;
                             case 'content_item_link':
                             case 'content_typed':
                                   $itemid = '';
                                   $itemid = $row['componentid'];
                                   $this->_valtrack->add('#__content',$itemid);
                                   if ($ref){
                                   $ref->setaquire ($this->getOpt('table_prefix').'content',$row['componentid']);
                                   $ref->set('blocktype', 'item');
                                   }
                                   if ($pref){
                                     $pref->blockchild('#__content', $itemid);
                                   }
                             break;
                             case 'contact_item_link':
                                   $itemid = '';
                                   $itemid = $row['componentid'];
                                   $this->_valtrack->add('#__contact_details',$itemid);
                                   if ($ref){
                                   $ref->setaquire ($this->getOpt('table_prefix').'contact_details', $row['componentid']);
                                   $ref->set('blocktype','item');
                                   }
                                   if ($pref){
                                     $pref->blockchild('#__contact_details', $itemid);
                                   }
                             break;
                             default:
                             break;
                     }
                   unset ($item);
                 }
        }

        function getComponents ($components) {
                 global $my;
                 if (is_array($components)){
                     $components = "(id='". join("' OR id='",$components)."')";
                 } elseif ($components == '') {
                     return FALSE;
                 } else {
                     $components = "(id='" . $components . "')";
                 }

                 $sql = "SELECT * FROM #__components "
                 . "\nWHERE " . $components ;

                 $this->_db->setQuery ($sql);
                 $ret = $this->_db->query();
                 if (!$ret){return FALSE;}


                 while ($row = $this->_db->getNextRow()){
                     $id = $row['id'];
                     $item = '';
                     $special = ($row['option'] == '') ? substr($row['link'],7) : $row['option'];
                     switch ($special){
                        case 'com_contact':
                        case 'com_newsfeeds':
                        case 'com_weblinks':
                          $item->special = $special;
                          $secid = ($special == 'com_contact')? 'com_contact_details': $special;
                          $this->_valtrack->add ('mosSectionCatRef',$secid);
                        break;
                        default:
                        break;
                     }

                     $item->title = ($row['option'] == '') ? substr($row['link'],7) : $row['option'];
                     $item->id = $row['id'];
                     $ref =& $this->Index->addItem('#__components', $id, $item);
                     $ref->set('title',$row['option']);
                     $ref->set('ordering',$row['id']);
                     $ref->set('SMtype','#__components');
                     $ref->set('render','0');
                     $ref->set('parent','0');
                     $ref->set('access','0');


                     $this->_valtrack->add('#__components', $id);
                     unset ($item);
                 }

        }

        function getSections ($sections) {
                 if (is_array($sections)){
                     $sections = "(id='"
                      . join ("' OR id='", $sections) . "') AND ";
                     } elseif ($sections == '') {
                     return FALSE;
                     } elseif ($sections == 'all'){
                        $sections = '';
                     } else {
                     $sections = "(id='" . $sections . "') AND ";
                 }
                 $access = ($this->getOpt('noauth') == '0') ?
                   "AND access <= '" . $this->getOpt('usergid') . "' " : '';

                 $sql = "SELECT * FROM #__sections "
                  . "\nWHERE " . $sections ." published='1' "
                  .$access;

                 $this->_db->setQuery ($sql);
                 $ret = $this->_db->query();
                 if (!$ret){ return FALSE;}
                 $expand = ($this->getOpt('exp_sections') == '1')? '1':'0';

                 while ($row = $this->_db->getNextRow()){
                         $id = $row['id'];
                         $item = '';
                         $item->title = $row['title'];
                         $item->id = $row['id'];
                         $ref =& $this->Index->addItem('#__sections',$id, $item);
                         $ref->set('ordering',$row['ordering']);
                         $ref->set('SMtype','#__sections');
                         $ref->set('parent','0');
                         $ref->set('count',$row['count']);
                         $ref->set('access',$row['access']);
                         $ref->set('desc',$row['description']);
                         $ref->set('url', $this->getOpt('deriveurl'));
                         $ref->set('blocktype','container');
                         $ref->set('expand', $expand);
                         $this->_valtrack->add ('mosSectionCatRef',$id);
                         $this->_valtrack->add ('#__sections',$id);
                         unset ($item);
                 }
        }

        function getCats ($cats, $sections) {
                if (($cats == FALSE)and($sections == FALSE)) return FALSE;
                if (($cats == 'all') or ($sections == 'all')){
                  $where = '';
                } else {
                  if (($sections != FALSE) and is_array($sections)){
                     $section_list = "(section='"
                     . join("' OR section='", $sections) . "') AND ";
                  } else {
                    $section_list = '';
                  }
                  if (($cats != FALSE) and is_array($cats)){
                    $cat_list = "(id='". join ("' OR id='", $cats) . "') AND ";
                  } else {
                    $cat_list = '';
                  }
                 if (($section_list != '') and ($cat_list != '')) {
                    $where = ' ('.substr($section_list,0,-5) . " OR "
                         . substr($cat_list,0,-5).') AND ';
                 } else {
                    $where = $section_list . $cat_list;
                 }
                }
                 $access = ($this->getOpt('noauth') == '0') ?
                   "AND access <= '" . $this->getOpt('usergid') . "' " : '';

                 $sql = "SELECT * FROM #__categories "
                 . "\nWHERE " . $where . " published='1' $access"
                 . " \nORDER BY id";

                 $this->_db->setQuery ($sql);
                $ret = $this->_db->query();
                if (!$ret){return FALSE;}
                 $expandcont = $this->getOpt('exp_categories');
                 $expandct = $this->getOpt('exp_ct_cat');
                 $expandnf = $this->getOpt('exp_nf_cat');
                 $expandwl = $this->getOpt('exp_wl_cat');

                while ($row = $this->_db->getNextRow()){
                     $id = $row['id'];
                     $item = '';
                     $item->title = $row['title'];
                     $item->id = $row['id'];
                     $ref =& $this->Index->addItem('#__categories',$id, $item);
                     $ref->set('ordering',$row['ordering']);
                     $ref->set('SMtype','#__categories');
                     $ref->set('parent',$row['parent_id']);
                     $ref->set('count',$row['count']);
                     $ref->set('desc',$row['description']);
                     $ref->set('access',$row['access']);
                     $ref->set('section', $row['section']);

                     $ref->set('blocktype','container');

                    switch ($row['section']){
                        case 'com_newsfeeds':
                        if ($row['section'] == 'com_newsfeeds')$ref->set('expand', $expandnf);
                        case 'com_weblinks':
                        if ($row['section'] == 'com_weblinks') $ref->set('expand', $expandwl);
                        case 'com_contact_details':
                        if ($row['section'] == 'com_contact_details') $ref->set('expand', $expandct);
                          $sectitle = ($row['section'] == 'com_contact_details')?
                            'com_contact' : $row['section'];
                          $ref->set('url', $this->getOpt('deriveurl'));
                          $compid = $this->Index->getIDbySpecial ('#__components',$sectitle);
                          $this->Index->addchild('#__components',$compid, '#__categories', $id);
                          $this->_valtrack->add('#__categories',$id);
                        break;
                        default:
                        $ref->set('url', $this->getOpt('deriveurl'));
                        $this->Index->addchild('#__sections',$row['section'],'#__categories',$id);
                        $this->_valtrack->add('#__categories',$id);
                        $ref->set('expand', $expandcont);
                        break;
                    }
                    unset ($item);
                 }
        }

        function getContentItems ($cats, $items) {
            global $mosConfig_offset;
                if (($cats == FALSE) and ($items == FALSE)) return FALSE;
               $now = date( 'Y-m-d H:i:s', time() + $mosConfig_offset * 60 * 60 );

                if (($cats == 'all') or ($items == 'all')){
                  $cats_items = '';
                } else {
                  if (($cats != FALSE) and is_array($cats)){
                     $cat_list = "(c.catid='"
                     . join("' OR c.catid='", $cats) . "') ";
                  } else {
                    $cat_list = '';
                  }
                  if (($items != FALSE) and is_array($items)){
                    $item_list = "(c.id='". join ("' OR c.id='", $items) . "') ";
                  } else {
                    $item_list = '';
                  }
                 if (($cat_list != '') and ($item_list != '')) {
                    $cats_items = '('.$cat_list . " OR " . $item_list.') AND';
                 } else {
                    $cats_items = $cat_list . $item_list .' AND';
                 }
                }

                 $access = ($this->getOpt('noauth') == '0') ?
                   "AND access <= '" . $this->getOpt('usergid') . "' " : '';

                $wheretime ="\n (c.publish_up = '0000-00-00 00:00:00'"
                  . " OR c.publish_up <= '$now')"
                  . "\n AND (c.publish_down = '0000-00-00 00:00:00'"
                  . " OR c.publish_down >= '$now')";

                 $sql = "SELECT c.id as id,c.state as state,c.title as title,"
                    ."c.introtext as introtext,c.fulltext as text,c.parentid as parentid,"
                    ."c.ordering as ordering,c.catid as catid,c.sectionid as sectionid,c.hits as hits,"
                    ."c.publish_up as publish_up, c.publish_down as publish_down,"
                    ." c.access as access,r.content_id as cid, r.rating_sum as rsum,"
                    ." r.rating_count as rcount FROM #__content as c"
                    ."\nLEFT JOIN #__content_rating as r ON (c.id = r.content_id)"
                    ."\nWHERE " . $cats_items . $wheretime
                    ." AND (c.state='1' OR c.state='-1')"
                    ."\n $access"
                    ."\nORDER BY c.id";
                 $this->_db->setQuery ($sql);
                 $expand = ($this->getOpt('exp_content') == '1')? '1':'0';
                $ret = $this->_db->query();
                if (!$ret){return FALSE;}

                 while ($row = $this->_db->getNextRow()){
                         $id = $row['id'];
//                         $state = $row['state'];
                         $item = '';
                         $item->title = $row['title'];
                         $item->id = $row['id'];
                         if ($row['state'] == '1'){
                         $ref =& $this->Index->addItem ('#__content',$id, $item);
                         } else {
                           $ref =& $this->Index->addItem ('archive_content',$id,$item);
                         }
                         $ref->set('ordering',$row['ordering']);
                         $ref->set('desc',$row['introtext'].$row['text']);
                         $ref->set('SMtype','#__content');
                         $ref->set('parent',$row['parentid']);
                         $ref->set('expand', $expand);
                         $ref->set('hits',$row['hits']);
                         $ref->set('rating',(($row['rsum'] != NULL)?
                            ($row['rsum'] / $row['rcount']) : NULL));
                         $ref->set('rvotes',(($row['rcount'] != NULL) ?
                            $row['rcount'] : NULL));
                         $ref->set('url','index.php?option=com_content&task=view&id='
                            . $row['id']);
                         $ref->set('access',$row['access']);
                         if ($row['state'] == '1'){
                           $this->Index->addchild('#__categories',$row['catid'], '#__content', $id);
                         }
                         }
                         unset ($item);
                 }

        function getContacts ($cats, $items) {
            $db =& $this->_db;
            $db->clearall();
            $db->addsql('table','#__contact_details');
            $db->addsql('field', '*');
            $db->addsql('and', '1', 'published');
            if ($this->getOpt('noauth') == '0'){
            $access = $this->getOpt('usergid');
            $db->addsql('and',"$access",'access','','<=');
            }
            if (($cats == 'all') or ($items == 'all')){ } else {
            if (is_array($cats)) {$db->addsql('or', $cats, 'catid');}
            if (is_array($items)){$db->addsql('or', $items, 'id');}
            }

            $ret = $db->autoquery();
            if (!$ret){return FALSE;}
            $expand = ($this->getOpt('exp_contacts') == '1')? '1':'0';

            while ($row = $db->getNextRow()){
                 $id = $row['id'];
                 $item = '';
                 $item->title = ($row['con_position'] == '')?
                    $row->name : $row['name'].' ('.$row['con_position'].')';
                 $item->id = $row['id'];
                 $ref =& $this->Index->addItem('#__contact_details',$id, $item);
                 $ref->set('url','index.php?option=com_contact&task=view&contact_id='
                    . $row['id']);
                 $ref->set('desc', @$row['name'].':'.@$row['address'].', '
                    .@$row['suburb'].', '.@$row['state'].', '.@$row['country'].'.'.
                    @$row['misc']);
                 $ref->set('ordering',$row['ordering']);
                 $ref->set('SMtype','#__contact_details');
                 $ref->set('render','1');
                 $ref->set('expand', $expand);
                 $ref->set('parent','0');
                 $ref->set('access',$row['access']);

                 $this->Index->addchild ('#__categories',$row['catid'],'#__contact_details',$id);
                 $this->_valtrack->add('#__contact_details',$id);
                 unset ($item);
             }
        }

        function getNewsfeeds ($cats, $nf) {
            $db =& $this->_db;
            $db->clearall();
            $db->addsql('table','#__newsfeeds');
            $db->addsql('field', '*');
            $db->addsql('and', '1', 'published');
            if (($cats == 'all') or ($nf == 'all')){ } else {
              if (is_array($cats)) {$db->addsql('or', $cats, 'catid');}
              if (is_array($nf)){$db->addsql('or', $nf, 'id');}
              }


           $ret = $db->autoquery();
           if (!$ret){return FALSE;}
            $expand = ($this->getOpt('exp_newsfeeds') == '1')? '1':'0';

            while ($row = $db->getNextRow()){
                 $id = $row['id'];
                 $item = '';
                 $item->title = $row['name'].',  ('.$row['numarticles'].') '
                    .$this->getLang('label_nf_articles');
                 $item->id = $row['id'];
                 $ref =& $this->Index->addItem('#__newsfeeds',$id, $item);
                 $ref->set('url','index.php?option=com_newsfeeds&task=view&feedid='
                    .$row['id']);
                 $ref->set('ordering',$row['ordering']);
                 $ref->set('SMtype','#__newsfeeds');
                 $ref->set('render','1');
                 $ref->set('expand', $expand);
                 $ref->set('parent','0');
                 $ref->set('access','0');

                 $this->Index->addchild ('#__categories',$row['catid'],'#__newsfeeds',$id);
                 $this->_valtrack->add('#__newsfeeds',$id);
                 unset ($item);
             }
        }

        function getWebLinks ($cats, $wl) {
            $db =& $this->_db;
            $db->clearall();
            $db->addsql('table','#__weblinks');
            $db->addsql('field', '*');
            $db->addsql('and', '1', 'published');
            if (($cats == 'all') or ($wl == 'all')){ } else {
              if (is_array($cats)) {$db->addsql('or', $cats, 'catid');}
              if (is_array($wl)){$db->addsql('or', $wl, 'id');}
              }


           $ret = $db->autoquery();
           if (!$ret){return FALSE;}
            $expand = ($this->getOpt('exp_weblinks') == '1')? '1':'0';

            while ($row = $db->getNextRow()){
                 $id = $row['id'];
                 $item = '';
                 $catid = $row['catid'];
                 $params =& new mosParameters($row['params']);
                 $item->title = $row['title'];
                 $item->id = $row['id'];
                 $ref =& $this->Index->addItem('#__weblinks',$id, $item);
                 $ref->set('url',"index.php?option=com_weblinks&task=view&catid=$catid&id=$id");
                 $ref->set('ordering',$row['ordering']);
                 $ref->set('linktype', $params->get('target',''));
                 $ref->set('desc', $row['description']);
                 $ref->set('SMtype','#__weblinks');
                 $ref->set('render','1');
                 $ref->set('expand', $expand);
                 $ref->set('parent','0');
                 $ref->set('access','0');

                 $this->Index->addchild ('#__categories',$row['catid'],'#__weblinks',$id);
                 $this->_valtrack->add('#__weblinks',$id);
                 unset ($item);
             }
        }

        function searchitem($item, &$client, $type){
            if ($item ==''){return '';}
            $sm = $this->getOpt('search_mode');
            $length = $this->getOpt('sr_desc_len');
            if (intval($sm) > 3){
              $item = substr($item,0,$length);
              return $this->trimItem($item);
            }
            $found = 0;
            $term = $this->getOpt('search_terms');
            $count = count($term);
            $use_hl = $this->getOpt('sr_show_hl');
            $hlcolor = $this->getOpt('sr_search_clr');
            if ($type == 'title'){
                $hlbld = (($this->getOpt('sr_search_bld') == '1')
                and ($this->getOpt('sr_title_hl') == '1'))?
                'font-weight:bold;':'';
            } else {
                $hlbld = ($this->getOpt('sr_search_bld') == '1')?
                'font-weight:bold;':'';
            }
            $hopen = '<span style="'.$hlbld.'color:'.$hlcolor.'">';
            $hclose = '</span>';
            $matches = '';
//            $found = '';
            $pos = '';
//            $add = '';
            $hits = '';//array(0=>0);
//            $patterns = '';
            $replace = '';

            foreach ($term as $key=>$val){
                if ($val == ''){continue;}

                      $pr_pat1 = '%\b';
                      $pr_pat2 = '\b%mis';
                      $pm_pat1 = '%(.){0,1}(\b';
                      $pm_pat2 = '\b)(.){0,1}%mis';
                      $pr_retp1 = '$0';
//                      $pm_retp1 = '$2';
                      //$retp2 = '';
                      $valpat = $val;
                    $cnt = 0;
                    $testpos = 0;
                        while (($test = strpos($val,'*',$testpos)) or ($test !== FALSE)){
                          $cnt++;
                          $testpos = $test +1;
                        }
                        if ($cnt > 0){
                            $newstrings = explode('*',$val);
                            $nest_count = count($newstrings);
//                            $br_count = 0;

                            $wc_pat = "([^\s]){0,40}";
                            $patstart = '(';
                            $patend = ')';
                            if ($newstrings[0] == '') {
                              $patstart = $wc_pat.$patstart;
                              unset ($newstrings[0]);
//                              $br_count++;

                            }
                            if ($newstrings[$nest_count - 1] == ''){
                            $patend = $patend.$wc_pat;
                            unset ($newstrings[$nest_count -1]);
//                            $br_count++;
                            }
                            $valpat = $patstart.implode(")([^\s]){0,40}(",$newstrings).$patend;
//                            $rep1 = '';

//                            $nest_count = ((count($newstrings)*2)-1) + $br_count;
//                            $n = 1;
//                            while ($n <= $nest_count){
//                              $rep1 = '$0'/*.$n*/;
//                              $n++;
//                            }
                        }

              if (isset($newstrings) and is_array($newstrings)){
                sort($newstrings, SORT_REGULAR);
                $cnt = count($newstrings)-1;
                $n = $cnt;
                $testpos = FALSE;
                while  ($n >= 0){
                      $testval = strpos(strtolower($item), strtolower($newstrings[$n]));
                      if ($testval === FALSE){
                        $n--;
                        continue;
                      } else if (($testpos === FALSE) or (($testval !== FALSE) and ($testval < $testpos))){
                        $testpos = $testval;
                      }
                  $n--;
                 }
              } else {
                $testpos = strpos(strtolower($item),strtolower($val));
              }
              if($testpos !== FALSE){
                $pm_patterns[$key] = $pm_pat1.$valpat.$pm_pat2;
                $num = preg_match_all($pm_patterns[$key], $item, $matches);
                if ($num > 0){
                  $cnt = count($matches[0])-1;
                  $n = $cnt;
                  $pos = FALSE;
                    while ($n >= 0){
                      $testval = strpos(strtolower($item), strtolower($matches[0][$n]));
                      if ((($pos === FALSE) and ($testval !== FALSE)) or (($testval !== FALSE) and ($testval < $pos))){
                        $pos = $testval;
                      }
                      $n--;
                    }
                    $hits[$val] = $num;
                    $pr_patterns[$key] = $pr_pat1.$valpat.$pr_pat2;
                    $replace[$key] = $hopen.$pr_retp1.$hclose;
                } /*else {
                  unset ($patterns[$key]);
                }
*/              }
            }

                if ($sm == '1'){
                    if (is_array($hits)){
                    $test = (count($hits)== $count)? TRUE:FALSE;
                    } else {
                      $test = FALSE;
                    }
                } else {
                  $test = (is_array($hits))? TRUE:FALSE;
                }

                if ($test === TRUE){
                  $found = array_sum($hits);
                  $item = $this->trimItem($item,$pos);

                  if (is_array($pr_patterns) and (is_array($replace) and ($use_hl == '1'))){
                    ksort ($pr_patterns);
                    ksort ($replace);
                    if ((($type == 'title') and ($this->getOpt('sr_title_hl') == '1'))
                        or ($type != 'title')){
                        $item = preg_replace($pr_patterns,$replace,$item);
                    }
                  }
                } else {
                  $found = 0;
                  $item = $this->trimItem($item);
                }

            if ($found > 0){
              $client->set($type.'_hits', $client->get($type.'_hits')+$found);
              $client->set('search_hits', $client->get('search_hits')+$found);
              $client->set($type.'_termhits', $hits);
            }
            return $item;

        }

        function getsrank (&$client){

            $terms = $this->getOpt('search_terms');
//            $s_hits = $client->get('search_hits');
            $thits = $client->get('title_hits');
//            $dhits = $client->get('desc_hits');
            $tchars = $client->get('desc_count') + $client->get('title_count');

            $ttermhits = $client->get('title_termhits');
            $dtermhits = $client->get('desc_termhits');
            $termchars = 0;
            $termhits = '';
            if (is_array($terms)){
                $termchars = 0;
                foreach($terms as $val){
                  $title = (isset($ttermhits[$val]))? $ttermhits[$val]:0;

                  $desc = (isset($dtermhits[$val]))? $dtermhits[$val]:0;

                  $termhits[$val] = $desc + $title;
                }
                if (is_array($termhits)){
                    foreach($termhits as $key=>$val){
                        $termchars = $termchars + (strlen($key) * $val);
                    }
                }
            }
            $w['dens'] = $this->getOpt('sr_densw');
            $w['title'] = $this->getOpt('sr_titlew');
//            $w['desc'] = 2;
            $w['all'] = $this->getOpt('sr_allw');

            $converto = 100; // Numeric standard for result
            $precision = 6; //decimels to use for equations

            $maxdens = $this->getOpt('sr_maxdens');//  Word density(%) to equate to $converto number (100%)
            $base = $maxdens/$converto;

            if (($tchars > 0) and ($termchars > 0)){
            $tdens = round($termchars / $tchars,$precision);
            $ddens = round((($tdens)/($base)),$precision);
            }
            $total['dens'] = ($ddens > ((1)))? 1 * $w['dens']: round((1 * $ddens),4) * $w['dens'];
            $nbase = $total['dens']/$w['dens'];
            $total['title'] = ($thits > 0)? 1 * $w['title']:($nbase) * $w['title'];
            $total['all'] = (($title > 0) and  ($desc > 0))?
                    1 * $w['all']:$w['all']*($nbase);
            $tnum = count($terms);
//            $tdif = $tnum - count($termhits);
//            $total['terms'] = ($tdif == '0')? 100 * $w['terms']: count($termhits)/$tnum * $w['terms'];
           $totals = round(array_sum($total)/array_sum($w)*100);//*10000;

            return $totals;

        }



        function setSearchOpts ($search, $mode){
            $save = array();
            if (get_magic_quotes_gpc()){
            $search = stripslashes($search);
          }

          $string = trim(preg_replace("%[^\w'*.]%", ' ', $search));

          if (($mode == '0') or ($mode == '1')){
          $rawtxt = trim(preg_replace("%[^\w'*.]%", ' ', $search));
          $rawtxt = explode (' ',$rawtxt);
              foreach ($rawtxt as $term){
                $ready[] = trim(preg_replace("%[^\w'*.]%", '', $term));
              }
          } else {
            $ready[] = $string;
          }
          foreach ($ready as $val){
            if ($val != ''){
              $save[] = $val;
            }
          }
          $this->_options->search_terms = $save;
          $this->_options->search_string = $string;


        }

        function createLink ($url, $title, &$client, $type=''){

            if (($this->getOpt('usergid') >= $client->get('access')) and ($url != '')){
                switch ($type) {
                        // cases are slightly different
                        case 1:
                        // open in a new window
                        $newurl = "<a href='$url' target='_window'>$title</a>";
                        break;

                        case 2:
                        // open in a popup window
                        $newurl = "<a href=\"#\" onclick=\"javascript: window.open('"
                            . $url ."', '', 'toolbar=no,location=no,status=no,"
                            . "menubar=no,scrollbars=yes,resizable=yes,width=780"
                            . ",height=550'); return false\">$title</a>\n";
                        break;

                        case 3:
                        // don't link it
                        $newurl = $title;
                        break;

                        default:        // formerly case 2
                        // open in parent window
                        $newurl = "<a href='$url'>$title</a>";
                        break;
                }
            } elseif ($this->getOpt('usergid') < $client->get('access')) {
              $authlang = ($client->get('access') == '1')? $this->getLang('noauth'):
                $this->getLang('adminonly');
                $newurl = $title.' '.$authlang;
            } else {
              $newurl = $title;
            }
                return $newurl;
        }

        function selectIcon (&$client){
            $icon = '';
            $auth = '';
            $auth = ($this->getOpt('usergid') < $client->get('access'))? 'na':'';
            if (!$client->get('icontype')){
                $icon = ($client->get('blocktype') == 'container')? $this->getIcon($auth.'folder'):
                    $this->getIcon($auth.'page');
            } else {
                $icon = $this->getIcon($auth.$client->get('icontype'));
            }
            $icon = ($this->getOpt('icons')== '0')? '':
                    '<img src="'.$this->getOpt('icondirurl').$icon.'" alt="'.$icon.'" /> ';
            return $icon;

        }

        function displayMap () {
                global $mainframe;
                $renderlist = array();
                $pagetitle = $this->getOpt('title');
                $pagedesc =  ($this->getOpt('page_desc') != '')?
                "<tr><td>".$this->getOpt('page_desc')."</td></tr>": '';
                $map = "<table class='contentpaneopen'>
                <tr>
                <td class='contentheading' width='100%'>$pagetitle
                </td>
                </tr>
                </table>\n";

                $view = $this->getOpt('view');
                $sort = $this->getOpt('sort');
                  switch ($sort) {
                    case 'search':
                    $leftcol = ($this->getOpt('sr_sho_rtng')=='1')?
                        "<td style='padding:2px;margin:2px;"
                        . "text-align:center' class='sectiontableheader'> "
                        . $this->getLang('label_rank')." </td>\n":'';
                    break;
                    case 'hits':
                    $leftcol = "<td style='padding:2px;margin:2px;"
                        . "text-align:center' class='sectiontableheader'> "
                        . $this->getLang('label_hits')." </td>\n";
                    break;
                    case 'rating':
                    case 'votes':
                    $leftcol = "<td style='padding:2px;margin:2px;"
                        . "text-align:center' class='sectiontableheader'> "
                        . $this->getLang('label_rating')." </td>\n"
                        . "<td style='padding:2px;margin:2px;"
                        . "text-align:center' class='sectiontableheader'> "
                        . $this->getLang('label_votes')." </td>\n";
                    break;
                    default:
                    $leftcol = '';
                    break;
                  }


                $tabletitle = ($view == 'map')?
                    $this->getLang('label_doctree') :
                    $this->getLang('label_title');

                $map .= "<table class='contentpaneopen'>$pagedesc"
                    ."<tr>
                    <td style='"
                    ."text-align:right;padding:2px;margin:0px'>".$this->samMenu()
                    ."
                    </td>
                    </tr>
                    <tr>
                    <td>
                    <table "
                    ."width='100%' cellpadding='1' cellspacing='1' border='0'"
                    .">
                    <tr>
                    $leftcol
                    <td style='padding:2px 2px 2px "
                    .$this->getOpt('pad')."px;margin:2px' class='"
                    ."sectiontableheader'>$tabletitle
                    </td>
                    </tr>
                    ";


                if (is_array($this->_renderlist)){
                  foreach ($this->_renderlist as $row) {
                    $c =& $row['client'];
                        $pad = ($this->getOpt('view') == 'map') ?
                            (count(explode($this->getOpt('seperator'), $row['idx']))-1) * $this->getOpt('pad'):$this->getOpt('pad');
                        $icon = $this->selectIcon($c);
                        $url = $row['url'];
                        $title = $row['title'];
                        $title = $icon.$this->createLink($url,$title,$c,$c->get('linktype'));
                        if ($c->testv('desc') and ($c->get('access') <= $this->getOpt('usergid'))) {
                            $desc = "<span class='small'><br />" .$c->get('desc')."...</span>";
                            } else {
                              $desc = '';
                              }
                        $itemclass = (($view == 'list') or ($view == 'search'))? " class='replace'":'';
                        $qtyclass = " class='replace'";

                  switch ($sort) {
                    case 'search':
                        $qty = ($c->testv('search_rank')) ? $c->get('search_rank').'%' : '*';
                        $listdata = ($this->getOpt('sr_sho_rtng')=='1')?
                            "<td style='text-align:center;"
                            ."vertical-align:text-top;' $qtyclass>$qty</td>\n":'';
                    break;
                    case 'hits':
                        $qty = ($c->testv('hits')) ? $c->get('hits') : '*';
                        $listdata = "<td style='text-align:center;"
                            ."vertical-align:text-top' $qtyclass>$qty</td>\n";
                    break;
                    case 'rating':
                    case 'votes':
                        $qty = ($c->testv('rating')) ? round($c->get('rating'),1) : '*';
                        $vqty = ($c->testv('rvotes')) ? $c->get('rvotes'):'*';
                        $listdata = "<td style='text-align:center;"
                            ."vertical-align:text-top' $qtyclass>$qty</td>\n"
                            ."<td style='text-align:center;vertical-align:text-top' "
                            . $qtyclass.">$vqty</td>\n";

                    break;
                    default:
                        $listdata = '';
//                        $mapdata='';
                    break;
                  }
                  $bpad = ($this->getOpt('view') == 'map')? '1px':'5px';
                  $html = "<tr>$listdata<td style='padding:0px 0px $bpad "
                    . $pad ."px' $itemclass>".$title  .$desc."</td></tr>\n";

                $rkey = $row['idx'];
                if (($this->getOpt('view') == 'map') or ($this->getOpt('sort')=='ordering')){
                  $rkey = preg_replace('%[^\d]%mis','',$row['idx']);
                  $renderlist[$rkey] = $html;
                  } else {
                    $temp = array_reverse(explode($this->getOpt('seperator'), $rkey));
                    $newkey = $temp[0].preg_replace('%[^\d\w]%mis','',$row['idx']);;
                    $renderlist[$newkey] = $html;
                  }

                } // end foreach construct
                } else {
                  $renderlist[0] = "<td>".$this->getLang('label_search_nf')."</td></tr>";
                }

                ksort ($renderlist, SORT_STRING);

                $evenodd = '1';
                foreach ($renderlist as $key => $val) {
                        $newval = str_replace("class='replace'","class='sectiontableentry$evenodd'",$val);
                        $map .= $newval ;
                        $evenodd = ($evenodd == '1')? '2' : '1';
                      }

                $footnote = (($sort == 'rating') or ($sort == 'hits') or ($sort == 'votes'))?
                    "<br />'*' = ".$this->getLang('label_'.$sort)." "
                    .$this->getLang('label_star') : '';

//    Removing or altering the $credit variable, or its rendering, is a violation
//    of Copyrights for samSiteMap component.
                $clink[1] = "<a href='http://roadstarclinic.com/component/option"
                    .",com_samSiteMap/Itemid,174' class='small'>RoadStarClinic.com</a>";
                $clink[2] = "<a href='http://mlshomequest.com/component/option"
                    .",com_samsitemap/Itemid,115/' class='small'>MLSHomeQuest.com</a>";


                $randn = rand(1,2);
                $link = $clink[$randn];
                $ver = 'samSiteMap ver '.$this->version;
                $credit = "<a href='http://coders.mlshomequest.com/"
                    ."' class='small'>$ver</a><br />"
                    .$this->getLang('label_credit')
                    ." $link";

                $map .= "</table></td></tr><tr><td style='text-align:left;"
                     . "padding:5px'></td></tr><tr><td style='"
                     . "text-align:center;padding:5px'"
                     . " class='small'></td></tr></table>" ;



//                $mainframe->SetPageTitle( $this->getOpt('title') );

                $adminalert = ($this->getOpt('usergid') == '2') ? $this->_adminalert : '';
                return $adminalert . $map;

        }

    function processAttrs (&$client, $mosItemid){
      global $mosConfig_live_site, $mainframe;
                $url = ($tmp = $client->get('url'))? $tmp: '';
                $type = ($tmp = $client->get('mosMenuType'))? $tmp:'url';
                $cSMtype = $client->get('SMtype');
                $newurl = $url;
                $render = $client->get('render');
                if ($newurl == $this->getOpt('deriveurl')){
                $menParent =& $this->Index->getref('#__menu', $mosItemid);
                $mptype = $menParent->get('mosMenuType');
                if ($mptype == 'components'){
                  $compref =& $this->Index->getref('#__components', $menParent->get('componentid'));
                  if ($compref) $mptype = $compref->get('title');
                }
                  switch ($mptype){
                        case 'com_newsfeeds':
                        case 'com_weblinks':
                        case 'com_contact':
                        case 'contact_category_table':
                        case 'newsfeed_category_table':
                        case 'weblink_category_table':
                            switch ($cSMtype){
                              case '#__categories':
                              $catid = '';
                              $catid = $client->get('id');
                              $newurl = "index.php?option=$mptype&catid=$catid";
                              break;
                            }
                        break;
                        case 'content_category':
                        case 'content_section':
                            switch ($cSMtype){
                                case '#__categories':
                                $secid = $client->get('section');
                                $catid = $client->get('id');
                                $newurl = "index.php?option=com_content&task=category&sectionid=$secid&id=$catid";
                                break;
                            }
                        break;
                        case 'content_blog_category':
                        case 'content_blog_section':
                            switch ($cSMtype){
                                case '#__sections':
                                    $secid = '';
                                    $secid = $client->get('id');
                                    $newurl = "index.php?option=com_content&task=section&id=$secid";
                                    $render = '0';
                                break;
                                case '#__categories':
                                    $catid = '';
                                    $catid = $client->get('id');
                                    $secid = $client->get('section');
                                    if ($menParent->get('link_cats') == '1'){
                                        $newurl = "index.php?option=com_content&task=category&sectionid"
                                            ."=$secid&id=$catid";
                                    } else {
                                      $newurl = '';
                                    }
                                    if ($menParent->get('show_cats') == '0'){
                                      $render = '0';
                                    }
                                break;
                            }
                        break;
                        default:
                        break;

                  }
                }

                switch ($type) {
                        case '':
                        break;
                        case 'separator':
                        $newurl = '';
                        break;
                        case 'component_item_link':
                        break;
                        case 'content_item_link':
                        $temp = split("&task=view&id=", $newurl);
                        $newurl .= '&Itemid='. $mosItemid;
                        break;
                        case 'url':
                        if ( eregi( 'index.php\?', substr($newurl,0,12) ) ) {
                                if ( !eregi( 'Itemid=', $newurl ) ) {
                                        $newurl .= '&Itemid='. $mosItemid;
                                }
                        }
                        break;
                        case 'content_typed':
                        default:
                        $newurl .= '&Itemid='. $mosItemid;
                        break;
                }
                $newurl = str_replace( '&', '&amp;', $newurl );

                if ( strcasecmp( substr( $newurl,0,4 ), 'http' ) ) {
                        $newurl = sefRelToAbs( $newurl );
                }
                $ret['render']= $render;
                $ret['url'] = $newurl;

                return $ret;
    }


        function renderclientChildren (&$clientref, $pid='none', $itemid='0') {
          $client =& $clientref;
            $mosItemid = $client->get('mosItemid');
          if (($mosItemid == '0') and ($itemid == '0')) {
            global $Itemid;
            } else {
              $Itemid = ($mosItemid != '0') ? $client->_mosItemid : $itemid;
            }
                $childQty = (is_object($client->_children)) ?
                    count($client->_children) : '0';

                if ($childQty < 1) { return FALSE;}
                foreach ($client->_children as $key => $val) {

                  $SMtype = $val['SMtype'];
                  $id = $val['id'];
                  $ref =& $this->Index->Itemexists($SMtype, $id);
                  if (($client->_SMtype == '#__menu') and (isset($client->_aquire))
                        and ($val['SMtype'].':'.$val['id'] == $client->_aquire)) {

                    if ($ref != FALSE){
                        $ref->render($pid, $Itemid, '1');
                    }
                  } else {
                    if ($ref != FALSE){
                        $ref->render($pid, $Itemid);
                    }
                  }
                }
        }
        //used to aquire all items from a specific index type (SMtype)
        function harvestall (&$client){
          if (count($client->_harvestall > 0)){
            foreach ($client->_harvestall as $key => $val){
              $ids = $this->Index->getallids ($val['SMtype']);
              foreach ($ids as $key2 => $val2){
                $ref =& $this->Index->getref ($val['SMtype'], $val2);

                if ($ref)$client->addchild ($ref->get('SMtype'), $ref->get('id'));
              }
            }
          }
        }

        function renderclient(&$client, $pid='none', $itemid='0', $skipself='0'){

          if ($client->_rendered == '1' or (isset($client->_expand) and $client->_expand == '0')) return;
          //get a valid Itemid
          $mosItemid = $client->get('mosItemid');
          if (($mosItemid == '0') and ($itemid == '0')) {
            $Itemid = $this->getOpt('Itemid');
          } else {
            $Itemid = ($mosItemid != '0') ? $client->_mosItemid : $itemid;
          }

          //if Item is a menuitem, aquire attributes from its target
          if (($client->get('SMtype') == '#__menu')
              and ($this->getOpt('usergid') <= $client->get('access'))) {
                 $client->aquire();}

          $idx = $this->getSortId($client);
          $parentid = $client->get('parent');
          $SMtype = $client->get('SMtype');
          while ($parentid > '0'){
              $parent =& $this->Index->getref($SMtype,$parentid);
              if ($parent == FALSE){break;}
              $psortid = $this->getSortId($parent);
              $idx = $psortid . $this->getOpt('seperator') . $idx;
              $parentid = $parent->get('parent');
          }

          $title =  $client->get('title');

          $rendvals = $this->processAttrs($client,$Itemid);
          $render = $rendvals['render'];
          $url = $rendvals['url'];

          $seperator = (($skipself == '1') or ($render == '0')) ?
              '<!|top>' : $this->getOpt('seperator');
          if ($pid != 'none'){$idx = $pid . $seperator . $idx;}

          if ($this->getOpt('usergid') >= $client->get('access')) {
            $client->renderChildren ($idx, $Itemid);
          }
          if (($skipself == '1') or ($render == '0') or
            (($client->get('SMtype') != '#__menu') and
             ($this->getOpt('showempty') == '0') and
             ($client->get('blocktype') == 'container') and
             ($client->get('childqty') == '0'))){
          } else {
              $this->addRenderItem ($idx, $title, $url, $client);
          }

          $client->_rendered = ($this->getOpt('multirender') == '1') ? '0' : '1';

        }

        function getOpt ($option, $default=''){
          if (isset($this->_options->$option)) {
            return $this->_options->$option;
            } else {
              return $default;
          }
        }

        function getSortId (&$client){
            $c_ordering = $client->get('ordering');

            $id = $this->padIndex($client->get('id'));

            $ordering = ((bool)strpos($c_ordering, '!priority!') != FALSE) ?
              $this->padIndex(substr($c_ordering,11), '1').$id :
              $this->padIndex($c_ordering).$id;

            switch ($this->getOpt('sort')) {
            case 'normal':
            $idx = ($this->getOpt('view') == 'map')?
                $ordering: $client->get('title').$ordering;
            break;
            case 'hits':
            $idx = ($client->get('hits')) ?
                $this->padIndex($client->get('hits'),'1'):
                $this->padIndex('');
            $idx2 = ($this->getOpt('view')=='map')?
                $ordering:
                strtolower($client->get('title')) . $ordering;
            $idx = $idx . '|' . $idx2 ;
            break;
            case 'search':
            if ($client->get('search_hits') > 0){
              $rank = $this->getsrank($client);
              $client->set('search_rank', $rank);
              }

            $idx = ($client->get('search_hits') > 0) ?
                $this->padIndex($client->get('search_rank'),'1')
                : $this->padIndex('');
            $idx2 = strtolower(strip_tags($client->get('title'))) . $ordering;
            $idx = $idx . '|' . $idx2 ;
            break;
            case 'rating':
            $rating = round($client->get('rating'),2);
            $idx = ($client->get('rating')) ?
                $this->padIndex($rating,'1') * 100:
                $this->padIndex('');
            $idx2 = ($client->get('rvotes')) ?
                $this->padIndex($client->get('rvotes'),'1'):
                $this->padIndex('');

            $idx3 = ($this->getOpt('view')=='map')?
                $ordering:
                strtolower($client->get('title')) . $ordering;
            $idx = $idx .'|'.$idx2.'|'.$idx3 ;
            break;
            case 'votes':
            $votes = $client->get('rvotes');
            $idx = ($client->get('rvotes')) ?
                $this->padIndex($votes,'1'):
                $this->padIndex('');
            $rating = round($client->get('rating'), 2);
            $idx2 =  ($client->get('rating')) ?
                $this->padIndex($rating,'1') * 100:
                $this->padIndex('');
            $idx3 = ($this->getOpt('view')=='map')?
                $ordering:
                strtolower($client->get('title')) . $ordering;
            $idx = $idx.'|'.$idx2.'|'.$idx3 ;
            break;
            default:
            $idx = $this->padIndex($client->get('id'));
            break;

            }
            return '-'.$idx.'-';

        }

        function padIndex ($idx, $subt='0', $padlen='8', $padchar='0') {
          $cnt = strlen($idx);
          $ldif = $padlen - "$cnt";
          $pad = '';

          while ($ldif > '0'){
            if ($ldif == '1'){
              $pad = '9' . $pad;
            } else {
              $pad = $padchar . $pad;
            }
            $ldif = $ldif - 1;
          }
            $end = '';
            while ($cnt > 0){
              $end = $padchar . $end;
              $cnt = $cnt - '1';
            }
            $totalpad = $pad . $end;
            $newidx = ($subt == '0') ? $pad . $idx: ($totalpad - $idx);
            return $newidx;
        }

        function makeArray ($data){
          if (is_array($data)) return $data;
          if (strpos($data, ',')){
            $oldarr = explode(',', $data);
                $cnt = 1;
                foreach ($oldarr as $key => $var){
                  $tvar = trim($var);
                  if ($tvar != '') {
                    $arr[$cnt] = $tvar;
                    $cnt = $cnt + 1;
                  }
                }
          } elseif (is_string($data)){
            $arr['1'] = $data;
          }
          return $arr;
        }

        function getPriority ($id, $SMtype, $default='!none!') {
            $newid = '';
            if (is_array($this->_options->priority->$SMtype)){
            $idx = array_flip(array_reverse ($this->_options->priority->$SMtype));}
            if (isset($idx[$id])){
                $newid = '!!priority!' . ($idx[$id] + 1);
            } else {
                $newid = ($default == '!none!') ? $id: $default;
            }
            return $newid;
        }

    function samMenu(){
      global $my;
      $absurl = $GLOBALS['mosConfig_live_site'] . "/index.php";
        $showmenu = $this->getOpt('showmenu');
        $showsearch = (($this->getOpt('showsearch') == '1') or ($this->getOpt('active_search') == '1'))?'1':'0';
        $showboth = (($showmenu == '1') and ($showsearch == '1'))? '1':'0';
        $quit = (($showmenu == '1') or ($showsearch == '1'))?FALSE:TRUE;
        if ($quit){return;}
        $sort = $this->getOpt('sort');
        $view = $this->getOpt('view');
        $desc = $this->getOpt('desc');
        $smode = $this->getOpt('search_mode');
        $option = "\n<input type='hidden' name='option' value='com_samsitemap' />";
        $itemid = ($this->getOpt('Itemid') != '')? "\n<input type='hidden' "
               . "name='Itemid' value='" . $this->getOpt('Itemid') . "' />": '';
        $access = ((isset($_GET['access'])) and ($my->gid == '2') and ($my->usertype == 'Super Administrator'))?
                "\n<input type='hidden' name='access' value='".intval($_GET['access'])."' />":
                '';
        $configid = (isset($_GET['configid']))?
                "\n<input type='hidden' name='configid' value='".intval($_GET['configid'])."' />":
                '';
        $commons = $option.$itemid.$access.$configid;
        $borderbottom = ($showboth == '1')? "border-bottom:solid 1px;":'';



      $mhead = "\n<div style='position:relative;float:right;'>\n<table border='0' cellspacing='0' cellpadding='0'>\n<tr>\n<td>";
      $startmenu = "\n<form name='sitemapoptions'"
                ."action='" . $absurl . "' method='get' style='padding:0px;margin:0px;border:0px'>"
               . "\n<table style='padding:0px;margin:0px;$borderbottom'$borderbottom border='0' cellspacing='0' cellpadding='0'>"
               . "\n<tr>"
               . "\n<td style='padding:5px 5px 5px 5px;text-align:left'>".$commons;

      $mview =   ($this->getOpt('showview') != '0')?
                "\n ".$this->getLang('label_view')." <select name='view' "
               . "class='inputbox' style='padding:0px;margin:0px'>"
               . "\n<option value='map'"
               . (($view =='map')? " selected='selected'" : "") . ">"
               . $this->getLang('option_view_tree')."</option>"
               . "\n<option value='list'"
               . (($view =='list')? " selected='selected'" : "") . ">"
               . $this->getLang('option_view_list')."</option>"
               . "\n</select>":'';

     $msort =  ($this->getOpt('showsort') != '0')?
               "\n ".$this->getLang('label_sort')." <select name='sort'"
               . " class='inputbox' style='padding:0px;margin:0px'>"
               . "\n<option value='normal'"
               . (($sort =='normal')? " selected='selected'" : "") . ">"
               . $this->getLang('option_sort_normal')."</option>"
               . "\n<option value='hits'"
               . (($sort =='hits')? " selected='selected'" : "") . ">"
               . $this->getLang('option_sort_hits')."</option>":'';

     $mrating = (($this->getOpt('showsort') != '0') and ($this->getOpt('ratingsort') != '0'))?
               "\n<option value='rating'"
               . (($sort =='rating')? " selected='selected'" : "") . ">"
               . $this->getLang('option_sort_rating')."</option>"
               ."\n<option value='votes'"
               . (($sort =='votes')? " selected='selected'" : "") . ">"
               . $this->getLang('option_sort_votes')."</option>": '';

     $msort2 =  ($this->getOpt('showsort') != '0')?"\n</select>":'';

     $mdesc =  ($this->getOpt('showdesc') != '0')?
               "\n ".$this->getLang('label_desc')." <select name='desc'"
               . " class='inputbox' style='padding:0px;margin:0px'>"
               . "\n<option value='1'"
               . (($desc == '1')? " selected='selected'" : "") . ">"
               . $this->getLang('option_desc_show')."</option>"
               . "\n<option value='0'"
               . (($desc == '0')? " selected='selected'" : "") . ">"
               . $this->getLang('option_desc_hide')."</option>"
               . "\n</select>":'';

     $mtail =  "\n<input type='submit' name='submit' class='button' value='"
                .$this->getLang('label_submit')."' />";

     $mtail2 = "\n</td>\n</tr>\n</table>"
               . "\n</form>\n</td>\n</tr>";

     $menu = ($showmenu == '1')?$startmenu.$mview.$msort.$mrating.$msort2.$mdesc.$mtail.$mtail2:'';

     $cancelform ="<td align='center'><form name='cancelsearch' action='index.php' method='get'>"
                .$commons
                ."\n<input type='submit' name='submit' value='".$this->getLang('label_cancel')
                ."' class='button'>"
                ."\n</form>"
                ."</td></tr>";
     $cancel =($showmenu == '1')?'':$cancelform;

     $search = (($this->getOpt('showsearch') == '1') or ($this->getOpt('active_search') == '1'))?
                "\n<tr>\n<td>\n<form name='sitemapsearch' action='" . $absurl
                . "' method='get' style='padding:0px;margin:0px;border:0px'>"
                ."\n<table style='padding:0px;border:0px;margin:0px' cellspacing='0' cellpadding='0'>\n<tr>"
                ."\n<td style='padding:5px 5px 5px 5px;text-align:justify'>"
                ."\n".$commons
                ."\n <input type='text' name='search' value=\""
                .$this->getOpt('search_string')
                ."\" style='padding:0px;margin:0px' class='inputbox' />"
                ."\n &nbsp;".$this->getLang('label_search_find')
                ."&nbsp;<input type='radio' name='smode' value='0' "
                .$this->checkedtest($smode, '0')." />"
                .$this->getLang('label_search_sm0')
                ."\n <input type='radio' name='smode' value='1' "
                .$this->checkedtest($smode, '1')." />"
                .$this->getLang('label_search_sm1')
                ."\n <input type='radio' name='smode' value='2' "
                .$this->checkedtest($smode, '2')." />"
                .$this->getLang('label_search_sm2')
                ."\n &nbsp;<input type='submit' name='submit' value='"
                .$this->getLang('label_search_submit')."' class='button'/>"
                ."\n".(($this->getOpt('sr_sho_wc')=='1')?"<br /><span class='small'>".$this->getLang('label_search_wild')."</span>":'')
                ."\n <input type='hidden' name='view' value='search'/>"
                ."\n <input type='hidden' name='sort' value='search'/>"
                ."\n </td>\n</tr>\n</table>\n</form>\n</td>\n</tr>"
                .$cancel
                :'';

     $mtail3 = "\n</table>"
                ."\n</div>"
                ."\n";
        $menu = $mhead.$menu.$search.$mtail3;
      return $menu;
    }

    function selecttest ($option, $val, $def=false){
        if ($option == $val){
          return "selected='selected'";
        } else if (($def == $option) and ($val = '')) {
          return "selected='selected'";
        } else {
          return '';
        }
    }

    function checkedtest ($option, $val, $def=false){
        if ($option == $val){
          return "checked='checked'";
        } else if (($def == $option) and ($val = '')) {
          return "checked='checked'";
        } else {
          return '';
        }
    }

    function trimItem($val,$spos=0){
        $val_len = ($this->getOpt('active_search')!='1')?
            $this->getOpt('desc_len'):$this->getOpt('sr_desc_len');
        $val_size = strlen($val);
        if ($val_size < $val_len){return $val;}
        $minus = 25; // characters to look backward

        $spos = ($spos > $minus)? $spos:0;
        $val_potential = $val_size - ($spos-$minus);
        if ($val_potential < $val_len){
          $spos = $spos - ($val_len - $val_potential);
          $spos = ($spos < 0)? 0: $spos;
          $val_potential = $val_size - ($spos-$minus);
        }
        if (($spos != 0) and ($val_potential >= $val_len)){
          $spos_minus = $spos-$minus;
          $minus_area = substr($val,$spos_minus,$minus);
          switch (TRUE){
            case (($minus_area) and ($mpos = strrpos($minus_area,'.'))):
                $spos = $spos_minus + $mpos + 1;
            break;
            case (($minus_area) and ($mpos = strpos($minus_area,' '))):
                $spos = $spos_minus + $mpos + 1;
            break;
            default:
            break;
          }
        }
        $plus = 15; //characters to look forward
        $val_plus = $val_len + $plus;
        $val_size = $val_size - $spos;
        $val_plus_end = $spos+$val_plus;
        $plus_area = substr($val,$spos+$val_len,15);
            switch (TRUE){
                case (($plus_area) and ($pos = strpos($plus_area,'.'))):
                    $val = substr($val,$spos,$val_len+$pos);
                break;
                case (($plus_area) and ($pos = strpos($plus_area, ' ')));
                    $val = substr($val,$spos,$val_len+$pos);
                break;
                default:
                    $val = substr($val,$spos,$val_len);
                break;
          }
      return $val;
    }
}


class samValtracker {
  var $_index = NULL;

  function add ($idxname, $val){
    $index =& $this->_index;
    $idxname = $this->r($idxname);
    if (!isset($index[$idxname])) $index[$idxname] = NULL;
    if ($val == 'all'){
      unset ($index[$idxname]);
      $index[$idxname] = 'all';
    } elseif ($index[$idxname] != 'all'){
      $index[$idxname][$val] = $val;
    }
  }

  function r($idxn){
    return str_replace('#__', $GLOBALS['samSMref']->getOpt('table_prefix'),$idxn);
  }

  function get ($idxname){
    $index =& $this->_index;
    $idxname = $this->r($idxname);
    if (isset($index[$idxname])){
      return $index[$idxname];
    } else {
      return false;
    }
  }

    function addvals ($idxname, $data){
      $idxname = $this->r($idxname);
      if (strpos($data, ',')){
        $newdata = explode(',', $data);
      } else {
        $newdata[] = $data;
      }
        foreach ($newdata as $key => $val){
          $tval = trim($val);
          if ($tval != '') {
           $this->add ($idxname, $tval);
          }
        }
      }


}

class samDBinterface {
        var $_db = NULL;
        var $_sql = NULL;
//        var $_and = NULL;
//        var $_table = NULL;
//        var $_leftjoin = NULL;
//        var $_where = NULL;
//        var $_and = NULL;
//        var $_or = NULL;
//        var $_fieldlist = NULL;

        function samDBinterface (&$db){
          $this->_db =& $db;
          $this->clearall();
          $this->_table_prefix = $this->_db->_table_prefix;
        }

        function clearall(){
            $this->_sql->_and = NULL;
            $this->_sql->_table = NULL;
            $this->_sql->_leftjoin = NULL;
            $this->_sql->_where = NULL;
            $this->_sql->_and = NULL;
            $this->_sql->_or = NULL;
            $this->_sql->_fieldlist = NULL;// = '0';
        }

        function sqlandor ($arr, $fname='', $andor, $tblalias, $oprtr='='){
          $andor = (strtolower($andor) == 'and')? 'AND' : 'OR';
          $tbl = ($tblalias == '')? '' : $tblalias.'.';
          if ((is_array($arr)) and ($fname != '')) {
            $ret = "(".$tbl.$fname.$oprtr."'".join("') $andor (".$tbl.$fname.$oprtr."'", $arr)."')";
          } elseif ((is_array($arr)) and ($fname == '')) {
            $ret = "(".join(") $andor (", $arr).")";
          } elseif ((is_string($arr) or is_int($arr)) and ($fname != '') and ($arr != '')){
            $ret = "(".$tbl.$fname.$oprtr."'".$arr."')";
          } else {
            $ret = FALSE;
          }
          return $ret;
        }

        function sqland ($arr, $fname=''){
          if ((is_string($arr)) and ($fname != '')) {
            $and = $fname."='$arr'";
          } elseif ((is_array($arr))){
          }
        }

        function setQuery ($sql) {
          $this->_db->setQuery($sql);
        }

        function query (){
          $this->_cursor = $this->_db->query();
          return $this->_cursor;
        }

        function autoquery(){
          $andcnt = $this->nextkey($this->_sql->_and);
          if ($this->_sql->_or != NULL){
            $this->_sql->_and->$andcnt = $this->sqlandor(get_object_vars($this->_sql->_or), '', 'OR','');
            }
          $fields = ($this->_sql->_fieldlist != NULL)?
            join(',', get_object_vars($this->_sql->_fieldlist)):
            '';
          $leftjoin = ($this->_sql->_leftjoin != NULL)?
            "\n LEFTJOIN ".join("\nLEFTJOIN ",get_object_vars($this->_sql->_leftjoin)):
            '';
          $tables = $this->_sql->_table.$leftjoin;

          $where = ($this->_sql->_and != NULL)?
            'WHERE '.join(' AND ', get_object_vars($this->_sql->_and)):
            '';
          $this->clearall();
          $sql = "SELECT $fields FROM $tables $where";
          $this->setQuery($sql);
          $this->_cursor = $this->query();
          return $this->_cursor;
        }

        function &loadObjectList ($id){
          $this->_objectlist = $this->_db->loadObjectList($id);
          return $this->_objectlist;
        }

        function &autoLoadObjectList ($grpid) {
          $andcnt = $this->nextkey($this->_sql->_and);
          if ($this->_sql->_or != NULL){
            $this->_sql->_and->$andcnt = $this->sqlandor(get_object_vars($this->_sql->_or), '', 'OR','');
            }
          $fields = ($this->_sql->_fieldlist != NULL)?
            join(',', get_object_vars($this->_sql->_fieldlist)):
            '';
          $leftjoin = ($this->_sql->_leftjoin != NULL)?
            "\n LEFTJOIN ".join("\nLEFTJOIN ",get_object_vars($this->_sql->_leftjoin)):
            '';
          $tables = $this->_sql->_table.$leftjoin;

          $where = ($this->_sql->_and != NULL)?
            'WHERE '.join(' AND ', get_object_vars($this->_sql->_and)):
            '';
          $this->clearall();
          $sql = "SELECT $fields FROM $tables $where";
          $this->setQuery($sql);
          $ret =& $this->loadObjectList($grpid);
          return $ret;

        }

        function getNextRow (){
         $ret = mysql_fetch_assoc($this->_cursor);
         if (!$ret){
           mysql_free_result ($this->_cursor);
           return FALSE;
         } else {
           return $ret;
         }

        }

        function field ($name, $label, $tblalias=''){
          $alias = ($label == '') ? '' :" AS $label";
          $tbl = ($tblalias == '') ? '' : $tblalias.'.';
          return $tbl.$name.$alias;

        }

        function addsql ($type, $vals, $label='', $tblalias='',$oprtr='='){
            if ($vals == ''){return FALSE;}

          switch ($type){
            case 'table':
            $alias = ($label == '')? '': " AS $label";
            $this->_sql->_table = $vals.$alias;
            break;
            case 'leftjoin':
            $alias = ($tblalias == '')? '' : " AS $label";
            $join = ($tblalias == '')? '' : " ON ($tblalias)";
            $cnt = $this->nextkey($this->_sql->_leftjoin);
            $this->_sql->_leftjoin->$cnt = $vals.$alias.$join;
            break;
            case 'andor':
            $cnt = $this->nextkey($this->_sql->_and);
            $this->_sql->_and->$cnt = '('.$this->sqlandor($vals, $label, 'or', $tblalias,$oprtr).')';
            break;
            case 'or':
            $cnt = $this->nextkey($this->_sql->_or);

            $this->_sql->_or->$cnt = $this->sqlandor($vals, $label,'or', $tblalias,$oprtr);
            break;
            case 'and':
            $cnt = $this->nextkey($this->_sql->_and);
            $this->_sql->_and->$cnt = $this->sqlandor($vals, $label, 'and', $tblalias,$oprtr);
            break;
            case 'field':
            if (is_array($vals)){
              $cnt = $this->nextkey($this->_sql->_fieldlist);
              $inclabel = (is_array($label))? 1:0;
              foreach ($vals as $key=>$val){
                $labl = ($inclabel == 0)? '': $label[$key];
                $this->_sql->_fieldlist->$cnt = $this->field ($val, $labl, $tblalias);
                $cnt = $cnt + 1;
              }
            } elseif (is_string($vals)) {
            $cnt = $this->nextkey($this->sql->_fieldlist);

            $this->_sql->_fieldlist->$cnt = $this->field($vals, $label, $tblalias);

            }
            break;
            case 'like':
            $cnt = $this->nextkey($this->sql->_and);
            if (is_array($vals)) {
              $this->sql->_and->$cnt = $label.' LIKE '.$this->sqlandor($vals, $label,'or',$tblalias);
            } else {
              $this->_sql->_and->$cnt = $label.' LIKE ('.$label."='".$vals."')";
            }
            break;
            default:
            break;
          }
        }

    function nextkey(&$val){
      $cnt = ($val == NULL)? 0: count(get_object_vars($val));
      return $cnt;
    }
}

// Will use $data->SMtype and $data->id to create index entry
//fails quietly if index already exists (will not overwrite - returns false)
class samSMIndex {
      var $_SMtype = null;
      var $_index = null;
      var $_titleindex = null;
      var $_false = FALSE;

      function samSMIndex ($idxName) {
        global $samSMref;
        $this->_idxName = $idxName;
        $this->_table_prefix = $samSMref->getOpt('table_prefix');
      }

      function addIndex ($idxName){
        $idxName = $this->r($idxName);
        if (!isset($this->_index->$idxName)){
            $this->_index->$idxName = '';
        }
      }

      function r($idxn){
        $idxn = str_replace('#__',$this->_table_prefix,$idxn);
        return $idxn;
      }

      function &addItem($idxName, $id, $data){
        $samSMref =& $GLOBALS['samSMref'];
        $idxName = $this->r($idxName);
        if (!isset($this->_index->$idxName)){$this->addIndex($idxName);}
        if (!isset ($this->_index->$idxName->$id)) {
           $this->_index->$idxName->$id =& new samSMblock($data);
           if (isset($data->title) and ($data->title != '')){
                $title = $data->title;
//                if (!isset($this->_index->$idxName->_titleindex)) $this->_index->$idxName->_titleindex = '';
                $this->_index->$idxName->_titleindex->$title = $id;
                if (isset($data->special)){
                    $special = $data->special;
                    $this->_index->$idxName->_specialindex->$special = $id;
                }
                }
        } else {
          $samSMref->adminalert("Duplicate Index request for id $idxName:$id titled "
            ."$data->title .  Index Entry Aborted.");
          return $this->_false;
        }
        $ret =& $this->_index->$idxName->$id;
        return $ret;
      }

    function &Itemexists($idxName, $id){
          $samSMref =& $GLOBALS['samSMref'];
          $idxName = $this->r($idxName);
          if (isset($this->_index->$idxName->$id)){
            return $this->_index->$idxName->$id;
          } else {
            return $this->_false;
          }
    }

    function getallids ($idxname){
      $idxname = $this->r($idxname);
      $ids = null;
      if (isset($this->_index->$idxname) and (count($this->_index->$idxname) > 0)){
          foreach ($this->_index->$idxname as $key => $val){
            if (($key == '_titleindex') or ($key == '_specialindex')) continue;
            if ($val->_SMtype == '#__sections'){
              $ids[] = $val->_id;
            } elseif (($val->_SMtype == '#__categories') and (is_numeric($val->_section))){
              $ids[] = $val->_id;
            } elseif ($val->_SMtype == '#__template_positions'){
              $ids[] = $val->_id;
            }
          }
          return $ids;
      } else {
        return FALSE;
      }
    }

    function addchild ($idxName, $id, $childSMtype, $childid){
      global $samSMref;
      $idxName = $this->r($idxName);
      $childSMtype = $this->r($childSMtype);
      if (isset($this->_index->$idxName->$id)) {
        $this->_index->$idxName->$id->addchild ($childSMtype, $childid);

        } else {
          return FALSE;
      }
    }

    function &getref ($idxName, $id) {
      $idxName = $this->r($idxName);
      if (isset($this->_index->$idxName->$id)){
        return $this->_index->$idxName->$id;
      } else {
        return $this->_false;
      }
    }

    function getIDbyTitle($idxName,$title){
      $idxName = $this->r($idxName);
      if (isset($this->_index->$idxName->_titleindex->$title)){
        $id = $this->_index->$idxName->_titleindex->$title;
        return $id;
      } else {
        return FALSE;
      }
    }

    function getIDbySpecial ($idxName,$title) {
      $idxName = $this->r($idxName);
      if ((isset($this->_index->$idxName->_specialindex)) and (
            isset($this->_index->$idxName->_specialindex->$title))){
        $id = $this->_index->$idxName->_specialindex->$title;
        return $id;
      } else {
        return FALSE;
      }
    }


}


class samSMblock {
        var $_id;
        var $_title;
        var $_mosItemid = '0';
        var $_rendered = '0';
        var $_render = '1';
        var $_blocktype = 'item';
        var $_children = '';
        var $_childqty = '0';
        var $_search_hits = '0';
        var $_title_hits = '0';
        var $_desc_hits = '0';
        var $_search_rank = '0';

        function samSMblock (&$data) {
            $samSMref =& $GLOBALS['samSMref'];
                $this->_id = $data->id;
                $this->_title = (isset($data->title))? $data->title: '';
                if (($samSMref->getOpt('active_search') == '1') and ($this->_title != '')){
                  $this->_title_count = strlen($data->title);
                  $this->_title = $samSMref->searchitem($this->_title, $this, 'title');
                }
                $this->_parent = (isset($data->parent)) ? $data->parent : '0';
                $this->_SMtype = (isset($data->SMtype))? $data->SMtype: '';
                $this->_ordering = (isset($data->ordering)) ? $data->ordering : $data->id;
                $this->_access = (isset($data->access))? $data->access: '2';
                $this->_url = (isset($data->url)) ? $data->url : FALSE;
                $usergid = $samSMref->getOpt('usergid');
                $this->_linktype = (isset($data->linktype))? $data->linktype : '';
                if (isset($data->blocktype)) $this->_blocktype = $data->blocktype;
                if (isset($data->mosMenuType))$this->_mosMenuType = $data->mosMenuType;
                if (isset($data->render)) $this->_render = $data->render;
                if (isset($data->mosItemid)) $this->_mosItemid = $data->mosItemid;
                if (isset($data->hits)) $this->_hits = $data->hits;
                if (isset($data->rating)) $this->_rating = $data->rating;
                if (isset($data->rvotes)) $this->_rvotes = $data->rvotes;
                if (isset($data->aquire)) $this->_aquire = $data->aquire;
                if ((isset($data->desc)) and ($samSMref->getOpt('desc') == '1') and ($data->desc != '')){
                  //Gets rid of any mambots
                  $newdesc = strip_tags($data->desc);
                  $newdesc = preg_replace ("%\{[^>]{0,100}\}%mis",'',$newdesc);
                  //Trims description to option length
                  $newdesc = substr($newdesc,0,$samSMref->getOpt('desc_len'));
                  $this->_desc = $newdesc;
                }
        }

        function addchild ($SMtype, $id) {
          global $samSMref;
              if ($id == 'all') {
                $idx = $SMtype . "." . $id;
                $this->_harvestall->$idx = array('id'=>$id,'SMtype'=>$SMtype);
              } elseif ((bool)strpos($id, ',') != FALSE){
                  $ids = explode(',', $id);
                  foreach ($ids as $key => $val){
                    $idx = $SMtype . "." . $val;
                    if (!isset($this->_blockchild->$idx)){
                      $this->_children->$idx = array('id'=>$val,'SMtype'=>$SMtype);
                      $this->_childqty = $this->_childqty + '1';
                    }
                 }
              } else {
                $idx = $SMtype . "." . $id;
                if (!isset($this->_blockchild->$idx)){
                  $this->_children->$idx = array('id'=>$id,'SMtype'=>$SMtype);
                  $this->_childqty = $this->_childqty + '1';
                }
              }
              if ($this->_blocktype == 'item') $this->_blocktype = 'container';
              $samSMref->_valtrack->add($SMtype, $id);
        }

        function testv ($val){
            $val = '_'.$val;
          $ret = (isset($this->$val))? TRUE:FALSE;
          return $ret;
        }
        function blockchild ($SMtype, $id) {
            $idx = $SMtype . "." . $id;
          if (@is_array($this->_children->$idx)){
            unset($this->_children->$idx);
            $this->_childqty = $this->_childqty - '1';
          }
          $this->_blockchild->$idx = $idx;

        }

        function renderChildren ($pid='none', $itemid='0') {
                $samSMref =& $GLOBALS['samSMref'];
                if (isset($this->_harvestall) and (count($this->_harvestall) > 0)) {
                  $samSMref->harvestall($this);
                }
                $samSMref->renderclientChildren($this, $pid, $itemid);
        }

        function render ($pid='none', $itemid='0', $skipself='0') {
          $samSMref =& $GLOBALS['samSMref'];
          $samSMref->renderclient($this, $pid, $itemid, $skipself);
        }

        // returns internal variable ie: string get('internal_var_name')
        function get ($var) {
          $newvar = "_" . $var;
          $ret = (isset($this->$newvar)) ? $this->$newvar : FALSE;
          return $ret;
        }

        function set ($varname, $val) {
          $samSMref =& $GLOBALS['samSMref'];
          $search = $samSMref->getOpt('active_search');
          $newvar = "_" . $varname;
          switch ($varname){
            case 'desc':
             if (($samSMref->getOpt('desc') == '1') or ($search == '1')) {
                  $pattern ='%(<(/p|br)([\s]){0,1}(/){0,1}>)|(\{[^>]{0,100}\})%mis';
                  //preg_replace strips {mosbot}s, <br />, and </p> and replaces with a space
                  $val = strip_tags(preg_replace ($pattern, ' ',$val));
//                  $val = preg_replace ("%\{[^>]{0,100}\}%mis",'',$val);
//                  $val = preg_replace ("%\.%mis", ' .',$val);
                  if ($search == '1'){
                    $this->set('desc_count', strlen($val));
                    $val = $samSMref->searchitem($val, $this, 'desc');
                  } else {
                        $val = $samSMref->trimItem($val);
                    }
             } else {
                    $val = NULL;
             }
             if ($val == '') $val = NULL;
            break;
            default:
            break;
          }

          if ($val != NULL)$this->$newvar = $val;
        }

        function setaquire ($SMtype, $id){
          $this->_aquire = $SMtype.':'.$id;
        }

        function aquire () {
          if (isset($this->_aquire)) {
                $samSMref =& $GLOBALS['samSMref'];
                $aquire = explode(':', $this->_aquire);
                $SMtype = $aquire[0];
                $id = $aquire[1];
                $ref =&  $samSMref->Index->Itemexists($SMtype, $id);
              if ($ref != FALSE) {
                $this->_desc = (isset($ref->_desc)) ? $ref->_desc : @$this->_desc;
                $this->_hits = (isset($ref->_hits)) ? $ref->_hits : @$this->_hits;
                $this->_rating = (isset($ref->_rating)) ? $ref->_rating : @$this->rating;
                  if ($samSMref->getOpt('active_search') == '1'){
                    if (isset($ref->_search_hits)) $this->_search_hits=$ref->_search_hits;
                    if (isset($ref->_title_hits)) $this->_title_hits=$ref->_title_hits;
                    if (isset($ref->_desc_hits)) $this->_desc_hits=$ref->_desc_hits;
                    if (isset($ref->_title_termhits)) $this->_title_termhits=$ref->_title_termhits;
                    if (isset($ref->_desc_termhits)) $this->_desc_termhits=$ref->_desc_termhits;
                  }
              }
          }
        }

}

class samSMroot extends samSMblock {
  var $_id = '0';
  var $_title = '';
  var $_render = '';
  var $_url = '';
  var $_ordering = '0';

}
?>
