<?php
/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link https://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
class TaskModule extends NWebModule
{

	
	public $name = 'Tasks';
	public $description = 'Task management module';
	public $version = '0.0.1';
	public $settingsPage = array('tasks/settings');
	
	public function init(){
		// register menu items
		// Yii::app()->getModule('admin')->registerMenuItem('Tasks');
		// $this->menu('admin')->addItem('Task',array('tasks/index'),'Admin',array('before'=>'settings'));
	}
	
	
	
	public function settings(){
		return array('tasks/settings');
	}
	
	public function install(){
		NActiveRecord::install('TaskTask');
	}
	
	public function uninstall(){
		NActiveRecord::uninstall('TaskTask');
	}
	
	
	
	public function getMenu(){
		return array(
			'admin' => array(
				'Tasks'=>array(
					'url'=>'tasks/index/index',
					'items'=>array())
			)
		);
	}
	
	
	

}