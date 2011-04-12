<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of TestController
 *
 * @author steve
 */
class TestController extends AController 
{
	
	public function actionLoadMessageFolders()
	{
		$folders = NMailReader::folders();
		echo $this->render('message-folders',array(
			'folders'=>$folders
		), true);
	}
	
	public function actionTestReadBatch($batch=0){
		NMailReader::$readLimit = 5;
		NMailReader::$readOfset=$batch;
		NMailReader::readMail();
	}

	
	public function actionTest($index, $actualId=0){
		NMailReader::testrPrintMessage($index, $actualId);
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
	
	public function actionTestInboxCount(){
		NMailReader::countInbox();
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

	
	public function actionThreading(){
		
//		$e = SupportEmail::model()->findByPk(21);
//		$headers = mb_convert_encoding($e->headers, 'utf-8');
//		dp($headers);
//		dp(CJSON::decode("$headers"));
//		echo (json_decode("$headers")===false)?'FALSE':'MUST BE NULL';
		$thread = new Threading;
		
		$thread->parseMessagesIntoThreads();
		//dp($thread->rootSet);
//		Yii::beginProfile('loop');
//		foreach(SupportEmail::model()->findAll() as $e){
//			if(empty($e->headers))
//				continue;
//			Yii::beginProfile('CJSON');
//			$headers = CJSON::decode($e->headers);
//			Yii::endProfile('CJSON');
//			//dp($headers);
//			
//			if(empty($headers) || !array_key_exists('in-reply-to', $headers))
//				continue;
//			Yii::beginProfile('MATCH');
//			preg_match('(<[^<>]+>)', $headers['in-reply-to'], $matches);
//			Yii::endProfile('MATCH');
//			dp($matches);
//		}
//		Yii::endProfile('loop');
	}
	
	public function actionThreadMsgs(){
		$thread = new Threading;
		$thread->parseMessagesIntoThreads();
		//dp($thread->subjectTable);
		$arr = array_values($thread->subjectTable);
		dp($arr[3]);
		//$this->printChildren($thread->rootSet);
		
	}

	public function printChildren($c, $indent=0){
		if($c->hasChildren()){
			foreach($c->children as $c){
				echo '<blockquote>';
				if($c->message!=null){
					$e = SupportEmail::model()->findByPk($c->message->dbId);

					echo $e->message_text;
				}
				$this->printChildren($c, $indent++);
				echo '</blockquote>';
			}
		}
	}


	public function actionTestSubject(){
		//Fwd: Re[3]: Re: Re: Mysd car re: sdjhsdf
		echo NMailReader::normalizeSubject('Fwd: Re[3]: Re: Re: Mysd car re: sdjhsdf');
	}
}
