<?php 
Class QuotesController extends AdminController
{
	public function actionIndex(){
		$quotes = new KashQuotes();
		$this->render('index',array('quotes'=>$quotes->getQuotes()));
	}
	
}