<?php
/**
* IntroText
* Version: 1.0
* Author: Bárbara Irene Meclazcke
* URL:  ewriting.com.ar
* mail: aclaina@yahoo.com.ar
* FileName: admin.introtext.php
* Date: 01/02/2005
* MOS Version #: 4.5.1a
* License: GNU General Public License
**/

// Don't allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );

include($mosConfig_absolute_path.'/administrator/components/com_introtext/com_introtext_settings.php');
include($mosConfig_absolute_path.'/administrator/components/com_introtext/language/'.$mosConfig_lang.'.php');

$introtextver='1.0';
$Post_Secret=md5($mosConfig_absolute_path);

if ($cfidget && !$cfidpost) { $cfid = $cfidget; }
elseif (!$cfidget && $cfidpost) { $cfid = $cfidpost; }

if ($task<>'') { $func = $task; }
elseif ($act<>'') { $func = $act; }

switch ($func) {
	//DISPLAY				
	case 'showintrotext': showintrotext( $func ); break;
	//STORIES ADMIN			
	case 'add': addintrotext ( 0 );	break;
	case 'save': saveintrotext ( $cfid ); break;		
	case 'delete': delintrotext ( $cfid );	break;		
	case 'edit': addintrotext ( $cfid ); break;
	//CONFIG
	case 'introlinkconfig': config( $func ); break;
	case 'saveconfig': saveconfig($catIntroTextC); break;
	default: showintrotext( 'showintrotext' ); break;	
}	//switch ($func)

//****************************************************************************************************
//										DISPLAY
//****************************************************************************************************
//SHOW LINK	TO FRONT ADMIN
function toolbarfront ( $actual )
{	HTML_introtext::toolbarfrontHTML( $actual );
}

