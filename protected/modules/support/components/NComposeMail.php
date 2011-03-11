<?php
/**
 * NComposeMail class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NComposeMail
 *
 * @author steve
 */
class NComposeMail extends NWidget
{

	public $replyTo;

    //put your code here
	public function init(){

		$model = new SupportComposeMail;
		if($this->replyTo){
			$model->to = $this->replyTo->from;
			$model->from = Yii::app()->user->record->email;
			$model->subject = $this->replyTo->subject;
			$model->message_html = $this->replyTo->message_html;
			$model->message_text = $this->replyTo->message_text;
		}
		$this->render('compose',array('model'=>$model));

	}
}