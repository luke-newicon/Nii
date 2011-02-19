<?php
/**
 * NApp class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
/**
 * Description of NApp
 *
 * @author steve
 */
class Nii extends CApplicationComponent
{
	public function init(){
		$exclude = array('gii');
		foreach(Yii::app()->getModules() as $module=>$v){
			if (in_array($module, $exclude)) continue;
			Yii::app()->getModule($module);
		}
	}

}