<?php
/**
* fckeditor.php, v 1.0 2004/09/20 21:00:23
* Mambo Open Source
* Copyright (C) 2000 - 2004 Miro International Pty Ltd
* All rights reserved
* Mambo Open Source is Free Software
* Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* version $Revision: 1.0
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onInitEditor', 'botInitEditor' );
$_MAMBOTS->registerFunction( 'onEditorArea', 'botEditorArea' );
$_MAMBOTS->registerFunction( 'onGetEditorContents', 'botGetEditorContents' );

function botInitEditor() {
	global $mosConfig_live_site;
return <<<EOD
<script type="text/javascript" src="$mosConfig_live_site/mambots/editors/fckeditor/fckeditor.js"></script>
EOD;
}

function botEditorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
global $mosConfig_live_site, $database;

     $content = str_replace("&lt;", "<", $content);
 	 $content = str_replace("&gt;", ">", $content);
	 $content = str_replace("&amp;", "&", $content);
	 $content = str_replace("&nbsp;", " ", $content);
	 $content = str_replace("&quot;", "\"", $content);
	 
    $query = "SELECT id FROM #__mambots WHERE element = 'fckeditor' AND folder = 'editors'";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$mambot = new mosMambot( $database );
	$mambot->load( $id );
	$params =& new mosParameters( $mambot->params );

	$toolbar = $params->get( 'toolbar', 'Default' );
	$skin = $params->get( 'skin', 'default' );
	$wwidth = $params->get( 'wwidth', '100%' );
	$hheight = $params->get( 'hheight', '250' );
	
return <<<EOD
<textarea name="$hiddenField" id="$hiddenField" cols="$col" rows="$row" style="width:{$width}px; height:{$height}px;">$content</textarea>

<script type="text/javascript">
        var oFCKeditor = new FCKeditor( '$hiddenField' ) ;
		oFCKeditor.BasePath = "$mosConfig_live_site/mambots/editors/fckeditor/" ;
		oFCKeditor.ToolbarSet = "$toolbar" ;
		oFCKeditor.Config['SkinPath'] = oFCKeditor.BasePath + 'editor/skins/' + '$skin' + '/' ;
		oFCKeditor.Width = "$wwidth" ;
		oFCKeditor.Height = "$hheight" ;
		oFCKeditor.ReplaceTextarea() ;
</script>
EOD;
}

function botGetEditorContents( $editorArea, $hiddenField ) {

}
?>
