<?php

class TimesheetModule extends NWebModule 
{

	public $name = 'Timesheet';
	public $description = 'Timesheet goodness';
	public $version = '0.0.1';
	public $assetUrl;

	public function init() 
	{
		Yii::import('timesheet.models.*');
	}
	
	public function setup() 
	{
		$localPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$this->assetUrl = Yii::app()->assetManager->publish($localPath);
		Yii::app()->clientScript->registerCssFile($this->assetUrl . '/timesheet.css');
		
		Yii::app()->menus->addItem('user', 'Timesheets', array('/timesheet/index/index'),'User');
		
		$project = Yii::app()->getModule('project');
		if ($project==null)
			throw new CException('Timesheet module requires the project module to be installed and enabled');
		
		Yii::app()->urlManager->addRules(array(
				array('/timesheet/api/list',   'pattern'=>'/timesheet/api/<model:\w+>',			 'verb'=>'GET'),
				array('/timesheet/api/view',   'pattern'=>'/timesheet/api/<model:\w+>/<id:\w+>', 'verb'=>'GET'),
				array('/timesheet/api/create', 'pattern'=>'/timesheet/api/<model:\w+>',          'verb'=>'POST'),
				array('/timesheet/api/update', 'pattern'=>'/timesheet/api/<model:\w+>/<id:\w+>', 'verb'=>'PUT'),
				array('/timesheet/api/delete', 'pattern'=>'/timesheet/api/<model:\w+>/<id:\w+>', 'verb'=>'DELETE'),
			)
		);
		Yii::app()->getClientScript()->registerPackage('fullcalendar');
	}

	public function install() 
	{
		TimesheetHoliday::install();
		TimesheetLog::install();
	}

	public function uninstall() 
	{	
	}
	
	/**
	 * get the total minutes currently logged again this project
	 * 
	 * @param int $projectId
	 * @return int number of minutes 
	 */
	public function getTotalProjectMinutes($projectId)
	{
		$minutes = TimesheetLog::model()->cmdSelect('sum(minutes) as totalminutes')
				->where("project_id = $projectId")->queryColumn();
		return $minutes[0];
	}
	
	/**
	 * get a list of all project time logs
	 * @param int $projectId 
	 * @return array TimesheetLog records
	 */
	public function getProjectTimeLogs($projectId)
	{
		return TimesheetLog::model()->findAllByAttributes(array('project_id'=>$projectId));
	}

}