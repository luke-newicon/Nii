<?php 
/**
 * Kashflow API module
 * ===================
 * 
 * Allows you to import your customers form kashflow n stuff
 * 
 * Need to configure the following settings
 * 
 * - username (your kashflow username)
 * - password (your kashflow password)
 * 
 * **HAVE FUN**
 * 
 * 
 * @author Luke
 *
 */
Class KashflowModule extends CWebModule
{

	public $defaultController = 'index';
	/**
	 * 
	 * @var string
	 */
	public $username = 'newicon';     // username to access the API
	
	public $password = 'bonsan';     // password to access the API

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'kashflow.models.*',
			'kashflow.models.api.*',
			'kashflow.components.*',
		));

		if(!Yii::app()->user->isGuest)
			$this->addMenuItem('Kashflow', array('/kashflow/index/index'));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}