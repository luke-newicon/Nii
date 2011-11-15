<?php

/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */


Class ProjectModule extends NWebModule 
{
	public $name = 'Project Management';
	public $description = 'Newicon Project Management Module';
	public $version = '0.0.1';
	//public $settingsPage = array('tasks/settings');
	
	public function init(){
		
	}
	
	public function setup(){
		
		Yii::app()->menus->addItem('main', 'Projects', array('/project/admin/index'), null, array(
			'visible' => Yii::app()->user->checkAccess('menu-projects'),
		));
		
		Yii::app()->menus->addItem('main', 'Another', array('/project/admin/index'), null, array(
			'visible' => Yii::app()->user->checkAccess('menu-projects'),
		));
	}
	
}