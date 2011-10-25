<?php

Class ModulesController extends AController
{
	
	/**
	 * action to display a list of modules available to be activated and installed.
	 */
	public function actionIndex(){
		
		$this->render('index', array('data'=>$this->moduleListData()));
	}
	
	
	public function moduleListData(){
		
		// get a list of all modules
		$allModules = Yii::app()->niiModulesAll;

		// get the list of modules currently defined in the settings
		$systemModules = Yii::app()->settings->get('system_modules', 'system', array());
		
		
		$coreModules = array(
			'nii', 'user', 'admin'
		);

		$data = array();
		foreach($allModules as $id => $module){
			if(in_array($id, $coreModules))
				continue;
			$data[] = array(
				'id' => $id,
				'name'=>$module->name,
				'description' => $module->description,
				'version' => $module->version,
				'enabled' => array_key_exists($id, $systemModules) ? $systemModules[$id]['enabled'] : 0
			);
		}
		
		return $data;

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
				
			echo CJSON::encode(array('success'=>'The "'.$m->name.'" module was successfully '.($enabled?'activated':'deactivated')));
			
		} catch(Exception $e) {
			echo CJSON::encode(array('error'=>'The module errored '.($state?'activated':'deactivated')));
		}
		
	}
	
	
}