<?php

class ProjectModule extends NWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'project.models.*',
			'project.components.*',
		));

		$basePath = yii::app()->getBasePath();
		$assets = new CAssetManager;
		$projectCss = $assets->publish($basePath.DS.'..'.DS.'modules'.DS.'project'.DS.'files');
		yii::app()->getClientScript()->registerCssFile($projectCss.DS.'project.css');

		if(!Yii::app()->user->isGuest)
			$this->addMenuItem(CHtml::image(Yii::app()->baseUrl.'/images/book.png', 'CRM'), array('/project/index/index'));
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
