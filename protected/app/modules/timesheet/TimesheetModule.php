<?php

class TimesheetModule extends NWebModule {

	public $name = 'Timesheet';
	public $description = 'Timesheet goodness';
	public $version = '0.0.1';

	public function init() {
		Yii::import('timesheet.models.*');
		Yii::app()->menus->addItem('main', 'Timesheet', array('/timesheet/index/index'));
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