<?php

class AdminPresentationSetting extends CFormModel {

	public $logo;
	public $menuAppname;
	public $topbarColor;
	public $menuSearch;
	
	public function init(){
		$this->logo = Yii::app()->getModule('admin')->logo;
		$this->menuAppname = Yii::app()->getModule('admin')->menuAppname;
		$this->topbarColor = Yii::app()->getModule('admin')->topbarColor;
		$this->menuSearch = Yii::app()->getModule('admin')->menuSearch;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('logo, menuAppname, topbarColor, menuSearch', 'safe'),
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
			'menuSearch' => 'Show the search box in the menu bar?',
		);
	}

	public function save(){
		$settings = array('admin'=>$this->attributes);
		$settings = CMap::mergeArray(Yii::app()->settings->get('modules','config'), $settings);
		Yii::app()->settings->set('modules',$settings,'config');
		return true;
	}
}