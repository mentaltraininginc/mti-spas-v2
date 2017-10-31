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

// Your Title
$title = "Component JACLPlus - Version 1.0.4";

// Your Message to users
$message = "<p>A Component Package That Make Your Joomla! Access Control Powerful.</p>";

// If your replaced file need to back up, what should we add extansion to filename
$backupext = ".jaclplus.bak";

// SQL Queries that you need to do upon installation
$Install_SQL_Queries = array(
	// SQL Query, Error Message
	array("CREATE TABLE #__jaclplus ( id INT NOT NULL AUTO_INCREMENT, aco_section VARCHAR( 50 ), aco_value VARCHAR( 50 ), aro_section VARCHAR( 50 ), aro_value VARCHAR( 50 ), axo_section VARCHAR( 50 ), axo_value VARCHAR( 50 ), enable TINYINT( 3 ) DEFAULT '0', PRIMARY KEY ( id ) );", "<br /><strong>Notice: Can not access database. ABORT!!!</strong>"), 
	array("ALTER TABLE #__session ADD jaclplus varchar(255) DEFAULT '0' NOT NULL", "<br /><strong>IMPORTANT: Please manually create this column!!!</strong>"),
	array("ALTER TABLE #__core_acl_aro_groups ADD jaclplus varchar(255) DEFAULT '0' NOT NULL", "<br /><strong>IMPORTANT: Please manually create this column!!!</strong>"), 
	array("UPDATE #__core_acl_aro_groups SET jaclplus = '0,1' WHERE group_id = 18", "<br /><strong>IMPORTANT: Please manually update those data!!!</strong>"), 
	array("UPDATE #__core_acl_aro_groups SET jaclplus = '0,1,2' WHERE group_id IN (19,20,21,23,24,25,30)", "<br /><strong>IMPORTANT: Please manually update those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'login', 'users', 'administrator', NULL , NULL , 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'login', 'users', 'super administrator', NULL , NULL , 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'login', 'users', 'manager', NULL , NULL , 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'config', 'users', 'administrator', NULL , NULL , 0);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'config', 'users', 'super administrator', NULL , NULL , 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'super administrator', 'components', 'com_dbadmin', 0);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'user', 'administrator', 'components', 'com_templates', 0);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'super administrator', 'components', 'com_templates', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'install', 'users', 'super administrator', 'templates', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'administrator', 'components', 'com_trash', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'super administrator', 'components', 'com_trash', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'administrator', 'components', 'com_menumanager', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'super administrator', 'components', 'com_menumanager', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'administrator', 'components', 'com_languages', 0);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'super administrator', 'components', 'com_languages', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'install', 'users', 'super administrator', 'languages', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'install', 'users', 'administrator', 'modules', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'install', 'users', 'super administrator', 'modules', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'super administrator', 'modules', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'administrator', 'modules', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'install', 'users', 'administrator', 'mambots', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'install', 'users', 'super administrator', 'mambots', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'super administrator', 'mambots', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'administrator', 'mambots', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'manager', 'modules', 'all', 0);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'install', 'users', 'administrator', 'components', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'install', 'users', 'super administrator', 'components', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'super administrator', 'components', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'administrator', 'components', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'manager', 'components', 'com_newsflash', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'manager', 'components', 'com_frontpage', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'manager', 'components', 'com_media', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'super administrator', 'components', 'com_massmail', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'administrator', 'components', 'com_users', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'super administrator', 'components', 'com_users', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'administrator', 'user properties', 'block_user', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'edit', 'users', 'super administrator', 'user properties', 'block_user', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'workflow', 'email_events', 'users', 'administrator', NULL , NULL , 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'workflow', 'email_events', 'users', 'super administrator', NULL , NULL , 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'add', 'users', 'author', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'add', 'users', 'editor', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'add', 'users', 'publisher', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'edit', 'users', 'author', 'content', 'own', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'edit', 'users', 'editor', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'edit', 'users', 'publisher', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'publish', 'users', 'publisher', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'add', 'users', 'manager', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'edit', 'users', 'manager', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'publish', 'users', 'manager', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'add', 'users', 'administrator', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'edit', 'users', 'administrator', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'publish', 'users', 'administrator', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'add', 'users', 'super administrator', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'edit', 'users', 'super administrator', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"), 
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'publish', 'users', 'super administrator', 'content', 'all', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"),
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'administrator', 'components', 'com_jaclplus', 0);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"),
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'administration', 'manage', 'users', 'super administrator', 'components', 'com_jaclplus', 1);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>"),
	array("INSERT INTO #__jaclplus ( id , aco_section , aco_value , aro_section , aro_value , axo_section , axo_value , enable ) VALUES ('', 'action', 'edit', 'users', 'super administrator', 'content', 'own', 0);", "<br /><strong>IMPORTANT: Please manually insert those data!!!</strong>")
	);

