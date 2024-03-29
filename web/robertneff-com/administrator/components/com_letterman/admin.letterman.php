<?php
// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Letterman Newsletter Component
* 
* @package Letterman
* @author soeren
* @copyright Soeren Eberhardt <soeren@virtuemart.net>
    (who just needed an easy and *working* Newsletter component for Mambo 4.5.1 and mixed up Newsletter and YaNC)
* @copyright Mark Lindeman <mark@pictura-dp.nl> 
    (parts of the Newsletter component by Mark Lindeman; Pictura Database Publishing bv, Heiloo the Netherland)
* @copyright Adam van Dongen <adam@tim-online.nl>
    (parts of the YaNC component by Adam van Dongen, www.tim-online.nl)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

global $mosConfig_lang, $mosConfig_absolute_path, $lm_params;

$GLOBALS['lm_version'] = '1.2.3';
$GLOBALS['lm_home'] = 'http://developer.joomla.org/sf/sfmain/do/viewProject/projects.letterman';

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

// Load configuration in constructor
$letterman = new mosLetterman($database);

if( !@include_once( $mosConfig_absolute_path ."/administrator/components/com_letterman/language/$mosConfig_lang.messages.php" ) ) {
	include_once( $mosConfig_absolute_path ."/administrator/components/com_letterman/language/english.messages.php" );
}

$cid = mosGetParam( $_POST, 'cid', array(0) );
$task = mosGetParam( $_REQUEST, 'task' );
$no_html = mosGetParam( $_REQUEST, 'no_html' );

if (!is_array( $cid )) {
	$cid = array(0);
}
if(!$no_html) {
	HTML_Letterman::header();
}

switch( $task ) {
	case "new":
		editNewsletter( 0, $option);
		break;
	case "edit":
		editNewsletter( $cid[0], $option );
		break;
	case 'compose':
		HTML_letterman::composeNewsletter();
		break;
	case 'composeNow':
		composeNow();
		break;
	case "save":
		saveNewsletter( $option );
		break;
	case "remove":
		removeNewsletter( $cid, $option );
		break;
	case "publish":
		publishNewsletter( $cid, 1, $option );
		break;
	case "unpublish":
		publishNewsletter( $cid, 0, $option );
		break;
	case "cancel":
		cancelNewsletter( $option );
		break;
	case "sendNow":
		lm_sendNewsletter( $cid[0], $option );
		break;
	case "sendMail":
		lm_sendMail();
		break;
		
	//subscriber management
	case "subscribers":
		listSubscribers();
		break;
	case "editSubscriber":
		HTML_Letterman::editSubscriber( $cid[0] );
		break;
	case "saveSubscriber":
		saveSubscriber();
		break;
	case "assignUsers":
		assignUsers();
		break;
	case "deleteSubscriber":
		if( sizeof( $_REQUEST['cid'] > 1 )) {
			deleteSubscribers();
		}
		else {
			deleteSubscriber( $cid[0] );
		}
		break;
	case "importSubscribers":
		importSubscribers();
		break;
	case "exportSubscribers":
		doExport();
		break;
	case 'fixSubscribers':
		syncSubscribersToUsers();
		break;
	case 'validateEmails':
		validateEmailAddresses( $cid );
		break;
		
	// Configuration
	case 'config':
		showConfig( $option );
		break;
	case 'saveconfig':
		saveSettings( $option );
		break;
	case 'cancelconfig':
		cancelSettings( $option );
		break;
		
		
	default:
		viewNewsletter( $option );
		break;
}
HTML_letterman::footer();

