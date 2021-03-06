<?php
/**
 * Nii class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

defined('DS') or define('DS',DIRECTORY_SEPARATOR);

/**
 * Nii The Nii application class.  It extends the Yii class.
 * Yii::app() refers to this class.
 *
 * @author steve <steve@newicon.net>
 * @property 
 */
class Nii extends CWebApplication
{
	
	/**
	 * The string key used by the setting component to store the module config array
	 * @var string
	 */
	public $moduleSettingsKey = 'modules';
	
	/**
	 * the string category used by the settings module to store the module config array
	 * @var string 
	 */
	public $moduleSettingsCategory = 'config';
	
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
	 * stores the core module configuration
	 * @var array 
	 */
	private $_coreModules;
	
	/**
	 * run the application
	 */
	public function run(){
		
		// for firephp
		ob_start();
		// turn off FB logging when we are in production mode
		if(!YII_DEBUG){
			FB::setEnabled(false);
		}
		
		$this->checkInstalled();
		
		if($this->domain)
			$this->setupDomainMultisite();
	
		// Loads database settings to override config
		$this->setupApplication();
		
		// initialise modules
		$this->setupModules();
	
		// run the application (process the request)
		parent::run();
		
	}
		
	/**
	 * This function applies database settings to override config
	 */
	public function setupApplication(){
		$this->configure(Yii::app()->settings->get('application','config'));
	}
	
	public function checkInstalled(){
		$i = new InstallForm();
		if(!$i->isDbInstalled($e) || !$i->isUserInstalled()){
			$this->goToInstall();
		}
	}
	
	/**
	 * Setup all nii modules. Runs the setup function of each modules.
	 * Core modules have their setup function executed first
	 * 
	 * @return void
	 */
	public function setupModules(){
		// Update the Yii::app()->modules configuration
		$this->configureModules();
		
		$this->initialiseModules();
		
		
		// setup each module 
		foreach($this->getModules() as $name => $config){
			if(!$this->isNiiModule($name)) continue;
			Yii::app()->getModule($name)->setup();
		}
		
		// raise the onAfterModulesSetup event.
		$this->onAfterModulesSetup(new CEvent($this));
		
	}
	
	/**
	 * Merges all modules into the Yii modules configuration array.
	 * This must be called before any subsequent calls to Yii::app()->getModules();
	 * 
	 * @see Nii::setupModules
	 * @return void
	 */
	public function configureModules(){
		
		// The core modules are defined in the application config
		// before merging with the database modules
		$this->_coreModules = $this->getModules();
		// exclude modules (like gii) from the core modules
		foreach($this->getExcludeModules() as $k=>$module)
			unset($this->_coreModules[$module]);
		
		// enable all core modules, by default enabled is false so we must
		// explicitly set enabled to true for all core modules
		// update the core configuration to include the enabled property.
		foreach($this->_coreModules as $name=>$config){
			$enabled = array_key_exists('enabled', $this->_coreModules[$name]) ? $this->_coreModules[$name]['enabled'] : true;
			$this->_coreModules[$name]['enabled'] = $enabled;
		}
		
		// Steve, whats this doing?  seems to be configuring the modules twice as this has already been done by the application.
		// Steve: Lines 161 to 177 are building up to this pinicle moment. It adds the additional enabled=>true property to the core modules. Nii relies on this to return modules that are enabled.
		// Yii itself assumes core modules (defined in config) are enabled but does not update the modules configuration...
		// This ensures the enabled property is set. Alternatively, each module in the config file could just have it hard coded.
		// I could loop through and do getModule($name)->enabled = true, but this would initilaise the module and I don't want to do that as it is the reponsibility of the initialisation function
		// If you are interested check out line 260 of CModule.php and then the getNiiModules function
		// 
		// So either this code which I have modded a bit but still does the same thing. Or ensure we always define the 'enabled' property in the core config.php files
		$this->setModules($this->_coreModules);
		
		// Set database modules
		$activeModules = $this->getModulesDbConfig();
		if(!empty($activeModules))
			$this->setModules($activeModules);
	}

	/**
	 * gets all NWebModules in the app and returns them in an array,
	 * This initialises each module, it calls the getModule on each module thus instantiating each if they
	 * are not already, thus running each modules initialisation (init) method
	 * 
	 * @see Nii::setupModules
	 * @return void
	 */
	public function initialiseModules(){
		// load the modules. Loops through all modules core modules are first in the configuration array
		// and will therefore get initialised first
		try {
			foreach($this->getModules() as $name => $config) {
				
				if ($this->isNiiModule($name))
					Yii::app()->getModule($name);
				
			}
		} catch (Exception $e){
			Yii::app()->updateModule($name, 0);
			Yii::app()->user->setFlash('error',"Unable to load the '$name' module. ");
			if (YII_DEBUG){
				ob_start();
				Yii::app()->displayException($e);
				$errorHtml = ob_get_clean();
				$msg = '<strong>'.$e->getMessage().'</strong>';
				$msg .= ' <a class="label warning" href="#" onclick="jQuery(\'#exception-error-details\').toggle();return false;">Show Error Details</a>'."<div style=\"display:none;\" id=\"exception-error-details\">$errorHtml</div>";
				Yii::app()->user->setFlash('error-block-message', $msg);
			}
		}
	}
	
	/**
	 * return boolean true|false whether the module is a nii module
	 * @param string $name the module name key
	 */
	public function isNiiModule($name){
		return (!in_array($name, $this->getExcludeModules()) && Yii::app()->getModule($name) instanceof NWebModule);
	}
	
