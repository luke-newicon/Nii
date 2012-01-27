<?php

class TimesheetModule extends NWebModule {

	public $name = 'Timesheet';
	public $description = 'Timesheet goodness';
	public $version = '0.0.1';

	public function init() {
		Yii::import('timesheet.models.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('main', 'Timesheet', array('/timesheet/index/index'));
	}

	public function install() {
		TimesheetTimerecord::install();
		TimesheetTimesheet::install();
	}

	public function uninstall() {
		
	}

}