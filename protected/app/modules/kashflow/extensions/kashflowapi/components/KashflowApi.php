<?php

Yii::setPathOfAlias('kashflowapi', dirname(dirname(__FILE__)));
Yii::import('kashflowapi.components.*');
Yii::import('kashflowapi.models.*');

class KashflowApi extends CApplicationComponent {

	/**
	 * @var string The url used for connecting to the kashflow service
	 */
	public $url = 'https://securedwebapp.com/api/service.asmx?WSDL';

	/**
	 *
	 * @var string The kashflow account username
	 */
	public $username;

	/**
	 * @var string The kashflow account password
	 */
	public $password;

	/**
	 * @var array The map of Soap objects
	 */
	public $classmap = array(
//		'AccountOverview' => 'KashflowAccountOverview',
//		'AgedDebtorsCreditors' => 'KashflowAgedDebtorsCreditors',
//		'BalanceSheet' => 'KashflowBalanceSheet',
//		'BankAccount' => 'KashflowBankAccount',
//		'BankOverview' => 'KashflowBankOverview',
//		'BankTransaction' => 'KashflowBankTransaction',
//		'BankTXType' => 'KashflowBankTXType',
		'BasicDataset' => 'KashflowBasicDataset',
//		'Currencies' => 'KashflowCurrencies',
		'Customer' => 'KashflowCustomer',
//		'CustomerBalance' => 'KashflowCustomerBalance',
		'Invoice' => 'KashflowInvoice',
//		'InvoiceLine' => 'KashflowInvoiceLine',
//		'InvoiceNote' => 'KashflowInvoiceNote',
//		'JournalEntry' => 'KashflowJournalEntry',
//		'JournalLine' => 'KashflowJournalLine',
//		'MonthlyPL' => 'KashflowMonthlyPL',
//		'NominalCode' => 'KashflowNominalCode',
//		'NominalCodeExtended' => 'KashflowNominalCodeExtended',
//		'Payment' => 'KashflowPayment',
//		'PaymentMethod' => 'KashflowPaymentMethod',
//		'Product' => 'KashflowProduct',
//		'ProfitAndLoss' => 'KashflowProfitAndLoss',
//		'Project' => 'KashflowProject',
//		'ReceiptAttachment' => 'KashflowReceiptAttachment',
//		'SubProduct' => 'KashflowSubProduct',
		'Supplier' => 'KashflowSupplier',
//		'TransactionInformation' => 'KashflowTransactionInformation',
//		'VATReport' => 'KashflowVATReport',
	);
	private $_client;

	/**
	 * Initialises the component
	 */
	public function init() {
		if (!$this->_client)
			$this->_client = new SoapClient($this->url, array(
						'classmap' => $this->classmap,
					));
	}

	/**
	 *
	 * @param string $function The function to call on the request
	 * @param array $parameters The list of parameters required by the function
	 * @return stdClass The repsonse from the request 
	 */
	public function request($function, $parameters=array()) {
		$parameters['UserName'] = $this->username;
		$parameters['Password'] = $this->password;
		return $this->handleResponse($this->_client->$function($parameters));
	}

	/**
	 * This handles the response from the kashflow request to throw errors when needed
	 * @param stdClass $response The response from the kashflow api request
	 * @return stdClass The response from the kashflow api request
	 */
	private function handleResponse($response) {
		if ("NO" == $response->Status)
			throw(new CHttpException(400, $response->StatusDetail));
		return $response;
	}

	/**
	 * This method returns an object of type Customer containing details of the customer specified by the Customer Code
	 * @param string $CustomerCode The unique customer code.
	 * @return KashflowCustomer
	 */
	public function GetCustomer($CustomerCode) {
		return $this->request('GetCustomer', array('CustomerCode' => $CustomerCode))->GetCustomerResult;
	}

	/**
	 * This method returns an object of type Customer containing details of the customer specified by the Customer ID.
	 * This is an alternative to the GetCustomer method which returns a customer based on their code.
	 * @param int $CustomerID
	 * @return KashflowCustomer
	 */
	public function GetCustomerByID($CustomerID) {
		return $this->request('GetCustomerByID', array('CustomerID' => $CustomerID))->GetCustomerByIDResult;
	}

