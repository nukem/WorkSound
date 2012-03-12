<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * 	Angell EYE PayPal Adaptive Payments CodeIgniter Library
 *	An open source PHP library written to easily work with PayPal's API's
 *	
 *  Copyright © 2011  Andrew K. Angell
 *	Email:  andrew@angelleye.com
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * @package			Angell_EYE_PayPal_Adaptive_Class_Library
 * @author			Andrew K. Angell
 * @copyright		Copyright © 2011 Angell EYE, LLC
 * @link			http://www.angelleye.com
 * @since			Version 2.1
 * @updated			11.23.2011
 * @filesource
*/

require_once('Paypal_pro.php');
class PayPal_Adaptive extends PayPal_Pro
{
	var $DeveloperAccountEmail = '';
	var $XMLNamespace = '';
	var $ApplicationID = '';
	var $DeviceID = '';
	var $IPAddress = '';
	var $DetailLevel = '';
	var $ErrorLanguage = '';
	
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */
	function __construct($DataArray)
	{
		parent::__construct($DataArray);
		
		$this->XMLNamespace = 'http://svcs.paypal.com/types/ap';
		$this->DeviceID = isset($DataArray['DeviceID']) ? $DataArray['DeviceID'] : '';
		$this->IPAddress = isset($DataArray['IPAddress']) ? $DataArray['IPAddress'] : $_SERVER['REMOTE_ADDR'];
		$this->DetailLevel = isset($DataArray['DetailLevel']) ? $DataArray['DetailLevel'] : 'ReturnAll';
		$this->ErrorLanguage = isset($DataArray['ErrorLanguage']) ? $DataArray['ErrorLanguage'] : 'en_US';
		$this->APISubject = isset($DataArray['APISubject']) ? $DataArray['APISubject'] : '';
		$this->DeveloperAccountEmail = isset($DataArray['DeveloperAccountEmail']) ? $DataArray['DeveloperAccountEmail'] : '';
		
		if($this -> Sandbox)
		{	
			// Sandbox Credentials
			/*$this -> ApplicationID = isset($DataArray['ApplicationID']) ? $DataArray['ApplicationID'] : '';
			$this -> APIUsername = isset($DataArray['APIUsername']) && $DataArray['APIUsername'] != '' ? $DataArray['APIUsername'] : '';
			$this -> APIPassword = isset($DataArray['APIPassword']) && $DataArray['APIPassword'] != '' ? $DataArray['APIPassword'] : '';
			$this -> APISignature = isset($DataArray['APISignature']) && $DataArray['APISignature'] != '' ? $DataArray['APISignature'] : '';
			$this -> EndPointURL = isset($DataArray['EndPointURL']) && $DataArray['EndPointURL'] != '' ? $DataArray['EndPointURL'] : 'https://svcs.sandbox.paypal.com/';*/
            $this -> ApplicationID =  '143232132321321';
			$this -> APIUsername = 'nsride_1329790642_biz_api1.gmail.com';
			$this -> APIPassword =  '1329790666';
			$this -> APISignature = 'Ax3PJydlYE6ah9ckEa-94mTy.W83AbtEmiC0DNqiTR8uyJKMWlFsOtKa';
			//$this -> EndPointURL =   'https://svcs.sandbox.paypal.com/';
			$this -> EndPointURL =   'https://svcs.sandbox.paypal.com/AdaptivePayments/Pay';
            
            
		}
		elseif($this -> BetaSandbox)
		{
			// Beta Sandbox Credentials
			$this -> ApplicationID = isset($DataArray['ApplicationID']) ? $DataArray['ApplicationID'] : '';
			$this -> APIUsername = isset($DataArray['APIUsername']) && $DataArray['APIUsername'] != '' ? $DataArray['APIUsername'] : '';
			$this -> APIPassword = isset($DataArray['APIPassword']) && $DataArray['APIPassword'] != '' ? $DataArray['APIPassword'] : '';
			$this -> APISignature = isset($DataArray['APISignature']) && $DataArray['APISignature'] != '' ? $DataArray['APISignature'] : '';
			$this -> EndPointURL = isset($DataArray['EndPointURL']) && $DataArray['EndPointURL'] != '' ? $DataArray['EndPointURL'] : 'https://svcs.beta-sandbox.paypal.com/';
		}
		else
		{
			// Live Credentials
			$this -> ApplicationID = isset($DataArray['ApplicationID']) ? $DataArray['ApplicationID'] : 'YOUR_APP_ID';
			$this -> APIUsername = isset($DataArray['APIUsername']) && $DataArray['APIUsername'] != '' ? $DataArray['APIUsername'] : '';
			$this -> APIPassword = isset($DataArray['APIPassword']) && $DataArray['APIPassword'] != ''  ? $DataArray['APIPassword'] : '';
			$this -> APISignature = isset($DataArray['APISignature']) && $DataArray['APISignature'] != ''  ? $DataArray['APISignature'] : '';
			$this -> EndPointURL = isset($DataArray['EndPointURL']) && $DataArray['EndPointURL'] != ''  ? $DataArray['EndPointURL'] : 'https://svcs.paypal.com/';
		}
	}
	
	/**
	 * Build all HTTP headers required for the API call.
	 *
	 * @access	public
	 * @param	boolean	$PrintHeaders - Whether to print headers on screen or not (true/false)
	 * @return	array $headers
	 */
	function BuildHeaders($PrintHeaders)
	{
		$headers = array(
						'X-PAYPAL-SECURITY-USERID: ' . $this -> APIUsername, 
						'X-PAYPAL-SECURITY-PASSWORD: ' . $this -> APIPassword, 
						'X-PAYPAL-SECURITY-SIGNATURE: ' . $this -> APISignature, 
						'X-PAYPAL-SECURITY-SUBJECT: ' . $this -> APISubject, 
						'X-PAYPAL-SECURITY-VERSION: ' . $this -> APIVersion, 
						'X-PAYPAL-REQUEST-DATA-FORMAT: XML', 
						'X-PAYPAL-RESPONSE-DATA-FORMAT: XML', 
						'X-PAYPAL-APPLICATION-ID: ' . $this -> ApplicationID, 
						'X-PAYPAL-DEVICE-ID: ' . $this -> DeviceID, 
						'X-PAYPAL-DEVICE-IPADDRESS: ' . $this -> IPAddress
						);
		
		if($this -> Sandbox)
		{
			array_push($headers, 'X-PAYPAL-SANDBOX-EMAIL-ADDRESS: '.$this->DeveloperAccountEmail);
		}
		
		if($PrintHeaders)
		{
			echo '<pre />';
			print_r($headers);
		}
		
		return $headers;
	}
	
