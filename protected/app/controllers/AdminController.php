<?php

class AdminController extends AController {

	public function actionIndex() {
		$this->redirect(array('dashboard'));
	}
	
	public function actionDashboard(){
		$this->render('dashboard');
	}
	
	public function actionModules(){
		
		dp(NWebModule::getNiiModules());
		
		
		
		
		$this->render('modules');
	}
	
	public function actionSettings(){
		$settings = new Setting;
		$this->render('settings',array('settings'=>$settings));
	}
	
	public function actionSettingsPage($module){
		echo Yii::app()->getModule($module)->settingsPage();
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