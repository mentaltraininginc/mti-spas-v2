<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is error.php, released on 2003-02-21.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net
	
Comment:
	QuiXplorer Version 2.3
	Error Reporting File
	
	Have Fun...
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
function show_error($error,$extra=NULL) {		// show error-message
	show_header($GLOBALS["error_msg"]["error"]);
	echo "<center><br/>".$GLOBALS["error_msg"]["error"].":"."<br/><br/>\n";
	echo $error."\n<br/><br/><a href=\"".make_link("list", $GLOBALS["dir"],NULL)."\">";
	echo $GLOBALS["error_msg"]["back"]."</a>";
	if($extra!=NULL) echo " - ".$extra;
	echo "<br/><br/></center>\n";
	show_footer();
	exit;
}
//------------------------------------------------------------------------------
?>
