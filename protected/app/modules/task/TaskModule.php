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
		Yii::import('task.models.*');
	}
	
	public function setup(){
		Yii::app()->menus->addItem('main', 'Tasks', '#', null, array(
			'visible' => Yii::app()->user->checkAccess('menu-tasks'),
		));
		Yii::app()->menus->addItem('main', 'Tasks', array('/task/admin/tasks'), 'Tasks', array(
			'notice' => TaskTask::model()->count(),
			'visible' => Yii::app()->user->checkAccess('task/admin/tasks'),
		));
//		Yii::app()->menus->addItem('main', 'Actions', array('/task/admin/actions'), 'Tasks', array(
//			'visible' => Yii::app()->user->checkAccess('task/admin/actions'),
//		));
	}
	
	public function install(){
		TaskTask::install();
		$tasks = TaskTask::model()->findAll();
		if(empty($tasks)){
			$task = new TaskTask;
			$task->name = 'My sample task';
			$task->description = 'This task is a sample to show how the task system works';
			$task->priority = 4;
			$task->importance = 6;
			$task->finish_date = '2011-10-11';
			$task->owner = 'Steve O\'Brien';
			$task->save();
		}
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
			'tasks' => 'tasks/settings',
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