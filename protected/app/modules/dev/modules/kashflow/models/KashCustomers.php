<?php
class KashCustomers extends KashTable
{
	
	public $rowClass = 'KashCustomer';
	public $resultWrapper = 'Customer';
	
	public function GetCustomer($code){

	}
	
	public function GetCustomerById($id){

	}
	
	public function GetCustomerByEmail($email){
		
	}
	
	public function GetCustomers(){
		return $this->api('GetCustomers');
	}
	
	public function GetCustomersModifiedSince($date){

	}
	
	public function InsertCustomer($customer){

	}
	
	public function UpdateCustomer($customer){

	}
	
	public function DeleteCustomer($code){

	}
	
	public function GetCustomerSources(){

	}
	
	public function GetCustomerVATNumber($code){

	}
	
	public function SetCustomerVATNumber($code,$vat){

	}
	
	public function SetCustomerCurrency($code){

	}
	
	public function SetCustomerCurrency($code,$currency){

	}
	
	public function GetCustomerAdvancePayments($code,$currency){

	}
    
	
}