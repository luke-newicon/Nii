<?php

class IndexController extends NController
{
	public function actionIndex()
	{
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
		$t = SupportTicket::model()->findByPk($id);
		$this->render('message',array('ticket'=>$t));
	}
	
	
	
	public function actionEmail($id){
		$this->layout = '/layouts/ajax';
		if(($e = SupportEmail::model()->findByPk($id)) === null)
			throw new CHttpException(404, 'Can not find the email message in the database');
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
		NMailReader::$readOfset = $offset*$limit;
		NMailReader::readMail();
		$total = NMailReader::countMessages();
		$tickets = SupportTicket::model()->findAll(array('limit'=>$limit,'offset'=>$offset*$limit));
		$this->render('message-list',array(
			'total'=>$total,
			'tickets'=>$tickets,
			'offset'=>$offset,
			'limit'=>$limit,

		));
	}

	public function actionLoadMessageFolders()
	{
		$folders = NMailReader::folders();
		echo $this->render('message-folders',array(
			'folders'=>$folders
		), true);
	}

	public function actionTest($index){
		NMailReader::testrPrintMessage($index);

	}


	public function actionSaveTest($index){
		$m = new SupportEmail();
		NMailReader::connect();
		$msgNum = NMailReader::countMessages();
		$msg = NMailReader::$mail->getMessage(($msgNum+1)-$index);
		echo $msg->from . '<br/>';
		$file = Yii::app()->getRuntimePath().DS.'testEmail';
		file_put_contents($file, $msg->getContent());
		dp(Zend_Mime_Decode::splitHeaderField($msg->from));
		foreach($msg as $part) {
			if($part->headerExists('content-type')){
				// split the content-type header up
				$contentType = Zend_Mime_Decode::splitContentType($part->contentType);
				if ($contentType['type'] == 'text/html') {
					$m->message_html = NMailReader::decodeContent($part, $contentType);
				} elseif ($contentType['type'] == 'text/plain') {
					$m->message_text = NMailReader::decodeContent($part, $contentType);
				} elseif ($part->isMultipart()) {
					self::parseParts($part, $m);
				} else {
					//self::saveAttachment($part, $m);
				}
			}else{
				// header does not exist... shout and scream at silly mail format person!
			}
		}

		//NMailReader::getHtmlPart();

	//	dp($html);
		$m->save();

	}

	public function actionLayout(){
		$this->render('test');
	}
	
}