<?php
/**
 * SupportComposeMail class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of SupportComposeMail
 *
 * @author steve
 */
class SupportComposeMail  extends CFormModel
{
	public $to;
	public $cc;
	public $subject;
	public $from;
	public $message_html;
	public $message_text;
	public $bcc;
	
	public function attributeLabels() {
		return array(
			'to'=>'To:',
			'cc'=>'Cc:',
			'bcc'=>'Bcc:',
			'subject'=>'Subject:',
			'from'=>'From:',
			'message_html'=>'Message:',
			'message_text'=>'Text:',
		);
	}
}