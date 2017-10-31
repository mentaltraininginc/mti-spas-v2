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

     The Original Code is fun_chmod.php, released on 2003-03-31.

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
	Permission-Change Functions

	Have Fun...
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
function chmod_item($dir, $item) {		// change permissions

	if(($GLOBALS["permissions"]&01)!=01) show_error($GLOBALS["error_msg"]["accessfunc"]);

	if( !empty($GLOBALS['__POST']["selitems"])) {
	  $cnt=count($GLOBALS['__POST']["selitems"]);
	  $do_recurse = true;
	}
	else {
	  $GLOBALS['__POST']["selitems"][]  = $item;
	  $cnt = 1;
	  $do_recurse = false;
	}

	// Execute
	if(isset($GLOBALS['__POST']["confirm"]) && $GLOBALS['__POST']["confirm"]=="true") {
	  $bin='';
	  for($i=0;$i<3;$i++) for($j=0;$j<3;$j++) {
		  $tmp="r_".$i.$j;
		  if(isset($GLOBALS['__POST'][$tmp]) &&$GLOBALS['__POST'][$tmp]=="1" ) $bin.='1';
		  else $bin.='0';
	  }
	  for($i=0;$i<$cnt;++$i) {
		  $item = $GLOBALS['__POST']["selitems"][$i];
		  if(!file_exists(get_abs_item($dir, $item))) show_error($item.": ".$GLOBALS["error_msg"]["fileexist"]);
		  if(!get_show_item($dir, $item)) show_error($item.": ".$GLOBALS["error_msg"]["accessfile"]);
		  if( $do_recurse )
			$ok = chmod_recursive( get_abs_item($dir,$item), bindec($bin) );
		  else
			$ok = @chmod( get_abs_item($dir,$item), bindec($bin) );

		  if(!$ok) {
			  show_error($item.": ".$GLOBALS["error_msg"]["permchange"]);
		  }
	  }
	  header("Location: ".make_link("link",$dir,NULL));
	  return;
	}

	$mode = parse_file_perms(get_file_perms($dir,$GLOBALS['__POST']["selitems"][0]));
	if($mode===false) show_error($GLOBALS['__POST']["selitems"][0].": ".$GLOBALS["error_msg"]["permread"]);
	$pos = "rwx";
	$text = "";
	for($i=0;$i<$cnt;++$i) {
	  $s_item=get_rel_item($dir,$GLOBALS['__POST']["selitems"][$i]);
	  if(strlen($s_item)>50) $s_item="...".substr($s_item,-47);
	  $text .= $s_item;
	}
	show_header($GLOBALS["messages"]["actperms"].": /".$text);


	// Form
	echo '<br /><table width="175"><form method="post" action="';
	echo make_link("chmod",$dir,$item) . "\">\n";
	echo "<input type=\"hidden\" name=\"confirm\" value=\"true\" />\n";
	for($i=0;$i<$cnt;++$i) {
		echo "<input type=\"hidden\" name=\"selitems[]\" value=\"".stripslashes($GLOBALS['__POST']["selitems"][$i])."\" />\n";
	}
	// print table with current perms & checkboxes to change
	for($i=0;$i<3;++$i) {
		echo "<tr><td>" . $GLOBALS["messages"]["miscchmod"][$i] . "</td>";
		for($j=0;$j<3;++$j) {
			echo "<td>" . $pos{$j} . "&nbsp;<input type=\"checkbox\"";
			if($mode{(3*$i)+$j} != "-") echo " checked";
			echo " name=\"r_" . $i.$j . "\" value=\"1\"></td>";
		}
		echo "</tr>\n";
	}

	// Submit / Cancel
	echo "</table>\n<br><table>\n<tr><td>\n<input type=\"submit\" value=\"".$GLOBALS["messages"]["btnchange"];
	echo "\"></td>\n<td><input type=\"button\" value=\"".$GLOBALS["messages"]["btncancel"];
	echo "\" onClick=\"javascript:location='".make_link("list",$dir,NULL)."';\">\n</td></tr></form></table><br />\n";
}
//------------------------------------------------------------------------------
?>