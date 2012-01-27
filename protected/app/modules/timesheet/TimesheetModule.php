<?php

class TimesheetModule extends NWebModule {

	public $name = 'Timesheet';
	public $description = 'Timesheet goodness';
	public $version = '0.0.1';

	public function init() {
		Yii::import('timesheet.models.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('user', 'Timesheets', array('/timesheet/index/index'),'User');
	}

	public function install() {
		TimesheetTimerecord::install();
		TimesheetTimesheet::install();
		TimesheetHoliday::install();
	}

	public function uninstall() {
		
	}

}