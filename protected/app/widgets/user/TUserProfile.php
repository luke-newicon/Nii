<?php

/**
 * TUserProfile class file.
 *
 * @author Robin Williams <robin.williams@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of TUserProfile
 * This should display profile information for the currently logged in user
 * NOTE: most of the information we wish to display will be stored in the related contact model.
 *
 * @author steve
 */
class TUserProfile extends CWidget 
{

	public $size = 25;
	
	public function run()
	{
//		$contact = User::getUserProfile();
//		$this->render('userProfileMenu',array('user'=>Yii::app()->user,'contact'=>$contact));
	}
}
