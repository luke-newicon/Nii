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
	
	public function settingsPage(){
		if(method_exists($this,'settings') && $this->settings()){
			$config['elements'] = $this->settings();
			$model = new Setting;
			$form = new CForm($config,$model);
			//echo $form;
		} else {
			return 'No settings for this module';
		}
	}
	
	public function getSettingsPage(){
		return array('/admin/settingsPage','module'=>$this->name);
	}
	
	/**
	 * loads the modules database settings and applies them to the module.
	 * This function is called automatically when loading activated modules.  
	 * With core modules it is manually triggered in the preInit function.
	 * All configuration should be loaded before the init function
	 * @return void
	 */
	public function loadSettings(){
		if(($config = Yii::app()->settings->get(__CLASS__)) !== null)
			$this->configure($config);
	}
	
	public static function getNiiModules(){
		Yii::beginProfile('getModules');
		$modFiles = CFileHelper::findFiles(Yii::getPathOfAlias('modules'),array('fileTypes'=>array('php'), 'level'=>1));
		$mods = array();
		foreach($modFiles as $m){
			$modName = basename($m);
			if (!strpos($modName, 'Module'))
				continue;
			$mod = str_replace('.php','',$modName);
			$configFile = dirname($m).DS.'config'.DS.'config.php';
			$config = array();
			if(file_exists($configFile)){
				$config = include($configFile); 
			}
			$mods[$mod] = $config;
		}
		Yii::endProfile('getModules');
		return $mods;
	}
	
	
	
}