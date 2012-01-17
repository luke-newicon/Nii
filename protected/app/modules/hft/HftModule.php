<?php

/**
 * Description of HftModule
 *
 * @author robinwilliams
 */
class HftModule extends NWebModule 
{
	public $name = 'Hope for Tomorrow';
	public $description = 'Module to manage donations, events and extra stuff in contacts';
	public $version = '0.0.1';
	
	public function init() {
		Yii::import('hft.models.*');
		Yii::import('hft.components.*');
		Yii::import('hft.components.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('main', 'Donations', array('/hft/donation/index'));
		Yii::app()->menus->addItem('main', 'Events', array('/hft/event/index'));
		
		Yii::app()->menus->addDivider('main','Contacts');
		Yii::app()->menus->addItem('main', 'Categories', array('/hft/category/index'), 'Contacts');

		Yii::app()->getModule('contact')->contactModel = 'HftContact';
		
		Yii::app()->getModule('contact')->onRenderContactAfterHeader = array($this, 'handleOnRenderAfterHeader');
		Yii::app()->getModule('contact')->onRenderContactAfterTypeDetails= array($this, 'handleOnRenderAfterTypeDetails');

		Yii::app()->getModule('contact')->onRenderContactBeforeTypeDetailsEdit = array($this, 'handleOnRenderBeforeTypeDetailsEdit');
		Yii::app()->getModule('contact')->onRenderContactAfterAddressEdit = array($this, 'handleOnRenderContactAfterAddressEdit');
		/**
		 *	Change configuration of contacts module
		 * Add fields/columns to contacts module dynamically 
		 */
		
		Yii::app()->getModule('contact')->relations = CMap::mergeArray(Yii::app()->getModule('contact')->relations, array(
			'Contact' => array(
				'donations' => array(
					'relation'=>array(HftContact::HAS_MANY,'HftDonation','contact_id'),
					'class'=>'HftDonation',
					'label'=>'Donations',
					'viewRoute'=>'/hft/donation/contactDonations',
					'isAddable'=>false,
					'notification'=>true,
				),
			),
		));
		
		Yii::app()->getModule('contact')->groups = CMap::mergeArray(Yii::app()->getModule('contact')->groups, array(
			'recent_donors' => array(
				'name' => 'Recent Donors',
				'description' => 'People that have donated in the last 2 weeks',
				'count' => HftDonation::countRecentDonors(),
				'contactIds' => ''
			),
			'major_donors' => array(
				'name' => 'Major Donors',
				'description' => 'People that have donated a large sum (over &pound;2,000)',
				'count' => HftDonation::countMajorDonors(),
				'contactIds' => ''
			)
		));
		
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		Yii::app()->getModule('contact')->addBehaviorFor($contactModel, array('donations'=>array('class'=>'hft.components.behaviors.ContactGroupDonation')));
		
//		Yii::app()->getModule('admin')->dashboard->addPortlet('google-bugslist','hft.widgets.GoogleBugsPortlet');
		Yii::app()->getModule('admin')->dashboard->addPortlet('activity-feed','hft.widgets.ActivityFeedPortlet');
		Yii::app()->getModule('admin')->dashboard->addPortlet('events-upcoming','hft.widgets.EventUpcomingPortlet');
		Yii::app()->getModule('admin')->dashboard->addPortlet('donations-latest','hft.widgets.DonationLatestPortlet');
		
		// Add extra rule fields to contact group rule fields
		Yii::app()->getModule('contact')->addGroupRuleField(HftDonation::groupRuleFields());
		Yii::app()->getModule('contact')->addGroupRuleField(HftEvent::groupRuleFields());
	}
	
	
	public function handleOnRenderAfterHeader($event){
		$event->sender->renderPartial('hft.views.contact.view.top', $event->params);
	}
	
	public function handleOnRenderAfterTypeDetails($event){
		$event->sender->renderPartial('hft.views.contact.view.after_type_details', $event->params);
	}
		
	public function handleOnRenderBeforeTypeDetailsEdit($event){
		$event->sender->renderPartial('hft.views.contact.edit.before_type_details', $event->params);
	}
	
	public function handleOnRenderContactAfterAddressEdit($event){
		$event->sender->renderPartial('hft.views.contact.edit.after_address', $event->params);
	}
	
	public function install() {
		HftContact::install('HftContact');
		HftContactSource::install('HftContactSource');
		HftDonation::install('HftDonation');
		HftDonationType::install('HftDonationType');
		HftEvent::install('HftEvent');
		HftEventOrganiserType::install('HftEventOrganiserType');
		HftEventAttendee::install('HftEventAttendee');
		HftDashboardLog::install('HftDashboardLog');
		$this->installPermissions();
	}
	
}