<?php 
Class CustomersController extends NiiController
{
	public function actionIndex(){
		$customers = new KashCustomers();
		$this->render('index',array('customers'=>$customers->getCustomers()));
	}
	
}