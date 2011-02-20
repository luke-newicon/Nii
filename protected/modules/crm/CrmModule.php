<?php

class CrmModule extends CWebModule
{
	public $defaultController = 'index';

	/**
	 * Display contact name: First, Last
	 * @var boolean
	 */
	public $displayOrderFirstLast = false;
	/**
	 * Dislay contact name: Last, First
	 * @var boolean
	 */
	public $displayOrderLastFirst = true;
	/**
	 * Sort contact by name: First, Last
	 * @var boolean
	 */
	public $sortOrderFirstLast = false;
	/**
	 * Sort contact by name: Last, First
	 * @var bollean
	 */
	public $sortOrderLastFirst = true;
	
	private $_assetsUrl;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'crm.models.*',
			'crm.components.*',
		));
	}

	/**
	 * @return string the base URL that contains all published asset files of crm.
	 */
	public function getAssetsUrl()
	{
		if($this->_assetsUrl===null)
			$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('crm.assets'));
		return $this->_assetsUrl;
	}


	public function install(){
//		Newicon_Db_Table::install('Nworx_Crm_Model_Contacts');
//		Newicon_Db_Table::install('Nworx_Crm_Model_Emails');
//		Newicon_Db_Table::install('Nworx_Crm_Model_Phones');
//		Newicon_Db_Table::install('Nworx_Crm_Model_Websites');
//		Newicon_Db_Table::install('Nworx_Crm_Model_Addresses');
	}

	public function uninstall(){

	}

	/**
	 *
	 * @return CrmModule
	 */
	public static function get(){
		return yii::app()->getModule('crm');
	}

}
