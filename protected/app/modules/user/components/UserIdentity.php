<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * store the user record
	 * @var NActiveRecord 
	 */
	private $_user;
	
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;
	const ERROR_DOMAIN=6;
	
	
	/**
	 * Gets the ActiveRecord User model
	 * 
	 * @return User 
	 */
	public function getUser(){
		if($this->_user === null){
			if (strpos($this->username,"@")) {
				$this->_user=UserModule::userModel()->notsafe()->findByAttributes(array('email'=>$this->username));
			} else {
				$this->_user=UserModule::userModel()->notsafe()->findByAttributes(array('username'=>$this->username));
			}
		}
		return $this->_user;
	}
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$this->getUser();
		if($this->_user===null)
			if (strpos($this->username,"@")) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
		else if(!$this->_user->checkPassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($this->_user->status==0&&Yii::app()->getModule('user')->loginNotActive==false)
			$this->errorCode=self::ERROR_STATUS_NOTACTIV;
		else if($this->_user->status==-1)
			$this->errorCode=self::ERROR_STATUS_BAN;
		else {
			// if user module set up for subdomain apps then we need to add 
			// an extra check
			if(UserModule::get()->domain){
				if($this->_user->domain != Yii::app()->getSubDomain()){
					if(!$this->_user->superuser){
						$this->errorCode=self::ERROR_DOMAIN;
						return !$this->errorCode;
					}
				}
			}
			$this->_loginUser($this->_user);
		}
		return !$this->errorCode;
	}
	

	/**
	 * This function does not perform the user login. That is done by Yii::app()->user->login($UserIdentity (this class), $duration)
	 * The command that performs the login is called in the UserLogin model form object
	 * This function adds additional data to the user identity class before logging in.
	 * 
	 * @param NActiveRecord $user 
	 */
	protected function _loginUser($user)
	{
		if($user){
			$this->_user = $user;
			$this->_id = $this->_user->id;
			$this->username = ($user->username==null)?$user->email:$user->username;
            $this->errorCode = self::ERROR_NONE;
		}
	}
	
	/**
	 * Allows administrator to impersonate another user
	 * @param type $userId
	 * @return UserIdentity 
	 */
	public static function impersonate($userId)
	{
		$ui = null;
		$user = UserModule::userModel()->findByPk($userId);
		if($user)
		{   
			//TODO: add another check here to ensure currently logged in user has permission to do this.
			Yii::app()->session['impersonate_restore'] = Yii::app()->user->id;
			Yii::app()->session['impersonate_restore_validation'] = 'xyz'; 
			// create some key from the password and infomation of this superuser to validate when performing a restore
			// this would ensure the correct user is being restored (so the session can not just be hacked adding in this id)
			$ui = new UserIdentity($user->email, "");
			$ui->_logInUser($user);
			
		}
		return $ui;
	}
	
	public static function impersonateRestore($userId){
		$ui = null;
		// check the validation session
		$user = UserModule::userModel()->findByPk($userId);
		if($user)
		{   
			$ui = new UserIdentity($user->email, "");
			$ui->_logInUser($user);
			// remove restore session
			unset(Yii::app()->session['impersonate_restore']);
		}
		return $ui;
	}

   /**
    * @return integer the ID of the user record
    */
	public function getId()
	{
		return $this->_id;
	}
	
	public function getSubDomain(){
		if($this->_user !==null){
			return $this->_user->domain;
		}
		return null;
	}
}