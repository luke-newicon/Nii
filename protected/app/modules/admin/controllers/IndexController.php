<?php

class IndexController extends AController {

	public function actionIndex() {
		$this->redirect(array('dashboard'));
	}
	
	public function actionDashboard(){
		$this->render('dashboard');
	}

	public function actionSettings(){
		$settings = new Setting;
		$this->render('settings',array('settings'=>$settings));
	}
	
	public function actionSettingsPage($module){
		$this->layout = '//layouts/ajax';
		$module = Yii::app()->getModule($module);
		$this->render('settingsPage',array('title'=>$module->name,'content'=>$module->settingsPage()));
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