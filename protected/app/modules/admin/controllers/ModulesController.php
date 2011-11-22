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
		$allModules = Yii::app()->modulesAvailable;

		// get the list of modules currently defined in the settings
		$systemModules = Yii::app()->modules;
		

		$data = array();
		foreach($allModules as $id => $module){
			// skip if the module is a core module
			if(Yii::app()->isCoreModule($id))
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
	 * store the current module being enabled or disabled.
	 * @var string the module id. 
	 */
	public $currentModule;
	
	/**
	 * Enables and activates a module
	 * 
	 * @param string $module the module id
	 */
	public function actionEnable($module){
		$this->currentModule = $module;
		Yii::app()->attachEventHandler('onError', array($this, 'handleModulePhpError'));
		try {
			Yii::app()->updateModule($this->currentModule, 1);
			
			$m = Yii::app()->activateModule($this->currentModule);

			Yii::app()->user->setFlash('success',"Module successfully enabled");
			
		} catch(Exception $e){
			Yii::app()->updateModule($this->currentModule, 0);
			Yii::app()->user->setFlash('error',"Unable to load the '$module' module. ");
			if (YII_DEBUG){
				ob_start();
				Yii::app()->displayException($e);
				$errorHtml = ob_get_clean();
				$msg = '<strong>'.$e->getMessage().'</strong>';
				$msg .= ' <a class="label warning" href="#" onclick="jQuery(\'#exception-error-details\').toggle();return false;">Show Error Details</a>'."<div style=\"display:none;\" id=\"exception-error-details\">$errorHtml</div>";
				Yii::app()->user->setFlash('error-block-message', $msg);
			}
						//"PHP error message: {$e->getMessage()}, <br /> File: {$e->getFile()} <br /> Line: {$e->getLine()}");
		}
		$this->redirect(array('/admin/modules/index'));
	}
	
	/**
	 * Handles the onError event raised by Yii::app() if there is a php execution error in the module
	 * being enabled / disabled
	 * @param CErrorEvent $event 
	 */
	public function handleModulePhpError($event){
		$event->handled = true;
		// the module raised a php error so we want to disable the module.
		Yii::app()->updateModule($this->currentModule, 0);
		Yii::app()->user->setFlash('error',"Module caused an error");
		if (YII_DEBUG){
			ob_start();
			Yii::app()->displayError($event->code, $event->message, $event->file, $event->line);
			$errorHtml = ob_get_clean();
			$msg = '<strong>'.$event->message.'</strong>';
			$msg .= ' <a class="label warning" href="#" onclick="jQuery(\'#exception-error-details\').toggle();return false;">Show Error Details</a>'."<div style=\"display:none;\" id=\"exception-error-details\">$errorHtml</div>";
			Yii::app()->user->setFlash('error-block-message', $msg);
		}
		$this->redirect(array('/admin/modules/index'));
	}
	
	/**
	 * Disables a module
	 * 
	 * @param string $module the modulde id
	 */
	public function actionDisable($module){
		Yii::app()->updateModule($module, 0);
		Yii::app()->user->setFlash('success',"Module successfully disabled");
		$this->redirect(array('/admin/modules/index'));
	}
	
	
}