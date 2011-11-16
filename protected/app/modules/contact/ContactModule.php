<?php

class ContactModule extends NWebModule {

	public $name = 'Contacts';
	public $description = 'Module to manage contacts';
	public $version = '0.0.1';
	public $menu_label = 'Contacts';
	
	public $contactModel = 'Contact';
	
	public $views = array();

	public function init() {
		Yii::import('contact.models.*');
	}

	public function setup() {
		Yii::app()->menus->addItem('main', $this->menu_label, array('/contact/admin/index'));
		Yii::app()->menus->addItem('main', 'All ' . $this->menu_label, array('/contact/admin/index'), $this->menu_label);
		Yii::app()->menus->addItem('main', 'Add a Person', array('/contact/admin/create/type/Person'), $this->menu_label);
		Yii::app()->menus->addItem('main', 'Add an Organisation', array('/contact/admin/create/type/Organisation'), $this->menu_label);
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
		FB::log('INSTALL MODULE '.$this->getId());
		Contact::install('Contact');
		$this->installPermissions();
	}
	
	/**
	 *
	 * @return ContactModule 
	 */
	public static function get(){
		return Yii::app()->getModule('contact');
	}
	
	public function addView($key, $partial) {
		$this->views[$key][] = $partial;
	}
	
	public function renderViews($key, $data) {
		foreach ($this->views[$key] as $k => $view) {
			Yii::app()->controller->renderPartial($view, array('data'=>$data));
		}
	}
	
	/**
	 * View Functions
	 */
	public function onRenderContactAfterHeader($event){
		$this->raiseEvent('onRenderContactAfterHeader', $event);
	}
	
	public function onRenderContactBeforeTypeDetails($event){
		$this->raiseEvent('onRenderContactBeforeTypeDetails', $event);
	}	
	
	public function onRenderContactAfterTypeDetails($event){
		$this->raiseEvent('onRenderContactAfterTypeDetails', $event);
	}
	
	public function onRenderContactAfterComment($event){
		$this->raiseEvent('onRenderContactAfterComment', $event);
	}
	
	/**
	 *	Edit Functions
	 */
	
	/**
	 *	
	 * @param CEvent $event - params = array(contact model, form widget)
	 */
	public function onRenderContactBeforeTypeDetailsEdit($event){
		$this->raiseEvent('onRenderContactBeforeTypeDetailsEdit', $event);
	}
	
	/**
	 *	
	 * @param CEvent $event - params = array(contact model, form widget)
	 */
	public function onRenderContactAfterTypeDetailsEdit($event){
		$this->raiseEvent('onRenderContactAfterTypeDetailsEdit', $event);
	}
	
	public function onRenderContactAfterAddressEdit($event){
		$this->raiseEvent('onRenderContactAfterAddressEdit', $event);
	}
	
	public function onRenderContactAfterCommentEdit($event){
		$this->raiseEvent('onRenderContactAfterCommentEdit', $event);
	}
	
}