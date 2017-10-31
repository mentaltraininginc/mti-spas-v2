<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * File Name: config.php
 * 	Configuration file for the File Manager Connector for PHP.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

global $Config ;

/*
/*Added by Eddy Chang 20050915
/*Get the root path
*/
require_once("../../../../../../../../../configuration.php");
$parent = str_replace( "//", "/", $mosConfig_absolute_path );
$parent = str_replace( $_SERVER['DOCUMENT_ROOT'],"", $parent );
/*End*/

// SECURITY: You must explicitelly enable this "connector". (Set it to "true").
$Config['Enabled'] = true ;

// Path to user files relative to the document root.

/*
/*Modified by Eddy Chang 20050915 
/*Change UserFilesPath to root path+images path	
*/
//$Config['UserFilesPath'] = '/UserFiles/' ;
$Config['UserFilesPath']=$parent.'/images/stories';

$Config['AllowedExtensions']['File']	= array() ;
$Config['DeniedExtensions']['File']		= array('php','php3','php5','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi') ;

$Config['AllowedExtensions']['Image']	= array('jpg','gif','jpeg','png') ;
$Config['DeniedExtensions']['Image']	= array() ;

$Config['AllowedExtensions']['Flash']	= array('swf','fla') ;
$Config['DeniedExtensions']['Flash']	= array() ;

$Config['AllowedExtensions']['Media']	= array('swf','fla','jpg','gif','jpeg','png','avi','mpg','mpeg') ;
$Config['DeniedExtensions']['Media']	= array() ;

?>