<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
* The configuration file for VirtueMart
*
* @package VirtueMart
* @subpackage core
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

global $mosConfig_absolute_path,$mosConfig_live_site;

if( stristr( $_SERVER['PHP_SELF'], 'administrator' ))
	@include_once( '../configuration.php' );
else
	@include_once( 'configuration.php' );

// Check for trailing slash
if( $mosConfig_live_site[strlen( $mosConfig_live_site)-1] == '/' ) {
	$app = '';
}
else {
	$app = '/';
}
// these path and url definitions here are based on the mambo configuration
define( 'URL', $mosConfig_live_site.$app );
define( 'SECUREURL', 'https://www.robertneff.com/' );

if( $_SERVER['SERVER_PORT'] == 443 )
	define( 'IMAGEURL', SECUREURL .'components/com_virtuemart/shop_image/' );
else
	define( 'IMAGEURL', URL .'components/com_virtuemart/shop_image/' );
define( 'COMPONENTURL', URL .'administrator/components/com_virtuemart/' );
define( 'ADMINPATH', $mosConfig_absolute_path.'/administrator/components/com_virtuemart/' );
define( 'CLASSPATH', ADMINPATH.'classes/' );
define( 'PAGEPATH', ADMINPATH.'html/' );
define( 'IMAGEPATH', $mosConfig_absolute_path.'/components/com_virtuemart/shop_image/' );

define('PSHOP_IS_OFFLINE', '');
define('PSHOP_OFFLINE_MESSAGE', '<h2>Our Shop is currently down for maintenance.</h2> Please check back again soon, or <a href=http://www.robertneff.com/index.php?option=com_contact&task=view&contact_id=1&Itemid=20>contact us directly here</a>.<br />
<br />
We apologize for any inconvenience this may have caused.<br />
<br />
- The Management');
define('USE_AS_CATALOGUE', '');
define('VM_TABLEPREFIX', 'vm');
define('VM_PRICE_SHOW_PACKAGING_PRICELABEL', '');
define('VM_PRICE_SHOW_INCLUDINGTAX', '');
define('VM_PRICE_ACCESS_LEVEL', 'Public Frontend');
define('VM_SILENT_REGISTRATION', '');
define('ENABLE_DOWNLOADS', '1');
define('DOWNLOAD_MAX', '3');
define('DOWNLOAD_EXPIRE', '432000');
define('ENABLE_DOWNLOAD_STATUS', 'P');
define('DISABLE_DOWNLOAD_STATUS', 'X');
define('DOWNLOADROOT', '/homepages/43/d150783187/htdocs/robertneff_com/downloadss/');
define('_SHOW_PRICES', '1');
define('ORDER_MAIL_HTML', '1');
define('HOMEPAGE', 'shop.index');
define('FLYPAGE', 'shop.flypage_ebook_1');
define('CATEGORY_TEMPLATE', 'browse_6');
define('PRODUCTS_PER_ROW', '1');
define('ERRORPAGE', 'shop.error');
define('NO_IMAGE', '/ps_image/noimage.gif');
define('SEARCH_ROWS', '50');
define('SEARCH_COLOR_1', '#f9f9f9');
define('SEARCH_COLOR_2', '#f0f0f0');
define('DEBUG', '');
define('SHOWVERSION', '');
define('PSHOP_ADD_TO_CART_STYLE', 'add-to-cart_yellow.gif');
define('TAX_VIRTUAL', '');
define('TAX_MODE', '1');
define('MULTIPLE_TAXRATES_ENABLE', '');
define('PAYMENT_DISCOUNT_BEFORE', '');
define('PSHOP_ALLOW_REVIEWS', '1');
define('MUST_AGREE_TO_TOS', '1');
define('PSHOP_AGREE_TO_TOS_ONORDER', '1');
define('LEAVE_BANK_DATA', '');
define('CAN_SELECT_STATES', '1');
define('SHOW_CHECKOUT_BAR', '1');
define('CHECKOUT_STYLE', '4');
define('CHECK_STOCK', '');
define('ENCODE_KEY', 'VM_Is_Stuff');
define('NO_SHIPPING', '1');
define('NO_SHIPTO', '1');
define('AFFILIATE_ENABLE', '1');
define('PSHOP_ALLOW_FRONTENDADMIN_FOR_NOBACKENDERS', '');
define('PSHOP_IMG_RESIZE_ENABLE', '1');
define('PSHOP_IMG_WIDTH', '90');
define('PSHOP_IMG_HEIGHT', '150');
define('PSHOP_COUPONS_ENABLE', '1');
define('PSHOP_PDF_BUTTON_ENABLE', '');
define('PSHOP_SHOW_PRODUCTS_IN_CATEGORY', '1');
define('PSHOP_SHOW_TOP_PAGENAV', '1');
define('PSHOP_SHOW_OUT_OF_STOCK_PRODUCTS', '1');

/* Shipping Methods Definition */
global $PSHOP_SHIPPING_MODULES;
$PSHOP_SHIPPING_MODULES[0] = "no_shipping";
?>