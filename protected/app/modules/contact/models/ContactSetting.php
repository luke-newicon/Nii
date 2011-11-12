<?php

class ContactSetting extends CFormModel {

	public $menu_label;
	
	public function init(){
		$this->menu_label = Yii::app()->getModule('contact')->menu_label;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('menu_label', 'required'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'menu_label' => 'Menu Label',
		);
	}
	
	public function save(){
		$settings = array('contact'=>$this->attributes);
		$settings = CMap::mergeArray(Yii::app()->settings->get('modules','config'), $settings);
		Yii::app()->settings->set('modules',$settings,'config');
		return true;
	}

}