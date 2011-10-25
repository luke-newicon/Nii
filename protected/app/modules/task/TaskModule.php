<?php
/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link https://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
class TaskModule extends NWebModule
{

	
//	public $settingsPage = array('/test/settings');
	public $name = 'Tasks';
	public $description = 'Task management module';
	public $version = '0.0.1';
	
	public function init(){
		// register menu items
		// Yii::app()->getModule('admin')->registerMenuItem('Tasks');
	}
	
	public function settings(){
		return array(
			'id' => array('type' => 'text'),
		);
	}
	
	public function install(){
		NActiveRecord::install('TaskTask');
	}
	
	public function uninstall(){
		NActiveRecord::uninstall('TaskTask');
	}
	
	

}