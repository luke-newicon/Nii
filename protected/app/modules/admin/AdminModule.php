<?php

class AdminModule extends NWebModule {

	public $name = 'Administration';
	public $description = 'Admin module for configuring the admin area';
	public $version = '1.0';

	public function init() {
		Yii::import('test.models.*');
	}

//	public function settings() {
//		return array(
//			'id' => array('type' => 'text'),
//		);
//	}

}