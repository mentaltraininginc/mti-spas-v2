<?

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
 * This file provides cart and checkout functions
 * to Virtuemart v1.0.0+. It requires specific function
 * calls in ps_cart.php, ps_checkout.php, and payment modules.
 *
 * Install this file in administator/components/com_virtuermart/classes.
 * Add "include_once('ps_ptp_functions.php');" to end of ps_main.php.
 * Requires ps_database.php to have loadAssocList() method added.
 * Requires language file modifications for messages
 *
 * @author Kawika Ohumukini
 * @copyright Copyright (C) 2005 Kawika Ohumukini. All rights reserved.
 * @version $Id: ps_ptp_functions.php,v 0.2.0 2005/12/17 00:15:22
 */

################## RETRIEVE PRODUCT TYPE INFORMATION ##################
/**
 * gets all product type parameters and set values for a product
 *
 * @param integer $product_id the id of the product
 * @return array of parameters and the product set values
 * @author kawika ohumukini
 */
function get_param_values($product_id){
	$db = new ps_DB;
	$fields = get_param($product_id);
	if (count($fields)) {
		list($data['product_type_id'], $data['product_type_name']) = get_product_type_data($product_id);
		if ($data['product_type_id'])
			return get_param_product_values($product_id, $data['product_type_id'], $fields);
	}
}
/**
 * gets all product type parameter names for product
 *
 * @param integer $product_id the id of the product
 * @return array of parameter names
 * @author kawika ohumukini
 */
function get_param($product_id){
	$db = new ps_DB;
	$query = "SELECT 
		#__{vm}_product_type_parameter.parameter_name
	FROM 
		#__{vm}_product_product_type_xref
		, #__{vm}_product_type_parameter
	WHERE 
		#__{vm}_product_product_type_xref.product_id='$product_id' 
		AND #__{vm}_product_product_type_xref.product_type_id = #__{vm}_product_type_parameter.product_type_id";
	$db->setQuery( $query );
	return $db->loadAssocList();
}
/**
 * gets all product type parameter values for product
 *
 * @param integer $product_id the id of the product
 * @return array of parameter name => values
 * @author kawika ohumukini
 */
function get_param_product_values($product_id, $product_type_id, $fields) {
	$db = new ps_DB;
	if ($product_id && $product_type_id) {
		$query = "SELECT * FROM #__{vm}_product_type_$product_type_id WHERE product_id = '$product_id'";
		$db->setQuery( $query );
		$db->query();
		if ($db->next_record()) {
			foreach ($fields as $field)
				$results[$field['parameter_name']] = $db->f($field['parameter_name']);
			return $results;
		}
	}
}
/**
 * gets product type data necessary to
 * retrieve product values and display product type name
 *
 * @param integer $product_id the id of the product
 * @return array of product type id and name
 * @author kawika ohumukini
 */
function get_product_type_data($product_id){
	$db = new ps_DB;
	$query = "SELECT 
		#__{vm}_product_product_type_xref.product_type_id
		, #__{vm}_product_type.product_type_name
	FROM 
		#__{vm}_product_product_type_xref
		, #__{vm}_product_type
	WHERE 
		#__{vm}_product_product_type_xref.product_id='$product_id' 
		AND #__{vm}_product_type.product_type_id = #__{vm}_product_product_type_xref.product_type_id";
	$db->setQuery( $query );
	$db->query();
	if ($db->next_record())
		return array($db->f('product_type_id'), $db->f('product_type_name'));
}

################## MAIN PARAMETER CALLS ##################

/**
 * pre-process add cart request
 *
 * @param array of values product_id, quantity, product_description (optional)
 * @return array original and/or modified data
 * @author kawika ohumukini
 */
