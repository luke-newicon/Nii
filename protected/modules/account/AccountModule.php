<?php
/**
 * AccountModule class file.
 *
 * @author Robin Williams <robin.williams@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of AccountModule
 *
 * @author rob
 */


class AccountModule extends NWebModule
{
	
	public function  preinit() {
		if(Yii::app()->getModule('user') === null)
			throw new CException('User module is required');
		parent::preinit();
	}
	
}
