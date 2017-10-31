<?php
/**
* FacileForms - A Joomla Forms Application
* @version 1.4.6
* @package FacileForms
* @copyright (C) 2004-2006 by Peter Koch
* @license Released under the terms of the GNU General Public License
*
* This is the main component entry point that will be called by joomla or mambo
* after after calling
*
*     http://siteurl/index.php?option=com_facileforms......
* or
*     http://siteurl/index2.php?option=com_facileforms......
*
* The first form is the normal call from frontend where the whole page is
* displayed by uting the template. The second form is a display of the plain
* form, wich is used to run in iframe or in popup windows.
**/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// declare global variables
global
$database,				// joomla/mambo database object
$ff_version,			// FacileForms version number
$ff_config,				// FacileForms configuration object
$ff_mospath,			// path to root of joomla/mambo
$ff_compath,			// path to component frontend root
$ff_mossite,			// url of the site root
$ff_request,			// array of request parameters ff_param_*
$ff_processor,			// current form procesor object
$ff_target;				// index of form on current page

// declare local vars
// (1) only used in component space and not plain form)
$plainform	= 0;		// running as plain form by index2.php
$formid		= null;		// form id number
$formname	= null;		// form name
$task		= 'view';	// either 'view' or 'submit'
$page		= 1;		// page to display
$inframe	= 0;		// run in iframe
$border		= 0;		// show a border around the form (1)
$align		= 1;		// 0-left 1-center 2-right (1)
$left		= 0;		// left margin in px (1)
$top		= 0;		// top margin in px (1)
$suffix		= '';		// CSS class suffix
$parprv		= '';		// private parameters
$runmode	= 0;		// run mode
$pagetitle	= true;		// set page title

$runmode = mosGetParam($_REQUEST,'ff_runmode', $runmode);

// get paths
if (!isset($ff_mospath)) $ff_mospath = str_replace('\\','/',dirname(dirname(dirname(__FILE__))));
if (!isset($ff_compath)) $ff_compath = $ff_mospath.'/components/com_facileforms';

// load config and initialize globals
require_once($ff_compath.'/facileforms.class.php');
if (!isset($ff_config)) $ff_config = new facileFormsConf();
initFacileForms();

// check for plain form
$plainform = basename($_SERVER['PHP_SELF'])=='index2.php';

// open session if necessary
if (!session_id()) session_start();

// create target id for this form and check if ff params are ment for this target
if (!$ff_target) $ff_target = 1; else $ff_target++;
$parent_target = mosGetParam($_REQUEST, 'ff_target', 1);
$my_ff_params = $plainform || $parent_target==$ff_target;

// clear list of request parameters
$ff_request = array();

if ($runmode==_FF_RUNMODE_FRONTEND) {
	// is this called by a module?
	if (isset($ff_applic) && $ff_applic=='mod_facileforms') {
		// get the module parameters
		$formname = $params->get('ff_mod_name');
		$page     = intval($params->get('ff_mod_page', $page));
		$inframe  = intval($params->get('ff_mod_frame', $inframe));
		$border   = intval($params->get('ff_mod_border', $border));
		$align    = intval($params->get('ff_mod_align', $align));
		$left     = intval($params->get('ff_mod_left', $left));
		$top      = intval($params->get('ff_mod_top', $top));
		$suffix   = $params->get('ff_mod_suffix', '');
		$parprv   = $params->get('ff_mod_parprv', '');
		addRequestParams($params->get('ff_mod_parpub', ''));
		$pagetitle = false;
	} else
		// is this called with an Itemid?
		if ($Itemid > 1) {
			// get parameters from menu
			$menu =& new mosMenu($database);
			$menu->load($Itemid);
			$params =& new mosParameters($menu->params);
			$formname = $params->get('ff_com_name');
			$page     = intval($params->get('ff_com_page', $page));
			$inframe  = intval($params->get('ff_com_frame', $inframe));
			$border   = intval($params->get('ff_com_border', $border));
			$align    = intval($params->get('ff_com_align', $align));
			$left     = intval($params->get('ff_com_left', $left));
			$top      = intval($params->get('ff_com_top', $top));
			$suffix   = $params->get('ff_com_suffix', '');
			$parprv   = $params->get('ff_com_parprv', '');
			addRequestParams($params->get('ff_com_parpub', ''));
		} // if
} // if

