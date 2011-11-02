<?php
/**
 * NWebModule class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/*
Plugin Name: WordPress Importer
Plugin URI: http://wordpress.org/extend/plugins/wordpress-importer/
Description: Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.
Author: wordpressdotorg
Author URI: http://wordpress.org/
Version: 0.5
Text Domain: wordpress-importer
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/


/**
 * Description of NWebModule
 * 
 * NWebModule allows modules to be understood in the grander scheme of an application.
 * Modules have an install and uninstall function to manage database table installation and module setup.
 * Helper to publish module specific assets.
 * 
 *
 *
 * @author steve
 */
class NWebModule extends CWebModule
{
    public $defaultController = 'index';
	
	/**
	 * enabled property, yii's config accepts a config parameter.
	 * 
	 * @var boolean
	 */
	public $enabled;
	
	private $_id;
	/**
	 * During module activation we want to access module info but not call the modules init function
	 * 
	 * @param type $id
	 * @param type $parent
	 * @param type $config 
	 */
	public function __construct($id, $parent, $config = null, $activate=true) {
		// if activate is false don't bother setting up the module officially
		// during module activation we want an instance of the module that we can use
		// but that does not set its self up and call its init functions or attach to the application
		$this->_id = $id;
		if($activate)
			parent::__construct($id, $parent, $config);
	}
	
	/**
	 * preInit is used to load in the database specific settings.
	 * Thus the init function has access to all module settings.
	 */
	public function preinit() {
		parent::preinit();
		$this->loadSettings();
	}
	
	/**
	 * stores the module.assets url
	 * @var type 
	 */
	private $_assetsUrl;
	
	/**
	 * Will publish a modules asset folder and return the url
	 * the assets folder should be in the root level of the module e.g. modules/user/asssets
	 * @return string the base URL to modules assets folder
	 */
	public function getAssetsUrl()
	{
		if($this->_assetsUrl===null)
			$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($this->getName().'.assets'));
		return $this->_assetsUrl;
	}

	
	public function install(){}
	
	public function uninstall(){}
	
	public function settings(){
		return array();
	}
	
	public function permissions(){
		return array();
	}
	
//	public function settingsPage(){
//		if(method_exists($this,'settings') && $this->settings()){
//			$modelname = ucwords($this->id).'Setting';
//			$model = new $modelname;
//			
//			$config = array(
//				'id' => $modelname.'Form',
//				'elements' => $this->settings(),
//				'buttons' => array(
//					'save'=> array(
//						'type' => 'submit',
//						'label' => 'Save',
//					),
//				),
//			);
//			
//			$form = new CForm($config,$model);
//			return $form;
//		} else {
//			return 'No settings for this module';
//		}
//	}
//	
//	public function getSettingsPage(){
//		return array('/admin/settings/page','module'=>$this->id);
//	}
	
	/**
	 * loads the modules database settings and applies them to the module.
	 * This function is called automatically when loading activated modules.  
	 * With core modules it is manually triggered in the preInit function.
	 * All configuration should be loaded before the init function
	 * @return void
	 */
	public function loadSettings(){
		$moduleConfig = Yii::app()->settings->get('system_modules', 'system', array());
		if(array_key_exists($this->id, $moduleConfig)){
			$this->configure($moduleConfig[$this->id]);
		}
	}
	
	
	public function getName(){
		return $this->_id;
	}
	
	public function installPermissions(){
		if(!Yii::app()->authManager->getAuthItem('task-admin-permissions'))
			Yii::app()->authManager->createTask('task-admin-permissions', 'Admin Permissions');
		foreach($this->permissions() as $id => $permissions){
			if(!Yii::app()->authManager->getAuthItem('task-'.$id))
				Yii::app()->authManager->createTask('task-'.$id, $permissions['description']);
			if(!Yii::app()->authManager->hasItemChild('task-admin-permissions', 'task-'.$id))
				Yii::app()->authManager->addItemChild('task-admin-permissions', 'task-'.$id);
			foreach($permissions['tasks'] as $taskName => $task){
				if(!Yii::app()->authManager->getAuthItem('task-'.$id.'-'.$taskName)){
					Yii::app()->authManager->createTask('task-'.$id.'-'.$taskName, $task['description']);
					if(!Yii::app()->authManager->hasItemChild('task-'.$id, 'task-'.$id.'-'.$taskName))
						Yii::app()->authManager->addItemChild('task-'.$id, 'task-'.$id.'-'.$taskName);
					// Only apply tasks to roles if the task doesn't exist
					foreach($task['roles'] as $role){
						if(Yii::app()->authManager->getAuthItem('role-'.$role)){
							if(!Yii::app()->authManager->hasItemChild('role-'.$role, 'task-'.$id.'-'.$taskName))
								Yii::app()->authManager->addItemChild('role-'.$role, 'task-'.$id.'-'.$taskName);
						}
					}
				}
				foreach($task['operations'] as $operation){
					if(!Yii::app()->authManager->getAuthItem($operation))
						Yii::app()->authManager->createOperation($operation);
					if(!Yii::app()->authManager->hasItemChild('task-'.$id.'-'.$taskName, $operation))
						Yii::app()->authManager->addItemChild('task-'.$id.'-'.$taskName, $operation);
				}
			}
		}
	}
	
}