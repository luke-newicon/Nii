<?php

/**
 * UserLoginInfo class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of UserLoginInfo
 * This should display information for the currently logged in user
 * NOTE: most of the information we wish to display will be stored in the associated CRM contact module.
 * However we do not want the user module to depend on the Crm module in case it is not installed.
 * Therefore first we must check for the existence of the CRM module and if it does not exist fall back to a more basic view.
 *
 * @author steve
 */
class NLoginInfo extends CWidget 
{

	public $size = 25;
	
	public function run()
	{
		$contact = Yii::app()->user->contact;
		$this->render('login-info',array('user'=>Yii::app()->user,'contact'=>$contact));
	}
}