	/**
	 * Send the API request to PayPal using CURL
	 *
	 * @access	public
	 * @param	string $Request
	 * @param   string $APIName
	 * @param   string $APIOperation
	 * @return	string
	 */
	function CURLRequest($Request, $APIName, $APIOperation)
	{
		$curl = curl_init();
				curl_setopt($curl, CURLOPT_VERBOSE, 1);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_URL, $this -> EndPointURL . $APIName . '/' . $APIOperation);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $Request);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $this -> BuildHeaders(false));
								
		if($this -> APIMode == 'Certificate')
		{
			curl_setopt($curl, CURLOPT_SSLCERT, $this -> PathToCertKeyPEM);
		}
		
		$Response = curl_exec($curl);		
		curl_close($curl);
		return $Response;
	}
	
	/**
	 * Get all errors returned from PayPal
	 *
	 * @access	public
	 * @param	string	XML response from PayPal
	 * @return	array
	 */
	function GetErrors($XML)
	{
		$DOM = new DOMDocument();
		$DOM->loadXML($XML);		
		$Errors = $DOM->getElementsByTagName('error') -> length > 0 ? $DOM->getElementsByTagName('error') : array();
		$ErrorsArray = array();
		foreach($Errors as $Error)
		{
			$Receiver = $Error -> getElementsByTagName('receiver') -> length > 0 ? $Error -> getElementsByTagName('receiver') -> item(0) -> nodeValue : '';
			$Category = $Error -> getElementsByTagName('category') -> length > 0 ? $Error -> getElementsByTagName('category') -> item(0) -> nodeValue : '';
			$Domain = $Error -> getElementsByTagName('domain') -> length > 0 ? $Error -> getElementsByTagName('domain') -> item(0) -> nodeValue : '';
			$ErrorID = $Error -> getElementsByTagName('errorId') -> length > 0 ? $Error -> getElementsByTagName('errorId') -> item(0) -> nodeValue : '';
			$ExceptionID = $Error -> getElementsByTagName('exceptionId') -> length > 0 ? $Error -> getElementsByTagName('exceptionId') -> item(0) -> nodeValue : '';
			$Message = $Error -> getElementsByTagName('message') -> length > 0 ? $Error -> getElementsByTagName('message') -> item(0) -> nodeValue : '';
			$Parameter = $Error -> getElementsByTagName('parameter') -> length > 0 ? $Error -> getElementsByTagName('parameter') -> item(0) -> nodeValue : '';
			$Severity = $Error -> getElementsByTagName('severity') -> length  > 0 ? $Error -> getElementsByTagName('severity') -> item(0) -> nodeValue : '';
			$Subdomain = $Error -> getElementsByTagName('subdomain') -> length > 0 ? $Error -> getElementsByTagName('subdomain') -> item(0) -> nodeValue : '';
			
			$CurrentError = array(
								  'Receiver' => $Receiver, 
								  'Category' => $Category, 
								  'Domain' => $Domain, 
								  'ErrorID' => $ErrorID, 
								  'ExceptionID' => $ExceptionID, 
								  'Message' => $Message, 
								  'Parameter' => $Parameter, 
								  'Severity' => $Severity, 
								  'Subdomain' => $Subdomain
								  );
			array_push($ErrorsArray, $CurrentError);
		}
		return $ErrorsArray;
	}
	
	/**
	 * Get the request envelope from the XML string
	 *
	 * @access	public
	 * @return	string XML request envelope
	 */
	function GetXMLRequestEnvelope()
	{
		$XML = '<requestEnvelope xmlns="">';
		$XML .= '<detailLevel>' . $this -> DetailLevel . '</detailLevel>';
		$XML .= '<errorLanguage>' . $this -> ErrorLanguage . '</errorLanguage>';
		$XML .= '</requestEnvelope>';
		
		return $XML;
	}	
	
	/**
	 * Log result to a location on the disk.
	 *
	 * @access	public
	 * @param	string	$filename 
	 * @param   string  $string_data
	 * @return	array
	 */
	function Logger($filename, $string_data)
	{	
		$timestamp = strtotime('now');
		$timestamp = date('mdY_giA_',$timestamp);
		$file = $_SERVER['DOCUMENT_ROOT']."/paypal/logs/".$timestamp.$filename.".xml";
		$fh = fopen($file, 'w');
		fwrite($fh, $string_data);
		fclose($fh);	
	}
	
	
	/**
	 * Submit Pay() API request to PayPal
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function Pay($DataArray)
	{	
		// PayRequest Fields
		$PayRequestFields = isset($DataArray['PayRequestFields']) ? $DataArray['PayRequestFields'] : array();
		$ActionType = isset($PayRequestFields['ActionType']) ? $PayRequestFields['ActionType'] : '';
		$CancelURL = isset($PayRequestFields['CancelURL']) ? $PayRequestFields['CancelURL'] : '';
		$CurrencyCode = isset($PayRequestFields['CurrencyCode']) ? $PayRequestFields['CurrencyCode'] : '';
		$FeesPayer = isset($PayRequestFields['FeesPayer']) ? $PayRequestFields['FeesPayer'] : '';
		$IPNNotificationURL = isset($PayRequestFields['IPNNotificationURL']) ? $PayRequestFields['IPNNotificationURL'] : '';
		$Memo = isset($PayRequestFields['Memo']) ? $PayRequestFields['Memo'] : '';
		$Pin = isset($PayRequestFields['Pin']) ? $PayRequestFields['Pin'] : '';
		$PreapprovalKey = isset($PayRequestFields['PreapprovalKey']) ? $PayRequestFields['PreapprovalKey'] : '';
		$ReturnURL = isset($PayRequestFields['ReturnURL']) ? $PayRequestFields['ReturnURL'] : '';
		$ReverseAllParallelPaymentsOnError = isset($PayRequestFields['ReverseAllParallelPaymentsOnError']) ? $PayRequestFields['ReverseAllParallelPaymentsOnError'] : '';
		$SenderEmail = isset($PayRequestFields['SenderEmail']) ? $PayRequestFields['SenderEmail'] : '';
		$TrackingID = isset($PayRequestFields['TrackingID']) ? $PayRequestFields['TrackingID'] : '';
		
		// ClientDetails Fields
		$ClientDetailsFields = isset($DataArray['ClientDetailsFields']) ? $DataArray['ClientDetailsFields'] : array();
		$CustomerID = isset($ClientDetailsFields['CustomerID']) ? $ClientDetailsFields['CustomerID'] : '';
		$CustomerType = isset($ClientDetailsFields['CustomerType']) ? $ClientDetailsFields['CustomerType'] : '';
		$GeoLocation = isset($ClientDetailsFields['GeoLocation']) ? $ClientDetailsFields['GeoLocation'] : '';
		$Model = isset($ClientDetailsFields['Model']) ? $ClientDetailsFields['Model'] : '';
		$PartnerName = isset($ClientDetailsFields['PartnerName']) ? $ClientDetailsFields['PartnerName'] : '';
		
		// FundingConstraint Fields
		$FundingTypes = isset($DataArray['FundingTypes']) ? $DataArray['FundingTypes'] : array();
		
		// Receivers Fields
		$Receivers = isset($DataArray['Receivers']) ? $DataArray['Receivers'] : array();
		$Amount = isset($Receivers['Amount']) ? $Receivers['Amount'] : '';
		$Email = isset($Receivers['Email']) ? $Receivers['Email'] : '';
		$InvoiceID = isset($Receivers['InvoiceID']) ? $Receivers['InvoiceID'] : '';
		$PaymentType = isset($Receivers['PaymentType']) ? $Receivers['PaymentType'] : '';
		$PaymentSubType = isset($Receivers['PaymentSubType']) ? $Receivers['PaymentSubType'] : '';
		$Phone = isset($Receivers['Phone']) ? $Receivers['Phone'] : '';
		$Primary = isset($Receivers['Primary']) ? $Receivers['Primary'] : '';
		
		// SenderIdentifier Fields
		$SenderIdentifierFields = isset($DataArray['SenderIdentifierFields']) ? $DataArray['SenderIdentifierFields'] : array();
		$UseCredentials = isset($SenderIdentifierFields['UseCredentials']) ? $SenderIdentifierFields['UseCredentials'] : '';
		
		// AccountIdentifierFields Fields
		$AccountIdentifierFields = isset($DataArray['AccountIdentifierFields']) ? $DataArray['AccountIdentifierFields'] : array();
		$AccountEmail = isset($AccountIdentifierFields['Email']) ? $AccountIdentifierFields['Email'] : '';
		$AccountPhone = isset($AccountIdentifierFields['Phone']) ? $AccountIdentifierFields['Phone'] : '';
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<PayRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= '<actionType xmlns="">' . $ActionType . '</actionType>';
		$XMLRequest .= '<cancelUrl xmlns="">' . $CancelURL . '</cancelUrl>';
		
		if(count($ClientDetailsFields) > 0)
		{
			$XMLRequest .= '<clientDetails xmlns="">';
			$XMLRequest .= $this -> ApplicationID != '' ? '<applicationId xmlns="">' . $this -> ApplicationID . '</applicationId>' : '';
			$XMLRequest .= $CustomerID != '' ? '<customerId xmlns="">' . $CustomerID . '</customerId>' : '';
			$XMLRequest .= $CustomerType != '' ? '<customerType xmlns="">' . $CustomerType . '</customerType>' : '';
			$XMLRequest .= $this -> DeviceID != '' ? '<deviceId xmlns="">' . $this -> DeviceID . '</deviceId>' : '';
			$XMLRequest .= $GeoLocation != '' ? '<geoLocation xmlns="">' . $GeoLocation . '</geoLocation>' : '';
			$XMLRequest .= $this -> IPAddress != '' ? '<ipAddress xmlns="">' . $this -> IPAddress . '</ipAddress>' : '';
			$XMLRequest .= $Model != '' ? '<model xmlns="">' . $Model . '</model>' : '';
			$XMLRequest .= $PartnerName != '' ? '<partnerName xmlns="">' . $PartnerName . '</partnerName>' : '';
			$XMLRequest .= '</clientDetails>';		
		}
		
		$XMLRequest .= '<currencyCode xmlns="">' . $CurrencyCode . '</currencyCode>';
		$XMLRequest .= $FeesPayer != '' ? '<feesPayer xmlns="">' . $FeesPayer . '</feesPayer>' : '';
		
		if(count($FundingTypes) > 0)
		{		
			$XMLRequest .= '<fundingConstraint xmlns="">';
			$XMLRequest .= '<allowedFundingType xmlns="">';
			
			foreach($FundingTypes as $FundingType)
			{
				$XMLRequest .= '<fundingTypeInfo xmlns="">';
				$XMLRequest .= '<fundingType xmlns="">' . $FundingType . '</fundingType>';
				$XMLRequest .= '</fundingTypeInfo>';
			}
			
			$XMLRequest .= '</allowedFundingType>';
			$XMLRequest .= '</fundingConstraint>';
		}
		
		$XMLRequest .= $IPNNotificationURL != '' ? '<ipnNotificationUrl xmlns="">' . $IPNNotificationURL . '</ipnNotificationUrl>' : '';
		$XMLRequest .= $Memo != '' ? '<memo xmlns="">' . $Memo . '</memo>' : '';
		$XMLRequest .= $Pin != '' ? '<pin xmlns="">' . $Pin . '</pin>' : '';
		$XMLRequest .= $PreapprovalKey != '' ? '<preapprovalKey xmlns="">' . $Pin . '</preapprovalKey>' : '';
		
		$XMLRequest .= '<receiverList xmlns="">';
		foreach($Receivers as $Receiver)
		{
			$XMLRequest .= '<receiver xmlns="">';
			$XMLRequest .= '<amount xmlns="">' . $Receiver['Amount'] . '</amount>';
			$XMLRequest .= '<email xmlns="">' . $Receiver['Email'] . '</email>';
			$XMLRequest .= $Receiver['InvoiceID'] != '' ? '<invoiceId xmlns="">' . $Receiver['InvoiceID'] . '</invoiceId>' : '';
			$XMLRequest .= $Receiver['PaymentType'] != '' ? '<paymentType xmlns="">' . $Receiver['PaymentType'] . '</paymentType>' : '';
			$XMLRequest .= $Receiver['PaymentSubType'] != '' ? '<paymentSubType xmlns="">' . $Receiver['PaymentSubType'] . '</paymentSubType>' : '';
			
			if($Receiver['Phone']['CountryCode'] != '')
			{
				$XMLRequest .= '<phone xmlns="">';
				$XMLRequest .= $Receiver['Phone']['CountryCode'] != '' ? '<countryCode xmlns="">' . $Receiver['Phone']['CountryCode'] . '</countryCode>' : '';
				$XMLRequest .= $Receiver['Phone']['PhoneNumber'] != '' ? '<phoneNumber xmlns="">' . $Receiver['Phone']['PhoneNumber'] . '</phoneNumber>' : '';
				$XMLRequest .= $Receiver['Phone']['Extension'] != '' ? '<extension xmlns="">' . $Receiver['Phone']['Extension'] . '</extension>' : '';
				$XMLRequest .= '</phone>';
			}
			
			$XMLRequest .= $Receiver['Primary'] != '' ? '<primary xmls="">' . $Receiver['Primary'] . '</primary>' : '';
			$XMLRequest .= '</receiver>';
		}
		$XMLRequest .= '</receiverList>';
		
		if(count($SenderIdentifierFields) > 0)
		{
			$XMLRequest .= '<sender>';
			$XMLRequest .= '<useCredentials xmlns="">' . $SenderIdentifierFields['UseCredentials'] . '</useCredentials>';
			$XMLRequest .= '</sender>';	
		}
		
		if(count($AccountIdentifierFields) > 0)
		{
			$XMLRequest .= '<account xmlns="">';
			$XMLRequest .= $AccountEmail != '' ? '<email xmlns="">' . $AccountEmail . '</email>' : '';
			
			if($AccountPhone != '')
			{
				$XMLRequest .= '<phone xmlns="">';
				$XMLRequest .= $AccountPhone['CountryCode'] != '' ? '<countryCode xmlns="">' . $AccountPhone['CountryCode'] . '</countryCode>' : '';
				$XMLRequest .= $AccountPhone['PhoneNumber'] != '' ? '<phoneNumber xmlns="">' . $AccountPhone['PhoneNumber'] . '</phoneNumber>' : '';
				$XMLRequest .= $AccountPhone['Extension'] != '' ? '<extension xmlns="">' . $AccountPhone['Extension'] . '</extension>' : '';
				$XMLRequest .= '</phone>';
			}
			
			$XMLRequest .= '</account>';
		}
		
		$XMLRequest .= '<returnUrl xmlns="">' . $ReturnURL . '</returnUrl>';
		$XMLRequest .= $ReverseAllParallelPaymentsOnError != '' ? '<reverseAllParallelPaymentsOnError xmlns="">' . $ReverseAllParallelPaymentsOnError . '</reverseAllParallelPaymentsOnError>' : '';
		$XMLRequest .= $SenderEmail != '' ? '<senderEmail xmlns="">' . $SenderEmail . '</senderEmail>' : '';
		$XMLRequest .= $TrackingID != '' ? '<trackingId xmlns="">' . $TrackingID . '</trackingId>' : '';
		$XMLRequest .= '</PayRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'Pay');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		
		$PayKey = $DOM -> getElementsByTagName('payKey') -> length > 0 ? $DOM -> getElementsByTagName('payKey') -> item(0) -> nodeValue : '';
		$PaymentExecStatus = $DOM -> getElementsByTagName('paymentExecStatus') -> length > 0 ? $DOM -> getElementsByTagName('paymentExecStatus') -> item(0) -> nodeValue : '';
		
		if($this -> Sandbox)
		{
			$RedirectURL = 'https://www.sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=' . $PayKey;
		}
		elseif($this -> BetaSandbox)
		{
			$RedirectURL = 'https://www.beta-sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=' . $PayKey;
		}
		else
		{
			$RedirectURL = 'https://www.paypal.com/webscr?cmd=_ap-payment&paykey=' . $PayKey;
		}
		
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'PayKey' => $PayKey, 
								   'PaymentExecStatus' => $PaymentExecStatus, 
								   'RedirectURL' => $PayKey != '' ? $RedirectURL : '', 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
        
		return $ResponseDataArray;
	}
	
	/**
	 * Submit PaymentDetails API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function PaymentDetails($DataArray)
	{
		// PaymentDetails Fields
		$PaymentDetailsFields = isset($DataArray['PaymentDetailsFields']) ? $DataArray['PaymentDetailsFields'] : array();
		$PayKey = isset($PaymentDetailsFields['PayKey']) ? $PaymentDetailsFields['PayKey'] : '';
		$TransactionID = isset($PaymentDetailsFields['TransactionID']) ? $PaymentDetailsFields['TransactionID'] : '';
		$TrackingID = isset($PaymentDetailsFields['TrackingID']) ? $PaymentDetailsFields['TrackingID'] : '';
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<PaymentDetailsRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= isset($PaymentDetailsFields['PayKey']) ? '<payKey xmlns="">' . $PaymentDetailsFields['PayKey'] . '</payKey>' : '';
		$XMLRequest .= isset($PaymentDetailsFields['TransactionID']) ? '<transactionId xmlns="">' . $PaymentDetailsFields['TransactionID'] . '</transactionId>' : '';
		$XMLRequest .= isset($PaymentDetailsFields['TrackingID']) ? '<trackingId xmlns="">' . $PaymentDetailsFields['TrackingID'] . '</trackingId>' : '';
		$XMLRequest .= '</PaymentDetailsRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'PaymentDetails');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		
		$ActionType = $DOM -> getElementsByTagName('actionType') -> length > 0 ? $DOM -> getElementsByTagName('actionType') -> item(0) -> nodeValue : '';
		$CancelURL = $DOM -> getElementsByTagName('cancelUrl') -> length > 0 ? $DOM -> getElementsByTagName('cancelUrl') -> item(0) -> nodeValue : '';
		$CurrencyCode = $DOM -> getElementsByTagName('currencyCode') -> length > 0 ? $DOM -> getElementsByTagName('currencyCode') -> item(0) -> nodeValue : '';
		$FeesPayer = $DOM -> getElementsByTagName('feesPayer') -> length > 0 ? $DOM -> getElementsByTagName('feesPayer') -> item(0) -> nodeValue : '';
		
		$FundingTypesDOM = $DOM -> getElementsByTagName('fundingType') -> length > 0 ? $DOM -> getElementsByTagName('fundingType') : array();
		$FundingTypes = array();
		foreach($FundingTypesDOM as $FundingType)
		{
			array_push($FundingTypes, $FundingType);
		}
		
		$IPNNotificationURL = $DOM -> getElementsByTagName('ipnNotificationUrl') -> length > 0 ? $DOM -> getElementsByTagName('ipnNotificationUrl') -> item(0) -> nodeValue : '';
		$Memo = $DOM -> getElementsByTagName('memo') -> length > 0 ? $DOM -> getElementsByTagName('memo') -> item(0) -> nodeValue : '';
		$PayKey = $DOM -> getElementsByTagName('payKey') -> length > 0 ? $DOM -> getElementsByTagName('payKey') -> item(0) -> nodeValue : '';
		
		$PendingRefund = $DOM -> getElementsByTagName('pendingRefund') -> length > 0 ? $DOM -> getElementsByTagName('pendingRefund') -> item(0) -> nodeValue : 'false';
		$RefundedAmount = $DOM -> getElementsByTagName('refundedAmount') -> length > 0 ? $DOM -> getElementsByTagName('refundedAmount') -> item(0) -> nodeValue : '';
		$SenderTransactionID = $DOM -> getElementsByTagName('senderTransactionID') -> length > 0 ? $DOM -> getElementsByTagName('senderTransactionID') -> item(0) -> nodeValue : '';

		$SenderTransactionStatus = $DOM -> getElementsByTagName('senderTransactionStatus') -> length > 0 ? $DOM -> getElementsByTagName('senderTransactionStatus') -> item(0) -> nodeValue : '';
		$TransactionID = $DOM -> getElementsByTagName('transactionId') -> length > 0 ? $DOM -> getElementsByTagName('transactionId') -> item(0) -> nodeValue : '';
		$TransactionStatus = $DOM -> getElementsByTagName('transactionStatus') -> length > 0 ? $DOM -> getElementsByTagName('transactionStatus') -> item(0) -> nodeValue : '';
		$PaymentInfo = array(
							'PendingRefund' => $PendingRefund, 
							'RefundAmount' => $RefundedAmount, 
							'SenderTransactionID' => $SenderTransactionID, 
							'SenderTransactionStatus' => $SenderTransactionStatus, 
							'TransactionID' => $TransactionID, 
							'TransactionStatus' => $TransactionStatus
							 );
		
		$PreapprovalKey = $DOM -> getElementsByTagName('preapprovalKey') -> length > 0 ? $DOM -> getElementsByTagName('preapprovalKey') -> item(0) -> nodeValue : '';
		$ReturnURL = $DOM -> getElementsByTagName('returnUrl') -> length > 0 ? $DOM -> getElementsByTagName('returnUrl') -> item(0) -> nodeValue : '';
		$ReverseAllParallelPaymentsOnError = $DOM -> getElementsByTagName('reverseAllParallelPaymentsOnError') -> length > 0 ? $DOM -> getElementsByTagName('reverseAllParallelPaymentsOnError') -> item(0) -> nodeValue : '';
		$SenderEmail = $DOM -> getElementsByTagName('senderEmail') -> length > 0 ? $DOM -> getElementsByTagName('senderEmail') -> item(0) -> nodeValue : '';
		$Status = $DOM -> getElementsByTagName('status') -> length > 0 ? $DOM -> getElementsByTagName('status') -> item(0) -> nodeValue : '';
		$TrackingID = $DOM -> getElementsByTagName('trackingId') -> length > 0 ? $DOM -> getElementsByTagName('trackingId') -> item(0) -> nodeValue : '';
		
		$Amount = $DOM -> getElementsByTagName('amount') -> length > 0 ? $DOM -> getElementsByTagName('amount') -> item(0) -> nodeValue : '';
		$Email = $DOM -> getElementsByTagName('email') -> length > 0 ? $DOM -> getElementsByTagName('email') -> item(0) -> nodeValue : '';
		$InvoiceID = $DOM -> getElementsByTagName('invoiceId') -> length > 0 ? $DOM -> getElementsByTagName('invoiceId') -> item(0) -> nodeValue : '';
		$PaymentType = $DOM -> getElementsByTagName('paymentType') -> length > 0 ? $DOM -> getElementsByTagName('paymentType') -> item(0) -> nodeValue : '';
		$Primary = $DOM -> getElementsByTagName('primary') -> length > 0 ? $DOM -> getElementsByTagName('primary') -> item(0) -> nodeValue : 'false';
		$Receiver = array(
						'Amount' => $Amount, 
						'Email' => $Email, 
						'InvoiceID' => $InvoiceID, 
						'PaymentType' => $PaymentType, 
						'Primary' => $Primary
						  );
		
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'ActionType' => $ActionType, 
								   'CancelURL' => $CancelURL, 
								   'CurrencyCode' => $CurrencyCode, 
								   'FeesPayer' => $FeesPayer, 
								   'FundingTypes' => $FundingTypes, 
								   'IPNNotificationURL' => $IPNNotificationURL, 
								   'Memo' => $Memo, 
								   'PayKey' => $PayKey, 
								   'PaymentInfo' => $PaymentInfo, 
								   'PreapprovalKey' => $PreapprovalKey, 
								   'ReturnURL' => $ReturnURL, 
								   'ReverseAllParallelPaymentsOnError' => $ReverseAllParallelPaymentsOnError, 
								   'SenderEmail' => $SenderEmail, 
								   'Status' => $Status, 
								   'TrackingID' => $TrackingID, 
								   'Receiver' => $Receiver, 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
	
	
	/**
	 * Submit ExecutePayment API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function ExecutePayment($DataArray)
	{
		// ExecutePaymentFields Fields
		$ExecutePaymentFields = isset($DataArray['ExecutePaymentFields']) ? $DataArray['ExecutePaymentFields'] : array();
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<ExecutePaymentRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= isset($ExecutePaymentFields['PayKey']) ? '<payKey xmlns="">' . $ExecutePaymentFields['PayKey'] . '</payKey>' : '';
		$XMLRequest .= isset($ExecutePaymentFields['FundingPlanID']) ? '<fundingPlanId xmlns="">' . $ExecutePaymentFields['FundingPlanID'] . '</fundingPlanId>' : '';
		$XMLRequest .= '</ExecutePaymentRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'ExecutePayment');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		$PaymentExecStatus = $DOM -> getElementsByTagName('paymentExecStatus') -> length > 0 ? $DOM -> getElementsByTagName('paymentExecStatus') -> item(0) -> nodeValue : '';
	
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'PaymentExecStatus' => $PaymentExecStatus, 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
	
	
	/**
	 * Submit GetPaymentOptions API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function GetPaymentOptions($PayKey)
	{
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<GetPaymentOptionsRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= '<payKey xmlns="">' . $PayKey. '</payKey>';
		$XMLRequest .= '</GetPaymentOptionsRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'PaymentDetails');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		
		// GetPaymentOptionsResponse Fields
		$PayKey = $DOM -> getElementsByTagName('payKey') -> length > 0 ? $DOM -> getElementsByTagName('payKey') -> item(0) -> nodeValue : '';
		$ShippingAddressID = $DOM -> getElementsByTagName('shippingAddressId') -> length > 0 ? $DOM -> getElementsByTagName('shippingAddressId') -> item(0) -> nodeValue : '';
		
		// InitiatingEntity Fields
		$InstitutionCustomer = $DOM -> getElementsByTagName('institutionCustomer') -> length > 0 ? $DOM -> getElementsByTagName('institutionCustomer') -> item(0) -> nodeValue : '';
		$CountryCode = $InstitutionCustomer -> getElementsByTagName('countryCode') -> length > 0 ? $InstitutionCustomer -> getElementsByTagName('countryCode') -> item(0) -> nodeValue : '';
		$DisplayName = $InstitutionCustomer -> getElementsByTagName('displayName') -> length > 0 ? $InstitutionCustomer -> getElementsByTagName('displayName') -> item(0) -> nodeValue : '';
		$Email = $InstitutionCustomer -> getElementsByTagName('email') -> length > 0 ? $InstitutionCustomer -> getElementsByTagName('email') -> item(0) -> nodeValue : '';
		$FirstName = $InstitutionCustomer -> getElementsByTagName('firstName') -> length > 0 ? $InstitutionCustomer -> getElementsByTagName('firstName') -> item(0) -> nodeValue : '';
		$InstitutionCustomerID = $InstitutionCustomer -> getElementsByTagName('institutionCustomerId') -> length > 0 ? $InstitutionCustomer -> getElementsByTagName('institutionCustomerId') -> item(0) -> nodeValue : '';
		$InstitutionID = $InstitutionCustomer -> getElementsByTagName('institutionId') -> length > 0 ? $InstitutionCustomer -> getElementsByTagName('institutionId') -> item(0) -> nodeValue : '';
		$LastName = $InstitutionCustomer -> getElementsByTagName('lastName') -> length > 0 ? $InstitutionCustomer -> getElementsByTagName('lastName') -> item(0) -> nodeValue : '';
		$InitiatingEntity = array(
										'CountryCode' => $CountryCode, 
										'DisplayName' => $DisplayName, 
										'Email' => $Email, 
										'FirstName' => $FirstName, 
										'InstitutionCustomerID' => $InstitutionCustomerID, 
										'InstitutionID' => $InstitutionID, 
										'LastName' => $LastName
										);
		
		// DisplayOptions Fields
		$EmailHeaderImageURL = $DOM -> getElementsByTagName('emailHeaderImageUrl') -> length > 0 ? $DOM -> getElementsByTagName('emailHeaderImageUrl') -> item(0) -> nodeValue : '';
		$EmailMarketingImageURL = $DOM -> getElementsByTagName('emailMarketingImageUrl') -> length > 0 ? $DOM -> getElementsByTagName('emailMarketingImageUrl') -> item(0) -> nodeValue : '';
		$BusinessName = $DOM -> getElementsByTagName('businessName') -> length > 0 ? $DOM -> getElementsByTagName('businessName') -> item(0) -> nodeValue : '';
		$DisplayOptions = array(
								'EmailHeaderImageURL' => $EmailHeaderImageURL, 
								'EmailMarketingImageURL' => $EmailMarketingImageURL, 
								'BusinessName' => $BusinessName
								);

		// Sender Options
		$RequireShippingAddressSelection = $DOM -> getElementsByTagName('requireShippingAddressSelection') -> length > 0 ? $DOM -> getElementsByTagName('requireShippingAddressSelection') -> item(0) -> nodeValue : '';
	
		// ReceiverOptions Fields
		$ReceiverOptions = $DOM -> getElementsByTagName('receiverOptions') -> length > 0 ? $DOM -> getElementsByTagName('receiverOptions') -> item(0) -> nodeValue : '';
		$Description = $ReceiverOptions -> getElementsByTagName('description') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('description') -> item(0) -> nodeValue : '';
		$CustomID = $ReceiverOptions -> getElementsByTagName('customId') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('customId') -> item(0) -> nodeValue : '';
		$Email = $ReceiverOptions -> getElementsByTagName('email') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('email') -> item(0) -> nodeValue : '';
		$PhoneCountryCode = $ReceiverOptions -> getElementsByTagName('countryCode') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('countryCode') -> item(0) -> nodeValue : '';
		$PhoneNumber = $ReceiverOptions -> getElementsByTagName('phoneNumber') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('phoneNumber') -> item(0) -> nodeValue : '';
		$PhoneExtension = $ReceiverOptions -> getElementsByTagName('extension') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('extension') -> item(0) -> nodeValue : '';
		
		// InvoiceDataFields
		$InvoiceItems = $ReceiverOptions -> getElementsByTagName('item') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('item') : array();
		$TotalTax = $ReceiverOptions -> getElementsByTagName('totalTax') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('totalTax') -> item(0) -> nodeValue : '';
		$TotalShipping = $ReceiverOptions -> getElementsByTagName('totalShipping') -> length > 0 ? $ReceiverOptions -> getElementsByTagName('totalShipping') -> item(0) -> nodeValue : '';
		
		$InvoiceItemsArray = array();
		foreach($InvoiceItems as $InvoiceItem)
		{
			$ItemName = $InvoiceItem -> getElementsByTagName('name') -> length > 0 ? $InvoiceItem -> getElementsByTagName('name') -> item(0) -> nodeValue : '';
			$ItemIdentifier = $InvoiceItem -> getElementsByTagName('identifier') -> length > 0 ? $InvoiceItem -> getElementsByTagName('identifier') -> item(0) -> nodeValue : '';
			$ItemSubtotal = $InvoiceItem -> getElementsByTagName('price') -> length > 0 ? $InvoiceItem -> getElementsByTagName('price') -> item(0) -> nodeValue : '';
			$ItemPrice = $InvoiceItem -> getElementsByTagName('itemPrice') -> length > 0 ? $InvoiceItem -> getElementsByTagName('itemPrice') -> item(0) -> nodeValue : '';
			$ItemCount = $InvoiceItem -> getElementsByTagName('itemCount') -> length > 0 ? $InvoiceItem -> getElementsByTagName('itemCount') -> item(0) -> nodeValue : '';
			
			$CurrentItem = array(
								'Name' => $ItemName, 
								'Identifier' => $ItemIdentifier, 
								'Subtotal' => $ItemSubtotal, 
								'Price' => $ItemPrice, 
								'ItemCount' => $ItemCount
								);
			array_push($InvoiceItemsArray,$CurrentItem);	
		}
		
		$InvoiceData = array('TotalTax' => $TotalTax, 'TotalShipping' => $TotalShipping, 'InvoiceItems' => $InvoiceItemsArray);
		
		$ReceiverOptionsFields = array(
									'Description' => $Description, 
									'CustomID' => $CustomID, 
									'Email' => $Email, 
									'PhoneCountryCode' => $PhoneCountryCode, 
									'PhoneNumber' => $PhoneNumber, 
									'PhoneExtension' => $PhoneExtension, 
									'InvoiceData' => $InvoiceData
									);
	
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'PayKey' => $PayKey, 
								   'ShippingAddressID' => $ShippingAddressID, 
								   'InitiatingEntity' => $InitiatingEntity, 
								   'DisplayOptions' => $DisplayOptions, 
								   'RequireShippingAddressSelection' => $RequireShippingAddressSelection, 
								   'ReceiverOptions' => $ReceiverOptionsFields, 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
	
	
	/**
	 * Submit SetPaymentOptions API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function SetPaymentOptions($DataArray)
	{
		// SetPaymentOptions Basic Fields
		$SPOFields = isset($DataArray['SPOFields']) ? $DataArray['SPOFields'] : array();
		$PayKey = isset($SPOFields['PayKey']) ? $SPOFields['PayKey'] : '';
		$ShippingAddressID = isset($SPOFields['ShippingAddressID']) ? $SPOFields['ShippingAddressID'] : '';
		
		// DisplayOptions Fields
		$DisplayOptions = isset($DataArray['DisplayOptions']) ? $DataArray['DisplayOptions'] : array();
		$EmailHeaderImageURL = isset($DisplayOptions['EmailHeaderImageURL']) ? $DisplayOptions['EmailHeaderImageURL'] : '';
		$EmailMarketingImageURL = isset($DisplayOptions['EmailMarketingImageURL']) ? $DisplayOptions['EmailMarketingImageURL'] : '';
		$HeaderImageURL = isset($DisplayOptions['HeaderImageURL']) ? $DisplayOptions['HeaderImageURL'] : '';
		$BusinessName = isset($DisplayOptions['BusinessName']) ? $DisplayOptions['BusinessName'] : '';
		
		// InstitutionCustomer Fields
		$InstitutionCustomer = isset($DataArray['InstitutionCustomer']) ? $DataArray['InstitutionCustomer'] : array();
		$CountryCode = isset($InstitutionCustomer['CountryCode']) ? $InstitutionCustomer['CountryCode'] : '';
		$DisplayName = isset($InstitutionCustomer['DisplayName']) ? $InstitutionCustomer['DisplayName'] : '';
		$InstitutionCustomerEmail = isset($InstitutionCustomer['Email']) ? $InstitutionCustomer['Email'] : '';
		$FirstName = isset($InstitutionCustomer['FirstName']) ? $InstitutionCustomer['FirstName'] : '';
		$LastName = isset($InstitutionCustomer['LastName']) ? $InstitutionCustomer['LastName'] : '';
		$InstitutionCustomerID = isset($InstitutionCustomer['InstitutionCustomerID']) ? $InstitutionCustomer['InstitutionCustomerID'] : '';
		$InstitutionID = isset($InstitutionCustomer['InstitutionID']) ? $InstitutionCustomer['InstitutionID'] : '';
		
		// SenderOptions Fields
		$SenderOptions = isset($DataArray['SenderOptions']) ? $DataArray['SenderOptions'] : array();
		$RequireShippingAddressSelection = isset($SenderOptions['RequireShippingAddressSelection']) ? $SenderOptions['RequireShippingAddressSelection'] : '';
		
		// ReceiverOptions Fields
		$ReceiverOptions = isset($DataArray['ReceiverOptions']) ? $DataArray['ReceiverOptions'] : array();
		$Description = isset($ReceiverOptions['Description']) ? $ReceiverOptions['Description'] : '';
		$CustomID = isset($ReceiverOptions['CustomID']) ? $ReceiverOptions['CustomID'] : '';
		
		// InvoiceData Fields
		$InvoiceData = isset($DataArray['InvoiceData']) ? $DataArray['InvoiceData'] : array();
		$TotalTax = isset($InvoiceData['TotalTax']) ? $InvoiceData['TotalTax'] : '';
		$TotalShipping = isset($InvoiceData['TotalShipping']) ? $InvoiceData['TotalShipping'] : '';
		
		// InvoiceItem Fields
		$InvoiceItems = isset($DataArray['InvoiceItems']) ? $DataArray['InvoiceItems'] : array();
		
		// ReceiverIdentifer Fields
		$ReceiverIdentifer = isset($DataArray['ReceiverIdentifer']) ? $DataArray['ReceiverIdentifer'] : array();
		$ReceiverIdentiferEmail = isset($ReceiverIdentifer['Email']) ? $ReceiverIdentifer['Email'] : '';
		$PhoneCountryCode = isset($ReceiverIdentifer['PhoneCountryCode']) ? $ReceiverIdentifer['PhoneCountryCode'] : '';
		$PhoneNumber = isset($ReceiverIdentifer['PhoneNumber']) ? $ReceiverIdentifer['PhoneNumber'] : '';
		$PhoneExtension = isset($ReceiverIdentifer['PhoneExtension']) ? $ReceiverIdentifer['PhoneExtension'] : '';

		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<SetPaymentOptionsRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= $PayKey != '' ? '<payKey xmlns="">'.$PayKey.'</payKey>' : '';
		$XMLRequest .= $ShippingAddressID != '' ? '<shippingAddressId xmlns="">'.$ShippingAddressID.'</shippingAddressId>' : '';
		
		if(count($InstitutionCustomer) > 0)
		{
			$XMLRequest .= '<initiatingEntity xmlns="">';
			$XMLRequest .= '<institutionCustomer xmlns="">';
			$XMLRequest .= $InstitutionID != '' ? '<institutionId xmlns="">'.$InstitutionID.'</institutionId>' : '';
			$XMLRequest .= $FirstName != '' ? '<firstName xmlns="">'.$FirstName.'</firstName>' : '';
			$XMLRequest .= $LastName != '' ? '<lastName xmlns="">'.$LastName.'</lastName>' : '';
			$XMLRequest .= $DisplayName != '' ? '<displayName xmlns="">'.$DisplayName.'</displayName>' : '';
			$XMLRequest .= $InstitutionCustomerID != '' ? '<institutionCustomerId xmlns="">'.$InstitutionCustomerID.'</institutionCustomerId>' : '';
			$XMLRequest .= $CountryCode != '' ? '<countryCode xmlns="">'.$CountryCode.'</countryCode>' : '';
			$XMLRequest .= $InstitutionCustomerEmail != '' ? '<email xmlns="">'.$InstitutionCustomerEmail.'</email>' : '';
			$XMLRequest .= '</institutionCustomer>';
			$XMLRequest .= '</initiatingEntity>';	
		}
		
		if(count($DisplayOptions) > 0)
		{
			$XMLRequest .= '<displayOptions xmlns="">';
			$XMLRequest .= $EmailHeaderImageURL != '' ? '<emailHeaderImageUrl xmlns="">'.$EmailHeaderImageURL.'</emailHeaderImageUrl>' : '';
			$XMLRequest .= $EmailMarketingImageURL != '' ? '<emailMarketingImageUrl xmlns="">'.$EmailMarketingImageURL.'</emailMarketingImageUrl>' : '';
			$XMLRequest .= $HeaderImageURL != '' ? '<headerImageUrl xmlns="">'.$HeaderImageURL.'</headerImageUrl>' : '';
			$XMLRequest .= $BusinessName != '' ? '<businessName xmlns="">'.$BusinessName.'</businessName>' : '';
			$XMLRequest .= '</displayOptions>';	
		}
		
		if(count($SenderOptions) > 0)
		{
			$XMLRequest .= '<senderOptions xmlns="">';
			$XMLRequest .= $RequireShippingAddressSelection != '' ? '<requireShippingAddressSelection xmlns="">'.$RequireShippingAddressSelection.'</requireShippingAddressSelection>' : '';
			$XMLRequest .= '</senderOptions>';	
		}
		
		$XMLRequest .= '<receiverOptions xmlns="">';
		$XMLRequest .= $Description != '' ? '<description xmlns="">'.$Description.'</description>' : '';
		$XMLRequest .= $CustomID != '' ? '<customId xmlns="">'.$CustomID.'</customId>' : '';
		$XMLRequest .= '<invoiceData xmlns="">';
		$XMLRequest .= $TotalTax != '' ? '<totalTax xmlns="">'.$TotalTax.'</totalTax>' : '';
		$XMLRequest .= $TotalShipping != '' ? '<totalShipping xmlns="">'.$TotalShipping.'</totalShipping>' : '';
		
		foreach($InvoiceItems as $InvoiceItem)
		{
			$XMLRequest .= '<item xmlns="">';
			$XMLRequest .= $InvoiceItem['Name'] != '' ? '<name xmlns="">'.$InvoiceItem['Name'].'</name>' : '';
			$XMLRequest .= $InvoiceItem['Identifier'] != '' ? '<identifier xmlns="">'.$InvoiceItem['Identifier'].'</identifier>' : '';
			$XMLRequest .= $InvoiceItem['Price'] != '' ? '<price xmlns="">'.$InvoiceItem['Price'].'</price>' : '';
			$XMLRequest .= $InvoiceItem['ItemPrice'] != '' ? '<itemPrice xmlns="">'.$InvoiceItem['ItemPrice'].'</itemPrice>' : '';
			$XMLRequest .= $InvoiceItem['ItemCount'] != '' ? '<itemCount xmlns="">'.$InvoiceItem['ItemCount'].'</itemCount>' : '';
			$XMLRequest .= '</item>';	
		}
		
		$XMLRequest .= '</invoiceData>';
		
		if(count($ReceiverIdentifer) > 0)
		{
			$XMLRequest .= '<receiver xmlns="">';
			$XMLRequest .= $ReceiverIdentiferEmail != '' ? '<email xmlns="">'.$ReceiverIdentiferEmail.'</email>' : '';
			$XMLRequest .= '<phone xmlns="">';
			$XMLRequest .= $PhoneCountryCode != '' ? '<countryCode xmlns="">'.$PhoneCountryCode.'</countryCode>' : '';
			$XMLRequest .= $PhoneNumber != '' ? '<phoneNumber xmlns="">'.$PhoneNumber.'</phoneNumber>' : '';
			$XMLRequest .= $PhoneExtension != '' ? '<extension xmlns="">'.$PhoneExtension.'</extension>' : '';
			$XMLRequest .= '</phone>';
			$XMLRequest .= '</receiver>';	
		}
		
		$XMLRequest .= '</receiverOptions>';
		$XMLRequest .= '</SetPaymentOptionsRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'SetPaymentOptions');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
		
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';

		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
	
	/**
	 * Submit Preapproval API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function Preapproval($DataArray)
	{	
		$PreapprovalFields = isset($DataArray['PreapprovalFields']) ? $DataArray['PreapprovalFields'] : array();
		$CancelURL = isset($PreapprovalFields['CancelURL']) ? $PreapprovalFields['CancelURL'] : '';
		$CurrencyCode = isset($PreapprovalFields['CurrencyCode']) ? $PreapprovalFields['CurrencyCode'] : '';
		$DateOfMonth = isset($PreapprovalFields['DateOfMonth']) ? $PreapprovalFields['DateOfMonth'] : '';
		$DayOfWeek = isset($PreapprovalFields['DayOfWeek']) ? $PreapprovalFields['DayOfWeek'] : '';
		$EndingDate = isset($PreapprovalFields['EndingDate']) ? $PreapprovalFields['EndingDate'] : '';
		$IPNNotificationURL = isset($PreapprovalFields['IPNNotificationURL']) ? $PreapprovalFields['IPNNotificationURL'] : '';
		$MaxAmountPerPayment = isset($PreapprovalFields['MaxAmountPerPayment']) ? $PreapprovalFields['MaxAmountPerPayment'] : '';
		$MaxNumberOfPayments = isset($PreapprovalFields['MaxNumberOfPayments']) ? $PreapprovalFields['MaxNumberOfPayments'] : '';
		$MaxNumberOfPaymentsPerPeriod = isset($PreapprovalFields['MaxNumberOfPaymentsPerPeriod']) ? $PreapprovalFields['MaxNumberOfPaymentsPerPeriod'] : '';
		$MaxTotalAmountOfAllPayments = isset($PreapprovalFields['MaxTotalAmountOfAllPayments']) ? $PreapprovalFields['MaxTotalAmountOfAllPayments'] : '';
		$Memo = isset($PreapprovalFields['Memo']) ? $PreapprovalFields['Memo'] : '';
		$PaymentPeriod = isset($PreapprovalFields['PaymentPeriod']) ? $PreapprovalFields['PaymentPeriod'] : '';
		$PinType = isset($PreapprovalFields['PinType']) ? $PreapprovalFields['PinType'] : '';
		$ReturnURL = isset($PreapprovalFields['ReturnURL']) ? $PreapprovalFields['ReturnURL'] : '';
		$SenderEmail = isset($PreapprovalFields['SenderEmail']) ? $PreapprovalFields['SenderEmail'] : '';
		$StartingDate = isset($PreapprovalFields['StartingDate']) ? $PreapprovalFields['StartingDate'] : '';
		
		$ClientDetailsFields = isset($DataArray['ClientDetailsFields']) ? $DataArray['ClientDetails'] : array();
		$CustomerID = isset($ClientDetailsFields['CustomerID']) ? $ClientDetailsFields['CustomerID'] : '';
		$CustomerType = isset($ClientDetailsFields['CustomerType']) ? $ClientDetailsFields['CustomerType'] : '';
		$GeoLocation = isset($ClientDetailsFields['GeoLocation']) ? $ClientDetailsFields['GeoLocation'] : '';
		$Model = isset($ClientDetailsFields['Model']) ? $ClientDetailsFields['Model'] : '';
		$PartnerName = isset($ClientDetailsFields['PartnerName']) ? $ClientDetailsFields['PartnerName'] : '';
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<PreapprovalRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= '<cancelUrl xmlns="">' . $CancelURL . '</cancelUrl>';
		
		$XMLRequest .= '<clientDetails xmlns="">';
		$XMLRequest .= $this -> ApplicationID != '' ? '<applicationId xmlns="">' . $this -> ApplicationID . '</applicationId>' : '';
		$XMLRequest .= $CustomerID != '' ? '<customerId xmlns="">' . $CustomerID . '</customerId>' : '';
		$XMLRequest .= $CustomerType != '' ? '<customerType xmlns="">' . $CustomerType . '</customerType>' : '';
		$XMLRequest .= $this -> DeviceID != '' ? '<deviceId xmlns="">' . $this -> DeviceID . '</deviceId>' : '';
		$XMLRequest .= $GeoLocation != '' ? '<geoLocation xmlns="">' . $GeoLocation . '</geoLocation>' : '';
		$XMLRequest .= $this -> IPAddress != '' ? '<ipAddress xmlns="">' . $this -> IPAddress . '</ipAddress>' : '';
		$XMLRequest .= $Model != '' ? '<model xmlns="">' . $Model . '</model>' : '';
		$XMLRequest .= $PartnerName != '' ? '<partnerName xmlns="">' . $PartnerName . '</partnerName>' : '';
		$XMLRequest .= '</clientDetails>';
		
		$XMLRequest .= '<currencyCode xmlns="">' . $CurrencyCode . '</currencyCode>';
		$XMLRequest .= $DateOfMonth != '' ? '<dateOfMonth xmlns="">' . $DateOfMonth . '</dateOfMonth>' : '';
		$XMLRequest .= $DayOfWeek != '' ? '<dayOfWeek xmlns="">' . $DayOfWeek . '</dayOfWeek>' : '';
		$XMLRequest .= $EndingDate != '' ? '<endingDate xmlns="">' . $EndingDate . '</endingDate>' : '';
		$XMLRequest .= $IPNNotificationURL != '' ? '<ipnNotificationUrl xmlns="">' . $IPNNotificationURL . '</ipnNotificationUrl>' : '';
		$XMLRequest .= $MaxAmountPerPayment != '' ? '<maxAmountPerPayment xmlns="">' . $MaxAmountPerPayment . '</maxAmountPerPayment>' : '';
		$XMLRequest .= $MaxNumberOfPayments != '' ? '<maxNumberOfPayments xmlns="">' . $MaxNumberOfPayments . '</maxNumberOfPayments>' : '';
		$XMLRequest .= $MaxNumberOfPaymentsPerPeriod != '' ? '<maxNumberOfPaymentsPerPeriod xmlns="">' . $MaxNumberOfPaymentsPerPeriod . '</maxNumberOfPaymentsPerPeriod>' : '';
		$XMLRequest .= $MaxTotalAmountOfAllPayments != '' ? '<maxTotalAmountOfAllPayments xmlns="">' . $MaxTotalAmountOfAllPayments . '</maxTotalAmountOfAllPayments>' : '';
		$XMLRequest .= $Memo != '' ? '<memo xmlns="">' . $Memo . '</memo>' : '';
		$XMLRequest .= $PaymentPeriod != '' ? '<paymentPeriod xmlns="">' . $Memo . '</paymentPeriod>' : '';
		$XMLRequest .= $PinType != '' ? '<pinType xmlns="">' . $PinType . '</pinType>' : '';
		$XMLRequest .= $ReturnURL != '' ? '<returnUrl xmlns="">' . $ReturnURL . '</returnUrl>' : '';
		$XMLRequest .= $SenderEmail != '' ? '<senderEmail xmlns="">' . $PinType . '</SenderEmail>' : '';
		$XMLRequest .= $StartingDate != '' ? '<startingDate xmlns="">' . $StartingDate . '</startingDate>' : '';
		$XMLRequest .= '</PreapprovalRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'Preapproval');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		$PreapprovalKey = $DOM -> getElementsByTagName('preapprovalKey') -> length > 0 ? $DOM -> getElementsByTagName('preapprovalKey') -> item(0) -> nodeValue: '';
		
		if($this -> Sandbox)
		{
			$RedirectURL = 'https://www.sandbox.paypal.com/webscr?cmd=_ap-preapproval&preapprovalkey=' . $PreapprovalKey;
		}
		elseif($this -> BetaSandbox)
		{
			$RedirectURL = 'https://www.beta-sandbox.paypal.com/webscr?cmd=_ap-preapproval&preapprovalkey=' . $PreapprovalKey;
		}
		else
		{
			$RedirectURL = 'https://www.paypal.com/webscr?cmd=_ap-preapproval&preapprovalkey=' . $PreapprovalKey;
		}
		
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'PreapprovalKey' => $PreapprovalKey, 
								   'RedirectURL' => $PreapprovalKey != '' ? $RedirectURL : '', 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
	
	/**
	 * Submit PreapprovalDetails API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function PreapprovalDetails($DataArray)
	{
		$PreapprovalDetailsFields = isset($DataArray['PreapprovalDetailsFields']) ? $DataArray['PreapprovalDetailsFields'] : array();
		$GetBillingAddress = isset($PreapprovalDetailsFields['GetBillingAddress']) ? $PreapprovalDetailsFields['GetBillingAddress'] : '';
		$PreapprovalKey = isset($PreapprovalDetailsFields['PreapprovalKey']) ? $PreapprovalDetailsFields['PreapprovalKey'] : '';
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<PreapprovalDetailsRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= $GetBillingAddress != '' ? '<getBillingAddress>' . $GetBillingAddress . '</getBillingAddress>' : '';
		$XMLRequest .= $PreapprovalKey != '' ? '<preapprovalKey>' . $PreapprovalKey . '</preapprovalKey>' : '';
		$XMLRequest .= '</PreapprovalDetailsRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'PreapprovalDetails');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		
		$Approved = $DOM -> getElementsByTagName('approved') -> length > 0 ? $DOM -> getElementsByTagName('approved') -> item(0) -> nodeValue : '';
		$CancelURL = $DOM -> getElementsByTagName('cancelUrl') -> length > 0 ? $DOM -> getElementsByTagName('cancelUrl') -> item(0) -> nodeValue : '';
		$CurPayments = $DOM -> getElementsByTagName('curPayments') -> length > 0 ? $DOM -> getElementsByTagName('curPayments') -> item(0) -> nodeValue : '';
		$CurPaymentsAmount = $DOM -> getElementsByTagName('curPaymentsAmount') -> length > 0 ? $DOM -> getElementsByTagName('curPaymentsAmount') -> item(0) -> nodeValue : '';
		$CurPeriodAttempts = $DOM -> getElementsByTagName('curPeriodAttempts') -> length > 0 ? $DOM -> getElementsByTagName('curPeriodAttempts') -> item(0) -> nodeValue : '';
		$CurPeriodEndingDate = $DOM -> getElementsByTagName('curPeriodEndingDate') -> length > 0 ? $DOM -> getElementsByTagName('curPeriodEndingDate') -> item(0) -> nodeValue : '';
		$CurrencyCode = $DOM -> getElementsByTagName('currencyCode') -> length > 0 ? $DOM -> getElementsByTagName('currencyCode') -> item(0) -> nodeValue : '';
		$DateOfMonth = $DOM -> getElementsByTagName('dateOfMonth') -> length > 0 ? $DOM -> getElementsByTagName('dateOfMonth') -> item(0) -> nodeValue : '';
		$DayOfWeek = $DOM -> getElementsByTagName('dayOfWeek') -> length > 0 ? $DOM -> getElementsByTagName('dayOfWeek') -> item(0) -> nodeValue : '';
		$EndingDate = $DOM -> getElementsByTagName('endingDate') -> length > 0 ? $DOM -> getElementsByTagName('endingDate') -> item(0) -> nodeValue : '';
		$IPNNotificationURL = $DOM -> getElementsByTagName('ipnNotificationUrl') -> length > 0 ? $DOM -> getElementsByTagName('ipnNotificationUrl') -> item(0) -> nodeValue : '';
		$MaxAmountPerPayment = $DOM -> getElementsByTagName('maxAmountPerPayment') -> length > 0 ? $DOM -> getElementsByTagName('maxAmountPerPayment') -> item(0) -> nodeValue : '';
		$MaxNumberOfPayments = $DOM -> getElementsByTagName('maxNumberOfPayments') -> length > 0 ? $DOM -> getElementsByTagName('maxNumberOfPayments') -> item(0) -> nodeValue : '';
		$MaxNumberOfPaymentsPerPeriod = $DOM -> getElementsByTagName('maxNumberOfPaymentsPerPeriod') -> length > 0 ? $DOM -> getElementsByTagName('maxNumberOfPaymentsPerPeriod') -> item(0) -> nodeValue : '';
		$MaxTotalAmountOfAllPayments = $DOM -> getElementsByTagName('maxTotalAmountOfAllPayments') -> length > 0 ? $DOM -> getElementsByTagName('maxTotalAmountOfAllPayments') -> item(0) -> nodeValue : '';
		$Memo = $DOM -> getElementsByTagName('memo') -> length > 0 ? $DOM -> getElementsByTagName('memo') -> item(0) -> nodeValue : '';
		$PaymentPeriod = $DOM -> getElementsByTagName('paymentPeriod') -> length > 0 ? $DOM -> getElementsByTagName('paymentPeriod') -> item(0) -> nodeValue : '';
		$PinType = $DOM -> getElementsByTagName('pinType') -> length > 0 ? $DOM -> getElementsByTagName('pinType') -> item(0) -> nodeValue : '';
		$ReturnUrl = $DOM -> getElementsByTagName('returnUrl') -> length > 0 ? $DOM -> getElementsByTagName('returnUrl') -> item(0) -> nodeValue : '';
		$SenderEmail = $DOM -> getElementsByTagName('senderEmail') -> length > 0 ? $DOM -> getElementsByTagName('senderEmail') -> item(0) -> nodeValue : '';
		$StartingDate = $DOM -> getElementsByTagName('startingDate') -> length > 0 ? $DOM -> getElementsByTagName('startingDate') -> item(0) -> nodeValue : '';
		$Status = $DOM -> getElementsByTagName('status') -> length > 0 ? $DOM -> getElementsByTagName('status') -> item(0) -> nodeValue : '';
		
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'Approved' => $Approved, 
								   'CancelURL' => $CancelURL, 
								   'CurPayments' => $CurPayments, 
								   'CurPaymentsAmount' => $CurPaymentsAmount, 
								   'CurPeriodAttempts' => $CurPeriodAttempts, 
								   'CurPeriodEndingDate' => $CurPeriodEndingDate, 
								   'CurrencyCode' => $CurrencyCode, 
								   'DateOfMonth' => $DateOfMonth, 
								   'DayOfWeek' => $DayOfWeek, 
								   'EndingDate' => $EndingDate, 
								   'IPNNotificationURL' => $IPNNotificationURL, 
								   'MaxAmountPerPayment' => $MaxAmountPerPayment, 
								   'MaxNumberOfPayments' => $MaxNumberOfPayments, 
								   'MaxNumberOfPaymentsPerPeriod' => $MaxNumberOfPaymentsPerPeriod, 
								   'MaxTotalAmountOfAllPayments' => $MaxTotalAmountOfAllPayments, 
								   'Memo' => $Memo, 
								   'PaymentPeriod' => $PaymentPeriod, 
								   'PinType' => $PinType, 
								   'ReturnUrl' => $ReturnUrl, 
								   'SenderEmail' => $SenderEmail, 
								   'StartingDate' => $StartingDate, 
								   'Status' => $Status, 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
	
	/**
	 * Submit CancelPreapproval API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function CancelPreapproval($DataArray)
	{
		$CancelPreapprovalFields = isset($DataArray['CancelPreapprovalFields']) ? $DataArray['CancelPreapprovalFields'] : array();
		$PreapprovalKey = isset($CancelPreapprovalFields['PreapprovalKey']) ? $CancelPreapprovalFields['PreapprovalKey'] : '';
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<CancelPreapprovalRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= $PreapprovalKey != '' ? '<preapprovalKey>' . $PreapprovalKey . '</preapprovalKey>' : '';
		$XMLRequest .= '</CancelPreapprovalRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'CancelPreapproval');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
	
	/**
	 * Submit Refund API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function Refund($DataArray)
	{
		$RefundFields = isset($DataArray['RefundFields']) ? $DataArray['RefundFields'] : array();
		$CurrencyCode = isset($RefundFields['CurrencyCode']) ? $RefundFields['CurrencyCode'] : '';
		$PayKey = isset($RefundFields['PayKey']) ? $RefundFields['PayKey'] : '';
		$TransactionID = isset($RefundFields['TransactionID']) ? $RefundFields['TransactionID'] : '';
		$TrackingID = isset($RefundFields['TrackingID']) ? $RefundFields['TrackingID'] : '';
		
		$Receivers = isset($DataArray['Receivers']) ? $DataArray['Receivers'] : array();
		$Amount = isset($Receivers['Amount']) ? $Receivers['Amount'] : '';
		$Email = isset($Receivers['Email']) ? $Receivers['Email'] : '';
		$InvoiceID = isset($Receivers['InvoiceID']) ? $Receivers['InvoiceID'] : '';
		$Primary = isset($Receivers['Primary']) ? $Receivers['Primary'] : '';
		$PaymentType = isset($Receivers['PaymentType']) ? $Receivers['PaymentType'] : '';
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<RefundRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= $CurrencyCode != '' ? '<currencyCode>' . $CurrencyCode . '</currencyCode>' : '';
		$XMLRequest .= $PayKey != '' ? '<payKey>' . $PayKey . '</payKey>' : '';
		
		$XMLRequest .= '<receiverList xmlns="">';
		foreach($Receivers as $Receiver)
		{
			$XMLRequest .= '<receiver xmlns="">';
			$XMLRequest .= '<amount xmlns="">' . $Receiver['Amount'] . '</amount>';
			$XMLRequest .= '<email xmlns="">' . $Receiver['Email'] . '</email>';
			$XMLRequest .= $Receiver['InvoiceID'] != '' ? '<invoiceId xmlns="">' . $Receiver['InvoiceID'] . '</invoiceId>' : '';
			$XMLRequest .= $Receiver['PaymentType'] != '' ? '<paymentType xmlns="">' . $Receiver['PaymentType'] . '</paymentType>' : '';
			$XMLRequest .= '</receiver>';
		}
		$XMLRequest .= '</receiverList>';
		
		$XMLRequest .= $TransactionID != '' ? '<transactionId>' . $TransactionID . '</transactionId>' : '';
		$XMLRequest .= $TrackingID != '' ? '<trackingId>' . $TrackingID . '</trackingId>' : '';
		$XMLRequest .= '</RefundRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'Refund');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		
		$EncryptedTransactionID = $DOM -> getElementsByTagName('encryptedRefundTransactionId') -> length > 0 ? $DOM -> getElementsByTagName('encryptedRefundTransactionId') -> item(0) -> nodeValue : '';
		$RefundFeeAmount = $DOM -> getElementsByTagName('refundFeeAmount') -> length > 0 ? $DOM -> getElementsByTagName('refundFeeAmount') -> item(0) -> nodeValue : '';
		$RefundGrossAmount = $DOM -> getElementsByTagName('refundGrossAmount') -> length > 0 ? $DOM -> getElementsByTagName('refundGrossAmount') -> item(0) -> nodeValue : '';
		$RefundHasBecomeFull = $DOM -> getElementsByTagName('refundHasBecomeFull') -> length > 0 ? $DOM -> getElementsByTagName('refundHasBecomeFull') -> item(0) -> nodeValue : '';
		$RefundNetAmount = $DOM -> getElementsByTagName('refundNetAmount') -> length > 0 ? $DOM -> getElementsByTagName('refundNetAmount') -> item(0) -> nodeValue : '';
		$RefundStatus = $DOM -> getElementsByTagName('refundStatus') -> length > 0 ? $DOM -> getElementsByTagName('refundStatus') -> item(0) -> nodeValue : '';
		$RefundTransactionStatus = $DOM -> getElementsByTagName('refundTransactionStatus') -> length > 0 ? $DOM -> getElementsByTagName('refundTransactionStatus') -> item(0) -> nodeValue : '';
		$TotalOfAllRefunds = $DOM -> getElementsByTagName('totalOfAllRefunds') -> length > 0 ? $DOM -> getElementsByTagName('totalOfAllRefunds') -> item(0) -> nodeValue : '';
		
		$Amount = $DOM -> getElementsByTagName('amount') -> length > 0 ? $DOM -> getElementsByTagName('amount') -> item(0) -> nodeValue : '';
		$Email = $DOM -> getElementsByTagName('email') -> length > 0 ? $DOM -> getElementsByTagName('email') -> item(0) -> nodeValue : '';
		$InvoiceID = $DOM -> getElementsByTagName('invoiceId') -> length > 0 ? $DOM -> getElementsByTagName('invoiceId') -> item(0) -> nodeValue : '';
		$PaymentType = $DOM -> getElementsByTagName('paymentType') -> length > 0 ? $DOM -> getElementsByTagName('paymentType') -> item(0) -> nodeValue : '';
		$Primary = $DOM -> getElementsByTagName('primary') -> length > 0 ? $DOM -> getElementsByTagName('primary') -> item(0) -> nodeValue : '';
		$Receiver = array(
						'Amount' => $Amount, 
						'Email' => $Email, 
						'InvoiceID' => $InvoiceID, 
						'PaymentType' => $PaymentType, 
						'Primary' => $Primary
						  );
		
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'EncryptedTransactionID' => $EncryptedTransactionID, 
								   'RefundFeeAmount' => $RefundFeeAmount, 
								   'RefundGrossAmount' => $RefundGrossAmount, 
								   'RefundHasBecomeFull' => $RefundHasBecomeFull, 
								   'RefundNetAmount' => $RefundNetAmount, 
								   'RefundStatus' => $RefundStatus, 
								   'RefundTransactionStatus' => $RefundTransactionStatus, 
								   'TotalOfAllRefunds' => $TotalOfAllRefunds, 
								   'Receiver' => $Receiver
								   );
		
		return $ResponseDataArray;
	}
	
	/**
	 * Submit ConvertCurrency API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function ConvertCurrency($DataArray)
	{
		$BaseAmountList = isset($DataArray['BaseAmountList']) ? $DataArray['BaseAmountList'] : array();
		$ConvertToCurrencyList = isset($DataArray['ConvertToCurrencyList']) ? $DataArray['ConvertToCurrencyList'] : array();
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<ConvertCurrencyRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= '<baseAmountList xmlns="">';
		foreach($BaseAmountList as $BaseAmount)
		{
			$XMLRequest .= '<currency xmlns="">';
			$XMLRequest .= '<code xmlns="">' . $BaseAmount['Code'] . '</code>';
			$XMLRequest .= '<amount xmlns="">' . $BaseAmount['Amount'] . '</amount>';
			$XMLRequest .= '</currency>';
		}
		$XMLRequest .= '</baseAmountList>';
		$XMLRequest .= '<convertToCurrencyList xmlns="">';
		foreach($ConvertToCurrencyList as $CurrencyCode)
			$XMLRequest .= '<currencyCode xmlns="">' . $CurrencyCode . '</currencyCode>';
		$XMLRequest .= '</convertToCurrencyList>';
		$XMLRequest .= '</ConvertCurrencyRequest>';
		
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptivePayments', 'ConvertCurrency');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
						
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		
		$CurrencyConversionListArray = array();
		$CurrencyConversionListDOM = $DOM -> getElementsByTagName('currencyConversionList') -> length > 0 ? $DOM -> getElementsByTagName('currencyConversionList') : array();
		
		foreach($CurrencyConversionListDOM as $CurrencyConversionList)
		{
			$BaseAmountDOM = $CurrencyConversionList -> getElementsByTagName('baseAmount') -> length > 0 ? $CurrencyConversionList -> getElementsByTagName('baseAmount') : array();		
			foreach($BaseAmountDOM as $BaseAmount)
			{
				$BaseAmountCurrencyCode = $BaseAmount -> getElementsByTagName('code') -> length > 0 ? $BaseAmount -> getElementsByTagName('code') -> item(0) -> nodeValue : '';
				$BaseAmountValue = $BaseAmount -> getElementsByTagName('amount') -> length > 0 ? $BaseAmount -> getElementsByTagName('amount') -> item(0) -> nodeValue : '';
				$BaseAmountArray = array(
										 'Code' => $BaseAmountCurrencyCode, 
										 'Amount' => $BaseAmountValue
										 );
			}
			
			$CurrencyListArray = array();
			$CurrencyListDOM = $CurrencyConversionList -> getElementsByTagName('currency') -> length > 0 ? $CurrencyConversionList -> getElementsByTagName('currency') : array();
			foreach($CurrencyListDOM as $CurrencyList)
			{
				$ListCurrencyCode = $CurrencyList -> getElementsByTagName('code') -> length > 0 ? $CurrencyList -> getElementsByTagName('code') -> item(0) -> nodeValue : '';
				$ListCurrencyAmount = $CurrencyList -> getElementsByTagName('amount') -> length > 0 ? $CurrencyList -> getElementsByTagName('amount') -> item(0) -> nodeValue : '';
				$ListCurrencyCurrent = array(
											 'Code' => $ListCurrencyCode, 
											 'Amount' => $ListCurrencyAmount
											 );
				array_push($CurrencyListArray, $ListCurrencyCurrent);
			}
			
			$CurrencyConversionListCurrent = array(
												   'BaseAmount' => $BaseAmountArray, 
												   'CurrencyList' => $CurrencyListArray
												   );
			
			array_push($CurrencyConversionListArray, $CurrencyConversionListCurrent);
		}
		
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'CurrencyConversionList' => $CurrencyConversionListArray, 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
	
	/**
	 * Submit CreateAccount API request to PayPal.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function CreateAccount($DataArray)
	{
		$CreateAccountFields = isset($DataArray['CreateAccountFields']) ? $DataArray['CreateAccountFields'] : array();
		$AccountType = isset($CreateAccountFields['AccountType']) ? $CreateAccountFields['AccountType'] : '';
		$CitizenshipCountryCode = isset($CreateAccountFields['CitizenshipCountryCode']) ? $CreateAccountFields['CitizenshipCountryCode'] : '';
		$ContactPhoneNumber = isset($CreateAccountFields['ContactPhoneNumber']) ? $CreateAccountFields['ContactPhoneNumber'] : '';
		$ReturnURL = isset($CreateAccountFields['ReturnURL']) ? $CreateAccountFields['ReturnURL'] : '';
		$CurrencyCode = isset($CreateAccountFields['CurrencyCode']) ? $CreateAccountFields['CurrencyCode'] : '';
		$DateOfBirth = isset($CreateAccountFields['DateOfBirth']) ? $CreateAccountFields['DateOfBirth'] : '';
		$EmailAddress = isset($CreateAccountFields['EmailAddress']) ? $CreateAccountFields['EmailAddress'] : '';
		$Salutation = isset($CreateAccountFields['Salutation']) ? $CreateAccountFields['Salutation'] : '';
		$FirstName = isset($CreateAccountFields['FirstName']) ? $CreateAccountFields['FirstName'] : '';
		$MiddleName = isset($CreateAccountFields['MiddleName']) ? $CreateAccountFields['MiddleName'] : '';
		$LastName = isset($CreateAccountFields['LastName']) ? $CreateAccountFields['LastName'] : '';
		$Suffix = isset($CreateAccountFields['Suffix']) ? $CreateAccountFields['Suffix'] : '';
		$NotificationURL = isset($CreateAccountFields['NotificationURL']) ? $CreateAccountFields['NotificationURL'] : '';
		$PreferredLanguageCode = isset($CreateAccountFields['PreferredLanguageCode']) ? $CreateAccountFields['PreferredLanguageCode'] : 'en_US';
		$RegistrationType = isset($CreateAccountFields['RegistrationType']) ? $CreateAccountFields['RegistrationType'] : 'Web';
		
		$Address = isset($DataArray['Address']) ? $DataArray['Address'] : array();
		$Line1 = isset($Address['Line1']) ? $Address['Line1'] : '';
		$Line2 = isset($Address['Line2']) ? $Address['Line2'] : '';
		$City = isset($Address['City']) ? $Address['City'] : '';
		$State = isset($Address['State']) ? $Address['State'] : '';
		$PostalCode = isset($Address['PostalCode']) ? $Address['PostalCode'] : '';
		$CountryCode = isset($Address['CountryCode']) ? $Address['CountryCode'] : '';
		
		$PartnerFields = isset($DataArray['PartnerFields']) ? $DataArray['PartnerFields'] : array();
		$PartnerField1 = isset($PartnerFields['Field1']) ? $PartnerFields['Field1'] : '';
		$PartnerField2 = isset($PartnerFields['Field2']) ? $PartnerFields['Field2'] : '';
		$PartnerField3 = isset($PartnerFields['Field3']) ? $PartnerFields['Field3'] : '';
		$PartnerField4 = isset($PartnerFields['Field4']) ? $PartnerFields['Field4'] : '';
		$PartnerField5 = isset($PartnerFields['Field5']) ? $PartnerFields['Field5'] : '';
		
		// Generate XML Request
		$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
		$XMLRequest .= '<CreateAccountRequest xmlns="' . $this -> XMLNamespace . '">';
		$XMLRequest .= $this -> GetXMLRequestEnvelope();
		$XMLRequest .= '<accountType xmlns="">' . $AccountType . '</accountType>';
		$XMLRequest .= '<emailAddress xmlns="">' . $EmailAddress . '</emailAddress>';
		$XMLRequest .= '<name xmlns="">';
		$XMLRequest .= $Salutation != '' ? '<salutation xmlns="">' . $Salutation . '</salutation>' : '';
		$XMLRequest .= '<firstName xmlns="">' . $FirstName . '</firstName>';
		$XMLRequest .= $MiddleName != '' ? '<middleName xmlns="">' . $MiddleName . '</middleName>' : '';
		$XMLRequest .= '<lastName xmlns="">' . $LastName . '</lastName>';
		$XMLRequest .= $Suffix != '' ? '<suffix xmlns="">' . $Suffix . '</suffix>' : '';
		$XMLRequest .= '</name>';
		$XMLRequest .= $DateOfBirth != '' ? '<dateOfBirth xmlns="">' . $DateOfBirth . '</dateOfBirth>' : '';
		$XMLRequest .= '<address xmlns="">';
		$XMLRequest .= '<line1 xmlns="">' . $Line1 . '</line1>';
		$XMLRequest .= $Line2 != '' ? '<line2 xmlns="">' . $Line2 . '</line2>' : '';
		$XMLRequest .= '<city xmlns="">' . $City . '</city>';
		$XMLRequest .= $State != '' ? '<state xmlns="">' . $State . '</state>' : '';
		$XMLRequest .= $PostalCode != '' ? '<postalCode xmlns="">' . $PostalCode . '</postalCode>' : '';
		$XMLRequest .= '<countryCode xmlns="">' . $CountryCode . '</countryCode>';
		$XMLRequest .= '</address>';
		$XMLRequest .= '<contactPhoneNumber xmlns="">' . $ContactPhoneNumber . '</contactPhoneNumber>';
		$XMLRequest .= '<currencyCode xmlns="">' . $CurrencyCode . '</currencyCode>';
		$XMLRequest .= '<citizenshipCountryCode xmlns="">' . $CitizenshipCountryCode . '</citizenshipCountryCode>';
		$XMLRequest .= '<preferredLanguageCode xmlns="">' . $PreferredLanguageCode . '</preferredLanguageCode>';
		$XMLRequest .= $NotificationURL != '' ? '<notificationURL xmlns="">' . $NotificationURL . '</notificationURL>' : '';
		$XMLRequest .= $PartnerField1 != '' ? '<partnerField1 xmlns="">' . $PartnerField1 . '</partnerField1>' : '';
		$XMLRequest .= $PartnerField2 != '' ? '<partnerField2 xmlns="">' . $PartnerField2 . '</partnerField2>' : '';
		$XMLRequest .= $PartnerField3 != '' ? '<partnerField3 xmlns="">' . $PartnerField3 . '</partnerField3>' : '';
		$XMLRequest .= $PartnerField4 != '' ? '<partnerField4 xmlns="">' . $PartnerField4 . '</partnerField4>' : '';
		$XMLRequest .= $PartnerField5 != '' ? '<partnerField5 xmlns="">' . $PartnerField5 . '</partnerField5>' : '';
		$XMLRequest .= '<registrationType xmlns="">' . $RegistrationType . '</registrationType>';
		$XMLRequest .= '<createAccountWebOptions xmlns="">';
		$XMLRequest .= '<returnUrl xmlns="">' . $ReturnURL . '</returnUrl>';
		$XMLRequest .= '</createAccountWebOptions>';
		$XMLRequest .= '</CreateAccountRequest>';
				
		// Call the API and load XML response into DOM
		$XMLResponse = $this -> CURLRequest($XMLRequest, 'AdaptiveAccounts', 'CreateAccount');
		$DOM = new DOMDocument();
		$DOM -> loadXML($XMLResponse);
		
		// Parse XML values
		$Fault = $DOM -> getElementsByTagName('FaultMessage') -> length > 0 ? true : false;
		$Errors = $this -> GetErrors($XMLResponse);
		$Ack = $DOM -> getElementsByTagName('ack') -> length > 0 ? $DOM -> getElementsByTagName('ack') -> item(0) -> nodeValue : '';
		$Build = $DOM -> getElementsByTagName('build') -> length > 0 ? $DOM -> getElementsByTagName('build') -> item(0) -> nodeValue : '';
		$CorrelationID = $DOM -> getElementsByTagName('correlationId') -> length > 0 ? $DOM -> getElementsByTagName('correlationId') -> item(0) -> nodeValue : '';
		$Timestamp = $DOM -> getElementsByTagName('timestamp') -> length > 0 ? $DOM -> getElementsByTagName('timestamp') -> item(0) -> nodeValue : '';
		
		$CreateAccountKey = $DOM -> getElementsByTagName('createAccountKey') -> length > 0 ? $DOM -> getElementsByTagName('createAccountKey') -> item(0) -> nodeValue : '';
		$ExecStatus = $DOM -> getElementsByTagName('execStatus') -> length > 0 ? $DOM -> getElementsByTagName('execStatus') -> item(0) -> nodeValue : '';
		$RedirectURL = $DOM -> getElementsByTagName('redirectURL') -> length > 0 ? $DOM -> getElementsByTagName('redirectURL') -> item(0) -> nodeValue : '';
		
		$ResponseDataArray = array(
								   'Errors' => $Errors, 
								   'Ack' => $Ack, 
								   'Build' => $Build, 
								   'CorrelationID' => $CorrelationID, 
								   'Timestamp' => $Timestamp, 
								   'CreateAccountKey' => $CreateAccountKey, 
								   'ExecStatus' => $ExecStatus, 
								   'RedirectURL' => $RedirectURL, 
								   'XMLRequest' => $XMLRequest, 
								   'XMLResponse' => $XMLResponse
								   );
		
		return $ResponseDataArray;
	}
}

/* End of file Paypal_pro.php */
/* Location: ./system/application/libraries/Paypal_pro.php */