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
		
		$this->menu->addItem('secondary','Admin','#');
		$this->menu->addItem('secondary','Modules',array('/admin/modules/index'),'Admin',array('notice'=>'ALERT','noticeHtmlOptions'=>array('class'=>'menu-notice label important')));
		$this->menu->addItem('secondary','Settings',array('/admin/settings/index'),'Admin',array('notice'=>7));
	}
	
	public function settings(){
		return array(
			'General' => array('/admin/settings/general'),
			'Presentation' => array('/admin/settings/presentation'),
		);
	}

}