<?php

class WikiModule extends NWebModule {

	public $name = 'Wiki';
	public $description = 'Wiki Module';
	public $version = '0.0.1b';

	public function init() {
		Yii::import('test.models.*');
		Yii::app()->getModule('admin')->menu->addItem('main','Wiki', array('/wiki/admin/index'));
	}
	
	public function install(){}
	
	public function uninstall(){}

}