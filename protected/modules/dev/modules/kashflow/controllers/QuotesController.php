<?php 
Class QuotesController extends AController
{
	public function actionIndex(){
		$quotes = new KashQuotes();
		$this->render('index',array('quotes'=>$quotes->getQuotes()));
	}
	
}