<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class InstallForm extends CFormModel
{
	public $sitename;
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
	
	public $db;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('sitename, email, db_host, db_name, db_username, username, password, timezone', 'required'),
			array('db_tablePrefix, db_password', 'safe'),
			array('db_host, db_name, db_username, db_password', 'validateDatabase'),
			array('email', 'email'),
		);
	}
	
	/**
	 * checks if the database connection details are valid,
	 * attempts to connect to the databse, and interpret the error message if any
	 * @param type $attribute
	 * @param type $params 
	 */
	public function validateDatabase($attribute,$params){
		// no point doing this if we already have errors
			$config = $this->generateConfig();
			try { 
				Yii::app()->setComponents($config['components']);
				Yii::app()->db->getConnectionStatus();
			} catch (Exception $e){
				Yii::app()->user->setFlash('error', "Couldn't connect to database. Please check the details and try again!");
				$msg = $e->getMessage();
				if(preg_match('/\bUnknown database\b/i', $msg))
					$this->addError('db_name','Unknown database name "'.$this->db_name.'"');
				else if(preg_match('/\bUnknown .* server host\b/i', $msg))
					$this->addError('db_host','Unknown host name "'.$this->db_host.'"');
				else if(preg_match('/\bAccess denied for user\b/i', $msg))
					$this->addError('db_password', 'Username and password combination is incorrect');
				else
					$this->addError('db',$e->getMessage());
			}
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'sitename' => 'Site Name',
			'email' => 'Email Address',
			'db_host' => 'Host',
			'db_name' => 'Database Name',
			'db_username' => 'Username',
			'db_password' => 'Password',
			'db_tablePrefix' => 'Table Prefix',
			'admin_name' => 'Name',
			'username' => 'Username',
			'password' => 'Password',
			'timezone' => 'Timezone'
		);
	}
	
	/**
	 * populates the model from a $local config array
	 * @param array $local 
	 */
	public function getLocalConfig($local) {
		
		$db = $local['components']['db'];
		$dbstring = explode(';',$db['connectionString']);
		
		$this->db_host = str_replace('mysql:host=', '', $dbstring[0]);
		$this->db_name = str_replace('dbname=', '', $dbstring[1]);
		$this->db_username = $db['username'];
		$this->db_password = $db['password'];
		$this->db_tablePrefix = $db['tablePrefix'];
		
		$this->sitename = $local['name'];
		$this->timezone = $local['timezone'];
		$this->email = $local['params']['adminEmail'];
		
	}
	
	
	/**
	 * generates a config array from the model properties.
	 * @return array compatible with yii config to save as applications local config settings
	 */
	public function generateConfig(){
		$config = array();
		$config['name'] = $this->sitename;
		$config['timezone'] = $this->timezone;

		$config['components']['db']['connectionString'] = 'mysql:host='.$this->db_host.';dbname='.$this->db_name;
		$config['components']['db']['username'] = $this->db_username;
		$config['components']['db']['password'] = $this->db_password;
		$config['components']['db']['tablePrefix'] = $this->db_tablePrefix;

		$config['params']['adminEmail'] = $this->email;
		return $config;
	}
	
	
	
	public function installDatabase(){
		// install tables and nii modules
		NActiveRecord::install('Setting');
		NActiveRecord::install('Log');
		Yii::app()->install();
	}
	
	public function createAdminUser(){
		// add the admin user
		// if the user already exists we will still make it work
		$user = User::model()->findByAttributes(array('username'=>$this->username));
		if ($user === null)
			$user = new User;
		if ($user->getScenario() != 'insert') {
			$user->password = $user->cryptPassword($this->password);
			$user->activekey = $user->cryptPassword(microtime().$this->password);
		} else {
			$user->password = $this->password;
		}

		$user->username = $this->username;
		$user->email = $this->email;
		$user->superuser = 1;
		$user->status = 1;

		if ($user->validate()) {
			return $user->save();
		} else {
			return false;
		}
	}
	
}
