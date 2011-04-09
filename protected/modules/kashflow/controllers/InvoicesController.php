<?php 
Class InvoicesController extends AController
{
	public function actionIndex(){
		$invoices = new KashInvoices();
		$customers = new KashCustomers();
		$customerLookup = array();
		foreach($customers->getCustomers() as $customer){
			$customerLookup[$customer->CustomerID] = $customer;	
		}
		$this->render('index',array(
			'customers'=>$customerLookup,
			'invoices'=>$invoices->getInvoicesByDateRange()
		));
	}
	
}