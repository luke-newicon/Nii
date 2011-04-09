<?php 
Class SuppliersController extends AController
{
	public function actionIndex(){
		$suppliers = new KashSuppliers();
		$this->render('index',array('suppliers'=>$suppliers->getSuppliers()));
	}
	
}