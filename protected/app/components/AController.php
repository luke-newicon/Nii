<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * Implements a default Deny behaviour
 */
class AController extends NController {

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/admin1column';

	public function init() {
		Yii::app()->errorHandler->errorAction = 'admin/index/error';
		
		$this->menu = array(
			'admin' => array('label' => 'Admin', 'url' => array('/admin'), 'active'=>($this->parentActive('admin/index')||$this->parentActive('admin/settings')||$this->parentActive('admin/modules')),
				'items' => array(
					'modules' => array('label' => 'Modules', 'url' => array('/admin/modules/index')),
					'settings' => array('label' => 'Settings', 'url' => array('/admin/settings/index')),
				),
			),
		);
	}
	
	
	public function active(){
		
	}
	
	public function parentActive($controller) {
		if ($controller == Yii::app()->controller->uniqueid) 
			return true;
	}

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