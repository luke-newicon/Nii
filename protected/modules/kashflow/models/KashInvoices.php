<?php
class KashInvoices extends KashTable
{
	
	public $rowClass = 'KashInvoice';
	public $resultWrapper = 'Invoice';
	
	public function getInvoice($code){

	}
	
	public function getInvoiceByID($id){

	}
	
	public function getInvoicesByDateRange(){
		return $this->api('GetInvoicesByDateRange','<StartDate>2010-05-14T00:00:00</StartDate><EndDate>2011-01-28T00:00:00</EndDate>')->orderBy('InvoiceDate','DESC');
	}
	
	public function getInvoicesForCustomer(){
		//return $this->api('GetCustomers')->orderBy('Name','ASC');
	}
	
	public function getInvoices_Overdue(){

	}
	
	public function getInvoices_Recent(){

	}
	
	public function getInvoices_Unpaid(){

	}
	
	public function insertInvoice(){

	}
	
	public function insertInvoiceLine(){

	}
	
	public function insertInvoiceLineWithInvoiceNumber(){

	}
	
	public function updateInvoice(){

	}
	
	public function updateInvoiceHeader(){

	}
	
	public function deleteInvoice(){

	}
	
	public function deleteInvoiceByID(){

	}
	
	public function deleteInvoiceLine(){

	}
	
	public function deleteInvoiceLineWithInvoiceID(){

	}
	
	public function emailInvoice(){

	}
	
	public function printInvoice(){

	}
	
	public function getPaypalLink(){

	}
	
}