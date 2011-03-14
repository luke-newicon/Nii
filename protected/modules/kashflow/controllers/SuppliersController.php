<?php 
Class SuppliersController extends NAController
{
	public function actionIndex(){
		$suppliers = new KashSuppliers();
		$this->render('index',array('suppliers'=>$suppliers->getSuppliers()));
	}
	
}