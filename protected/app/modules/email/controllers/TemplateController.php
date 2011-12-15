<?php

class TemplateController extends AController
{
	
	public function actionIndex() {
		
		$this->pageTitle = Yii::app()->name . ' - Manage Design Tempaltes';
		$templateModel = 'EmailTemplate';
	
		$model = new $templateModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$templateModel]))
			$model->attributes = $_GET[$templateModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	public function actionGetContents($id) {
		$template = EmailCampaignTemplate::model()->findByPk($id);
		$response = array('content'=>$template->content, 'subject'=>$template->subject);
		if ($template->default_group_id) {
			$group = ContactGroup::model()->findByPk($template->default_group_id);
			$recipients['id'] = 'g_'.$group->id;
			$recipients['name'] = $group->name;
		}
		if (isset($recipients))
			$response['recipients'] = $recipients;
		echo CJSON::encode($response) ;
		Yii::app()->end();
	}

	/**
	 *	View screen for email design templates
	 * @param int $id 
	 */
	public function actionView($id) {
		$model = NActiveRecord::model('EmailTemplate')->findByPk($id);
		
		$this->render('view', array(
			'model'=>$model,
		));
	}
	
	/**
	 *	View screen for email design templates
	 * @param int $id 
	 */
	public function actionTemplateContent($id) {
		$model = NActiveRecord::model('EmailTemplate')->findByPk($id);
		
		$this->renderPartial('template_content', array(
			'model'=>$model,
		));
	}
	
	/**
	 *	Create screen for email design templates 
	 */
	public function actionCreate() {
		
		$this->pageTitle = Yii::app()->name . ' - New Design Template';
		$modelName = 'EmailTemplate';
		
		$model = new $modelName;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
			if ($model->default_template==1)
				Yii::app()->db->createCommand('update email_template set default_template=0')->query();
			
			if ($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$this->render('edit', array(
			'model'=>$model,
		));
	}

	/**
	 *	Edit screen for email design templates 
	 */
	public function actionEdit($id) {
		
		$this->pageTitle = Yii::app()->name . ' - Edit Design Template';
		$modelName = 'EmailTemplate';
		
		$model = NActiveRecord::model($modelName)->findByPk($id);
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
			if ($model->default_template==1)
				Yii::app()->db->createCommand('update email_template set default_template=0')->query();
			
			if ($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$this->render('edit', array(
			'model'=>$model,
		));
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

