<?php

class AdminController extends AController {

	public function actionIndex() {
		$model = new KashflowCustomer;
		$model->Name = 'Luke Spencer';
		print_r($model->GetCustomerAdvancePayments(4891765));
//		$this->redirect(array('customers'));
	}

	public function actionCustomers() {
		$customers = Yii::app()->kashflow->GetCustomers();

		$this->render('customers', array(
			'customers' => $customers
		));
	}
	
	public function actionQuotes() {
		$quotes = Yii::app()->kashflow->GetQuotes();

		$this->render('quotes', array(
			'quotes' => $quotes
		));
	}
	
	public function actionInvoices() {
		$invoices = Yii::app()->kashflow->GetInvoicesByDateRange('2011-11-01');

		$this->render('invoices', array(
			'invoices' => $invoices
		));
	}
	
	public function actionSuppliers() {
		$suppliers = Yii::app()->kashflow->GetSuppliers();

		$this->render('suppliers', array(
			'suppliers' => $suppliers
		));
	}
	
	public function actionReceipts() {
		$receipts = Yii::app()->kashflow->GetReceipts();

		$this->render('receipts', array(
			'receipts' => $receipts
		));
	}

}