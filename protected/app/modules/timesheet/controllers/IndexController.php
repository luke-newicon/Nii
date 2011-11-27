<?php

class IndexController extends AController {

	public function actionIndex() {
		$this->render('index');
	}

	public function actionGood() {
		$this->render('good');
	}

}
