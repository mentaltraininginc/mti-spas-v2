<?php
/**
* Facile Forms - A Joomla Forms Application
* @version 1.4.4
* @package FacileForms
* @copyright (C) 2004-2005 by Peter Koch
* @license Released under the terms of the GNU General Public License
**/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

require_once($ff_admpath.'/admin/form.class.php');
require_once($ff_admpath.'/admin/element.class.php');

$pkg = getFormPackage();
$caller =  mosGetParam($_REQUEST, 'caller_url', '');
$tabpane = mosGetParam($_REQUEST, 'tabpane', 0);
switch ($task) {
	case 'save' :
		facileFormsForm::save($option, $pkg, $caller);
		break;
	case 'cancel':
		facileFormsForm::cancel($option, $pkg, $caller);
		break;
	case 'edit' :
		facileFormsForm::edit($option, $tabpane, $pkg, $ids, $caller);
		break;
	case 'new' :
		$ids = array(0);
		facileFormsForm::edit($option, 0, $pkg, $ids, $caller);
		break;
	case 'copy' :
		facileFormsForm::copy($option, $pkg, $ids);
		break;
	case 'remove' :
		facileFormsForm::del($option, $pkg, $ids);
		break;
	case 'publish' :
		facileFormsForm::publish($option, $pkg, $ids, '1');
		break;
	case 'unpublish' :
		facileFormsForm::publish($option, $pkg, $ids, '0');
		break;
	case 'orderup':
		facileFormsForm::order($option, $pkg, $ids, -1);
		break;
	case 'orderdown':
		facileFormsForm::order($option, $pkg, $ids, 1);
		break;
	case 'config' :
		$ff_config->edit(
			$option,
			"index2.php?option=$option&act=manageforms",
			$pkg
		);
		break;
	default:
		if (substr($task,0,8) == 'editpage') {
			$page = sscanf($task,"editpage%d");
			facileFormsElement::listitems($option, $pkg, $ids[0], $page[0], 'view');
		} else {
			facileFormsForm::listitems($option, $pkg);
		} // if
		break;
} // switch

function getFormPackage()
{
	global $ff_config;
	$pkg = mosGetParam($_REQUEST, 'pkg', null);
	if (is_null($pkg))
		$pkg = $pkg = $ff_config->formpkg;
	else
	if ($pkg == '- blank -')
		$pkg = '';
	else {
		$ok = _ff_selectValue(
			"select count(*) from `#__facileforms_forms` ".
			"where package = binary '$pkg'"
		);
		if (!$ok) $pkg = $ff_config->formpkg;
	} // if
	if ($pkg != $ff_config->formpkg) {
		$ff_config->formpkg = $pkg;
		$ff_config->store();
	} // if
	return $pkg;
} // getFormPackage

?>