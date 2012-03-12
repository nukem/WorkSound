<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Adaptive_payments extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		// Show Errors
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		
		// Load helpers
		$this->load->helper('url');
		
		// Load PayPal library
		$this->config->load('paypal');
		
		$config = array(
			'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
			'APIUsername' => $this->config->item('APIUsername'), 	// PayPal API username of the API caller
			'APIPassword' => $this->config->item('APIPassword'), 	// PayPal API password of the API caller
			'APISignature' => $this->config->item('APISignature'), 	// PayPal API signature of the API caller
			'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
			'APIVersion' => $this->config->item('APIVersion'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
			'DeviceID' => $this->config->item('DeviceID'), 
			'ApplicationID' => $this->config->item('ApplicationID'), 
			'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
		);
		 
		$this->load->library('paypal/Paypal_adaptive', $config);	
	}
	
	
	function index()
	{
       
        
		$this->load->view('adaptive_payments_demo');
	}
	
	function Pay()
	{    
		// Prepare request arrays
		$PayRequestFields = array(
								'ActionType' => 'PAY_PRIMARY', 	
                                // Required.  Whether the request pays the receiver or whether the request is set up to create a payment request,
                                // but not fulfill the payment until the ExecutePayment is called. 
                                // Values are:  PAY, CREATE, PAY_PRIMARY
								'CancelURL' => 'http://localhost/paypal/', 							
          // Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
								'CurrencyCode' => 'USD', 							
                                // Required.  3 character currency code.
								'FeesPayer' => 'SENDER', 								
                                // The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
								'IPNNotificationURL' => 'http://www.soundbooka.com.au/version2/booka/successnotification', 					
                                // The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
								'Memo' => '', 									
                                // A note associated with the payment (text, not HTML).  1000 char max
								'Pin' => '', 									
                                // The sener's personal id number, which was specified when the sender signed up for the preapproval
								'PreapprovalKey' => '', 						
                                // The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.  
								'ReturnURL' => 'http://localhost/paypal/', 								
                                // Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
								'ReverseAllParallelPaymentsOnError' => '', 			
                                // Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
								'SenderEmail' => 'nsridevi@enoahisolution.com', 							
                                // Sender's email address.  127 char max.
								'TrackingID' => ''									
                                // Unique ID that you specify to track the payment.  127 char max.
								);                            
                        
                        $ClientDetailsFields = array(
								'CustomerID' => '1', 								
                                // Your ID for the sender  127 char max.
								'CustomerType' => 'Booka', 							
                                // Your ID of the type of customer.  127 char max.
								'GeoLocation' => 'chennai', 							
                                // Sender's geographic location
								'Model' => 'gig payment', 									
                                // A sub-identification of the application.  127 char max.
								'PartnerName' => 'testing'								
                                // Your organization's name or ID
								);                                
								
		$FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');
		
		$Receivers = array();
		$Receiver = array(
						'Amount' => '29.00', 											// Required.  Amount to be paid to the receiver.
						'Email' => 'nsridevi@enoahisolution.com', 												// Receiver's email address. 127 char max.
						'InvoiceID' => '20', 											// The invoice number for the payment.  127 char max.
						'PaymentType' => 'SERVICE', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => 'Booking', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => 'TRUE'												// Whether this receiver is the primary receiver.  Values are:  TRUE, FALSE
						);
		array_push($Receivers,$Receiver);
        
        $Receiver = array(
						'Amount' => '100.00', 											// Required.  Amount to be paid to the receiver.
						'Email' => 'nsride_1329797161_per@gmail.com', 												// Receiver's email address. 127 char max.
						'InvoiceID' => '20', 											// The invoice number for the payment.  127 char max.
						'PaymentType' => 'SERVICE', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => 'Booking', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => 'FALSE'												// Whether this receiver is the primary receiver.  Values are:  TRUE, FALSE
						);
		array_push($Receivers,$Receiver);
        
		
		$SenderIdentifierFields = array(
										'UseCredentials' => ''						// If TRUE, use credentials to identify the sender.  Default is false.
										);
										
		$AccountIdentifierFields = array(
										'Email' => 'nsridevi@enoahisolution.com', 								// Sender's email address.  127 char max.
										'Phone' => array('CountryCode' => '631503', 'PhoneNumber' => '9944028649', 'Extension' => '91')								// Sender's phone number.  Numbers only.
										);
										
		$PayPalRequestData = array(
							'PayRequestFields' => $PayRequestFields, 
							'ClientDetailsFields' => $ClientDetailsFields, 
							'FundingTypes' => $FundingTypes, 
							'Receivers' => $Receivers, 
							'SenderIdentifierFields' => $SenderIdentifierFields, 
							'AccountIdentifierFields' => $AccountIdentifierFields
							);	                          
                               
		$PayPalResult = $this->paypal_adaptive->Pay($PayPalRequestData);
        
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
         
			$this->load->view('paypal_error',$errors);
		}
		else
		{
        echo "success";;
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Pay_chained_demo()
	{
		// Prepare request arrays
		$PayRequestFields = array(
								'ActionType' => 'PAY', 								// Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
								'CancelURL' => site_url('paypal/adaptive_payments/pay_cancel'), 									// Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
								'CurrencyCode' => 'USD', 								// Required.  3 character currency code.
								'FeesPayer' => 'EACHRECEIVER', 									// The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
								'IPNNotificationURL' => '', 						// The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
								'Memo' => '', 										// A note associated with the payment (text, not HTML).  1000 char max
								'Pin' => '', 										// The sener's personal id number, which was specified when the sender signed up for the preapproval
								'PreapprovalKey' => '', 							// The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.  
								'ReturnURL' => site_url('paypal/adaptive_payments/pay_return'), 									// Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
								'ReverseAllParallelPaymentsOnError' => '', 			// Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
								'SenderEmail' => '', 								// Sender's email address.  127 char max.
								'TrackingID' => ''									// Unique ID that you specify to track the payment.  127 char max.
								);
								
		$ClientDetailsFields = array(
								'CustomerID' => '', 								// Your ID for the sender  127 char max.
								'CustomerType' => '', 								// Your ID of the type of customer.  127 char max.
								'GeoLocation' => '', 								// Sender's geographic location
								'Model' => '', 										// A sub-identification of the application.  127 char max.
								'PartnerName' => ''									// Your organization's name or ID
								);
								
		$FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');
		
		$Receivers = array();
		$Receiver = array(
						'Amount' => '100.00', 											// Required.  Amount to be paid to the receiver.
						'Email' => 'agb_b_1296836857_per@angelleye.com', 												// Receiver's email address. 127 char max.
						'InvoiceID' => '123-ABCDEF', 											// The invoice number for the payment.  127 char max.
						'PaymentType' => 'SERVICE', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => '', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => 'true'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
						);
		array_push($Receivers,$Receiver);
		
		$Receiver = array(
						'Amount' => '10.00', 											// Required.  Amount to be paid to the receiver.
						'Email' => 'agbc_1296755893_biz@angelleye.com', 												// Receiver's email address. 127 char max.
						'InvoiceID' => '123-ABCDEF', 											// The invoice number for the payment.  127 char max.
						'PaymentType' => 'SERVICE', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => '', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => 'false'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
						);
		array_push($Receivers,$Receiver);
		
		$Receiver = array(
						'Amount' => '10.00', 											// Required.  Amount to be paid to the receiver.
						'Email' => 'agb_1296755685_biz@angelleye.com', 												// Receiver's email address. 127 char max.
						'InvoiceID' => '123-ABCDEF', 											// The invoice number for the payment.  127 char max.
						'PaymentType' => 'SERVICE', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => '', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => 'false'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
						);
		array_push($Receivers,$Receiver);
		
		$SenderIdentifierFields = array(
										'UseCredentials' => ''						// If TRUE, use credentials to identify the sender.  Default is false.
										);
										
		$AccountIdentifierFields = array(
										'Email' => '', 								// Sender's email address.  127 char max.
										'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')								// Sender's phone number.  Numbers only.
										);
										
		$PayPalRequestData = array(
							'PayRequestFields' => $PayRequestFields, 
							'ClientDetailsFields' => $ClientDetailsFields, 
							'FundingTypes' => $FundingTypes, 
							'Receivers' => $Receivers, 
							'SenderIdentifierFields' => $SenderIdentifierFields, 
							'AccountIdentifierFields' => $AccountIdentifierFields
							);	
							
		$PayPalResult = $this->paypal_adaptive->Pay($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.
			header('Location: '.$PayPalResult['RedirectURL']);
			exit();
		}
	}
	
	
	function Payment_details()
	{
		// Prepare request arrays
		$PaymentDetailsFields = array(
									'PayKey' => '', 							// The pay key that identifies the payment for which you want to retrieve details.  
									'TransactionID' => '', 						// The PayPal transaction ID associated with the payment.  
									'TrackingID' => ''							// The tracking ID that was specified for this payment in the PayRequest message.  127 char max.
									);
									
		$PayPalRequestData = array('PaymentDetailsFields' => $PaymentDetailsFields);
		$PayPalResult = $this->paypal_adaptive->PaymentDetails($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Execute_payment()
	{
		// Prepare request arrays
		$ExecutePaymentFields = array(
									'PayKey' => '', 								// The pay key that identifies the payment to be executed.  This is the key returned in the PayResponse message.
									'FundingPlanID' => '' 							// The ID of the funding plan from which to make this payment.
									);
									
		$PayPalRequestData = array('ExecutePaymentFields' => $ExecutePaymentFields);	
		$PayPalResult = $this->paypal_adaptive->ExecutePayment($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Get_payment_options()
	{
		// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPalResult = $this->paypal_adaptive->GetPaymentOptions($PayKey);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Set_payment_options()
	{
		// Prepare request arrays
		$SPOFields = array(
						'PayKey' => '', 							// Required.  The pay key that identifies the payment for which you want to set payment options.  
						'ShippingAddressID' => '' 					// Sender's shipping address ID.
						);
						
		$DisplayOptions = array(
						'EmailHeaderImageURL' => '', 			// The URL of the image that displays in the header of customer emails.  1,024 char max.  Image dimensions:  43 x 240
						'EmailMarketingImageURL' => '', 		// The URL of the image that displays in the customer emails.  1,024 char max.  Image dimensions:  80 x 530
						'HeaderImageURL' => '', 				// The URL of the image that displays in the header of a payment page.  1,024 char max.  Image dimensions:  750 x 90
						'BusinessName' => ''					// The business name to display.  128 char max.
						);
								
		$InstitutionCustomer = array(
						'CountryCode' => '', 				// Required.  2 char code of the home country of the end user.
						'DisplayName' => '', 				// Required.  The full name of the consumer as known by the institution.  200 char max.
						'InstitutionCustomerEmail' => '', 	// The email address of the consumer.  127 char max.
						'FirstName' => '', 					// Required.  The first name of the consumer.  64 char max.
						'LastName' => '', 					// Required.  The last name of the consumer.  64 char max.
						'InstitutionCustomerID' => '', 		// Required.  The unique ID assigned to the consumer by the institution.  64 char max.
						'InstitutionID' => ''				// Required.  The unique ID assiend to the institution.  64 char max.
						);
								
		$SenderOptions = array(
						'RequireShippingAddressSelection' => '' // Boolean.  If true, require the sender to select a shipping address during the embedded payment flow.  Default is false.
						);
							
		$ReceiverOptions = array(
						'Description' => '', 					// A description you want to associate with the payment.  1000 char max.
						'CustomID' => ''						// An external reference number you want to associate with the payment.  1000 char max.
						);
							
		$InvoiceData = array(
						'TotalTax' => '', 							// Total tax associated with the payment.
						'TotalShipping' => '' 						// Total shipping associated with the payment.
						);
						
		$InvoiceItems = array();
		$InvoiceItem = array(
						'Name' => '', 								// Name of item.
						'Identifier' => '', 						// External reference to item or item ID.
						'Price' => '', 								// Total of line item.
						'ItemPrice' => '',							// Price of an individual item.
						'ItemCount' => ''							// Item QTY
						);
		array_push($InvoiceItems,$InvoiceItem);
		
		$ReceiverIdentifer = array(
						'ReceiverIdentifierEmail' => '', 	// Receiver's email address.  127 char max.
						'PhoneCountryCode' => '', 			// Receiver's telephone number country code.
						'PhoneNumber' => '', 				// Receiver's telephone number.  
						'PhoneExtension' => ''				// Receiver's telephone extension.
						);
		
		$PayPalRequestData = array(
						'SPOFields' => $SPOFields, 
						'DisplayOptions' => $DisplayOptions, 
						'InstitutionCustomer' => $InstitutionCustomer, 
						'SenderOptions' => $SenderOptions, 
						'ReceiverOptions' => $ReceiverOptions, 
						'InvoiceData' => $InvoiceData, 
						'InvoiceItems' => $InvoiceItems, 
						'ReceiverIdentifier' => $ReceiverIdentifier
						);
		
		// Pass data into class for processing with PayPal and load the response array into $PayPalResult
		$PayPalResult = $this->paypal_adaptive->SetPaymentOptions($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.
		}	
	}
	
	
	function Preapproval()
	{
		// Prepare request arrays
		$PreapprovalFields = array(
								   'CancelURL' => '',  								// Required.  URL to send the browser to after the user cancels.
								   'CurrencyCode' => '', 							// Required.  Currency Code.
								   'DateOfMonth' => '', 							// The day of the month on which a monthly payment is to be made.  0 - 31.  Specifying 0 indiciates that payment can be made on any day of the month.
								   'DayOfWeek' => '', 								// The day of the week that a weekly payment should be made.  Allowable values: NO_DAY_SPECIFIED, SUNDAY, MONDAY, TUESDAY, WEDNESDAY, THURSDAY, FRIDAY, SATURDAY
								   'EndingDate' => '', 								// Required.  The last date for which the preapproval is valid.  It cannot be later than one year from the starting date.
								   'IPNNotificationURL' => '', 						// The URL for IPN notifications.
								   'MaxAmountPerPayment' => '', 					// The preapproved maximum amount per payment.  Cannot exceed the preapproved max total amount of all payments.
								   'MaxNumberOfPayments' => '', 					// The preapproved maximum number of payments.  Cannot exceed the preapproved max total number of all payments. 
								   'MaxTotalAmountOfAllPaymentsPerPeriod' => '', 	// The preapproved maximum number of all payments per period.
								   'MaxTotalAmountOfAllPayments' => '', 			// The preapproved maximum total amount of all payments.  Cannot exceed $2,000 USD or the equivalent in other currencies.
								   'Memo' => '', 									// A note about the preapproval.
								   'PaymentPeriod' => '', 							// The pament period.  One of the following:  NO_PERIOD_SPECIFIED, DAILY, WEEKLY, BIWEEKLY, SEMIMONTHLY, MONTHLY, ANNUALLY
								   'PinType' => '', 								// Whether a personal identification number is required.  It is one of the following:  NOT_REQUIRED, REQUIRED
								   'ReturnURL' => '', 								// URL to return the sender to after approving at PayPal.
								   'SenderEmail' => '', 							// Sender's email address.  If not specified, the email address of the sender who logs on to approve is used.
								   'StartingDate' => '' 							// Required.  First date for which the preapproval is valid.  Cannot be before today's date or after the ending date.
								   );
		
		$ClientDetailsFields = array(
									 'CustomerID' => '', 						// Your ID for the sender.
									 'CustomerType' => '', 						// Your ID of the type of customer.
									 'GeoLocation' => '', 						// Sender's geographic location.
									 'Model' => '', 							// A sub-id of the application
									 'PartnerName' => ''						// Your organization's name or ID.
									 );
		
		$PayPalRequestData = array(
							 'PreapprovalFields' => $PreapprovalFields, 
							 'ClientDetailsFields' => $ClientDetailsFields
							 );	
		
		$PayPalResult = $this->paypal_adaptive->Preapproval($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Preapproval_details()
	{
		// Prepare request arrays
		$PreapprovalDetailsFields = array(
										  'GetBillingAddress' => '', 									// Opion to get the billing address in the response.  true or false.  Only available with Advanced permissions levels.
										  'PreapprovalKey' => '' 										// Required.  A preapproval key that identifies the preapproval for which you want to retrieve details.  Returned in the PreapprovalResponse
										  );
		
		$PayPalRequestData = array('PreapprovalDetailsFields' => $PreapprovalDetailsFields);
		$PayPalResult = $this->paypal_adaptive->PreapprovalDetails($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
	
	function Cancel_preapproval()
	{
		// Prepare request arrays
		$CancelPreapprovalFields = array(
										 'PreapprovalKey' => ''										// Required.  Preapproval key that identifies the preapproval to be canceled.
										 );
		
		$PayPalRequestData = array('CancelPreapprovalFields' => $CancelPreapprovalFields);
		$PayPalResult = $this->paypal_adaptive->CancelPreapproval($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Refund()
	{
		// Prepare request arrays
		$RefundFields = array(
							  'CurrencyCode' => '', 											// Required.  Must specify code used for original payment.  You do not need to specify if you use a payKey to refund a completed transaction.
							  'PayKey' => '',  													// Required.  The key used to create the payment that you want to refund.
							  'TransactionID' => '', 											// Required.  The PayPal transaction ID associated with the payment that you want to refund.
							  'TrackingID' => ''												// Required.  The tracking ID associated with the payment that you want to refund.
							  );
		
		$Receivers = array();
		$Receiver = array(
						  'Email' => '',									// A receiver's email address. 
						  'Amount' => '', 									// Amount to be debited to the receiver's account.
						  'Primary' => '', 									// Set to true to indicate a chained payment.  Only one receiver can be a primary receiver.  Omit this field, or set to false for simple and parallel payments.
						  'InvoiceID' => '', 								// The invoice number for the payment.  This field is only used in Pay API operation.
						  'PaymentType' => ''								// The transaction subtype for the payment.  Allowable values are: GOODS, SERVICE
						  );
		
		array_push($Receivers, $Receiver);
		
		$PayPalRequestData = array(
							 'RefundFields' => $RefundFields, 
							 'Receivers' => $Receivers
							 );	
							 
		$PayPalResult = $this->paypal_adaptive->Refund($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}	
	}
	
	
	function Convert_currency()
	{
		// Prepare request arrays
		$BaseAmountList = array();
		$BaseAmountData = array(
								'Code' => 'USD', 						// Currency code.
								'Amount' => '100.00'						// Amount to be converted.
								);
		array_push($BaseAmountList, $BaseAmountData);
		
		$ConvertToCurrencyList = array('BRL', 'AUD', 'CAD');			// Currency Codes
		
		$PayPalRequestData = array(
								'BaseAmountList' => $BaseAmountList, 
								'ConvertToCurrencyList' => $ConvertToCurrencyList
								);	
								
		$PayPalResult = $this->paypal_adaptive->ConvertCurrency($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
			$data = array('PayPalResult'=>$PayPalResult);
			$this->load->view('convert_currency',$data);
		}	
	}
	
	
	function Create_account()
	{
		// Prepare request arrays
		$CreateAccountFields = array(
									 'AccountType' => '',  										// Required.  The type of account to be created.  Personal or Premier
									 'CitizenshipCountryCode' => '',  							// Required.  The code of the country to be associated with the business account.  This field does not apply to personal or premier accounts.
									 'ContactPhoneNumber' => '', 								// Required.  The phone number associated with the new account.
									 'ReturnURL' => '', 										// Required.  URL to redirect the user to after leaving PayPal pages.
									 'CurrencyCode' => '', 										// Required.  Currency code associated with the new account.  
									 'DateOfBirth' => '', 										// Date of birth of the account holder.  YYYY-MM-DDZ format.  For example, 1970-01-01Z
									 'EmailAddress' => '', 										// Required.  Email address.
									 'Saluation' => '', 										// A saluation for the account holder.
									 'FirstName' => '', 										// Required.  First name of the account holder.
									 'MiddleName' => '', 										// Middle name of the account holder.
									 'LastName' => '', 											// Required.  Last name of the account holder.
									 'Suffix' => '',  											// Suffix name for the account holder.
									 'NotificationURL' => '', 									// URL for IPN
									 'PreferredLanguageCode' => '', 							// Required.  The code indicating the language to be associated with the new account.
									 'RegistrationType' => '' 									// Required.  Whether the PayPal user will use a mobile device or the web to complete registration.  This determins whether a key or a URL is returned for the redirect URL.  Allowable values are:  Web
									);
		
		$Address = array(
					   'Line1' => '', 															// Required.  Street address.
					   'Line2' => '', 															// Street address 2.
					   'City' => '', 															// Required.  City
					   'State' => '', 															// State or Province
					   'PostalCode' => '', 														// Postal code
					   'CountryCode' => ''														// Required.  The country code.
					   );
		
		$PartnerFields = array(
							   'Field1' => '', 											// Custom field for use however needed
							   'Field2' => '', 											
							   'Field3' => '', 
							   'Field4' => '', 
							   'Field5' => ''
							   );
		
		$PayPalRequestData = array(
								   'CreateAccountFields' => $CreateAccountFields, 
								   'Address' => $Address, 
								   'PartnerFields' => $PartnerFields
								   );	
								   
		$PayPalResult = $this->paypal_adaptive->CreateAccount($PayPalRequestData);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			$this->load->view('paypal_error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.	
		}
	}
	
}

/* End of file adaptive_payments.php */
/* Location: ./system/application/controllers/paypal/adaptive_payments.php */