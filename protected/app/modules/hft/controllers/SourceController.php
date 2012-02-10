<?php

/**
 * Description of SourceController
 *
 * @author robinwilliams
 */
class SourceController extends AController 
{
	
	/**
	 *	Action to display the default sources grid view 
	 */
	public function actionIndex() {
		
		$this->pageTitle = Yii::app()->name . ' - Sources';
		$sourceModel = 'HftContactSource';
	
		$model = new $sourceModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$sourceModel]))
			$model->attributes = $_GET[$sourceModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	public function actionDelete($id) {
		if (NActiveRecord::model('HftContactSource')->deleteByPk($id))
			echo CJSON::encode(array('success'=>'Source successfully deleted'));
		Yii::app()->end();
	}
	
	
	/**
	 * Create a new source
	 */
	public function actionCreate() {
		
		$modelName = 'HftContactSource';
		
		$model = new $modelName;
		
		if ($_POST[$modelName]) {
			$model->attributes = $_POST[$modelName];
			$model->save();
		}
		echo CJSON::encode($model);
		Yii::app()->end();
	}
	
	
	/**
	 * Create a new source
	 */
	public function actionUpdate($id) {
		
		$modelName = 'HftContactSource';
		
		$model = NActiveRecord::model($modelName)->findByPk($id);
		
		if ($_POST[$modelName]) {
			$model->attributes = $_POST[$modelName];
			$model->save();
		}
		echo CJSON::encode($model);
		Yii::app()->end();
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model,$class='source')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}