<?php
/**
* Facile Forms - A Joomla Forms Application
* @version 1.4.4
* @package FacileForms
* @copyright (C) 2004-2005 by Peter Koch
* @license Released under the terms of the GNU General Public License
**/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

require_once($ff_admpath.'/admin/install.class.php');

switch ($task) {
	case '':
	case 'step2':
		facileFormsInstaller::step2($option);
		break;
	case 'step3':
		facileFormsInstaller::step3($option);
		break;
	default:
		$ff_config->edit($option, "index2.php?option=$option&act=manageforms");
		break;
} // switch
?>