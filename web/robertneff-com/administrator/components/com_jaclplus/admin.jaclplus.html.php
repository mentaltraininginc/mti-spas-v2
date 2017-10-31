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

class HTML_jaclplus {
	
	function showAbout( $option ) {
		?>
		<form action="index2.php" method="post" name="adminForm"><div align="left">
<h2 align="center">Component JACLPlus - Version 1.0.4 </h2>
<strong>JACLPlus</strong> Component <em>for Joomla! 1.0.4 Stable </em> <br />
&copy; 2005 Vincent Cheah, ByOS Technologies (www.byostech.com)<br>
             All rights reserved.
  <p>      This component allows you to create new Groups and/or new Access Levels in Joomla! 1.0.4 Stable. </p>
  <ul>
<li><b>IMPORTANT - This component is a HACK for Joomla! 1.0.4 Stable core files.</b></li>
<li><b>IMPORTANT - This component does not work with any other versions of Joomla! except Joomla! 1.0.4 Stable. You have to install this component on Joomla! 1.0.4 Stable ONLY.</b></li>
<li><b>IMPORTANT - This component does not work with any other components, modules, mambots or hacks as the effects of using them with this component is unknown.  
	It is recommended that you install this component on clean/fresh installation of Joomla! 1.0.4 Stable. For components, modules, mambots or hacks that work with this component, please go to <a href="http://www.byostech.com/component/option,com_joomlaboard/Itemid,6/func,showcat/catid,5/">http://www.byostech.com/forum</a> to check.</b></li>
<li>For questions and support please contact the author at <a href="mailto:jaclplus@byostech.com">jaclplus@byostech.com</a> or go to <a href="http://www.byostech.com/forum">http://www.byostech.com/forum</a>.</li>
<li>With this component, you can control your contents to be viewed by groups that created by you. To do this, you can create a new group and assign multiple access levels to that group. This will be more flexible, and you can decise whether to allow registered users to gain access or not.</li>
</ul>
         <p>
            <strong><font color="#FF8000">Note for all version of JACLPlus: </font></strong><br>
            <font size="1">JACLPlus is provided as free software and therefore provided 'as-is'.
            The ByOS Technologies, its subsidiaries, its developers, contributors 
            and its parental legal entities (formally or informally) (these will further be referenced as 'BYOS') 
            offer you JACLPlus for absolutely free for your own personal use, pleasure and education. 
            The BYOS reserves the right to charge corporate or  commercial users of the Software for this 
           or future versions or support on a paid basis. </font>        </p>
         <p><font size="1">Any JACLPlus version may contain errors, bugs and/or can cause problems otherwise. By installing this software, you have agreed to waive BYOS from whatever form of liability and/or 
            responsibility for any problems and/or damages done by this software to you, your web environment 
            or in any other way legally, financially, socially, emotionally or whatever other ~ally you could 
   possibly imagine and find a legal article for that favours your rights...<br>
     In short and slightly more human readable: Use this software at your own risk; 
      we don't guarantee anything! </font></p>
         <p><font size="1">By using JACLPlus, 
               it's your way of answering: &quot;Yes,I know... trust me, I know what I'm 
            doing so it'll be my own fault if things go wrong and I don't care&quot;...</font>
           <br>
           <font size="1">Have fun with JACLPlus! We know you will!!!</font>
         </p></div>
		 <input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	function showGroups( &$rows, $option ) {
		?>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="user">
			<?php echo _JACL_G_MANAGER; ?>
			</th>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<?php echo _JACL_G_DEFAULT; ?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="2%" class="title">
			#
			</th>
			<th width="3%" class="title">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title">
			<?php echo _JACL_G_NAME; ?>
			</th>
			<th width="70%" class="title" >
			<?php echo _JACL_G_ACCESS_LEVELS; ?> </th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	=& $rows[$i];

			$link 	= 'index2.php?option='.$option.'&amp;task=editA&amp;id='. $row->group_id. '&amp;hidemainmenu=1';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i+1;?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->group_id ); ?>
				</td>
				<td>
				<a href="<?php echo $link; ?>">
				<?php echo $row->name; ?>
				</a>
				</td>
				<td>
				<?php echo $row->jaclplus; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	function editGroup( &$row, $option, $gid, $lists ) {
		global $my, $acl;
		global $mosConfig_live_site;
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			} else if (pressbutton == 'addACL') {
				form.subtask.value = "addACL";
				submitform( 'editA' );
				return;
			}
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

			// do field validation
			if (trim(form.name.value) == "") {
				alert( "<?php echo _JACL_G_PROVIDE_NAME; ?>" );
			} else if (r.exec(form.name.value) || form.name.value.length < 3) {
				alert( "<?php echo _JACL_G_INVALID_CHARS; ?>" );
			} else if (!isSelected(form.access)) {
				alert( "<?php echo _JACL_G_ASSIGN_A; ?>" );
			} else {
				submitform( pressbutton );
			}
		}
		function isSelected(form_element) {
			var form = document.adminForm;
			var isSelected = false;
			form.jaclplus.value = "";
			for (i=0; i < form_element.length; i++) {
				if (form_element.options[i].selected) {
					isSelected = true;
					form.jaclplus.value += form_element.options[i].value + ",";
				}
			}
			form.jaclplus.value = form.jaclplus.value.substr(0, form.jaclplus.value.length-1);
			return isSelected;
		}
		function specialbutton(pressbutton,aclid,myvalue) {
			var form = document.adminForm;
			form.aclid.value = aclid;
			form.myvalue.value = myvalue;
			form.hidemainmenu.value = "1";
			if (pressbutton == 'removeACL') {
				if (confirm("<?php echo _JACL_ACL_CONFIRM_REMOVE; ?>")) {
					form.subtask.value = "removeACL";
					submitform( 'editA' );
					return;
				}
			} else if (pressbutton == 'editACL') {
				if (confirm("<?php echo _JACL_ACL_CONFIRM_EDIT; ?>")) {
					form.subtask.value = "editACL";
					submitform( 'editA' );
					return;
				}
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="group">
			<?php echo _JACL_G_ID; ?> <small><?php echo $row->group_id ? _JACL_EDIT : _JACL_ADD;?></small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo _JACL_G_DETAILS; ?>
					</th>
				</tr>
				<tr>
				  <td><?php echo _JACL_G_ID; ?> </td>
				  <td><?php echo $row->group_id ? $row->group_id : _JACL_NEW;?>&nbsp;</td>
				  </tr>
				<tr>
					<td valign="top">
					<?php echo _JACL_PARENT_G; ?>
					</td>
					<td>
					<?php echo $lists['parent_id']; ?>
					</td>
				</tr>
				<tr>
					<td width="100">
					<?php echo _JACL_GROUP_NAME; ?>
					</td>
					<td width="85%">
					<?php echo $lists['name']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
					<?php echo _JACL_ACCESS_LEVEL; ?>
					</td>
					<td>
					<?php echo $lists['access']; ?> <?php echo _JACL_PREESS_CTL; ?>
					</td>
				</tr>
				<?php if ( $row->group_id < 1 ) { // new add only ?>
				<tr>
					<td valign="top">
					<?php echo _JACL_G_INHERIT_FROM; ?>
					</td>
					<td>
					<?php echo $lists['inheritfrom']; ?>
					</td>
				</tr>
				<?php } ?>
				</table>
			</td>
		  </tr>
		</table>
<?php
 	if( $row->group_id ) {
		 showGroupACL( $row, $option );
	}
?>
		<input type="hidden" name="id" value="<?php echo $row->group_id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="subtask" value="" />
		<input type="hidden" name="aclid" value="" />
		<input type="hidden" name="myvalue" value="" />
		<input type="hidden" name="jaclplus" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	function showGroupACL( &$rows, &$group_info, $lists, $option ) {
		global $my;
		$canEdit = jaclplus_check( $group_info->group_id );
		?>
		<table class="adminlist">
		<tr>
			<th width="2%" class="title">
			#
			</th>
			<th width="3%" class="title">
			<!-- <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" /> -->
			<?php echo _JACL_ACO_ADD_REMOVE; ?>
			</th>
			<th class="title">
			<?php echo _JACL_ACO_SECTION; ?> </th>
			<th class="title" >
			<?php echo _JACL_ACO_VALUE; ?> </th>
			<th class="title">
			<?php echo _JACL_ARO_SECTION; ?> </th>
			<th class="title" >
			<?php echo _JACL_ARO_VALUE; ?> </th>
			<th class="title">
			<?php echo _JACL_AXO_SECTION; ?> </th>
			<th class="title" >
			<?php echo _JACL_AXO_VALUE; ?> </th>
			<th class="title" >
			<?php echo _JACL_ACL_ENABLE; ?> </th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	=& $rows[$i];
			if ($canEdit) {
				$link 	= 'javascript: specialbutton(\'removeACL\',\''.$row->id.'\',\''.$row->enable.'\');';
				$link2 	= 'javascript: specialbutton(\'editACL\',\''.$row->id.'\',\''.$row->enable.'\');';
			} else {
				$link 	= 'javascript: void(0);';
				$link2 	= 'javascript: void(0);';
			}
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i+1;?>
				</td>
				<td>
				<a href="<?php echo $link; ?>" title="<?php echo _JACL_ACO_REMOVE_TAG; ?>">
				<?php echo _JACL_ACO_REMOVE; ?>
				</a>
				</td>
				<td>
				<?php echo $row->aco_section; ?>
				</td>
				<td>
				<?php echo $row->aco_value; ?>
				</td>
				<td>
				<?php echo $row->aro_section; ?>
				</td>
				<td>
				<?php echo $row->aro_value; ?>
				</td>
				<td>
				<?php echo $row->axo_section; ?>
				</td>
				<td>
				<?php echo $row->axo_value; ?>
				</td>
				<td>
				<a href="<?php echo $link2; ?>" title="<?php echo _JACL_ACL_EDIT_TAG; ?>">
				<?php echo $row->enable ? _JACL_ACL_YES : _JACL_ACL_NO ; ?>
				</a>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		if ($canEdit) {
		?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i+1;?>
				</td>
				<td>
				<a href="javascript: submitbutton('addACL');" title="<?php echo _JACL_ACL_ADD_TAG; ?>">
				<?php echo "[ + ]"; ?>
				</a>
				</td>
				<td>
				<?php echo $lists['aco_section']; ?>
				</td>
				<td>
				<?php echo $lists['aco_value']; ?>
				</td>
				<td>
				users
				</td>
				<td>
				<?php echo strtolower($group_info->name); ?>
				</td>
				<td>
				<?php echo $lists['axo_section']; ?>
				</td>
				<td>
				<?php echo $lists['axo_value']; ?>
				</td>
				<td>
				<?php echo $lists['yes_no']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="6">
				<?php 
				$link 	= 'index2.php?option='.$option.'&amp;task=editA&amp;id='. $my->gid. '&amp;hidemainmenu=1';
				echo _JACL_ACL_ADD_MSG; ?> 
				<a href="<?php echo $link; ?>" target="_blank">
				<?php echo _JACL_G_YOUR_ACL; ?>
				</a>
				</td>
			</tr>
		<?php } ?>
		</table>
		<?php
	}

	function showAccess( &$rows, $option ) {
		?>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="user">
			<?php echo _JACL_A_MANAGER; ?>
			</th>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<?php echo _JACL_A_DEFAULT; ?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="2%" class="title">
			#
			</th>
			<th width="3%" class="title">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title">
			<?php echo _JACL_A_NAME; ?>
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	=& $rows[$i];

			$link 	= 'index2.php?option='.$option.'&amp;task=editALA&amp;id='. $row->id. '&amp;hidemainmenu=1';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i+1;?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id ); ?>
				</td>
				<td>
				<a href="<?php echo $link; ?>">
				<?php echo $row->name; if($row->id <= 2) echo _JACL_ASTERISK;?>
				</a>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	function editaccess( $option, $id, $lists ) {
		global $my, $acl;
		global $mosConfig_live_site;
		if($id==-1){
			$isNew = true;
		}else{
			$isNew = false;
		}
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancelAL') {
				submitform( pressbutton );
				return;
			}
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

			// do field validation
			if (trim(form.name.value) == "") {
				alert( "<?php echo _JACL_A_PROVIDE_NAME; ?>" );
			} else if (r.exec(form.name.value) || form.name.value.length < 3) {
				alert( "<?php echo _JACL_A_INVALID_CHARS; ?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="group">
			<?php echo _JACL_A_ID; ?> <small><?php echo $isNew ? _JACL_ADD : _JACL_EDIT;?></small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo _JACL_A_DETAILS; ?>
					</th>
				</tr>
				<tr>
				  <td><?php echo _JACL_A_ID; ?> </td>
				  <td><?php echo $isNew ? _JACL_NEW : $id;?>&nbsp;</td>
				  </tr>
				<tr>
					<td width="100">
					<?php echo _JACL_ACCESS_LEVEL_NAME; ?>
					</td>
					<td width="85%">
					<?php echo $lists['name']; ?>
					</td>
				</tr>
				</table>
			</td>
		  </tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="jaclplus" value="" />
		</form>
		<?php
	}
}
?>