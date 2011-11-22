<?php

class IndexController extends AController {

	public function actionIndex() {
		$this->redirect(array('dashboard'));
	}

	public function actionDashboard() {
//		$modules = Yii::app()->getModules();
//		echo '<pre>'.print_r($modules,true).'</pre>';
		$this->render('dashboard');
	}

}