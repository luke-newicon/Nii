<?php

class TestModule extends NWebModule {

	public $name = 'Test';
	public $description = 'Lukes test module for testing lots of good module stuff';
	public $version = '0.0.1b';

	public function init() {
		Yii::import('test.models.*');
		Yii::app()->getModule('admin')->menu->addItem('main', 'Test Module', array('/test/index/index'));
		Yii::app()->getModule('admin')->menu->addItem('main', 'First page', array('/test/index/index'), 'Test Module');
		Yii::app()->getModule('admin')->menu->addDivider('secondary','Admin');
		Yii::app()->getModule('admin')->menu->addItem('secondary', 'Good page', array('/test/index/good'), 'Admin');
		Yii::app()->getModule('admin')->menu->addItem('main', 'Test Dashboard', array('/test/index/dashboard'), 'Home');
		Yii::app()->getModule('admin')->menu->addItem('user', 'Test User Settings', array('/test/index/good'), 'User');
	}

	public function settings() {
		return array(
			'test' => '/test/settings/index',
			'test2' => array(
				'label' => 'Another Test',
				'url' => array('/test/settings/index'),
			),
		);
	}

//	public function permissions() {
//		return array(
//			'test' => array('label' => 'Test Module', 'roles' => array('Administrator','Editor','Viewer'), 'items' => array(
//				'test/index/index' => array('label' => 'The test module main page', 'roles' => array('Administrator','Editor','Viewer')),
//				'test/index/good' => array('label' => 'The test module good page', 'roles' => array('Administrator','Editor')),
//				'test/settings/index' => array('label' => 'The test module settings page', 'roles' => array('Administrator')),
//			)),
//		);
//	}

	public function install() {
		
	}

	public function uninstall() {
		
	}

}