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
		if(property_exists($response, 'Customer')){
			if(is_array($response->Customer))
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
	public function DeleteQuote($QuoteNumber){
		$this->request('DeleteQuote', array('QuoteNumber' => $QuoteNumber));
	}
	/**
	 * This method allows you to delete a quote
	 * @param int $QuoteID An integer representing the quote id you want to delete
	 */
    public function DeleteQuoteByID($QuoteID){
		$this->request('DeleteQuoteByID', array('QuoteID' => $QuoteID));
	}
	/**
	 * This method allows you to delete a quote line
	 * @param int $QuoteNumber An integer representing the quote number you want to delete
	 * @param int $LineID An integer representing the quote line id you want to delete
	 */
    public function DeleteQuoteLine($QuoteNumber, $LineID){
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
    public function DeleteQuoteLineWithQuoteID($QuoteID, $LineID){
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
    public function GetQuoteByNumber($QuoteNumber){
		return $this->request('GetQuoteByNumber', array('QuoteNumber' => $QuoteNumber))->GetQuoteByNumberResult;
	}
	/**
	 * This method returns an object of type Invoice containing details of the qouted id requested.
	 * @param int $QuoteID The unique quote number
	 * @return KashflowInvoice
	 */
    public function GetQuoteByID($QuoteID){
		return $this->request('GetQuoteByID', array('QuoteID' => $QuoteID))->GetQuoteByIDResult;
	}
    /**
	 * This method returns an array object of type Invoice.
	 * @return array An array object of type Invoice
	 */
	public function GetQuotes() {
		$response = $this->request('GetQuotes')->GetQuotesResult;
		if(property_exists($response, 'Invoice')){
			if(is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}
	
    public function GetQuotes_Recent(){
	}
    public function GetQuotesForCustomer(){
		
	}
    public function InsertQuote(){
		
	}
    public function InsertQuoteLine(){
		
	}
    public function isStillQuote(){
		
	}
    public function UpdateQuote(){
		
	}
    public function UpdateQuoteHeader(){
		
	}
    public function ConvertQuoteToInvoice(){
		
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
		if(property_exists($response, 'Invoice')){
			if(is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

	/**
	 * This method returns an array object of type Supplier containing details of the suppliers.
	 * @return array An array object of type Supplier
	 */
	public function GetSuppliers() {
		$response = $this->request('GetSuppliers')->GetSuppliersResult;
		if(property_exists($response, 'Supplier')){
			if(is_array($response->Supplier))
				return $response->Supplier;
			else
				return array($response->Supplier);
		} else
			return array();
	}

	/**
	 * The method returns an array of type Invoice containing details of all Receipts.
	 * @return array An array of type Invoice
	 */
	public function GetReceipts() {
		$response = $this->request('GetReceipts')->GetReceiptsResult;
		if(property_exists($response, 'Invoice')){
			if(is_array($response->Invoice))
				return $response->Invoice;
			else
				return array($response->Invoice);
		} else
			return array();
	}

}