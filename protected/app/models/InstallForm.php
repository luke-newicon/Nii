<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class InstallForm extends CFormModel
{
	public $sitename;
	public $hostname;
	public $timezone;
	public $db_host;
	public $db_name;
	public $db_username;
	public $db_password;
	public $db_tablePrefix;
	public $username;
	public $password;
	public $email;
	
	public $installDb;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('sitename, hostname, email, db_host, db_name, db_username, username', 'required'),
			array('db_tablePrefix, db_password, password', 'safe'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'sitename' => 'Site Name',
			'hostname' => 'Host',
			'email' => 'Email Address',
			'db_host' => 'Host',
			'db_name' => 'Database Name',
			'db_username' => 'Username',
			'db_password' => 'Password',
			'db_tablePrefix' => 'Table Prefix',
			'admin_name' => 'Name',
			'username' => 'Username',
			'password' => 'Password',
		);
	}
	
	public function getLocalConfig($local) {
		
		$db = $local['components']['db'];
		$dbstring = explode(';',$db['connectionString']);
		
		$this->db_host = str_replace('mysql:host=', '', $dbstring[0]);
		$this->db_name = str_replace('dbname=', '', $dbstring[1]);
		$this->db_username = $db['username'];
		$this->db_password = $db['password'];
		$this->db_tablePrefix = $db['tablePrefix'];
		
		$this->sitename = $local['name'];
		$this->hostname = $local['hostname'];
		$this->timezone = $local['timezone'];
		$this->email = $local['params']['adminEmail'];
		
	}

}
