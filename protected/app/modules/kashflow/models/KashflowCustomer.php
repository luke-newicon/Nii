<?php

class KashflowCustomer extends KashflowModel {

	public $CustomerID;
	public $Code;
	public $Name;
	public $Contact;
	public $Telephone;
	public $Mobile;
	public $Fax;
	public $Email;
	public $Address1;
	public $Address2;
	public $Address3;
	public $Address4;
	public $Postcode;
	public $Website;
	public $EC;
	public $OutsideEC;
	public $Notes;
	public $Source;
	public $Discount;
	public $ShowDiscount;
	public $PaymentTerms;
	public $ExtraText1;
	public $ExtraText2;
	public $ExtraText3;
	public $ExtraText4;
	public $ExtraText5;
	public $ExtraText6;
	public $CheckBox1;
	public $CheckBox2;
	public $Created;
	public $Updated;
	public $CurrencyID;
	public $resultWrapper = 'Customer';

	public function GetCustomer($code) {
		
	}

	public function GetCustomerById($id) {
		
	}

	public function GetCustomerByEmail($email) {
		
	}

	public function GetCustomers() {
		return $this->request('GetCustomers')->GetCustomersResult->Customer;
	}

	public function GetCustomersModifiedSince($date) {
		
	}

	public function InsertCustomer($customer) {
		
	}

	public function UpdateCustomer($customer) {
		
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