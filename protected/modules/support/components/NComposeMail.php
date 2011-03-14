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
			if(Yii::app()->user->record)
				$model->from = Yii::app()->user->record->email;
			$model->subject = $this->replyTo->subject;

			$wroteDeatils = '<br /><br />On '.  NTime::nice($this->replyTo->date) . ' ' . CHtml::encode($this->replyTo->from) . ' wrote:';
			$model->message_html = '<div>'.$wroteDeatils.'<blockquote type="cite">'.$this->replyTo->message_html.'</blockquote></div>';
			$model->message_text = $this->replyTo->message_text;
		}
		$this->render('compose',array('model'=>$model));

	}
}