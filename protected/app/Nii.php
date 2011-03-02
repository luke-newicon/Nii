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

	
	public function run(){

		// set up application context using the subdomain
		$host = Yii::app()->request->getHostInfo();
		$domain = 'newicon.org';
		$subdomain = trim(str_replace(array('http://',$domain),'',$host),'.');
		//echo $subdomain;
		
		// initialise modules
		$exclude = array('gii');
		foreach(Yii::app()->getModules() as $module=>$v){
			if (in_array($module, $exclude)) continue;
			Yii::app()->getModule($module);
		}
		// run the application (process the request)
		parent::run();
	}
	
	public function install(){
		$auth = Yii::app()->authManager;
		$auth->createRole('authenticated', 'authenticated user', 'return !Yii::app()->user->isGuest;');
		$auth->createRole('guest', 'guest user', 'return Yii::app()->user->isGuest;');
	}
}