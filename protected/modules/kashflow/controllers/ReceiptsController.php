<?php 
Class ReceiptsController extends AController
{
	public function actionIndex(){
		$receipts = new KashPurchases();
		$this->render('index',array('receipts'=>$receipts->getReceipts()));
	}
	
}