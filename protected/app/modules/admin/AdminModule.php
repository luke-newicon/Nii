<?php

class AdminModule extends NWebModule {

	public $name = 'Administration';
	public $description = 'Admin module for configuring the admin area';
	public $version = '1.0';

	public function init() {
	}
	
//	public function settings(){
//		return array(
//			'url' => array('/admin/settings')
//		);
//	}
	
	public function getSettingsPage(){
		return array('/admin/settings/general');
	}

}