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

	public function init(){
		
		$this->setImport(array(
			'project.models.*',
			'project.components.*',
		));
		
		// relies on the image component NImage
		Yii::app()->image->addType('projectThumb',array(
			'resize' => array('width'=>198, 'height'=>158, 'master'=>'width', 'scale'=>'down'),
			'crop'  => array('width'=>198, 'height'=>158, 'left'=>'center', 'top'=>'top')
		));
		
		if(!Yii::app()->user->isGuest)
			$this->addMenuItem(CHtml::image(Yii::app()->baseUrl.'/images/book.png', 'CRM'), array('/project/index/index'));
	}
	
	public function install(){
		Project::install();
		ProjectScreen::install();
		ProjectHotSpot::install();
	}
	
	/**
	 *
	 * @return ProjectModule
	 */
	public static function get(){
		return Yii::app()->getModule('project');
	}
}