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
		Yii::app()->menus->addItem('main', 'Mail', '#');
		Yii::app()->menus->addItem('main', 'All Emails', array('/email/index/index'), 'Mail');
		Yii::app()->menus->addDivider('main','Mail');
		Yii::app()->menus->addItem('main', 'Send an Email', array('/email/index/create'), 'Mail', array('linkOptions'=>array('icon'=>'icon-envelope')));
		Yii::app()->menus->addDivider('main','Mail');
		Yii::app()->menus->addItem('main', 'Manage Saved Campaigns', array('/email/manage/index'), 'Mail');
		Yii::app()->menus->addItem('main', 'Manage Design Templates', array('/email/template/index'), 'Mail');

	}
	
	public function permissions() {
		return array(
			'donation' => array('description' => 'Donation',
				'tasks' => array(
					'view' => array('description' => 'View Donations',
						'roles' => array('administrator', 'editor', 'viewer'),
						'operations' => array(
							'hft/donation/index',
							'hft/donation/view',
							'hft/donation/contactDonations',
							'hft/donation/notes',
							'hft/donation/attachments',
						),
					),
					'edit' => array('description' => 'Edit Donations',
						'roles' => array('administrator', 'editor'),
						'operations' => array(
							'hft/donation/edit',
							'hft/donation/thankyouSent',
						),
					),
				),
			),
			'event' => array('description' => 'Event',
				'tasks' => array(
					'view' => array('description' => 'View Events',
						'roles' => array('administrator', 'editor', 'viewer'),
						'operations' => array(
							'hft/event/index',
							'hft/event/view',
							'hft/event/notes',
							'hft/event/attachments',
							'hft/event/attendees',
						),
					),
					'edit' => array('description' => 'Edit Events',
						'roles' => array('administrator', 'editor'),
						'operations' => array(
							'hft/event/edit',
							'hft/event/addAttendee',
							'hft/event/deleteAttendee',
							'hft/event/emailAttendees',
						),
					),
				),
			),
			'email' => array('description' => 'Emails',
				'tasks' => array(
					'view' => array('description' => 'View Emails',
						'roles' => array('administrator', 'editor', 'viewer'),
						'operations' => array(
							'email/index/index',
							'email/index/preview',
							'email/index/view',
							'email/index/previewContent',
							'email/index/recipients',
						),
					),
					'edit' => array('description' => 'Edit and Send Emails',
						'roles' => array('administrator', 'editor'),
						'operations' => array(
							'email/index/create',
							'email/index/edit',
							'email/index/send',
						),
					),
					'edit_template' => array('description' => 'View and Edit Email Templates',
						'roles' => array('administrator', 'editor'),
						'operations' => array(
							'email/template/index',
							'email/template/create',
							'email/template/edit',
							'email/template/view',
							'email/template/getContents',
							'email/template/templateContent',
						),
					),
					'edit_campaign' => array('description' => 'View and Edit Saved Email Campaigns',
						'roles' => array('administrator', 'editor'),
						'operations' => array(
							'email/manage/index',
							'email/manage/create',
							'email/manage/edit',
							'email/manage/view',
						),
					),
				),
			),
		);
	}
	
	public function install(){
		EmailCampaignTemplate::install();
		EmailCampaign::install();
		EmailTemplate::install();
		EmailCampaignEmail::install();
		$this->installPermissions();
	}
}