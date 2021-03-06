<?php

class TimesheetController extends AController 
{

	public function accessRules() {
		return array(
			array('allow',
				'users' => array('@'),
			),
			array('deny', // deny all users
				'users' => array('?'),
			),
		);
	}
	
	public function actionIndex($date=null) {

		// find the monday of this week
		$monday = TimesheetLog::model()->getMonday();
		
		// find the logs for this week
		$logs = TimesheetLog::model()->findAllForWeek($monday);
		
		$this->render('index', array(
			'startDate' => $monday,
			'logs'      => CJSON::encode($logs),
			'projects'  => CJSON::encode(Yii::app()->getModule('project')->getProjectList()),
			'tasks'     => CJSON::encode(Yii::app()->getModule('project')->getTaskList())
		));
	}
	
	/**
	 * get the timesheet logs for week commencing...
	 * @param unix time 
	 */
	public function actionLog($date=null){
		$logs = TimesheetLog::model()->findAllForWeek(NTime::dateToUnix($date));
		echo CJSON::encode($logs);
	}
	
	/**
	 * create an individual Time log 
	 * This action is only fired through a post request
	 */
	public function actionLogCreate(){
		$t = new TimesheetLog;
		$t->attributes = $_POST;
		$t->save();
		echo CJSON::encode($t);
	}
	
	/**
	 * save a week log row custom functionality for timesheet view.
	 */
	public function actionSaveWeekLog(){
		TimesheetLog::model()->saveWeekLog($_POST['log']);
	}
	
	/**
	 * get a list of tasks, gets the latest 30 tasks
	 */
	public function actionTasks(){
		echo CJSON::encode(Yii::app()->getModule('project')->getTaskList(array('limit'=>30,'order'=>'id DESC')));
	}
	

}
