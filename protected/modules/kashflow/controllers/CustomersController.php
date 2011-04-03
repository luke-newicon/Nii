<?php 
Class CustomersController extends AdminController
{
	public function actionIndex(){
		$customers = new KashCustomers();
		$this->render('index',array('customers'=>$customers->getCustomers()));
	}
	
}