if ($my_ff_params) {
	// allow overriding by url params
	$formid = mosGetParam($_REQUEST, 'ff_form', $formid);
	if ($formid==null)
		$formname = mosGetParam($_REQUEST,'ff_name', $formname);
	else
		$formname = null;
	$task = mosGetParam($_REQUEST,'ff_task', $task);
	$page = mosGetParam($_REQUEST,'ff_page', $page);
	$inframe = mosGetParam($_REQUEST,'ff_frame', $inframe);
	$border = mosGetParam($_REQUEST,'ff_border', $border);
	$align1 = mosGetParam($_REQUEST,'ff_align', -1);
	if ($align1>=0) {
		$align = mosGetParam($_REQUEST, 'ff_align', $align);
		$left = 0;
		if ($align>2) { $left = $align; $align = 3; }
	} // if
	$top = mosGetParam($_REQUEST,'ff_top',$top);
	$suffix = mosGetParam($_REQUEST,'ff_suffix',$suffix);
} // if

// load form
$ok = true;
if (is_numeric($formid)) {
	$database->setQuery(
		"select * from #__facileforms_forms ".
		"where id=$formid and published=1"
	);
	$forms = $database->loadObjectList();
	if (count($forms) < 1) {
		echo '[Form '.$formid.' not found!]';
		$ok = false;
	} else
		$form = $forms[0];
} else
	if ($formname != null) {
		$database->setQuery(
			"select * from #__facileforms_forms ".
			"where name='$formname' and published=1 ".
			"order by ordering, id"
		);
		$forms = $database->loadObjectList();
		if (count($forms) < 1) {
			echo '[Form '.$formname.' not found!]';
			$ok = false;
		} else
			$form = $forms[0];
	} else {
		echo '[No form id or name provided!]';
		$ok = false;
	} // if

