<?php

class UserEditForm extends User {
	
	public $verifyPassword;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return array(
			array('first_name, last_name, email, username', 'required'),
			array('email', 'email'),
			array('email', 'unique', 'message' => UserModule::t("This email address already exists.")),
			array('username', 'unique', 'message' => UserModule::t("This username address already exists.")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimum length 4 symbols).")),
			array('verifyPassword', 'doVerifyPassword'),
			array('roleName, status, superuser','safe'),
		);
	}

}