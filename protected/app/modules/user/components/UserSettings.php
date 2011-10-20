<?php

/**
 * Settings class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Helper class to modify settings for the current user
 * 
 * DEPENDS:
 * - Depends on settings (NSettings) being defined as an application component with key "settings"
 *
 * @author steve
 */
class UserSettings extends CComponent {
	
	protected static $_singleton;
	
	/**
	 * singleton instanciation method
	 * @return Settings 
	 */
	public function getInstance(){
		if(self::$_singleton===null)
			self::$_singleton = new UserSettings;
		return self::$_singleton;
	}
	
	private function __construct() {
		if(Yii::app()->getComponent('settings') === null)
			throw new CException('User setting requires NSettings to be configured as an application component with the key "settings"');
	}
	
	public function getCategory(){
		return 'user_'.Yii::app()->user->id;
	}
	
	public function get($key, $default=null){
		return Yii::app()->settings->get($key, $this->getCategory(), $default);
	}
	
	public function set($key, $value){
		return Yii::app()->settings->set($key, $value, $this->getCategory());
	}
	
	public function getAll(){
		return Yii::app()->settings->get(null, $this->getCategory());
	}
}