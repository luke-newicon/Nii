<?php

Class AccountModule extends NWebModule
{
	public $name = 'Hotspot Account';
	
	public function init(){
		$this->setImport(array(
			'account.models.*',
			'account.extensions.EActiveResource.*'
		));
		require_once Yii::getPathOfAlias('account.extensions.recurly.library.recurly').'.php';
		
		
		Yii::app()->user->attachBehavior('account', array('class'=>'account.components.AccountUser'));
		// add event to do extra processing when a user signs up.
		// change this to on activation... we only want to create new databases for real users
		//UserModule::get()->onRegistrationComplete = array($this, 'registrationComplete');
	}
	
	public function install(){
		Billing::install();
	}
	
}