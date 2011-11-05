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
	
	public function install(){
		Contact::install('Contact');
	}

}