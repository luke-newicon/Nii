<?php
/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link https://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
class ProjectModule extends NWebModule
{

	public $name = 'Projects';
	public $description = 'Project management module';
	public $version = '0.0.1';
	
	public function init()
	{
		Yii::import('project.models.*');
		
		Yii::app()->urlManager->addRules(array(
				array('/project/api/createProject', 'pattern' => 'api/project'),
				array('/project/project/index', 'pattern' => 'project/<project:\d>'),
			), false
		);
	}
	
	public function setup()
	{
		Yii::app()->menus->addItem('main', 'Projects', array('/project/index'), null, array(
			'visible' => Yii::app()->user->checkAccess('menu-tasks'),
		));
		
		Yii::app()->sprite->addImageFolderPath(Yii::getPathOfAlias('project.images'));
	}
	
	public function install()
	{
		NActiveRecord::install('ProjectTask');
	}
	
	public function uninstall()
	{
		NActiveRecord::uninstall('ProjectTask');
	}
	
}