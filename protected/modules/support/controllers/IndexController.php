<?php

class IndexController extends AController
{
	
	public function actionIndex()
	{
		$url = $this->getModule('dev')->getAssetsUrl();
		Yii::app()->clientScript->registerScriptFile("$url/ape/JavaScript.js");
		Yii::app()->clientScript->registerScriptFile("$url/ape/config.js");
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
		$emails = SupportEmail::model()->findAll(array(
			'limit'=>$limit,
			'offset'=>$offset*$limit,
			'order'=>'date DESC, id DESC'
		));
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

	public function actionContacts($q){
		$q = urldecode($_GET['q']);
		// escape % and _ characters
		$q = strtr($q, array('%'=>'\%', '_'=>'\_'));
		$nl = CrmContact::model()->nameLikeQuery($q);
		CrmEmail::model()->with('contact')
			->getDbCriteria()
			->addCondition('address like :q')
			->addCondition($nl['condition'], 'OR')
			->params = array_merge($nl['params'],array(':q'=>"%$q%"));
		$data = array();
		foreach(CrmEmail::model()->findAll(array('limit'=>20)) as $c){
			$data[] = array('id'=>$c->contact->id, 'name'=>$c->contact->name().' &lt;'.$c->address.'&gt;');
		}
		echo json_encode($data);
	}
	
	public function actionImport($offset=0){
		NMailReader::$readLimit = 250;
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
	
	
	public function actionCheckMail($id){
		NMailReader::$readLimit = 5;
		NMailReader::$forceCountRefresh = true;
		NMailReader::readMail();
		// need to know where i am. whats currently displaying?
		// check to see if new emails exist in the db
		// the id is the id of the latest email displaying.
		$r = SupportEmail::model()->findAll(array(
			'limit'=>30,
			'order'=>'date DESC, id DESC',
		));
		// loop through the latest db results if the id is the same as the 
		// one currently showing we are up to date, if not it must be new add it to the newMsg array
		$newMsgs = array();
		foreach($r as $i => $e){
			//echo $e->id();
			if($e->id == $id)
				break;
			
			$newMsgs[] = $this->renderPartial(
				'_message-list-item', 
				array('email'=>$e,'dataPos'=>$i),
				true
			);
		}
		// we need the messages to be shown the latest first.
		$ret = array_reverse($newMsgs);
		echo json_encode($ret);
	}

}