function viewNewsletter( $option) {
	global $database, $mainframe;

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	$where = "";
	if ($search) {
		$where = " WHERE a.subject LIKE '%$search%' OR a.message LIKE '%$search%'";
	}

	$database->setQuery( "SELECT COUNT(*) FROM #__letterman AS a $where" );
	$total = $database->loadResult();

	require_once( "includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$sql = "SELECT
        a.*, u.name AS editor, g.name AS groupname"
	. "\nFROM #__letterman AS a"
	. "\nLEFT JOIN #__users AS u ON u.id=a.checked_out"
	. "\nLEFT JOIN #__groups AS g ON g.id = a.access"
	. "\n$where ORDER BY created DESC LIMIT $pageNav->limitstart,$pageNav->limit";
	$database->setQuery( $sql );
	$rows = $database->loadObjectList();

	HTML_Letterman::showNewsletter( $rows, $search, $pageNav, $option );
}

function composeNow() {
	global $mosConfig_absolute_path, $_MAMBOTS;
	
	if( !function_exists( "sefRelToAbs" )) {
		include_once( $mosConfig_absolute_path."/administrator/components/com_letterman/includes/sef.php" );
	}
	if( get_magic_quotes_gpc() ) {
		$nl_content = stripslashes( mosGetParam( $_POST, 'nl_content' ));
	}
	else {
		$nl_content = mosGetParam( $_POST, 'nl_content' );
	}
	require_once( $mosConfig_absolute_path.'/administrator/components/com_letterman/includes/contentRenderer.class.php' );
	$renderer = new lm_contentRenderer();
	
	$content = $renderer->getContent( $nl_content );
	
	HTML_letterman::composeNewsletter( $content );
}

function editNewsletter( $uid, $option ) {
	global $database, $my;

	$row = new mosLetterman( $database );
	// load the row from the db table
	$row->load( $uid );

	if ($uid) {
		$row->checkout( $my->id );
	} else {
		// initialise new record
		$row->published = 0;
	}

	// make the select list for the image positions
	$yesno[] = mosHTML::makeOption( '0', 'No' );
	$yesno[] = mosHTML::makeOption( '1', 'Yes' );

	// build the html select list
	$publist = mosHTML::selectList( $yesno, 'published', 'class="inputbox" size="2"',
	'value', 'text', $row->published );

	// get list of groups
	$database->setQuery( "SELECT id AS value, name AS text FROM #__groups ORDER BY id" );
	$groups = $database->loadObjectList();	if (!($orders = $database->loadObjectList())) {
		echo $database->stderr();
		return false;
	}

	// build the html select list
	$glist = mosHTML::selectList( $groups, 'access', 'class="inputbox" size="1"',
				'value', 'text', intval( $row->access ) );


	HTML_Letterman::editNewsletter( $row, $publist, $option , $glist );
}

function saveNewsletter( $option ) {
	global $database, $my;

	$row = new mosLetterman( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();

	mosRedirect( "index2.php?option=$option" );
}

/**
* Publishes or Unpublishes one or more records
* @param database A database connector object
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The current url option
*/
function publishNewsletter( $cid=null, $publish=1, $option ) {
	global $database, $my;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__letterman SET published='$publish'"
	. "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosLetterman( $database );
		$row->checkin( $cid[0] );
	}
	mosRedirect( "index2.php?option=$option" );
}

/**
* Deletes one or more records
* @param array An array of unique category id numbers
* @param string The current url option
*/
function removeNewsletter( $cid, $option ) {
	global $database;

	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$database->setQuery( "DELETE FROM #__letterman WHERE id IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}

	mosRedirect( "index2.php?option=$option" );
}

/**
* Cancels an edit operation
* @param string The current url option
*/
function cancelNewsletter( $option ) {
	global $database;
	$row = new mosLetterman( $database );
	$row->bind( $_POST );
	$row->checkin();
	mosRedirect( "index2.php?option=$option" );
}


/**
 * BEGIN OF THE SUBSCRIBER SECTION
 *
 */
function listSubscribers() {
	global $mosConfig_list_limit, $mainframe, $database, $mosConfig_absolute_path, $my;
	$option = mosGetParam( $_REQUEST, 'option');
	$orderby = mosGetParam($_REQUEST, 'orderby', 'subscriber_name');
	$sort = mosGetParam($_REQUEST, 'ordering', 'ASC');

	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( $search ) );

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
/**
	$q_registered = "SELECT * FROM `#__letterman_subscribers`, `#__users` WHERE user_id = id";
	$database->setQuery( $q_registered );
	$registered_subscribers = $database->loadObjectList();
*/
	if( !empty( $search ) ) {
		$q_search = "WHERE (subscriber_name LIKE '%$search%' OR subscriber_email LIKE '%$search%')";
	}
	else {
		$q_search = "";
	}
	$q_all = "SELECT * FROM `#__letterman_subscribers` $q_search ORDER BY $orderby $sort, subscriber_id ASC";
	
	$database->setQuery( $q_all );
	$subscribers = $database->loadObjectList();

	$total = sizeof( $subscribers );
	require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );
	$limitstart = $pageNav->limitstart;
	$q_search = "SELECT * FROM `#__letterman_subscribers` $q_search ORDER BY $orderby $sort, subscriber_id ASC LIMIT ".$limitstart.", ".$limit;
	$database->setQuery( $q_search );
	$rows = $database->loadObjectList();
	
	HTML_letterman::showSubscribers( $rows, $pageNav, $orderby, $sort, $search );
}

