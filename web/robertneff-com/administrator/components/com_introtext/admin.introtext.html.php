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

class HTML_introtext {

//****************************************************************************************************
//										DISPLAY
//****************************************************************************************************
//SHOW LINK	TO UTILITIES FUNC
function toolbarfrontHTML( $actual  )
{	global $mosConfig_live_site; ?>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
	<script language="Javascript" src="../includes/js/overlib_mini.js"></script>
	<!-- TOOLBAR -->
	<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" style="border-top: 2px solid #e5e5e5; border-bottom: 2px solid #e5e5e5;">
		<tr bgcolor="#F5F5F5">
			<td width="25%" align="center" valign="bottom" <?php if ($actual == "showintrotext") echo "bgcolor='#E4E1DC' style='border-left: 2px solid #e5e5e5; border-right: 2px solid #e5e5e5;'";?>>
				<a href="index2.php?option=com_introtext&task=showintrotext"><img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/introlink.gif' border='0' align='absmiddle'></a><BR>
				<a href="index2.php?option=com_introtext&task=showintrotext"><b><?php echo _INTROTEXT_LINKS; ?></b></a>			
			</td>			
			<td width="25%" align="center" valign="bottom" <?php if ($actual == "introlinkconfig") echo "bgcolor='#E4E1DC' style='border-left: 2px solid #e5e5e5; border-right: 2px solid #e5e5e5;'";?>>
				<a href="index2.php?option=com_introtext&task=introlinkconfig"><img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/config.gif' border='0' align='absmiddle'></a><BR>
				<a href="index2.php?option=com_introtext&task=introlinkconfig"><b><?php echo _INTROTEXT_CONFIG_TITLE; ?></b></a>
			</td>
			<td width="90%">&nbsp;</td>
		</tr>		
	</table>
	<?php
}

//SHOW INTRO LINKS
function showintrotextHTML( &$rows, &$pcontent, &$pmenu, &$pageNav, $catname ) 
{	global $mosConfig_live_site, $catIntroText; ?>
	<BR>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr><td width="100%">
				<span class="sectionname">IntroText&nbsp;</span>
				<img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/header.gif' border='0' align='absmiddle'>
				<span class="sectionname">&nbsp;<?php echo _INTROTEXT_LINKS; ?></span>
			</td>
		</tr>
	</table>
	<BR>
	<form action="index2.php" method="post" name="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr> 
	    	<td align="center">Display #&nbsp;<?php echo $pageNav->writeLimitBox(); ?></td>
			<td align="center"><B><?php echo _INTROTEXT_CATNAME; ?></B>&nbsp;<?php if ($catIntroText) echo $catname; else echo _INTROTEXT_NONESELECTED; ?></td>
		</tr>
	</table>
	<BR>
	<!-- TOOLBAR -->
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr><td align="center">
				<a href="index2.php?option=com_introtext&task=add"><img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/new.gif' border='0' align='absmiddle'></a>&nbsp;
				<a href="index2.php?option=com_introtext&task=add"><b><?php echo _INTROTEXT_ADDLINKS; ?></b></a>
			</td></tr>
	</table> 
	<br>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr><!-- TABLE HEADER -->			
			<th align="left"><?php echo _INTROTEXT_LINKNAME; ?></th>
			<th align="center"><?php echo _INTROTEXT_CONTITLE; ?></th>
			<th align="center"><?php echo _INTROTEXT_MENULINK; ?></th>			
			<th>&nbsp;</th>
		</tr>
	<?php $k = 0;
	for ($i=0, $n=count( $rows ); $i < $n; $i++) {
		$row = &$rows[$i]; ?>
		<tr class="<?php echo "row$k"; ?>">
			<!-- LINK NAME -->
			<td align="left"><a href="index2.php?option=com_introtext&task=edit&cfid=<?php echo $row->id; ?>"><?php echo $row->namelink; ?></a></td>
			<!-- CONTENT TITLE -->
			<td align="center"><?php echo $pcontent[$i];?></td>
			<!-- MENU LINK -->
			<td align="center"><?php echo $pmenu[$i];?></td>			
			<td align="right">
				<a href="index2.php?option=com_introtext&task=edit&cfid=<?php echo $row->id; ?>"><img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/edit.gif' border='0' align='absmiddle'></a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="index2.php?option=com_introtext&task=delete&cfid=<?php echo $row->id; ?>"><img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/delete.gif' border='0' align='absmiddle'></a>
			</td>		
		<?php $k = 1 - $k; ?>
		</tr>
	<?php } // for ($i=0, $n=count( $rows ); $i < $n; $i++) ?>
		<tr><th align="center" colspan="4"><?php echo $pageNav->writePagesLinks(); ?></th></tr>
    	<tr><td align="center" colspan="4"><?php echo $pageNav->writePagesCounter(); ?></td></tr>
		<tr><th align="center" colspan="4"><?php echo _INTROTEXT_ERRORSHOW1 ?><BR><?php echo _INTROTEXT_NOEXIST ?>&nbsp;=&nbsp;<?php echo _INTROTEXT_ERRORSHOW2 ?></th></tr>
	</table>		
		<input type="hidden" name="option" value="com_introtext" />
		<input type="hidden" name="task" value="showintrotext" />
	</form>
	<?php HTML_introtext::footerfrontHTML();
}

//****************************************************************************************************
//									STORIES ADMIN
//****************************************************************************************************
//ADD INTRO LINK
function addintrotextHTML( &$intro, &$contlist, &$menuid, &$menutxt )
{	global $tabclass_arr, $mosConfig_live_site, $Web_Stories_Path, $Small_Text_Len, $Large_Text_Len; ?>
	<br>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr><td width="100%">
				<span class="sectionname">IntroText&nbsp;</span>
				<img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/header.gif' border='0' align='absmiddle'>
				<span class="sectionname">&nbsp;<?php if ($intro) { echo _INTROTEXT_EDIT; } else { echo _INTROTEXT_ADD; } ?>&nbsp;<?php echo _INTROTEXT_LINK; ?></span>
			</td></tr>
	</table>
	<br>
	<!-- TOOLBAR -->
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr><td align="center">
			<a href="index2.php?option=com_introtext&task=showintrotext"><img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/back.png' border='0' align='absmiddle'></a>
			<a href="index2.php?option=com_introtext&task=showintrotext"><b><?php echo _INTROTEXT_GOBACK; ?></b></a>
			</td></tr>
	</table> 
	<br><BR>
	<FORM METHOD=POST NAME="adminForm" ACTION="index2.php?option=com_introtext&task=save">
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="4" class="<?php echo $tabclass_arr[$tabcnt]; ?>">
		<TR>	
			<td width="30%" valign="baseline" align="right"><B><?php echo _INTROTEXT_LINKNAME; ?>:</B>&nbsp;</TD>
			<TD valign="top" colspan="2" align="left">
				<?php if ($intro) { ?>
					<INPUT CLASS="inputbox" type="text" name="namelink" size="25" value="<?php echo $intro->namelink; ?>">
				<?php } else { ?>
					<INPUT CLASS="inputbox" type="text" name="namelink" size="25" value="">
				<?php } ?>
				<BR><?php echo _INTROTEXT_LINKNAMEDESC; ?>
			</TD>
		</TR>	
		<TR><td colspan="2">&nbsp;</TD></TR>
		<TR>	
			<td width="30%" valign="baseline" align="right"><B><?php echo _INTROTEXT_CONTITLE; ?>:</B>&nbsp;</TD>
			<TD valign="top" align="left" colspan="2"><?php echo $contlist; ?><BR><?php echo _INTROTEXT_CONTITLEDESC; ?></TD>
		</TR>
		<TR><td colspan="2">&nbsp;</TD></TR>
		<TR>	
			<td width="30%" valign="baseline" align="right"><B><?php echo _INTROTEXT_MENULINK; ?>:</B>&nbsp;</TD>
			<TD valign="top" align="left" colspan="2">
				<SELECT NAME="menuid" class="inputbox">
				<?php if ($intro) {
					for ($i=0, $n=count( $menuid ); $i < $n; $i++)  { 
						if ($intro->menuid == $menuid[$i]) { ?>
					<option value="<?php echo $menuid[$i]; ?>" SELECTED><?php echo $menutxt[$i]; ?></option>
						<?php } else { ?>
					<option value="<?php echo $menuid[$i]; ?>"><?php echo $menutxt[$i]; ?></option>
						<?php }
					} 
				} else { 
					for ($i=0, $n=count( $menuid ); $i < $n; $i++)  { ?>
					<option value="<?php echo $menuid[$i]; ?>"><?php echo $menutxt[$i]; ?></option>
					<?php }
				} ?>
				</SELECT>
				<BR><?php echo _INTROTEXT_MENULINKDESC; ?>
			</TD>
		</TR>		
		<TR><td colspan="2">&nbsp;</TD></TR>
		<TR>
			<td colspan="2" align="center">
				<INPUT CLASS="button" TYPE="submit" NAME="submitsave" VALUE="<?php echo _INTROTEXT_SAVE; ?>">
			</TD>
		</TR>		
	</TABLE>
		<input type="hidden" name="cfid" value="<?php echo $intro->id; ?>" />
	</FORM>
	<?php HTML_introtext::footerfrontHTML();
}

//****************************************************************************************************
//									CONFIG ADMIN
//****************************************************************************************************
//SHOW CONFIG			//REVISADO
function configHTML( $catslist )
{	global $mosConfig_absolute_path, $mosConfig_live_site, $catIntroText; ?>
	<br>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr><td width="100%">
				<span class="sectionname">IntroText&nbsp;</span>
				<img src='<?php echo $mosConfig_live_site; ?>/administrator/components/com_introtext/images/header.gif' border='0' align='absmiddle'>
				<span class="sectionname">&nbsp;<?php echo _INTROTEXT_CONFIG_TITLE; ?></span>
			</td></tr>
	</table>
	<br>	
	<form action="index2.php" method="POST" name="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
	   	<tr><td colspan="3">&nbsp;</td></tr>
      	<tr>        	
			<td width="20%" align="right" valign="top"><b><?php echo _INTROTEXT_CONFIG1T; ?></b></td>
			<td align="left" valign="middle"><?php echo $catslist; ?></td>
			<td align="left" valign="middle"><?php echo _INTROTEXT_CONFIG1D; ?></td>
		</tr>		
		<tr><td colspan="3">&nbsp;</td></tr>
		<?php if ($catIntroText) { ?>
		<TR><th colspan="3" align="center"><?php echo _INTROTEXT_CONFIG_WARNING; ?></Th></TR>		
		<?php } ?>
	</table>	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<TR><td>&nbsp;</TD></TR>
		<TR><td align="center">
				<INPUT CLASS="button" TYPE="submit" NAME="submitsave" VALUE="<?php echo _INTROTEXT_SAVE; ?>">
			</TD></TR>		
		<TR><td>&nbsp;</TD></TR>
	</TABLE>
		<input type="hidden" name="func" value="saveconfig" />
		<input type="hidden" name="option" value="com_introtext" />
		<input type="hidden" name="task" value="" />
	</form>
	<?php HTML_introtext::footerfrontHTML();
}

//****************************************************************************************************
//									ABOUT ME
//****************************************************************************************************
function footerfrontHTML()
{	global $introtextver;	?>
	<br>
	<table cellpadding="8" cellspacing="0" border="0" width="100%">
		<tr> 
			<td width="100%" align="center">
				<font color="#CC9933" size="1"><b>IntroText <?php echo $introtextver; ?></b> -
				<a href="mailto:aclaina@yahoo.com.ar">Barbara Irene Meclazcke (Aclaina)</a> -
				<a href="http://ewriting.com.ar" target="_blank">ewriting.com.ar</a></font>
			</TD>
		</TR>
	</table>
	<?php
}

}/// class HTML_introtext
?>
