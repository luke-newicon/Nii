<?php

class TestModule extends NWebModule {

	public $name = 'Test';
	public $description = 'Lukes test module for testing lots of good module stuff';
	public $version = '0.0.1b';

	public function init() {
		Yii::import('test.models.*');
		Yii::app()->getModule('admin')->menu->addItem('main', 'Test Module', array('/test/index/index'));
		Yii::app()->getModule('admin')->menu->addItem('main', 'First page', array('/test/index/index'), 'Test Module');
		Yii::app()->getModule('admin')->menu->addItem('secondary', 'Good page', array('/test/index/good'), 'Admin');
		Yii::app()->getModule('admin')->menu->addItem('main', 'Test Dashboard', array('/test/index/dashboard'), 'Home');
		Yii::app()->getModule('admin')->menu->addItem('user', 'Test User Settings', array('/test/index/good'), 'User');
	}

	public function settings() {
		return array(
			'Test' => array('/test/settings/index'),
		);
	}

	public function permissions() {
		return array(
			'test' => array('label' => 'Test Module', 'roles' => array('admin','edit','view'), 'items' => array(
				'test/index/index' => array('label' => 'The test module main page', 'roles' => array('admin','edit','view')),
				'test/index/good' => array('label' => 'The test module good page', 'roles' => array('admin','edit')),
				'test/settings/index' => array('label' => 'The test module settings page', 'roles' => array('admin')),
			)),
		);
	}

	public function install() {
		
	}

	public function uninstall() {
		
	}

}