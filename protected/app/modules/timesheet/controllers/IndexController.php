<?php

class IndexController extends AController {

	public function actionIndex($userId, $date=null) {
		
		$date ='2012-01-24 00:00:00';
		$weekLog = TimesheetTimesheet::model()->getUserTimesheet($userId, $date);
		$this->render('index',array('weekLog'=>$weekLog));
	}

}
