<?php

class SettingsController extends AController {
	
	public function actionIndex(){
		$settings = new Setting;
		$this->render('index',array('settings'=>$settings));
	}
	
	public function actionPage($module){
		$this->layout = '//layouts/ajax';
		$module = Yii::app()->getModule($module);
		$this->render('page',array('title'=>$module->name,'content'=>$module->settingsPage()));
	}
	
}