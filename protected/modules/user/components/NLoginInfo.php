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
