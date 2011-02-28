<?php 
Class QuotesController extends NController
{
	public function actionIndex(){
		$quotes = new KashQuotes();
		$this->render('index',array('quotes'=>$quotes->getQuotes()));
	}
	
}