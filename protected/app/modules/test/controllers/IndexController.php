<?php

class IndexController extends AController {

	public function actionIndex() {
		
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		$model = new $contactModel('search');
		
		$model->unsetAttributes();
		
		if(isset($_GET[$contactModel]))
			$model->attributes = $_GET[$contactModel];

		$this->render('index', array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}

	public function actionGrid() {
		$this->render('grid');
	}

}
