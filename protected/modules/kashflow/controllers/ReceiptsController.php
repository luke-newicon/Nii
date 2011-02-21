<?php 
Class ReceiptsController extends NiiController
{
	public function actionIndex(){
		$receipts = new KashPurchases();
		$this->render('index',array('receipts'=>$receipts->getReceipts()));
	}
	
}