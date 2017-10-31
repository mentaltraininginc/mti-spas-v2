<?php /* $Id: mod_clo.class.php chanh ong $ */
/**
* CLO handling functions
* @package CLO 
* @Copyright Chanh Ong 12/29/2004
* @ All rights reserved
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

/** 
* Utility function for CLO
*/
?>

<?php
function co_mk_tree($irows) {
global $clouseSelection,$clouseLines,$clouseIcons,$clouseStatusText,$clocloseSameLevel,$cloopenAll,$clobasetext;
global $clopath,$clolpath;
global $clodtree;
global $cloclass_sfx;
echo "<table border=0 cellspacing=1 cellpadding=0 width=\"190\"><TR><TD align=left>";
echo "<link rel='StyleSheet' href='".$clodtree."dtree.css' type='text/css' />";
echo "<script type='text/javascript' src='".$clodtree."dtree.js'></script>";
echo <<<EOT
<p align="center"><a href="javascript: cotree.openAll();">Open All</a> | 
<a href="javascript: cotree.closeAll();">Close All</a>
</p>
<script type="text/javascript">
EOT;
echo "\ncotree = new dTree('cotree','".$clodtree."');";
echo "\ncotree.config.useSelection=".$clouseSelection.";";
echo "\ncotree.config.useLines=".$clouseLines.";";
echo "\ncotree.config.useIcons=".$clouseIcons.";";
echo "\ncotree.config.useStatusText=".$clouseStatusText.";";
echo "\ncotree.config.closeSameLevel=".$clocloseSameLevel.";";
$imgid = 0;
$catid = 0;
$lineid = 0;
$catname="";
echo "\ncotree.add(0,-1,'MosCmenuTree','http://ongetc.com','','');\n";
foreach ($irows as $irow) {
  $url = "''";
  $title = "''";
  $target = "''";
  $icon = "''";
  $iconOpen = "''";
  $openorclose = "false";
  if ($catname=="" or $catname <> $irow->name) {
    $imgid = $imgid + 1;
    $lineid = $lineid + 1;
    $name = "'".$irow->name."'";
    $catid = $lineid;
    echo "\ncotree.add($lineid,0,$name,$url,$title,$target,$icon,$iconOpen,$openorclose);\n";
  }
  $catname = $irow->name;
  $lineid = $lineid + 1;
  $name = "'".$irow->title."'";
  $url = "'".co_set_url($irow)."'";
  $img = co_set_new_or_upd($irow->created,$irow->cmsfolder);
  if ($img == "") { $img = "none"; }
  $icon = "'".$img."'";
  echo "cotree.add($lineid,$catid,$name,$url,$title,$target,$icon,$iconOpen,$openorclose);\n";
}
echo <<<EOT
document.write(cotree);
//document.write(cotree.toString());
</script>
</td></tr></table>
EOT;
}
?>

<?php
function co_mk_menu($irows) {
global $clopath,$clolpath;
echo <<<EOT
<div><TABLE BORDER="0">
EOT;
echo "<STYLE TYPE=\"text/css\">\n";
foreach ($irows as $irow) {
  if ($catname=="" or $catname <> $irow->name) {
    $catid = $catid + 1;
    $catname = $irow->name;
    echo "#menu".$catid." { display : none }\n";
  }
}
echo <<<EOT
a:link {color:black; text-decoration:none}
a:hover {color:blue; text-decoration:underline}
</STYLE>
<tr><TD VALIGN="top" Width="200">
EOT;
$catid = 0;
$catname="";
foreach ($irows as $irow) {
  if ($catname=="" or $catname <> $irow->name) {
    $catid = $catid + 1;
    if ($catid > 1 and $catname <> $irow->name) {
      echo "</SPAN></TD></TR>";
      echo "<tr><TD VALIGN=\"top\" Width=\"200\">";
    }
    $img = co_set_new_or_upd($irow->created,$irow->cmsfolder);
    if ($img == "") { $img = $clopath."/images/".co_set_image($imgid); }
    $img = co_mk_imgsrc($img);
    $catname = $irow->name;
    echo "<SPAN onMouseOver=\"document.all.menu".$catid.".style.display = 'block'\" onClick=\"document.all.menu".$catid.".style.display = 'none'\" onMouseOut=\"document.all.menu".$catid.".style.display = 'block'\">";
    echo "<FONT SIZE=\"-1\"><b>".$catname."</b></font></span><br>";
    echo "<SPAN ID=\"menu".$catid."\" onClick=\"document.all.menu".$catid.".style.display='none'\">";
  }
  echo "\n<FONT SIZE=\"-1\">$img&nbsp;<A HREF=\"".co_set_url($irow)."\">$irow->title"."</A></FONT><BR>";
}
echo <<<EOT
</SPAN></td></tr></table></div>
EOT;
}
?>

<?php
function co_mk_sql($isecid,$icatid,$iorderby,$ishowupdated) {
  $selsecid=$isecid;
  $selcatid=$icatid;
  if ($isecid != "") { $selsecid = "(c.id in ($isecid))"; }
  if ($icatid != "") { $selcatid = "OR (a.catid in ($icatid))"; }
  if ($selsecid != "" or $seccatid!= "") {
    $secorcat = "\nAND (" . $selsecid . $selcatid . ")";
  }
  $tmporder = $iorderby;
  if ($iorderby == "") { $tmporder = "id"; }
  global $mosConfig_offset;
  $now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );
  if ($ishowupdated != "") { $tmpshowdate = "\nAND (a.title_alias >= '". co_diffdaysindate(time(),-($ishowupdated)) ."')";}
  else { $tmpshowdate="";  }
  
  $query = "SELECT b.name, a.catid, a.id, a.title, a.title_alias as cmsfolder, "
    . "\nUNIX_TIMESTAMP(a.created) AS created, UNIX_TIMESTAMP(a.modified) AS modified, c.id as section "
    . "\nFROM #__content as a, #__categories as b, #__sections as c "
    . "\nWHERE (a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= '$now') "
    . "\nAND (a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= '$now') "
    . "\nAND a.state='1' AND a.checked_out='0' "
    . $secorcat
    . $tmpshowdate
    . "\nAND c.id=a.sectionid AND c.id=b.section AND a.catid=b.id" 
    . "\nORDER BY b.".$tmporder." ASC, a.title ASC";
  echo "<!-- $query -->";
  return $query;
}

