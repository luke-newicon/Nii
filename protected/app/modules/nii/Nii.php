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
	 * This activates each module, it calls the getModule on each module thus instantiating each if they
	 * are not already, thus running each modules initialisation (init) method
	 * 
	 * @param array $exclude modules to exclude from the returned array
	 * @return array 'module name'=>$module object
	 */
	public function getNiiModules($exclude=array()){
		$exclude = array_merge(array('gii'), $exclude);
		$retModules = array();
		
		
		// first load nii
		Yii::app()->getModule('nii');
		
		// get core modules
		$modules = Yii::app()->getModules();
		
		// add active modules
		if(($activeMods = Yii::app()->settings->get('system_modules', 'system', array())) !== null){
			// add the active modules to the configuration
			$this->configure(array('modules'=>$activeMods));
			$modules = CMap::mergeArray($modules, $activeMods);
			
		}
		
		// load the modules
		foreach($modules as $name => $config){
			if (in_array($name, $exclude)) continue;
			// initialises each module
			$module = Yii::app()->activateModule($name);
			if($module instanceOf NWebModule)
				$retModules[$name] = $module;
		}
				
		return $retModules;
	}
	
	
	/**
	 * Gets all modules available for install / activation
	 * looks in the modules folder and finds all module class files.
	 * Each module is instantiated in an isolated environment. It's init and preInit function is not called
	 * and it is not attached to the application object
	 * 
	 * @return array ('moduleName'=>'module zombie object')
	 */
	public function getNiiModulesAll(){
		$modFiles = CFileHelper::findFiles(Yii::getPathOfAlias('modules'),array('fileTypes'=>array('php'), 'level'=>1));
		$mods = array();
		foreach($modFiles as $m){
			$modName = basename($m);
			if (!strpos($modName, 'Module'))
				continue;
			$mod = str_replace('.php','',$modName);
			$modId = strtolower(str_replace('Module','', $mod));
			Yii::import("modules.$modId.$mod");
			$moduleObj = new $mod($modId, null, null, false);
			$mods[$modId] = $moduleObj;
		}
		return $mods;
	}
	
	
	/**
	 * function to activate a module.
	 * this function enables the system to add additional functionality during module activation
	 * @param type $moduleId
	 * @return type 
	 */
	public function activateModule($moduleId){
		$m = Yii::app()->getModule($moduleId);
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
		Yii::app()->cache->flush();
		foreach($this->getNiiModules() as $m){
			FB::log(get_class($m));
			$m->install();
		}
		Yii::app()->cache->flush();
	}
	
	/**
	 * install all loops through each registered database and runs the install of each module against it.
	 * This is useful for multi site subdomain systems
	 */
	public function installAll(){
		NAppRecord::$db = null;
		$this->install();
		FB::log('finished main install');
		// need to loop through sub databases if on a multi site install
		if($this->domain){
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
	
	
	/**
	 * returns the name of the database used on this specific sub domain
	 * used for multisite applications
	 * @return string the database name 
	 */
	public function getDomainDbName(){
		$subdomain = $this->getSubDomain();
		return $this->domainDbPrefix.$subdomain;
	}
	
	/**
	 * get the database connection object specific to this subdomain
	 * returns the main database connection if there is no subdomain
	 * 
	 * @return CDbConnection 
	 */
	public function getSubDomainDb(){
		// if there is no subdomain return the main database
		if($this->getSubDomain() == ''){
			$db = Yii::app()->getDb();
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
	
	/**
	 * function called when the system needs to be installed 
	 * this must be called instead of the run function
	 */
	public function goToInstall() {
		$route = explode('/',Yii::app()->getUrlManager()->parseUrl($this->getRequest()));
		if ($route[0] != 'install') {
			$this->catchAllRequest = array('install');
		}
		$this->run();
	}	
	
}