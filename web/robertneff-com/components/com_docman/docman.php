<?php

/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: docman.php,v 1.79 2005/08/07 17:40:25 johanjanssens Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

require_once($mainframe->getPath('front_html'));
require_once($mainframe->getPath('class'));

// mainframe is an API workhorse, lots of 'core' interaction routines
$_DOCMAN = new dmMainFrame(_DM_TYPE_SITE);
$_DOCMAN->loadLanguage('frontend');

$_DMUSER = $_DOCMAN->getUser();

require_once($_DOCMAN->getPath('classes', 'html'));
require_once($_DOCMAN->getPath('classes', 'utils'));
require_once($_DOCMAN->getPath('classes', 'theme'));

$document 		= (isset($document)) ? $document : null;
$document_name 	= (isset($document_name)) ? $document_name : null;
$document_type 	= (isset($document_type)) ? $document_type : null;

$task 			= mosGetParam($_REQUEST, "task", "");
$gid 			= mosGetParam($_REQUEST, "gid", 0);
$script 		= mosGetParam($_REQUEST, "script", 0);

$ordering 		= mosGetParam($_REQUEST, "order", $_DOCMAN->getCfg('default_order'));
$direction 		= mosGetParam($_REQUEST, "dir"	, $_DOCMAN->getCfg('default_order2'));

$revision 		= mosGetParam($_REQUEST, "revision", 0);
$archive 		= mosGetParam($_REQUEST, "archive", 0);
$Itemid 		= mosGetParam($_REQUEST, "Itemid" , 0);

$limitstart 	= mosGetParam($_REQUEST, "limitstart", 0);
$limit 			= mosGetParam($_REQUEST, "limit", $_DOCMAN->getCfg('perpage'));
$total 			= DOCMAN_Cats::countDocsInCatByUser($gid, $_DMUSER);

if ($total <= $limit) {
    $limitstart = 0;
}

// check if the user actually has access to see this document
switch ($_DMUSER->canAccess()) {
    case 0:
  	    showMsgBox(_DML_NOLOG);
        return;
    case -1:
        showMsgBox(_DML_ISDOWN);
        return;
}
// component tasks
switch ($task)
{    
    //standard operations
    case "doc_details":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        showDocumentDetails($gid);
        break;
        
   	case "doc_download":
      	require_once($_DOCMAN->getPath('includes_f', 'download'));
        showDocumentDownload($gid);
        break;
        
   	case "doc_view":
      	require_once($_DOCMAN->getPath('includes_f', 'download'));
        showDocumentView($gid);
        break;
    
    //maintain operations
    case "doc_edit":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        showDocumentEdit($gid, $script);
        break;

    case "doc_save":
    case "save":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        saveDocument($gid);
        break;

    case "doc_cancel":
    case "cancel":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        cancelDocument($gid);
        break;

    case "doc_move":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        showDocumentMove($gid);
        break;

    case "doc_move_process":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        moveDocumentProcess($gid);
        break;

    case "doc_checkin":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        checkinDocument($gid);
        break;

    case "doc_checkout":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        checkoutDocument($gid);
        break;
        
   	case "doc_reset":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        resetDocument($gid);
        break;
        
   	case "doc_delete":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        deleteDocument($gid);
        break;
        
    case "doc_update":
    	require_once($_DOCMAN->getPath('includes_f', 'upload'));
        showDocumentUpload($gid, $script, 1);
        break;
   	
   	 case "doc_update_process":
   	 	require_once($_DOCMAN->getPath('includes_f', 'documents'));
        updateDocumentProcess($gid);
        break;

	 //special operations
    case "doc_approve":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        approveDocument(array($gid));
        break;

    case "doc_unpublish":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        publishDocument(array($gid), 0);
        break;

    case "doc_publish":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        publishDocument(array($gid));
        break;
    
    // upload operations    
    case "upload":
    	require_once($_DOCMAN->getPath('includes_f', 'upload'));
        showDocumentUpload($gid, $script, 0);
        break;

    // license operations
    case "license_result":
        require_once($_DOCMAN->getPath('includes_f', 'download'));
        licenseDocumentProcess($gid);
        break;

    // search operations
    case "search_form":
        require_once($_DOCMAN->getPath('includes_f', 'search'));
        showSearchForm($gid, $Itemid);
        break;

    case "search_result":
        require_once($_DOCMAN->getPath('includes_f', 'search'));
        showSearchResult($gid, $Itemid);
        break;
        
	// category operations
    case "cat_view" :
    default:
        require_once($_DOCMAN->getPath('includes_f', 'categories'));
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        showDocman($gid);
}

function showMsgBox($msg)
{
    HTML_docman::pageMsgBox($msg);
}

function showDocman($gid)
{
    $html = new StdClass();
    $html->menu = fetchMenu($gid);
    $html->pathway = '';
   
    $pathway = fetchPathway($gid);
    $html->pathway = fetchPathway($gid);

    $html->category = '';

    if ($gid > 0) {
        $cat = fetchCategory($gid);
    }

    $html->cat_list = fetchCategoryList($gid);
    $html->doc_list = fetchDocumentList($gid);
    $html->pagenav   = fetchPageNav($gid);
    $html->pagetitle = fetchPageTitle($gid);
      
    HTML_docman::pageDocman($html);
}

function showDocumentDetails($gid)
{
    $html = new StdClass();
    $html->menu = fetchMenu($gid);
    $html->docdetails = fetchDocument($gid);

    HTML_docman::pageDocument($html);
}