function ptp_main_cart_add($data){
	global $vmLogger, $VM_LANG;
	if ($data['product_id'] && $data) {
		$params = get_param_values($data['product_id']);
		$cart_quantity = get_param_cart_quantity($data['product_id'], $params);
		$cart_max_quantity = get_param_max_qty($data['product_id'], $params);
		// 
		if ($new_user_level = get_param_user_level($data['product_id'], $params))
			$data['new_user_level'] = $new_user_level;
		// 
		if (get_param_buy_alone($data['product_id'], $params) && $_SESSION["cart"]["idx"]) {
			$vmLogger->err( $VM_LANG->_PHPSHOP_CART_PARAM_RECUR );
			$data['quantity'] = 0;
			return $data;
		}
		// 
		if (!get_param_buy_alone($data['product_id'], $params) && cart_has_buy_alone($data['product_id'])) {
			$vmLogger->err( $VM_LANG->_PHPSHOP_CART_PARAM_RECUR );
			$data['quantity'] = 0;
			return $data;
		}
		// 
		if (get_param_block_sku($data['product_id'], $params) && (get_param_block_sku_cart($data['product_id'], $params) || get_param_block_sku_bought($data['product_id'], $params))) {
			$vmLogger->err( $VM_LANG->_PHPSHOP_CART_PARAM_BLOCKED_SKU );
			$data['quantity'] = 0;
			return $data;
		}
		if (get_param_req_sku($data['product_id'], $params) && !get_param_req_sku_cart($data['product_id'], $params) && !get_param_req_sku_bought($data['product_id'], $params)) {
			$vmLogger->err( $VM_LANG->_PHPSHOP_CART_PARAM_REQUIRED_SKU );
			$data['quantity'] = 0;
			return $data;
		}
		// 
		if ($cart_max_quantity && $cart_quantity + $data['quantity'] > $cart_max_quantity) {
			$vmLogger->warning( $VM_LANG->_PHPSHOP_CART_PARAM_QUANTITY_EXCEEDED );
			$data['quantity'] = $cart_max_quantity - $cart_quantity;
			if ($data['quantity'] < 0)
				$data['quantity'] = 0;
			return $data;
		}
	}
	return $data;
}
/**
 * pre-process update cart request
 *
 * @param array of values product_id, quantity, product_description
 * @return array original and/or modified data
 * @author kawika ohumukini
 */
function ptp_main_cart_update($data){
	global $vmLogger, $VM_LANG;
	if ($data['product_id']) {
		$params = get_param_values($data['product_id']);
		$cart_quantity = get_param_cart_quantity($data['product_id'], $params);
		$cart_max_quantity = get_param_max_qty($data['product_id'], $params);
		// 
		if (get_param_block_sku($data['product_id'], $params) && (get_param_block_sku_cart($data['product_id'], $params) || get_param_block_sku_bought($data['product_id'], $params))) {
			$vmLogger->err( $VM_LANG->_PHPSHOP_CART_PARAM_BLOCKED_SKU );
			$data['quantity'] = 0;
			return $data;
		}
		if (get_param_req_sku($data['product_id'], $params) && !get_param_req_sku_cart($data['product_id'], $params) && !get_param_req_sku_bought($data['product_id'], $params)) {
			$vmLogger->err( $VM_LANG->_PHPSHOP_CART_PARAM_REQUIRED_SKU );
			$data['quantity'] = 0;
			return $data;
		}
		// 
		if ($cart_max_quantity && $data['quantity'] > $cart_max_quantity) {
			$vmLogger->warning( $VM_LANG->_PHPSHOP_CART_PARAM_QUANTITY_EXCEEDED );
			$data['quantity'] = $cart_max_quantity;
			if ($data['quantity'] < 0)
				$data['quantity'] = 0;
			return $data;
		}
	}
	return $data;
}
/**
 * pre-process update cart request
 *
 * @param array of values product_id, quantity, product_description
 * @return array original and/or modified data
 * @author kawika ohumukini
 */
function ptp_main_cart_delete($data){
	global $vmLogger, $VM_LANG;
	if ($data['product_id']) {
		$params = get_param_values($data['product_id']);
		$cart_quantity = get_param_cart_quantity($data['product_id'], $params);
		$cart_max_quantity = get_param_max_qty($data['product_id'], $params);
		// 
		if (get_param_block_sku($data['product_id'], $params) && (get_param_block_sku_cart($data['product_id'], $params) || get_param_block_sku_bought($data['product_id'], $params))) {
			$vmLogger->err( $VM_LANG->_PHPSHOP_CART_PARAM_BLOCKED_SKU );
			$data['quantity'] = 0;
			return $data;
		}
		if (get_param_req_sku($data['product_id'], $params) && !get_param_req_sku_cart($data['product_id'], $params) && !get_param_req_sku_bought($data['product_id'], $params)) {
			$vmLogger->err( $VM_LANG->_PHPSHOP_CART_PARAM_REQUIRED_SKU );
			$data['quantity'] = 0;
			return $data;
		}
		// 
		if ($cart_max_quantity && $data['quantity'] > $cart_max_quantity) {
			$vmLogger->warning( $VM_LANG->_PHPSHOP_CART_PARAM_QUANTITY_EXCEEDED );
			$data['quantity'] = $cart_max_quantity;
			if ($data['quantity'] < 0)
				$data['quantity'] = 0;
			return $data;
		}
	}
	return $data;
}
/**
 * pre-process update cart request
 *
 * @param array of values product_id, quantity, product_description
 * @return array original and/or modified data
 * @author kawika ohumukini
 */
