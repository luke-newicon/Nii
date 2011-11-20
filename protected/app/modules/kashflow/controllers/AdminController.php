<?php

class AdminController extends AController {

	public function actionIndex() {
		$model = new KashflowCustomer;
		$model->CustomerID = 4889944;
		$model->Name = 'Luke Spencer';
		print_r($model->UpdateCustomer());
		
//		$this->redirect(array('customers'));
	}

	public function actionCustomers() {

		$model = new KashflowCustomer;

		$customers = $model->GetCustomers();

		$this->render('customers', array(
			'customers' => $customers
		));
	}
	
	public function actionQuotes() {

		$model = new KashflowQuote;

		$quotes = $model->GetQuotes();

		$this->render('quotes', array(
			'quotes' => $quotes
		));
	}
	
	public function actionInvoices() {

		$model = new KashflowInvoice;

		$invoices = $model->GetInvoices();

		$this->render('invoices', array(
			'invoices' => $invoices
		));
	}
	
	public function actionSuppliers() {

		$model = new KashflowSupplier;

		$suppliers = $model->GetSuppliers();

		$this->render('suppliers', array(
			'suppliers' => $suppliers
		));
	}
	
	public function actionReceipts() {

		$model = new KashflowReceipt;

		$receipts = $model->GetReceipts();

		$this->render('receipts', array(
			'receipts' => $receipts
		));
	}

}