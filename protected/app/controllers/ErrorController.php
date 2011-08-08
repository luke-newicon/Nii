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
 * Description of ErrorController
 *
 * @author steve
 */
class ErrorController extends Controller 
{
	public $layout = '//layouts/login';
	/**
	 * This error is called by nii if the subdomain is not recognised
	 */
	public function actionIndex(){
		$this->render('index');
	}
}
