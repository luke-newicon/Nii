<?php

class TestModule extends NWebModule {

	public $settingsPage = array('/test/settings');
	
	public function init(){
		Yii::import('test.models.*');
	}

}