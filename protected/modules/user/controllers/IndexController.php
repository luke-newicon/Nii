<?php

class IndexController extends AdminController {

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$model = new User('search');
		if (isset($_GET['User']))
			$model->attributes = $_GET['User'];
		$this->render('index', array(
			'model' => $model
		));
	}

	public function actionView($id){
		$model = User::model()->findbyPk($id);

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$this->render('view',array('model'=>$model));
	}

}