<?php

class UserAccountForm extends User {

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return array(
			array('first_name, last_name, email', 'required'),
			array('email', 'email'),
			array('email', 'unique', 'message' => UserModule::t("This email address already exists.")),
		);
	}

}