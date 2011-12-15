<?php

class IndexController extends AController {

	public function actionIndex() {
		$this->redirect(array('dashboard'));
	}

	public function actionDashboard() {
		$this->render('dashboard', array(
			'portlets' => $this->module->dashboard->portlets,
		));
	}

}