	/**
	 * This method returns an object of type Customer containing details of the customer specified by the Customers email address.
	 * This is an alternative to the GetCustomer method which returns a customer based on their code. It is useful for checking if a customer already exists.
	 * @param int $CustomerEmail
	 * @return KashflowCustomer
	 */
	public function GetCustomerByEmail($CustomerEmail) {
		return $this->request('GetCustomerByEmail', array('CustomerEmail' => $CustomerEmail))->GetCustomerByEmailResult;
	}

	/**
	 * This method returns an array of of type Customer containing details of all customers.
	 * @return array Array of KashflowCustomer objects
	 */
	public function GetCustomers() {
		$response = $this->request('GetCustomers')->GetCustomersResult;
		if (property_exists($response, 'Customer')) {
			if (is_array($response->Customer))
				return $response->Customer;
			else
				return array($response->Customer);
		} else
			return array();
	}

	/**
	 * This method returns an array of of type Customer containing details of all customers that have been modified or created since the specified date.
	 * @param datetime $ModDate
	 * @return array Array of KashflowCustomer objects
	 */
	public function GetCustomersModifiedSince($ModDate) {
		return $this->request('GetCustomersModifiedSince', array('ModifiedSince' => $ModDate))->GetCustomersModifiedSinceResult;
	}

	/**
	 * This method lets you create a new Customer.
	 * If the operation is successful then you are returned an integer containing the newly generated ID number for the customer.
	 * @param array $Customer Array of customer fields for insertion
	 * @return int CustomerID of newly created customer
	 */
	public function InsertCustomer($Customer) {
		return $this->request('InsertCustomer', array('custr' => $Customer))->InsertCustomerResult;
	}

	/**
	 * This method lets you update customer details.
	 * The CustomerID element of the Customer object is used to locate the customer you want to update.
	 * @param array $Customer Array of customer fields for insertion
	 */
	public function UpdateCustomer($Customer) {
		$this->request('UpdateCustomer', array('custr' => $Customer));
	}

	/**
	 * This method deletes the customer specified by the Customer Code.
	 * @param int $CustomerID The unique customer code
	 */
	public function DeleteCustomer($CustomerID) {
		$this->request('DeleteCustomer', array('CustomerID' => $CustomerID));
	}

	/**
	 * This method returns an array of of type BasicDataset containing the id number and name of all sources of customers. The integer matches the integer contained in the Source element of the Customer class
	 * @return array Array of Customer source objects in the BasicDataset format (ID, Name, Description, Value)
	 */
	public function GetCustomerSources() {
		return $this->request('GetCustomerSources')->GetCustomerSourcesResult->BasicDataset;
	}

	/**
	 * This method takes returns a VAT number for the specified customer.
	 * @param string $CustomerCode The unique customer code.
	 * @return string CustVATNumber, A VAT Number.
	 */
	public function GetCustomerVATNumber($CustomerCode) {
		return $this->request('GetCustomerVATNumber', array('CustomerCode' => $CustomerCode))->GetCustomerVATNumberResult;
	}

	/**
	 * This method takes a customer code and a VAT number and updates the VAT number for the specified customer.
	 * @param string $CustVATNumber The VAT number for the customer
	 * @param string CustomerCode The unique customer code.
	 */
	public function SetCustomerVATNumber($CustVATNumber, $CustomerCode) {
		$this->request('SetCustomerVATNumber', array(
			'CustVATNumber' => $CustVATNumber,
			'CustomerCode' => $CustomerCode,
		));
	}

	/**
	 * This method returns the currency code for the specified customer.
	 * @param string $CustomerCode The unique customer code.
	 * @return string CustCurrencyCode A currency code e.g. GBP, USD , ZAR
	 */
	public function GetCustomerCurrency($CustomerCode) {
		return $this->request('GetCustomerCurrency', array('CustomerCode' => $CustomerCode))->GetCustomerCurrencyResult;
	}

	/**
	 * This method takes a currency code and a customer code and updates the default currency for the customer specified. The currency code should have already been setup in your account.
	 * @param string $CurrencyCode The ISO code of a currency. E.g. USD, GBP
	 * @param string $CustomerCode The unique customer code.
	 */
	public function SetCustomerCurrency($CurrencyCode, $CustomerCode) {
		
	}

