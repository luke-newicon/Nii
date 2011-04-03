<?php 
Class SuppliersController extends AdminController
{
	public function actionIndex(){
		$suppliers = new KashSuppliers();
		$this->render('index',array('suppliers'=>$suppliers->getSuppliers()));
	}
	
}