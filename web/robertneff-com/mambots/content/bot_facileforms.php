<?php
/**
* FacileForms - A Joomla Forms Application
* @version 1.4.6
* @package FacileForms
* @copyright (C) 2004-2006 by Peter Koch
* @license Released under the terms of the GNU General Public License
**/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onPrepareContent', 'botFacileForms' );

function botFacileForms($published, &$row, $mask=0, $page=0)
{
	global $botFacileFormsPublished, $botFacileFormsContentid;
	$botFacileFormsPublished = $published;
	$botFacileFormsContentid = $row->id;

	// define the regular expression for the bot
	// the syntax is: { FacileForms : formname, page, border, urlparams, suffix }
	$regex =
		"/".                    // delimiter
		"\\{".                  // opening {
		"[\\s]*".               // skip whitespace
		"FacileForms".          // required tag identifier
		"[\\s]*".               // skip whitespace
		":".                    // colon
		"[\\s]*".               // skip whitespace
		"([A-Za-z0-9_\\-]+)".   // required form name
		"(".                        // start of page/border/params scan
			"[\\s]*".               // skip whitespace
			",".                    // require a comma
			"[\\s]*".               // skip whitespace
			"(\\d*)".               // find integer pagenumber
			"(".                        // start border scan
				"[\\s]*".               // skip whitespace
				",".                    // require a comma
				"[\\s]*".              // skip whitespace
				"(0|1)?".               // find border as 0 or 1
				"(".                        // start params scan
					"[\\s]*".               // skip whitespace
					",".                    // require a comma
					"[\\s]*".               // skip whitespace
					"([^\\},]*)".           // find any chars but comma and }
					"(".                        // start suffix scan
						"[\\s]*".               // skip whitespace
						",".                    // require a comma
						"[\\s]*".               // skip whitespace
						"([^\\s\\},]*)".        // find any chars but whitespace, comma and }
					")?".                       // 0 or 1 times suffix
				")?".                       // 0 or 1 times params
			")?".                       // 0 or 1 times a border
		")?".                       // 0 or 1 times page/border/params
		"[\\s]*".               // skip whitespace
		"\\}".                  // closing }
		"/s";                    // delimiter

	// perform the replacement
	$row->text = preg_replace_callback( $regex, 'botFacileForms_replacer', $row->text );

	// clean up globals
	unset( $GLOBALS['botFacileFormsPublished'] );

	return true;
} // botFacileForms

function botFacileForms_replacer( &$matches )
{
	global $database, $ff_mossite, $ff_version, $ff_config, $ff_target, $ff_request, $ff_mospath, $ff_compath;
	global $botFacileFormsPublished, $botFacileFormsContentid;

	// return nothing in case the mambot is disabled
	if (!$botFacileFormsPublished) return '';

	// get paths
	$ff_mospath = str_replace('\\','/',dirname(dirname(dirname(__FILE__))));
	$ff_compath = $ff_mospath.'/components/com_facileforms';

	// load config
	require_once($ff_compath.'/facileforms.class.php');
	$ff_config = new facileFormsConf();
	initFacileForms();

	// get the parameters from the regex scan
	$formid   = '';
	$formname = '';
	$page     = 1;
	$border   = 1;
	$suffix   = '';
	$ff_request = array();
	$cnt = count($matches);
	if ($cnt > 1) {
		$formname = $matches[1];
		if ($cnt > 3) {
			if ($matches[3]!='') $page = intval($matches[3]);
			if ($cnt > 5) {
				if ($matches[5]!='') $border = intval($matches[5]);
				if ($cnt > 7) {
					addRequestParams($matches[7]);
					if ($cnt > 9) $suffix = $matches[9];
				} // if
			} // if
		} // if
	} // if

	if (!$ff_target) $ff_target = 1; else $ff_target++;
	$target = mosGetParam($_REQUEST, 'ff_target', '');
	$myTarget = $target==$ff_target || ($target=='' && $ff_target==1);

	if ($myTarget) {
		// yes, all ff_ parameters are meant for me
		$formid   = mosGetParam($_REQUEST, 'ff_form',  $formid);
		$formname = mosGetParam($_REQUEST, 'ff_name',  $formname);
		$page     = mosGetParam($_REQUEST, 'ff_page',  $page);
		$border   = mosGetParam($_REQUEST, 'ff_border',$border);
		reset($_REQUEST);
		while (list($prop, $val) = each($_REQUEST))
			if (!is_array($val) && substr($prop,0,9)=='ff_param_')
				$ff_request[$prop] = $val;
	} // if

	// load form
	if (is_numeric($formid)) {
		$database->setQuery(
			"select * from #__facileforms_forms ".
			"where id=$formid and published=1 and runmode<2"
		);
		$forms = $database->loadObjectList();
		if (count($forms) < 1) return '[Form '.$formid.' not found!]';
	} else {
		$database->setQuery(
			"select * from #__facileforms_forms ".
			"where name='$formname' and published=1 and runmode<2 ".
			"order by ordering, id"
		);
		$forms = $database->loadObjectList();
		if (count($forms) < 1) return '[Form '.$formname.' not found!]';
	} // if
	$form = $forms[0];

    // get Itemid
    $iid = mosGetParam($_REQUEST, 'Itemid', 1);
    if (!is_numeric($iid)) $iid = 1;

	// prepare width and height parameters
	$framewidth = 'width="'.$form->width;
	if ($form->widthmode) $framewidth .= '%" '; else $framewidth .= '" ';
	$frameheight = '';
	if (!$form->heightmode) $frameheight = 'height="'.$form->height.'" ';

	// build the url
	$url = $ff_mossite.'/index2.php'
				.'?option=com_facileforms'
				.'&amp;Itemid='.$iid
				.'&amp;ff_contentid='.$botFacileFormsContentid
				.'&amp;ff_form='.$form->id
				.'&amp;ff_frame=1';
	if ($page>1) $url .= '&amp;ff_page='.$page;
	if ($suffix!='') $url .= '&amp;ff_suffix='.urlencode($suffix);
	reset($ff_request);
	while (list($prop, $val) = each($ff_request)) $url .= '&amp;'.$prop.'='.urlencode($val);
	$params =   'id="ff_frame'.$form->id.'" '.
				'src="'.$url.'" '.
				$framewidth.
				$frameheight.
				'frameborder="'.$border.'" '.
				'allowtransparency="true" '.
				'scrolling="no" ';
	return
        // DO NOT REMOVE OR CHANGE OR OTHERWISE MAKE INVISIBLE THE FOLLOWING COPYRIGHT MESSAGE
        // FAILURE TO COMPLY IS A DIRECT VIOLATION OF THE GNU GENERAL PUBLIC LICENSE
        // http://www.gnu.org/copyleft/gpl.html
        "\n<!-- FacileForms V".$ff_version." Copyright(c) 2004-2006 by Peter Koch, Chur, Switzerland.  All rights reserved. -->\n".
        // END OF COPYRIGHT
        "<iframe ".$params.">\n".
        "<p>Sorry, your browser cannot display frames!</p>\n".
        "</iframe>\n";
} // botFacileForms_replacer

?>