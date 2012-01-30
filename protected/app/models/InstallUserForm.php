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
	
	/**
	 * Admin user create
	 * @return boolean result of save function
	 */
	public function createAdminUser(){
		// method can only be used if a user does not already exist!
		// In affect it can only be ran once
		if($this->isUserInstalled())
			return false;
		// add the admin user
		// if the user already exists we will still make it work
		$user = User::model()->findByAttributes(array('username'=>$this->username));
		if ($user === null)
			$user = new User;
		
		$user->password = $this->password;
		$user->username = $this->username;
		$user->email = $this->email;
		$user->superuser = 1;
		$user->status = 1;
		$user->roleName = 'admin';

		// we do not want to use validation as it will fail because we are a guest user.
		// bu this is an exception as we are in the install and this is never called again.
		return $user->save(false);
	}
	
}