	/**
	 * Get all nii modules that are active
	 * @return array [moduleId] => moduble object
	 */
	public function getNiiModules(){
		$ret = array();
		foreach($this->getModules()  as $name => $config){
			if(!$this->isNiiModule($name)) continue;
			if ($config['enabled'] != true) continue;
			$ret[$name] = Yii::app()->getModule($name);
		}
		return $ret;
	}
	
	/**
	 * Determin if the module is a core module
	 * @name string $name module string id
	 * @return boolean
	 */
	public function isCoreModule($key){
		return array_key_exists($key, $this->getCoreModules());
	}
	
	/**
	 * retuns the core module configuration
	 * 
	 * @return array [moduleId]=>array modules config
	 */
	public function getCoreModules(){
		return $this->_coreModules;
	}
	
	/**
	 * returns an array of modules to exclude from initialisation and setup
	 * 
	 * @return array list of module id strings
	 */
	public function getExcludeModules(){
		return array('gii');
	}
		
	/**
	 * returns a list of all modules configuration including modules available for activation
	 * @return array
	 */
	public function getModulesDbConfig(){
		return Yii::app()->settings->get($this->moduleSettingsKey, $this->moduleSettingsCategory, array());
	}
	
	/**
	 * Gets all modules available for install / activation
	 * looks in the modules folder and finds all module class files.
	 * Each module is instantiated in an isolated environment. It's init and preInit function is not called
	 * and it is not attached to the application object
	 * 
	 * @return array ('moduleName'=>'module zombie object')
	 */
	public function getModulesAvailable(){
		$modFiles = CFileHelper::findFiles(Yii::getPathOfAlias('modules'),array('fileTypes'=>array('php'), 'level'=>1));
		$mods = array();
		foreach($modFiles as $m){
			$modName = basename($m);
			if (!strpos($modName, 'Module'))
				continue;
			$mod = str_replace('.php','',$modName);
			$modId = strtolower(str_replace('Module','', $mod));
			Yii::import("modules.$modId.$mod");
			
			// check if the module has a valid module class
			if(!@class_exists("$mod", true))
				throw new CException('Can not find the module class for the "'.$mod.'" module');
			
			$moduleObj = new $mod($modId, null, null, false);
			$mods[$modId] = $moduleObj;
		}
		return $mods;
	}
	

	/**
	 * function to activate a module.
	 * - This function get the module from the module id
	 * - Runs the installation
	 * - runs the setup
	 * this function enables the system to add additional functionality during module activation
	 * @param type $moduleId
	 * @return NWebModule 
	 */
	public function activateModule($moduleId){
		try {
			
			$m = Yii::app()->getModule($moduleId);
			$m->install();
			$m->setup();
			$this->flushAssets();
			return $m;
			
		} catch(Exception $e) {
			// error activating the module. e.g. may not exist!
			// this can be caused by deleting the module files before disabling
			$this->updateModule($moduleId);
			Yii::app()->user->setFlash('error', "Unable to load the '$moduleId' module ");
			if (YII_DEBUG)
				throw new CException($e->getMessage());
			if(Yii::app()->controller)
				Yii::app()->controller->redirect(array('/admin/modules/index'));
		}
	}
	
    /**
	 * Enables or disables a module
	 * 
	 * @param string $module the module id
	 * @param int $enabled 
	 */
	public function updateModule($module, $enabled=0){
		// get the current module settings
		$sysMods = Yii::app()->settings->get($this->moduleSettingsKey, $this->moduleSettingsCategory, array());
		// create the array format for the affected module
		$update = array(strtolower($module) => array('enabled'=>$enabled));
		// merge the update with the existing settings
		$sysMods = CMap::mergeArray($sysMods, $update);
		// save the settings back
		Yii::app()->settings->set($this->moduleSettingsKey, $sysMods, $this->moduleSettingsCategory);
		// update yii's module configuration
		Yii::app()->configure(array('modules'=>$sysMods));
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
		foreach($this->getModules() as $m => $config){
			$m = Yii::app()->getModule($m);
			if ($m instanceof NWebModule) {
				$m->install();
			}
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
		// need to loop through sub databases if on a multi site install
		if($this->domain){
			$doms = AppDomain::model()->findAll();
			foreach($doms as $d){
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
	 * Adds the necessary configurations to create a multiple site application.  
	 * Each separate sub domain will act as an isolated application. Sharing global user details.
	 */
	public function setupDomainMultisite(){
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
		// create a new application for the user on registratiion.
		UserModule::get()->onRegistrationComplete = array($this, 'registrationComplete');
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
	
	/**
	 * get the subdomin
	 * @return string 
	 */
	public function getSubDomain(){
		return $this->_subDomain;
	}
	
	/**
	 * set the subdomin
	 * @param string $subdomain
	 * @return void 
	 */
	public function setSubDomain($subdomain){
		$this->_subDomain = $subdomain;
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
	
	/**
	 * Adds a new database component to Nii specific to the current domain application instance
	 * and returns the resulting CDbConnection.
	 *  
	 * @param string $dbName the database name
	 * @return CDbConnection 
	 */
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
	}
	
	/**
	 * Event called after nii has called the setup function of each module
	 */
	public function onAfterModulesSetup($event){
		$this->raiseEvent('onAfterModulesSetup', $event);
	}
	
	/**
	 * Clear all the assets from the assets folder
	 */
	public static function flushAssets(){
		$ignore = array(Yii::app()->getAssetManager()->basePath.'/.gitignore');
		NFileHelper::deleteFilesRecursive(Yii::app()->getAssetManager()->basePath,$ignore);
	}
	
	
}