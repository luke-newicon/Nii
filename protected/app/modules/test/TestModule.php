<?php

class TestModule extends NWebModule {

	public $name = 'Test';
	public $description = 'Lukes test module for testing lots of good module stuff';
	public $version = '0.0.1b';

	public function init() {
		Yii::import('test.components.*');
		Yii::import('test.models.*');
		Yii::import('test.models.db.*');
		Yii::import('test.models.grid.*');
		Yii::import('test.models.form.*');
		
		Yii::app()->menus->addItem('main', 'Test Module', '#');
		Yii::app()->menus->addItem('main', 'Grid', array('/test/index/grid'), 'Test Module');
		Yii::app()->menus->addItem('main', 'Form', array('/test/index/form'), 'Test Module');
		Yii::app()->menus->addItem('main', 'Auto Form', array('/test/index/autoform'), 'Test Module');
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
		TestExtra::install('TestExtra');
	}

	public function uninstall() {
		
	}

}