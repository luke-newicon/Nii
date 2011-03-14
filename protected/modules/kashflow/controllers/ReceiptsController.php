<?php 
Class ReceiptsController extends NAController
{
	public function actionIndex(){
		$receipts = new KashPurchases();
		$this->render('index',array('receipts'=>$receipts->getReceipts()));
	}
	
}