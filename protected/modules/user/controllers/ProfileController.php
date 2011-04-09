<?php
/**
 * ProfileController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ProfileController
 *
 * @author steve
 */
class ProfileController extends AController
{

    public function actionIndex(){
		// get the contact profile record.  
		// For profiles to be enabled you have to have the crm module installed. 
		$this->render('/profile/index',array('contact'=>Yii::app()->user->contact));
	}
}