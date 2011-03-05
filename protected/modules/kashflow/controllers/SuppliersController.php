<?php 
Class SuppliersController extends NController
{
	public function actionIndex(){
		$suppliers = new KashSuppliers();
		$this->render('index',array('suppliers'=>$suppliers->getSuppliers()));
	}
	
}