<?php

class TimesheetController extends AController {

	public function actionIndex($date=null) {
		$date = '2012-01-24';
		$weekLog = TimesheetTimesheet::model()->getUserTimesheet(Yii::app()->user->id, $date);
		$this->render('index', array('weekLog' => $weekLog));
	}

}
