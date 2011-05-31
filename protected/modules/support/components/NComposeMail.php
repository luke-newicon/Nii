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

	/**
	 *
	 * @var SupportEmail
	 */
	public $replyToEmail;
	
	public $replyToAll = true;
	
    //put your code here
	public function init(){
		
		
		
		$model = new SupportComposeMail;
		if($this->replyToEmail){
			$arr = array();
			foreach(NMailReader::getRecipients($this->replyToEmail->from) as $id=>$e){
				$email = $e['name'].' <'.$e['email'].'>';
				$arr[] = array('id'=>$email,'name'=>CHtml::encode($email));
			}
			$model->to = $arr;
			
			if($this->replyToAll){
				$replyAllArr = array();
				foreach(NMailReader::getRecipients($this->replyToEmail->to) as $id=>$e){
					$email = $e['name'].' <'.$e['email'].'>';
					$replyAllArr[] = array('id'=>$email,'name'=>CHtml::encode($email));
				}
				foreach(NMailReader::getRecipients($this->replyToEmail->cc) as $id=>$e){
					$email = $e['name'].' <'.$e['email'].'>';
					$replyAllArr[] = array('id'=>$email,'name'=>CHtml::encode($email));
				}
				$model->cc = $replyAllArr;
			}
			
			
			if(Yii::app()->user->record)
				$model->from = Yii::app()->user->record->email;
			$model->subject = $this->replyToEmail->subject;

			$wroteDeatils = '<br /><br />On '.  NTime::nice($this->replyToEmail->date) . ' ' . CHtml::encode($this->replyToEmail->from) . ' wrote:';
			$model->message_html = '<div>'.$wroteDeatils.'<blockquote type="cite">'.$this->replyToEmail->message_html.'</blockquote></div>';
			$model->message_text = $this->replyToEmail->message_text;
		}
		$this->render('compose',array('model'=>$model));

	}
}