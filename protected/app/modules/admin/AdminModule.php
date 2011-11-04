<?php

class AdminModule extends NWebModule {

	public $name = 'Administration';
	public $description = 'Admin module for configuring the admin area';
	public $version = '1.0';

	public function init() {
		Yii::import('admin.components.*');
		Yii::import('admin.models.*');

		$adminMenu = new AdminMenu;
		$this->setComponent('menu', $adminMenu);

		$this->menu->addMenu('main');
		$this->menu->addMenu('secondary');

		$this->menu->addItem('secondary', 'Admin', '#', null, array(
			'visible' => Yii::app()->user->checkAccess('menu-admin'),
		));
		$this->menu->addItem('secondary', 'Settings', array('/admin/settings/index'), 'Admin', array(
			'visible' => Yii::app()->user->checkAccess('admin/settings/index'),
			'notice' => 7,
		));
		$this->menu->addItem('secondary', 'Notifications', array('/admin/notifications/index'), 'Admin', array(
			'visible' => Yii::app()->user->checkAccess('admin/notifications/index'),
		));
		$this->menu->addItem('secondary', 'Modules', array('/admin/modules/index'), 'Admin', array(
			'visible' => Yii::app()->user->checkAccess('admin/modules/index'),
			'notice' => 'ALERT',
			'noticeHtmlOptions' => array('class' => 'label important'),
		));
	}
	
	public function install(){
		$this->installPermissions();
	}

	public function settings() {
		return array(
			'general' => '/admin/settings/general',
			'presentation' => '/admin/settings/presentation',
		);
	}

	public function permissions() {
		return array(
			'admin' => array('description' => 'Admin',
				'tasks' => array(
					'modules' => array('description' => 'Manage Modules',
						'roles' => array('administrator'),
						'operations' => array(
							'admin/modules/index',
							'admin/modules/enable',
							'admin/modules/disable',
							'menu-admin',
						),
					),
					'settings' => array('description' => 'Manage Settings',
						'roles' => array('administrator'),
						'operations' => array(
							'admin/settings/index',
							'admin/settings/page',
							'admin/settings/general',
							'admin/settings/presentation',
							'menu-admin',
						),
					),
					'dashboard' => array('description' => 'Dashboard',
						'roles' => array('administrator','editor','viewer'),
						'operations' => array(
							'admin/index/index',
							'admin/index/dashboard',
						),
					),
				),
			),
		);
	}

}