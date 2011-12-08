<?php

class TemplateController extends AController
{
	
	public function actionIndex() {
		return;
	}
	
	public function actionGetContents($id) {
		$template = EmailCampaignTemplate::model()->findByPk($id);
		$response = array('content'=>$template->content, 'subject'=>$template->subject);
		if ($template->default_group) {
			$group = ContactGroup::model()->findByAttributes(array('name'=>$template->default_group));
			$recipients['id'] = (int)$group->id;
			$recipients['name'] = $group->label;
		}
		if (isset($recipients))
			$response['recipients'] = $recipients;
		echo CJSON::encode($response) ;
		Yii::app()->end();
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model,$class='emailCampaignTemplate')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}

