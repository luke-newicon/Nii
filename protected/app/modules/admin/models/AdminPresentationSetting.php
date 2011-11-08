<?php

class AdminPresentationSetting extends CFormModel {

	public $logo;
	public $menuAppname;
	public $topbarColor;
	
	public function init(){
		$this->logo = Yii::app()->getModule('admin')->logo;
		$this->menuAppname = Yii::app()->getModule('admin')->menuAppname;
		$this->topbarColor = Yii::app()->getModule('admin')->topbarColor;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('logo, menuAppname, topbarColor', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'logo' => 'Logo',
			'menuAppname' => 'Application Name',
			'topbarColor' => 'Menu Colour',
		);
	}

	public function save(){
		$settings = array('admin'=>$this->attributes);
		$settings = CMap::mergeArray(Yii::app()->settings->get('modules','config'), $settings);
		Yii::app()->settings->set('modules',$settings,'config');
		return true;
	}
}