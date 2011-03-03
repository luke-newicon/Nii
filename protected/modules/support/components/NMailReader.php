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
	public static $readLimit = 5;
	
	public static function readMail(){
		$support = Yii::app()->getModule('support');
		$mail = new Zend_Mail_Storage_Imap(array(
			'host'     => $support->emailHost,
			'user'     => $support->emailUsername,
			'password' => $support->emailPassword,
			'port'     => $support->emailPort,
			'ssl'	   => $support->emailSsl
		));
		$msgNum = $mail->countMessages();
		// read messages Latest First.
		// should limit results:

		$ii = 0;
		for($i=$msgNum; $i>0; $i--){
			if($ii >= self::$readLimit) break;
			$e = $mail->getMessage($i);	
			// check we have not already processed the email
			// TODO: if system is set to not delete from server. (implement delete message if it is)
			//FB::log($i,'mail number');
			//FB::log($ii,'loop number');
			$ii++;
			if($e->headerExists('message-id')){
				if(SupportEmail::model()->find('message_id=:id',array(':id'=>$e->getHeader('message-id')))){
					continue;
				}
			}

			self::saveMail($e);
			
			$mail->setFlags($i,array(Zend_Mail_Storage::FLAG_SEEN));
		}
	}
	
	public static function saveMail(Zend_Mail_Message $e){
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
		self::parseParts($e, $m);
		
		$m->save();
		Yii::log($m->message_html);
		// yii::app()->end();
		$t = false;
		// Check the subject line for possible ID.
        if (self::hasSubjectTicketId($m->subject, $id))
        	if(($t = SupportTicket::model()->findByPk($id)));
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
	
	public static function parseParts($parts, &$m){
		foreach($parts as $part) {
			$encoding = self::headerParam($part,'content-transfer-encoding');
			if (strtok($part->contentType, ';') == 'text/html'){
				$m->message_html = $part->getContent();
				continue;
			}elseif (strtok($part->contentType, ';') == 'text/plain'){
				$m->message_text = self::decode($part->getContent(),$encoding);
				continue;	
			}elseif ($part->isMultipart()){
				self::parseParts($part, $m);
			}else{
				self::saveAttachment($part, $m);
			}
		}
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
	
	/**
	 * This function splits a header usually in the format
	 * "name last" <some@email.com> and returns array name=>'',email=>''
	 * @param string $fromString
	 * @retun array(name=>'nameValue',email=>'emailValue') 
	 */
	public static function splitFromHeader($fromString){
		preg_match('/([^<]*) <(.*)>/', $fromString, $matches);
		$name = array_key_exists(1,$matches)?$matches[1]:'';
		$email = array_key_exists(2,$matches)?$matches[2]:'';
		return array(
			'name'=>str_replace('"','',$name),
			'email'=>$email
		);
	}
	
	
	public static function date(Zend_Mail_Message $mail){
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
	
}