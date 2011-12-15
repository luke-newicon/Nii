<?php

class ContactModule extends NWebModule {

	public $name = 'Contacts';
	public $description = 'Module to manage contacts';
	public $version = '0.0.1';
	public $menu_label = 'Contacts';
	
	public $contactModel = 'Contact';
	
	public $actions = array();
	
	public $views = array();
	
	public $relations = array();
	
	public $groups = array();
	
	/**
	 * Display contact name: First, Last
	 * @var boolean
	 */
	public $displayOrderFirstLast = false;
	/**
	 * Dislay contact name: Last, First
	 * @var boolean
	 */
	public $displayOrderLastFirst = true;
	/**
	 * Sort contact by name: First, Last
	 * @var boolean
	 */
	public $sortOrderFirstLast = false;
	/**
	 * Sort contact by name: Last, First
	 * @var bollean
	 */
	public $sortOrderLastFirst = true;

	public function init() {
		Yii::import('contact.models.*');
	}

	public function setup() {
		Yii::app()->menus->addItem('main', $this->menu_label, array('/contact/admin/index'));
		Yii::app()->menus->addItem('main', 'All ' . $this->menu_label, array('/contact/admin/index'), $this->menu_label);
		Yii::app()->menus->addItem('main', 'Contact Groups', array('/contact/group/index'), $this->menu_label);
		//Yii::app()->menus->addItem('main', 'Add a Person', array('/contact/admin/create/type/Person'), $this->menu_label);
		//Yii::app()->menus->addItem('main', 'Add an Organisation', array('/contact/admin/create/type/Organisation'), $this->menu_label);
		Yii::app()->getModule('admin')->dashboard->addPortlet('contact-latest','contact.widgets.ContactLatestPortlet','side');
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
		ContactGroup::install('ContactGroup');
		ContactGroupContact::install('ContactGroupContact');
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
	 *	Add an item to groups array
	 * @param array $group 
	 */
	public function addGroup($group=array()) {
		Yii::app()->getModule('contact')->groups = CMap::mergeArray(Yii::app()->getModule('contact')->groups, $group);
	}
	
	public function getGroups() {
		return $this->groups;
	}
	
	public function searchGroups($term) {
		$groups = array();
		foreach ($this->groups as $key => $group) {
			if (strstr($key, $term) || strstr($group['name'], $term))
				$groups[$key]['id'] = $key;
				$groups[$key]['label'] = $group['name'] .' ('.$group['count'].')';
		}
		return $groups;
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
	
	public function onRenderContactBeforeTypeDetailsEdit($event){
		$this->raiseEvent('onRenderContactBeforeTypeDetailsEdit', $event);
	}
	
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