<?php

class DomainLookup extends CFormModel {

	public $domain;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array(
			array('domain', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'domain' => 'Domain',
		);
	}

}
