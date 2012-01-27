<?php

class TimesheetController extends AController {

	public function actionIndex($date=null) {
		$date = '2012-01-24';
		$timesheet = TimesheetTimesheet::model()->getUserTimesheet(Yii::app()->user->id, $date);
		$this->render('index', array('timesheet' => $timesheet));
	}
	
	public function actionDelete($id){
		TimesheetTimerecord::model()->findByPk($id)->delete();
		$this->redirect(array('/timesheet/index/index'));
	}

}
