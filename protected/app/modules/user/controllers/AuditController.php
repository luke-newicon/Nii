<?php

class AuditController extends AController {

	public function actionIndex() {
		
		$this->pageTitle = Yii::app()->name.' - Audit Trail';
		$class = 'NLog';
		$model = new NLog('search');
		
		$model->unsetAttributes();
		
		if(isset($_GET[$class]))
			$model->attributes = $_GET[$class];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model
		));
	}
	
}