//SHOW INTRO LINKS				
function showintrotext( $func )
{	global $database, $mainframe, $mosConfig_absolute_path;
	toolbarfront($func);
	//GET MAMBO VARS
	$limit = intval( mosGetParam( $_REQUEST, 'limit', 10 ) );
	$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
	
	// GET TOTAL NUMBER OF RECORDS
	$database->setQuery( "SELECT count(*) FROM #__introtext_link");
	$total = $database->loadResult();
	echo $database->getErrorMsg();
	//GET LIMIT LIST
	if ($limit > $total) { $limitstart = 0; }
	//GET INTRO LINKS
	$database->setQuery( "SELECT * FROM #__introtext_link ORDER BY namelink LIMIT $limitstart,$limit");
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {	echo $database->stderr(); return; }
	$i=0;
	foreach ($rows as $row){	
		//GET CONTENT NAME
		$database->setQuery( "SELECT title, state FROM #__content WHERE id = $row->contentid" );
		$contentdb=null;
		$enabled = 1;
		if (!($database->loadObject( $contentdb ))) { $pcontent[$i]=_INTROTEXT_NOEXIST; $enabled = 0; }
		else { 
			$pcontent[$i]=$contentdb->title; 
			if ($contentdb->state <> 1) { 
				$enabled = 0;
				$pcontent[$i]="<I>".$pcontent[$i]."</I>"; 
			}			
		}
		//GET MENUS
		$database->setQuery( "SELECT menutype, name, published FROM #__menu WHERE id = $row->menuid" );
		$menudb=null;
		if (!($database->loadObject( $menudb ))) { $pmenu[$i]=_INTROTEXT_NOEXIST; $enabled = 0; }
		else { 
			switch ($menudb->menutype) {
				case 'mainmenu': $pmenu[$i]= _MAINMENU_BOX."/".$menudb->name; break;
				case 'usermenu': $pmenu[$i]= _UMENU_TITLE."/".$menudb->name; break;
				case 'topmenu': $pmenu[$i]= _INTROTEXT_TOPMENU."/".$menudb->name; break;
				case 'othermenu': $pmenu[$i]= _INTROTEXT_OTHERMENU."/".$menudb->name; break;
				default: $pmenu[$i]= $menudb->menutype."/".$menudb->name;
			}
			if ($menudb->published <> 1) {
				$enabled = 0;		
				$pmenu[$i]="<I>".$pmenu[$i]."</I>"; 
			}
		}			
		if (!$enabled) {
			$database->setQuery( "UPDATE #__introtext_link SET enabled=0 WHERE id=$row->id" );
			if (!$database->query()) { echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n"; exit(); }		
		}
		$i++;
	}	
	//CREATE NEW ADMIN PAGE
	require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	HTML_introtext::showintrotextHTML( $rows, $pcontent, $pmenu, $pageNav, getCategoryName() );
}

//****************************************************************************************************
//									INTRO LINKS ADMIN
//****************************************************************************************************
//ADD INTRO LINK					
function addintrotext ( $introid = 0 )
{	global $database, $catIntroText, $mosConfig_offset, $my;
	if (!$catIntroText) { mosRedirect( "index2.php?option=com_introtext&task=showintrotext", _INTROTEXT_ERR_CAT ); return; }	
	if ($introid) {
		//GET LINK
		$database->setQuery( "SELECT * from #__introtext_link WHERE id=$introid" );
		$intro=null;
		$database->loadObject( $intro );
		$contid = $intro->contentid;
		$menuid = $intro->menuid;		
	} else { $contid = 0; $menuid = 0; }

	$now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );	
	// GET CONTENT
	$database->setQuery( "SELECT id AS value, title AS text FROM #__content "
						."WHERE catid = $catIntroText AND state = 1 "
						."AND access <= $my->gid "
						."AND (publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now') "
						."AND (publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now')	"
						."ORDER BY ordering");
	$contsdb = null;
	$contsdb = $database->loadObjectList();
	array_unshift( $contsdb, mosHTML::makeOption( '0', _INTROTEXT_SELECTCONTCATEGORY ) );
	$contlist = mosHTML::selectList( $contsdb, "contid", 'class="inputbox" size="1"', 'value', 'text', $contid );
	// GET MENUS	
	$database->setQuery( "SELECT id, name, menutype, type, link FROM #__menu WHERE published=1 ORDER BY menutype, ordering" );
	$menusdb = $database->loadObjectList();
	$menuid = array(); $menutxt = array();
	$menuid[0] = 0;
	$menutxt[0] = _INTROTEXT_SELECTMENU;
	$i = 1;
	foreach ($menusdb as $menu) {
		if (($menu->type == "url") && (strrpos($menu->link,'Itemid='))) {
			$menuid[$i] = substr( $menu->link, strrpos($menu->link,'Itemid=') + 7 );
		} else {
			$menuid[$i] = $menu->id;	
		}
		switch ($menu->menutype) {
			case 'mainmenu': $menutxt[$i] = _MAINMENU_BOX."/".$menu->name; break;
			case 'usermenu': $menutxt[$i] = _UMENU_TITLE."/".$menu->name; break;
			case 'topmenu': $menutxt[$i] = _INTROTEXT_TOPMENU."/".$menu->name; break;
			case 'othermenu': $menutxt[$i] = _INTROTEXT_OTHERMENU."/".$menu->name; break;
			default: $menutxt[$i] = $menu->menutype."/".$menu->name;
		}				
		$i++;
	}
	
	HTML_introtext::addintrotextHTML ( $intro, $contlist, $menuid, $menutxt ); /*VOY POR ACA*/
}

