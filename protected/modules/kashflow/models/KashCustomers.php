<?php
class KashCustomers extends KashTable
{
	
	public $rowClass = 'KashCustomer';
	public $resultWrapper = 'Customer';
	
	public function getCustomer($code){

	}
	
	public function getCustomerById($id){

	}
	
	public function getCustomerByEmail($email){
		
	}
	
	public function getCustomers(){
		return $this->api('GetCustomers');
	}
	
	public function getCustomersModifiedSince($date){

	}
	
	public function insertCustomer($customer){

	}
	
	public function updateCustomer($customer){

	}
	
	public function deleteCustomer($code){

	}
	
	public function getCustomerSources(){

	}
	
	public function getCustomerVATNumber($code){

	}
	
	public function setCustomerVATNumber($code,$vat){

	}
	
	public function getCustomerCurrency($code){

	}
	
	public function setCustomerCurrency($code,$currency){

	}
	
}