<?php
/**
 * NApp class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NApp
 *
 * @author steve
 */
class Nii extends CWebApplication
{
	
	private $_subDomain;
	
	public function run(){

		// set up application context using the subdomain
		$host = Yii::app()->request->getHostInfo();
		// define the hostname!
		$domain = 'local.ape-project.org';
		$subdomain = trim(str_replace(array('http://',$domain),'',$host),'.');
		//echo $subdomain;
		//echo $subdomain;
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
			}
		}
		
		// initialise modules
		$this->getNiiModules();
		
		$this->install();
		// add event to do extra processing when a user signs up.
		// change this to on activation... we only want to create new databases for real users
		UserModule::get()->onRegistrationComplete = array($this, 'registrationComplete');
		
		// run the application (process the request)
		parent::run();
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
			if($m instanceOf NWebModule)
				$m[] = $module;
		}
		return $m;
	}
	
	
	public function install(){
		foreach($this->getNiiModules() as $m)
			$m->install();
	}
	
	/**
	 * handles user onRegistrationComplete event
	 * @param type $event 
	 */
	public function registrationComplete($event){
		$this->createApp($event->params['user']->domain);
	}
	
	public function createApp($subdomain, $dbPrefix='spanner_'){
		
		// install new database with the name of the subdomain .. like spanner_subdomain
		$sql = "CREATE DATABASE `$dbPrefix$subdomain`";
		$cmd = Yii::app()->db->createCommand($sql);
		$cmd->execute();
		
		// install the tables and run each modules install
		$db = Yii::app()->getMyDb($subdomain);
		$db->createCommand()->createTable('test', array(
			'id'=>'pk',
			'test'=>'string'
		));
		
	}
	
	public function getSubDomain(){
		return $this->_subDomain;
	}
	
	public function setSubDomain($subdomain){
		$this->_subDomain = $subdomain;
	}
	
	/**
	 * get the database specific to this subdomain
	 * 
	 * @param string $subdomain
	 * @return CDbConnection 
	 */
	public function getMyDb($subdomain=null){
		$subdomain = ($subdomain===null) ? $this->getSubDomain() : $subdomain ;
		if(!$this->hasComponent("{$subdomain}_db")) {
			$this->components = array("{$subdomain}_db"=>array(
				'class' => 'CDbConnection',
				'connectionString' => "mysql:host=localhost;dbname=spanner_{$subdomain}",
				'emulatePrepare' => true,
				'username' => 'newicon',
				'password' => 'bonsan',
				'charset' => 'utf8',
				'tablePrefix' =>'',
				//'schemaCachingDuration' => 3600,
				'enableProfiling'=>true,
				'enableParamLogging'=>true,
			));
		}
		$component = "{$subdomain}_db";
		return $this->$component;
	}
	
}