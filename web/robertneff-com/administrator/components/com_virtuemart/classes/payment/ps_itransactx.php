<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
 * iTransact XML class
 *
 * This file provides real-time transaction handling
 * to Virtuemart payment processing. It requires the
 * XML service to be activated at iTransact.
 *
 * @author Kawika Ohumukini
 * @copyright Copyright (C) 2005 Kawika Ohumukini. All rights reserved.
 * @version $Id: ps_itransactx.php,v 1.0 2005/12/10 12:00:00
 */

define( 'ITRX_DEFAULT_GATEWAY_URL', 'https://secure.paymentclearing.com/cgi-bin/rc/xmltrans.cgi' );

define( 'ITRX_CURL_ERROR_OFFSET', 1000 );
define( 'ITRX_XML_ERROR_OFFSET',  2000 );

define( 'ITRX_TRANSACTION_OK',       0 );
define( 'ITRX_TRANSACTION_FAILED',   1 );
define( 'ITRX_TRANSACTION_UNKNOWN',  2 );

/**
* This class let's you handle transactions with the iTransact XML Payment Gateway
*
*/
class ps_itransactx {

    var $classname = "ps_itransactx";
    var $payment_code = "ITRX";
    
    /**
    * Required by Virtuemart. Shows all configuration parameters
    * @returns boolean False when the Payment method has no configration
    */
    function show_configuration() {
        global $VM_LANG;
        $db = new ps_DB();
        
        /* iTransact Gateway Location (URI) */
		if (!ITRX_GATEWAY_URL)
			define( "ITRX_GATEWAY_URL", ITRX_DEFAULT_GATEWAY_URL);
            
        /** Read current Configuration ***/
        include_once(CLASSPATH ."payment/".$this->classname.".cfg.php");
    ?>
    <table>
        <tr>
        <td><strong>iTransact Vendor ID</strong></td>
            <td>
                <input type="text" name="ITRX_VENDOR_ID" class="inputbox" value="<?php  echo ITRX_VENDOR_ID ?>" />
            </td>
            <td>The Vendor ID you received from iTransact.
            </td>
        </tr>
        <tr>
        <td><strong>iTransact Vendor Password</strong></td>
            <td>
                <input type="text" name="ITRX_VENDOR_PASSWORD" class="inputbox" value="<?php  echo ITRX_VENDOR_PASSWORD ?>" />
            </td>
            <td>The Vendor ID you received from iTransact.
            </td>
        </tr>
        <tr>
        <td><strong>Gateway URL</strong></td>
            <td>
                <input type="text" name="ITRX_GATEWAY_URL" class="inputbox" size="60" value="<?php  echo ITRX_GATEWAY_URL ?>" />
            </td>
            <td>The URL of the iTransact Secure Payment Gateway.
            </td>
        </tr>
        <tr>
        <td><strong>Homepage URL</strong></td>
            <td>
                <input type="text" name="ITRX_HOMEPAGE_URL" class="inputbox" size="60" value="<?php  echo ITRX_HOMEPAGE_URL ?>" />
            </td>
            <td>The Home page URL of your web site.
            </td>
        </tr>
      </table>
    <?php
    }
    
    /**
    * Required by Virtuemart.
    * @returns boolean False if there's no configuration
    */
    function has_configuration() {
      return true;
   }
   
  /**
	* Required by Virtuemart. Returns the "is_writeable" status of the configuration file
	* @param void
	* @returns boolean True when the configuration file is writeable, false when not
	*/
   function configfile_writeable() {
      return is_writeable( CLASSPATH."payment/".$this->classname.".cfg.php" );
   }
   
  /**
	* Required by Virtuemart. Returns the "is_readable" status of the configuration file
	* @param void
	* @returns boolean True when the configuration file is writeable, false when not
	*/
   function configfile_readable() {
      return is_readable( CLASSPATH."payment/".$this->classname.".cfg.php" );
   }
   
