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
		Yii::app()->getModule('admin')->menu->addDivider('secondary','Admin');
		Yii::app()->getModule('admin')->menu->addItem('secondary','Developer', array('/dev/admin/index'),'Admin',array(
			'visible' => Yii::app()->user->checkAccess('dev/admin/index'),
		));
	}
	
	public function permissions() {
		return array(
			'dev' => array('description' => 'Developer',
				'tasks' => array(
					'view' => array('description' => 'View Developer',
						'roles' => array('administrator'),
						'operations' => array(
							'dev/admin/index',
							'menu-admin',
						),
					),
				),
			),
		);
	}
	
	public function install(){
		$this->installPermissions();
	}
}