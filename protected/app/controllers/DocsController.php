<?php

class DocsController extends NController
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionContactsComplete(){
		$this->layout = '//layouts/ajax';
		echo json_encode(array(
			array('key'=>'contact 1', 'value'=>'contact 1'),
			array('key'=>'steve', 'value'=>'someone else')
		));
		Yii::app()->end();
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}