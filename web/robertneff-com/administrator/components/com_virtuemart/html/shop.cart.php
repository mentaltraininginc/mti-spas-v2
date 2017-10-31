<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: shop.cart.php,v 1.2 2005/09/27 17:51:26 soeren_nb Exp $
* @package VirtueMart
* @subpackage html
* @copyright Copyright (C) 2004-2005 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
mm_showMyFileName( __FILE__ );

$mainframe->setPageTitle( $VM_LANG->_PHPSHOP_CART_TITLE );

$show_basket = true;

?>
<h2><?php echo $VM_LANG->_PHPSHOP_CART_TITLE ?></h2>
<!-- Cart Begins here -->
<?php include(PAGEPATH. 'basket.php'); ?>
<!-- End Cart -->
<?php
if ($cart["idx"]) {
 ?>
 <br />
 <div style="float:left; width:50%;">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td>
				<a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">
				<img src="<?php echo IMAGEURL ?>ps_image/back.png" align="middle" width="32" height="32" alt="Back" border="0" />
				</a>
			</td>
			<td valign="middle" style="padding-top:6px">
				<h3>
				<a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">
					<?php echo $VM_LANG->_PHPSHOP_CONTINUE_SHOPPING; ?>
				</a>
				</h3>
			</td>
		</tr>
	</table>
</div>
 <?php
   if (!defined('_MIN_POV_REACHED')) { ?>
       <div style="text-align:center;width:40%;float:left;">
       <br /><br />
           <span style="font-weight:bold;"><?php echo $VM_LANG->_PHPSHOP_CHECKOUT_ERR_MIN_POV2 . " ".$CURRENCY_DISPLAY->getFullValue($_SESSION['minimum_pov']) ?></span>
       </div><?php
   }
   else {
 ?>
<div style="float:left; width:50%;">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td valign="middle" style="padding:6px">
				<h3>
				  <a href="<?php $sess->purl( $mm_action_url .
				  		"index.php?page=checkout.index&ssl_redirect=1"); ?>">
      			  <?php echo $VM_LANG->_PHPSHOP_CHECKOUT_TITLE_A ?>
			      </a>
				</h3>
			</td>
			<td>
				<a href="<?php $sess->purl( $mm_action_url .
					"index.php?page=checkout.index&ssl_redirect=1"); ?>">
					&nbsp;&nbsp;<img src="<?php echo IMAGEURL ?>ps_image/forward.png" align="middle" width="32" height="32" alt="Forward" border="0" />
				</a>
			</td>
		</tr>
	</table>
</div>
 
 <?php
 }
 ?>
<br style="clear:both;" /><br/>

<?php
// End if statement
}
?>

