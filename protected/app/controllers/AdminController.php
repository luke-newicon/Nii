<?php

class AdminController extends AController {

	public function actionIndex() {
		$this->redirect(array('dashboard'));
	}
	
	public function actionDashboard(){
		$this->render('dashboard');
	}
	
	public function actionModules(){
		
		// get a list of all modules
		$allModules = Yii::app()->niiModulesAll;

		// get the list of modules currently defined in the settings
		$systemModules = Yii::app()->settings->get('system_modules', 'system', array());
		
		
		FB::log($allModules, '$allModules');
		FB::log($systemModules, '$systemModules');
		
		$this->render('modules', array('allModules'=>$allModules, 'systemModules'=>$systemModules));
	}
	
	/**
	 * handles module activate and deactivate ajax requests.
	 * @param string $module the module id
	 * @param bool $activate 
	 */
	public function actionModuleState($moduleId,$enabled=0){
		// This is where the module is activated / deactivated
		try {
			
			$m = Yii::app()->activateModule($moduleId);
			
			// update the modules enabled state by merging with the current settings
			$sysMods = Yii::app()->settings->get('system_modules', 'system', array());
			$update = array(strtolower($moduleId) => array('enabled'=>$enabled));
			$sysMods = CMap::mergeArray($sysMods, $update);
			$sysMods = Yii::app()->settings->set('system_modules', $sysMods);
				
			echo CJSON::encode(array('success'=>'The "'.$m.'" module was successfully '.($enabled?'activated':'deactivated')));
			
		} catch(Exception $e) {
			echo CJSON::encode(array('error'=>'The module errored '.($state?'activated':'deactivated')));
		}
		
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