	/**
	 * 	This method returns an array object of type Customer containing details of the customers matching the postcode specified
	 * @param string $Postcode The postcode to use when searching for customers
	 * @return array Customer objects
	 */
	public function GetCustomersByPostcode($Postcode) {
		return $this->request('GetCustomersByPostcode', array('Postcode' => $Postcode))->GetCustomersByPostcodeResult->Customer;
	}

	/**
	 * This method returns an object of type CustomerBalance containing details of the customers invoice balances.
	 * @param string $CustomerCode The unique code of the customer you want to get a balance for
	 * @return stdClass CustomerBalance (CustomerID, CustomerCode, Value, Balance)
	 */
	public function GetCustomerBalance($CustomerCode) {
		return $this->request('GetCustomerBalance', array('CustomerCode' => $CustomerCode))->GetCustomerBalanceResult;
	}

	/**
	 * This method returns an array object of type Bank Transaction containing details of the customers advance payments.
	 * @param int $CustomerId The id of the customer you want to get advance payments for
	 * @return stdClass An object of type Bank Transaction
	 */
	public function GetCustomerAdvancePayments($CustomerId) {
		return $this->request('GetCustomerAdvancePayments', array('CustomerId' => $CustomerId))->GetCustomerAdvancePaymentsResult;
	}

	/**
	 * This method allows you to delete a quote
	 * @param int $QuoteNumber An integer representing the quote number you want to delete
	 */
	public function DeleteQuote($QuoteNumber) {
		$this->request('DeleteQuote', array('QuoteNumber' => $QuoteNumber));
	}

	/**
	 * This method allows you to delete a quote
	 * @param int $QuoteID An integer representing the quote id you want to delete
	 */
	public function DeleteQuoteByID($QuoteID) {
		$this->request('DeleteQuoteByID', array('QuoteID' => $QuoteID));
	}

	/**
	 * This method allows you to delete a quote line
	 * @param int $QuoteNumber An integer representing the quote number you want to delete
	 * @param int $LineID An integer representing the quote line id you want to delete
	 */
	public function DeleteQuoteLine($QuoteNumber, $LineID) {
		$this->request('DeleteQuoteLine', array(
			'QuoteNumber' => $QuoteNumber,
			'LineID' => $LineID,
		));
	}

	/**
	 * This method allows you to delete a quote line
	 * @param int $QuoteID An integer representing the quote id you want to delete
	 * @param int $LineID An integer representing the quote line id you want to delete
	 */
	public function DeleteQuoteLineWithQuoteID($QuoteID, $LineID) {
		$this->request('DeleteQuoteLineWithQuoteID', array(
			'QuoteID' => $QuoteID,
			'LineID' => $LineID,
		));
	}

	/**
	 * This method returns an object of type Invoice containing details of the qoute number requested.
	 * @param int $QuoteNumber The unique quote number
	 * @return KashflowInvoice
	 */
	public function GetQuoteByNumber($QuoteNumber) {
		return $this->request('GetQuoteByNumber', array('QuoteNumber' => $QuoteNumber))->GetQuoteByNumberResult;
	}

	/**
	 * This method returns an object of type Invoice containing details of the qouted id requested.
	 * @param int $QuoteID The unique quote number
	 * @return KashflowInvoice
	 */
	public function GetQuoteByID($QuoteID) {
		return $this->request('GetQuoteByID', array('QuoteID' => $QuoteID))->GetQuoteByIDResult;
	}

