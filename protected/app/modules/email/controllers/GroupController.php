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
		$groupModel = 'ContactGroup';
	
		$model = new $groupModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$groupModel]))
			$model->attributes = $_GET[$groupModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	public function actionView($id) {
		
		$this->pageTitle = Yii::app()->name . ' - View Group';
		
		$model = NActiveRecord::model('ContactGroup')->findByPk($id);
		$this->render('view',array(
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

