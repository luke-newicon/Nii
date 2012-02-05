<?php

class TimesheetController extends AController {

	public function actionIndex($date=null) {

		// find the monday of this week
		$monday = TimesheetLog::model()->getMonday();
		
		// find the logs for this week
		$logs = TimesheetLog::model()->findAllForWeek($monday);
		
		$this->render('index', array(
			'startDate'=>$monday,
			'logs'=>CJSON::encode($logs)
		));
	}
	
	/**
	 * get the timesheet logs for week commencing...
	 * @param unix time 
	 */
	public function actionWeekLog($date){
		$logs = TimesheetLog::model()->findAllForWeek(NTime::dateToUnix($date));
		echo CJSON::encode($logs);
	}
	
	/**
	 * save a week log row custom functionality for timesheet view.
	 */
	public function actionSaveWeekLog(){
		dp($_POST['log']);
		TimesheetLog::model()->saveWeekLog($_POST['log']);
	}
	

}
