<?php

/**
 * NAController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * This class should be extended by controllers that reate admin areas
 * By default all un authenticated (not logged in) users are rejected
 *
 * @author steve
 */
class NAController extends NController {

	/**
	 * This rule prevents all actions on controllers
	 * from unauthenticated users unless explicitly set 
	 * @return array 
	 */
	public function accessRules() {
		return array(
			array('deny',
				'users' => array('?'),
			),
		);
	}

}