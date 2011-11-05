<?php

class WikiModule extends NWebModule {

	public $name = 'Wiki';
	public $description = 'Wiki Module';
	public $version = '0.0.1b';

	public function init() {
		Yii::import('test.models.*');
		Yii::app()->menus->addItem('main','Wiki', array('/wiki/admin/index'));
	}
	
	public function install(){
		$this->installPermissions();
	}
	
	public function uninstall(){}
	
	public function permissions() {
		return array(
			'wiki' => array('description' => 'Wiki',
				'tasks' => array(
					'view' => array('description' => 'Wiki Module',
						'roles' => array('administrator','editor','viewer'),
						'operations' => array(
							'wiki',
						),
					),
				),
			),
		);
	}

}