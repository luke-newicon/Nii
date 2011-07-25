<?php

/**
 * ProjecyModule class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ProjecyModule
 *
 * @author steve
 */
class ProjectModule extends NWebModule
{

	/**
	 * the link fed into NHtml::Url for the preview experience
	 */
	public $shareLink = '/project/view/index/h';
	
	public function init(){
		
		$this->setImport(array(
			'project.models.*',
			'project.components.*',
		));
		
		// relies on the image component NImage
		Yii::app()->image->addType('projectThumb',array(
			'resize' => array('width'=>198, 'height'=>158, 'master'=>'width', 'scale'=>'down'),
			'crop'  => array('width'=>198, 'height'=>158, 'left'=>'center', 'top'=>'top'),
			'noimage'=>Yii::getPathOfAlias('project.assets.add-screens').'.png'
		));
		
		Yii::app()->image->addType('projectSidebarThumb',array(
			'resize' => array('width'=>300, 'height'=>400, 'master'=>'width', 'scale'=>'down'),
			//'crop'  => array('width'=>198, 'height'=>158, 'left'=>'center', 'top'=>'top'),
			//'noimage'=>Yii::getPathOfAlias('project.assets.add-screens').'.png'
		));
		
		if(!Yii::app()->user->isGuest)
			$this->addMenuItem(CHtml::image(Yii::app()->baseUrl.'/images/book.png', 'CRM'), array('/project/index/index'));
		
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(!Yii::app()->getRequest()->getIsAjaxRequest()){
				Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl().'/jquery.flip.min.js');
				Yii::app()->clientScript->registerCssFile($this->getAssetsUrl().'/project.css');
			}
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function install(){
		Project::install();
		ProjectScreen::install();
		ProjectHotSpot::install();
		ProjectTemplate::install();
		ProjectScreenTemplate::install();
		ProjectComment::install();
		ProjectLink::install();
	}
	
	/**
	 *
	 * @return ProjectModule
	 */
	public static function get(){
		return Yii::app()->getModule('project');
	}
	
	
}