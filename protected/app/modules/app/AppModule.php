<?php

class AppModule extends NWebModule {

	public $name = 'Applications';
	public $description = 'Trying a concept of an applications module that organises modules per user';
	public $version = '0.0.1b';

	public function init() {
		Yii::app()->getModule('admin')->menu->addItem('main','Applications', array('/app/admin/index'));
		Yii::app()->getModule('admin')->menu->addItem('main','Task Manager', array('/task/index/index'),'Applications');
		Yii::app()->getModule('admin')->menu->addDivider('main','Applications');
		Yii::app()->getModule('admin')->menu->addItem('main','Show all apps', array('/app/admin/index'),'Applications');
	}

	public function settings() {
		return array(
			'applications' => '/app/settings/index',
		);
	}
	
	public function install(){}
	
	public function uninstall(){}

}