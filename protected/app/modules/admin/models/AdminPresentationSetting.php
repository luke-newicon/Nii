<?php

class AdminPresentationSetting extends CFormModel {

	public $logo = '/images/logo.gif';
	public $color = 'FFFFFF';
	public $background = 'AAAAAA';

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('logo, color, background', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'logo' => 'Logo',
			'color' => 'Colour',
			'background' => 'Background',
		);
	}

}