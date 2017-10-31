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

class TOOLBAR_jaclplus {
	function _EDIT() {
		global $id;

		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::apply();
		mosMenuBar::spacer();
		if ( $id ) {
			mosMenuBar::cancel( 'cancel', 'Close' );
		} else {
			mosMenuBar::cancel();
		}
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::custom( 'logout', 'cancel.png', 'cancel_f2.png', '&nbsp;Logout' );
		mosMenuBar::spacer();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::editListX();
		mosMenuBar::spacer();
		mosMenuBar::addNewX();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function _LISTAL() {
		mosMenuBar::startTable();
		mosMenuBar::deleteList('', 'removeAL');
		mosMenuBar::spacer();
		mosMenuBar::editListX('editAL');
		mosMenuBar::spacer();
		mosMenuBar::addNewX('newAL');
		mosMenuBar::spacer();
		mosMenuBar::custom( 'cancel', 'back.png', 'back_f2.png', '&nbsp;Back', false );
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function _EDITAL() {
		global $id;

		mosMenuBar::startTable();
		mosMenuBar::save( 'saveAL' );
		mosMenuBar::spacer();
		mosMenuBar::apply( 'applyAL' );
		mosMenuBar::spacer();
		if ( $id ) {
			mosMenuBar::cancel( 'cancelAL', 'Close' );
		} else {
			mosMenuBar::cancel( 'cancelAL' );
		}
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function _ABOUT() {
		mosMenuBar::startTable();
		mosMenuBar::custom( 'cancel', 'back.png', 'back_f2.png', '&nbsp;Back', false );
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
}
?>