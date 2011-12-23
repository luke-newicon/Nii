<?php

class ManageController extends AController
{
	
	public function actionIndex()
	{
		$this->pageTitle = Yii::app()->name . ' - Saved Email Campaigns';
		$eventModel = 'EmailCampaignTemplate';
	
		$model = new $eventModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$eventModel]))
			$model->attributes = $_GET[$eventModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	/**
	 *	View screen for saved email campaigns
	 * @param int $id 
	 */	
	public function actionView($id) {
		$model = NActiveRecord::model('EmailCampaignTemplate')->findByPk($id);
		
		$this->render('view', array(
			'model'=>$model,
		));
	}
	
	/**
	 *	Create screen for saved email campaigns 
	 */
	public function actionCreate() {
		
		$this->pageTitle = Yii::app()->name . ' - New Saved Campaign';
		$modelName = 'EmailCampaignTemplate';
		
		$model = new $modelName;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
			if ($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$this->render('edit', array(
			'model'=>$model,
		));
	}

	/**
	 *	Edit screen for saved email campaigns 
	 */
	public function actionEdit($id) {
		
		$this->pageTitle = Yii::app()->name . ' - Edit Saved Campaign';
		$modelName = 'EmailCampaignTemplate';
		
		$model = NActiveRecord::model($modelName)->findByPk($id);
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
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
	public function performAjaxValidation($model,$class='')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}

