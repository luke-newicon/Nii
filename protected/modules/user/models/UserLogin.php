<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLogin extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_userIdentity;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>UserModule::t("Remember me next time on this computer"),
			'username'=>UserModule::t("username or email"),
			'password'=>UserModule::t("password"),
		);
	}
	
	public function getUserIdentity(){
		return $this->_userIdentity;
	}
	

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$this->_userIdentity=new UserIdentity($this->username,$this->password);
			$this->_userIdentity->authenticate();
			$duration=$this->rememberMe ? UserModule::get()->rememberMeDuration : 0;
			switch($this->_userIdentity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					Yii::app()->user->login($this->_userIdentity,$duration);
					break;
				case UserIdentity::ERROR_EMAIL_INVALID:
					$this->addError("username",UserModule::t("Email is incorrect."));
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError("username",UserModule::t("Username is incorrect."));
					break;
				case UserIdentity::ERROR_STATUS_NOTACTIV:
					$this->addError("username",UserModule::t("Your account is not activated."));
					break;
				case UserIdentity::ERROR_STATUS_BAN:
					$this->addError("username",UserModule::t("Your account is blocked."));
					break;
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError("password",UserModule::t("Password is incorrect."));
					break;
				case UserIdentity::ERROR_DOMAIN:
					$this->addError("username",UserModule::t("You do not have access to this address, ."));
					break;
			}
		}
	}
}
