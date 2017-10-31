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

     The Original Code is fun_archive.php, released on 2003-03-31.

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
	Zip & TarGzip Functions
	
	Have Fun...
------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------
function zip_items($dir,$name) {

	require_once(_QUIXPLORER_PATH . "/_lib/lib_zip.php");
	$cnt=count($GLOBALS['__POST']["selitems"]);
	$abs_dir=get_abs_dir($dir);
	
	$download = mosGetParam( $_REQUEST, 'download', "n" );
	
	$archive_name = get_abs_item($dir,$name);
	if( !strstr( $archive_name, "." )) $archive_name .= ".zip";
	
	$zipfile=new ZipFile();
	for($i=0;$i<$cnt;++$i) {
		$selitem=stripslashes($GLOBALS['__POST']["selitems"][$i]);
		if(!$zipfile->add($abs_dir,$selitem)) {
			show_error($selitem.": Failed adding item.");
		}
	}
	if(!$zipfile->save( $archive_name )) {
		show_error($name.": Failed saving zipfile.");
	}
	else {
	  if( $download=="y" ) {
		require _QUIXPLORER_PATH . "/.include/fun_down.php";
		download_item( dirname($archive_name), basename($archive_name), true );
	  }
	}
	return;
}

//------------------------------------------------------------------------------
function tgz_items($dir,$name) {
	global $mosConfig_absolute_path;
	require_once(_QUIXPLORER_PATH . "/_lib/Tar.php");
	$cnt=count($GLOBALS['__POST']["selitems"]);
	$abs_dir=get_abs_dir($dir);
	
	$download = mosGetParam( $_REQUEST, 'download', "n" );
	
	$type = ($GLOBALS['__POST']["type"] == "tgz") ? "gz" : "bz2";
	$archive_name = get_abs_item($dir,$name);
	if( !strstr( $archive_name, "." )) {
	  $archive_name .= ".tar.$type";
	}
	$tgz_file = new Archive_Tar($archive_name, $type);
	
	for($i=0;$i<$cnt;++$i) {
		$selitem=stripslashes($GLOBALS['__POST']["selitems"][$i]);
		$v_list[] = $abs_dir ."/". $selitem;
	}
	if(!$tgz_file->createModify($v_list, '', realpath($mosConfig_absolute_path))) {
		show_error($name.": Failed saving Archive File.");
	}
	else {
	  if( $download=="y" ) {
		require _QUIXPLORER_PATH . "/.include/fun_down.php";
		download_item( dirname($archive_name), basename($archive_name), true );
	  }
	}
	return;
}
//------------------------------------------------------------------------------
function archive_items($dir) {
	if(($GLOBALS["permissions"]&01)!=01) show_error($GLOBALS["error_msg"]["accessfunc"]);
	if(!$GLOBALS["zip"] && !$GLOBALS["tgz"]) show_error($GLOBALS["error_msg"]["miscnofunc"]);
	
	if(isset($GLOBALS['__POST']["name"])) {
		$name=basename(stripslashes($GLOBALS['__POST']["name"]));
		if($name=="") show_error($GLOBALS["error_msg"]["miscnoname"]);
		switch($GLOBALS['__POST']["type"]) {
			case "zip":	zip_items($dir,$name);	break;
			default:	tgz_items($dir,$name);
		}
		mosRedirect(str_replace("index3.php", "index2.php", make_link("list",$dir,NULL)));
	}
	
	show_header($GLOBALS["messages"]["actarchive"]);
	echo "<br/><form name=\"archform\" method=\"post\" action=\"".str_replace("index2.php", "index3.php", make_link("arch",$dir,NULL))."\">\n";
	echo "<input type=\"hidden\" name=\"no_html\" value=\"1\" />";
	$cnt=count($GLOBALS['__POST']["selitems"]);
	for($i=0;$i<$cnt;++$i) {
		echo "<input type=\"hidden\" name=\"selitems[]\" value=\"".stripslashes($GLOBALS['__POST']["selitems"][$i])."\">\n";
	}
	
	echo "<table width=\"300\"><tr><td>".$GLOBALS["messages"]["nameheader"].":</td><td align=\"left\">";
	echo "<input type=\"text\" name=\"name\" size=\"25\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["typeheader"].":</td><td align=\"left\"><select name=\"type\">\n";
	if(extension_loaded("zlib")) {
	  echo "<option value=\"zip\">Zip</option>\n";
	  echo "<option value=\"tgz\">TGz</option>\n";
	}
	if(extension_loaded("bz2")) echo "<option value=\"bz2\">Bzip2</option>\n";
	echo "</select></td></tr>";
	echo "<tr><td>".$GLOBALS["messages"]["downlink"]."?:</td><td align=\"left\">";
	echo "<input type=\"checkbox\" checked=\"checked\" name=\"download\" value=\"y\" /></td></tr>\n";
	echo "<tr><td></td><td align=\"right\"><input type=\"submit\" value=\"".$GLOBALS["messages"]["btncreate"]."\">\n";
	echo "<input type=\"button\" value=\"".$GLOBALS["messages"]["btncancel"];
	echo "\" onclick=\"javascript:location='".make_link("list",$dir,NULL)."';\">\n</td></tr></form></table><br/>\n";
?><script language="JavaScript1.2" type="text/javascript"><!--
	if(document.archform) document.archform.name.focus();
// --></script><?php
}

function extract_item( $dir, $item ) {
  global $mosConfig_absolute_path;
  
  if( !is_archive( $item )) {
	show_error($GLOBALS["error_msg"]["extract_noarchive"]);
  }
  else {
	  
	  $archive_name = realpath(get_abs_item($dir,$item));
	  
	  $file_info = pathinfo($archive_name);
	  
	  if( empty( $dir ))
		$extract_dir = realpath($mosConfig_absolute_path);
	  else
		$extract_dir = realpath( $mosConfig_absolute_path."/".$dir );
		
	  $ext = $file_info["extension"];
	  
	  switch( $ext ) {
		case "zip":
		
		  require_once( $mosConfig_absolute_path."/administrator/includes/pcl/pclzip.lib.php" );
		  require_once( $mosConfig_absolute_path . "/administrator/includes/pcl/pclerror.lib.php" );
		  $zip = new PclZip($archive_name);
		  $res = $zip->extract( PCLZIP_OPT_PATH, $extract_dir );
		  if( $res < 1 ) {
			show_error( $GLOBALS["messages"]["extract_failure"]." (". $zip->error_string.")" );
		  }
		  else
			$_REQUEST['mosmsg'] = $GLOBALS["messages"]["extract_success"];
		  
		break;
		
		case "gz":  // a
		case "bz": // lot
		case "bz2": // of
		case "bzip2": // fallthroughs,
		case "tbz": // don't
		case "tar": // wonder
		  require_once(_QUIXPLORER_PATH . "/_lib/Tar.php");
		  $archive = new Archive_Tar($archive_name, $type);
		  if( $archive->extract( $extract_dir ) )
			$_REQUEST['mosmsg'] = $GLOBALS["messages"]["extract_success"];
		  else
			show_error($GLOBALS["error_msg"]["extract_failure"]);
		break;
		
		default: 
			show_error($GLOBALS["error_msg"]["extract_unknowntype"]);
		
		break;
	  }
  
	  mosRedirect( make_link("list", $dir, null), $_REQUEST['mosmsg'] );
  }
}
//------------------------------------------------------------------------------
?>
