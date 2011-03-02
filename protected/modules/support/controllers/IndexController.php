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
}