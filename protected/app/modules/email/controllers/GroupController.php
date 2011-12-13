<?php

class GroupController extends AController
{
	
	public function actionIndex()
	{
		$this->redirect(array('manage'));
	}
	
	public function actionManage()
	{
		$this->pageTitle = Yii::app()->name . ' - Email Groups';
		$eventModel = 'ContactGroup';
	
		$model = new $eventModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$eventModel]))
			$model->attributes = $_GET[$eventModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	public function actionEdit() {

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

