<?php

class AdminPresentationSetting extends CFormModel {

	public $logo;
	public $menuAppname;
	
	public function init(){
		$this->logo = Yii::app()->getModule('admin')->logo;
		$this->menuAppname = Yii::app()->getModule('admin')->menuAppname;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('logo, menuAppname', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'logo' => 'Logo',
			'menuAppname' => 'Application Name',
		);
	}

	public function save(){
		$settings = array('admin'=>array(
			'logo' => $this->logo,
			'menuAppname' => $this->menuAppname,
		));
		$settings = CMap::mergeArray(Yii::app()->settings->get('modules','config'), $settings);
		Yii::app()->settings->set('modules',$settings,'config');
		return true;
	}
}