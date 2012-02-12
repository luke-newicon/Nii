<?php

class ApiController extends RestController 
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
	
	
	/**
	 * get the timesheet logs for week commencing...
	 * @param unix time 
	 */
	public function actionList_log(){
		if(isset($_GET['date']))
			$logs = TimesheetLog::model()->findAllForWeek(NTime::dateToUnix($_GET['date']));
		if(isset($_GET['start'])){
			$logs = TimesheetLog::model()->findLogsBetween($_GET['start'], $_GET['end']);
		}
		echo CJSON::encode($logs);
	}
	
	
	public function modelResources(){
		return array(
			'log'=>'TimesheetLog'
		);
	}

}
