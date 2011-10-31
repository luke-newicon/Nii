<?php

class AdminGeneralSetting extends CFormModel {

	public $appname;

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

}