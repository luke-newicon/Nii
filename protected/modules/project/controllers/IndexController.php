<?php

/**
 * IndexCrontroller class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of IndexCrontroller
 *
 * @author steve
 */
class IndexController extends AController
{ 
	//put your code here
	public function actionIndex(){
		Project::install();
		$this->render('index');
	}
	
	public function actionInstall(){
		ProjectModule::get()->install();
	}
}