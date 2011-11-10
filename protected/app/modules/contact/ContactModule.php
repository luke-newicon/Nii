<?php

class ContactModule extends NWebModule {

	public $name = 'Contacts';
	public $description = 'Module to manage contacts';
	public $version = '0.0.1';

	public function init() {
		Yii::import('contact.models.*');
		Yii::app()->menus->addItem('main','Contacts', array('/contact/admin/index'));
		Yii::app()->menus->addItem('main','All Contacts', array('/contact/admin/index'),'Contacts');
	}

	public function permissions() {
		return array(
			'contact' => array('description' => 'Contact',
				'tasks' => array(
					'view' => array('description' => 'View Contacts',
						'roles' => array('administrator','editor','viewer'),
						'operations' => array(
							'contact/admin/index',
							'contact/admin/view',
							'menu-contact',
						),
					),
					'edit' => array('description' => 'Edit Contacts',
						'roles' => array('administrator','editor'),
						'operations' => array(
							'contact/admin/edit',
							'contact/admin/create',
							'contact/admin/uploadPhoto',
						),
					),
				),
			),
		);
	}
	
	public function install(){
		Contact::install('Contact');
		$this->installPermissions();
	}

}