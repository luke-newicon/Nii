<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of AppController
 *
 * @author steve
 */
class AppController extends Controller
{
	public $layout = '//layouts/admin';
	
	
	public function accessRules() {
		return array(
			array('deny',
				'users' => array('?')
			),
		);
	}
	
	public function actionIndex(){
		$this->render('index');
	}
	
	public function actionCreateApp($subdomain){
		
		Yii::app()->createApp($subdomain);
		
	}
	
}