function ptp_main_cart_checkout($data){
	global $vmLogger, $VM_LANG;
	if ($data['product_id']) {
		$params = get_param_values($data['product_id']);
		$cart_quantity = get_param_cart_quantity($data['product_id'], $params);
		// 
		if (get_param_recur($data['product_id'], $params))
			return $params;
	}
	return $data;
}

################## INDIVIDUAL PARAMETER VALUES ##################

/**
 * returns the quantity of this product in cart
 *
 * @param integer $product_id the id of the product
 * @param array $params the product parameter names and values
 * @return integer product_id cart quantity
 * @author kawika ohumukini
 */
function get_param_cart_quantity($product_id, $params){
	if ($product_id) {
		if (!$params)
			$params = get_param_values($product_id);
		for ($i=0;$i<$_SESSION['cart']['idx'];$i++)
			if (
				$product_id == $_SESSION['cart'][$i]['product_id']
			)
				$cart_quantity += $_SESSION['cart'][$i]['quantity'];
		return $cart_quantity;
	}
}
/**
 * returns the maximum quantity of this product that may be in cart
 *
 * @param integer $product_id the id of the product
 * @param array $paramsthe product parameter names and values
 * @return integer maximum quantity
 * @author kawika ohumukini
 */
function get_param_max_qty($product_id, $params){
	if ($product_id) {
		if (!$params)
			$params = get_param_values($product_id);
		return $params['max_qty'];
	}
}
/**
 * checks for recurring billing setting
 *
 * @param integer $product_id the id of the product
 * @param array $paramsthe product parameter names and values
 * @return boolean recurring is set to Yes
 * @author kawika ohumukini
 */
function get_param_recur($product_id, $params){
	if ($product_id) {
		if (!$params)
			$params = get_param_values($product_id);
		if ($params['recur'] == 'Yes')
			return true;
	}
}
/**
 * checks if product must be purchased seperately
 *
 * @param integer $product_id the id of the product
 * @param array $params the product parameter names and values
 * @return boolean if buy_alone set to Yes
 * @author kawika ohumukini
 */
function get_param_buy_alone($product_id, $params){
	if ($product_id) {
		if (!$params)
			$params = get_param_values($product_id);
		if ($params['buy_alone'] == 'Yes')
			return true;
	}
}
/**
 * checks if product will assign a new user level
 *
 * @param integer $product_id the id of the product
 * @return string new user level
 * @author kawika ohumukini
 */
function get_param_user_level($product_id, $params){
	if ($product_id) {
		if (!$params)
			$params = get_param_values($product_id);
		return $params['user_level'];
	}
}
/**
 * checks if product has a default product status on checkout
 *
 * @param integer $product_id the id of the product
 * @return boolean if cart has buy_alone products
 * @author kawika ohumukini
 */
function get_param_order_status($product_id, $params){
	if ($product_id) {
		if (!$params)
			$params = get_param_values($product_id);
		return $params['order_status'];
	}
}
/**
 * checks if product requires existing products in cart or purchased
 *
 * @param integer $product_id the id of the product
 * @return boolean if product requires existing products
 * @author kawika ohumukini
 */
function get_param_block_sku($product_id, $params){
	if ($product_id) {
		if (!$params)
			$params = get_param_values($product_id);
		return $params['block_sku'];
	}
}
/**
 * checks if product requires existing products in cart or purchased
 *
 * @param integer $product_id the id of the product
 * @return boolean if product requires existing products
 * @author kawika ohumukini
 */
function get_param_req_sku($product_id, $params){
	if ($product_id) {
		if (!$params)
			$params = get_param_values($product_id);
		return $params['req_sku'];
	}
}
/**
 * checks if blocked products are in cart
 *
 * @param integer $product_id the id of the product
 * @return boolean if cart has buy_alone products
 * @author kawika ohumukini
 */
