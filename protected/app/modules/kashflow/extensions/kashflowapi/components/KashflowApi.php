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
		'AccountOverview' => 'KashflowAccountOverview',
		'AgedDebtorsCreditors' => 'KashflowAgedDebtorsCreditors',
		'BalanceSheet' => 'KashflowBalanceSheet',
		'BankAccount' => 'KashflowBankAccount',
		'BankOverview' => 'KashflowBankOverview',
		'BankTransaction' => 'KashflowBankTransaction',
		'BankTXType' => 'KashflowBankTXType',
		'BasicDataset' => 'KashflowBasicDataset',
		'Currencies' => 'KashflowCurrencies',
		'Customer' => 'KashflowCustomer',
		'CustomerBalance' => 'KashflowCustomerBalance',
		'Invoice' => 'KashflowInvoice',
		'InvoiceLine' => 'KashflowInvoiceLine',
		'InvoiceNote' => 'KashflowInvoiceNote',
		'JournalEntry' => 'KashflowJournalEntry',
		'JournalLine' => 'KashflowJournalLine',
		'MonthlyPL' => 'KashflowMonthlyPL',
		'NominalCode' => 'KashflowNominalCode',
		'NominalCodeExtended' => 'KashflowNominalCodeExtended',
		'Payment' => 'KashflowPayment',
		'PaymentMethod' => 'KashflowPaymentMethod',
		'Product' => 'KashflowProduct',
		'ProfitAndLoss' => 'KashflowProfitAndLoss',
		'Project' => 'KashflowProject',
		'ReceiptAttachment' => 'KashflowReceiptAttachment',
		'SubProduct' => 'KashflowSubProduct',
		'Supplier' => 'KashflowSupplier',
		'TransactionInformation' => 'KashflowTransactionInformation',
		'VATReport' => 'KashflowVATReport',
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

	/**
	 * This method returns an object of type Supplier containing details of the supplier specified by the Supplier ID.
	 * This is an alternative to the GetSupplier method which returns a supplier based on their code.
	 * @param int $SupplierID The unique Supplier id
	 * @return KashflowSupplier An object of type Supplier
	 */
	public function GetSupplierById($SupplierID) {
		return $this->request('GetSupplierById', array(
					'SupplierID' => $SupplierID,
				))->GetSupplierByIdResult->Supplier;
	}

	/**
	 * This method lets you create a new Supplier.
	 * If the operation is successful then you are returned an integer containing the newly generated ID number for the supplier.
	 * @param KashflowSuppleir $Supplier An object of type Supplier
	 */
	public function InsertSupplier($Supplier) {
		$this->request('InsertSupplier', array('Supplier' => $Supplier));
	}

	/**
	 * This method lets you update an existing Supplier.
	 * @param KashflowSuppleir $Supplier An object of type Supplier
	 */
	public function UpdateSupplier($Supplier) {
		$this->request('UpdateSupplier', array('Supplier' => $Supplier));
	}

	/**
	 * This method returns a VAT number for the specified supplier.
	 * @param string $SupplierCode The unique supplier code.
	 * @return string SupVATNumber A VAT number
	 */
	public function GetSupplierVATNumber($SupplierCode) {
		return $this->request('GetSupplierVATNumber', array(
					'SupplierCode' => $SupplierCode,
				))->GetSupplierVATNumberResult;
	}

	/**
	 * This method takes a supplier code and a VAT number and updates the VAT number for the specified supplier.
	 * @param string $SupVATNumber A VAT number
	 * @param string $SupplierCode The unique supplier code.
	 */
	public function SetSupplierVATNumber($SupVATNumber, $SupplierCode) {
		$this->request('SetSupplierVATNumber', array(
			'SupVATNumber' => $SupVATNumber,
			'SupplierCode' => $SupplierCode,
		));
	}

	/**
	 * This method returns the currency code for the specified supplier.
	 * @param string $SupplierCode The unique supplier code.
	 * @return string SuppCurrencyCode A currency code e.g. GBP, USD , ZAR
	 */
	public function GetSupplierCurrency($SupplierCode) {
		return $this->request('GetSupplierCurrency', array(
					'SupplierCode' => $SupplierCode,
				))->GetSupplierCurrencyResult;
	}

	/**
	 * This method takes a currency code and a supplier code and updates the default currency for the supplier specified. The currency code should have already been setup in your account.
	 * @param string $CurrencyCode The ISO code of a currency. E.g. USD, GBP
	 * @param string $SupplierCode The unique supplier code.
	 */
	public function SetSupplierCurrency($CurrencyCode, $SupplierCode) {
		$this->request('SetSupplierVATNumber', array(
			'CurrencyCode' => $CurrencyCode,
			'SupplierCode' => $SupplierCode,
		));
	}

	/**
	 * This method returns an object of type Receipt containing details of the Receipt number requested.
	 * @param int $ReceiptNumber The unique receipt number
	 * @return KashflowInvoice An object of type Invoice
	 */
	public function GetReceipt($ReceiptNumber) {
		return $this->request('GetReceipt', array(
					'ReceiptNumber' => $ReceiptNumber,
				))->GetReceiptsResult->Invoice;
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

	/**
	 * The method returns an array of type Invoice containing details of the most recent NumberOfReceipts receipts (based on receipt date)
	 * @param int $NumberOfReceipts The number of receipts you'd like returned
	 * @return array An array of type Invoice
	 */
	public function GetReceipts_Recent($NumberOfReceipts) {
		$response = $this->request('GetReceipts_Recent', array(
					'NumberOfReceipts' => $NumberOfReceipts,
				))->GetReceipts_RecentResult;
		if (property_exists($response, 'Invoice')) {
			if (is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * The method returns an array of type Invoice containing details of all Receipts for the specified supplier.
	 * @param int $SupplierID The unique supplier id
	 * @return KashflowInvoice An array of type Invoice
	 */
	public function GetReceiptsForSupplier($SupplierID) {
		return $this->request('GetReceiptsForSupplier', array(
					'SupplierID' => $SupplierID,
				))->GetReceiptsForSupplierResult->Invoice;
	}

	/**
	 * This method will create an receipt (purchase invoice) and return the new receipt number.
	 * The new receipt number is automatically created by incrementing the users current highest receipt number by one.
	 * @param KashflowInvoice $Invoice An object of type Invoice
	 * @return int $ReceiptNumber An Integer representing the new, unique receipt number
	 */
	public function InsertReceipt($Invoice) {
		return $this->request('InsertReceipt', array(
					'Invoice' => $Invoice,
				))->InsertReceiptResult;
	}

	/**
	 * This method allows you to modify the details of an existing receipt.
	 * The receipt to be updated is identified by  its receipt number.
	 * @param KashflowInvoice $Receipt An object of type Invoice
	 */
	public function UpdateReceipt($Receipt) {
		$this->request('UpdateReceipt', array(
			'Receipt' => $Receipt,
		));
	}

	/**
	 * This method allows you to modify the header details of an existing receipt.
	 * The receipt to be updated is identified by its receipt id.
	 * @param KashflowInvoice $Invoice An object of type Invoice
	 */
	public function UpdateReceiptHeader($Invoice) {
		$this->request('UpdateReceiptHeader', array(
			'Invoice' => $Invoice,
		));
	}

	/**
	 * This method allows you to delete a recepit (purchase invoice)
	 * @param int $ReceiptNumber An integer representing the receipt number you want to delete
	 */
	public function DeleteReceipt($ReceiptNumber) {
		$this->request('DeleteReceipt', array(
			'ReceiptNumber' => $ReceiptNumber,
		));
	}

	/**
	 * This method allows you to delete a recepit (purchase invoice)
	 * @param int $ReceiptID An integer representing the receipt id you want to delete
	 */
	public function DeleteReceiptByID($ReceiptID) {
		$this->request('DeleteReceiptByID', array(
			'ReceiptID' => $ReceiptID,
		));
	}

	/**
	 * This method will create an new receipt line.
	 * @param int $ReceiptID The receipt id for the receipt you're adding line(s) to
	 * @param KashflowInvoiceLine $RceiptLine An object of type InvoiceLine
	 */
	public function InsertReceiptLine($ReceiptID, $RceiptLine) {
		$this->request('InsertReceiptLine', array(
			'ReceiptID' => $ReceiptID,
			'RceiptLine' => $RceiptLine,
		));
	}

	/**
	 * This method will create an new receipt line.
	 * @param int $ReceiptNumber The receipt number for the receipt you're adding line(s) to
	 * @param KashflowInvoiceLine $RceiptLine An object of type InvoiceLine
	 */
	public function InsertReceiptLineFromNumber($ReceiptNumber, $RceiptLine) {
		$this->request('InsertReceiptLineFromNumber', array(
			'ReceiptNumber' => $ReceiptNumber,
			'RceiptLine' => $RceiptLine,
		));
	}

	/**
	 * This method allows you to delete an receipt line
	 * @param int $LineID An integer representing the receipt line id you want to delete
	 * @param int $ReceiptNumber An integer representing the receipt number you want to delete
	 */
	public function DeleteReceiptLine($LineID, $ReceiptNumber) {
		$this->request('DeleteReceiptLine', array(
			'LineID' => $LineID,
			'ReceiptNumber' => $ReceiptNumber,
		));
	}

	/**
	 * This method allows you to delete an receipt line
	 * @param int $LineID An integer representing the receipt line id you want to delete
	 * @param int $ReceiptID An integer representing the receipt id you want to delete
	 */
	public function DeleteReceiptLineWithReceiptID($LineID, $ReceiptID) {
		$this->request('DeleteReceiptLineWithReceiptID', array(
			'LineID' => $LineID,
			'ReceiptID' => $ReceiptID,
		));
	}

	/**
	 * This method will attach a file to an existing receipt (purchase invoice) for the specified receipt number .
	 * @param int $ReceiptNo An integer value representing the receipt no.
	 * @param string $Base64String A base64 encoded string of the file to be attached.
	 * @param string $ContentType The content type of the file to be attached.e.g. "plain/text"
	 * @param string $Filename The name and extension of the file to be attached.
	 * @param string $FileExtension The extension of the file to be attached.e.g. "txt" or "pdf"
	 * @param string $FileSize The size of the file.e.g. "510"
	 */
	public function AttachFileToReceipt($ReceiptNo, $Base64String, $ContentType, $Filename, $FileExtension, $FileSize) {
		$this->request('AttachFileToReceipt', array(
			'ReceiptNo' => $ReceiptNo,
			'Base64String' => $Base64String,
			'ContentType' => $ContentType,
			'Filename' => $Filename,
			'FileExtension' => $FileExtension,
			'FileSize' => $FileSize,
		));
	}

	/**
	 * This method returns  an array of tpye ReceiptAttachments containing a list of attachments for the receipt id specified.
	 * @param int $ReceiptID An integer value representing the receipt id.
	 * @return KashflowReceiptAttachment An array of objects of type ReceiptAttachment
	 */
	public function GetReceiptAttachments($ReceiptID) {
		return $this->request('GetReceiptAttachments', array(
					'ReceiptID' => $ReceiptID,
				))->GetReceiptAttachmentsResult->ReceiptAttachment;
	}

	/**
	 * This method deletes a receipt attachment for the receipt id and attachment id specified.
	 * @param int $ReceiptID An integer value representing the receipt id.
	 * @param int $AttachmentID An integer value representing the attachment id.
	 */
	public function DeleteReceiptAttachment($ReceiptID, $AttachmentID) {
		$this->request('DeleteReceiptAttachment', array(
			'ReceiptID' => $ReceiptID,
			'AttachmentID' => $AttachmentID,
		));
	}

	/**
	 * This method returns an array of all payments made to the receipt number you specify
	 * @param int $ReceiptNumber The unique receipt number for which you wish to retrieve payments
	 * @return KashflowPayment An array of objects of type Payment 
	 */
	public function GetReceiptPayment($ReceiptNumber) {
		return $this->request('GetReceiptPayment', array(
					'ReceiptNumber' => $ReceiptNumber,
				))->GetReceiptPaymentResult->Payment;
	}

	/**
	 * This method returns all of the users Payment Methods.
	 * @return ReceiptPaymentMethod An array of objects of type PaymentMethod
	 */
	public function GetRecPayMethods() {
		return $this->request('GetRecPayMethods')->GetRecPayMethodsResult;
	}

	/**
	 * This method allows  you to add a payment to a receipt
	 * @param KashflowPayment $Payment An object of type Payment 
	 * @return int An integer representing the new payment number 
	 */
	public function InsertReceiptPayment($Payment) {
		return $this->request('InsertReceiptPayment', array(
					'Payment' => $Payment,
				))->InsertReceiptPaymentResult;
	}

	/**
	 * This method allows  you to delete a payment from a receipt
	 * @param int $PaymentNumber An integer representing the  payment number you want to delete
	 */
	public function DeleteReceiptPayment($PaymentNumber) {
		$this->request('DeleteReceiptPayment', array(
			'PaymentNumber' => $PaymentNumber,
		));
	}

	/**
	 * This method allows you to allocate and advance payment to a receipt
	 * @param int $ReceiptNumber The receipt number to apply the advance payment to.
	 * @param int $BankTxId The bank transaction id of the advance payment.
	 */
	public function AllocateAdvancePaymentToReceipt($ReceiptNumber, $BankTxId) {
		$this->request('AllocateAdvancePaymentToReceipt', array(
			'ReceiptNumber' => $ReceiptNumber,
			'BankTxId' => $BankTxId,
		));
	}

	/**
	 * This method will create a new bank account.
	 * @param string $AccountName 
	 * @param int $NominalCode 
	 */
	public function CreateBankAccount($AccountName, $NominalCode) {
		$this->request('CreateBankAccount', array(
			'AccountName' => $AccountName,
			'NominalCode' => $NominalCode,
		));
	}

	/**
	 * This method returns  all bank accounts that the user has set up.
	 * @return KashflowBankAccount An array of objects of type BankAccount
	 */
	public function GetBankAccounts() {
		return $this->request('GetBankAccounts')->GetBankAccountsResult->BankAccount;
	}

	/**
	 * This method returns all of the users Bank Transaction Types.
	 * @return KashflowBankTXType $BankTXTypes[] An array of objects of type BankTXType
	 */
	public function GetBankTxTypes() {
		return $this->request('GetBankTxTypes')->GetBankTxTypesResult->BankTXType;
	}

	/**
	 * The method allows you to get the bank balanace for the specified date.
	 * @param int $AccountID An integer representing the unique bank account id
	 * @param DateTime $BalanceDate  
	 */
	public function GetBankBalance($AccountID, $BalanceDate) {
		$this->request('GetBankBalance', array(
			'AccountID' => $AccountID,
			'BalanceDate' => $BalanceDate,
		));
	}

	/**
	 * The method returns an array of type BankTransaction containing details of all transactions for the specfied bank account.
	 * @param int $AccountID The unique bank account id
	 * @return KashflowBankTransaction An array of type BankTransaction
	 */
	public function GetBankTransactions($AccountID) {
		return $this->request('GetBankTransactions', array(
					'AccountID' => $AccountID,
				))->GetBankTransactionsResult->BankTransaction;
	}

	/**
	 * This method will create a new bank transaction and return the ID number of the new transaction
	 * @param KashflowInvoice $BankTransaction An object of type BankTransaction
	 * @return int An Integer representing the new, system-wide unique tx number
	 */
	public function InsertBankTransaction($BankTransaction) {
		return $this->request('InsertBankTransaction', array(
					'BankTransaction' => $BankTransaction,
				))->InsertBankTransactionResult;
	}

	/**
	 * This method allows you to modify the details of an bank transaction
	 * @param KashflowBankTransaction $BankTransaction An object of type BankTransaction
	 */
	public function UpdateBankTransaction($BankTransaction) {
		$this->request('UpdateBankTransaction', array(
			'BankTransaction' => $BankTransaction,
		));
	}

	/**
	 * The method allows you to delete a bank transaction.
	 * @param int $TransactionID An integer representing the unique transaction id
	 */
	public function DeleteBankTransaction($TransactionID) {
		$this->request('DeleteBankTransaction', array(
			'TransactionID' => $TransactionID,
		));
	}

	/**
	 * This method will create a journal entry and return the new journal entry number.
	 * The new journal entry number is automatically created by incrementing the users current highest journal entry number by one.
	 * A copy of a valid request can be found here.
	 * @param KashflowJournalEntry $JournalEntry An object of type JournalEntry
	 * @return int $JournalEntryNumber An Integer representing the new, unique journal entry number
	 */
	public function InsertJournal($JournalEntry) {
		return $this->request('InsertJournal', array(
					'JournalEntry' => $JournalEntry,
				))->InsertJournalResult;
	}

	/**
	 * The method returns an object of type JournalEntry containing details of the specified journal entry.
	 * @param int $JournalNumber An integer representing the journal number
	 * @return KashflowJournalEntry An object of type JournalEntry
	 */
	public function GetJournal($JournalNumber) {
		return $this->request('GetJournal', array(
					'JournalNumber' => $JournalNumber,
				))->GetJournalResult->JournalEntry;
	}

	/**
	 * The method returns an array of type JournalEntry containing details of all Journal Entries.
	 * @return KashflowJournalEntry An array of type JournalEntry
	 */
	public function GetJournals() {
		return $this->request('GetJournals')->GetJournalsResult->JournalEntry;
	}

	/**
	 * The method allows you to delete a journal entry.
	 * @param int $JournalNumber An integer representing the journal number
	 */
	public function DeleteJournal($JournalNumber) {
		$this->request('DeleteJournal', array(
			'JournalNumber' => $JournalNumber,
		));
	}

	/**
	 * The method allows you to delete a journal entry.
	 * @param int $JournalID An integer representing the journal id
	 */
	public function DeleteJournalByID($JournalID) {
		$this->request('DeleteJournalByID', array(
			'JournalID' => $JournalID,
		));
	}

	/**
	 * This method allows you to modify the details of an existing journal.
	 * The journal to be updated is identified by the journal id.
	 * NB: The existing journal lines are deleted and replace by the journal lines passed with the Journal object
	 * @param KashflowJournalEntry $JournalEntry An object of type JournalEntry
	 */
	public function UpdateJournal($JournalEntry) {
		$this->request('UpdateJournal', array(
			'JournalEntry' => $JournalEntry,
		));
	}

	/**
	 * This method allows you to modify the header details of an existing journal.
	 * The journal to be updated is identified by the journal id.
	 * @param KashflowJournalEntry $JournalEntry An object of type JournalEntry
	 */
	public function UpdateJournalHeader($JournalEntry) {
		$this->request('UpdateJournalHeader', array(
			'JournalEntry' => $JournalEntry,
		));
	}

	/**
	 * This method will return an array item of AgedDebtorsCreditors containing aged debtors.
	 * @param DateTime $AgedDebtorsDate The date you'd like to use for the AgedDebtors report
	 */
	public function GetAgedDebtors($AgedDebtorsDate) {
		$this->request('GetAgedDebtors', array(
			'AgedDebtorsDate' => $AgedDebtorsDate,
		));
	}

	/**
	 * This method will return an array item of AgedDebtorsCreditors containing aged creditors.
	 * @param DateTime $AgedCreditorsDate The date you'd like to use for the AgedCreditors report
	 */
	public function GetAgedCreditors($AgedCreditorsDate) {
		$this->request('GetAgedCreditors', array(
			'AgedCreditorsDate' => $AgedCreditorsDate,
		));
	}

	/**
	 * This method returns  a Balance Sheet for the specified date.
	 * @param DateTime $Date The start date for the report
	 * @return KashflowBalanceSheet An object of type BalanceSheet
	 */
	public function GetBalanceSheet($Date) {
		return $this->request('GetBalanceSheet', array(
					'Date' => $Date,
				))->GetBalanceSheetResult->BalanceSheet;
	}

	/**
	 * This method returns a string containg the contents of a CSV file that can be imported in to the Digita range of products. The file will contain all transactions within the specified date range
	 * @param DateTime $StartDate The start date for the report
	 * @param DateTime $EndDate The end date for the report
	 * @return string An string containing the data for the CSV file.
	 */
	public function GetDigitaCSVFile($StartDate, $EndDate) {
		return $this->request('GetDigitaCSVFile', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
				))->GetDigitaCSVFileResult;
	}

	/**
	 * This method returns  an array of of type BasicDataset containing the id number and name of all sources of customers. The integer matches the integer contained in the Source element of the Customer class
	 * @param DateTime $StartDate The start date for the report
	 * @param DateTime $EndDate The end date for the report
	 * @param Boolean $BasedOnInvoiceDate If set to True then the report will be based on invoice dates, as opposed to payment dates
	 * @return KashflowBasicDataset An array of objects of type BasicDataset.
	 * The ID field contains the customer id. Name is the customer name, Description is the customer code, Value is the income from this customer in the period specified
	 */
	public function GetIncomeByCustomer($StartDate, $EndDate, $BasedOnInvoiceDate) {
		return $this->request('GetIncomeByCustomer', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
					'BasedOnInvoiceDate' => $BasedOnInvoiceDate,
				))->GetIncomeByCustomerResult->BasicDataset;
	}

	/**
	 * This method returns  an array of of type BasicDataset containing a number of KPIs (Key Performance Indicators)
	 * @param DateTime $StartDate The start date for the report
	 * @param DateTime $EndDate The end date for the report
	 * @param int $ExcludeVAT If set to 1 then VAT will not be included in financial values
	 * @param int $ExcludeSameDayPays If set to 1 then invoices and receipts paid on the day of issue will not be included in calculations of how long it takes for invoices and receipts to be paid.
	 * @return KashflowBasicDataset An array of objects of type BasicDataset.
	 * The ID field contains the customer id. Name is the customer name, Description is the customer code, Value is the income from this customer in the period specified
	 */
	public function GetKPIs($StartDate, $EndDate, $ExcludeVAT, $ExcludeSameDayPays) {
		return $this->request('GetKPIs', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
					'ExcludeVAT' => $ExcludeVAT,
					'ExcludeSameDayPays' => $ExcludeSameDayPays,
				))->GetKPIsResult->BasicDataset;
	}

	/**
	 * This method returns a monthly Profit and Loss report array for the specified period.
	 * @param DateTime $StartDate The start date for the report
	 * @param DateTime $EndDate The end date for the report
	 * @return MonthlyProfitAndLoss An array of type ProfitAndLoss
	 */
	public function GetMonthlyProfitAndLoss($StartDate, $EndDate) {
		return $this->request('GetMonthlyProfitAndLoss', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
				))->GetMonthlyProfitAndLossResult;
	}

	/**
	 * This method returns a Nominal Ledger report array for the specified period and nominal.
	 * @param DateTime $StartDate The start date for the report
	 * @param DateTime $EndDate The end date for the report
	 * @param int $NominalID The nominal id for the report
	 * @return KashflowTransactionInformation An array of type TransactionInformation
	 */
	public function GetNominalLedger($StartDate, $EndDate, $NominalID) {
		return $this->request('GetNominalLedger', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
					'NominalID' => $NominalID,
				))->GetNominalLedgerResult->TransactionInformation;
	}

	/**
	 * This method returns  a Profit and Loss report for the specified period.
	 * @param DateTime $StartDate The start date for the report
	 * @param DateTime $EndDate The end date for the report
	 * @return KashflowProfitAndLoss An object of type ProfitAndLoss
	 */
	public function GetProfitAndLoss($StartDate, $EndDate) {
		return $this->request('GetProfitAndLoss', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
				))->GetProfitAndLossResult->ProfitAndLoss;
	}

	/**
	 * This method returns  a Trial Balance report for the specified period.
	 * @param DateTime $StartDate The start date for the report
	 * @param DateTime $EndDate The end date for the report
	 * @return KashflowNominalCode An array of type NominalCode
	 */
	public function GetTrialBalance($StartDate, $EndDate) {
		return $this->request('GetTrialBalance', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
				))->GetTrialBalanceResult->NominalCode;
	}

	/**
	 * This method returns  the figures for a VAT return  for the specified period.
	 * @param DateTime $StartDate The start date for the report
	 * @param DateTime $EndDate The end date for the report
	 * @return KashflowVATReport An object of type VATReport
	 */
	public function GetVATReport($StartDate, $EndDate) {
		return $this->request('GetVATReport', array(
					'StartDate' => $StartDate,
					'EndDate' => $EndDate,
				))->GetVATReportResult->VATReport;
	}

	/**
	 * This method returns  a basic data set of all of the users  projects.
	 * For a more powerful and flexible method, see GetProjects_Full.
	 * @return BasicDataSet An array of objects of type BasicDataSet.
	 * The 'ID' member contains the project ID, the 'Name' member contains the project name and the 'Description' member contains the project number.
	 */
	public function GetProjects() {
		return $this->request('GetProjects')->GetProjectsResult;
	}

	/**
	 * The method returns an array of type Project containing all projects of the selected status.
	 * For a lighter-weight alternative, see GetProjects.
	 * @param int $ProjStatus The method will only return Projects witha matching status
	 * -1   - All Projects
	 * 0 - Complete
	 * 1 - Active
	 * 2 - Archived
	 * @return KashflowProject An array of type Project
	 */
	public function GetProjects_Full($ProjStatus) {
		return $this->request('GetProjects_Full', array(
					'ProjStatus' => $ProjStatus,
				))->GetProjects_FullResult->Project;
	}

	/**
	 * This method allows you to create or update a project.
	 * To create a project leave the ID property of the Project class blank (or 0). To edit a project, set it to the ID of the project you want to edit.
	 * If the number property of the Project class is left blank (or 0) then the next number in sequence will be used.
	 * @param KashflowProject $Project An object of type Project
	 * @return int An Integer representing the new project ID, or the ID of the edited project
	 */
	public function InsertOrUpdateProject($Project) {
		return $this->request('InsertOrUpdateProject', array(
					'Project' => $Project,
				))->InsertOrUpdateProjectResult;
	}

	/**
	 * This method returns an object of type Project containing details of the Project id requested.
	 * @param int $ProjId The unique project id
	 * @return KashflowProject An object of type Project
	 */
	public function GetProjectById($ProjId) {
		return $this->request('GetProjectById', array(
					'ProjId' => $ProjId,
				))->GetProjectByIdResult->Project;
	}

	/**
	 * This method returns an object of type Project containing details of the Project name requested.
	 * @param string $ProjName The project name
	 * @return KashflowProject An object of type Project
	 */
	public function GetProjectByName($ProjName) {
		return $this->request('GetProjectByName', array(
					'ProjName' => $ProjName,
				))->GetProjectByNameResult->Project;
	}

	/**
	 * This method returns an object of type Project containing details of the Project reference requested.
	 * @param string $ProjRef The project reference
	 * @return KashflowProject An object of type Project
	 */
	public function GetProjectByRef($ProjRef) {
		return $this->request('GetProjectByRef', array(
					'ProjRef' => $ProjRef,
				))->GetProjectByRefResult->Project;
	}

	/**
	 * This method allows you to create a new SubProduct.
	 * A SubProduct in the application is either a "product" as a child of a Sales Type, or a "Sub-Outgoing Type" as a child of an Outgoing Type.
	 * @param KashflowSubProduct $sp A SubProduct populated with the relevant fields.
	 * If the id is set to 0, a new SubProduct will be created. If it is non-zero then the selected SubProduct will be updated.
	 * @return int An integer giving the  unique ID number of the updated or newly created  SubProduct
	 */
	public function AddOrUpdateSubProduct($sp) {
		return $this->request('AddOrUpdateSubProduct', array(
					'sp' => $sp,
				))->AddOrUpdateSubProductResult;
	}

	/**
	 * A user can restrict access to the API to a specified list of IP addresses.
	 * Sometimes you may want to access the API via a device that has an IP address that changes regularly (typically a mobile device) and this makes the IP restrictions impractical.
	 * Rather than suggesting users set the API settings to allow access from any IP address you should use this method to automatically add your IP address to the access list.
	 * The user needs to enable "AutoAuth" by going to Settings -> API Settings and clicking the link to edit the IP address list.
	 * They'll be given an AutoAuthKey which you will need to pass to us in the this method in order to add your IP to the authorised list.
	 * You don't need to pass us your IP address. The API will automatically detect the IP address of the host that called this method.
	 * @param string $appName The name of your application. This is used in the comment for the IP listing so the user knows which application added the IP address
	 * @param string $AutoAuthKey This is the AutoAuthKey mentioned above. It should be provided to you by the user. The AutoAuthKey is a hex string in the format: 1234ABCD-1234
	 */
	public function AutoAuthIP($appName, $AutoAuthKey) {
		$this->request('AutoAuthIP', array(
			'appName' => $appName,
			'AutoAuthKey' => $AutoAuthKey,
		));
	}

	/**
	 * Unlike other API methods, this method doesn't require that you authenticate yourself by passing in a username and password.
	 * However, this method is intended to be used mainly by our integration partners. So you do need to provide an AccountCreationKey. If you'd like a key to use to create accounts, please contact us.
	 * If the account was successfully created then you'll receive an ID number. This is our reference for the user account.
	 * If it was unsuccessful for any reason then you'll get a Status of NO and the StatusDetail will explain why (ie, username already in use)
	 * @param string $AccountCreationKey See above
	 * @param string $Username The desired username
	 * @param string $password The password for the new account. Must be at least 5 characters
	 * @param string $memorableword The memorable word for the new account. Must be at least 5 characters
	 * @param string $EmailAddress  The users email address
	 * @param string $CompanyName The users company name
	 * @param string $Addr1 An address for the user
	 * @param string $Addr2  
	 * @param string $Addr3  
	 * @param string $Addr4  
	 * @param string $Postcode The users postcode
	 * @param string $ContactName A contact name for the user. usually their full name.
	 * @param string $Telephone The users telephone number
	 * @param int $VATRegistered Set this to 1 is the user is VAT registered
	 * @param string $VATNumber The users VAT number
	 * @param int $USSettings Set this to 1 if you want the user to have the date in US format and default to $ for the currency
	 * @param string $promocode If you've joined our affiliate scheme, you can provide your promotional code here
	 * @return int If the account was successfully created you'll receive a user id number
	 */
	public function createAccount($AccountCreationKey, $Username, $password, $memorableword, $EmailAddress, $CompanyName, $Addr1, $Addr2, $Addr3, $Addr4, $Postcode, $ContactName, $Telephone, $VATRegistered, $VATNumber, $USSettings, $promocode) {
		return $this->request('createAccount', array(
					'AccountCreationKey' => $AccountCreationKey,
					'Username' => $Username,
					'password' => $password,
					'memorableword' => $memorableword,
					'EmailAddress ' => $EmailAddress,
					'CompanyName' => $CompanyName,
					'Addr1' => $Addr1,
					'Addr2' => $Addr2,
					'Addr3' => $Addr3,
					'Addr4' => $Addr4,
					'Postcode' => $Postcode,
					'ContactName' => $ContactName,
					'Telephone' => $Telephone,
					'VATRegistered' => $VATRegistered,
					'VATNumber' => $VATNumber,
					'USSettings' => $USSettings,
					'promocode' => $promocode,
				))->createAccountResult;
	}

	/**
	 * This method returns a summary of your accounts.
	 * @return KashflowAccountOverview An object of type AccountOverview
	 */
	public function GetAccountOverview() {
		return $this->request('GetAccountOverview')->GetAccountOverviewResult->AccountOverview;
	}

	/**
	 * This method returns an array of bank accounts and their balances.
	 * @return KashflowBankOverview An array of objects of type BankOverview
	 */
	public function GetBankOverview() {
		return $this->request('GetBankOverview')->GetBankOverviewResult->BankOverview;
	}

	/**
	 * This method returns all currencies that have been setup in the users account.
	 * @return KashflowCurrencies An array of objects of type Currencies
	 */
	public function GetCurrencies() {
		return $this->request('GetCurrencies')->GetCurrenciesResult->Currencies;
	}

	/**
	 * Using this method, you can seamlessly log a user in to KashFlow from your own application.
	 * Just provide us with the username and password and we'll give you a link to direct them to.
	 * The link will only work once, and will expire after 120 seconds.
	 * So if you need to log them in again, you'll need to call the function again to get a new URL.
	 * You can append an additional URL to the query string in the returned URL if you want to redirect them to specific page after logging them in
	 * So adding ?r=bank.asp to the URL will take them to the bank page after logging them in.
	 * Note: for this method to work, the user must enable "Remote Login"
	  in Settings -> APi Settings. If this isn't enabled we'll still provide you with a link, but when you redirect them to it they'll be asked to manually log in.
	 * View Client Soap Examples
	 */
	public function GetRemoteLoginURL() {
		$this->request('GetRemoteLoginURL');
	}

	/**
	 * This method returns  all of the users products.
	 * These "Products" are just the subset of NominalCodes that are set up to be accessed within the "Sales" section of the application.
	 * Do not confuse these with SubProducts which you can retrieve with the GetSubProducts method
	 * @return KashflowProduct An array of objects of type Product
	 */
	public function GetProducts() {
		return $this->request('GetProducts')->GetProductsResult->Product;
	}

	/**
	 * This method returns  a list of all nominal codes that the user has on their account.
	 * If you require more detail on each code, you may want to consider the GetNominalsExtended method
	 * @return NominalCodes An array of objects of type NominalCode
	 */
	public function GetNominalCodes() {
		return $this->request('GetNominalCodes')->GetNominalCodesResult;
	}

	/**
	 * This method returns  a list of all nominal codes that the user has on their account.
	 * @return KashflowNominalCodeExtended An array of objects of type NominalCodeExtended
	 */
	public function GetNominalCodesExtended() {
		return $this->request('GetNominalCodesExtended')->GetNominalCodesExtendedResult->NominalCodeExtended;
	}

	/**
	 * This method returns an array of  SubProducts.
	 * A SubProduct in the application is either a "product" as a child of a Sales Type, or a "Sub-Outgoing Type" as a child of an Outgoing Type.
	 * @param int $NominalID The ID of the NominalCode for which you want to retrieve SubProducts.
	 * @return SubProducts An array of type  SubProducts
	 */
	public function GetSubProducts($NominalID) {
		return $this->request('GetSubProducts', array(
					'NominalID' => $NominalID,
				))->GetSubProductsResult;
	}

	/**
	 * This method returns  an array of of type BasicDataset containing a list of all the VAT rates that the user account has set up
	 * @return KashflowBasicDataset An array of objects of type BasicDataset.
	 * The ID field contains the  id of the Rate. this is unlikley to be of any use to you.
	 * Name and Description contain the Rate as it should be presented to a user, ie "17.5%"
	 * Value contains the actual rate as a decimal. ie: 17.5
	 */
	public function GetVATRates() {
		return $this->request('GetVATRates')->GetVATRatesResult->BasicDataset;
	}

	/**
	 * This method allows you to create a new nominal code
	 * @param string $name The name for the new nominal code 
	 * @param int $code The code number for the new nominal code. This must be unique for the user account
	 * @param int $classification Define what type of code this is. Valid properties are:
	 * 1 - Turnover
	 * 2 - Cost of Sale
	 * 3 - Expense
	 * 4 - Fixed Asset
	 * 5 - Current Asset/Liability
	 * 6 - Capital and Reserves
	 * @param int $nomtype Choose where in the system this code should be listed. Valid properties are:
	 * 1 - Sales Type
	 * 2 - Outgoing Type
	 * 3 - Bank Transaction Type
	 */
	public function InsertNominalCode($name, $code, $classification, $nomtype) {
		$this->request('InsertNominalCode', array(
			'name' => $name,
			'code' => $code,
			'classification' => $classification,
			'nomtype' => $nomtype,
		));
	}

	/**
	 * This method takes just the standard arguments and returns a boolean True or False to indicate whether or not VAT is enabled on the account in question.
	 * @return boolean TRUE - VAT Registered, FALSE - Not VAT Registered
	 */
	public function isUserVATRegistered() {
		return $this->request('isUserVATRegistered')->isUserVATRegisteredResult;
	}

	/**
	 * This method returns  an array of of type Customer containing details of all customers contained in the submitted VCF file.
	 * This method doesn't import the customers into the account. It will just return an array of the Customer object which you can present to the user for editing/confirmation.
	 * You can then  send back the individual Customer objects to either InsertCustomer or InsertSupplier.
	 * The VCF file can contain one or many contacts.
	 * @param base64Binary $inStream A Base 64 binary array representing the .vcf file. 
	 * @return KashflowCustomer An array of objects of type Customer
	 */
	public function VCFToCustomerObjects($inStream) {
		return $this->request('VCFToCustomerObjects', array(
					'inStream' => $inStream,
				))->VCFToCustomerObjectsResult->Customer;
	}

	/**
	 * This method returns a SubProducts.
	 * A SubProduct in the application is either a "product" as a child of a Sales Type, or a "Sub-Outgoing Type" as a child of an Outgoing Type.
	 * @param int $ProductID The ID of the sub-product for which you want to retrieve.
	 * @return SubProducts A class of type  SubProducts
	 */
	public function GetSubProductByID($ProductID) {
		return $this->request('GetSubProductByID', array(
					'ProductID' => $ProductID,
				))->GetSubProductByIDResult;
	}

	/**
	 * This method returns a  SubProducts.
	 * A SubProduct in the application is either a "product" as a child of a Sales Type, or a "Sub-Outgoing Type" as a child of an Outgoing Type.
	 * @param string $ProductCode The code of the sub-product for which you want to retrieve.
	 * @return SubProducts A class of type  SubProducts
	 */
	public function GetSubProductByCode($ProductCode) {
		return $this->request('GetSubProductByCode', array(
					'ProductCode' => $ProductCode,
				))->GetSubProductByCodeResult;
	}

}