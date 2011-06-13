<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class NAController extends NController
{
	
	public function accessRules() {
		return array(
			'deny'=>array(
				'users'=>'?'
			)
		);
	}
	
}