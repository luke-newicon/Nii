<?php

class AdminController extends AController {

	public function actionIndex() {
		$this->redirect(array('dashboard'));
	}
	
	public function actionDashboard(){
		$this->render('dashboard');
	}
	
	public function actionModules(){
		
		dp(Yii::app()->getAllNiiModules());
		
		$this->render('modules');
	}
	
	public function actionModuleState($module,$state=0){
		// This is where the module is activated / deactivated
		echo CJSON::encode(array('success'=>'The "'.Yii::app()->getModule($module)->name.'" module was successfully '.($state?'activated':'deactivated')));
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