<?php

/**
 * ApiController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ApiController
 *
 * @author steve
 */
class ApiController extends RestController
{
	/**
	 * called from post: api/project
	 */
	public function actionCreateProject()
	{
		$api = new ProjectApi();
		$api->createProject($_POST);
	}
	
	
	
	
	
}