//SAVE INTRO LINK 			
function saveintrotext ( $introid=0 )
{	global $database;
	//PROCESS THE VARIABLES			
	$namelink=$_POST['namelink'];
	$contid=$_POST['contid'];
	$menuid=$_POST['menuid'];
	
	if (!$contid) { mosRedirect( "index2.php?option=com_introtext&task=showintrotext", _INTROTEXT_ERR_CONT ); return; }
	if (!$menuid) { mosRedirect( "index2.php?option=com_introtext&task=showintrotext", _INTROTEXT_ERR_MENU ); return; }
	
	$namelink=substr($namelink,0,25);
	if ($introid <> 0) {	//UPDATE STORY
		$database->setQuery( "UPDATE #__introtext_link SET namelink='$namelink', contentid=$contid, menuid=$menuid, enabled=1 WHERE id=$introid" );
		if (!$database->query()) { echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n"; exit(); }		
	} else { //NEW STORY
		$database->setQuery( "INSERT INTO #__introtext_link (namelink,contentid,menuid,enabled) VALUES ('$namelink',$contid,$menuid,1)" );
		if (!$database->query()) { echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n"; }
	}		
	//RENEW PAGE
	mosRedirect( "index2.php?option=com_introtext" );	
}	

//DELETE INTRO LINK			
function delintrotext ( $introid = 0 )
{	global $database;
	//IF THERE'S NO SELECTED STORY
	if (!$introid) { mosRedirect( "index2.php?option=com_introtext&task=showintrotext", _INTROTEXT_ERR_DEL ); return; }
	else {
		//DELETE STORY
		$database->setQuery( "DELETE FROM #__introtext_link WHERE id=$introid" );
		if (!$database->query()) { echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n"; }
	}
	//RENEW PAGE
	mosRedirect( "index2.php?option=com_introtext" );	 
}

//****************************************************************************************************
//									CONFIG ADMIN
//****************************************************************************************************
//SHOW CONFIG OPTIONS
function config ( $func )
{	global $database, $catIntroText;
	toolbarfront($func);
	$database->setQuery( "SELECT c.id AS value, CONCAT_WS( '/',s.title, c.title ) AS text "
						."FROM #__categories AS c "
						."LEFT JOIN #__sections AS s ON s.id=c.section "
						."WHERE c.published='1' AND s.scope='content' "
						."ORDER BY c.title");
	$catsdb = null;
	$catsdb = $database->loadObjectList();
	array_unshift( $catsdb, mosHTML::makeOption( '0', '- Select Content Category -' ) );
	$catslist = mosHTML::selectList( $catsdb, "catIntroTextC", 'class="inputbox" size="1"', 'value', 'text', $catIntroText );
	HTML_introtext::configHTML( $catslist );
}

//SAVE CONFIG DATA		
function saveconfig ( $catIntroTextC )
{	global $database, $mosConfig_absolute_path, $catIntroText;
	$configfile = $mosConfig_absolute_path.'/administrator/components/com_introtext/com_introtext_settings.php';
	@chmod ($configfile, 0766);
	if (!is_writable($configfile)) {
    	mosRedirect( "index2.php?option=com_introtext&task=introlinkconfig", _INTROTEXT_CONFIG_ERR );
	    break;
  	}
	if ($catIntroTextC <> $catIntroText) {
		$database->setQuery( "DELETE FROM #__introtext_link" );
		if (!$database->query()) { echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n"; }		
		$catIntroText = $catIntroTextC;
	}
	//GET CONFIG TEXT
	$configtxt = "<?php\n";
	$configtxt .= "\$catIntroText = \"$catIntroText\";\n";	
	$configtxt .= "?>";
	//WRITE CONFIG
	if ($fp = fopen($configfile, "w")) {
		fwrite($fp, $configtxt);
		fclose ($fp);
		mosRedirect( "index2.php?option=com_introtext&task=introlinkconfig", _INTROTEXT_CONFIG_COMP );
	} else {
		mosRedirect( "index2.php?option=com_introtext&task=introlinkconfig", _INTROTEXT_CONFIG_ERR );
	}
}

//****************************************************************************************************
//								EXTRA FUNCTIONS
//****************************************************************************************************

//GET SECTION/CATEGORY NAME
function getCategoryName() 
{	global $database, $catIntroText;
	$thisname = "";
	if ($catIntroText)
	{	$database->setQuery( "SELECT CONCAT_WS( '/',s.title, c.title ) "
							."FROM #__categories AS c "
							."LEFT JOIN #__sections AS s ON s.id=c.section	"
							."WHERE c.id= $catIntroText");
		$thisname=null;
		$thisname = $database->loadResult(  );	
	} 
	return $thisname;
}	 

?>
