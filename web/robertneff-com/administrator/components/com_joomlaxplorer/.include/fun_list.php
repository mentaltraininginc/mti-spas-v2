<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is fun_list.php, released on 2003-03-31.

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
	Directory-Listing Functions
	
	Have Fun...
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
// HELPER FUNCTIONS (USED BY MAIN FUNCTION 'list_dir', SEE BOTTOM)
function make_list($_list1, $_list2) {		// make list of files
	$list = array();

	if($GLOBALS["srt"]=="yes") {
		$list1 = $_list1;
		$list2 = $_list2;
	} else {
		$list1 = $_list2;
		$list2 = $_list1;
	}
	
	if(is_array($list1)) {
		while (list($key, $val) = each($list1)) {
			$list[$key] = $val;
		}
	}
	
	if(is_array($list2)) {
		while (list($key, $val) = each($list2)) {
			$list[$key] = $val;
		}
	}
	
	return $list;
}
//------------------------------------------------------------------------------
function make_tables($dir, &$dir_list, &$file_list, &$tot_file_size, &$num_items)
{						// make table of files in dir
	// make tables & place results in reference-variables passed to function
	// also 'return' total filesize & total number of items
	$homedir = realpath($GLOBALS['home_dir']);
	$tot_file_size = $num_items = 0;
	// Open directory
	$handle = @opendir(get_abs_dir($dir));
	if($handle===false && $dir=="") {
	  $handle = @opendir($homedir . $GLOBALS['separator']);
	}
	if($handle===false)
	  show_error($dir.": ".$GLOBALS["error_msg"]["opendir"]);
	
	// Read directory
	while(($new_item = readdir($handle))!==false) {
		$abs_new_item = get_abs_item($dir, $new_item);
		if ($new_item == "." || $new_item == "..") continue;
		if(!file_exists($abs_new_item)) show_error($dir."/$abs_new_item: ".$GLOBALS["error_msg"]["readdir"]);
		if(!get_show_item($dir, $new_item)) continue;
		
		$new_file_size = filesize($abs_new_item);
		$tot_file_size += $new_file_size;
		$num_items++;
		
		if(get_is_dir($dir, $new_item)) {
			if($GLOBALS["order"]=="mod") {
				$dir_list[$new_item] =
					@filemtime($abs_new_item);
			} else {	// order == "size", "type" or "name"
				$dir_list[$new_item] = $new_item;
			}
		} else {
			if($GLOBALS["order"]=="size") {
				$file_list[$new_item] = $new_file_size;
			} elseif($GLOBALS["order"]=="mod") {
				$file_list[$new_item] =
					@filemtime($abs_new_item);
			} elseif($GLOBALS["order"]=="type") {
				$file_list[$new_item] =
					get_mime_type($dir, $new_item, "type");
			} else {	// order == "name"
				$file_list[$new_item] = $new_item;
			}
		}
	}
	closedir($handle);
	
	
	// sort
	if(is_array($dir_list)) {
		if($GLOBALS["order"]=="mod") {
			if($GLOBALS["srt"]=="yes") arsort($dir_list);
			else asort($dir_list);
		} else {	// order == "size", "type" or "name"
			if($GLOBALS["srt"]=="yes") ksort($dir_list);
			else krsort($dir_list);
		}
	}
	
	// sort
	if(is_array($file_list)) {
		if($GLOBALS["order"]=="mod") {
			if($GLOBALS["srt"]=="yes") arsort($file_list);
			else asort($file_list);
		} elseif($GLOBALS["order"]=="size" || $GLOBALS["order"]=="type") {
			if($GLOBALS["srt"]=="yes") asort($file_list);
			else arsort($file_list);
		} else {	// order == "name"
			if($GLOBALS["srt"]=="yes") ksort($file_list);
			else krsort($file_list);
		}
	}
}
//------------------------------------------------------------------------------
function print_table($dir, $list, $allow) {	// print table of files
	global $dir_up;
	if(!is_array($list)) return;
	if( $dir != "" ) {
	  echo "<tr class=\"rowdata\"><td>&nbsp;</td><td valign=\"baseline\"><a href=\"".make_link("list",$dir_up,NULL)."\">";
	  echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_up.png\" ";
	  echo "alt=\"".$GLOBALS["messages"]["uplink"]."\" title=\"".$GLOBALS["messages"]["uplink"]."\"/>&nbsp;&nbsp;..</a></td>\n";
	  echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	  if( extension_loaded( "posix" ))
		echo "<td>&nbsp;</td>";
	  echo "</tr>";
	}
	$i = 0;
	while(list($item,) = each($list)){
		// link to dir / file
		$abs_item=get_abs_item($dir,$item);
		
		$file_info = stat( $abs_item );
		
		$target="";
		//$extra="";
		//if(is_link($abs_item)) $extra=" -> ".@readlink($abs_item);
		if(is_dir($abs_item)) {
			$link = make_link("list",get_rel_item($dir, $item),NULL);
		} else { //if(get_is_editable($dir,$item) || get_is_image($dir,$item)) {
			$link = $GLOBALS["home_url"]."/".get_rel_item($dir, $item);
			$target = "_blank";
		} //else $link = "";
		
		//$disabled = is_readable( $abs_item ) ? "" : "disabled=\"disabled\"";
		
		//echo "<tr class=\"rowdata\">"
		echo '<tr onmouseover="style.backgroundColor=\'#D8ECFF\';" onmouseout="style.backgroundColor=\'#EAECEE\';" bgcolor=\'#EAECEE\'>';
		echo "<td><input type=\"checkbox\" id=\"item_$i\" name=\"selitems[]\" value=\"";
		echo htmlspecialchars($item)."\" onclick=\"javascript:Toggle(this);\"></td>\n";
	// Icon + Link
		echo "<td nowrap=\"nowrap\">";
		/*if($link!="") */ echo"<a href=\"".$link."\" target=\"".$target."\">";
		//else echo "<A>";
		echo "<img border=\"0\" width=\"22\" height=\"22\" ";
		echo "align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/".get_mime_type($dir, $item, "img")."\" alt=\"\">&nbsp;";
		$s_item=$item;	if(strlen($s_item)>50) $s_item=substr($s_item,0,47)."...";
		echo htmlspecialchars($s_item)."</a></td>\n";	// ...$extra...
	// Size
		echo "<td>".parse_file_size(get_file_size($dir,$item))."</td>\n";
	// type
		echo "<td>".get_mime_type($dir, $item, "type")."</td>\n";
	// modified
		echo "<td>".parse_file_date(get_file_date($dir,$item))."</td>\n";
	// permissions
		echo "<td>";
		if($allow) {
			echo "<a href=\"".make_link("chmod",$dir,$item)."\" title=\"";
			echo $GLOBALS["messages"]["permlink"]."\">";
		}
		echo parse_file_type($dir,$item).parse_file_perms(get_file_perms($dir,$item));
		if($allow) echo "</a>";
		echo "</td>\n";
	// Owner
	error_reporting( E_ALL );
	if( extension_loaded( "posix" )) {
		echo "<td>\n";
		$user_info = posix_getpwuid( $file_info["uid"] );
		$group_info = posix_getgrgid($file_info["gid"] );
		echo $user_info["name"]. " (".$file_info["uid"].") /<br/>";
		echo $group_info["name"]. " (".$file_info["gid"].")";
		
		echo "</td>\n";
	}
	// actions
		echo "<td>\n<table>\n";
		// EDIT
		if(get_is_editable($dir, $item)) {
			if($allow) {
				echo "<td><a href=\"".make_link("edit",$dir,$item)."\">";
				echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
				echo "src=\""._QUIXPLORER_URL."/_img/_edit.png\" alt=\"".$GLOBALS["messages"]["editlink"]."\" title=\"";
				echo $GLOBALS["messages"]["editlink"]."\"></a></td>\n";
			} else {
				echo "<td><img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
				echo "src=\""._QUIXPLORER_URL."/_img/_edit_.png\" alt=\"".$GLOBALS["messages"]["editlink"]."\" title=\"";
				echo $GLOBALS["messages"]["editlink"]."\"></td>\n";
			}
		} else {
			// Extract Link
			if( is_archive( $item ) ) {
			  echo "<td><a 
			  onclick=\"javascript: ClearAll(); getElementById('item_$i').checked = true; if( confirm('". ($GLOBALS["messages"]["extract_warning"]) ."') ) { document.selform.do_action.value='extract'; document.selform.submit(); } else {  getElementById('item_$i').checked = false; return false;}\" 
			  href=\"".make_link("extract",$dir,$item)."\" title=\"".$GLOBALS["messages"]["extractlink"]."\">";
			  echo "<img border=\"0\" width=\"22\" height=\"20\" align=\"absmiddle\" ";
			  echo "src=\""._QUIXPLORER_URL."/_img/_extract.png\" alt=\"".$GLOBALS["messages"]["extractlink"];
			  echo "\" title=\"".$GLOBALS["messages"]["extractlink"]."\"></a></td>\n";
			}
			else {
			  echo "<td><img border=\"0\" width=\"16\" height=\"16\" align=\"absmiddle\" ";
			  echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"\"></td>\n";
			}
		}
		// DOWNLOAD / Extract
		if(get_is_file($dir,$item)) {
			if($allow) {
				echo "<td><a href=\"".make_link("download",$dir,$item)."\" title=\"".$GLOBALS["messages"]["downlink"]."\">";
				echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
				echo "src=\""._QUIXPLORER_URL."/_img/_download.png\" alt=\"".$GLOBALS["messages"]["downlink"];
				echo "\" title=\"".$GLOBALS["messages"]["downlink"]."\"></a></td>\n";
			} else if(!$allow) {
				echo "<td><img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
				echo "src=\""._QUIXPLORER_URL."/_img/_download_.png\" alt=\"".$GLOBALS["messages"]["downlink"];
				echo "\" title=\"".$GLOBALS["messages"]["downlink"]."\"></td>\n";
			}
		} else {
			echo "<td><img border=\"0\" width=\"16\" height=\"16\" align=\"absmiddle\" ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"\"></td>\n";
		}
		// DELETE
		if(get_is_file($dir,$item)) {
			if($allow) {
				echo "<td><a href=\"#\" title=\"".$GLOBALS["messages"]["dellink"]."\" 
				onclick=\"javascript: ClearAll(); getElementById('item_$i').checked = true; if( confirm('". ($GLOBALS["messages"]["dellink"]) ."?') ) { document.selform.do_action.value='delete'; document.selform.submit(); } else {  getElementById('item_$i').checked = false; return false;}\">";
				echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
				echo "src=\""._QUIXPLORER_URL."/_img/_delete.png\" alt=\"".$GLOBALS["messages"]["dellink"];
				echo "\" title=\"".$GLOBALS["messages"]["dellink"]."\"></a></td>\n";
			} 
			else if(!$allow) {
				echo "<td><img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
				echo "src=\""._QUIXPLORER_URL."/_img/_delete_.png\" alt=\"".$GLOBALS["messages"]["dellink"];
				echo "\" title=\"".$GLOBALS["messages"]["dellink"]."\"></td>\n";
			}
		} else {
			echo "<td><img border=\"0\" width=\"16\" height=\"16\" align=\"absmiddle\" ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"\"></td>\n";
		}
		echo "</table>\n</td></tr>\n";
		$i++;
	}
}
//------------------------------------------------------------------------------
// MAIN FUNCTION
function list_dir($dir) {			// list directory contents
	global $dir_up, $mosConfig_absolute_path;
    if( is_callable( array( "moscommonhtml", "loadoverlib" ) ))
		mosCommonHtml::loadOverlib();
	$allow=($GLOBALS["permissions"]&01)==01;
	$admin=((($GLOBALS["permissions"]&04)==04) || (($GLOBALS["permissions"]&02)==02));
	
	$dir_up = dirname($dir);
	if($dir_up==".") $dir_up = "";
	
	if(!get_show_item($dir_up,basename($dir))) show_error($dir." : ".$GLOBALS["error_msg"]["accessdir"]);
	
	// make file & dir tables, & get total filesize & number of items
	make_tables($dir, $dir_list, $file_list, $tot_file_size, $num_items);
	
	$dirs = explode( "/", $dir );
	$implode = "";
	$dir_links = "<a href=\"".make_link( "list", "", null )."\">..</a>&nbsp;/&nbsp;";
	foreach( $dirs as $directory ) {
	  if( $directory != "" ) {
		$implode .= $directory."/";
		$dir_links .= "<a href=\"".make_link( "list", $implode, null )."\">$directory</a>&nbsp;/&nbsp;";
	  }
	}
	show_header($GLOBALS["messages"]["actdir"].": ".$dir_links);
	
	// Javascript functions:
	include _QUIXPLORER_PATH."/.include/javascript.php";
	
	// Sorting of items
	$_img = "&nbsp;<img width=\"10\" height=\"10\" border=\"0\" align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/";
	if($GLOBALS["srt"]=="yes") {
		$_srt = "no";	$_img .= "_arrowup.gif\" alt=\"^\">";
	} else {
		$_srt = "yes";	$_img .= "_arrowdown.gif\" alt=\"v\">";
	}
	
	// Toolbar
	echo "<br><table width=\"95%\"><tr><td><table><tr>\n";
	
	// PARENT DIR
	echo "<td>";
	if( $dir != "" ) {
	  echo "<a href=\"".make_link("list",$dir_up,NULL)."\">";
	  echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_up.png\" ";
	  echo "alt=\"".$GLOBALS["messages"]["uplink"]."\" title=\"".$GLOBALS["messages"]["uplink"]."\"></a>";
	}
	echo "</td>\n";
	// HOME DIR
	echo "<td><a href=\"".make_link("list",NULL,NULL)."\">";
	echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_home.png\" ";
	echo "alt=\"".$GLOBALS["messages"]["homelink"]."\" title=\"".$GLOBALS["messages"]["homelink"]."\"></a></td>\n";
	// RELOAD
	echo "<td><a href=\"javascript:location.reload();\"><img border=\"0\" width=\"22\" height=\"22\" ";
	echo "align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_refresh.png\" alt=\"".$GLOBALS["messages"]["reloadlink"];
	echo "\" title=\"".$GLOBALS["messages"]["reloadlink"]."\"></A></td>\n";
	// SEARCH
	echo "<td><a href=\"".make_link("search",$dir,NULL)."\">";
	echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_search.png\" ";
	echo "alt=\"".$GLOBALS["messages"]["searchlink"]."\" title=\"".$GLOBALS["messages"]["searchlink"];
	echo "\"></a></td>\n";
	
	echo "<td><img src=\"images/menu_divider.png\" height=\"22\" width=\"2\" border=\"0\" alt=\"|\" /></td>";
	
	// joomla Sysinfo
	echo "<td><a href=\"".make_link("sysinfo",$dir,NULL)."\">";
	echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/systeminfo.png\" ";
	echo "alt=\"" . $GLOBALS['messages']['mossysinfolink'] . "\" title=\"" . $GLOBALS['messages']['mossysinfolink'] . "\"></a></td>\n";
	
	echo "<td><img src=\"images/menu_divider.png\" height=\"22\" width=\"2\" border=\"0\" alt=\"|\" /></td>";
	
	if($allow) {
		// COPY
		echo "<td><a href=\"javascript:Copy();\"><img border=\"0\" width=\"22\" height=\"22\" ";
		echo "align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_copy.png\" alt=\"".$GLOBALS["messages"]["copylink"];
		echo "\" title=\"".$GLOBALS["messages"]["copylink"]."\"></a></td>\n";
		// MOVE
		echo "<td><a href=\"javascript:Move();\"><img border=\"0\" width=\"22\" height=\"22\" ";
		echo "align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_move.png\" alt=\"".$GLOBALS["messages"]["movelink"];
		echo "\" title=\"".$GLOBALS["messages"]["movelink"]."\"></A></td>\n";
		// DELETE
		echo "<td><a href=\"javascript:Delete();\"><img border=\"0\" width=\"22\" height=\"22\" ";
		echo "align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_delete.png\" alt=\"".$GLOBALS["messages"]["dellink"];
		echo "\" title=\"".$GLOBALS["messages"]["dellink"]."\"></A></td>\n";
		// CHMOD
		echo "<td><a href=\"javascript:Chmod();\"><img border=\"0\" width=\"22\" height=\"22\" ";
		echo "align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_chmod.png\" alt=\"chmod\" title=\"" . $GLOBALS['messages']['chmodlink'] . "\"></a></td>\n";
		// UPLOAD
		if(get_cfg_var("file_uploads")) {
			echo "<td><a href=\"".make_link("upload",$dir,NULL)."\">";
			echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
			echo "src=\""._QUIXPLORER_URL."/_img/_upload.png\" alt=\"".$GLOBALS["messages"]["uploadlink"];
			echo "\" title=\"".$GLOBALS["messages"]["uploadlink"]."\"></A></td>\n";
		} else {
			echo "<td><img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
			echo "src=\""._QUIXPLORER_URL."/_img/_upload_.png\" alt=\"".$GLOBALS["messages"]["uploadlink"];
			echo "\" title=\"".$GLOBALS["messages"]["uploadlink"]."\"></td>\n";
		}
		// ARCHIVE
		if($GLOBALS["zip"] || $GLOBALS["tar"] || $GLOBALS["tgz"]) {
			echo "<td><a href=\"javascript:Archive();\"><img border=\"0\" width=\"22\" height=\"22\" ";
			echo "align=\"absmiddle\" src=\""._QUIXPLORER_URL."/_img/_archive.png\" alt=\"".$GLOBALS["messages"]["comprlink"];
			echo "\" title=\"".$GLOBALS["messages"]["comprlink"]."\"></A></td>\n";
		}
	} else {
		// COPY
		echo "<td><img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
		echo "src=\""._QUIXPLORER_URL."/_img/_copy_.png\" alt=\"".$GLOBALS["messages"]["copylink"]."\" title=\"";
		echo $GLOBALS["messages"]["copylink"]."\"></td>\n";
		// MOVE
		echo "<td><img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
		echo "src=\""._QUIXPLORER_URL."/_img/_move_.png\" alt=\"".$GLOBALS["messages"]["movelink"]."\" title=\"";
		echo $GLOBALS["messages"]["movelink"]."\"></td>\n";
		// DELETE
		echo "<td><img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
		echo "src=\""._QUIXPLORER_URL."/_img/_delete_.png\" alt=\"".$GLOBALS["messages"]["dellink"]."\" title=\"";
		echo $GLOBALS["messages"]["dellink"]."\"></td>\n";
		// UPLOAD
		echo "<td><img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
		echo "src=\""._QUIXPLORER_URL."/_img/_upload_.png\" alt=\"".$GLOBALS["messages"]["uplink"];
		echo "\" title=\"".$GLOBALS["messages"]["uplink"]."\"></td>\n";
	}

	// ADMIN & LOGOUT
	if($GLOBALS["require_login"]) {
		echo "<td>::</td>";
		// ADMIN
		if($admin) {
			echo "<td><a href=\"".make_link("admin",$dir,NULL)."\">";
			echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
			echo "src=\""._QUIXPLORER_URL."/_img/_admin.png\" alt=\"".$GLOBALS["messages"]["adminlink"]."\" title=\"";
			echo $GLOBALS["messages"]["adminlink"]."\"></A></td>\n";
		}
		// LOGOUT
		echo "<td><a href=\"".make_link("logout",NULL,NULL)."\">";
		echo "<img border=\"0\" width=\"22\" height=\"22\" align=\"absmiddle\" ";
		echo "src=\""._QUIXPLORER_URL."/_img/_logout.png\" alt=\"".$GLOBALS["messages"]["logoutlink"]."\" title=\"";
		echo $GLOBALS["messages"]["logoutlink"]."\"></a></td>\n";
	}
	// Logo
	echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"http://joomlaforge.net/projects/joomlaxplorer/\" target=\"_blank\" title=\"joomlaXplorer Project\"><img border=\"0\" align=\"absmiddle\" ";
	echo "src=\""._QUIXPLORER_URL."/_img/logo.png\" height=\"60\" width=\"303\" alt=\"" . $GLOBALS['messages']['logolink'] . "\"></a></td>\n";
	
	echo "</tr></table></td>\n";
	
	// Create File / Dir
	if($allow) {
		echo "<td align=\"right\"><table><form action=\"".make_link("mkitem",$dir,NULL)."\" method=\"post\">\n<tr><td>";
		echo "<select name=\"mktype\"><option value=\"file\">".$GLOBALS["mimes"]["file"]."</option>";
		echo "<option value=\"dir\">".$GLOBALS["mimes"]["dir"]."</option></select>\n";
		echo "<input name=\"mkname\" type=\"text\" size=\"15\">";
		echo "<input type=\"submit\" value=\"".$GLOBALS["messages"]["btncreate"];
		echo "\"></td></tr></form></table></td>\n";
	}
	
	echo "</tr></table>\n";
	
	// End Toolbar
	
	
	// Begin Table + Form for checkboxes
	echo"<table width=\"95%\"><form name=\"selform\" method=\"post\" action=\"".make_link("post",$dir,null)."\">\n";
	echo "<input type=\"hidden\" name=\"do_action\"><input type=\"hidden\" name=\"first\" value=\"y\">\n";
	
	if( extension_loaded( "posix" )) {
	  $owner_info = '<td width="15%" class="header"><strong>' . $GLOBALS['messages']['miscowner'] . '</strong>&nbsp;';
	  if( function_exists( "mosTooltip" ) ) {
		$my_user_info = posix_getpwuid( getmyuid() );
		$my_group_info = posix_getpwuid( getmygid() );
		$owner_info .= mosTooltip( mysql_escape_string( sprintf( $GLOBALS['messages']['miscownerdesc'],  $my_user_info['name'], $my_user_info['uid'], $my_group_info['name'], $my_group_info['gid'] ))); // new [mic]
	  }
	  $owner_info .= "</td>\n";
	  $colspan=8;
	}
	else {
	  $owner_info = "";
	  $colspan = 7;
	}
	// Table Header
	echo "<tr><td colspan=\"$colspan\"><hr/></td></tr><tr><td width=\"2%\" class=\"header\">\n";
	echo "<input type=\"checkbox\" name=\"toggleAllC\" onclick=\"javascript:ToggleAll(this);\"></td>\n";
	echo "<td width=\"44%\" class=\"header\"><b>\n";
	if($GLOBALS["order"]=="name") $new_srt = $_srt;	else $new_srt = "yes";
	echo "<a href=\"".make_link("list",$dir,NULL,"name",$new_srt)."\">".$GLOBALS["messages"]["nameheader"];
	if($GLOBALS["order"]=="name") echo $_img;
	echo "</a></b></td>\n<td width=\"10%\" class=\"header\"><B>";
	if($GLOBALS["order"]=="size") $new_srt = $_srt;	else $new_srt = "yes";
	echo "<a href=\"".make_link("list",$dir,NULL,"size",$new_srt)."\">".$GLOBALS["messages"]["sizeheader"];
	if($GLOBALS["order"]=="size") echo $_img;
	echo "</A></B></td>\n<td width=\"12%\" class=\"header\"><B>";
	if($GLOBALS["order"]=="type") $new_srt = $_srt;	else $new_srt = "yes";
	echo "<a href=\"".make_link("list",$dir,NULL,"type",$new_srt)."\">".$GLOBALS["messages"]["typeheader"];
	if($GLOBALS["order"]=="type") echo $_img;
	echo "</a></b></td>\n<td width=\"12%\" class=\"header\"><B>";
	if($GLOBALS["order"]=="mod") $new_srt = $_srt;	else $new_srt = "yes";
	echo "<a href=\"".make_link("list",$dir,NULL,"mod",$new_srt)."\">".$GLOBALS["messages"]["modifheader"];
	if($GLOBALS["order"]=="mod") echo $_img;
	echo "</a></b></td><td width=\"8%\" class=\"header\"><b>".$GLOBALS["messages"]["permheader"]."</b>\n";
	echo "</td>";
	echo $owner_info;
	echo "<td width=\"6%\" class=\"header\"><b>".$GLOBALS["messages"]["actionheader"]."</b></td></tr>\n";
	echo "<tr><td colspan=\"$colspan\"><hr/></td></tr>\n";
	
	// make & print Table using lists
	print_table($dir, make_list($dir_list, $file_list), $allow);

	// print number of items & total filesize
	echo "<tr><td colspan=\"$colspan\"><hr/></td></tr><tr>\n<td class=\"header\"></td>";
	echo "<td class=\"header\">".$num_items." ".$GLOBALS["messages"]["miscitems"]." (";
	
	if(function_exists("disk_free_space")) {
		$size = disk_free_space($mosConfig_absolute_path. $GLOBALS['separator']);
		$free=parse_file_size($size);
	} 
	elseif(function_exists("diskfreespace")) {
		$size = diskfreespace($mosConfig_absolute_path . $GLOBALS['separator']);
		$free=parse_file_size($size);
	} 
	else $free = "?";
	
	echo $GLOBALS["messages"]["miscfree"].": ".$free.")</td>\n";
	echo "<td class=\"header\">".parse_file_size($tot_file_size)."</td>\n";
	for($i=0;$i<($colspan-3);++$i) echo"<td class=\"header\"></td>";
	echo "</tr>\n<tr><td colspan=\"$colspan\"><hr/></td></tr></form></table>\n";
	
?><script language="JavaScript1.2" type="text/javascript"><!--
	// Uncheck all items (to avoid problems with new items)
	var ml = document.selform;
	var len = ml.elements.length;
	for(var i=0; i<len; ++i) {
		var e = ml.elements[i];
		if(e.name == "selitems[]" && e.checked == true) {
			e.checked=false;
		}
	}
// --></script>
<?php
}
//------------------------------------------------------------------------------
?>
