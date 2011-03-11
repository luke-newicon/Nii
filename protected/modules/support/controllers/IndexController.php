<?php

class IndexController extends NController
{
	public function actionIndex()
	{
		//NMailReader::readMail();
		//$tickets = SupportTicket::model()->findAll();
		//$total = NMailReader::countMessages();
		$total=8000;
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
		$j['summary'] = $this->render('message',array('ticket'=>$t),true);
		$e = $t->emails[0];
		$j['content'] = $e->message();
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
//		NMailReader::$readOfset = $offset*$limit;
//		NMailReader::readMail();
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


	public function actionReply($emailId){
		$t = SupportTicket::model()->findByPk($emailId);
		// get last email in conversation

		echo $this->widget('support.components.NComposeMail',array('replyTo'=>$t->emails[0]),true);
	}


	public function actionTest($index){
		NMailReader::testrPrintMessage($index);
	}

	public function actionTestSave($index){
		$m = new SupportEmail();
		NMailReader::connect();
		$msgNum = NMailReader::countMessages();
		$mail = NMailReader::$mail;
		$index = ($msgNum+1)-$index;
		$msg = $mail->getMessage($index);
		echo $msg->from . '<br/>';
		if($msg->headerExists('cc'))
			echo CHtml::encode($msg->cc);
		$file = Yii::app()->getRuntimePath().DS.'testEmail';
		file_put_contents($file, $mail->getRawHeader($index).$mail->getRawContent($index));

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
					// self::saveAttachment($part, $m);
				}
			}else{
				// header does not exist... shout and scream at silly mail format person!
			}
		}
		//NMailReader::getHtmlPart();
		//dp($html);
		$m->save();
	}

	public function actionTestTo(){
		$string = '"COLOSIMO, Antonio" <Antonio.COLOSIMO@airbus.com>,
			"BERNARDINI, Gabriele" <Gabriele.BERNARDINI@airbus.com>,
			"BIRD, Andrew" <Andrew.Bird2@airbus.com>,
			"\'BIRD, Ollie\'" <birdy_o@hotmail.co.uk>,
			"CABLE, Peter" <PETER.CABLE@airbus.com>,
			"CAMPBELL, Lynn L" <lynn.l.campbell@airbus.com>,
			"DAVIES, Ryan M" <Ryan.Davies@airbus.com>,
			"de Luca, Marco" <marco.deluca@airbus.com>,
			"DI-LECCE, Giuseppe" <GIUSEPPE.DI-LECCE@airbus.com>,
			"DI-PISA, Corrado" <CORRADO.DI-PISA@airbus.com>,
			"ELSEY, Christopher" <CHRISTOPHER.ELSEY@airbus.com>,
			"EVERETT, Martin" <Martin.Everett@Airbus.com>,
			"FORD, Jonathan" <jonathan.ford@airbus.com>,
			"FRASER, Alistair" <alistair.fraser@airbus.com>,
			"FROST, Terence" <Terence.Frost@Airbus.com>,
			"GALLUCCI, Mattia" <mattia.gallucci@airbus.com>,
			"GARAYGAY, Cecile" <CECILE.GARAYGAY@airbus.com>,
			"GILMARTIN, Paul" <PAUL.GILMARTIN@airbus.com>,
			"HANCOCK, Simon" <Simon.Hancock@airbus.com>,
			"HEALEY, Mark M" <Mark.M.Healey@airbus.com>,
			"HUMPHREY, Matthew" <matthew.humphrey@airbus.com>,
			"KIRCHHOFF, Bjoern" <Bjoern.Kirchhoff@airbus.com>,
			"MALISZEWSKA, Claudia C" <claudia.c.maliszewska@airbus.com>,
			"MEHTA, Keval" <keval.mehta@airbus.com>,
			"MELLOR, Russell" <Russell.Mellor@airbus.com>,
			"MORRIS, James M" <James.J.Morris@airbus.com>,
			\'Nbaghdadi\' <nbaghdadi@stirling-dynamics.com>,
			"NEWBOUND, Alex" <ALEX.NEWBOUND@airbus.com>,
			"PIRA-LUNA, Andres" <Andres.Pira-Luna@airbus.com>,
			"REYNOLDS, Dylan" <DYLAN.REYNOLDS@airbus.com>,
			"RICHARDSON, Mark" <MARK.RICHARDSON@airbus.com>,
			"ROULLIERE, Pierre (ALTEN)" <pierre.roulliere.external@airbus.com>,
			"\'SPENCER, Luke\'" <luke@newicon.co.uk>,
			\'Steve\' <steve@newicon.net>,
			"STORNAIUOLO, Salvatore" <SALVATORE.STORNAIUOLO@airbus.com>,
			"TIPPING, Jonathan" <jonathan.tipping@airbus.com>,
			"TONINELLI, Lorenzo" <lorenzo.toninelli@airbus.com>,
			"VIVARELLI, Leonardo" <Leonardo.Vivarelli@airbus.com>,
			"WILLIAMS, David R" <David.R.WILLIAMS@airbus.com>,
			"WOMBWELL, Adrian" <Adrian.Wombwell@Airbus.com>,
			"BAGHDADI, Nadjib (STIRLING DYNAMICS LTD)" <nadjib.baghdadi.external@airbus.com>,
			"MAZILLIUS, Sam (EADS Iwuk)" <sam.mazillius@eads.com>,
			steve@newicon.net,
			<Jennifer.Griffiths@synergyhealthplc.com>,
			silly@someone.com,';
		dp(CHtml::encode($string));
		dp(NMailReader::getRecipients($string));
	}	
}

