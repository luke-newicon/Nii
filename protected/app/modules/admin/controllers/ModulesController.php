<?php

Class ModulesController extends AController
{
	
	/**
	 * action to display a list of modules available to be enabled/disabled and installed.
	 */
	public function actionIndex(){
		
		$this->render('index', array('data'=>$this->moduleListData()));
	}
	
	/**
	 * Gathers an array suitable for a dataprovider 
	 * 
	 * @return array 
	 */
	public function moduleListData(){
		
		// get a list of all modules
		$allModules = Yii::app()->niiModulesAll;

		// get the list of modules currently defined in the settings
		$systemModules = Yii::app()->settings->get('system_modules', 'system', array());
		
		
		$coreModules = array('nii', 'user', 'admin');

		$data = array();
		foreach($allModules as $id => $module){
			// skip if the module is a core module
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
	 * Enables and activates a module
	 * 
	 * @param string $module the module id
	 */
	public function actionEnable($module){
		$this->updateModule($module, 1);
		$m = Yii::app()->activateModule($module);
		$m->install();
		
		Yii::app()->user->setFlash('success',"Module successfully enabled");
		$this->redirect(array('/admin/modules/index'));
	}
	
	/**
	 * Disables a module
	 * 
	 * @param string $module the modulde id
	 */
	public function actionDisable($module){
		$this->updateModule($module, 0);
		Yii::app()->user->setFlash('success',"Module successfully disabled");
		$this->redirect(array('/admin/modules/index'));
	}
	
	/**
	 * Enables or disables a module
	 * 
	 * @param string $module the module id
	 * @param int $enabled 
	 */
	public function updateModule($module, $enabled=0){
		// get the current module settings
		$sysMods = Yii::app()->settings->get('system_modules', 'system', array());
		// create the array format for the affected module
		$update = array(strtolower($module) => array('enabled'=>$enabled));
		// merge the update with the existing settings
		$sysMods = CMap::mergeArray($sysMods, $update);
		// save the settings back
		Yii::app()->settings->set('system_modules', $sysMods);
		// update yii's module configuration
		Yii::app()->configure(array('modules'=>$sysMods));
	}
	
	
}