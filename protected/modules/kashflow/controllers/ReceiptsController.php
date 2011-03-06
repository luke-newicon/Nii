<?php 
Class ReceiptsController extends NController
{
	public function actionIndex(){
		$receipts = new KashPurchases();
		$this->render('index',array('receipts'=>$receipts->getReceipts()));
	}
	
}