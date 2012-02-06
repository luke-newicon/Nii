<?php

class TimesheetModule extends NWebModule {

	public $name = 'Timesheet';
	public $description = 'Timesheet goodness';
	public $version = '0.0.1';
	public $assetUrl;

	public function init() {
		Yii::import('timesheet.models.*');
	}
	
	public function setup() {
		$localPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$this->assetUrl = Yii::app()->assetManager->publish($localPath);
		Yii::app()->clientScript->registerCssFile($this->assetUrl . '/timesheet.css');
		
		Yii::app()->menus->addItem('user', 'Timesheets', array('/timesheet/index/index'),'User');
		
		$project = Yii::app()->getModule('project');
		if ($project==null)
			throw new CException('Timesheet module requires the project module to be installed and enabled');
	}

	public function install() {
		TimesheetHoliday::install();
		TimesheetLog::install();
	}

	public function uninstall() {
		
	}

}