  /**
	* Required by Virtuemart. Writes the configuration file for this payment method
	* @param array An array of objects
	* @returns boolean True when writing was successful
	*/
   function write_configuration( &$d ) {
		$aryConfig = array(
		  	'ITRX_VENDOR_ID'			=> $d['ITRX_VENDOR_ID']
			, 'ITRX_VENDOR_PASSWORD'	=> $d['ITRX_VENDOR_PASSWORD']
			, 'ITRX_GATEWAY_URL'		=> $d['ITRX_GATEWAY_URL']
			, 'ITRX_HOMEPAGE_URL'		=> $d['ITRX_HOMEPAGE_URL']
		);
		$config = "<?php\n";
		$config .= "defined('_VALID_MOS') or die('Direct Access to this location is not allowed.'); \n\n";
		foreach( $aryConfig as $key => $value )
			$config .= "define ('$key', '$value');\n";
		$config .= "?>";
		if ($fp = fopen(CLASSPATH ."payment/".$this->classname.".cfg.php", "w")) {
			fputs($fp, $config, strlen($config));
			fclose ($fp);
			return true;
		}
		else
			return false;
	}
    /**
    * Required by Virtuemart. Main function call to process payment.
	*
	* @param integer Invoice number
	* @param integer Order total
	* @param array An array of objects
    * @returns boolean False if payment processing fails
    */
    function process_payment($order_number, $order_total, &$d) {
        global $vendor_name, $VM_LANG;

        /*** Get the Configuration File for iTransact ***/
        require_once(CLASSPATH ."payment/".$this->classname.".cfg.php");
		
        /* iTransact Gateway Location (URI) */
		if (!ITRX_GATEWAY_URL)
			define( "ITRX_GATEWAY_URL", ITRX_DEFAULT_GATEWAY_URL);
            
        // Get user billing information
        $db = new ps_DB;
        $qt = "SELECT 
			first_name
			, last_name
			, user_email
			, address_1
			, city
			, state
			, zip
			, country
			, phone_1
		FROM 
		 	#__{vm}_user_info 
		WHERE 
			user_id = '".$_SESSION['auth']['user_id']."' 
			AND address_type='BT'
		";
        $db->query($qt);
        if (!$db->next_record())
			return false;

		$TrxnNumber = uniqid( "itrx_" );
		/* split name on card input into first and last name
		 * First name will contain middle initials */
		$CustomerFirstname	= trim(substr($_SESSION['ccdata']['order_payment_name'], 0, strrpos($_SESSION['ccdata']['order_payment_name'], " ")));
		$CustomerLastname	= trim(substr($_SESSION['ccdata']['order_payment_name'], strrpos($_SESSION['ccdata']['order_payment_name'], " "), strlen($_SESSION['ccdata']['order_payment_name'])));
/*
		Uncomment to use billing name
		$CustomerFirstname	= $db->f("first_name");
		$CustomerLastname	= $db->f("last_name");
*/

		// Build XML request string
		$xmlRequest = "<?xml version=\"1.0\" ?>\n".
"<SaleRequest>\n".
	"<CustomerData>\n".
		"<Email>".htmlentities( $db->f("user_email") )."</Email>\n".
		"<BillingAddress>\n".
			"<FirstName>".htmlentities( $CustomerFirstname )."</FirstName>\n".
			"<LastName>".htmlentities( $CustomerLastname )."</LastName>\n".
			"<Address1>".htmlentities( $db->f("address_1") )."</Address1>\n".
			"<City>".htmlentities( $db->f("city") )."</City>\n".
			"<State>".htmlentities( $db->f("state") )."</State>\n".
			"<Zip>".htmlentities( $db->f("zip") )."</Zip>\n".
			"<Country>".htmlentities( $db->f("country") )."</Country>\n".
			"<Phone>".htmlentities( $db->f("phone_1") )."</Phone>\n".
		"</BillingAddress>\n".
		"<AccountInfo>\n".
			"<CardInfo>\n".
				"<CCNum>".htmlentities( $_SESSION['ccdata']['order_payment_number'] )."</CCNum>\n".
				"<CCMo>".htmlentities( $_SESSION['ccdata']['order_payment_expire_month'] )."</CCMo>\n".
				"<CCYr>".htmlentities( $_SESSION['ccdata']['order_payment_expire_year'] )."</CCYr>\n".
			"</CardInfo>\n".
		"</AccountInfo>\n".
	"</CustomerData>\n".
	"<TransactionData>\n".
		"<VendorId>".htmlentities( ITRX_VENDOR_ID )."</VendorId>\n".
		"<VendorPassword>".htmlentities( ITRX_VENDOR_PASSWORD )."</VendorPassword>\n".
		"<HomePage>".htmlentities( ITRX_HOMEPAGE_URL )."</HomePage>\n".
		"<OrderItems>\n";
        // items
		$myRecurFee = 0;
		$myRegisterFee = 0;
		for ($i=0;$i<$_SESSION['cart']['idx'];$i++) {
			/********************************************
			 * July 2nd, 2006 - recurring payments      *
			 * section removed by Erik Neff to function *
			 * in Joomla 1.0.10 and VirtueMart 1.0.5    *
			 ********************************************
			 
			$ptp = ptp_main_cart_checkout(array('product_id'=>$_SESSION['cart'][$i]['product_id'], 'quantity'=>$_SESSION['cart'][$i]['quantity'], 'description'=>$_SESSION['cart'][$i]['description']));
			if ($_SESSION['cart'][$i]['new_user_level'])
				$_SESSION['new_user_level'] = $_SESSION['cart'][$i]['new_user_level'];
			if ($ptp['recur']) {
				$_SESSION['is_recur'] = true;
				$myTotalRecur += $this->aryProduct[$i]['cost'];
				if ($ptp['register_fee']) {
					$myRegisterFee = $ptp['register_fee'];
					$myRecurFee += $this->aryProduct[$i]['cost'];
				}
				else {
					$myRegisterFee = 0;
					$myRecurFee += $this->aryProduct[$i]['cost'];
				}
			}
			else {
			
				$myRegisterFee = $this->aryProduct[$i]['cost'];
			}*/
			$myRegisterFee = $this->aryProduct[$i]['cost'];
			/********************************************
			 * End recurring payments removal           *
			 * modification by Erik Neff			    *
			 ********************************************/
			 
			/********************************************
			 * If-Else Statement by Erik Neff			*
			 * Compensating for iTransact's refusal of	*
			 * empty description tags					*
			 ********************************************/
			
			
			if (htmlentities( $_SESSION['cart'][$i]['description'] ) == NULL){
				$xmlRequest .= "<Item>\n".
					"<Description> None </Description>\n".
					"<Cost>".htmlentities( $myRegisterFee )."</Cost>\n".
					"<Qty>".htmlentities( $_SESSION['cart'][$i]['quantity'] )."</Qty>\n".
				"</Item>\n";
			}
			else {
				$xmlRequest .= "<Item>\n".
					"<Description>".htmlentities( $_SESSION['cart'][$i]['description'] )."</Description>\n".
					"<Cost>".htmlentities( $myRegisterFee )."</Cost>\n".
					"<Qty>".htmlentities( $_SESSION['cart'][$i]['quantity'] )."</Qty>\n".
				"</Item>\n";
			}
			/********************************************
			 * End Modification by Erik Neff			*
			 ********************************************/
		}
		$xmlRequest .= "</OrderItems>\n";
		/********************************************
		 * July 2nd, 2006 - another recurring       *
		 * payments section removed by Erik Neff to *
		 * function in Joomla 1.0.10 and VM 1.0.5   *
		 ********************************************
		if ($myTotalRecur) {
			$xmlRequest .= "<RecurringData>\n".
				"<RecurRecipe>Monthly01</RecurRecipe>\n".
				"<RecurReps>120</RecurReps>\n";
			if ($myRecurFee)
				$xmlRequest .= "<RecurTotal>".htmlentities( $myRecurFee )."</RecurTotal>\n";
			$xmlRequest .= "</RecurringData>\n";
		}
		/********************************************
		 * End recurring payments removal           *
		 * modification by Erik Neff			    *
		 ********************************************/
		$xmlRequest .= "</TransactionData>\n".
"</SaleRequest>";

		$xmlRequest = "xml=$xmlRequest";
        // Use CURL to execute XML POST and write output into a string
        $ch = curl_init( ITRX_GATEWAY_URL );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $xmlRequest );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 240 );
        $xmlResponse = curl_exec( $ch );
		$xmlResponse = str_replace(" standalone=\"yes\"","",$xmlResponse);

        // Check whether the curl_exec worked.
        if( curl_errno( $ch ) == CURLE_OK ) {
            // It worked, so setup an XML parser for the result.
            $parser = xml_parser_create();
            
            // Disable XML tag capitalisation (Case Folding)
            xml_parser_set_option ($parser, XML_OPTION_CASE_FOLDING, FALSE);

            // Define Callback functions for XML Parsing
            xml_set_object($parser, &$this);
            xml_set_element_handler ($parser, "XmlElementStart", "XmlElementEnd");
            xml_set_character_data_handler ($parser, "XmlData");
            
            // Parse the XML response
            xml_parse($parser, $xmlResponse, TRUE);
            if( xml_get_error_code( $parser ) == XML_ERROR_NONE ) {
				if ($this->xmlData['Status'] == 'OK') {
	                // Get the result into local variables.
	                $ResultTrxnStatus		= $this->xmlData['Status'];
	                $ResultTrxnNumber		= $this->xmlData['XID'];
	                $ResultTrxnReference	= $this->xmlData['TimeStamp'];
	                $ResultAuthCode			= $this->xmlData['AuthCode'];
	                $ResultReturnAmount		= $this->xmlData['Total'];
	                $ResultTrxnError		= $this->xmlData['itrxTrxnError'];
	                $this->myError			= 0;
	                $ErrorMessage			= '';
				}
				elseif ($this->xmlData['Status'] == 'FAILED') {
	                $this->myError = $this->xmlData['ErrorCategory'];
    	            $ErrorMessage = $this->xmlData['ErrorMessage'];
				}
            }
			else {
                // An XML error occured. Return the error message and number.
                $this->myError = xml_get_error_code( $parser ) + ITRX_XML_ERROR_OFFSET;
                $ErrorMessage = xml_error_string( $this->myError );
            }
            // Clean up our XML parser
            xml_parser_free( $parser );
        }
		else {
            // A CURL Error occured. Return the error message and number. (offset so we can pick the error apart)
            $this->myError = curl_errno( $ch ) + ITRX_CURL_ERROR_OFFSET;
            $ErrorMessage = curl_error( $ch );
        }
        // Clean up CURL, and return any error.
        curl_close( $ch );
        if( $this->getError($ResultTrxnStatus) == ITRX_TRANSACTION_OK ) {
			$d["order_payment_log"]			= $VM_LANG->_PHPSHOP_PAYMENT_TRANSACTION_SUCCESS;
            $d["order_payment_trans_id"]	= $TrxnNumber;
            $d["error"] = "";
            return true;
		} 
        else {
			$d["error"] = $VM_LANG->_PHPSHOP_PAYMENT_ERROR.": ";
            $d["error"] .= $this->getErrorMessage($ResultTrxnError, $ErrorMessage);
            $d["order_payment_trans_id"] = $TrxnNumber;
            return false;
		}
    }
    /**
	* @param object Parser
	* @param string Current tag
	* @param string Attributes
    */
    function XmlElementStart ($parser, $tag, $attributes) {
        $this->currentTag = $tag;
    }
    /**
	* @param object Parser
	* @param string Current tag
    */
    function XmlElementEnd ($parser, $tag) {
        $this->currentTag = "";
    }
    /**
	* @param object Parser
	* @param string cData
    */
    function XmlData ($parser, $cdata) {
        $this->xmlData[$this->currentTag] = $cdata;
    }
    /**
	* @param string Processing transaction result status
    */
    function getError($getTrxnStatus) {
		// Internal Error
        if( $this->myError != 0 )
            return $this->myError;
		else {
            // itrx Error
            if( $getTrxnStatus == 'OK' ) {
                return ITRX_TRANSACTION_OK;
            }
			elseif( $getTrxnStatus == 'FAILED' ) {
                return ITRX_TRANSACTION_FAILED;
            }
			else {
                return ITRX_TRANSACTION_UNKNOWN;
            }
        }
    }
    /**
	* @param string Processing error status
	* @param string Processing error message
    */
    function getErrorMessage($getTrxnError, $ErrorMessage) {
		// Internal Error
        if( $this->myError != 0 )
            return $ErrorMessage;
		// itrx Error
        else
            return $getTrxnError;
    }
}

?>