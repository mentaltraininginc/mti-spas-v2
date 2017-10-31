<?php
// By: Chanh Ong
// $Id: modulebot.inc,v 1.0.1 2004/06/17 01:34:00 alwarren Exp $
/**
* modulebot mambot
* @Copyright (C) 2004 Al Warren
* @ All rights reserved
* @ Modulebot mambot is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.0.1 $
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Language constants
define( '_MODULEBOT_USAGE', '<b>mosmodule Usage:</b>' );
define( '_MODULEBOT_MODULE_NAME', 'module name' );
define( '_MODULEBOT_SECTION_NAME', 'Section Name' );
define( '_MODULEBOT_POSITION', 'position' );
define( '_MODULEBOT_POSITIONS', ' position = a block position (user1, top, left, etc)' );
define( '_MODULEBOT_LIST', 'display a list of modules and block positions' );
define( '_MODULEBOT_AVAILABLE_MODULES', 'Available Modules' );
define( '_MODULEBOT_AVAILABLE_POSITIONS', 'Available Positions' );

class mosmodulebot {
  function insertBots( $textin, $bots ) {

		// collect the text
		$text = preg_split( "/{(mosmodule)\s*(.*?)}/i", $textin );
		$textout = $text[0];
		
		//process the bots
		$args = array();
		$n = count($bots);
		for($i=0; $i<=$n-1; $i++) {
			$textout .= mosmodulebot::processBot($bots[$i][0]);
			$textout .= $text[$i+1];
		}
		return $textout;
  }

  function processBot( $thisbot ) {
	global $database, $mainframe;

	// define positions for module blocks
	$sql = "SELECT DISTINCT position from #__modules ORDER BY position";
	$database->setQuery( $sql );
	$positions = $database->loadResultArray();

	// split out the arguments
	preg_match_all( "/{(mosmodule)\s*(.*?)}/i", $thisbot, $bot, PREG_SET_ORDER );

	$text = '';
	$args = $bot[0][2];	// module=module title or module block position or list
	$options = explode('=', $bot[0][2]);
	$option = strtolower( $options[0] ? $options[0] : $options[1] );

	$task = in_array($option, $positions) ? 'block' : $option;
	$task = in_array($option, $positions) ? 'block' : $option;
	$task = $option=='list' ? $option : $task;
	switch ($task) {
		case 'section':
                        $args = explode('=', $args);
                        $text = mosmodulebot::loadsection( $args[1]);
                        break;
		case 'module':
			$args = explode('=', $args);
			$module = mysql_escape_string($args[1]);
			if ( $module == 'newsflash' && class_exists( 'newsflash_html' ) ) {
				return $text;
			}
			ob_start();
			mosmodulebot::loadModule( $module );
			$text = ob_get_contents();
			ob_end_clean();
			break;
		case 'block':
			if (mosCountModules( $option )) {
				ob_start();
				mosLoadModules ( $option );
				$text = ob_get_contents();
				ob_end_clean();
			}
			break;
		case 'list':
		default:
			$text = mosmodulebot::listModules( $positions );
			break;
	}
	return $text;
  }

  function loadModule( $thismodule ) {
	global $database, $mainframe, $my, $mosConfig_absolute_path, $Itemid;
	require_once( "$mosConfig_absolute_path/includes/frontend.html.php" );

	$sql = "SELECT id, title, module, position, content, showtitle, params"
	."\nFROM #__modules"
	. "\nWHERE access <= '$my->gid'"
	. "\nAND title='$thismodule' LIMIT 1";

	$database->setQuery( $sql );
	$module = $database->loadObjectList();
	if($database->getErrorNum()) {
		echo "MA ".$database->stderr(true);
		return;
	}
	if ( count($module) ) {
		$module = $module[0];
#		$params = mosParseParams( $module->params );
 $params =& new mosParameters( $module->params );
		if ((substr("$module->module",0,4))=="mod_") {
			modules_html::module2( $module, $params, $Itemid );
		} else {
			modules_html::module( $module, $params, $Itemid );
		}
	}
  }

  function listModules( $positions ) {
	global $database, $my;
	$sql = "SELECT title FROM #__modules WHERE access <= '$my->gid' ORDER BY title";
	$database->setQuery($sql);
	$modules = $database->loadResultArray();
	$text  = _MODULEBOT_USAGE;
	$text .= "<br />{mosmodule section=" . _MODULEBOT_SECTION_NAME . "}";
	$text .= "<br />{mosmodule module=" . _MODULEBOT_MODULE_NAME . "}";
	$text .= "<br />{mosmodule position} - ". _MODULEBOT_POSITIONS;
	$text .= "<br />{mosmodule list} -  " . _MODULEBOT_LIST;
	$text .= "<br /><br />";
	$text .= "<table align='center' cellpadding='4' border='0'>";
	$text .= "<tr>";
	$text .= "<th>". _MODULEBOT_AVAILABLE_MODULES;
	$text .= "</th>";
	$text .= "<th>". _MODULEBOT_AVAILABLE_POSITIONS;
	$text .= "</th>";
	$text .= "</tr>";
	$text .= "<tr><td valign='top'>";
	foreach ($modules as $module) {
		$text .= "$module <br />";
	}
	$text .= "</td><td valign='top'>";
	foreach ($positions as $position) {
		$text .= "$position <br />";
	}
	$text .= "</td></tr>";
	$text .= "</table>";
	return $text;
  }

 function loadsection( $sectionname) {
        global $database, $my;
        $sql = "SELECT b.Name, a.Title, concat(a.introtext, a.fulltext) as Article";
        $sql = $sql." FROM  #__content AS a, #__sections AS b";
        $sql = $sql." WHERE b.id=a.sectionid and b.Name LIKE '$sectionname'";
        $sql = $sql." ORDER BY RAND() LIMIT 1";
        $database->setQuery($sql);
        $rows = $database->loadObjectList(); 
        foreach ($rows as $row) {
//          $article = str_replace("{mosaddphp:googleadssm.php}", "", $row->Article);
          $article = $row->Article;
          $text .= "<b>$row->Title</b> <br />$article<br />";
        }               
                        
        return $text;   
  }               
}
?>
