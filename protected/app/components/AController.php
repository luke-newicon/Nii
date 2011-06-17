<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * Implements a default Deny behaviour
 */
class AController extends NController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/admin';

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