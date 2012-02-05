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
		$rows = $_POST['log'];
		
		foreach($rows as $log){
			if(is_array($log['time'])) {
				foreach($log['time'] as $i=>$day){
					if($log['time'][$i]!=''){
						$l = new TimesheetLog;
						$l->minutes = $log['time'][$i]*60;
						$l->project_id = $log['project'];
						$l->task_id = $log['task'];
						$d = NTime::dateToUnix($rows['date']);
						dp(date('d', $d));
						dp(date('m', $d));
						dp(date('Y', $d));
						$l->date = date('Y-m-d',mktime(0, 0, 0, date('m', $d), date('j', $d)+$i, date('Y', $d)));
						$l->user_id = Yii::app()->user->record->id;
						$l->save();
					}
				}
			}
		}
	}
	

}