// SQL Queries that you need to do upon uninstallation
$Uninstall_SQL_Queries = array(
	// SQL Query, Error Message
	array("ALTER TABLE #__session DROP jaclplus", "<br /><strong>IMPORTANT: Please manually delete this column!!!</strong>"), 
	array("ALTER TABLE #__core_acl_aro_groups DROP jaclplus", "<br /><strong>IMPORTANT: Please manually delete this column!!!</strong>"),
	array("DELETE FROM #__groups WHERE id > 2", "<br /><strong>IMPORTANT: Please manually delete these data!!!</strong>"),
	array("TRUNCATE TABLE #__core_acl_aro_groups", "<br /><strong>IMPORTANT: Please manually delete these data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (17,0,'ROOT',1,22);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (28,17,'USERS',2,21);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (29,28,'Public Frontend',3,12);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (18,29,'Registered',4,11);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (19,18,'Author',5,10);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (20,19,'Editor',6,9);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (21,20,'Publisher',7,8);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (30,28,'Public Backend',13,20);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (23,30,'Manager',14,19);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (24,23,'Administrator',15,18);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("INSERT INTO #__core_acl_aro_groups VALUES (25,24,'Super Administrator',16,17);", "<br /><strong>IMPORTANT: Please manually insert this data!!!</strong>"),
	array("UPDATE #__categories SET access = '2' WHERE access > 2", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__contact_details SET access = '2' WHERE access > 2", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__content SET access = '2' WHERE access > 2", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__mambots SET access = '2' WHERE access > 2", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__menu SET access = '2' WHERE access > 2", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__modules SET access = '2' WHERE access > 2 AND access != 99", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__polls SET access = '2' WHERE access > 2", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__sections SET access = '2' WHERE access > 2", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__session SET gid = '18' WHERE gid > 30", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__users SET gid = '18' WHERE gid > 30", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("UPDATE #__core_acl_groups_aro_map SET group_id = '18' WHERE group_id > 30", "<br /><strong>IMPORTANT: Please manually update this data!!!</strong>"),
	array("DROP TABLE #__jaclplus", "<br /><strong>IMPORTANT: Please manually delete this table!!!</strong>")
	);

// Files that you need Patch Component to replace
$Replace_Files = array( 
	// File to be replaced, Replacement file, Create bak?
	// Will automatically create dir if non exist (One Level Only!) please make sure parent dir exist
	// If you want to replace a xml file, you must use other extension for the xml replacement file to avoid com_installer process your xml file
	// E.g. file to replace 'jaclplus.xml', replacement file better be 'jaclplus.xml.php' or else (can not be 'jaclplus.xml')
	array("/administrator/index.php", "/patch/index.php", true),
	array("/administrator/index2.php", "/patch/index2.php", true),
	array("/administrator/index3.php", "/patch/index3.php", true),
	array("/administrator/components/com_users/admin.users.php", "/patch/admin.users.php", true),
	array("/administrator/includes/auth.php", "/patch/auth.php", true),
	array("/administrator/modules/mod_logged.php", "/patch/mod_logged.php", true),
	array("/administrator/modules/mod_quickicon.php", "/patch/mod_quickicon.php", true),
	array("/includes/frontend.php", "/patch/frontend.php", true),
	array("/includes/gacl.class.php", "/patch/gacl.class.php", true),
	array("/includes/gacl_api.class.php", "/patch/gacl_api.class.php", true), 
	array("/includes/joomla.php", "/patch/joomla.php", true), 
	array("/modules/mod_latestnews.php", "/patch/mod_latestnews.php", true), 
	array("/modules/mod_mainmenu.php", "/patch/mod_mainmenu.php", true), 
	array("/modules/mod_mostread.php", "/patch/mod_mostread.php", true), 
	array("/modules/mod_newsflash.php", "/patch/mod_newsflash.php", true), 
	array("/modules/mod_related_items.php", "/patch/mod_related_items.php", true), 
	array("/modules/mod_sections.php", "/patch/mod_sections.php", true), 
	array("/components/com_contact/contact.php", "/patch/contact.php", true), 
	array("/components/com_content/content.html.php", "/patch/content.html.php", true), 
	array("/components/com_content/content.php", "/patch/content.php", true), 
	array("/components/com_newsfeeds/newsfeeds.php", "/patch/newsfeeds.php", true), 
	array("/components/com_weblinks/weblinks.php", "/patch/weblinks.php", true), 
	array("/mambots/search/categories.searchbot.php", "/patch/categories.searchbot.php", true), 
	array("/mambots/search/contacts.searchbot.php", "/patch/contacts.searchbot.php", true), 
	array("/mambots/search/content.searchbot.php", "/patch/content.searchbot.php", true), 
	array("/mambots/search/newsfeeds.searchbot.php", "/patch/newsfeeds.searchbot.php", true), 
	array("/mambots/search/sections.searchbot.php", "/patch/sections.searchbot.php", true), 
	array("/mambots/search/weblinks.searchbot.php", "/patch/weblinks.searchbot.php", true)
	);
	
// Actions that you need to implement besides above

?>