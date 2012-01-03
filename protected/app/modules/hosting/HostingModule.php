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
	

	public function permissions() {
		return array(
			'hosting' => array('description' => 'Hosting',
				'tasks' => array(
					'view' => array('description' => 'View Hosting Details',
						'roles' => array('administrator', 'editor', 'viewer'),
						'operations' => array(
							'hosting/server/index',
							'hosting/server/view',
							'hosting/server/admin',
						),
					),
					'edit' => array('description' => 'Edit Hosting Details',
						'roles' => array('administrator', 'editor'),
						'operations' => array(
							'hosting/server/edit',
							'hosting/server/create',
							'hosting/server/delete',
						),
					),
				),
			),
		);
	}
	
	public function install(){
		HostingServer::install('HostingServer');
	}
}
