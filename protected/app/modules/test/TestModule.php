<?php

class TestModule extends NWebModule {

	
//	public $settingsPage = array('/test/settings');
	public $name = 'Test Module';
	public $description = 'Lukes test module for testing lots of good module stuff';
	public $version = '0.0.1b';
	
	public function init(){
		Yii::import('test.models.*');
	}
	
	public function settings(){
		return array(
			'id' => array('type' => 'text'),
		);
	}

}