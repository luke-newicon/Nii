<?php

class TimesheetController extends AController {

	public function actionIndex($date=null) {
		
		$timesheet = TimesheetTimesheet::model()->getUserTimesheet(Yii::app()->user->id, $date);
		if(!$timesheet){
			$timesheet = new TimesheetTimesheet;
			$timesheet->user_id = Yii::app()->user->id;
			$timesheet->week_date = $date;
			$timesheet->save();
		}

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
		
	}
	
	public function actionAdd($timesheet){
		$record = new TimesheetTimerecord;
		$record->timesheet_id = $timesheet;
		$record->save();
		$this->renderPartial('_row', array('record' => $record));
	}
	
	public function actionDelete($id){
		TimesheetTimerecord::model()->findByPk($id)->delete();
		$this->redirect(array('/timesheet/index/index'));
	}

}
