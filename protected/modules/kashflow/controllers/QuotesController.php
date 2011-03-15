<?php 
Class QuotesController extends NAController
{
	public function actionIndex(){
		$quotes = new KashQuotes();
		$this->render('index',array('quotes'=>$quotes->getQuotes()));
	}
	
}