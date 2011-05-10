<?php

class IndexController extends AController {

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$user = UserModule::get()->userClass;
		$model = new $user('search');
		if (isset($_GET[$user]))
			$model->attributes = $_GET[$user];
		$this->render('index', array(
			'model' => $model
		));
	}

	public function actionView($id){
		$model = UserModule::userModel()->findbyPk($id);

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$this->render('view',array('model'=>$model));
	}
	
	public function actionInstall(){
		$this->getModule()->install();
	}

}