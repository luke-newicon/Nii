<?php
class KashSuppliers extends KashTable
{
	
	public $rowClass = 'KashSupplier';
	public $resultWrapper = 'Supplier';

	public function getSupplier($code){

	}
	
	public function getSupplierById($id){

	}
	
	public function getSuppliers(){
		return $this->api('GetSuppliers')->orderBy('Name','ASC');
	}
	
	public function insertSupplier($supplier){

	}
	
	public function updateSupplier($supplier){

	}
	
	public function getSupplierVATNumber($code){

	}
	
	public function setSupplierVATNumber($code,$vat){

	}
	
	public function getSupplierCurrency($code){

	}
	
	public function setSupplierCurrency($code,$currency){

	}
	
}