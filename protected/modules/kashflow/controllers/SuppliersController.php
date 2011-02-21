<?php 
Class SuppliersController extends NiiController
{
	public function actionIndex(){
		$suppliers = new KashSuppliers();
		$this->render('index',array('suppliers'=>$suppliers->getSuppliers()));
	}
	
}