<?php
/**
* @version 0.2.0
* @author Daniel Ecer
* @package exmenu_0.2.0
* @copyright (C) 2005 Daniel Ecer (de.siteof.de)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Notice: some parts are based on the default mainmenu module.
* Beside this it were havily redesigned to separate module from view (though no template engine is used but each view could of course). 
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// requested module allows to include other modules without immediately displaying them
if (!isset($requestedModule)) {
	$requestedModule	= 'exmenu';
}

if (!defined( '_EXTENDED_MENU_INCLUDED_' )) {
	/** ensure that functions are declared only once */
	define( '_EXTENDED_MENU_INCLUDED_', 1 );
	
	
	define( 'EXTENDED_MENU_ACCESS_KEYS_NONE', 0 );
	define( 'EXTENDED_MENU_ACCESS_KEYS_PARSE', 1 );
	define( 'EXTENDED_MENU_ACCESS_KEYS_STRIP', 2 );
	define( 'EXTENDED_MENU_ACCESS_KEYS_STRIP_MARKUP', 3 );
	define( 'EXTENDED_MENU_ACCESS_KEYS_STRIP_AND_EMPHASE', 4 );

	if (!function_exists('ampReplace')) {
		function ampReplace( $text ) {
			$text = str_replace( '&#', '*-*', $text );
			$text = str_replace( '&', '&amp;', $text );
			$text = str_replace( '&amp;amp;', '&amp;', $text );
			$text = str_replace( '*-*', '&#', $text );
		
			return $text;
		}
	}
	
	/**
	 * Abstract class for nodes... may be used for other kind of nodes than just menu nodes.
	 */
	class AbstractNode {
		var $childList = array();
		var $hasChildren = FALSE;
		
		function addChildNode(&$child) {
			$result	= count($this->childList);
			$this->childList[]	=& $child;
			$this->hasChildren	= TRUE;
			return $result;
		}
		
		function &getChildNodeList() {
			return $this->childList;
		}
		
		function hasChildren() {
			return $this->hasChildren;
		}
	}
	
	/**
	 * Class for menu nodes.
	 */
	class MenuNode extends AbstractNode {
		var $active		= FALSE;
		var $expanded	= FALSE;
		var $accessKey	= '';

		function isCurrent() {
			global $Itemid;
			return ($Itemid > 0) && ($this->id == $Itemid);
		}
		function isActive() {
			return $this->active;
		}
		function isExpanded() {
			return $this->expanded;
		}
		function setExpanded($expanded = TRUE) {
			$this->expanded	= $expanded;
		}
		function expand($level = 1) {
			if ($level < 1) {
				return FALSE;
			}
			$this->setExpanded(TRUE);
			if ($level > 1) {
				$children	=& $this->getChildNodeList();
				foreach(array_keys($children) as $k) {
					$menuNode	=& $children[$k];
					$menuNode->expand($level - 1);
				}
			}
		}
	}
	
	/**
	 * Loads a menu but does not render it.
	 * (Formaly known as MenuManager)
	 * 
	 * @since 0.2.0
	 */
	class MenuLoader {
		
		var $menutype			= '';
		var $activeMenuId		= -1;
		var $openActiveOnly		= FALSE;
		var $maxDepth			= 0;
		var $minExpand			= 0;
		var $parseAccessKey		= 0;
		var $cacheEnabled		= TRUE;
		var $activeIds;
		var $menuNodeByIdMap	= array();
		var $menuNodeList;

		/**
		 * returns a quoted string you could use inside a query
		 * (this is a function provided for compatibility with Mambo 4.5.1)
		 * @see database::quote
		 * @return string
		 */
		function dbQuote(&$database, $text) {
			if (method_exists($database, 'quote')) {
				return $database->quote($text);
			} else {
				return '\''.mysql_escape_string($text).'\'';
			}
		}

		function load() {
			global $database, $my, $mosConfig_shownoauth;
			$menutype		= $this->menutype;
			$activeMenuId	= $this->activeMenuId;
			$openActiveOnly	= $this->openActiveOnly;
			$maxDepth		= $this->maxDepth;
			$minExpand		= $this->minExpand;

			$sql = 'SELECT m.* FROM #__menu AS m'.
				' WHERE menutype='.$this->dbQuote($database, $menutype).' AND published=1';
			if (!$mosConfig_shownoauth) {
				$sql	.= ' AND access <= '.$my->gid;
			}
			if ($maxDepth <= 0) {
				$sql	.= ' AND parent=0';
			}
			$sql	.= ' ORDER BY ordering';
			$sqlKey	= $sql;
			$cacheVariableName	= '_EXTENDED_MENU_CACHE';
			$rows	= NULL;
			if ($this->cacheEnabled) {
				if (isset($GLOBALS[$cacheVariableName])) {
					if (isset($GLOBALS[$cacheVariableName][$sqlKey])) {
						$rows		= $GLOBALS[$cacheVariableName][$sqlKey];
					}
				} else {
					$GLOBALS[$cacheVariableName]	= array();
				}
			}
			if (is_null($rows)) {
				$database->setQuery($sql);
				$rows	= $database->loadRowList('id');
				if ($this->cacheEnabled) {
					if (isset($GLOBALS[$cacheVariableName][$sqlKey])) {
						// the cache may be useful for splitted menus
						$GLOBALS[$cacheVariableName][$sqlKey]	= $rows;
					}
				}
			}
			$menuNodeByIdMap	= array();
			$rootMenuNodeList	= array();
			$activeIds			= array();
			$parseAccessKeys	= $this->parseAccessKey;
			if (isset($rows[$activeMenuId])) {
				$id	= $activeMenuId;
				while(($id > 0) && (isset($rows[$id]))) {
					$activeRow	=& $rows[$id];
					$activeRow['active']	= TRUE;	// we assume that we do not have a field called 'active'
					$activeIds[]			= $id;
					$id	= $activeRow['parent'];
				}
			}
			foreach(array_keys($rows) as $id) {
				$row			=& $rows[$id];
				$parentMenuId	= $row['parent'];
				if (($parentMenuId > 0) && ($minExpand < 2) && ($openActiveOnly) && (!in_array($parentMenuId, $activeIds))) {
					if (isset($menuNodeByIdMap[$parentMenuId])) {
						$menuNodeByIdMap[$parentMenuId]->hasChildren	= TRUE;
					} else if (isset($rows[$parentMenuId])) {
						$rows[$parentMenuId]['hasChildren']	= TRUE;	// remember that we have children (even though not displaying them)
					}
					continue;	// for optimization we skip this node
				}
				$menuNode	=& new MenuNode();
				foreach($row as $k => $field) {
					$menuNode->$k = $field;
				}
				if (($menuNode->active) || (!$openActiveOnly)) {
					$menuNode->expanded	= TRUE;	// active menu items are expanded
				}
				if ($parseAccessKeys > 0) {
					$menuNode->accessKey	= $this->parseAccessKey($menuNode->name, $parseAccessKeys);
				}
				if ((isset($row['hasChildren'])) && (!$menuNode->hasChildren)) {
					$menuNode->hasChildren	= TRUE;
				}
				$menuNodeByIdMap[$menuNode->id]	=& $menuNode;
				if ($parentMenuId == 0) {
					$rootMenuNodeList[]	=& $menuNode;
				}
			}
			if ($maxDepth > 0) {
				// add nodes in second pass (now we have objects for all)
				foreach(array_keys($menuNodeByIdMap) as $k) {
					$menuNode	=& $menuNodeByIdMap[$k];
					if (($menuNode->parent > 0) && (isset($menuNodeByIdMap[$menuNode->parent]))) {
						$parentNode	=& $menuNodeByIdMap[$menuNode->parent];
						$parentNode->addChildNode($menuNode);
					}
				}
			}
			if ($minExpand >= 2) {
				foreach(array_keys($rootMenuNodeList) as $k) {
					$menuNode	=& $rootMenuNodeList[$k];
					$menuNode->expand($minExpand - 1);
				}
			}
			$this->menuNodeList		=& $rootMenuNodeList;
			$this->menuNodeByIdMap	=& $menuNodeByIdMap;
			$this->activeIds		=& $activeIds;
			return TRUE;
		}
		
		/**
		 * Parses the name parameter for access keys and uses the parseAccessKeys setting. The name parameter may be changed while the access key is returned.
		 */
		function parseAccessKey(&$name, $parseAccessKeys) {
			$accessKey	= '';
			if ($parseAccessKeys > 0) {
				$i	= strpos($name, '[');
				if ($i !== FALSE) {
					$j	= strpos($name, ']', $i + 1);
					if ($j !== FALSE) {
						$accessKey	= strtolower(trim(substr($name, $i + 1, $j - $i - 1)));
						if (($accessKey != '') && (substr($accessKey, 0, 1) == '-')) {
							$accessKey			= substr($accessKey, 1, strlen($accessKey) - 1);
							$parseAccessKeys	= constant('EXTENDED_MENU_ACCESS_KEYS_STRIP');
						}
						if ($parseAccessKeys == constant('EXTENDED_MENU_ACCESS_KEYS_STRIP')) {
							$name			= substr($name, 0, $i).substr($name, $j + 1, strlen($name) - $j - 1);
						} else if ($parseAccessKeys == constant('EXTENDED_MENU_ACCESS_KEYS_STRIP_MARKUP')) {
							$name			= substr($name, 0, $i).substr($name, $i + 1, $j - $i - 1).substr($name, $j + 1, strlen($name) - $j - 1);
						} else if ($parseAccessKeys == constant('EXTENDED_MENU_ACCESS_KEYS_STRIP_AND_EMPHASE')) {
							$name			= substr($name, 0, $i).'<em>'.substr($name, $i + 1, $j - $i - 1).'</em>'.substr($name, $j + 1, strlen($name) - $j - 1);
						}
					}
				}
			}
			return $accessKey;
		}
		
		function _addHierarchy(&$hierarchy, &$menuNodeList, $depthIndex) {
			if ($depthIndex <= 0) {
				return TRUE;
			}
			$index	= 0;
			foreach(array_keys($menuNodeList) as $k) {
				$menuNode	=& $menuNodeList[$k];
				if (in_array($menuNode->id, $this->activeIds)) {
					$hierarchy[]	= (1+$index);
					if ($depthIndex > 0) {
						$subMenuNodeList	=& $menuNode->getChildNodeList();
						$this->_addHierarchy($hierarchy, $subMenuNodeList, $depthIndex - 1);
					}
					break;
				}
				$index++;
			}
		}
		
		/**
		 * Returns the hierarchy array for the given depth/level.
		 */
		function getHierarchy($depthIndex) {
			$hierarchy	= array();
			$this->_addHierarchy($hierarchy, $this->menuNodeList, $depthIndex);
			return $hierarchy;
		}
	}
	
	/**
	 * Abstract class for all menu nodes.
	 */
	class AbstractMenuView {
		var $classSuffix;
		var $maxDepth			= 10;
		var $openActiveOnly		= TRUE;
		var $menuLevel			= 0;
		var $activeMenuClass	= FALSE;
		var $titleAttribute		= FALSE;
		var $hierarchyBasedIds	= FALSE;
		var $sublevelClasses	= FALSE;
		var $mainlevelClasses	= FALSE;
		var $menuHierarchy		= array();
		var $params;


		function getExtractedHref($html) {
			$s	= 'href="';
			$i	= strpos($html, 'href="');
			if ($i !== FALSE) {
				$i	+= strlen($s);
				$j	= strpos($html, '"', $i);
				if ($j !== FALSE) {
					return substr($html, $i, $j - $i);
				}
			}
			return '';
		}
		
		function getHierarchyString($hierarchy) {
			$result	= implode('_', $hierarchy);
			if ($result == '') {
				$result	= 'root';
			}
			return $result;
		}

		/**
		* Utility function for writing a menu link
		* (modification of the original menu module mosGetMenuLink function)
		*/
		function mosGetMenuLink( $mitem, $level=0, &$params, $itemHierarchy ) {
			global $Itemid, $mosConfig_live_site, $mainframe;

			// alias to use a prefered name without having to change all reference
			$menuNode	=& $mitem;
			
			$txt = '';
	
			switch ($mitem->type) {
				case 'separator':
				case 'component_item_link':
				break;
				case 'content_item_link':
				$temp = split("&task=view&id=", $mitem->link);
				$mitem->link .= '&Itemid='. $mainframe->getItemid($temp[1]);
				break;
				case 'url':
				if ( eregi( 'index.php\?', $mitem->link ) ) {
					if ( !eregi( 'Itemid=', $mitem->link ) ) {
						$mitem->link .= '&Itemid='. $mitem->id;
					}
				}
				break;
				case 'content_typed':
				default:
				$mitem->link .= '&Itemid='. $mitem->id;
				break;
			}
	
			// Active Menu highlighting
			// why reading the request parameter when there is a global variable?
//			$current_itemid = trim( mosGetParam( $_REQUEST, 'Itemid', 0 ) );
			
			$title	= strip_tags($menuNode->name);
			
			// use a more meaningful name than "id": elementParameters
			$elementParameters	= '';
			if (($this->hierarchyBasedIds) && (count($itemHierarchy) > 0)) {
				$elementParameters	.= ' id="menulink_'.$this->getHierarchyString($itemHierarchy).$this->classSuffix.'"';
			} else if ($menuNode->isCurrent()) {
				$elementParameters	.= ' id="active_menu'.$this->classSuffix.'"';
			}
			if ((isset($menuNode->accessKey)) && ($menuNode->accessKey != '')) {
				$elementParameters	.= ' accesskey="'.$menuNode->accessKey.'"';
				$title	.= ' ['.strtoupper($menuNode->accessKey).']';
			}
			
			if ($this->titleAttribute) {
				$elementParameters	.= ' title="'.$title.'"';
			}
	
			$mitem->link = ampReplace( $mitem->link );
	
			if ( strcasecmp( substr( $mitem->link,0,4 ), 'http' ) ) {
				$mitem->link = sefRelToAbs( $mitem->link );
			}
	
			if ($level > 0) {
				$menuclass = 'sublevel';
			} else {
				$menuclass = 'mainlevel';
			}
			if (($this->activeMenuClass) && ($menuNode->isActive())) {
				$menuclass	.= '_active';
			}
			$menuclass	.= $this->classSuffix;
	
			switch ($mitem->browserNav) {
				// cases are slightly different
				case 1:
				// open in a new window
				$txt = '<a href="'. $mitem->link .'" target="_blank" class="'. $menuclass .'"'. $elementParameters .'>'. $mitem->name .'</a>';
				break;
	
				case 2:
				// open in a popup window
				$txt = "<a href=\"#\" onclick=\"javascript: window.open('". $mitem->link ."', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class=\"$menuclass\"". $elementParameters .">". $mitem->name ."</a>\n";
				break;
	
				case 3:
				// don't link it
				$txt = '<span class="'. $menuclass .'"'. $elementParameters .'>'. ($mitem->name != '' ? $mitem->name : '&nbsp;') .'</span>';
				break;
	
				default:	// formerly case 2
				// open in parent window
				$txt = '<a href="'. $mitem->link .'" class="'. $menuclass .'"'. $elementParameters .'>'. $mitem->name .'</a>';
				break;
			}
	
			if ( $params->get( 'menu_images' ) ) {
				$menu_params = new stdClass();
				$menu_params =& new mosParameters( $mitem->params );
				$menu_image = $menu_params->def( 'menu_image', -1 );
				if ( ( $menu_image <> '-1' ) && $menu_image ) {
					$image = '<img src="'. $mosConfig_live_site .'/images/stories/'. $menu_image .'" border="0" alt="'. $mitem->name .'"/>';
					if ( $params->get( 'menu_images_align' ) ) {
						$txt = $txt .' '. $image;
					} else {
						$txt = $image .' '. $txt;
					}
				}
			}
	
			return $txt;
		}
	}
	
	/**
	 * This Menu View is used for menu style "Flat List" and "Tree List"
	 */
	class ListMenuView extends AbstractMenuView {
		
		function renderAsString(&$menuNodeList, $level = 0) {
			return $this->_renderMenuNodeList($menuNodeList, $level, $this->menuHierarchy);
		}
		
		function _renderMenuNodeList(&$menuNodeList, $level = 0, $hierarchy = array()) {
			$result	= '';
			$result	.= '<ul ';
			if ($this->hierarchyBasedIds) {
				$result	.= ' id="menulist_'.$this->getHierarchyString($hierarchy).$this->classSuffix.'"';
				$levelAttribute	= 'class';
			}
			$levelAttribute	= (($level == 0) && (!$this->hierarchyBasedIds) ? 'id' : 'class');	// for compatibility use id if possible
			$levelValue		= '';
			if ($level == 0) {
				$levelValue	= 'mainlevel';
			} else {
				if ($this->sublevelClasses) {
					$levelValue	= 'sublevel';
				}
			}
			if ($levelValue != '') {
				$result	.= ' '.$levelAttribute.'="'.$levelValue.$this->classSuffix.'"';
			}
			$result	.= '>';
			$index	= 0;
			foreach(array_keys($menuNodeList) as $id) {
				$menuNode			=& $menuNodeList[$id];
				$itemHierarchy		= $hierarchy;
				$itemHierarchy[]	= (1 + $index);
				$result	.= '<li';
				if ($this->hierarchyBasedIds) {
					$result	.= ' id="menuitem_'.$this->getHierarchyString($itemHierarchy).$this->classSuffix.'"';
				}
				$result	.= '>';
				$linkOutput	= $this->mosGetMenuLink($menuNode, $level, $this->params, $itemHierarchy);
				$result	.= $linkOutput;
				if (($level < $this->maxDepth) && ($menuNode->isExpanded())) {
					$subMenuNodeList	=& $menuNode->getChildNodeList();
					if (count($subMenuNodeList) > 0) {
						$result	.= $this->_renderMenuNodeList($subMenuNodeList, $level+1, $itemHierarchy);
					}
				}
				$result	.= '</li>';
				$index++;
			}
			$result	.= '</ul>';
			return $result;
		}
	}

	/**
	 * This Menu View is used for menu style "Horizontal"
	 */
	class HorizontalMenuView extends AbstractMenuView {
		
		function renderAsString(&$menuNodeList, $level = 0) {
			return $this->_renderMenuNodeList($menuNodeList, $level, $this->menuHierarchy);
		}
		
		function _renderMenuNodeList(&$menuNodeList, $level = 0, $hierarchy = array()) {
			$params		= $this->params;
			$menuclass	= 'mainlevel'.$this->classSuffix;
			$result	= '';
			if ($level == 0) {
				$result	.= '<table width="100%" border="0" cellpadding="0" cellspacing="1"><tr><td nowrap="nowrap">';
				$result	.= '<span class="'.$menuclass.'"> '.$params->get('end_spacer').'</span>';
			} else {
				return '';	// horizontal menu has no sub menus
			}
			$index	= 0;
			foreach(array_keys($menuNodeList) as $id) {
				$menuNode	=& $menuNodeList[$id];
				$itemHierarchy		= $hierarchy;
				$itemHierarchy[]	= (1 + $index);
				$result	.= '<span class="'. $menuclass .'"> '.$params->get('spacer').' </span>';
				$linkOutput	= $this->mosGetMenuLink($menuNode, $level, $this->params, $itemHierarchy);
				$result	.= $linkOutput;
				$result	.= '<span class="'. $menuclass .'"> '.$params->get('end_spacer').' </span>';
				$index++;
			}
			$result	.= '</td></tr></table>';
			return $result;
		}
	}


	/**
	 * This Menu View is used for menu style "Vertical"
	 */
	class VerticalTableMenuView extends AbstractMenuView {
		
		function renderAsString(&$menuNodeList, $level = 0) {
			return $this->_renderMenuNodeList($menuNodeList, $level, $this->menuHierarchy);
		}
		
		function _renderMenuNodeList(&$menuNodeList, $level = 0, $hierarchy = array()) {
			global $mosConfig_live_site, $cur_template;
			$img	= NULL;
			$params	= $this->params;
			// indent icons
			if (($level >= 1) && ($level <= 7)) {
				switch ($params->get('indent_image')) {
					case '1':
						// Default images
						$imgpath	= $mosConfig_live_site .'/images/M_images';
						$img		= '<img src="'.$imgpath.'/indent'.$level.'.png" alt="" />';
						break;
					case '2':
						// Use Params
						$imgpath = $mosConfig_live_site .'/images/M_images';
						if ($params->get('indent_image'.$level) != '-1') {
							$img	= '<img src="'.$imgpath.'/'.$params->get('indent_image'.$level).'" alt="" />';
						}
						break;
					case '3':
						// None
						break;
					default:
						// Template
						$imgpath	= $mosConfig_live_site .'/templates/'. $cur_template .'/images';
						$img		= '<img src="'.$imgpath.'/indent'.$level.'.png" alt="" />';
						break;
				}
			}
			
			$result	= '';
			if ($level == 0) {
				$result	.= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
			}
			$index	= 0;
			foreach(array_keys($menuNodeList) as $id) {
				$menuNode	=& $menuNodeList[$id];
				$itemHierarchy		= $hierarchy;
				$itemHierarchy[]	= (1 + $index);
				
				$elementAttributes	= '';
				if ($this->hierarchyBasedIds) {
					$elementAttributes	.= ' id="menuitem_'.$this->getHierarchyString($itemHierarchy).$this->classSuffix.'"';
				}
				$levelValue		= '';
				if ($level == 0) {
					if ($this->mainlevelClasses) {
						$levelValue	= 'mainlevel';
					}
				} else {
					if ($this->sublevelClasses) {
						$levelValue	= 'sublevel';
					}
				}
				if ($levelValue != '') {
					$elementAttributes	.= ' class="'.$levelValue.$this->classSuffix.'"';
				}
				
				if ($level == 0) {
					$result	.= '<tr align="left"><td'.$elementAttributes.'>';
				} else {
					$result	.= '<div style="padding-left: '.(4 * $level).'px"'.$elementAttributes.'>'.$img;
				}
				$linkOutput	= $this->mosGetMenuLink($menuNode, $level, $this->params, $itemHierarchy);
				$result	.= $linkOutput;
				if (($level < $this->maxDepth) && ($menuNode->isExpanded())) {
					$subMenuNodeList	=& $menuNode->getChildNodeList();
					if (count($subMenuNodeList) > 0) {
						$result	.= $this->_renderMenuNodeList($subMenuNodeList, $level+1, $itemHierarchy);
					}
				}
				if ($level == 0) {
					$result	.= '</td></tr>';
				} else {
					$result	.= '</div>';
				}
				$index++;
			}
			if ($level == 0) {
				$result	.= '</table>';
			}
			return $result;
		}

	}

	/**
	 * This Menu View is used for menu style "HTML Tree"
	 */
	class HtmlTreeMenuView extends AbstractMenuView {
		
		function getImageHtml($name) {
			global $mosConfig_live_site, $cur_template;
			$imagePath	= $mosConfig_live_site.'/templates/'.$cur_template.'/images/';
			return '<img src="'.$imagePath.$name.'.gif'.'" alt="" border="0"/>';
		}
		
		function renderAsString(&$menuNodeList, $level = 0) {
			return $this->_renderMenuNodeList($menuNodeList, $level, $this->menuHierarchy);
		}
		
		function _renderMenuNodeList1(&$menuNodeList, $level = 0, $hierarchy = array()) {
			global $mosConfig_live_site, $cur_template;
			$imagePath	= $mosConfig_live_site.'/templates/'.$cur_template.'/images/';
			$result	= '';
			if ($level == 0) {
				$result	.= '<div class="tree">';
				$result	.= $this->getImageHtml('base');
				$result	.= '<br/>';
			} else {
			}
			$keys	= array_keys($menuNodeList);
			$count	= count($keys);
			$iItem		= 0;
			foreach($keys as $id) {
				$iItem++;
				$isLast	= ($iItem == $count);
				$menuNode	=& $menuNodeList[$id];
				$itemHierarchy		= $hierarchy;
				$itemHierarchy[]	= $iItem;
				$hasSubMenuItems	= ($menuNode->hasChildren());
				$subMenuNodeList	=& $menuNode->getChildNodeList();
				$openSubMenuItems	= (($hasSubMenuItems) && ($level < $this->maxDepth) && ($menuNode->isExpanded()));
				if ($menuNode->type	== 'separator') {
					$linkOutput			= '';
				} else {
					$linkOutput			= trim($this->mosGetMenuLink($menuNode, $level, $this->params, $itemHierarchy));
				}
				$href				= $this->getExtractedHref($linkOutput);
				$result	.= '<div>';
				for($i = 0; $i < $level; $i++) {
					$result	.= $this->getImageHtml('line');
				}
				if ($hasSubMenuItems) {
					if ($openSubMenuItems) {
						$result	.= $this->getImageHtml('minus');
						$result	.= $this->getImageHtml('folder_open');
					} else {
						if ($href != '') {
							$result	.= '<a class="plus" href="'.$href.'">';
						}
						$result	.= $this->getImageHtml('plus');
						if ($href != '') {
							$result	.= '</a>';
						}
						$result	.= $this->getImageHtml('folder');
					}
				} else {
					if ($linkOutput == '') {
						$result	.= $this->getImageHtml('line');
					} else {
						if ($isLast) {
							$result	.= $this->getImageHtml('join_last');
						} else {
							$result	.= $this->getImageHtml('join');
						}
						if ($menuNode->isActive()) {
							$result	.= $this->getImageHtml('document_open');
						} else {
							$result	.= $this->getImageHtml('document');
						}
					}
				}
				if ($linkOutput != '') {
//					$result	.= '&nbsp;&nbsp;';
				}
				$result	.= $linkOutput;
				$result	.= '</div>';
//				$result	.= '<br/>';
				if ($openSubMenuItems) {
					$result	.= $this->_renderMenuNodeList($subMenuNodeList, $level+1, $itemHierarchy);
				}
			}
			if ($level == 0) {
				$result	.= '</div>';
			} else {
			}
			return $result;
		}

		function _renderMenuNodeList(&$menuNodeList, $level = 0, $hierarchy = array(), $noLineMap = NULL) {
			global $mosConfig_live_site, $cur_template;
			$imagePath	= $mosConfig_live_site.'/templates/'.$cur_template.'/images/';
			if (!is_array($noLineMap)) {
				$noLineMap	= array();
			}
			$result	= '';
			if ($level == 0) {
				$result	.= '<div class="tree">';
				$result	.= $this->getImageHtml('base');
				$result	.= '<br/>';
			} else {
			}
			$keys	= array_keys($menuNodeList);
			$count	= count($keys);
			$iItem		= 0;
			foreach($keys as $id) {
				$iItem++;
				$isLast	= ($iItem == $count);
				$lastSuffix	= ($isLast ? '_last' : '');
				$menuNode	=& $menuNodeList[$id];
				$itemHierarchy		= $hierarchy;
				$itemHierarchy[]	= $iItem;
				$hasSubMenuItems	= ($menuNode->hasChildren());
				$subMenuNodeList	=& $menuNode->getChildNodeList();
				$openSubMenuItems	= (($hasSubMenuItems) && ($level < $this->maxDepth) && ($menuNode->isExpanded()));
				if ($menuNode->type	== 'separator') {
					$linkOutput			= '';
				} else {
					$linkOutput			= trim($this->mosGetMenuLink($menuNode, $level, $this->params, $itemHierarchy));
				}
				$href				= $this->getExtractedHref($linkOutput);
				$result	.= '<div>';
				for($i = 0; $i < $level; $i++) {
					if (isset($noLineMap[$i])) {
						$result	.= $this->getImageHtml('noline');
					} else {
						$result	.= $this->getImageHtml('line');
					}
				}
				if ($hasSubMenuItems) {
					if ($openSubMenuItems) {
						$result	.= $this->getImageHtml('minus'.$lastSuffix);
						$result	.= $this->getImageHtml('folder_open');
					} else {
						if ($href != '') {
							$result	.= '<a class="plus" href="'.$href.'">';
						}
						$result	.= $this->getImageHtml('plus');
						if ($href != '') {
							$result	.= '</a>';
						}
						$result	.= $this->getImageHtml('folder');
					}
				} else {
					if ($linkOutput == '') {
						$result	.= $this->getImageHtml('line');
					} else {
						$result	.= $this->getImageHtml('join'.$lastSuffix);
						if ($menuNode->isActive()) {
							$result	.= $this->getImageHtml('document_open');
						} else {
							$result	.= $this->getImageHtml('document');
						}
					}
				}
				$result	.= $linkOutput;
				if ($isLast) {
					$noLineMap[$level]	= TRUE;
				}
				if ($linkOutput != '') {
//					$result	.= '&nbsp;&nbsp;';
				}
//				$result	.= $linkOutput;
				$result	.= '</div>';
//				$result	.= '<br/>';
				if ($openSubMenuItems) {
					$result	.= $this->_renderMenuNodeList($subMenuNodeList, $level+1, $itemHierarchy, $noLineMap);
				}
				unset($noLineMap[$level]);
			}
			if ($level == 0) {
				$result	.= '</div>';
			} else {
			}
			return $result;
		}
	}


	/**
	 * This Menu View is used for menu style "CSS Tree"
	 */
	class CssTreeMenuView extends AbstractMenuView {
		
		function getImageHtml($name) {
			global $mosConfig_live_site, $cur_template;
//			$imagePath	= $mosConfig_live_site.'/templates/'.$cur_template.'/images/';
//			return '<img src="'.$imagePath.$name.'.gif'.'" alt="" border="0"/>';
			return '<span class="'.$name.'"></span>';
		}
		
		function renderAsString(&$menuNodeList, $level = 0) {
			return $this->_renderMenuNodeList($menuNodeList, $level, $this->menuHierarchy);
		}
		
		function _renderMenuNodeList(&$menuNodeList, $level = 0, $hierarchy = array(), $noLineMap = NULL) {
			global $mosConfig_live_site, $cur_template;
			if (!is_array($noLineMap)) {
				$noLineMap	= array();
			}
			$imagePath	= $mosConfig_live_site.'/templates/'.$cur_template.'/images/';
			$result	= '';
			if ($level == 0) {
				$result	.= '<div class="tree">';
				$result	.= '<div class="start">';
				$result	.= '</div>';
			} else {
			}
			$keys	= array_keys($menuNodeList);
			$count	= count($keys);
			$iItem		= 0;
			$result	.= '<ul>';
			foreach($keys as $id) {
				$result	.= '<li>';
				$iItem++;
				$isLast	= ($iItem == $count);
				$lastSuffix	= ($isLast ? '_last' : '');
				$menuNode	=& $menuNodeList[$id];
				$itemHierarchy		= $hierarchy;
				$itemHierarchy[]	= $iItem;
				$hasSubMenuItems	= ($menuNode->hasChildren());
				$subMenuNodeList	=& $menuNode->getChildNodeList();
				$openSubMenuItems	= (($hasSubMenuItems) && ($level < $this->maxDepth) && ($menuNode->isExpanded()));
				if ($menuNode->type	== 'separator') {
					$linkOutput			= '';
				} else {
					$linkOutput			= trim($this->mosGetMenuLink($menuNode, $level, $this->params, $itemHierarchy));
				}
				$href				= $this->getExtractedHref($linkOutput);
//				$result	.= '<div class="clear">';
				for($i = 0; $i < $level; $i++) {
					if (isset($noLineMap[$i])) {
						$result	.= $this->getImageHtml('noline');
					} else {
						$result	.= $this->getImageHtml('line');
					}
				}
				if ($hasSubMenuItems) {
					if ($openSubMenuItems) {
						$result	.= $this->getImageHtml('minus'.$lastSuffix);
						$result	.= $this->getImageHtml('folder_open');
					} else {
						if ($href != '') {
							$result	.= '<a class="plus" href="'.$href.'">';
						}
						$result	.= $this->getImageHtml('plus');
						if ($href != '') {
							$result	.= '</a>';
						}
						$result	.= $this->getImageHtml('folder');
					}
				} else {
					if ($linkOutput == '') {
						$result	.= $this->getImageHtml('line');
					} else {
						$result	.= $this->getImageHtml('join'.$lastSuffix);
						if ($menuNode->isActive()) {
							$result	.= $this->getImageHtml('document_open');
						} else {
							$result	.= $this->getImageHtml('document');
						}
					}
				}
				$result	.= $linkOutput;
				if ($isLast) {
					$noLineMap[$level]	= TRUE;
				}
//				$result	.= '</div>';
//				$result	.= '<br/>';
				if ($openSubMenuItems) {
					$result	.= $this->_renderMenuNodeList($subMenuNodeList, $level+1, $itemHierarchy, $noLineMap);
				}
				unset($noLineMap[$level]);
				$result	.= '</li>';
			}
			$result	.= '</ul>';
			if ($level == 0) {
				$result	.= '</div>';
			} else {
			}
			return $result;
		}
	}


	/**
	 * This Menu View is used for patTemplate template files
	 */
	class PatTemplateMenuView extends AbstractMenuView {
		
		var $patTemplateDirectory	= '';
		var $patTemplateFile		= '';
		
		function renderAsString(&$menuNodeList, $level = 0) {
			global $mosConfig_live_site, $mosConfig_absolute_path, $cur_template;
			require_once($mosConfig_absolute_path.'/includes/patTemplate/patTemplate.php');
			$tmpl   =& new patTemplate();
			$tmpl->setBasedir($this->patTemplateDirectory);
			$tmpl->readTemplatesFromFile($this->patTemplateFile);
			$menuListContent	= $this->processMenuNodeList($tmpl, $menuNodeList);
			$this->resetTemplate($tmpl, 'menu', $this->menuLevel);
			$tmpl->addVar('menu', 'MENU_LIST', $menuListContent);
			return $tmpl->getParsedTemplate('menu');
		}
		
		function resetTemplate(&$tmpl, $name, $level = 0, $hierarchy = '') {
			$tmpl->clearTemplate($name);
			$tmpl->addVar($name, 'LEVEL', $level);
			$tmpl->addVar($name, 'MENU_LEVEL', $this->menuLevel);
			$tmpl->addVar($name, 'CLASS_SUFFIX', $this->classSuffix);
		}
		
		function processMenuNodeList(&$tmpl, &$menuNodeList, $level = 0, $hierarchy = array()) {
			$keys	= array_keys($menuNodeList);
			$count	= count($keys);
			if ($count == 0) {
				return '';
			}
			$itemTemplateName	= 'menu_item';
			$listTemplateName	= 'menu_list';
			$menuItemsContent	= '';
			$index	= 0;
			$hierarchyString			= $this->getHierarchyString(array_merge($this->menuHierarchy, $hierarchy));
			$relativeHierarchyString	= $this->getHierarchyString($hierarchy);
			foreach($keys as $id) {
				$menuNode	=& $menuNodeList[$id];
				$hasSubMenuItems	= ($menuNode->hasChildren());
				$subMenuNodeList	=& $menuNode->getChildNodeList();
				$openSubMenuItems	= (($hasSubMenuItems) && ($level < $this->maxDepth) && ($menuNode->isExpanded()));
				$itemHierarchy		= $hierarchy;
				$itemHierarchy[]	= (1+$index);
				$subMenuItemsContent	= '';
				if ($openSubMenuItems) {
					$subMenuItemsContent	= $this->processMenuNodeList($tmpl, $subMenuNodeList, $level+1,
						$itemHierarchy);
				}
				$linkOutput			= trim($this->mosGetMenuLink($menuNode, $level, $this->params, $itemHierarchy));
				$this->resetTemplate($tmpl, $itemTemplateName, $level);
				$tmpl->addVar($itemTemplateName, 'CAPTION', $menuNode->name);
				$tmpl->addVar($itemTemplateName, 'URL', $this->getExtractedHref($linkOutput));
				$tmpl->addVar($itemTemplateName, 'TYPE', $menuNode->type);
				$tmpl->addVar($itemTemplateName, 'ACCESS_KEY', (isset($menuNode->accessKey) ? $menuNode->accessKey : ''));
				$tmpl->addVar($itemTemplateName, 'LINK', $linkOutput);
				$tmpl->addVar($itemTemplateName, 'SUB_MENU_ITEMS', $subMenuItemsContent);
				$tmpl->addVar($itemTemplateName, 'ITEM_ID', $id);
				$tmpl->addVar($itemTemplateName, 'INDEX', 1+$index);
				$tmpl->addVar($itemTemplateName, 'PARENT_HIERARCHY', $hierarchyString);
				$tmpl->addVar($listTemplateName, 'RELATIVE_PARENT_HIERARCHY', $relativeHierarchyString);
				$tmpl->addVar($itemTemplateName, 'HIERARCHY', $this->getHierarchyString(array_merge($this->menuHierarchy, $itemHierarchy)));
				$tmpl->addVar($itemTemplateName, 'RELATIVE_HIERARCHY', $this->getHierarchyString($itemHierarchy));
				$tmpl->addVar($itemTemplateName, 'IS_CURRENT', $menuNode->isCurrent());
				$tmpl->addVar($itemTemplateName, 'IS_ACTIVE', $menuNode->isActive());
				$tmpl->addVar($itemTemplateName, 'IS_EXPANDED', $menuNode->isExpanded());
				$menuItemsContent	.= trim($tmpl->getParsedTemplate($itemTemplateName));
				$index++;
			}
			$this->resetTemplate($tmpl, $listTemplateName, $level);
			$tmpl->addVar($listTemplateName, 'MENU_ITEMS', $menuItemsContent);
			$tmpl->addVar($listTemplateName, 'HIERARCHY', $hierarchyString);
			$tmpl->addVar($listTemplateName, 'RELATIVE_HIERARCHY', $relativeHierarchyString);
			$result	= trim($tmpl->getParsedTemplate($listTemplateName));
			return $result;
		}
	}
	
	class ExtendedMenuModule {
		
		function showModule(&$params) {
			global $Itemid, $mosConfig_absolute_path, $cur_template;
			$params->def( 'menutype', 'mainmenu' );
			$params->def( 'class_sfx', '' );
			$params->def( 'menu_images', 0 );
			$params->def( 'menu_images_align', 0 );
			$params->def( 'expand_menu', 0 );
			$params->def( 'indent_image', 0 );
			$params->def( 'indent_image1', 'indent1.png' );
			$params->def( 'indent_image2', 'indent2.png' );
			$params->def( 'indent_image3', 'indent3.png' );
			$params->def( 'indent_image4', 'indent4.png' );
			$params->def( 'indent_image5', 'indent5.png' );
			$params->def( 'indent_image6', 'indent.png' );
			$params->def( 'spacer', '' );
			$params->def( 'end_spacer', '' );
			
			$params->def('expand_min', '');
			$params->def('max_depth', 10);
			$params->def('hide_first', 0);
			
			$params->def('level_begin', 0);
			$params->def('split_menu', 0);
			$params->def('menu_count', 1);
			$params->def('query_cache', 0 );
			
			$params->def('parse_access_key', 3);
			$params->def('title_attribute', 0);
			$params->def('level_class', 0);
			$params->def('active_menu_class', 0);
			$params->def('element_id', 0);
			$params->def('menu_template', 0);
			$params->def('menu_template_name', '');
			
			if ((isset($GLOBALS['EXTENDED_MENU_OVERRIDE']) && (is_array($GLOBALS['EXTENDED_MENU_OVERRIDE'])))) {
				foreach($GLOBALS['EXTENDED_MENU_OVERRIDE'] as $k => $v) {
					$params->set($k, $v);
				}
			}
			
			$menu_style						= $params->get( 'menu_style', 'vert_indent' );
			
			$maxDepth						= intval($params->get('max_depth')) - 1;
			$minExpand						= intval($params->get('expand_min'));
			$hideFirst						= intval($params->get('hide_first'));
			$openActiveOnly					= !$params->get('expand_menu');
			
			$depthIndex						= intval($params->get('level_begin'));
			$splitMenu						= intval($params->get('split_menu'));
			$menuCount						= intval($params->get('menu_count'));
			$queryCache						= intval($params->get('query_cache'));
			
			$parseAccessKey					= intval($params->get('parse_access_key'));
			$titleAttribute					= intval($params->get('title_attribute'));
			$levelClass						= intval($params->get('level_class'));
			$activeMenuClass				= intval($params->get('active_menu_class'));
			$elementId						= intval($params->get('element_id'));
			$menuTemplate					= intval($params->get('menu_template'));
			$patTemplateFile				= trim($params->get('menu_template_name'));
			
			$patTemplateDirectory			= $mosConfig_absolute_path.'/templates/'.$cur_template;
			if (($menuTemplate > 0) && ($patTemplateFile != '')) {
				if (file_exists($patTemplateDirectory.'/'.$patTemplateFile)) {
					$menu_style						= 'patTemplate';
				} else if (file_exists($patTemplateDirectory.'/tmpl/'.$patTemplateFile)) {
					$patTemplateDirectory			= $patTemplateDirectory.'/tmpl';
					$menu_style						= 'patTemplate';
				}
			}
			if ($menuCount > 1) {
				$splitMenu	= max(1, $splitMenu);
			}
			$menuLoader						= new MenuLoader();
			switch ( $menu_style ) {
				case 'patTemplate':
					// not choosen directly by the user
					$view						=& new PatTemplateMenuView();
					$view->patTemplateDirectory	= $patTemplateDirectory;
					$view->patTemplateFile		= $patTemplateFile;
					break;
				case 'list_flat':
					$maxDepth				= 0;
				case 'list_tree':
					$view					=& new ListMenuView();
					break;
				case 'horiz_flat':
					$maxDepth				= 0;
					$view					=& new HorizontalMenuView();
					break;
				case 'html_tree':
					$view					=& new HtmlTreeMenuView();
					break;
				case 'css_tree':
					$view					=& new CssTreeMenuView();
					break;
				default:
					$view					=& new VerticalTableMenuView();
					break;
			}
			$menuLoader->menutype			= $params->get('menutype');
			$menuLoader->activeMenuId		= $Itemid;
			$menuLoader->openActiveOnly		= $openActiveOnly;
			$menuLoader->maxDepth			= $maxDepth;
			$menuLoader->minExpand			= $minExpand;
			$menuLoader->parseAccessKey		= $parseAccessKey;
			$menuLoader->cacheEnabled		= ($queryCache > 0);
			$menuLoader->load();
			
			$view->params					=& $params;
			$view->classSuffix				= $params->get('class_sfx');
			$view->openActiveOnly			= $openActiveOnly;
			$view->titleAttribute			= $titleAttribute > 0;
			$view->mainlevelClass			= $levelClass > 0;
			$view->sublevelClass			= $levelClass > 0;
			$view->activeMenuClass			= $activeMenuClass > 0;
			$view->hierarchyBasedIds		= $elementId > 0;
			
			for ($iMenu = 0; $iMenu < $menuCount; $iMenu++) {
				if ($splitMenu > 0) {
					$view->maxDepth			= $splitMenu - 1;
				} else {
					$view->maxDepth			= $maxDepth;
				}
				if ($depthIndex > 0) {
					if ($depthIndex > count($menuLoader->activeIds)) {
						break;	// no more menu items
					}
					$menuNode	=& $menuLoader->menuNodeByIdMap[$menuLoader->activeIds[count($menuLoader->activeIds) - $depthIndex]];
					$menuNodeList					=& $menuNode->getChildNodeList();
				} else {
					$menuNodeList					=& $menuLoader->menuNodeList;
				}
				if (count($menuNodeList) == 0) {
					break;
				}
				$view->menuHierarchy	= $menuLoader->getHierarchy($depthIndex);
				$view->menuLevel		= $depthIndex;
				if (($hideFirst == 1) && ($iMenu == 0)) {
					$menuNodeList2	= $menuNodeList;
					array_shift($menuNodeList2);
					$menuNodeList	=& $menuNodeList2;
				}
				echo $view->renderAsString($menuNodeList, 0);
				$depthIndex				+= $view->maxDepth + 1;
			}
		}
		
	}

}

if ((isset($params)) && ($requestedModule == 'exmenu')) {
	ExtendedMenuModule::showModule($params);
}

?>