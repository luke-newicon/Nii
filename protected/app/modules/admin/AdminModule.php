<?php

class AdminModule extends NWebModule {

	public $name = 'Administration';
	public $description = 'Admin module for configuring the admin area';
	public $version = '1.0';
	
	public $logo;
	public $menuAppname = true;
	public $topbarColor;
	public $h2Color = '#404040';
	public $h3Color = '#404040';
	public $menuSearch = false;

	public function init() {
		Yii::import('admin.components.*');
		Yii::import('admin.models.*');
	}
	
	public function setup(){
		Yii::app()->menus->addMenu('main');
		Yii::app()->menus->addMenu('secondary');

		Yii::app()->menus->addItem('secondary', 'Admin', '#', null, array(
			'visible' => Yii::app()->user->checkAccess('menu-admin'),
		));
		Yii::app()->menus->addItem('secondary', 'Upgrades', array('/admin/upgrades/index'), 'Admin', array(
			'visible' => Yii::app()->user->checkAccess('admin/upgrades/index'),
//			'notice' => 1,
		));
		Yii::app()->menus->addItem('secondary', 'Settings', array('/admin/settings/index'), 'Admin', array(
			'visible' => Yii::app()->user->checkAccess('admin/settings/index'),
//			'notice' => 7,
		));
		Yii::app()->menus->addItem('secondary', 'Notifications', array('/admin/notifications/index'), 'Admin', array(
			'visible' => Yii::app()->user->checkAccess('admin/notifications/index'),
		));
		Yii::app()->menus->addItem('secondary', 'Modules', array('/admin/modules/index'), 'Admin', array(
			'visible' => Yii::app()->user->checkAccess('admin/modules/index'),
//			'notice' => 'ALERT',
//			'noticeHtmlOptions' => array('class' => 'label important'),
		));
		
		Yii::app()->menus->addMenu('user');
		
		Yii::app()->menus->addItem('user','User','#');
		Yii::app()->menus->addItem('user','My Account',array('/user/admin/account'),'User',array('linkOptions'=>array('data-controls-modal'=>'modal-user-account','data-backdrop'=>'static')));
		Yii::app()->menus->addItem('user','Settings',array('/user/admin/settings'),'User');
		
		Yii::app()->menus->addDivider('secondary','Admin');
		Yii::app()->menus->addItem('secondary','Users',array('/user/admin/users'),'Admin',array(
			'visible' => Yii::app()->user->checkAccess('user/admin/users'),
		));
		Yii::app()->menus->addItem('secondary','Permissions',array('/user/admin/permissions'),'Admin',array(
			'visible' => Yii::app()->user->checkAccess('user/admin/permissions'),
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