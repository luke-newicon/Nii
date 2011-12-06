<?php
/**
 * EmailModule is the module class for the email system
 *
 * @author Robin Williams <robin.williams@newicon.net>
 * @version $Id: EmailModule.php $
 * @package Email
 */
class EmailModule extends NWebModule
{
	
	public $name = 'Emails';
	public $description = 'Module to manage newsletters, email and email templating';
	public $version = '0.0.1';
	
	public function init() {
		Yii::import('email.models.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('main', 'Emails', array('/email/index'));
		Yii::app()->menus->addItem('main', 'All Emails', array('/email/index'), 'Emails');
		Yii::app()->menus->addItem('main', 'New Email Campaign', array('/email/template/create'), 'Emails');

	}
	
	public function install(){
		EmailTemplate::install();
		EmailCampaign::install();
	}
}