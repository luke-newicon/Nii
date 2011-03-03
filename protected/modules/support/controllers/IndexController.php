<?php

class IndexController extends NController
{
	public function actionIndex()
	{
		NMailReader::readMail();
		$tickets = SupportTicket::model()->findAll();
		$this->render('index',array(
			'tickets'=>$tickets,
		));
	}
	
	/**
	 * Display the email message it must use an iframe to achieve this called from ajax
	 */
	public function actionMessage($id){
		$this->layout = '/layouts/ajax';
		$t = SupportTicket::model()->findByPk($id);
		$this->render('message',array('ticket'=>$t));
	}
	
	
	
	public function actionEmail($id){
		$this->layout = '/layouts/ajax';
		if(($e = SupportEmail::model()->findByPk($id)) === null)
			throw new CHttpException(404, 'Can not find the email message in the database');
		$this->render('email',array('e'=>$e));
	}
	
}