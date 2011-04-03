<?php 
Class ReceiptsController extends AdminController
{
	public function actionIndex(){
		$receipts = new KashPurchases();
		$this->render('index',array('receipts'=>$receipts->getReceipts()));
	}
	
}