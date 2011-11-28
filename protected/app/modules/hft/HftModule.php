<?php

/**
 * Description of HftModule
 *
 * @author robinwilliams
 */
class HftModule extends NWebModule 
{
	public $name = 'Hope for Tomorrow';
	public $description = 'Module to manage contacts and donations';
	public $version = '0.0.1';
	
	public function init() {
		Yii::import('hft.models.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('main', 'Donations', array('/hft/donation/index'));
		Yii::app()->menus->addItem('main', 'Events', array('/hft/event/index'));

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
		$this->installPermissions();
	}
	
}