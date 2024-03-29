<?php
/**
* This file has been modified by Vincent Cheah, ByOS Technologies 2005-12-02 16:37 
* for integration with JACLPlus Component 
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: ps_config.php,v 1.9 2005/10/25 19:33:52 soeren_nb Exp $
* @package VirtueMart
* @subpackage classes
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

class ps_config {

/****************************************************************************
 *    function: writeconfig
 *  created by: soeren
 * description: writes the virtuemart.cfg.php
 *  parameters: passed by html from
 *     returns: true if successful
 ****************************************************************************/

function writeconfig(&$d) {
    global $my, $db;
    
	$group_id = intval( $d['conf_VM_PRICE_ACCESS_LEVEL'] );
	$db->query( 'SELECT name FROM #__core_acl_aro_groups WHERE group_id=\''.$group_id.'\'' );
	$db->next_record();
	$d['conf_VM_PRICE_ACCESS_LEVEL'] = $db->f('name');
	
	$this->prepareaclJACLPlus($d['conf_VM_PRICE_ACCESS_LEVEL']);
	
    if ($_POST['myname'] != "Jabba Binks")
        return false;
    else {
        if ($d['conf_CHECKOUT_STYLE']=='3' || $d['conf_CHECKOUT_STYLE']=='4') {
            $d['conf_NO_SHIPTO'] = '1'; 
        }
        else {
            $d['conf_NO_SHIPTO'] = ''; 
        }
        if( $d['conf_SHIPPING'][0] == "no_shipping" )
            $d['conf_NO_SHIPPING'] = '1';
        
        $d['conf_PSHOP_OFFLINE_MESSAGE'] = addslashes( stripslashes($d['conf_PSHOP_OFFLINE_MESSAGE']));
        
        /** Prevent this config setting from being changed by no-backenders  **/
        if (!defined('_PHSHOP_ADMIN') && !stristr($my->usertype, "admin")) {
          $d['conf_PSHOP_ALLOW_FRONTENDADMIN_FOR_NOBACKENDERS'] = PSHOP_ALLOW_FRONTENDADMIN_FOR_NOBACKENDERS;
        }
        $my_config_array = array(
			"PSHOP_IS_OFFLINE"  =>      "conf_PSHOP_IS_OFFLINE",
            "PSHOP_OFFLINE_MESSAGE"  =>      "conf_PSHOP_OFFLINE_MESSAGE",
            "USE_AS_CATALOGUE"  =>      "conf_USE_AS_CATALOGUE",
            "VM_TABLEPREFIX"  =>      "conf_VM_TABLEPREFIX",
            "VM_PRICE_SHOW_PACKAGING_PRICELABEL"  =>      "conf_VM_PRICE_SHOW_PACKAGING_PRICELABEL",
            "VM_PRICE_SHOW_INCLUDINGTAX"  =>      "conf_VM_PRICE_SHOW_INCLUDINGTAX",
            "VM_PRICE_ACCESS_LEVEL"  =>      "conf_VM_PRICE_ACCESS_LEVEL",
            "VM_SILENT_REGISTRATION"  =>      "conf_VM_SILENT_REGISTRATION",
            "ENABLE_DOWNLOADS"  =>      "conf_ENABLE_DOWNLOADS",
            "DOWNLOAD_MAX"  =>      "conf_DOWNLOAD_MAX",
            "DOWNLOAD_EXPIRE"  =>      "conf_DOWNLOAD_EXPIRE",
            "ENABLE_DOWNLOAD_STATUS"  =>      "conf_ENABLE_DOWNLOAD_STATUS",
            "DISABLE_DOWNLOAD_STATUS"  =>      "conf_DISABLE_DOWNLOAD_STATUS",
            "DOWNLOADROOT"  =>      "conf_DOWNLOADROOT",
            "_SHOW_PRICES"      =>      "conf__SHOW_PRICES",
            "ORDER_MAIL_HTML"   =>      "conf_ORDER_MAIL_HTML",
            "HOMEPAGE"		=>	"conf_HOMEPAGE",
            "FLYPAGE"		=>	"conf_FLYPAGE",
            "CATEGORY_TEMPLATE"		=>	"conf_CATEGORY_TEMPLATE",
            "PRODUCTS_PER_ROW"		=>	"conf_PRODUCTS_PER_ROW",
            "ERRORPAGE"		=>	"conf_ERRORPAGE",
            "NO_IMAGE"		=>	"conf_NO_IMAGE",
            "SEARCH_ROWS"	=>	"conf_SEARCH_ROWS",
            "SEARCH_COLOR_1"	=>	"conf_SEARCH_COLOR_1",
            "SEARCH_COLOR_2"	=>	"conf_SEARCH_COLOR_2",
            "DEBUG"		=>	"conf_DEBUG",
            "SHOWVERSION"	=>  	"conf_SHOWVERSION",
            "PSHOP_ADD_TO_CART_STYLE" => "conf_PSHOP_ADD_TO_CART_STYLE",
            "TAX_VIRTUAL" 	=>      "conf_TAX_VIRTUAL",
            "TAX_MODE" 	        =>      "conf_TAX_MODE",
            "MULTIPLE_TAXRATES_ENABLE" 	        =>      "conf_MULTIPLE_TAXRATES_ENABLE",
            "PAYMENT_DISCOUNT_BEFORE" => "conf_PAYMENT_DISCOUNT_BEFORE",
            "PSHOP_ALLOW_REVIEWS" => "conf_PSHOP_ALLOW_REVIEWS",
            "MUST_AGREE_TO_TOS" =>      "conf_MUST_AGREE_TO_TOS",
            "PSHOP_AGREE_TO_TOS_ONORDER" =>      "conf_PSHOP_AGREE_TO_TOS_ONORDER",
            "LEAVE_BANK_DATA" =>      "conf_LEAVE_BANK_DATA",
            "CAN_SELECT_STATES" =>      "conf_CAN_SELECT_STATES",
            "SHOW_CHECKOUT_BAR"	=>	"conf_SHOW_CHECKOUT_BAR",
            "CHECKOUT_STYLE"	=>	"conf_CHECKOUT_STYLE",
            "CHECK_STOCK"	=>	"conf_CHECK_STOCK",
            "ENCODE_KEY"	=>	"conf_ENCODE_KEY",
            "NO_SHIPPING"    	=>      "conf_NO_SHIPPING",
            "NO_SHIPTO"    	=>      "conf_NO_SHIPTO",
            "AFFILIATE_ENABLE"    	=>      "conf_AFFILIATE_ENABLE",
            "PSHOP_ALLOW_FRONTENDADMIN_FOR_NOBACKENDERS" => "conf_PSHOP_ALLOW_FRONTENDADMIN_FOR_NOBACKENDERS",
            "PSHOP_IMG_RESIZE_ENABLE" => "conf_PSHOP_IMG_RESIZE_ENABLE",
            "PSHOP_IMG_WIDTH" => "conf_PSHOP_IMG_WIDTH",
            "PSHOP_IMG_HEIGHT" => "conf_PSHOP_IMG_HEIGHT",
            "PSHOP_COUPONS_ENABLE" => "conf_PSHOP_COUPONS_ENABLE",
            "PSHOP_PDF_BUTTON_ENABLE" => "conf_PSHOP_PDF_BUTTON_ENABLE",
            "PSHOP_SHOW_PRODUCTS_IN_CATEGORY" => "conf_PSHOP_SHOW_PRODUCTS_IN_CATEGORY",
            "PSHOP_SHOW_TOP_PAGENAV"    	=>      "conf_PSHOP_SHOW_TOP_PAGENAV",
            "PSHOP_SHOW_OUT_OF_STOCK_PRODUCTS"    	=>      "conf_PSHOP_SHOW_OUT_OF_STOCK_PRODUCTS",
            "PSHOP_SHIPPING_MODULE"    	=>      "conf_SHIPPING"
            );
            
    $config = "<?php
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

global \$mosConfig_absolute_path,\$mosConfig_live_site;

if( stristr( \$_SERVER['PHP_SELF'], 'administrator' ))
	@include_once( '../configuration.php' );
else
	@include_once( 'configuration.php' );

// Check for trailing slash
if( \$mosConfig_live_site[strlen( \$mosConfig_live_site)-1] == '/' ) {
	\$app = '';
}
else {
	\$app = '/';
}
// these path and url definitions here are based on the mambo configuration
define( 'URL', \$mosConfig_live_site.\$app );
define( 'SECUREURL', '".$d['conf_SECUREURL']."' );

if( \$_SERVER['SERVER_PORT'] == 443 )
	define( 'IMAGEURL', SECUREURL .'components/com_virtuemart/shop_image/' );
else
	define( 'IMAGEURL', URL .'components/com_virtuemart/shop_image/' );
define( 'COMPONENTURL', URL .'administrator/components/com_virtuemart/' );
define( 'ADMINPATH', \$mosConfig_absolute_path.'/administrator/components/com_virtuemart/' );
define( 'CLASSPATH', ADMINPATH.'classes/' );
define( 'PAGEPATH', ADMINPATH.'html/' );
define( 'IMAGEPATH', \$mosConfig_absolute_path.'/components/com_virtuemart/shop_image/' );\n\n";

    while (list($key, $value) = each($my_config_array)) {
        if($key == "PSHOP_SHIPPING_MODULE" ) {
            $config .= "\n/* Shipping Methods Definition */\nglobal \$PSHOP_SHIPPING_MODULES;\n";
            $i = 0;
            foreach( $d['conf_SHIPPING'] as $shipping_module) {
                $config.= "\$PSHOP_SHIPPING_MODULES[$i] = \"$shipping_module\";\n";
                $i++;
            }
        }
        else
            $config .= "define('".$key."', '".$d[$value]."');\n";
    }
    
    $config .= "?>";

	if ($fp = fopen(ADMINPATH ."virtuemart.cfg.php", "w")) {
		fputs($fp, $config, strlen($config));
		fclose ($fp);

		defined('_PSHOP_ADMIN') ? 
        mosRedirect( "index2.php?page=admin.show_cfg&option=com_virtuemart", "The configuration details have been updated!" ) :
        mosRedirect( "index.php?page=admin.show_cfg&option=com_virtuemart", "The configuration details have been updated!" );

	} else {
        defined('_PSHOP_ADMIN') ? 
        mosRedirect( "index2.php?page=admin.show_cfg&option=com_virtuemart", "An Error Has Occurred! Unable to open config file to write!" ) :
        mosRedirect( "index.php?page=admin.show_cfg&option=com_virtuemart", "An Error Has Occurred! Unable to open config file to write!" );
	}
    }
  } // end function writeconfig
  
	function prepareaclJACLPlus($vm_price_access_level) {
		global $database, $acl;
		
		//$query = "DELETE FROM #__jaclplus WHERE " //delete all
		$query = "UPDATE #__jaclplus SET enable = '0' WHERE " //disable all
		."aco_section = 'virtuemart' AND "
		."aco_value = 'prices' AND "
		."aro_section = 'users'";
		$database->setQuery( $query );
		if(!$database->query()){
			//exit();
		}
		
		$child_groups = $acl->_getBelow( '#__core_acl_aro_groups', 'g1.group_id, g1.name, COUNT(g2.name) AS level',	'g1.name', null, $vm_price_access_level );
		foreach( $child_groups as $child_group ) {
			$this->addaclJACLPlus( 'virtuemart', 'prices', 'users', $child_group->name, null, null );
		}
		$admin_groups = $acl->_getBelow( '#__core_acl_aro_groups', 'g1.group_id, g1.name, COUNT(g2.name) AS level',	'g1.name', null, 'Public Backend' );
		foreach( $admin_groups as $child_group ) {
			$this->addaclJACLPlus( 'virtuemart', 'prices', 'users', $child_group->name, null, null );
		}
	}

	function addaclJACLPlus( $aco_section_value, $aco_value,
		$aro_section_value, $aro_value, $axo_section_value=NULL, $axo_value=NULL ) {
		global $database;

		$query = "SELECT id FROM #__jaclplus WHERE "
		."aco_section ='".$aco_section_value."' AND "
		."aco_value ='".$aco_value."' AND "
		."aro_section ='".$aro_section_value."' AND "
		."aro_value ='".( $aro_value ? strtolower($aro_value) : "public frontend")."' AND "
		.( $axo_section_value ? "axo_section ='".$axo_section_value."' AND " : "axo_section IS NULL AND " )
		.( $axo_value ? "axo_value ='".$axo_value."'" : "axo_value IS NULL");
		$database->setQuery( $query );
		if($jaclplus_id = $database->loadResult()) { //okay found one and enable it
			$query = "UPDATE #__jaclplus SET enable = '1' WHERE "
			."aco_section ='".$aco_section_value."' AND "
			."aco_value ='".$aco_value."' AND "
			."aro_section ='".$aro_section_value."' AND "
			."aro_value ='".( $aro_value ? strtolower($aro_value) : "public frontend")."' AND "
			.( $axo_section_value ? "axo_section ='".$axo_section_value."' AND " : "axo_section IS NULL AND " )
			.( $axo_value ? "axo_value ='".$axo_value."'" : "axo_value IS NULL");
			$database->setQuery( $query );
			if(!$database->query()){
				//exit();
			}
		} else { //okay not found, insert and enable it
			$query = "INSERT INTO #__jaclplus SET aco_section = '".$aco_section_value."', "
				."aco_value = '".$aco_value."', "
				."aro_section = '".$aro_section_value."', "
				."aro_value = '".strtolower($aro_value)."', "
				.( $axo_section_value ? "axo_section = '".$axo_section_value."', " : "axo_section = NULL, " )
				.( $axo_value ? "axo_value = '".$axo_value."', " : "axo_value = NULL, ")
				."enable = '1'";
			$database->setQuery( $query );
			if(!$database->query()){
				//exit();
			}
		}
	}
} // end class ps_config
?>
