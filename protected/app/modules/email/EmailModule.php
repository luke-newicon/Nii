<?php

/**
 * Description of EmailModule
 *
 * @author robinwilliams
 */
class EmailModule extends NWebModule 
{
	public $name = 'Email Module';
	public $description = 'Module to manage Newsletters, Emails and Email Templating';
	public $version = '0.0.1';
	
	public function init() {
		Yii::import('email.models.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('main', 'Email', array('/email/admin/index'));
	}
		
	public function install() {
		HftContact::install('HftContact');
		HftContactSource::install('HftContactSource');
		HftDonation::install('HftDonation');
		HftDonationType::install('HftDonationType');
		HftEvent::install('HftEvent');
		HftEventOrganiserType::install('HftEventOrganiserType');
		HftEventAttendee::install('HftEventAttendee');
		$this->installPermissions();
	}
	
}