if ($ok) {
	if ($pagetitle && $form->title != '') $mainframe->setPageTitle($form->title);
	if ($form->name==$formname) addRequestParams($parprv);
	if ($my_ff_params) {
		reset($_REQUEST);
		while (list($prop, $val) = each($_REQUEST))
			if (!is_array($val) && substr($prop,0,9)=='ff_param_')
				$ff_request[$prop] = $val;
	} // if

	if ($inframe && !$plainform) {
		// open frame and detach processing
		$divstyle = 'width:100%;';
		switch ($align) {
			case 0: $divstyle .= 'text-align:left;';   break;
			case 1: $divstyle .= 'text-align:center;'; break;
			case 2: $divstyle .= 'text-align:right;';  break;
			case 3: if ($left > 0) $divstyle .= 'padding-left:'.$left.'px;'; break;
			default: break;
		} // switch
		if ($top > 0) $divstyle .= 'padding-top:'.$top.'px;';
		$framewidth = 'width="'.$form->width.($form->widthmode?'%" ':'" ');
		$frameheight = '';
		if (!$form->heightmode) $frameheight = 'height="'.$form->height.'" ';
		$url = $ff_mossite.'/index2.php'
					.'?option=com_facileforms'
					.'&amp;Itemid='.(($Itemid > 0 && $Itemid < 99999999) ? $Itemid : 1)
					.'&amp;ff_form='.$form->id
					.'&amp;ff_frame=1';
		if ($page != 1) $url .= '&amp;ff_page='.$page;
		if ($border) $url .= '&amp;ff_border=1';
		if ($parent_target > 1) $url .= '&amp;ff_target='.$parent_target;
		reset($ff_request);
		while (list($prop, $val) = each($ff_request)) $url .= '&amp;'.$prop.'='.urlencode($val);
		$params =   'id="ff_frame'.$form->id.'" '.
					'src="'.$url.'" '.
					$framewidth.
					$frameheight.
					'frameborder="'.$border.'" '.
					'allowtransparency="true" '.
					'scrolling="no" ';
        // DO NOT REMOVE OR CHANGE OR OTHERWISE MAKE INVISIBLE THE FOLLOWING COPYRIGHT MESSAGE
        // FAILURE TO COMPLY IS A DIRECT VIOLATION OF THE GNU GENERAL PUBLIC LICENSE
        // http://www.gnu.org/copyleft/gpl.html
        echo "\n<!-- FacileForms V".$ff_version." Copyright(c) 2004-2006 by Peter Koch, Chur, Switzerland.  All rights reserved. -->\n";
        // END OF COPYRIGHT
		echo '<div style="'.$divstyle.'">'."\n".
			 "<iframe ".$params.">\n".
			 "<p>Sorry, your browser cannot display frames!</p>\n".
			 "</iframe>\n".
			 "</div>\n";
	} else {
		// process inline
		$database->setQuery("select id from #__users where lower(username)=lower('$my->username')");
		$id = $database->loadResult();
		if ($id) $my->load($id);
		require_once($ff_compath.'/facileforms.process.php');
		if ($task == 'view') {
			$div1style = '';
			$div2style = '';
			$fullwidth = $form->widthmode && $form->width>=100;
			if ($form->widthmode) {
				$div1style .= 'min-width:10px;';
				$div2style .= 'min-width:10px;';
			} // if
			$div2style .= 'width:'.($fullwidth?'100':$form->width).($form->widthmode?'%':'px').';';
			if (!$form->heightmode) $div2style .= 'height:'.$form->height.'px;';
			if ($plainform) {
				$div2style .= 'position:absolute;top:0px;left:0px;margin:0px;';
			} else {
				$div1style .= 'width:100%;';
				$div2style .= 'position:relative;overflow:hidden;';
				if ($border) $div2style .= 'border:1px solid black;';
				if (!$fullwidth) {
					switch ($align) {
						case 1:
							$div1style .= 'text-align:center;';
							$div2style .= 'text-align:left;margin-left:auto;margin-right:auto;';
							break;
						case 2:
							$div1style .= 'text-align:right;';
							$div2style .= 'text-align:left;margin-left:auto;margin-right:0px;';
							break;
						case 3:
							if ($left > 0) $div2style .= 'margin-left:'.$left.'px;';
						default:
							break;
					} // switch
				} // if
				if ($top > 0) $div2style .= 'margin-top:'.$top.'px;';
			} // if
			ob_start();
	        // DO NOT REMOVE OR CHANGE OR OTHERWISE MAKE INVISIBLE THE FOLLOWING COPYRIGHT MESSAGE
	        // FAILURE TO COMPLY IS A DIRECT VIOLATION OF THE GNU GENERAL PUBLIC LICENSE
	        // http://www.gnu.org/copyleft/gpl.html
	        echo "\n<!-- FacileForms V".$ff_version." Copyright(c) 2004-2006 by Peter Koch, Chur, Switzerland.  All rights reserved. -->\n";
	        // END OF COPYRIGHT
			if (!$plainform) echo '<div style="'.$div1style.'">'."\n";
			echo '<div style="'.$div2style.'">'."\n";
		} // if task = view
		if ($left > 3) $align = $left;
		$ff_processor = new HTML_facileFormsProcessor(
			$runmode, $inframe, $form->id, $page, $border,
			$align, $top, $ff_target, $suffix
		);
		if ($task == 'submit')
			$ff_processor->submit();
		else {
			$ff_processor->view();
			echo "</div>\n";
			if (!$plainform) echo "</div>\n";
			ob_end_flush();
		} // if
	} // if
} // if
?>