<?php

class IndexController extends AController {

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
	
	public function actionIndex() {
		$tabs['Timesheets'] = array('id' => 'timesheets', 'ajax' => CHtml::normalizeUrl(array('/timesheet/timesheet/index')));
		$tabs['Holidays'] = array('id' => 'holidays', 'ajax' => CHtml::normalizeUrl(array('/timesheet/holiday/index')));
		
		$this->render('index',array(
			'tabs' => $tabs,
		));
	}

}
