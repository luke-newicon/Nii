<?php

class AdminGeneralSetting extends CFormModel {

	public $appname;
	
	public function init(){
		$this->appname = Yii::app()->name;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('appname', 'required'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'appname' => 'Application Name',
		);
	}
	
	public function save(){
		$settings = array('name' => $this->appname);
		$settings = CMap::mergeArray(Yii::app()->settings->get('application','config'), $settings);
		Yii::app()->settings->set('application',$settings,'config');
		return true;
	}

}