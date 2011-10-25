<?php

class AdminController extends AController {

	public function actionIndex(){
		$this->redirect('pages');
	}
	
	public function actionPages() {
		$this->render('pages');
	}
	
	public function actionSettings(){
		$this->render('settings');
	}

}