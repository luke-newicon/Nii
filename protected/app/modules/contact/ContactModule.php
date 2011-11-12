<?php

class ContactModule extends NWebModule {

	public $name = 'Contacts';
	public $description = 'Module to manage contacts';
	public $version = '0.0.1';
	public $menu_label = 'Contacts';

	public function init() {
		Yii::import('contact.models.*');
	}

	public function setup() {
		Yii::app()->menus->addItem('main', $this->menu_label, array('/contact/admin/index'));
		Yii::app()->menus->addItem('main', 'All ' . $this->menu_label, array('/contact/admin/index'), $this->menu_label);
	}

	public function settings() {
		return array(
			'contacts' => '/contact/settings/index',
		);
	}

	public function permissions() {
		return array(
			'contact' => array('description' => 'Contact',
				'tasks' => array(
					'view' => array('description' => 'View Contacts',
						'roles' => array('administrator', 'editor', 'viewer'),
						'operations' => array(
							'contact/admin/index',
							'contact/admin/view',
							'menu-contact',
							'nii/index/show',
						),
					),
					'edit' => array('description' => 'Edit Contacts',
						'roles' => array('administrator', 'editor'),
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

	public function install() {
		Contact::install('Contact');
		$this->installPermissions();
	}

}