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

	/**
	 * records wheteher there is an error with the domain the user is logging into 
	 */
	public $domain;
	
	/**
	 *
	 * @var UserIdentity 
	 */
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
		$usernameLabel = (UserModule::get()->usernameRequired) ? 'Username or Email' : 'Email';
		return array(
			'rememberMe'=>UserModule::t("Keep me logged in for 30 days"),
			'username'=>UserModule::t($usernameLabel),
			'password'=>UserModule::t("Password"),
		);
	}
	
	/**
	 * return the useridentity
	 * @return UserIdentity
	 */
	public function getUserIdentity(){
		return $this->_userIdentity;
	}
	
	
	/**
	 * this function called the models validate method which in turn will call, the authentication rule, 
	 * which logins in a user if it is successful.
	 * @return boolean 
	 */
	public function login(){
		if($this->validate()){
			Yii::app()->user->login($this->_userIdentity,$this->getDuration());
			return true;
		}
		return false;
	}
	
	/**
	 * The "remember me" login duration
	 * @return int 
	 */
	public function getDuration(){
		return $this->rememberMe ? UserModule::get()->rememberMeDuration : 0;
	}
	
	
	/**
	 * This function returns true if the only error is that a user is logging in to the wrong doomain
	 */
	public function isValidButWrongDomain(){
		return (!$this->hasErrors('username') && !$this->hasErrors('password') && $this->hasErrors('domain'));
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 * It also performs the logining in of a user
	 * @return void
	 */
	public function authenticate($attribute,$params)
	{
		
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$this->_userIdentity=new UserIdentity($this->username,$this->password);
			$this->_userIdentity->authenticate();
			switch($this->_userIdentity->errorCode)
			{
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
					$this->addError('domain', 'You do not have access to the current domain');
					
				case UserIdentity::ERROR_NONE:
					break;
			}
		}
	}
	
}
