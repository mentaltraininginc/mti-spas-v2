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

if (file_exists(dirname(__FILE__) . '/language/'.$mosConfig_lang.'.php')) {
  include(dirname(__FILE__) . '/language/'.$mosConfig_lang.'.php');
} else {
  include(dirname(__FILE__) . '/language/english.php');
}

function com_uninstall()
{
global $database, $mosConfig_absolute_path;
require(dirname(__FILE__).'/config.jaclplus.php');
   
	foreach( $Uninstall_SQL_Queries as $Query ) {
		$database->setQuery($Query[0]);
		if (!$database->query()) {
			$echostr = $database->getErrorMsg().$Query[1]."<br/>\n";
			echo $echostr;
		}
	}
	foreach( $Replace_Files as $file ) {
		$restore_file = $mosConfig_absolute_path.$file[0];
		if ( unpatchFile( $restore_file, $backupext ) ) {
			$echostr = _JACL_P_RESTORE_FILE.$restore_file._JACL_P_SUCCESSFULLY."<br/>\n";
			echo $echostr;
		} else {
			$echostr = _JACL_P_RESTORE_FILE.$restore_file._JACL_P_UNSUCCESSFULLY."<br/>\n"
			._JACL_P_RESTORE_FILE_MSG."<br/>\n";
			echo $echostr;
		}
	}
?>
Component JACLPlus has been uninstalled.
<?php
}

function unpatchFile($restore_file, $backupext) {
	$backupfile = $restore_file.$backupext;
	if (file_exists($backupfile)) {
		$path = dirname($restore_file);
		$patholdperms = NULL;
		if(!is_writable($path)){ //can not write in the directory
			//$patholdperms = substr(sprintf('%o', fileperms($path)), -4);
			$patholdperms = fileperms($path);
			if(!(@chmod($path, 0777))){
				return false;
			}
		}
		$oldperms = fileperms($restore_file);
		@chmod($restore_file, 0777);
		if (!(@copy($backupfile, $restore_file))) {
			if($patholdperms) @chmod($path, $patholdperms);
			@chmod($restore_file, $oldperms);
   			return false;
		}
		if($patholdperms) @chmod($path, $patholdperms);
		@chmod($restore_file, $oldperms);
		@unlink($backupfile);
		return true;
	}
	return false;
}
?>