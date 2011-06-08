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
		// register nii js goodness#
		$this->registerScripts();
		//Yii::import('nii.widgets.*');
	}
	
	public function registerScripts(){
		$cs = Yii::app()->getClientScript();
		Yii::app()->getClientScript()->registerCoreScript("jquery.ui");
		$cs->registerScriptFile($this->getAssetsUrl().'/js/jquery.metadata.js');
		$cs->registerScriptFile($this->getAssetsUrl().'/js/tipsy/javascripts/jquery.tipsy.js');
		$cs->registerCssFile($this->getAssetsUrl().'/oocss/all.css');
		$cs->registerCssFile($this->getAssetsUrl().'/js/tipsy/stylesheets/tipsy.css');
		$cs->registerScriptFile($this->getAssetsUrl().'/js/nii.js');
	}
	
	/**
	 * return array of the scripts not to include from ajax
	 * note: these will likely mirror the scripts registered on every page load by
	 * NiiModule::registerScripts
	 */
	public function ajaxScriptMap(){
		return array (
			'jquery.js'=>false,
			'jquery-ui.css'=>false,
			'jquery.tipsy.js'=>false,
			'jquery.tipsy.css'=>false,
			'jquery.metadata.js'=>false,
			'nii.js'=>false,
		);
	}
	
	public function install(){
		Yii::import('nii.widgets.notes.models.NNote');
		NNote::install();
	}
	
	/**
	 * shortcut method to return the Nii module
	 * @return NiiModule 
	 */
	public static function get(){
		return yii::app()->getModule('nii'); 
	}
	
}
