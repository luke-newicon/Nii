<?php
/**
 * Yii-User module
 * 
 * @author Mikhail Mangushev <mishamx@gmail.com> 
 * @link http://yii-user.googlecode.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: UserModule.php 105 2011-02-16 13:05:56Z mishamx $
 */

class NiiModule extends NWebModule
{
	public function init(){
		// register nii js goodness
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($this->getAssetsUrl().'/js/tipsy/jquery.tipsy.js');
		$cs->registerCssFile($this->getAssetsUrl().'/js/tipsy/css/tipsy.css');
		$cs->registerScriptFile($this->getAssetsUrl().'/js/nii.js');
	}
}