function assignUsers() {
	global $database;

	$q = "SELECT id, name, username, email 
			FROM `#__users` 
			LEFT JOIN `#__letterman_subscribers` 
				ON id = user_id OR email=subscriber_email 
			WHERE user_id IS NULL
			ORDER BY name ASC, username ASC
			LIMIT 0, 1000";
	$database->setQuery( $q );

	$rows = $database->loadObjectList();

	HTML_Letterman::assignUsers( $rows );
}

function saveSubscriber() {
	global $database;
	
	$orderby = mosGetParam($_REQUEST, 'orderby', 'subscriber_name');
	$sort = mosGetParam($_REQUEST, 'ordering', 'ASC');
		
	$selectedUsers = mosGetParam( $_POST, 'selectedUsers'  );

	if( is_array( $selectedUsers )) {
		$_REQUEST['mosmsg'] = LM_SUBSCRIBER_SAVED;
		foreach( $selectedUsers as $user_id ) {
			$q = "SELECT email, name FROM #__users WHERE id='$user_id'";
			$database->setQuery( $q );
			$database->loadObject( $user );
			$subscriber =& new mosLettermanSubscribers($database);
			$subscriber->user_id = $user_id;
			$subscriber->subscriber_name = $user->name;
			$subscriber->subscriber_email = $user->email;
			$subscriber->confirmed = "1";
			$subscriber->subscribe_date = date( "Y:m:d h:i:s", time() );
			if( !$subscriber->store() ) {
				$_REQUEST['mosmsg'] .= "Error storing User ".$user->name;
			}
		}
		mosRedirect( "index2.php?option=com_letterman&task=subscribers", $_REQUEST['mosmsg']);
	}
	elseif( !empty( $_POST['subscriber_email'] )) {
		$row = new mosLettermanSubscribers( $database );
		// load the row from the db table
		if (!$row->bind( $_POST )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$row->subscribe_date = date( "Y-m-d H:i:s" );

		if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if(empty($row->subscriber_id)){
			$row->subscriber_id = $database->insertid();
		}

		$error = $database->getErrorMsg();

		if(!empty($error)){
			echo "<script> alert('".LM_ERROR_EMAIL_ALREADY_ONLIST."'); location.href = 'index2.php?option=com_letterman&task=subscribers'; </script>\n";
			exit();
		}
		else {
			mosRedirect( "index2.php?option=com_letterman&task=subscribers&ordering=$sort&orderby=$orderby", LM_SUBSCRIBER_SAVED);
		}
	}
	else {
		mosRedirect( "index2.php?option=com_letterman&task=subscribers&ordering=$sort&orderby=$orderby" );
	}
}
	
function deleteSubscribers(){
	global $database;
	
	$orderby = mosGetParam($_REQUEST, 'orderby', 'subscriber_name');
	$sort = mosGetParam($_REQUEST, 'ordering', 'ASC');
	
	$cid = implode(", ", $_REQUEST['cid']);
	$count = sizeof( $_REQUEST['cid']);
	$query = "DELETE FROM #__letterman_subscribers WHERE subscriber_id IN (" . $cid . ")";
	$database->setQuery($query);
	$database->query();

	$error = $database->getErrorMsg();
	if(!empty($error)){
		echo "<script type=\"text/javascript\"> alert('". $error ."'); </script>\n";
		exit();
	}
	$msg = str_replace( "{X}", $count, LM_SUBSCRIBERS_DELETED);
	mosRedirect( "index2.php?option=com_letterman&task=subscribers&ordering=$sort&orderby=$orderby", $msg);
}

function deleteSubscriber( $id){
	global $database;
	
	$orderby = mosGetParam($_REQUEST, 'orderby', 'subscriber_name');
	$sort = mosGetParam($_REQUEST, 'ordering', 'ASC');
	
	//subscribers
	$query = "DELETE FROM #__newsletter_subscribers WHERE subscriber_id = " . $id;
	$database->setQuery($query);
	$database->query();

	$error = $database->getErrorMsg();
	if(!empty($error)){
		echo "<script> alert('". $error ."'); </script>\n";
		exit();
	}
	mosRedirect( "index2.php?option=com_letterman&task=subscribers&ordering=$sort&orderby=$orderby", LM_SUBSCRIBER_DELETED);
}

function doExport() {
	global $database, $mosConfig_absolute_path;

	// Workaround for GZIP = On
	if( stristr( $_SERVER['PHP_SELF'], "index2" ) ) {
		mosRedirect( "index3.php?option=com_letterman&task=exportSubscribers&no_html=1" );
	}

	if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
		$UserBrowser = "Opera";
	}
	elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
		$UserBrowser = "IE";
	} else {
		$UserBrowser = '';
	}
	$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';

	$filename = "BackupList_Letterman_from_" . date('d-m-Y');

	$output = '<?xml version="1.0" encoding="ISO-8859-1" ?>
				  <!-- Letterman export file -->
				  <!DOCTYPE subscribers [
				  <!ELEMENT subscribers (subscriber+)>
				  <!ELEMENT subscriber (subscriber_id, name, email, confirmed, subscribe_date)>
				  <!ELEMENT subscriber_id (#PCDATA)>
				  <!ELEMENT name (CDATA)>
				  <!ELEMENT email (#PCDATA)>
				  <!ELEMENT confirmed (#PCDATA)>
				  <!ELEMENT subscribe_date (#PCDATA)>
				  ]>
				  <subscribers>
				  ';
	$q = "SELECT subscriber_id,subscriber_name,subscriber_email,confirmed,subscribe_date FROM #__letterman_subscribers ORDER BY subscriber_name ASC";
	$database->setQuery( $q );
	$subscribers = $database->loadObjectList();

	foreach ($subscribers AS $subscriber){
		$output .= "  <subscriber>\n";
		$output .= "    <subscriber_id>" . $subscriber->subscriber_id . "</subscriber_id>\n";
		$output .= "    <name><![CDATA[" . htmlentities(html_entity_decode($subscriber->subscriber_name)) . "]]></name>\n";
		$output .= "    <email>" . $subscriber->subscriber_email . "</email>\n";
		$output .= "    <confirmed>" . $subscriber->confirmed . "</confirmed>\n";
		$output .= "    <subscribe_date>" . $subscriber->subscribe_date . "</subscribe_date>\n";
		$output .= "  </subscriber>\n";
	}
	$output .= "</subscribers>";


	//send file to browser

	@ob_end_clean();
	ob_start();

	header('Content-Type: ' . $mime_type);
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

	if ($UserBrowser == 'IE') {
		header('Content-Disposition: inline; filename="' . $filename . '.xml"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	}
	else {
		header('Content-Disposition: attachment; filename="' . $filename . '.xml"');
		header('Pragma: no-cache');
	}
	print $output;
	exit();
}

function importSubscribers() {
	global $database, $mosConfig_absolute_path, $mosConfig_live_site, $option, $mosConfig_cachepath;
	//send mailing to an entered emailadres
	if(!empty($_FILES['xmlfile']) && !empty($_FILES['cvsfile'])){
		@ini_set('memory_limit', '16M');
?>
     <table class="adminheading">
		<tr>
			<th><?php echo LM_IMPORT_USERS ?></th>
		</tr>
		</table>
    
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
      <th colspan="2" class="title">&nbsp;</th>
    </tr>
    <tr>
      <td>
<?php
if(!empty($_FILES['xmlfile']['name'])){
	if($_FILES['xmlfile']['type'] == "text/xml"){
		$filename = $_FILES['xmlfile']['name'];
		
		$path = $mosConfig_cachepath . '/';
		if( is_writable($path) ) {

			if(!move_uploaded_file($_FILES['xmlfile']['tmp_name'], $path . $filename)) {
				print "<font class=\"error\">".LM_UPLAOD_FAILED.": " . $_FILES['xmlfile']['error'] . "</font><br>\n";
			}
			else {
				// We could need this later, when utf-8 is fully supported
				$iso  = explode ('=', _ISO );
				$iso = strtolower( $iso[1] );
				$data = file_get_contents( $path . $filename );
				
				$data = str_replace( '&amp;', '&', $data );
				
				if( !stristr( $data, '<name><![CDATA[')) {
					$data = str_replace( '<name>', '<name><![CDATA[', $data );
					$data = str_replace( '</name>', ']]></name>', $data );
					$data = str_replace( '<name><![CDATA[<![CDATA[', '<name><![CDATA[', $data );
					$data = str_replace( ']]>]]></name>', ']]></name>', $data );
				}
				
				/* XML Parsing */
				require_once( $mosConfig_absolute_path. '/includes/domit/xml_domit_lite_include.php' );
				$xmlDoc =& new DOMIT_Lite_Document();
				//if( $iso == 'utf-8' ) {
				//	$res = $xmlDoc->parseXML_utf8( $data, false, true ); 
				//}
				//else {
					$res = $xmlDoc->parseXML( $data, false, true ); 
				//}
				if( !$res ) {
					mosRedirect( 'index2.php?option=com_letterman&task=importSubsribers', LM_ERROR_PARSING_XML );
				}
				
				$nodelist = $xmlDoc->getElementsByTagName( "subscriber" );
				
				if($nodelist->getLength() > 0){
					$count = 0;
					$num = $nodelist->getLength();
					if( $num > 0 ) {
						$q = "REPLACE INTO #__letterman_subscribers VALUES ";
					}
					
					for ($i = 0; $i < $num; $i++) {
						$currNode =& $nodelist->item($i);
						$subscriber['subscriber_id'] = $currNode->childNodes[0]->getText();
						$subscriber['name'] = html_entity_decode( $currNode->childNodes[1]->getText());
						$subscriber['email'] = $currNode->childNodes[2]->getText();
						$subscriber['confirmed'] = $currNode->childNodes[3]->getText();
						$subscriber['subscribe_date'] = $currNode->childNodes[4]->getText();

						if( !empty( $subscriber['email'] )) {
							if( empty( $subscriber['name'])) {
								$subscriber['name'] = LM_SUBSCRIBER;
							}
							$q .= "( '"
							. $subscriber['subscriber_id'] . "', '', '"
							. $subscriber['name'] . "', '"
							. $subscriber['email'] . "', '"
							. $subscriber['confirmed'] . "', '"
							. $subscriber['subscribe_date'] . "')";
							if( $i+1 < $num ) {
								$q .= ", \n";
							}
							else {
								$q .= "; ";
							}
						}

						$count++;
					}
		
					$database->setQuery($q);
					$database->query();
					/*$error = $database->getErrorNum();
					if( $error ) {
						if($error == 1062){
							echo '<span class="error">' . LM_ERROR_EMAIL_ALREADY_ONLIST . ": ".$subscriber['email']."'. </span><br />";
						}
						else{
							echo $database->getErrorMsg() . "<br />\n";
						}
					}*/
				
					$msg = str_replace( "{X}", $count, LM_SUCCESS_ON_IMPORT );
					echo "<span class=\"message\">$msg</span><br /><br />".LM_IMPORT_FINISHED."<br />
          	    <a href=\"index2.php?option=com_letterman&task=subscribers\">"._CMN_CONTINUE."</a>"; 
				}

				if( !unlink($path . $filename) ) {
					print"<font class=\"error\">" . LM_ERROR_DELETING_FILE . ": $path | $filename.</font><br>\n";
				}
			}
		}
		else {
			echo '<span class="error">' . LM_DIR_NOT_WRITABLE . '</span>';
		}
	}
	else{
		echo '<span class="error">'.LM_ERROR_NO_XML.'</span>';
	}
}
else{
	if(
	($_FILES['cvsfile']['type'] == "application/octet-stream") ||
	($_FILES['cvsfile']['type'] == "application/vnd.ms-excel")
	){
		$filename = $_FILES['cvsfile']['name'];

		$path = $mosConfig_cachepath . '/';
		if(is_writable($path)){

			if(!move_uploaded_file($_FILES['cvsfile']['tmp_name'], $path . $filename)){
				echo "<span class=\"error\">".LM_UPLAOD_FAILED.": " . $_FILES['cvsfile']['error'] . "</span><br>\n";
			}
			else{
				//print_r($_FILES);
				$name_column = mosGetParam($_POST, 'name_column', '1');
				$address_column = mosGetParam($_POST, 'address_column', '2');
				$delim = mosGetParam($_POST, 'delimiter', ';');
				$offset = mosGetParam($_POST, 'record_number', 1);
				$offset = $offset - 1; //default an array starts at 0 in stead of 1
				$name_column = $name_column - 1; //default an array starts at 0 in stead of 1
				$address_column = $address_column - 1; //default an array starts at 0 in stead of 1
				$content = file($path . $filename);


				if(sizeof($content) > 0){
					for($i = $offset; $i < sizeof($content); $i++){

						$subscriber = explode($delim, $content[$i]);
						//var_dump($subscriber);
						$subscriber[$address_column] = ltrim(rtrim($subscriber[$address_column]));
						$subscriber[$address_column] = str_replace('"', '', $subscriber[$address_column]);
						$subscriber[$name_column] = str_replace('"', '', $subscriber[$name_column]);
						if(!empty($subscriber[$address_column])){
							//echo $subscriber[$address_column] . ": ". intval(check_email_address($subscriber[$address_column])) .'<br />';
							if(check_email_address($subscriber[$address_column])){
								$query = "REPLACE INTO #__letterman_subscribers (subscriber_name, subscriber_email, confirmed, subscribe_date)
              	      VALUES('". addslashes($subscriber[$name_column]) . "', '". addslashes($subscriber[$address_column]) . "', '1', NOW());";
								$database->setQuery($query);
								$database->query();
								$error = $database->getErrorNum();
								if($error){
									if($error == 1062){
										echo '<span class="error">' . LM_ERROR_EMAIL_ALREADY_ONLIST . ": ".$subscriber['email']."'. </span><br />";
									}
									else{
										echo $database->getErrorMsg() . "<br />\n";
									}
								}
							}
							else{
								echo '<span class="error"><b>'.LM_ERROR_INVALID_EMAIL.':</b> ' . $subscriber[$address_column] . '</span><br />';
							}
						}
						else{
							echo '<span class="error">'.LM_ERROR_EMPTY_EMAIL.':' . $subscriber[$name_column] . '</span><br />';
						}
					}
					echo '<br /><br />'.LM_IMPORT_FINISHED.'<br />
          	    <a href="index2.php?option=com_letterman&task=subscribers">'._CMN_CONTINUE.'</a>'; 
				}
				else{
					echo '<font class="error">'.LM_ERROR_EMPTY_FILE.'</font><br />';
				}

				if(!unlink($path . $filename)){
					print"<font class=\"error\">" . LM_ERROR_DELETING_FILE.": ".$path ." | ". $filename . ".</font><br>\n";
				}
			}
		}
		else{
			echo '<span class="error">' . LM_DIR_NOT_WRITABLE . '</span><br />';
		}
	}
	else{
		echo '<span class="error">'.LM_ERROR_ONLY_TEXT.'</span><br />';
	}
}
?>
    </td>
  </tr>
  </table>
<?php
	}
	else{
?>
    <table class="adminheading">
		<tr>
			<th><?php echo LM_SELECT_FILE ?>:</th>
		</tr>
		</table>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
    <form action="index2.php" method="POST" name="adminForm" enctype="multipart/form-data">
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="task" value="importSubscribers" />
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
      <th colspan="3" class="title">&nbsp;</th>
    </tr>
    <tr>
      <td width="200" colspan="2"><strong><?php echo LM_YOUR_XML_FILE ?>: </strong></td>
      <td><input type="file" name="xmlfile"></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </td>
    <tr>
      <td width="200" colspan="2"><strong><?php echo LM_YOUR_CSV_FILE ?>: </strong></td>
      <td><input type="file" name="cvsfile"></td>
    </tr>
    <tr>  
		  <td width="20" valign="top"><?php echo mosToolTip(LM_POSITION_NAME); ?></td>    
      <td><?php echo LM_NAME_COL ?>:</td>
      <td><input type="text" name="name_column" size="2" value="1" /></td>
    </tr>
    <tr>
		  <td width="20" valign="top"><?php echo mosToolTip(LM_POSITION_EMAIL); ?></td>
      <td><?php echo LM_EMAIL_COL ?>:</td>
      <td><input type="text" name="address_column" size="2" value="2" /></td>
    </tr>
    <tr>
		  <td width="20" valign="top"><?php echo mosToolTip(LM_STARTFROM); ?></td>
      <td><?php echo LM_STARTFROMLINE ?>:</td>
      <td><input type="text" name="record_number" size="2" value="1" /></td>
    </tr>
    <tr>
		  <td width="20" valign="top"><?php echo mosToolTip(LM_CSV_DELIMITER_TIP); ?></td>
      <td><?php echo LM_CSV_DELIMITER ?>:</td>
      <td><input type="text" name="delimiter" size="2" value=";"/></td>
    </tr>
    </table>
    </form>
<?php
	}
}

function syncSubscribersToUsers() {
	global $database;
	
	// First step: Find registered users who are subscribed, but have an empty user_id entry
	$q = 'SELECT subscriber_id, name, email, id FROM `#__letterman_subscribers`, `#__users` WHERE email=subscriber_email AND user_id = 0 GROUP BY subscriber_id';
	$database->setQuery( $q );	
	$usersToFix = $database->loadObjectList();
	$fixed_ids = 0;
	if( $usersToFix) {
		foreach ( $usersToFix as $user) {
			$q = 'UPDATE `#__letterman_subscribers` SET user_id ='.$user->id.', subscriber_name=\''.$user->name.'\' WHERE subscriber_id='.$user->subscriber_id;
			$fixed_ids++;
		}
	}
	
	// Second step: Find unconfirmed accounts of registered users who have changed their email address since newsletter subscription
	$q = 'SELECT subscriber_email, email, subscriber_id
			FROM `#__letterman_subscribers` , `#__users`
			WHERE user_id = id
			AND email != subscriber_email
			AND confirmed =0';
	$database->setQuery($q);
	$usersToFix = null;
	$usersToFix = $database->loadObjectList();
	$fixed_emails = 0;
	if( $usersToFix) {
		foreach ( $usersToFix as $user) {
			$q = 'UPDATE `#__letterman_subscribers` SET subscriber_email =\''.$user->email.'\', confirmed=1 WHERE subscriber_id='.$user->subscriber_id;
			$fixed_emails++;
		}
	}
	
	$msg = 'Fixed '.$fixed_ids.' user_id(s) and updated '.$fixed_emails.' email address(es).';
	
	mosRedirect( 'index2.php?option=com_letterman&task=subscribers', $msg );	
}


function validateEmailAddresses( $cid ) {
	global $database, $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_mailfrom;
	
	require_once( $mosConfig_absolute_path.'/administrator/components/com_letterman/includes/email_validation.php');
	$validator =& new email_validation_class();
	
	$tmp = explode( '@', $mosConfig_mailfrom );
	$mailuser = $tmp[0];
	$mailserver = $tmp[1];
	
	$validator->timeout=5;
	$validator->data_timeout=0;
	$validator->localuser=$mailuser;
	$validator->localhost=$mailserver;
	$validator->debug=0;
	$validator->html_debug=1;
	$validator->exclude_address="";
		
	$results = array();
	
	foreach( $cid as $subscriber_id ) {
		$subscriber = new mosLettermanSubscribers( $database );
		$subscriber->load( $subscriber_id );
	
		$results[$subscriber_id]['email'] = $subscriber->subscriber_email;
		$results[$subscriber_id]['name'] = $subscriber->subscriber_name;
		
		if( $subscriber->confirmed == 1 || strstr( $subscriber->subscriber_name, 'INVALID_') ) {
			// Skip confirmed email addresses!
			$results[$subscriber_id]['result'] = 2;
			$results[$subscriber_id]['result_txt'] = 'skipped';
			continue;
		}
		$res = $validator->ValidateEmailBox( $subscriber->subscriber_email );
		if( $res === -1) {
			$results[$subscriber_id]['result'] = -1;
			$results[$subscriber_id]['result_txt'] = 'Unable to validate the address with this host.';
		}
		elseif( $res ) {
			$results[$subscriber_id]['result'] = 1;
			$results[$subscriber_id]['result_txt'] = 'The host is able to receive email. The address could be valid.';
			$subscriber->confirmed = 1;
			$subscriber->store();
		}
		else {
			$results[$subscriber_id]['result'] = 0;
			$results[$subscriber_id]['result_txt'] = 'The host can\'t receive email or this mailbox doesn\'t exist. The address is NOT valid.';
			$subscriber->subscriber_name = 'INVALID_'.$subscriber->subscriber_name;
			$subscriber->store();
		}
	}
	HTML_letterman::showValidationResults( $results );
}


function check_email_address($email) {
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!ereg("[^@]{1,64}@[^@]{1,255}", $email)) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		}
	}
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

function showConfig( $option='com_letterman') {
		global $database, $mainframe, $mosConfig_list_limit;

	$query = "SELECT a.id
				FROM #__components AS a
				WHERE a.name = 'Letterman'";
	$database->setQuery( $query );
	$id = $database->loadResult();

	// load the row from the db table
	$row = new mosComponent( $database );
	$row->load( $id );

	// get params definitions
	$params = new mosParameters( $row->params, $mainframe->getPath( 'com_xml', $row->option ), 'component' );
	
	HTML_letterman::settings( $option, $params, $id );
}
function saveSettings( $option ) {
	global $database;

	$params = mosGetParam( $_POST, 'params', '' );
	if (is_array( $params )) {
		$txt = array();
		foreach ($params as $k=>$v) {
			$txt[] = "$k=$v";
		}
		if( is_callable(array('mosParameters', 'textareaHandling'))) {
			$_POST['params'] = mosParameters::textareaHandling( $txt );
		}
		else {
			
			$total = count( $txt );
			for( $i=0; $i < $total; $i++ ) {
				if ( strstr( $txt[$i], "\n" ) ) {
					$txt[$i] = str_replace( "\n", '<br />', $txt[$i] );
				}
			}
			$_POST['params'] = implode( "\n", $txt );
	
		}
	}

	$id = mosGetParam( $_POST, 'id' );
	$row = new mosComponent( $database );
	$row->load( $id );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (!$row->check()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$msg = 'Settings successfully Saved';
	mosRedirect( 'index2.php?option='. $option, $msg );
}

/**
* Cancels editing and checks in the record
*/
function cancelSettings( $option='com_letterman'){
	mosRedirect( 'index2.php?option='.$option );
}

function lm_getAttachments($dir){
	global $mosConfig_absolute_path;
	$files = mosReadDirectory($dir, '.');
	$return = array();
	  
	foreach($files AS $file){
	    if(is_dir($dir . "/" . $file) && is_readable($dir . "/" . $file)){
			$returnarray = lm_getAttachments($dir . "/" . $file);
	      	foreach ($returnarray AS $tmpfile){
	        	$return[] = $file . '/' . $tmpfile;
	      	}
	    }
	    else{
	    	  $return[] = $file;
	    }
	}
	//sort($return);
	return $return;
}
/**
 * Returns a mosHTML::selectList object with all content items
 * @author Adam van Dongen
 * @return mosHTML
 */
function lm_getContentSelectList(){
    global $database;
    
    $where = array(
		"c.state > 0",
		"c.catid=cc.id",
		);
		
  	$items = array();
  	$items[] = mosHTML::makeOption( '0', 'Select a content item' );
  	$query = 'SELECT s.id, s.title AS section_name 
  				FROM #__sections AS s 
  				WHERE s.scope=\'content\'
  				ORDER BY ordering ASC, s.title ASC
  				LIMIT 0, 10';
  	
  	$database->setQuery( $query );
  	$sections = $database->loadObjectList();
  	
  	foreach( $sections as $section ) {
  		$items[] = mosHTML::makeOption( '', '- - - '.$section->section_name.' - - -' );
	    $query = "SELECT c.id, c.title, cc.title AS categorie_name"
	  	. "\n FROM #__content AS c, #__categories AS cc"
	  	. ( count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : '' )
	  	. "\n AND cc.section=".$section->id
	  	. "\n ORDER BY c.created DESC, cc.title, c.title"
	  	. "\n LIMIT 0, 10";
	  	
	  	//echo nl2br(str_replace("#__", "mos_", $query));
	  	$database->setQuery( $query );
	  	$rows = $database->loadObjectList();
	  	
	  	if(sizeof($rows) > 0){  	
	    	foreach($rows AS $row){
	    	  $items[] = mosHTML::makeOption( $row->id, $row->categorie_name . " - " . $row->title );
	    	}
	  	}
  	}
  	$selectList = mosHTML::selectList( $items, 'contentid', 'class="inputbox" size="10" onchange="addContentTag()"', 'value', 'text', '0' );
  	$selectList = str_replace( '>- - -', ' disabled="disabled">- - -', $selectList );
  	
  	return $selectList;
 }
?>
