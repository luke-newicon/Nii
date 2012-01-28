<?php

/**
 * Install Form class.
 */
class InstallDbForm extends InstallForm
{
	public $sitename;
	public $timezone;
	public $host;
	public $name;
	public $username;
	public $password;
	public $tablePrefix;

	
	public $db;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('sitename, timezone, host, name, username', 'required'),
			array('host, name, username, password', 'validateDatabase'),
			array('tablePrefix, password', 'safe'),
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
					$this->addError('name','Unknown database name "'.$this->name.'"');
				else if(preg_match('/\bUnknown .* server host\b/i', $msg))
					$this->addError('host','Unknown host name "'.$this->host.'"');
				else if(preg_match('/\bAccess denied for user\b/i', $msg)) {
					$this->addError('username', 'Username and password combination is incorrect');
					$this->addError('password', 'Username and password combination is incorrect');
				} else
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
			'host' => 'Host',
			'name' => 'Database Name',
			'username' => 'Username',
			'password' => 'Password',
			'tablePrefix' => 'Table Prefix',
			'admin_name' => 'Name',
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
		
		$this->host = str_replace('mysql:host=', '', $dbstring[0]);
		$this->name = str_replace('dbname=', '', $dbstring[1]);
		$this->username = $db['username'];
		$this->password = $db['password'];
		$this->tablePrefix = $db['tablePrefix'];
		
		$this->sitename = $local['name'];
		$this->timezone = $local['timezone'];
		
	}
	
	
	/**
	 * Generates a config array from the model properties.
	 * @return array compatible with yii config to save as applications local config settings
	 */
	public function generateConfig(){
		$config = array();
		$config['name'] = $this->sitename;
		$config['timezone'] = $this->timezone;

		$config['components']['db']['connectionString'] = 'mysql:host='.$this->host.';dbname='.$this->name;
		$config['components']['db']['username'] = $this->username;
		$config['components']['db']['password'] = $this->password;
		$config['components']['db']['tablePrefix'] = $this->tablePrefix;

		return $config;
	}
	
	/**
	 * generates the php string for the config file
	 * @return string 
	 */
	public function generateConfigPhp(){
		return '<?php ' . "\n" . 'return ' . var_export($this->generateConfig(), true) . ';';
	}
	
	/**
	 * save the config file 
	 * @return boolean true on success
	 */
	public function saveConfig(){
		// create local file contents
		$filename = $this->getConfigFile();
		$config = $this->generateConfig();
		if (is_writable(dirname($filename))) {
			file_put_contents($filename, $this->generateConfigPhp());
			return true;
		}
		return false;
	}
	

	public function installDatabase(){
		// the database details have already been added by the validation function.
		// install tables and nii modules
		Yii::app()->install();
	}
	
	
}
