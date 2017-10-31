<?php
/******************************************************************/
/* Title........: JACLPlus Component for Joomla! 1.0.4 Stable
/* Description..: Joomla! ACL Enhancements Hacks for Joomla! 1.0.4 Stable
/* Author.......: Vincent Cheah
/* Version......: 1.0.4 (For Joomla! 1.0.4 ONLY)
/* Created......: 23/11/2005
/* Contact......: jaclplus@byostech.com
/* Copyright....: (C) 2005 Vincent Cheah, ByOS Technologies. All rights reserved.
/* Note.........: This script is a part of JACLPlus package.
/* License......: Released under GNU/GPL http://www.gnu.org/copyleft/gpl.html
/******************************************************************/
###################################################################
//JACLPlus Component for Joomla! 1.0.4 Stable (Joomla! ACL Enhancements Hacks)
//Copyright (C) 2005  Vincent Cheah, ByOS Technologies. All rights reserved.
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
//
//You should have received a copy of the GNU General Public License
//along with this program; if not, write to the Free Software
//Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
###################################################################

// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed. [ <a href="http://www.byostech.com/jaclplus">JACLPlus Component for Joomla! 1.0.4 Stable</a> ]' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
	case 'newAL':
	case 'editAL':
	case 'editALA':
		TOOLBAR_jaclplus::_EDITAL();
		break;

	case 'listAL':
		TOOLBAR_jaclplus::_LISTAL();
		break;

	case 'about':
		TOOLBAR_jaclplus::_ABOUT();
		break;

	case 'new':
	case 'edit':
	case 'editA':
		TOOLBAR_jaclplus::_EDIT();
		break;

	default:
		TOOLBAR_jaclplus::_DEFAULT();
		break;
}
?>