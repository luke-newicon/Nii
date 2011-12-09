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
	
	public function init(){
		Yii::import('task.models.*');
	}
	
	public function setup(){
		Yii::app()->menus->addItem('main', 'Tasks', '#', null, array(
			'visible' => Yii::app()->user->checkAccess('menu-tasks'),
		));
		Yii::app()->menus->addItem('main', 'Projects', array('/task/admin/projects'), 'Tasks', array(
			'visible' => Yii::app()->user->checkAccess('task/admin/projects'),
		));
		Yii::app()->menus->addItem('main', 'Tasks', array('/task/admin/tasks'), 'Tasks', array(
//			'notice' => TaskTask::model()->count(),
			'visible' => Yii::app()->user->checkAccess('task/admin/tasks'),
		));
		Yii::app()->menus->addItem('main', 'Actions', array('/task/admin/actions'), 'Tasks', array(
			'visible' => Yii::app()->user->checkAccess('task/admin/actions'),
		));
		Yii::app()->menus->addItem('main', 'Customers', array('/contact/customer/index'), Yii::app()->getModule('contact')->menu_label, array(
			'visible' => Yii::app()->user->checkAccess('contact/customer/index'),
		));
		Yii::app()->menus->addItem('main', 'Suppliers', array('/contact/supplier/index'), Yii::app()->getModule('contact')->menu_label, array(
			'visible' => Yii::app()->user->checkAccess('contact/supplier/index'),
		));
		Yii::app()->menus->addItem('main', 'Staff', array('/contact/staff/index'), Yii::app()->getModule('contact')->menu_label, array(
			'visible' => Yii::app()->user->checkAccess('contact/staff/index'),
		));
		
		Yii::app()->getModule('contact')->controllerMap = CMap::mergeArray(Yii::app()->controllerMap, array(
			'customer' => 'task.controllers.CustomerController',
			'supplier' => 'task.controllers.SupplierController',
			'staff' => 'task.controllers.StaffController',
		));
		
		Yii::app()->getModule('contact')->relations = CMap::mergeArray(Yii::app()->getModule('contact')->relations, array(
			'Contact' => array(
				'customer' => array(
					'label' => 'Customer',
					'class' => 'ContactCustomer',
					'relation' => array(Contact::HAS_ONE, 'ContactCustomer', 'contact_id'),
					'notification' => false,
					'viewRoute' => '/contact/customer/view',
					'addRoute' => '/contact/customer/add',
					'isAddable' => true,
				),
				'supplier' => array(
					'label' => 'Supplier',
					'class' => 'ContactSupplier',
					'relation' => array(Contact::HAS_ONE, 'ContactSupplier', 'contact_id'),
					'notification' => false,
					'viewRoute' => '/contact/supplier/view',
					'addRoute' => '/contact/customer/add',
					'isAddable' => true,
				),
				'staff' => array(
					'label' => 'Staff',
					'class' => 'ContactStaff',
					'relation' => array(Contact::HAS_ONE, 'ContactStaff', 'contact_id'),
					'notification' => false,
					'viewRoute' => '/contact/staff/view',
					'addRoute' => '/contact/customer/add',
					'isAddable' => true,
				),
			),
		));
	}
	
	public function install(){
//		TaskItem::install();
//		TaskItemChild::install();
//		TaskAssignment::install();
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
		TaskProject::install();
		TaskAction::install();
		ContactCustomer::install();
		ContactSupplier::install();
		ContactStaff::install();
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
			'tasks' => '/task/settings/index',
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
			'customer' => array('description' => 'Customers',
				'tasks' => array(
					'view' => array('description' => 'View Customers',
						'roles' => array('administrator','editor','viewer'),
						'operations' => array(
							'contact/customer/index',
							'contact/customer/view',
						),
					),
					'manage' => array('description' => 'Add/Edit/Delete Customers',
						'roles' => array('administrator','editor'),
						'operations' => array(
							'contact/customer/add',
							'contact/customer/edit',
							'contact/customer/delete',
						),
					),
				),
			),
			'supplier' => array('description' => 'Suppliers',
				'tasks' => array(
					'view' => array('description' => 'View Suppliers',
						'roles' => array('administrator','editor','viewer'),
						'operations' => array(
							'contact/supplier/index',
							'contact/supplier/view',
						),
					),
					'manage' => array('description' => 'Add/Edit/Delete Suppliers',
						'roles' => array('administrator','editor'),
						'operations' => array(
							'contact/supplier/add',
							'contact/supplier/edit',
							'contact/supplier/delete',
						),
					),
				),
			),
			'staff' => array('description' => 'Staff',
				'tasks' => array(
					'view' => array('description' => 'View Staff',
						'roles' => array('administrator','editor','viewer'),
						'operations' => array(
							'contact/staff/index',
							'contact/staff/view',
						),
					),
					'manage' => array('description' => 'Add/Edit/Delete Staff',
						'roles' => array('administrator','editor'),
						'operations' => array(
							'contact/staff/add',
							'contact/staff/edit',
							'contact/staff/delete',
						),
					),
				),
			),
		);
	}

}