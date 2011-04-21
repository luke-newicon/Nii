<?php

class IndexController extends AController
{
	public function actionIndex()
	{
		//NMailReader::readMail();
		//$tickets = SupportTicket::model()->findAll();
		$total = NMailReader::countMessages();
		$this->render('index',array(
			'total'=>$total,
		));
	}
	
	/**
	 * Display the email message it must use an iframe to achieve this called from ajax
	 */
	public function actionMessage($id){
		$this->layout = '/layouts/ajax';
		$e = SupportEmail::model()->findByPk($id);
		$j['summary'] = $this->render('message',array('email'=>$e),true);
		if($e->opened == 0){
			$e->opened = 1;
			$e->save();
		}	
		$j['content'] = $e->message();
		echo json_encode($j);
	}
	
	/**
	 * Display the email message it must use an iframe to achieve this called from ajax
	 */
	public function actionMessageThread($id){
		// $id is now the normalized subject
		$threading = new Threading;
		$threading->parseMessagesIntoThreads();
		
		$this->layout = '/layouts/ajax';
		$thread = $threading->subjectTable[$id];
		//$e = SupportEmail::model()->findByPk($id);
		$j['summary'] = $this->render('message-thread',array('container'=>$thread),true);
		// make this work
		
		$thread->markAsOpened();
	
		$j['content'] = $thread->getEmail()->message();
		echo json_encode($j);
	}

	/**
	 * empty controller action called by the iframe src to display an empty page
	 */
	public function actionEmptyIframe(){
		//<meta  content="text/html; charset=utf-8" http-equiv="Content-type" />
		$this->layout = '/layouts/ajax';
		Yii::app()->clientScript->registerMetaTag('text/html; charset=utf-8',null,'Content-type');
		$this->render('empty');
	}

	// not really used at the moment!
	public function actionEmail($id){
		$this->layout = '/layouts/ajax';
		if(($e = SupportEmail::model()->findByPk($id)) === null)
			throw new CHttpException(404, 'Can not find the email message in the database');
		if($e->opened == 0){
			$e->opened = 1;
			$e->save();
		}	
		$this->render('email',array('e'=>$e));
	}

	/**
	 * load in the message previews
	 * @param int $offset
	 */
	public function actionLoadMessageList($offset=0)
	{
		$this->layout = '/layouts/ajax';
		$limit = SupportModule::get()->msgPageLimit;
		//NMailReader::$readOfset = $offset*$limit;
		//NMailReader::readMail();
		$total = NMailReader::countMessages();
		$emails = SupportEmail::model()->findAll(array('limit'=>$limit,'offset'=>$offset*$limit));
		$this->render('message-list',array(
			'total'=>$total,
			'emails'=>$emails,
			'offset'=>$offset,
			'limit'=>$limit,
		));
	}
	
	public function actionLoadMessageListThreaded($offset=0){
		$thread = new Threading;
		$thread->parseMessagesIntoThreads();
		//dp($thread->subjectTable);
		
		
		$this->layout = '/layouts/ajax';
		$limit = SupportModule::get()->msgPageLimit;
		$offset = $offset*$limit;
		//NMailReader::$readOfset = $offset*$limit;
		//NMailReader::readMail();
		$total = NMailReader::countMessages();
		//$emails = SupportEmail::model()->findAll(array('limit'=>$limit,'offset'=>$offset*$limit));
		$this->render('message-list-threaded',array(
			'total'=>$total,
			'threads'=>$thread->threads,
			'offset'=>$offset,
			'limit'=>$limit,
		));
	}

	public function actionReply($emailId){
		$e = SupportEmail::model()->findByPk($emailId);
		// get last email in conversation

		echo $this->widget('support.components.NComposeMail',array('replyTo'=>$e),true);
	}

	public function actionCompose(){
		echo $this->widget('support.components.NComposeMail',array(),true);
	}

	public function actionContacts(){
		$q = urldecode($_GET['q']);
		$data = array();
		//$data[] = array('id'=>$_GET['q'], 'name'=>$_GET['q']);
		foreach(CrmContact::model()->nameLike($q)->findAll(array('limit'=>20)) as $c){
			// only add people to the dropdown that have email addresses
			//if($email = $c->getPrimaryEmail()){
				$data[] = array('id'=>$c->id, 'name'=>$c->name().' &lt;'.$c->getPrimaryEmail().'&gt;');
			//}	
		}
		echo json_encode($data);
	}
	
	public function actionImport($offset=0){
		Yii::app()->getModule('support')->msgPageLimit = 250;
		NMailReader::$readOfset = $offset;
		NMailReader::$breakIfExists = false;
		NMailReader::$folder = '[Google Mail]/Sent Mail';
		NMailReader::readMail();
	}


	public function actionSend(){
		// lets hack this in for now...
		$model = new SupportComposeMail();
		$model->attributes = $_POST['SupportComposeMail'];
		
		$mail = new Zend_Mail();

		$mail->setBodyText(strip_tags($model->message_html));
		$mail->setBodyHtml($model->message_html);
		$mail->setFrom('steve@newicon.net', 'Steve O\'Brien');
		echo $model->message_html;
		echo $model->to;
		
		if(strpos($model->to, ',')){
			$to = explode(',',$model->to);
			foreach($to as $t)
				$mail->addTo(SupportEmail::getContact($t));
		}else{
			$mail->addTo(SupportEmail::getContact($model->to));
		}
		
		$mail->setSubject($model->subject);
		$mail->send();
	}

}

