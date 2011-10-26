<?php

class TestModule extends NWebModule {

	public $name = 'Test';
	public $description = 'Lukes test module for testing lots of good module stuff';
	public $version = '0.0.1b';

	public function init() {
		Yii::import('test.models.*');
		Yii::app()->getModule('admin')->menu->addItem('main','Test Module', array('/test/index/index'));
		Yii::app()->getModule('admin')->menu->addItem('main','First page', array('/test/index/index'), 'Test Module');
		Yii::app()->getModule('admin')->menu->addItem('secondary','Good page', array('/test/index/good'), 'Admin');
		Yii::app()->getModule('admin')->menu->addItem('main','Test Dashboard', array('/test/index/dashboard'), 'Home');
		Yii::app()->getModule('admin')->menu->addItem('secondary','Test User Settings', array('/test/index/good'), 'Luke Spencer');
	}

	public function settings() {
		return array(
			'test' => array('/test/settings'),
		);
	}

}