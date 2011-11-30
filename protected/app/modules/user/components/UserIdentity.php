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
			// successful login has occured so we store some additional data
			$this->_user = $user;
			$this->_id = $this->_user->id;
			$this->username = ($user->username==null)?$user->email:$user->username;
            $this->errorCode = self::ERROR_NONE;
			// we also want to generate a random auth key which we store in the session state.
			// this will then also get stored in the cookie.
			// Then when restoring from a cookie we can compare this key with the one in the database 
			// this will implement the additional security as recomended by yii
			// here: http://www.yiiframework.com/doc/guide/1.1/en/topics.auth section 3. Cookie-based Login 
		}
	}
	
	/**
	 * Allows administrator to impersonate another user
	 * @param type $userId
	 * @return UserIdentity 
	 */
	public static function impersonate($userId)
	{
		$superUser = UserModule::userModel()->notsafe()->findByPk(Yii::app()->user->id);
		$user = UserModule::userModel()->notsafe()->findByPk($userId);
		if($user)
		{   
			//TODO: add another check here to ensure currently logged in user has permission to do this.
			Yii::app()->session['impersonate_restore'] = Yii::app()->user->id;
			Yii::app()->session['impersonate_restore_validation'] = md5($superUser->password); 
			// create some key from the password and infomation of this superuser to validate when performing a restore
			// this would ensure the correct user is being restored (so the session can not just be hacked adding in this id)
			$ui = new UserIdentity($user->email, "");
			$ui->_logInUser($user);
			Yii::app()->user->login($ui);
		}
	}
	
	public static function impersonateRestore(){
		$user = UserModule::userModel()->notsafe()->findByPk(Yii::app()->session['impersonate_restore']);
		if($user)
		{
			// check the validation session to ensure the validation key matches this user.
			// Protects against cases where the session could be hacked.  
			// You must know the users details (password, activekey and the id) to restore the user.
			if(md5($user->password) == Yii::app()->session['impersonate_restore_validation']){
				$ui = new UserIdentity($user->email, "");
				$ui->_logInUser($user);
				Yii::app()->user->login($ui);
				// remove restore session
				unset(Yii::app()->session['impersonate_restore']);
				unset(Yii::app()->session['impersonate_restore_validation']);
			}
		}
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