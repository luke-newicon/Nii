<?php

class CrmModule extends NWebModule
{
	

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
		if(!Yii::app()->user->isGuest)
			$this->addMenuItem('Crm', array('/crm/index/index'));
		
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
		
		$auth=Yii::app()->authManager;
		$auth->createTask('createSomething','create a something');
		$auth->createTask('createContact','create a new contact record');
		
		$auth->getAuthItem('authenticated')
			->addChild('createSomething','create a something');
		
		
//		//echo 'hello?';
//		$sqlFile = Yii::getPathOfAlias('crm.data').DS.'schema.mysql.sql';
//		$sql = file_get_contents($sqlFile);
//		dp($sql);
//		$c = new CrmContact('install');
//		
//		$def = $c->definition();
//		dp($def);
//		Yii::app()->db->createCommand()->createTable(
//			$c->tableName(), 
//			$def['columns'],
//			$def['extra']
//		);
//		foreach($def['keys'] as $i=>$v){
//			Yii::app()->db->createCommand()->createIndex($v[0], $c->tableName(), $v[1]);
//		}
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
