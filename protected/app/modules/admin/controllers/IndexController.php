<?php

class IndexController extends AController {

	public function actionIndex() {
		$this->redirect(array('dashboard'));
	}
	
	public function actionDashboard(){
		$this->render('dashboard');
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}