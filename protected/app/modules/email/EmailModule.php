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
		Yii::import('email.components.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('main', 'Mail', array('/email/index'));
		Yii::app()->menus->addItem('main', 'All Emails', array('/email/index'), 'Mail');
		Yii::app()->menus->addItem('main', 'Send an Email', array('/email/index/create'), 'Mail');
		Yii::app()->menus->addDivider('main','Emails');
		Yii::app()->menus->addItem('main', 'Manage Saved Campaigns', array('/email/manage/index'), 'Mail');
		Yii::app()->menus->addItem('main', 'Manage Design Templates', array('/email/template/index'), 'Mail');

	}
	
	public function install(){
		EmailCampaignTemplate::install();
		EmailCampaign::install();
		EmailTemplate::install();
		EmailCampaignEmail::install();
	}
}