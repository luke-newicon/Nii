<?php
/**
 * NWebModule class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
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
	
	
}