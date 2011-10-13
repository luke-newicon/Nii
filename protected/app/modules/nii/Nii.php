<?php
/**
 * NApp class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

defined('DS') or define('DS',DIRECTORY_SEPARATOR);

/**
 * Nii 
 *
 * @author steve <steve@newicon.net>
 */
class Nii extends CWebApplication
{
	
	/**
	 * enable this app to support multiple subdomain instances
	 * @var type 
	 */
	public $domain = false;
	
	/**
	 * An array of subdomains that are not allowed
	 * in the format of array(
	 *    0 => 'hotspot',
	 *    1 => 'naughty_domain'
	 * )
	 * @var array
	 */
	public $bannedSubDomains=array();

	/**
	 * the website url host that the app is running on,
	 * this enables the app to determin the subdomain acurately
	 * @var string 
	 */
	public $hostname = 'local.newicon.org';
	
	/**
	 * the database options for the subdomain specific database component
	 * @see CDbConnection
	 * 
	 * @var array 
	 */
	public $domainDb = array(
		'username'=>'root',
		'password'=>'',
		'enableProfiling'=>false,
		'enableParamLogging'=>false,
	);
	
	/**
	 * the spcific user database hostname only applicable for Mysql,
	 * enables user dtabases to be hosted on other servers.
	 * @var string
	 */
	public $domainDbHostname = 'localhost';
	
	/**
	 * prefix of the the new subdomain databases
	 * @var string 
	 */
	public $domainDbPrefix = 'nii_';
	
	/**
	 * the subdomain the application is currently running under
	 * @var string
	 */
	private $_subDomain;
	
	/**
	 * run the application
	 */
	public function run(){
		
		// for firephp
		ob_start();
		
		if($this->domain){
			
			// set up application context using the subdomain
			$host = Yii::app()->request->getHostInfo();
			// define the hostname!
			$schema = Yii::app()->request->getIsSecureConnection() ? 'https://' : 'http://';
			$subdomain = trim(str_replace(array($schema, $this->hostname),'',$host),'.');
			
			// redirect if www.
			if($subdomain=='www')
				Yii::app()->request->redirect(str_replace('www.','',$host).Yii::app()->request->getUrl(), true, 301);

			if($subdomain==''){
				$this->defaultController = 'site';
			} else {
				//check domain
				$dom = AppDomain::model()->findByPk($subdomain);
				if($dom === null){
					$this->catchAllRequest = array('error');
				}else{
					$this->setSubDomain($dom->domain);
					$this->defaultController = 'app';
					$this->configSubDomain();
				}
			}
		}
		
		
		
		// initialise modules
		$this->getNiiModules();

		// add event to do extra processing when a user signs up.
		// change this to on activation... we only want to create new databases for real users
		UserModule::get()->onRegistrationComplete = array($this, 'registrationComplete');
		// run the application (process the request)
		parent::run();
	}
	
	
	
	
	/**
	 * This is run when a subdomain is initialised.
	 * changes file paths etc to make specific to the subdomain environment
	 */
	public function configSubDomain(){
		// to prevent cache affecting other subdomains lets create a specific runtime folder for each subdomain
		$runtime = Yii::getPathOfAlias('app.runtime').DS.$this->getSubDomain();
		if(!file_exists($runtime)){
			mkdir($runtime);
		}
		$this->runtimePath = $runtime;
	}
	
	/**
	 * gets all NWebModules in the app and returns them in an array,
	 * Actively calls the getModule on each module thus instantiating each if they
	 * are not already, thus running each modules initialisation (init) method
	 * 
	 * @param array $exclude modules to exclude from the returned array
	 * @return array 
	 */
	public function getNiiModules($exclude=array()){
		$exclude = array_merge(array('gii'), $exclude);
		$m = array();
		foreach(Yii::app()->getModules() as $module=>$v){
			if (in_array($module, $exclude)) continue;
			$module = Yii::app()->getModule($module);
			if($module instanceOf NWebModule)
				$m[] = $module;
		}
		return $m;
	}
	
	
	/**
	 * install all active modules
	 * invokes the install function on all active NWebModule modules
	 * 
	 * In the event with multiple databases, the install will attempt to update all databases that exist.
	 * It runs each modules install function again each registered database
	 * 
	 * @return void
	 */
	public function install(){
		// only install for the main database
		foreach($this->getNiiModules() as $m){
			FB::log(get_class($m));
			$m->install();
		}
	}
	
	/**
	 * install all loops through each registered database and runs the install of each module against it.
	 */
	public function installAll(){
		NAppRecord::$db = null;
		$this->install();
		FB::log('finished main install');
		// need to loop through databases
		$doms = AppDomain::model()->findAll();
		foreach($doms as $d){
			FB::log('install '.$this->domainDbPrefix.$d->domain);
			// get the specific database for this domain
			$db = $this->domainDbPrefix.$d->domain;
			NAppRecord::$db = $this->_getDb($db);
			foreach($this->getNiiModules() as $m){
				$m->install();
			}
		}
	}
	
	/**
	 * handles user onRegistrationComplete event
	 * delegates to create App
	 * @param type $event 
	 */
	public function registrationComplete($event){
		if ($this->domain)
			$this->createApp($event->params['user']->domain);
	}
	
	/**
	 * installs a new application database for the specific subdomain
	 * It then runs each modules install against the new databse
	 * 
	 * @param string $subdomain 
	 */
	public function createApp($subdomain){
		$this->subDomain = $subdomain;
		$dbName = $this->getDomainDbName();
		// install new database with the name of the subdomain .. like spanner_subdomain
		$sql = "CREATE DATABASE `$dbName`";
		$cmd = Yii::app()->getDb()->createCommand($sql);
		$cmd->execute();
		
		// install the tables and run each modules install
		$this->install();
	}
	
	public function getSubDomain(){
		return $this->_subDomain;
	}
	
	public function setSubDomain($subdomain){
		$this->_subDomain = $subdomain;
	}
	
	
	public function getDomainDbName(){
		$subdomain = $this->getSubDomain();
		FB::log($this->domainDbPrefix.$subdomain, 'get domain db name');
		return $this->domainDbPrefix.$subdomain;
	}
	
	/**
	 * get the database specific to this subdomain, or the database specified by
	 * $dbName
	 * 
	 * @param string $dbName
	 * @return CDbConnection 
	 */
	public function getSubDomainDb(){
		// if there is no subdomain return the main database
		if($this->getSubDomain() == ''){
			$db = Yii::app()->getDb();
			FB::log($db, 'db');
			return $db;
		}
		// get the database name secific to the current subdomain
		$dbName = $this->getDomainDbName();
		
		return $this->_getDb($dbName);
	}
	
	
	protected function _getDb($dbName){
		if(!$this->hasComponent("{$dbName}_db")) {
			$a = array(
				'class' => 'CDbConnection',
				'connectionString' => "mysql:host={$this->domainDbHostname};dbname={$dbName}",
				'emulatePrepare' => true,
				'charset' => 'utf8',
				'tablePrefix' =>'',
			);
			// properties in array $a will overwrite any *silly* properties in $this->dbOptions
			$this->domainDb = array_merge($this->domainDb, $a);
			$this->components = array("{$dbName}_db"=>$this->domainDb);
		}
		$component = "{$dbName}_db";
		return $this->$component;
	}
	
	public function goToInstall() {
		$route = explode('/',Yii::app()->getUrlManager()->parseUrl($this->getRequest()));
		if ($route[0] != 'install') {
			$this->catchAllRequest = array('install');
		}
		$this->run();
	}	
	
}