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
		
		$this->menu->addItem('Home',array('/admin/index/dashboard'));
		$this->menu->addItem('Dashboard',array('/admin/index/dashboard'),'Home');
		$this->menu->addItem('Admin',array('/admin/modules/index'));
		$this->menu->addItem('Modules',array('/admin/modules/index'),'Admin');
		$this->menu->addItem('Settings',array('/admin/settings/index'),'Admin');
	}
	
	public function settings(){
		return array(
			'General' => array('/admin/settings/general'),
			'Presentation' => array('/admin/settings/presentation'),
		);
	}

}