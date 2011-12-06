<?php

class TemplateController extends AController
{
	
	public function actionIndex() {
		return;
	}
	
	public function actionCreate() {
		
		$this->pageTitle = Yii::app()->name . ' - New Email Campaign';
		$modelName = 'EmailCampaign';
		
		$model = new $modelName;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
			if($model->save()) {
				
				NLog::insertLog('Inserted new template details (id: '.$model->id.')', $model);
				$this->redirect(array("template/send","id"=>$model->id));		
			}
		}
		
		$this->render('create', array(
			'model'=>$model,
		));
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model,$class='emailCampaign')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}

