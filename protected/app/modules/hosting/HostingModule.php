<?php

class HostingModule extends NWebModule
{
	
	public $name = 'Hosting';
	public $description = 'Module to manage Newicon\'s hosting, including servers and domains';
	public $version = '0.0.1';
	
	public function init() {
		Yii::import('hosting.models.*');
		Yii::import('hosting.components.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('main', 'Hosting', 'javascript:void(0)');
		Yii::app()->menus->addItem('main', 'Servers', array('/hosting/server'), 'Hosting');
	}
	
	public function install(){
		HostingServer::install('HostingServer');
	}
}
