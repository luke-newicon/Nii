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
	
	public function init(){
		Yii::import('project.models.*');
	}
	
	public function setup(){
		Yii::app()->menus->addItem('main', 'Projects', array('/project/index'), null, array(
			'visible' => Yii::app()->user->checkAccess('menu-tasks'),
		));
		Yii::app()->menus->addItem('main', 'Tasks', array('/project/task'), null, array(
			'visible' => Yii::app()->user->checkAccess('menu-tasks'),
		));
//		Yii::app()->menus->addItem('main', 'Actions', array('/task/admin/actions'), 'Tasks', array(
//			'visible' => Yii::app()->user->checkAccess('task/admin/actions'),
//		));
//		Yii::app()->menus->addItem('main', 'Customers', array('/contact/customer/index'), Yii::app()->getModule('contact')->menu_label, array(
//			'visible' => Yii::app()->user->checkAccess('contact/customer/index'),
//		));
//		Yii::app()->menus->addItem('main', 'Suppliers', array('/contact/supplier/index'), Yii::app()->getModule('contact')->menu_label, array(
//			'visible' => Yii::app()->user->checkAccess('contact/supplier/index'),
//		));
//		Yii::app()->menus->addItem('main', 'Staff', array('/contact/staff/index'), Yii::app()->getModule('contact')->menu_label, array(
//			'visible' => Yii::app()->user->checkAccess('contact/staff/index'),
//		));
		
//		Yii::app()->getModule('project')->controllerMap = CMap::mergeArray(Yii::app()->controllerMap, array(
//			'project' => 'project.controllers.ProjectController',
//			'task' => 'project.controllers.TaskController',
//		));
		
	}
	
	public function install(){
		ProjectProject::install();
		ProjectTask::install();
		$this->installPermissions();
	}
	
	public function uninstall(){
		//NActiveRecord::uninstall('TaskTask');
	}
	
	public function activate(){
		
	}
	
	public function deactivate(){
		
	}
	
	public function menus(){
		
	}
	
	public function notifications(){
		
	}
	
	public function settings(){
		return array(
//			'projects' => '/project/settings/index',
		);
	}
	
	public function permissions() {
		return array(
			'task' => array('description' => 'Tasks',
				'tasks' => array(
					'view' => array('description' => 'View Tasks',
						'roles' => array('administrator','editor','viewer'),
						'operations' => array(
							'task/admin/tasks',
							'task/admin/viewTask',
							'menu-tasks',
						),
					),
					'manage' => array('description' => 'Add/Edit/Delete Tasks',
						'roles' => array('administrator','editor'),
						'operations' => array(
							'task/admin/addTask',
							'task/admin/editTask',
							'task/admin/deleteTask',
						),
					),
				),
			),
		);
	}

}