function showDocumentDownload($gid)
{
	global $database, $_DOCMAN;
	
	$doc = new DOCMAN_Document($gid);
	$data = &$doc->getDataObject();
	
	 //check if we need to display a license
    if ($_DOCMAN->getCfg('display_license') && 
       ($data->dmlicense_display && $data->dmlicense_id)) 
    {
    	//fetch the license form
    	$html = new StdClass();
    	$html->doclicense = fetchDocumentLicenseForm($gid);
    	
   		 //get the license text
   		$license = new mosDMLicenses($database);
   		$license->load($data->dmlicense_id);
    	
    	HTML_docman::pageDocumentLicense($html, $license->license);
    	
	} else {
		download($doc, false);
	}
}

function showDocumentView($gid)
{
	global $database, $_DOCMAN;
	
	$doc = new DOCMAN_Document($gid);
	$data = &$doc->getDataObject();
	
	 //check if we need to display a license
    if ($_DOCMAN->getCfg('display_license') && 
       ($data->dmlicense_display && $data->dmlicense_id)) 
    {
    	//fetch the license form
    	$html = new StdClass();
    	$html->doclicense = fetchDocumentLicenseForm($gid);
    	
   		 //get the license text
   		$license = new mosDMLicenses($database);
   		$license->load($data->dmlicense_id);
    	
    	HTML_docman::pageDocumentLicense($html, $license->license);
    	
	} else {
		download($doc, true);
	}
}

function showDocumentUpload($gid, $script, $update)
{
	$step   = mosGetParam($_REQUEST, "step", 1);
	$method = mosGetParam($_REQUEST, "method", null);
	
	if($script) {
    	HTML_docman::scriptDocumentUpload($step, $method, $update);
    	return;
    }
	
	//fetch the license form
    $html = new StdClass();
    $html->menu = fetchMenu();
    $html->docupload = fetchDocumentUploadForm($gid, $step, $method, $update);
    		
    HTML_docman::pageDocumentUpload($html, $step, $method, $update);
}

function showDocumentEdit($gid, $script)
{
    if($script) {
    	HTML_docman::scriptDocumentEdit();
    	return;
    }
    
    $html = new StdClass();
    $html->menu = fetchMenu($gid);
    $html->docedit = fetchEditDocumentForm($gid);
    
    HTML_docman::pageDocumentEdit($html);
}

function showDocumentMove($gid)
{
    $html = new StdClass();
    $html->menu = fetchMenu($gid);
    $html->docmove = fetchMoveDocumentForm($gid);

    HTML_docman::pageDocumentMove($html);
}

function showSearchForm($gid, $Itemid)
{
    $html = new StdClass();
    $html->menu = fetchMenu(0);
    $html->searchform = fetchSearchForm($gid, $Itemid);
    $items = array();

    HTML_docman::pageSearch($html, $items);
}

function showSearchResult($gid, $Itemid)
{
    $html = new StdClass();
    $html->menu = fetchMenu(0);
    $html->searchform = fetchSearchForm($gid, $Itemid);
    $items = getSearchResult($gid, $Itemid);

    HTML_docman::pageSearch($html, $items);
}

function fetchMenu($gid = 0)
{
    global $_DOCMAN, $_DMUSER;

    // create links
    $links = new StdClass();
    $links->home = _taskLink(null);
    $links->search = _taskLink('search_form');
    $links->upload = _taskLink('upload', $gid);

    // create perms
    $perms = new StdClass();
    $perms->view = DM_TPL_AUTHORIZED;
    $perms->search = DM_TPL_AUTHORIZED;
    $perms->upload = DM_TPL_NOT_AUTHORIZED;

    if ($_DMUSER->canUpload()) {
        $perms->upload = DM_TPL_AUTHORIZED;
    } else {
        if ($_DMUSER->userid == 0 && $_DOCMAN->getCfg('user_upload') != -1) {
            $perms->upload = DM_TPL_NOT_LOGGED_IN;
        }
    }

    return HTML_docman::fetchMenu($links, $perms);
}

function fetchPathWay($id)
{
     if (!$id > 0) {
     	return;
     }
    
    // get the category ancestors
    $ancestors = &DOCMAN_Cats::getAncestors($id);

    // add home link
    $home = new StdClass();
    $home->name  = _DML_TPL_CAT_VIEW;
    $home->title = _DML_TPL_CAT_VIEW;
    $home->link  = DOCMAN_Utils::taskLink('');

    $ancestors[] = &$home;
    // reverse the array
    $ancestors = &array_reverse($ancestors);
    // display the pathway
    return HTML_docman::fetchPathWay($ancestors);
}

function fetchPageNav($gid)
{
    global $_DMUSER, $total, $limit, $limitstart, $direction, $ordering;

    // show pages naviagtion
    require_once($GLOBALS['mosConfig_absolute_path'] . '/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    if ($total <= $limit) {
        return;
    }
    
    $link  = 'index.php?option=com_docman&amp;task=cat_view'
    	.'&amp;gid='.$gid
    	.'&amp;dir='.$direction
    	.'&amp;order='.$ordering;

    return HTML_docman::fetchPageNav($pageNav, $link);
}

function fetchPageTitle($id) 
{
     if (!$id > 0) {
     	return;
     }
    
    // get the category ancestors
    $ancestors = &DOCMAN_Cats::getAncestors($id);

    // reverse the array
    $ancestors = &array_reverse($ancestors);

    // display the pathway
    return HTML_docman::fetchPageTitle($ancestors);
}

function _taskLink($task, $gid = '', $params = null)
{
    return DOCMAN_Utils::taskLink($task, $gid, $params);
}

function _returnTo($task, $msg = '', $gid = '', $params = null)
{
    return DOCMAN_Utils::returnTo($task, $msg, $gid, $params);
}

?>
