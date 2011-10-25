<?php

class TestModule extends NWebModule {

	public $name = 'Test';
	public $description = 'Lukes test module for testing lots of good module stuff';
	public $version = '0.0.1b';

	public function init() {
		Yii::import('test.models.*');
		Yii::app()->getModule('admin')->menu->addItem('Test Module', array('/test/index/index'));
		Yii::app()->getModule('admin')->menu->addItem('First page', array('/test/index/index'), 'Test Module');
		Yii::app()->getModule('admin')->menu->addItem('Good page', array('/test/index/good'), 'Admin');
		Yii::app()->getModule('admin')->menu->addItem('Test Dashboard', array('/test/index/dashboard'), 'Home');
	}

	public function settings() {
		return array(
			'My test settings' => array('/test/settings'),
		);
	}

}