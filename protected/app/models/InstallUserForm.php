<?php


/**
 * This form is responsible for installing the first user.
 * As a security precaution thiswill only allow 1 user to be ionstalled.
 * If there is more than 1 user in the users database table this form will no longer allow
 * users to be installed.
 *
 * @author steve
 */
class InstallUserForm extends InstallForm 
{
	
	public $email;
	public $username;
	public $password;
	
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('email, username, password', 'required'),
			array('email', 'email'),
			array('email, username, password', 'validateUser'),
		);
	}
	
	/**
	 * checks if we allowed to create a user, the current user table must be empty
	 * @param type $attribute
	 * @param type $params 
	 */
	public function validateUser($attribute,$params){
		if($this->isDbInstalled()){
			if($this->isUserInstalled()){
				$this->addError('username', 'A user has already been installed.  
					The install script only allows one user to be installed');
			}
		}
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email Address',
			'username' => 'Username',
			'password' => 'Password',
		);
	}
	
	public function createAdminUser(){
		// add the admin user
		// if the user already exists we will still make it work
		$user = User::model()->findByAttributes(array('username'=>$this->username));
		if ($user === null)
			$user = new User;
//		if ($user->getScenario() != 'insert') {
//			$user->password = $user->cryptPassword($this->password);
//			$user->activekey = $user->cryptPassword(microtime().$this->password);
//		} else {
		$user->password = $this->password;
//		}

		$user->username = $this->username;
		$user->email = $this->email;
		$user->superuser = 1;
		$user->status = 1;
		$user->roleName = 'admin';

		if ($user->validate()) {
			return $user->save();
			if($user->save())
				return $user->saveRole();
			else
				return false;
		} else {
			return false;
		}
	}
	
	/**
	 * Checks if there is a user installed 
	 */
	public function isUserInstalled(){
		return	(User::model()->count() > 0);
	}
	
}