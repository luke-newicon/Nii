<?php

class KashflowCustomer extends KashflowModel {
	/**
	 * @var int The system-wide, unique ID number for this customer
	 */
	public $CustomerID = 0;
	/**
	 * @var string Customer Code 
	 */
	public $Code = "";
	/**
	 * @var string The customers name
	 */
	public $Name = "";
	/**
	 * @var string Contact Name
	 */
	public $Contact = "";
	/**
	 * @var string Telephone number
	 */
	public $Telephone = "";
	/**
	 * @var string Mobile number
	 */
	public $Mobile = "";
	/**
	 * @var string Fax number
	 */
	public $Fax = "";
	/**
	 * @var string Email address
	 */
	public $Email = "";
	/**
	 * @var string Address line 1
	 */
	public $Address1 = "";
	/**
	 * @var string Address line 2
	 */
	public $Address2 = "";
	/**
	 * @var string Address line 3
	 */
	public $Address3 = "";
	/**
	 * @var string Address line 4
	 */
	public $Address4 = "";
	/**
	 * @var string Postcode
	 */
	public $Postcode = "";
	/**
	 * @var string Website
	 */
	public $Website = "";
	/**
	 * @var int Is set to 1 if the customer is based in another EC country
	 */
	public $EC = 0;
	/**
	 * @var int Is set to 1 if the customer is based outside an EC country
	 */
	public $OutsideEC = 0;
	/**
	 * @var string Customer notes
	 */
	public $Notes = "";
	/**
	 * @var int Customer source id
	 */
	public $Source = 0;
	/**
	 * @var float The discount percentage for this customer
	 */
	public $Discount = 0;
	/**
	 * @var boolean Show discount
	 */
	public $ShowDiscount = 0;
	/**
	 * @var string Payment terms
	 */
	public $PaymentTerms = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText1 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText2 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText3 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText4 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText5 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText6 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText7 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText8 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText9 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText10 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText11 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText12 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText13 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText14 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText15 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText16 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText17 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText18 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText19 = "";
	/**
	 * @var string Custom field
	 */
	public $ExtraText20 = "";
	/**
	 * @var int Custom field
	 */
	public $CheckBox1 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox2 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox3 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox4 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox5 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox6 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox7 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox8 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox9 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox10 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox11 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox12 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox13 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox14 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox15 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox16 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox17 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox18 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox19 = 0;
	/**
	 * @var int Custom field
	 */
	public $CheckBox20 = 0;
	/**
	 * @var datetime The date this customer was created
	 */
	public $Created = 0;
	/**
	 * @var datetime The date this customer was updated
	 */
	public $Updated = 0;
	/**
	 * @var int	The default currency id
	 */
	public $CurrencyID = 0;
	/**
	 * @var string Contact name title
	 */
	public $ContactTitle = "";
	/**
	 * @var string Contact first name
	 */
	public $ContactFirstName = "";
	/**
	 * @var string Contact last name
	 */
	public $ContactLastName = "";
	/**
	 * @var int A flag to indicate whether the customer has a delivery address. Set to 1 if delivery address is present.
	 */
	public $CustHasDeliveryAddress = 0;
	/**
	 * @var string Delivery address line 1
	 */
	public $DeliveryAddress1 = "";
	/**
	 * @var string Delivery address line 2
	 */
	public $DeliveryAddress2 = "";
	/**
	 * @var string Delivery address line 3
	 */
	public $DeliveryAddress3 = "";
	/**
	 * @var string Delivery address line 4
	 */
	public $DeliveryAddress4 = "";
	/**
	 * @var string Delivery address postcode
	 */
	public $DeliveryPostcode = "";
	/**
	 * This method returns an object of type Customer containing details of the customer specified by the Customer Code
	 * @param string $CustomerCode
	 * @return stdClass
	 */
	public function GetCustomer($CustomerCode) {
		$params = array(
			'CustomerCode' => $CustomerCode,
		);
		return $this->request('GetCustomer', $params)->GetCustomerResult;
	}
	/**
	 * This method returns an object of type Customer containing details of the customer specified by the Customer ID.
	 * This is an alternative to the GetCustomer method which returns a customer based on their code.
	 * @param int $CustomerID
	 * @return stdClass
	 */
	public function GetCustomerByID($CustomerID) {
		$params = array(
			'CustomerID' => $CustomerID,
		);
		return $this->request('GetCustomerByID', $params)->GetCustomerByIDResult;
	}
	/**
	 * This method returns an object of type Customer containing details of the customer specified by the Customers email address.
	 * This is an alternative to the GetCustomer method which returns a customer based on their code. It is useful for checking if a customer already exists.
	 * @param int $CustomerEmail
	 * @return stdClass
	 */
	public function GetCustomerByEmail($CustomerEmail) {
		$params = array(
			'CustomerEmail' => $CustomerEmail,
		);
		return $this->request('GetCustomerByEmail', $params)->GetCustomerByEmailResult;
	}
	/**
	 * This method returns an array of of type Customer containing details of all customers.
	 * @return array Array of customer objects
	 */
	public function GetCustomers() {
		return $this->request('GetCustomers')->GetCustomersResult->Customer;
	}
	/**
	 * This method returns an array of of type Customer containing details of all customers that have been modified or created since the specified date.
	 * @param datetime $ModDate
	 * @return array Array of customer objects
	 */
	public function GetCustomersModifiedSince($ModDate) {
		$params = array(
			'ModifiedSince' => $ModDate,
		);
		return $this->request('GetCustomersModifiedSince', $params)->GetCustomersModifiedSinceResult;
	}
	/**
	 * This method lets you create a new Customer.
	 * If the operation is successful then you are returned an integer containing the newly generated ID number for the customer.
	 * @param array $customer Array of customer fields for insertion
	 * @return int CustomerID of newly created customer
	 */
	public function InsertCustomer($customer=null) {
		if(!$customer){
			$customer['custr'] = $this->attributes;
		}
		return $this->request('InsertCustomer', $customer)->InsertCustomerResult;
	}
	/**
	 * This method lets you create a new Customer.
	 * If the operation is successful then you are returned an integer containing the newly generated ID number for the customer.
	 * @param array $customer Array of customer fields for updating
	 */
	public function UpdateCustomer($customer=null) {
		if(!$customer){
			$customer['custr'] = $this->attributes;
		}
		$this->request('UpdateCustomer', $customer);
	}

	public function DeleteCustomer($code) {
		
	}

	public function GetCustomerSources() {
		
	}

	public function GetCustomerVATNumber($code) {
		
	}

	public function SetCustomerVATNumber($code, $vat) {
		
	}

	public function GetCustomerCurrency($code) {
		
	}

	public function SetCustomerCurrency($code, $currency) {
		
	}

	public function GetCustomersByPostcode($code, $currency) {
		
	}

	public function GetCustomerBalance($code, $currency) {
		
	}

	public function GetCustomerAdvancePayments($code, $currency) {
		
	}

}