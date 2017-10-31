<?php
/**
* IntroText
* Version: 1.0
* Author: Bárbara Irene Meclazcke
* URL:  ewriting.com.ar
* mail: aclaina@yahoo.com.ar
* FileName: admin.introtext.php
* Date: 01/02/2005
* MOS Version #: 4.5.1a
* License: GNU General Public License
**/

// Don't allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function com_install()
{	global $mosConfig_live_site, $mosConfig_absolute_path;
	$introtextver='1.0';
	@chmod($mosConfig_absolute_path.'/administrator/components/com_introtext/com_introtext_settings.php', 0777);
	?>
	<font color="green">Done!</font></p>
	<table border="0" cellspacing="0" cellpadding="4" width="75%">
		<tr>
	 		<td align="center">
				<img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/header.gif' border='0' align='absmiddle'><BR>
 				IntroText installed succesfully.<br>
				Now you have to create a category or go to the config option and associate a category that already exist				
				<p><b>Please, go to the components-menu above,<br>
				look for the entry "IntroText", click it and<br>
				choose the Configuration Option in the Toolbar.</b></p><br>
	 		</td>
	 	</tr>
	</table>
	<table cellpadding="8" cellspacing="0" border="0" width="100%">
		<tr> 
			<td width="100%">
				<font color="#CC9933" size="1"><b>Introtext <?php echo $introtextver; ?></b> -
				<a href="mailto:aclaina@yahoo.com.ar">Barbara Irene Meclazcke (Aclaina)</a> -
				<a href="http://ewriting.com.ar" target="_blank">ewriting.com.ar</a></font>
			</TD>
		</TR>
	</table>
	<?php
	return;
}
?>