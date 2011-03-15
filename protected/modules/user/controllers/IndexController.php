<?php

class IndexController extends NAController {

	/**
	 * Lists all models.
	 */
	public function actionIndex() {

		$model = new User('search');
		if (isset($_GET['User']))
			$model->attributes = $_GET['User'];
		$this->render('/user/index', array(
			'model' => $model
		));
	}

}