	/**
	 * This method returns an array object of type Invoice.
	 * @return array An array object of type Invoice
	 */
	public function GetQuotes() {
		$response = $this->request('GetQuotes')->GetQuotesResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * The method returns an array of type Invoice containing details of the most recent NumberOfQuotes quotes (based on quote date)
	 * @param int $NumberOfQuotes The number of quotes you'd like returned
	 * @return array An array of type Invoice
	 */
	public function GetQuotes_Recent($NumberOfQuotes) {
		$response = $this->request('GetQuotes_Recent')->GetQuotes_RecentResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * The method returns an array of type Invoice containing details of all quotes assigned to the specified customer.
	 * @param int $CustID The ID of the customer
	 * @return array An array of type Invoice
	 */
	public function GetQuotesForCustomer($CustID) {
		$response = $this->request('GetQuotesForCustomer', array('CustID' => $CustID))->GetQuotesForCustomerResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * This method will create a quote and return the new quote id.
	 * @param KashflowInvoice $Quote An object of type Invoice
	 * @return int QuoteID An Integer representing the new, unique quote id
	 */
	public function InsertQuote($Quote) {
		return $this->request('InsertQuote', array('Quote' => $Quote))->InsertQuoteResult;
	}

	/**
	 * This method will create a new quote line and return the new quote line id.
	 * @param int $QuoteID An integer value representing the quote id
	 * @param KashflowInvoiceLine $QuoteLine An object of type InvoiceLine
	 * @return int QuoteLineID An Integer representing the new, unique quote line ID
	 */
	public function InsertQuoteLine($QuoteID, $QuoteLine) {
		return $this->request('InsertQuoteLine', array(
					'QuoteID' => $QuoteID,
					'QuoteLine' => $QuoteLine,
				))->InsertQuoteLineResult;
	}

	/**
	 * This method takes just the standard arguments and the quote id. It returns a Boolean value of TRUE or FALSE.
	 * @param int $QouteID The unique qoute id
	 * @return boolean Is still a quote
	 */
	public function isStillQuote($QuoteID) {
		return $this->request('isStillQuote', array('QuoteID' => $QuoteID))->isStillQuoteResult;
	}

	/**
	 * This method allows you to modify the details of an existing quote.
	 * The quote to be updated is identified by its quote id.
	 * NB: The existing quote lines are deleted and replace by the quote lines passed with the Quote object
	 * @param KashflowInvoice $Quote An object of type Invoice
	 */
	public function UpdateQuote($Quote) {
		$this->request('UpdateQuote', array('Quote' => $Quote));
	}

	/**
	 * This method allows you to modify the header details of an existing quote.
	 * The quote to be updated is identified by its quote id.
	 * @param KashflowInvoice $Quote An object of type Invoice
	 */
	public function UpdateQuoteHeader($Quote) {
		$this->request('UpdateQuoteHeader', array('Quote' => $Quote));
	}

	/**
	 * The method lets you convert a quote into an invoice.
	 * It returns the newly created invoice as an object of type Invoice.
	 * @param int $QuoteID The ID of the quote you wish to convert
	 * @param int $CustomerID The ID of the customer you want the invoice assigned to. Leave it as 0 and it'll be assigned to the same customer as the quote.
	 * @param int $CopyQuoteReference Set to 1 if you want a line on the invoice saying "Based on Quote Number x"
	 * @param int $deleteQuoteAfterconversion If set to 1 then the quote will be deleted once the invoice has been created
	 * @return KashflowInvoice
	 */
	public function ConvertQuoteToInvoice($QuoteID, $CustomerID=0, $CopyQuoteReference=0, $deleteQuoteAfterconversion=0) {
		return $this->request('ConvertQuoteToInvoice', array(
					'QuoteID' => $QuoteID,
					'CustomerID' => $CustomerID,
					'CopyQuoteReference' => $CopyQuoteReference,
					'deleteQuoteAfterconversion' => $deleteQuoteAfterconversion,
				))->ConvertQuoteToInvoiceResult;
	}

	/**
	 * This method returns an object of type Invoice containing details of the Invoice number requested.
	 * @param int $InvoiceNumber The unique invoice number
	 * @return KashflowInvoice An object of type Invoice
	 */
	public function GetInvoice($InvoiceNumber) {
		return $this->request('GetInvoice', array('InvoiceNumber' => $InvoiceNumber))->GetInvoiceResult->Invoice;
	}

	/**
	 * This method returns an object of type Invoice containing details of the Invoice id requested.
	 * @param int $InvoiceID The unique invoice id
	 * @return KashflowInvoice An object of type Invoice
	 */
	public function GetInvoiceByID($InvoiceID) {
		return $this->request('GetInvoiceByID', array('InvoiceID' => $InvoiceID))->GetInvoiceByIDResult->Invoice;
	}

	/**
	 * This method returns an array object of type Invoice.
	 * @param datetime $StartDate Start date
	 * @param datetime $EndDate End date
	 * @return array An array object of type Invoice
	 */
	public function GetInvoicesByDateRange($StartDate, $EndDate=null) {
		if (!$EndDate)
			$EndDate = date('Y-m-d');
		$response = $this->request('GetInvoicesByDateRange', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
				))->GetInvoicesByDateRangeResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * The method returns an array of type Invoice containing details of all invoices assigned to the specified customer.
	 * @param int $CustID The ID of the customer
	 * @return array KashflowInvoice An array of type Invoice
	 */
	public function GetInvoicesForCustomer($CustID) {
		$response = $this->request('GetInvoicesForCustomer', array(
					'CustID' => $CustID,
				))->GetInvoicesForCustomerResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * The method returns an array of type Invoice containing details of all overdue invoices
	 * @return array KashflowInvoice An array of type Invoice
	 */
	public function GetInvoices_Overdue() {
		$response = $this->request('GetInvoices_Overdue')->GetInvoices_OverdueResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * The method returns an array of type Invoice containing details of the most recent NumberOfInvoices invoices (based on invoice date)
	 * @param int $NumberOfInvoices The number of invoices you'd like returned
	 * @return array KashflowInvoice An array of type Invoice
	 */
	public function GetInvoices_Recent($NumberOfInvoices) {
		$response = $this->request('GetInvoices_Recent', array(
					'NumberOfInvoices' => $NumberOfInvoices,
				))->GetInvoices_RecentResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * The method returns an array of type Invoice containing details of all unpaid invoices.
	 * @return array KashflowInvoice An array of type Invoice
	 */
	public function GetInvoices_Unpaid() {
		$response = $this->request('GetInvoices_Unpaid')->GetInvoices_UnpaidResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * This method will create an invoice and return the new invoice number.
	 * The new invoice number is automatically created by incrementing the customers current highest invoice number by one.
	 * @param KashflowInvoice $Invoice An object of type Invoice
	 * @return int InvoiceNumber An Integer representing the new, unique invoice number
	 */
	public function InsertInvoice($Invoice) {
		return $this->request('InsertInvoice', array(
					'Invoice' => $Invoice,
				))->InsertInvoiceResult;
	}

	/**
	 * This method will create an new invoice line and returns the new invoice line id.
	 * @param int $InvoiceID An Integer representing the unique invoice id
	 * @param KashflowInvoiceLine $InvoiceLine An object of type InvoiceLine
	 * @return int InvoiceLineID An Integer representing the new, unique invoice line ID
	 */
	public function InsertInvoiceLine($InvoiceID, $InvoiceLine) {
		return $this->request('InsertInvoiceLine', array(
					'InvoiceID' => $InvoiceID,
					'InvoiceLine' => $InvoiceLine,
				))->InsertInvoiceLineResult;
	}

	/**
	 * This method will create an new invoice line and returns the new invoice line id.
	 * @param int $InvoiceNumber An Integer representing the invoice number
	 * @param KashflowInvoiceLine $InvoiceLine An object of type InvoiceLine
	 * @return int InvoiceLineID An Integer representing the new, unique invoice line ID
	 */
	public function InsertInvoiceLineWithInvoiceNumber($InvoiceNumber, $InvoiceLine) {
		return $this->request('InsertInvoiceLineWithInvoiceNumber', array(
					'InvoiceNumber' => $InvoiceNumber,
					'InvoiceLine' => $InvoiceLine,
				))->InsertInvoiceLineWithInvoiceNumberResult;
	}

	/**
	 * This method allows you to modify the details of an existing invoice.
	 * The invoice to be updated is identified by its invoice number.
	 * @param KashflowInvoice $Invoice An object of type Invoice
	 */
	public function UpdateInvoice($Invoice) {
		$this->request('UpdateInvoice', array(
			'Invoice' => $Invoice,
		));
	}

	/**
	 * This method allows you to modify the header details of an existing invoice.
	 * The invoice to be updated is identified by its invoice id.
	 * @param KashflowInvoice $Invoice An object of type Invoice
	 */
	public function UpdateInvoiceHeader($Invoice) {
		$this->request('UpdateInvoiceHeader', array(
			'Invoice' => $Invoice,
		));
	}

	/**
	 * This method deletes an invoice specified by the invoice number.
	 * @param int $InvoiceNumber The invoice number
	 */
	public function DeleteInvoice($InvoiceNumber) {
		$this->request('DeleteInvoice', array(
			'InvoiceNumber' => $InvoiceNumber,
		));
	}

	/**
	 * This method deletes an invoice specified by the invoice id.
	 * @param int $InvoiceID The unique invoice id
	 */
	public function DeleteInvoiceByID($InvoiceID) {
		$this->request('DeleteInvoiceByID', array(
			'InvoiceID' => $InvoiceID,
		));
	}

	/**
	 * This method will delete invoice line for the invoice number and invoice line id specified.
	 * @param int $InvoiceLineID An integer representing the invoice line id
	 * @param int $InvoiceNumber An integer representing the invoice number
	 */
	public function DeleteInvoiceLine($InvoiceLineID, $InvoiceNumber) {
		$this->request('DeleteInvoiceLine', array(
			'InvoiceLineID' => $InvoiceLineID,
			'InvoiceNumber' => $InvoiceNumber,
		));
	}

	/**
	 * This method will delete invoice line for the invoice id and invoice line id specified.
	 * @param int $InvoiceLineID An integer representing the invoice line id
	 * @param int $InvoiceID An integer representing the invoice id
	 */
	public function DeleteInvoiceLineWithInvoiceID($InvoiceLineID, $InvoiceID) {
		$this->request('DeleteInvoiceLineWithInvoiceID', array(
			'InvoiceLineID' => $InvoiceLineID,
			'InvoiceID' => $InvoiceID,
		));
	}

	/**
	 * This method allows you to email an invoice. The invoice is sent from our own SMTP servers.
	 * The subject line and body of the email are as per the variables you provide below.
	 * The invoice is attached to the email as a PDF file.
	 * @param int $InvoiceNumber The number of the invoice to be emailed.
	 * @param string $FromEmail The name of the sender
	 * @param string $FromName The email address that the invoice should appear to have been sent from
	 * @param string $SubjectLine The subject line to be used on the email
	 * @param string $Body The body of the email
	 * @param string $RecipientEmail The recipients email address
	 */
	public function EmailInvoice($InvoiceNumber, $FromEmail, $FromName, $SubjectLine, $Body, $RecipientEmail) {
		$this->request('EmailInvoice', array(
			'InvoiceNumber' => $InvoiceNumber,
			'FromEmail' => $FromEmail,
			'FromName' => $FromName,
			'SubjectLine' => $SubjectLine,
			'Body' => $FromEmail,
			'RecipientEmail' => $RecipientEmail,
		));
	}

	/**
	 * This method returns a string containing the address of a PDF file containing your invoice(s).
	 * You can provide an integer if you just want to print one invoice, or a comma separated list of invoice numbers if you want to print more than one invoice.
	 * @param int $InvoiceNumber The invoice number for the invoice you want to print.
	 * If you are instead supplying a string of numbers in the next argument then you should set this to 0
	 * @param string $InvoiceNumberList A comma separated list of invoice numbers.
	 * You can just provide an empty string if you are providing a single invoice number above.
	 * @return string PDF address
	 */
	public function PrintInvoice($InvoiceNumber=0, $InvoiceNumberList='') {
		return $this->request('PrintInvoice', array(
					'InvoiceNumber' => $InvoiceNumber,
					'InvoiceNumberList' => $InvoiceNumberList,
				))->PrintInvoiceResult;
	}

	/**
	 * This method returns a link to a PayPal page for a customer to pay the invoice.
	 * @param int $InvoiceNumber The invoice number
	 * @return string PayPal page link
	 */
	public function GetPaypalLink($InvoiceNumber) {
		return $this->request('GetPaypalLink', array(
					'InvoiceNumber' => $InvoiceNumber,
				))->GetPaypalLinkResult;
	}

	/**
	 * This method will create a note for the invoice id specified.
	 * @param int $InvoiceID The system-wide, unique ID number for the invoice
	 * @param string $Notes The actual note to be added to the invoice
	 * @param string $NoteDate The date of the note
	 * @return boolean InsertInvoiceNoteResult
	 */
	public function InsertInvoiceNotes($InvoiceID, $Notes, $NoteDate=null) {
		if (!$NoteDate)
			$NoteDate = date('Y-m-d');
		return $this->request('InsertInvoiceNotes', array(
					'InvoiceID' => $InvoiceID,
					'Notes' => $Notes,
					'NoteDate' => $NoteDate,
				))->InsertInvoiceNotesResult;
	}

	/**
	 * This method returns an array object of type InvoiceNote containing notes of the Invoice id requested.
	 * @param int $InvoiceID The system-wide, unique ID number for the invoice
	 * @return array An array object of type InvoiceNote
	 */
	public function GetInvoiceNotes($InvoiceID) {
		$response = $this->request('GetInvoiceNotes', array(
					'InvoiceID' => $InvoiceID,
				))->GetInvoiceNotesResult;
		if (property_exists($response, 'InvoiceNote')) {
			if (is_array($response->InvoiceNote))
				return $response->InvoiceNote;
			else
				return array($response->InvoiceNote);
		} else
			return array();
	}

	/**
	 * This method applies a customer credit note to an sales invoice to reduce the amount owed.
	 * @param int $InvoiceID The invoice id to which you wish to apply the credit note
	 * @param int $CreditNoteID The id of the Credit Note (a negative-value invoice) to apply to the invoice
	 * @return boolean True if successful, false if not.
	 */
	public function applyCreditNoteToInvoice($InvoiceID, $CreditNoteID) {
		return $this->request('applyCreditNoteToInvoice', array(
					'InvoiceID' => $InvoiceID,
					'CreditNoteID' => $CreditNoteID,
				))->applyCreditNoteToInvoiceResult;
	}

	/**
	 * This method returns an array of all payments made to the invoice number you specify
	 * @param int $InvoiceNumber The unique invoice number for which you wish to retrieve payments
	 * @return array An array of objects of type Payment
	 */
	public function GetInvoicePayment($InvoiceNumber) {
		$response = $this->request('GetInvoicePayment', array(
					'InvoiceNumber' => $InvoiceNumber,
				))->GetInvoicePaymentResult;
		if (property_exists($response, 'Payment')) {
			if (is_array($response->Payment))
				return $response->Payment;
			else
				return array($response->Payment);
		} else
			return array();
	}

	/**
	 * This method returns all of the users Payment Methods.
	 * @param int $InvoiceNumber The unique invoice number for which you wish to retrieve payments
	 * @return array An array of objects of type PaymentMethod
	 */
	public function GetInvPayMethods() {
		$response = $this->request('GetInvPayMethods')->GetInvPayMethodsResult;
		if (property_exists($response, 'PaymentMethod')) {
			if (is_array($response->PaymentMethod))
				return $response->PaymentMethod;
			else
				return array($response->PaymentMethod);
		} else
			return array();
	}

	/**
	 * This method allows you to add a payment to an invoice
	 * @param KashflowPayment $Payment An object of type Payment
	 * @return int An integer representing the new payment number
	 */
	public function InsertInvoicePayment($Payment) {
		return $this->request('InsertInvoicePayment', array(
					'Payment' => $Payment,
				))->InsertInvoicePaymentResult;
	}

	/**
	 * This method allows you to delete a payment from an Invoice
	 * @param int $PaymentNumber An integer representing the payment number you want to delete
	 * @return int An integer representing the new payment number
	 */
	public function DeleteInvoicePayment($PaymentNumber) {
		$this->request('InsertInvoicePayment', array('PaymentNumber' => $PaymentNumber));
	}

	/**
	 * This method allows you to allocate and advance payment to an invoice.
	 * @param int $InvoiceNumber The invoice number to apply the advance payment to.
	 * @param int $BankTxId The bank transaction id of the advance payment.
	 */
	public function AllocateAdvancePaymentToInvoice($InvoiceNumber, $BankTxId) {
		$this->request('AllocateAdvancePaymentToInvoice', array(
			'InvoiceNumber' => $InvoiceNumber,
			'BankTxId' => $BankTxId,
		));
	}

	/**
	 * This method returns an object of type Supplier containing details of the supplier specified by the Supplier Code
	 * @param int $SupplierCode The unique supplier code
	 * @return KashflowSupplier An object of type Supplier
	 */
	public function GetSupplier($SupplierCode) {
		return $this->request('GetSupplier', array(
					'SupplierCode' => $SupplierCode,
				))->GetSupplierResult->Supplier;
	}

	/**
	 * This method returns an array object of type Supplier containing details of the suppliers.
	 * @return array An array object of type Supplier
	 */
	public function GetSuppliers() {
		$response = $this->request('GetSuppliers')->GetSuppliersResult;
		if (property_exists($response, 'Supplier')) {
			if (is_array($response->Supplier))
				return $response->Supplier;
			else
				return array($response->Supplier);
		} else
			return array();
	}

	public function GetSupplierById() {
		
	}

	public function InsertSupplier() {
		
	}

	public function UpdateSupplier() {
		
	}

	public function GetSupplierVATNumber() {
		
	}

	public function SetSupplierVATNumber() {
		
	}

	public function GetSupplierCurrency() {
		
	}

	public function SetSupplierCurrency() {
		
	}

	public function GetReceipt() {
		
	}

	/**
	 * The method returns an array of type Invoice containing details of all Receipts.
	 * @return array An array of type Invoice
	 */
	public function GetReceipts() {
		$response = $this->request('GetReceipts')->GetReceiptsResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	public function GetReceipts_Recent() {
		
	}

	public function GetReceiptsForSupplier() {
		
	}

	public function InsertReceipt() {
		
	}

	public function UpdateReceipt() {
		
	}

	public function UpdateReceiptHeader() {
		
	}

	public function DeleteReceipt() {
		
	}

	public function DeleteReceiptByID() {
		
	}

	public function InsertReceiptLine() {
		
	}

	public function InsertReceiptLineFromNumber() {
		
	}

	public function DeleteReceiptLine() {
		
	}

	public function DeleteReceiptLineWithReceiptID() {
		
	}

	public function AttachFileToReceipt() {
		
	}

	public function GetReceiptAttachments() {
		
	}

	public function DeleteReceiptAttachment() {
		
	}

	public function GetReceiptPayment() {
		
	}

	public function GetRecPayMethods() {
		
	}

	public function InsertReceiptPayment() {
		
	}

	public function DeleteReceiptPayment() {
		
	}

	public function AllocateAdvancePaymentToReceipt() {
		
	}

	public function CreateBankAccount() {
		
	}

	public function GetBankAccounts() {
		
	}

	public function GetBankTXTypes() {
		
	}

	public function GetBankBalance() {
		
	}

	public function GetBankTransactions() {
		
	}

	public function InsertBankTransaction() {
		
	}

	public function UpdateBankTransaction() {
		
	}

	public function DeleteBankTransaction() {
		
	}

	public function InsertJournal() {
		
	}

	public function GetJournal() {
		
	}

	public function GetJournals() {
		
	}

	public function DeleteJournal() {
		
	}

	public function DeleteJournalByID() {
		
	}

	public function UpdateJournal() {
		
	}

	public function UpdateJournalHeader() {
		
	}

	public function GetAgedDebtors() {
		
	}

	public function GetAgedCreditors() {
		
	}

	public function GetBalanceSheet() {
		
	}

	public function GetDigitaCSVFile() {
		
	}

	public function GetIncomeByCustomer() {
		
	}

	public function GetKPIs() {
		
	}

	public function GetMonthlyProfitAndLoss() {
		
	}

	public function GetNominalLedger() {
		
	}

	public function GetProfitAndLoss() {
		
	}

	public function GetTrialBalance() {
		
	}

	public function GetVATReport() {
		
	}

	public function GetProjects() {
		
	}

	public function GetProjects_Full() {
		
	}

	public function InsertOrUpdateProject() {
		
	}

	public function GetProjectById() {
		
	}

	public function GetProjectByName() {
		
	}

	public function GetProjectByRef() {
		
	}

	public function AddOrUpdateSubProduct() {
		
	}

	public function AutoAuthIP() {
		
	}

	public function createAccount() {
		
	}

	public function GetAccountOverview() {
		
	}

	public function GetBankOverview() {
		
	}

	public function GetCurrencies() {
		
	}

	public function GetRemoteLoginURL() {
		
	}

	public function GetProducts() {
		
	}

	public function GetNominalCodes() {
		
	}

	public function GetNominalCodesExtended() {
		
	}

	public function GetSubProducts() {
		
	}

	public function GetVATRates() {
		
	}

	public function InsertNominalCode() {
		
	}

	public function isUserVATRegistered() {
		
	}

	public function VCFToCustomerObjects() {
		
	}

	public function GetSubProductByID() {
		
	}

	public function GetSubProductByCode() {
		
	}

}