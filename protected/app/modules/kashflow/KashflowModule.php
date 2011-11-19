<?php
/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link https://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
class KashflowModule extends NWebModule
{
	
	public $name = 'Kashflow';
	public $description = 'Interface with a Kashflow account';
	public $version = '0.0.1';
	
	public $username;
	public $password;
	
	public function init(){
		Yii::import('kashflow.components.*');
		Yii::import('kashflow.models.*');
	}
	
	public function setup(){
		Yii::app()->menus->addItem('main', 'Kashflow', '#', null, array(
			'visible' => Yii::app()->user->checkAccess('menu-kashflow'),
		));
		Yii::app()->menus->addItem('main', 'Customers', array('/kashflow/admin/customers'), 'Kashflow', array(
			'visible' => Yii::app()->user->checkAccess('kashflow/admin/customers'),
		));
		Yii::app()->menus->addItem('main', 'Quotes', array('/kashflow/admin/quotes'), 'Kashflow', array(
			'visible' => Yii::app()->user->checkAccess('kashflow/admin/quotes'),
		));
		Yii::app()->menus->addItem('main', 'Invoices', array('/kashflow/admin/invoices'), 'Kashflow', array(
			'visible' => Yii::app()->user->checkAccess('kashflow/admin/invoices'),
		));
		Yii::app()->menus->addItem('main', 'Suppliers', array('/kashflow/admin/suppliers'), 'Kashflow', array(
			'visible' => Yii::app()->user->checkAccess('kashflow/admin/suppliers'),
		));
		Yii::app()->menus->addItem('main', 'Receipts', array('/kashflow/admin/receipts'), 'Kashflow', array(
			'visible' => Yii::app()->user->checkAccess('kashflow/admin/receipts'),
		));
	}
	
	public function install(){
		$this->installPermissions();
	}
	
	public function uninstall(){
		
	}
	
	public function settings(){
		return array(
			'kashflow' => '/kashflow/settings/index',
		);
	}
	
	public function permissions() {
		return array(
//			'task' => array('description' => 'Tasks',
//				'tasks' => array(
//					'view' => array('description' => 'View Tasks',
//						'roles' => array('administrator','editor','viewer'),
//						'operations' => array(
//							'task/admin/tasks',
//							'task/admin/viewTask',
//							'menu-tasks',
//						),
//					),
//					'manage' => array('description' => 'Add/Edit/Delete Tasks',
//						'roles' => array('administrator','editor'),
//						'operations' => array(
//							'task/admin/addTask',
//							'task/admin/editTask',
//							'task/admin/deleteTask',
//						),
//					),
//				),
//			),
		);
	}
}