// cycle through the returned rows displaying them in a table
// with links to the content item
function co_get_contents_per_category($irows,$itype) {
  switch ($itype) {
    case "list": co_mk_list($irows); break; 
    case "bycat": co_mk_bycat($irows); break; 
    case "tree": co_mk_tree($irows); break;
    case "dropdown": co_mk_dropdown($irows); break;
    case "menu": co_mk_menu($irows); break;
    default : co_mk_list($irows); 
  }
}

// cycle through the returned rows displaying them in a table
// with links to the content item
function co_mk_bycat($irows) {
  global $clopath,$clolpath;
  $catname="";
  $catid = 0;
  foreach ($irows as $irow){
    if ($catname=="" or $catname <> $irow->name) {
     $catid = $catid + 1;
     $catname = $irow->name;
     if ($catid>9) {$catid=rand(1,10);}
     if ($catid >1) { echo "<br></div>"; }
     echo "\n<div><b>".$catname."</b>";
    }
    echo co_get_href_and_img($irow,$catid);
  }
  echo "</div>"; 
}

// cycle through the returned rows displaying them in a table
// with links to the content item
function co_mk_list($irows) {
  global $clopath,$clolpath;
  foreach ($irows as $irow){ 
    if ($catname=="" or $catname <> $irow->name) {
     $catid = $catid + 1;
     $catname = $irow->name;
     if ($catid>9) {$catid=rand(1,10);}
    }
    echo co_get_href_and_img($irow,$catid);
  }
}

function co_get_href_and_img($irow,$catid) {
  return "\n<div>".co_set_href_and_img($irow,$catid)."</div>";
}

function co_set_href_and_img($irow,$catid) {
  global $clopath,$clolpath;
  global $cloclass_sfx;
  $newimg = co_set_new_or_upd($irow->created,$irow->cmsfolder);
  $catimg = $clopath."/images/".co_set_image($catid); 
  $newimg = co_mk_imgsrc($newimg);
  $catimg = co_mk_imgsrc($catimg);
  $ret = "$catimg <a href=\"".co_set_url($irow)."\">$irow->title"." $newimg</a>";
  return $ret;
}

function co_set_url($irow) {
global $cloitmid;
$itmid="";
	if ($cloitmid) { $itmid = "&Itemid=".$cloitmid; }
	$co_index = "index.php?option=content&amp;task=view&amp;id=$irow->id".$itmid;
	return sefRelToAbs($co_index);
}

// cycle through the returned rows displaying them in a table
// with links to the content item
function co_mk_dropdown($irows) {
  $jumpid = $irows[0]->id;
  $i = 0;
  echo "<form name=\"jump".$jumpid."\">";
  echo "<select name=\"menu\">";
  foreach ($irows as $irow){
    $i = $i + 1;
    $tmp1 = "<option";
    if ($i == 1) { $tmp1 = $tmp1 . " selected"; }
    $tmp2 = " value=\"".co_set_url($irow);
    echo $tmp1.$tmp2."</option>";
  }
  echo "</select>";
  echo "<input type=\"button\" onClick=\"location=document.jump$jumpid.menu.options[document.jump$jumpid.menu.selectedIndex].value;\" value=\"GO\">";
  echo "</p>";
  echo "</form>";
}


//  set the image file for each content category 
function co_set_image($pcat) {
#  echo "\n<!-- cat: $pcat -->";
  switch ($pcat) {
  case 1:
    $simage = "barrow.gif";
    break;
  case 2:
    $simage = "rarrow.gif";
    break;
  case 3:
    $simage = "zarrow.gif";
    break;
  case 4:
    $simage = "xarrow.gif";
    break;
  case 5:
    $simage = "warrow.gif";
    break;
  case 6:
    $simage = "varrow.gif";
    break;
  case 7:
    $simage = "oarrow.gif";
    break;
  case 8:
    $simage = "tarrow.gif";
    break;
  case 9:
    $simage = "uarrow.gif";
    break;
  default:
    $simage = "karrow.gif";
    break;
  };
  return $simage;
}

function co_set_new_or_upd($newdate,$upddate) {
  global $clopath,$clolpath;
  $img = "";
  if (co_more_than_14days($newdate) == 0) {
    $img = $clopath."/images/new.gif";
  }
  else {
    if ($upddate <> "") {
      $change_date = strtotime($upddate);
      $more_than_14days = co_more_than_14days($change_date);
      if ($more_than_14days == 0) { $img = $clopath."/images/upd.gif"; }
    }
  }
  return $img;
}    

function co_new_or_upd($newdate,$upddate) {
  $newimg = co_set_new_or_upd($newdate,$upddate);
  if ($newimg <> "") { echo co_mk_imgsrc($newimg); }
}

function co_more_than_14days($idate) {
  $diff = co_diffdays(time(),$idate);
  if ($diff < 14)  { $diff = 0; }
  return $diff;
}
?>
