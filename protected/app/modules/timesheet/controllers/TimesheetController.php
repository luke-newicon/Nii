<?php

class TimesheetController extends AController {

	public function actionIndex($date=null) {
		$date = '2012-01-24';
		$timesheet = TimesheetTimesheet::model()->getUserTimesheet(Yii::app()->user->id, $date);
		if(!$timesheet){
			$timesheet = new TimesheetTimesheet;
			$timesheet->user_id = Yii::app()->user->id;
			$timesheet->week_date = $date;
			$timesheet->save();
		}
		$this->render('index', array('timesheet' => $timesheet));
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
