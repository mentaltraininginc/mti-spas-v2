<?php
/**
* Name: Show SubMenu Children
* Version: 1.0
* Author: Mike Teigen
* CreationDate: 21/09/2005
* This module is released under the GNU/GPL License
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$menuclass = $params->get( 'class_sfx' );

$sql = "SELECT id FROM #__menu "
	. "\nWHERE parent='$Itemid'";
		
$database->setQuery( $sql );
		
$rows1 = $database->loadResult();
		
if($rows1){
	$parent1 = $Itemid;
}
else {
	$sql = "SELECT parent FROM #__menu "
		. "\nWHERE id='$Itemid'";
		
	$database->setQuery( $sql );
	
	$rows1 = $database->loadResult();
	$parent1 = $rows1;
}
		
$sql = "SELECT name FROM #__menu "
	. "\nWHERE id='$parent1'";
		
$database->setQuery( $sql );
		
$rows1 = $database->loadResult();
if(!$rows1){
	$parent1 = "0";
	$menuname = "Main Menu";
} else {
	$menuname = $rows1;
}
		
$sql = "SELECT m.* FROM #__menu AS m"
	. "\nWHERE published=1 AND parent='$parent1' AND menutype='mainmenu'"
	. "\nORDER BY ordering";

$database->setQuery( $sql );

$rows = $database->loadObjectList( 'id' );
foreach ($rows as $p ) {
	$content = vert_submenu_list( $rows , $menuclass, $menuname );
}

function vert_submenu_list( $data , $class, $menuname ) {
$html = "<tr>
	<th valign=\"top\">$menuname</th>
	</tr>";
foreach ($data as $v ) {
	if ($v->type != 'url') {
			$v->link .= "&amp;Itemid=$v->id";
		}
		
		$theLink = str_replace('&amp;', '##########', $v->link);
		$theLink = str_replace('&', '&amp;', $theLink);
		$theLink = str_replace('##########', '&amp;', $theLink);
		$theLink = sefRelToAbs($theLink);
	
		$html = $html . "<tr align=\"left\"><td><a href=\"$theLink\" class=\"$class\">$v->name</a></td></tr>";
	}
	return $html;
}
?>