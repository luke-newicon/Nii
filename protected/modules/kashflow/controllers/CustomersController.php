<?php 
Class CustomersController extends NController
{
	public function actionIndex(){
		$customers = new KashCustomers();
		$this->render('index',array('customers'=>$customers->getCustomers()));
	}
	
}