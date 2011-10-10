<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'AccountController'.
 */
class RegistrationForm extends User
{
	public $verifyPassword;
	public $verifyCode;
	
	public $terms;
	
	public function rules() {
		$rules = array(
			array('password, verifyPassword, email', 'required'),
			array('username', 'length', 'max'=>75, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('verifyPassword', 'doVerifyPassword'),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('password','compare','compareAttribute'=>'username','operator'=>'!=','message'=>'Your password must be different from your username'),
		);
		
		$userModule = Yii::app()->getModule('user');
		if($userModule->usernameRequired)
			$rules[] = array('username','required');
		
		if($userModule->termsRequired)
			$rules[] = array('terms', 'required','requiredValue'=>1, 'message'=>UserModule::t("You must agree to the terms to sign up"));
		
		if (isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			return $rules;
		else 
			$rules[] = array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration'));
		return $rules;
	}
	
	public function doVerifyPassword($attribute,$params) {
		if($this->password != $this->verifyPassword){
			$this->addError("verifyPassword",UserModule::t("Retype Password is incorrect."));
		}
//		if (UserModule::checkPassword($this->password, $this->verifyPassword) === false) {
//			$this->addError("verifyPassword",UserModule::t("Retype Password is incorrect."));
//		}
	}
	
}