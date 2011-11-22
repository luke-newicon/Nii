<?php

class AdminPresentationSetting extends CFormModel {

	public $logo;
	public $menuAppname;
	public $topbarColor;
	public $h2Color;
	public $h3Color;
	public $menuSearch;
	
	public function init(){
		$this->logo = Yii::app()->getModule('admin')->logo;
		$this->menuAppname = Yii::app()->getModule('admin')->menuAppname;
		$this->topbarColor = Yii::app()->getModule('admin')->topbarColor;
		$this->h2Color = Yii::app()->getModule('admin')->h2Color;
		$this->h3Color = Yii::app()->getModule('admin')->h3Color;
		$this->menuSearch = Yii::app()->getModule('admin')->menuSearch;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('logo, menuAppname, topbarColor, menuSearch, h2Color, h3Color', 'safe'),
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
			'h2Color' => 'Page Title Text Colour',
			'h3Color' => 'Subtitle Text Colour',
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