function get_param_block_sku_cart($product_id, $params){
	if ($product_id) {
		$db = new ps_DB;
		if (!$params)
			$params = get_param_values($product_id);
		if ($skuList = get_param_block_sku($product_id)) {
			$skuList = explode(",", $skuList);
			for ($i=0;$i<$_SESSION['cart']['idx'];$i++)
				$idList .= $_SESSION['cart'][$i]['product_id'] != $product_id ? $_SESSION['cart'][$i]['product_id']."," : '';
			if ($idList) {
				$idList = substr($idList,0,strlen($idList)-1);
				$query = "SELECT 
					p.product_sku 
				FROM 
					#__{vm}_product p
				WHERE 
					p.product_id IN ('$idList')";
				$db->setQuery( $query );
				$db->query();
				while ($db->next_record()) {
					if (in_array($db->f('product_sku'), $skuList))
						return true;
				}
			}
		}
	}
}
/**
 * checks if blocked products are purchased
 *
 * @param integer $product_id the id of the product
 * @return boolean if cart has buy_alone products
 * @author kawika ohumukini
 */
function get_param_block_sku_bought($product_id, $params){
	if ($product_id) {
		$db = new ps_DB;
		if (!$params)
			$params = get_param_values($product_id);
		if ($skuList = get_param_req_sku($product_id)) {
			$skuList = ereg_replace(",", "','", $skuList);
			$query = "SELECT 
				o.order_id 
			FROM 
				#__{vm}_orders o
				, #__{vm}_order_item i
			WHERE 
				i.order_item_sku IN ('$skuList') 
				AND o.order_id = i.order_id 
				AND o.order_status IN ('C','S') 
				AND i.order_status IN ('C','S')";
			$db->setQuery( $query );
			$db->query();
			if ($db->next_record())
				return true;
		}
	}
}
/**
 * checks if required products are in cart
 *
 * @param integer $product_id the id of the product
 * @return boolean if cart has buy_alone products
 * @author kawika ohumukini
 */
function get_param_req_sku_cart($product_id, $params){
	if ($product_id) {
		$db = new ps_DB;
		if (!$params)
			$params = get_param_values($product_id);
		if ($skuList = get_param_req_sku($product_id)) {
			$skuList = explode(",", $skuList);
			for ($i=0;$i<$_SESSION['cart']['idx'];$i++)
				$idList .= $_SESSION['cart'][$i]['product_id'] != $product_id ? $_SESSION['cart'][$i]['product_id']."," : '';
			if ($idList) {
				$idList = substr($idList,0,strlen($idList)-1);
				$query = "SELECT 
					p.product_sku 
				FROM 
					#__{vm}_product p
				WHERE 
					p.product_id IN ('$idList')";
				$db->setQuery( $query );
				$db->query();
				while ($db->next_record()) {
					if (in_array($db->f('product_sku'), $skuList))
						return true;
				}
			}
		}
	}
}
/**
 * checks if required products are purchased
 *
 * @param integer $product_id the id of the product
 * @return boolean if cart has buy_alone products
 * @author kawika ohumukini
 */
function get_param_req_sku_bought($product_id, $params){
	if ($product_id) {
		$db = new ps_DB;
		if (!$params)
			$params = get_param_values($product_id);
		if ($skuList = get_param_req_sku($product_id)) {
			$skuList = ereg_replace(",", "','", $skuList);
			$query = "SELECT 
				o.order_id 
			FROM 
				#__{vm}_orders o
				, #__{vm}_order_item i
			WHERE 
				i.order_item_sku IN ('$skuList') 
				AND o.order_id = i.order_id 
				AND o.order_status IN ('C','S') 
				AND i.order_status IN ('C','S')";
			$db->setQuery( $query );
			$db->query();
			if ($db->next_record())
				return true;
		}
	}
}

################## MISCELLANEOUS FUNCTIONS ##################

/**
 * checks buy_alone products are in cart
 *
 * @param integer $product_id the id of the product
 * @param array $paramsthe product parameter names and values
 * @return boolean if cart has buy_alone products
 * @author kawika ohumukini
 */
function cart_has_buy_alone($product_id){
	if ($product_id)
		for ($i=0;$i<$_SESSION['cart']['idx'];$i++)
			if (get_param_buy_alone($_SESSION['cart'][$i]['product_id']))
				return true;
}

/**
 * gets product name
 *
 * @param integer $product_id the id of the product
 * @return string product name
 * @author kawika ohumukini
 */
function get_product_name($product_id) {
	$db = new ps_DB;
	$query = "SELECT 
		#__{vm}_product.product_name
	FROM 
		#__{vm}_product
	WHERE 
		#__{vm}_product.product_id='$product_id'";
	$db->setQuery( $query );
	return $db->loadResult();
}

?>
