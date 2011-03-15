<?php 
Class CustomersController extends NAController
{
	public function actionIndex(){
		$customers = new KashCustomers();
		$this->render('index',array('customers'=>$customers->getCustomers()));
	}
	
}