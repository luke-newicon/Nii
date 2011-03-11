<?php 
/**
 * NMailReader class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://www.newicon.org/
 * @copyright Copyright &copy; 20010-2011 Newicon Ltd
 * @license http://www.newicon.org/license/
 */

/**
 * NMailReader is the module class for the support system
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @version $Id: NMailReader.php $
 * @package Support
 */
Class NMailReader extends CComponent
{
	public static $readLimit = 30;

	public static $readOfset = 0;

	/**
	 *
	 * @var Zend_Mail_Storage_Imap
	 */
	public static $mail;
	
	/**
	 *
	 * @return Zend_Mail_Storage_Imap 
	 */
	public static function connect(){
		Yii::beginProfile('imap connect');
		self::$readLimit = SupportModule::get()->msgPageLimit;
		if(self::$mail ===null){
			$support = Yii::app()->getModule('support');
			self::$mail = new Zend_Mail_Storage_Imap(array(
				'host'     => $support->emailHost,
				'user'     => $support->emailUsername,
				'password' => $support->emailPassword,
				'port'     => $support->emailPort,
				'ssl'	   => $support->emailSsl
			));
		}
		Yii::endProfile('imap connect');
		return self::$mail;
	}
	
	public static function countMessages()
	{
		return self::connect()->countMessages();
	}
	
	
	public static function testrPrintMessage($msgIndex){
		$mail = self::connect();
		$msgNum = self::countMessages();
		$msg = $mail->getMessage(($msgNum+1)-$msgIndex);
		dp($msg);
		dp($msg->getContent());
		echo 'end of debug print output';
		if ($msg->isMultipart()) {
			foreach($msg as $part){
				dp($part);
			}
		} else {
			$encoding = self::headerParam($msg,'content-transfer-encoding');
			if (strtok($msg->contentType, ';') == 'text/html'){
				echo self::decode($msg->getContent(),$encoding);
			}elseif (strtok($msg->contentType, ';') == 'text/plain'){
				echo self::decode($msg->getContent(),$encoding);
			}
		}

		//create a new file
		$file = Yii::app()->getRuntimePath().DS.'testEmail';
		file_put_contents($file, $msg);

	}
	
	public static function readMail(){
		
		$mail = self::connect();

		// read messages Latest First.
		// should limit results:
		$msgNum = self::countMessages();
		$msgNum = $msgNum - self::$readOfset;
		$ii = 0;
		for($i=$msgNum; $i>0; $i--){
			if($ii >= self::$readLimit) break;
			Yii::beginProfile('imap: get message');
			$e = $mail->getMessage($i);
			$mail->noop();
			Yii::endProfile('imap: get message');
			// check we have not already processed the email
			// TODO: if system is set to not delete from server. (implement delete message if it is)
			$ii++;
			if($e->headerExists('message-id')){
				if(SupportEmail::model()->find('message_id=:id',array(':id'=>$e->getHeader('message-id')))){
					continue;
				}
			}
			self::saveMail($e, $i);
			//$mail->setFlags($i,array(Zend_Mail_Storage::FLAG_SEEN));
		}
	}

	/**
	 * saves a mail message
	 *
	 * @param Zend_Mail_Message $e
	 * @param int $i the message position
	 */
	public static function saveMail(Zend_Mail_Message $e, $i){
		// create mail message
		$m = new SupportEmail();
		$m->subject = mb_decode_mimeheader($e->subject);
		$m->headers = CJavaScript::encode($e->getHeaders());
		$m->from = $e->from;
		$m->to = $e->to;
		$m->message_id = $e->getHeader('message-id');
		if(isset($e->cc))
			$m->cc = $e->cc;
		// add message and attachments to email
		// attachments need the mail id so save it first
		$m->date = self::date($e);
		$m->save();
		try {
			self::parseParts($e, $m);
		} catch(Zend_Exception $err){
			Yii::log('ERROR parsing mail parts of message id: '.$i.': ' . $err->getMessage(),'error');
			$m->save();
			return;
		}
		$m->save();

		$t = false;
		// Check the subject line for possible ID.
        if (self::hasSubjectTicketId($m->subject, $id))
        	if(($t = SupportTicket::model()->findByPk($id))===null);
				$t = new SupportTicket();
				
		$t->createTicketFromMail($m);
			
		// create link table
		$te = new SupportTicketEmail();
		$te->email_id = $m->id();
		$te->ticket_id = $t->id();
		$te->save();
	}


	/**
	 * Checks the $subject string for a ticket id
	 *
	 * - If found it returns true
	 * - Also sets the byreference $id variable to the ticket id found
	 *
	 * @param string $subject
	 * @param int $id
	 * @return boolean
	 */
	public static function hasSubjectTicketId($subject, &$id=false){
		$hash = Yii::app()->getModule('support')->subjectPrepend;
		$ret = preg_match("[$hash([0-9]{1,11})]",$subject,$matches);
		$id = (array_key_exists(1,$matches)) ? $matches[1] : false;
		return ($ret !== 0);
	}

	/**
	 * Save parts of a message to a record
	 * 
	 * @param Zend_Mail_Message $msg
	 * @param SupportEmail $m
	 */
	public static function parseParts($msg, &$m){
		if($msg->isMultipart()){
			foreach($msg as $part) {
				self::ParsePart($part, $m);
			}
		}else{
			self::ParsePart($msg, $m);
		}
	}

	public static function ParsePart($part, &$m){
		
		// check content-type header exists
		if($part->headerExists('content-type')){
			// split the content-type header up
			$contentType = Zend_Mime_Decode::splitContentType($part->contentType);
			if ($contentType['type'] == 'text/html') {
				$m->message_html = self::decodeContent($part, $contentType);
			} elseif ($contentType['type'] == 'text/plain') {
				$m->message_text = self::decodeContent($part, $contentType);
			} elseif ($part->isMultipart()) {
				self::parseParts($part, $m);
			} else {
				//self::saveAttachment($part, $m);
			}
		}else{
			// header does not exist... shout and scream at silly mail format person!
		}
		
	}

	/**
	 *
	 * @param Zend_Mime_Part $part
	 * @return string
	 */
	public static function decodeContent($part, $contentType){
		$encoding = self::headerParam($part,'content-transfer-encoding', 'quoted-printable');
		$strMsg = self::decode($part->getContent(),$encoding);
		if(array_key_exists('charset', $contentType)){
			$strMsg = mb_convert_encoding($strMsg, 'utf-8', $contentType['charset']);
		}else{
			$strMsg = mb_convert_encoding($strMsg, 'utf-8');
		}
		return $strMsg;
	}
	
	public static function saveAttachment($part, $mail){
//		$path = Yii::app()->getRuntimePath();
//		if($part->headerExists('content-disposition')){
//			if(strtok($part->contentDisposition, ';')=='attachment'){
//				$filename = trim(str_replace(array('filename=','"'),'',strtok(';')));
//				$data = self::decode($part->getContent(),$part->contentTransferEncoding);
//				$up = new NUploader();
//				$fileId = $up->addFile($filename, $data, 'support_attachments');
//				$a = new SupportAttachment();
//				$a->name = $filename;
//				$a->type = strtok($part->contentType, ';');
//				$a->mail_id = $mail->id();
//				$a->file_id = $fileId;
//				$a->save();
//			}
//		}
	}
	
	public static function headerParam($part,$header,$defaultVal=null){
		return ($part->headerExists($header)) ? $part->getHeader($header) : $defaultVal;
	}
	
	/**
     * Given a body string and an encoding type,
     * this function will decode and return it.
     *
     * @param  string $string body to decode
     * @param  string $encoding Encoding type to use.
     * @return string Decoded body
     * @access private
     */
    public static function decode($string, $encoding = '7bit')
    {
        switch (strtolower($encoding)) {
            case '7bit':
                return $string;
                break;

            case 'quoted-printable':
                return quoted_printable_decode($string);
                break;

            case 'base64':
                return base64_decode($string);
                break;

            default:
                return $string;
        }
    }
    
    public function parsePriority($header=null)
	{
        $priority=0;
        if($header && ($begin=strpos($header,'X-Priority:'))!==false){
            $begin+=strlen('X-Priority:');
            $xpriority=preg_replace("/[^0-9]/", "",substr($header, $begin, strpos($header,"\n",$begin) - $begin));
            if(!is_numeric($xpriority))
                $priority=0;
            elseif($xpriority>4)
                $priority=1;
            elseif($xpriority>=3)
                $priority=2;
            elseif($xpriority>0)
                $priority=3;
        }
        return $priority;
    }
	
	
	public static function date(Zend_Mail_Message $mail)
	{
		if($mail->headerExists('date')){
			$date = $mail->getHeader('date');
			if(!($unixTs = strtotime($date)))
				//can not read the date make the date the current date.
				$unixTs = time();
		} else {
			$unixTs = time();
		}
		return date('Y-m-d H:i:s',$unixTs);
	}
	
	
	public static function folders()
	{
		$mail = self::connect();
		return new RecursiveIteratorIterator($mail->getFolders(), RecursiveIteratorIterator::SELF_FIRST);
	}

	/**
	 * Parses a To, From or CC email header field
	 * into correct name and email values,
	 * Trailing commas create individual rows if the row is an empty string this is not appended to the array
	 * @see NMailReader::splitRecipient
	 * @param string $string
	 */
	public static function getRecipients($string){
		$contacts = str_getcsv($string);
		//dp($contacts,true);
		$cArr = array();
		foreach($contacts as $c) {
			if(($r = self::splitRecipient($c)))
				$cArr[] = $r;
		}
		return $cArr;
	}

	/**
	 * This function splits a header usually in the format
	 * "name last" <some@email.com> and returns array with a name and email key
	 * It strips any double quotes and single quotes from the name attribute and generates a name
	 * value if none is supplied by removing the host part of the email address
	 * For example:
	 * 
	 * header format: '"steve obrien", <steve@newicon.net>' returns:
	 *     name  => steve obrien
	 *     email => steve@newicon.net
	 *
	 * header format: '<steve@newicon.net>' returns:
	 *     name  => steve
	 *     email => steve@newicon.net
	 *
	 * header format: 'steve@newicon.net' returns:
	 *     name  => steve
	 *     email => steve@newicon.net
	 *
	 * If $string is an empty string it returns null
	 *
	 * @param string $fromString
	 * @retun array(name=>'nameValue',email=>'emailValue')
	 */
	public static function splitRecipient($string)
	{
		if ($string=='') return null;

		preg_match('/([^<]*) <(.*)>|<(.*)>|([^<>]*)/', $string, $matches);

		$match1 = array_key_exists(1,$matches)?$matches[1]:'';
		$match2 = array_key_exists(2,$matches)?$matches[2]:'';
		$match3 = array_key_exists(3,$matches)?$matches[3]:'';
		$match4 = array_key_exists(4,$matches)?$matches[4]:'';

		// string is like "steve obrien" <steve@newicon.net>
		if($match1 && $match2 && !$match3 && !$match4){
			$email = $matches[2];
			$name = self::removeEmailHost($matches[1]);
		}

		// string is like <steve@newicon.net>
		if(!$match1 && !$match2 && $match3 && !$match4){
			$email = $matches[3];
			$name = self::removeEmailHost($email);
		}

		// string is like steve@newicon.net
		if(!$match1 && !$match2 && !$match3 && $match4){
			$email = $matches[4];
			$name = self::removeEmailHost($email);
		}

		return array(
			'name'=>trim(str_replace('"','',$name),"'"),
			'email'=>$email
		);
	}

	public static function removeEmailHost($email){
		$bits = explode('@',$email);
		return $bits[0];
	}

	
	
}