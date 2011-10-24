<?php

class SettingsController extends AController {

	public function actionIndex() {
		$model = new TestSetting;
		
//		$this->performAjaxValidation($model, 'TestSettingForm');
		
		if(isset($_POST['TestSetting']))
			$model->validate();
		
		$this->render('index',array('model'=>$model));
	}

}