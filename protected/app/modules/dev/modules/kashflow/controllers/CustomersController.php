<?php 
Class CustomersController extends AController
{
	public function actionIndex(){
		$customers = new KashCustomers();
		$this->render('index',array('customers'=>$customers->getCustomers()));
	}
	
}