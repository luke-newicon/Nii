<?php 
Class QuotesController extends NiiController
{
	public function actionIndex(){
		$quotes = new KashQuotes();
		$this->render('index',array('quotes'=>$quotes->getQuotes()));
	}
	
}