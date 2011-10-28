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
		
		$this->menu->addItem('secondary','Admin',array('/admin/modules/index'));
		$this->menu->addItem('secondary','Modules',array('/admin/modules/index'),'Admin');
		$this->menu->addItem('secondary','Settings',array('/admin/settings/index'),'Admin');
		$this->menu->addItem('secondary','Luke Spencer',array('/user/account/index'));
		$this->menu->addItem('secondary','Account',array('/user/admin/account'),'Luke Spencer');
		$this->menu->addItem('secondary','Settings',array('/user/account/settings'),'Luke Spencer');
	}
	
	public function settings(){
		return array(
			'General' => array('/admin/settings/general'),
			'Presentation' => array('/admin/settings/presentation'),
		);
	}

}