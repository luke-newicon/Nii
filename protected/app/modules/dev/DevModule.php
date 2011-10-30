<?php
/**
 * DevModule class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 * 
 */

/**
 * Description of DevModule
 *
 * @author steve
 */
class DevModule extends NWebModule
{
	public $name = 'Developer';
	
	public function init() {
		Yii::app()->getModule('admin')->menu->addItem('secondary','Developer', array('/dev/admin/index'),'Admin');
	}
}